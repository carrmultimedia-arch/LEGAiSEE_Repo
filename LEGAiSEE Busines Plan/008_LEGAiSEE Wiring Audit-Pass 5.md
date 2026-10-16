## 1. Cases Module Reads JSON Instead of MySQL

**Source:** `modules/cases_module.php` [Inspect Cases module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/cases_module.php)

The module loads its case and client collections using:

```php
$cases   = load_json_dir(__DIR__ . '/../data/cases');
$clients = load_json_dir(__DIR__ . '/../data/clients');
```

It then builds a client index from the JSON client records and associates each displayed case with a client through `client_id`.

The shared helper, `modules/utils/bootstrap.php`, scans a directory for `.json` files, decodes them, and returns the resulting arrays.

**Finding:** The registered Cases module's displayed case list is filesystem-driven. It does not query the MySQL `cases` or `clients` tables in the inspected implementation.

By contrast, the Clients module queries MySQL's `clients` table, and Client View queries MySQL for clients, cases, payments, and review flags.

Sources:

* [Cases module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/cases_module.php)
* [JSON-loading helper](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/utils/bootstrap.php)
* [Clients module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/clients_module.php)
* [Client View module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/client_view_module.php)

### WIR-032 — Cases and Clients use different data sources

**Severity: High integration concern**

The current code establishes two paths:

```text
Cases module
    └── data/cases/*.json
        └── data/clients/*.json

Clients module
    └── MySQL clients

Client View
    ├── MySQL clients
    ├── MySQL cases
    ├── MySQL payments
    └── MySQL review_flags
```

If the JSON files and MySQL tables are not kept synchronized, the Cases module can display a different collection of cases or clients from the rest of the system.

That is particularly relevant to your earlier point that JSON was previously used as a database and that the system later moved toward MySQL.

**What is established:** The Cases module reads JSON; the Clients module and Client View read MySQL.

**What is not established:** Whether the JSON files are obsolete, intentionally retained as a separate view, or still maintained by another process. That requires tracing the writers before deciding which source should be authoritative.

**Audit disposition:** Confirm the intended source of truth before changing the Cases module.

---

## 2. Client View Uses MySQL, but Selects Only One Case

**Source:** `modules/client_view_module.php` [Inspect Client View](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/client_view_module.php)

The client-view function queries the client by ID and then retrieves a single case:

```sql
SELECT *
FROM cases
WHERE client_id = ?
ORDER BY created_at DESC
LIMIT 1
```

It also retrieves all payments for that client, but its primary case context is the most recently created case.

### WIR-033 — Client View presents a multi-case client through a single-case context

The same function retrieves payment history by `client_id`, while its report lookup uses the selected case's ID to construct a filesystem path.

This creates an important distinction:

* Payment history is client-scoped.
* The selected case is whichever matching case is newest.
* The report lookup is scoped to that selected case.
* The confirmed findings query is scoped to client context, not visibly to the selected case.

**Impact:** If a client has multiple cases, the displayed case and report can represent one case while the findings shown in Client View may include confirmed review flags associated with the client more broadly.

This is consistent with the case-scoping problem previously identified in the report module.

It does not establish that every multi-case client currently has incorrect results. It establishes that the inspected query structure does not enforce a consistent case scope across those components.

---

## 3. Review Findings Are Resolved Through Relationship Columns With Inconsistent Semantics

Client View resolves relationship findings using:

```sql
LEFT JOIN entities e1 ON e1.id = r.from_entity
LEFT JOIN entities e2 ON e2.id = r.to_entity
```

The previously inspected entity-extraction engine writes entity names into `from_entity` and `to_entity`, while also storing separate ID fields named `from_entity_id` and `to_entity_id`.

Sources:

* [Client View module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/client_view_module.php)
* [Entity extraction engine](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/engine/entity_extraction_engine.php)

### WIR-034 — The relationship-column mismatch affects more than Dig Review

This extends the earlier WIR-014 finding.

The issue is not limited to one screen: both Dig Review and Client View use `from_entity` and `to_entity` as entity IDs in their joins, while the extraction code was observed writing entity names into those fields.

If that implementation is active in the live system, relationship labels can fail to resolve correctly.

**Required verification:** Inspect the actual MySQL `relationships` table definition and live records. Confirm the intended meaning and data type of each endpoint column before deciding whether the defect is in extraction, the consumer queries, or both.

---

## 4. Client View and Payment Module Are Connected, but the Initial Checkout Route Is Not Demonstrated as the Active Path

**Sources:**

* [Client View](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/client_view_module.php)
* [Payment module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/payment_module.php)

Client View displays pending payments and offers a **Generate Pay Link** button.

That button sends a POST request to:

`?module=payment&action=create_checkout_from_pending`

Its payload contains the existing payment ID and a client email entered through a prompt.

The payment module's corresponding handler retrieves the payment by ID, requires the payment status to be `pending`, and creates a new Stripe Checkout Session using the amount and currency already stored in that payment record.

### WIR-035 — The visible payment interface uses the pending-payment route

This establishes a direct connection:

```text
Client View
    └── Generate Pay Link
          └── create_checkout_from_pending
                ├── Read pending MySQL payment
                ├── Create Stripe Checkout Session
                └── Update stored session ID
```

The initial `create_checkout` handler is a separate path that creates a new payment record and a Checkout Session. The inspected Client View button does not call that handler.

**Impact:** The initial checkout handler may be intended for another caller, but its use by the visible Client View interface has not been demonstrated.

This is not proof that the initial route is orphaned. It is an unresolved integration question: identify every caller before classifying that route as active or unused.

### WIR-036 — The pay-link interface asks for an email, but the payment handler does not use it to select the notification recipient

Client View prompts the operator to enter an email address and sends it to `create_checkout_from_pending`.

The payment module validates that the email is present, but the visible handler does not persist it in the payment record or pass it into the Stripe Checkout Session's customer-email field.

The webhook notification function instead reads the client's email from:

`data/clients/{client_id}/profile.json`

**Impact:** The operator-entered email does not control the notification destination in the inspected flow. The profile JSON remains the source used for the client receipt.

This reinforces WIR-023 from Pass 4 and the broader finding that client contact data is split between MySQL and filesystem JSON.

---

## 5. The Database Schema Is Still Unverified

The next step originally called for inspecting database migrations and table definitions. I attempted to locate likely schema files, including common migration and schema paths, but those guessed paths returned no file. That does **not** establish that the repository contains no schema definitions or migrations.

The source files inspected so far demonstrate queries against these tables:

| Table | Observed use |
| --- | --- |
| `clients` | Client listing and client lookup |
| `cases` | Case lookup by client and recent-case selection |
| `payments` | Payment history, checkout, and payment status |
| `review_flags` | Confirmed findings |
| `entities` | Entity lookup and relationship resolution |
| `relationships` | Relationship lookup |
| `processing_queue` | Pending next action for a case |

The source code tells us which columns some modules expect, but it does not prove the complete schema, foreign keys, indexes, or constraints.

### WIR-037 — Application code assumes a schema whose complete definition has not been established

This is an **audit gap**, not a confirmed schema defect.

Until the table definitions are found, we cannot reliably determine whether:

* `cases.client_id` is a foreign key to `clients.id`.
* Payment references are constrained to valid clients and cases.
* Relationship endpoint columns store names or IDs in the live database.
* IDs use compatible types across tables.
* Foreign-key constraints prevent orphan records.
* Multiple modules are creating or modifying the same table differently.

The schema should be established from the actual database or its authoritative migration files—not reconstructed from assumptions.

---

## 6. Updated Ownership Map

Based on the code inspected to date, the system has the following observed structure:

```text
                         ┌─────────────────────────┐
                         │       MySQL             │
                         │                         │
                         │ clients                 │
                         │ cases                   │
                         │ payments                │
                         │ review_flags            │
                         │ entities                │
                         │ relationships            │
                         │ processing_queue        │
                         └────────────┬────────────┘
                                      │
                  ┌───────────────────┼────────────────────┐
                  │                   │                    │
                  ▼                   ▼                    ▼
             Clients module     Client View          Payment module
                                      │                    │
                                      │                    └── Stripe
                                      │
                                      ├── Report lookup
                                      │   through filesystem
                                      │
                                      └── Confirmed findings
                                          from review_flags

                         ┌─────────────────────────┐
                         │     Filesystem JSON     │
                         │                         │
                         │ data/cases/*.json       │
                         │ data/clients/*.json     │
                         │ profile.json files     │
                         │ case analysis outputs  │
                         └────────────┬────────────┘
                                      │
                                      ▼
                                Cases module
```

This diagram represents the observed access paths. It is not a claim that the two stores are completely disconnected or that every JSON file is legacy data.

---

## 7. Pass 5 Findings Summary

| ID | Finding | Severity / status |
| --- | --- | --- |
| WIR-032 | Cases module reads JSON while Clients and Client View read MySQL | High integration concern; authority unresolved |
| WIR-033 | Client View selects one case but loads confirmed findings by client context | Case-scoping defect pattern; confirm intended behavior |
| WIR-034 | Relationship endpoint semantics conflict across extraction and display queries | High; verify against live schema and records |
| WIR-035 | Visible pay-link button uses the pending-payment checkout route | Integration established; initial route caller unresolved |
| WIR-036 | Entered checkout email is not used by the visible notification path | Confirmed source-level mismatch |
| WIR-037 | Complete schema and constraints remain unverified | Audit gap |

### Pass 5 conclusion

The evidence now supports a more specific description of the integration problem:

1. **Client and case information has competing storage paths.** The registered Cases module reads JSON, while other major modules read MySQL.
2. **Case scope is not consistently propagated.** Client View selects a single case but loads confirmed findings using client context.
3. **Entity relationships have an unresolved data contract.** Extraction and display code disagree about the meaning of relationship endpoint columns.
4. **Payment functionality has multiple entry points.** The visible pay-link interface uses the existing-pending-payment route; the initial checkout route's active caller remains unknown.

The correct next move is not to convert every JSON file to MySQL or rewrite the affected modules. First, establish which records are canonical, trace all writers, and inspect the actual schema. Then the audit can distinguish legacy code from active functionality and identify the smallest changes needed to reconnect the system.