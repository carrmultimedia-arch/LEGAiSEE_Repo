## 1. Payment Module: Present, Registered, but Not Reliably Safe for Production

**Source:** `modules/payment_module.php` [Inspect payment module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/payment_module.php)

The payment module implements a recognizable Stripe Checkout flow:

1. Accept a client, case, report, email, and exhibit tier.
2. Determine the price from a hard-coded tier table.
3. Insert a pending payment into MySQL.
4. Create a Stripe Checkout Session.
5. Save the Stripe session ID.
6. Receive a webhook and mark the payment as paid.
7. Send payment notifications by email.

The module is also represented in the main `shell.php` navigation as the Payments module. This establishes a route to the module, but does not prove the entire transaction flow works.

### WIR-021 — Stripe webhook signature verification is disabled

**Severity: Critical before real payments**

The webhook handler contains the Stripe signature-verification call, but it is commented out. The code instead decodes the incoming JSON payload directly.

Consequently, the handler does not establish that a notification claiming a checkout succeeded actually came from Stripe.

The handler then looks up the payment by checkout-session ID and changes its status to `paid`.

**Impact:** If the endpoint is reachable and the required session ID is known or obtained, an unverified request could potentially trigger the paid-status path. The actual exploitability depends on deployment details, but the code does not provide the required authenticity check.

**Connection affected:** Stripe → payment module → MySQL payment record → email notifications.

### WIR-022 — Payment creation accepts client, case, and report identifiers without validating their relationship

The `create_checkout` handler accepts `client_id`, `case_id`, and `report_id` from the request. It checks that the fields are present and that the requested tier exists in the pricing table.

It does not visibly establish that:

* The client exists.
* The case exists.
* The case belongs to that client.
* The report exists.
* The report belongs to that case and client.
* The requester is authorized to initiate this transaction.

The code inserts the submitted identifiers into the `payments` table.

**Impact:** The payment record can be created without the application first establishing that its three principal references describe a valid, related business transaction.

This is a data-integrity and authorization concern. Whether MySQL rejects any particular invalid combination depends on the actual table constraints, which have not yet been verified.

### WIR-023 — The submitted client email is not persisted in the visible payment flow

The initial checkout handler accepts `client_email`, but the payment insert stores the client ID, case ID, report ID, amount, currency, status, and payment method. The submitted email is not included in that insert.

After payment, the notification function looks for the client's email and name in:

`data/clients/{client_id}/profile.json`

It does not use the email supplied to the initial checkout request.

**Impact:** The address entered during checkout and the address used for payment notification can differ. If the JSON profile is missing or has no email, the client notification is skipped.

This is another example of a mixed data model: transaction details are written to MySQL, while customer contact information is read from a filesystem JSON profile.

### WIR-024 — Payment confirmation can trigger duplicate notification work

When the webhook receives a `checkout.session.completed` event, it updates the matching payment to `paid` and calls `sendPaymentNotifications()`.

The visible handler does not first check whether that payment has already been processed. It also does not visibly record a Stripe event ID for deduplication.

Stripe webhook delivery can be retried. Therefore, duplicate deliveries could cause the notification function to run repeatedly.

**Impact:** A payment could produce duplicate emails or repeated notification side effects.

The `email_sent_client` and `email_sent_john` flags are updated after sending attempts, but the handler does not use those flags to prevent a repeat before sending.

### WIR-025 — Payment status is returned without visible authorization checks

The `status` action accepts a `payment_id`, retrieves the matching payment row, and returns the row in a JSON response.

No authentication or ownership check is visible in this handler.

**Impact:** If the endpoint is accessible without external access controls, someone who obtains a payment ID could retrieve payment details. The precise exposure depends on the surrounding authentication and server configuration, which this source inspection cannot establish.

A status endpoint should return only the fields the intended requester is permitted to see.

### WIR-026 — Checkout URLs use HTTP

Both checkout-creation paths construct their success URLs with:

`http://` + `$_SERVER['HTTP_HOST']`

The cancellation URL also uses HTTP.

**Impact:** This does not establish an HTTPS destination. If the site is intended to operate securely over HTTPS, the checkout URLs should be generated from a trusted, configured HTTPS base URL rather than relying on the incoming host header and hard-coded HTTP scheme.

This should be checked against the live deployment before any payment testing.

### WIR-027 — Failed checkout-session creation can leave pending payment records

The initial handler inserts a pending payment before attempting to create the Stripe Checkout Session.

If Stripe session creation fails, the exception handler returns an error but does not visibly remove or mark the pending payment record as failed.

That is not necessarily incorrect: retaining failed attempts can be useful for auditing. However, the system needs a defined policy for abandoned or failed attempts so that pending records are not mistaken for active checkout sessions.

The separate `create_checkout_from_pending` action can create another session for an existing pending payment. The visible code does not limit how often this can occur.

**Impact:** Multiple checkout attempts can be associated with a single pending payment unless another layer prevents them.

### WIR-028 — Payment tiers are hard-coded independently of the rest of the business model

The payment module defines eight prices, ranging from $500 to $250,000.

These values are used to determine the initial checkout amount. The module does not visibly retrieve tier definitions from a shared product, service, or pricing registry.

This is not automatically a defect: fixed prices can be intentional. The wiring question is whether these eight tiers are the authoritative commercial definitions used by the rest of LEGAiSEE.

If another module defines report tiers or pricing independently, the system risks divergent prices and terminology.

**Required verification:** Establish whether these eight tiers are the current intended product catalog or an older payment implementation.

---

## 2. Main Shell Integration

**Source:** `shell.php` [Inspect main shell](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/shell.php)

The main shell includes the payment module in its dashboard cards and sidebar. Its general module-rendering mechanism loads modules through the registry.

This establishes a visible navigation connection:

`Grand Lobby → Payments → payment module`

However, the payment module also handles JSON actions, Stripe callbacks, and webhook requests. Those functions are not the same as rendering the module's interface.

The source therefore demonstrates that the module is reachable through the shell, but not that every action is routed correctly, that authentication is consistently applied, or that Stripe can complete a real transaction.

The shell also has special early intercepts for report generation and vault downloads. No corresponding early payment intercept is visible in the inspected shell source. Payment actions appear to rely on the module's normal route.

**Audit conclusion:** Payment is integrated into the shell's navigation. End-to-end transaction integration remains unverified, with the webhook signature issue being the most important visible defect.

---

## 3. Database Relationship Map: What the Code Establishes

The current evidence supports the following partial map:

```text
CLIENT
  │
  ├── CASE
  │    │
  │    ├── FILES / ARTIFACTS
  │    │
  │    ├── ENTITY EXTRACTION
  │    │      ├── ENTITIES
  │    │      └── RELATIONSHIPS
  │    │
  │    ├── REVIEW FLAGS
  │    │
  │    └── REPORT PDF
  │
  ├── PROFILE JSON
  │
  └── PAYMENT
         ├── client_id
         ├── case_id
         ├── report_id
         ├── amount / currency / status
         ├── Stripe checkout-session ID
         └── Stripe payment-intent ID
```

This is a map of observed code-level relationships, not a verified database entity-relationship diagram. In particular, it does not establish which foreign keys exist or whether the database enforces these relationships.

### WIR-029 — Client and case information is split between MySQL and filesystem JSON

Several previously inspected modules use different sources for related information:

| Information | Observed source |
| --- | --- |
| Client and case lookups in report generation | MySQL `clients` and `cases` tables |
| Case discovery for report selection | Filesystem `meta.json` files |
| Client name and email for payment notifications | Filesystem `profile.json` |
| Payment transaction records | MySQL `payments` table |
| Review decisions | MySQL `review_flags` table |
| Several excavation and analysis findings | Filesystem JSON files |

The existence of two storage mechanisms is not itself a defect. JSON can legitimately hold artifacts, analysis outputs, cached views, or other structured files.

The concern is that some modules use JSON for information that other modules expect to retrieve from MySQL.

**Impact:** A client or case can potentially be visible to one module but missing or represented differently in another, depending on which store was updated.

**Important distinction:** We have not yet established that all JSON files are obsolete. The next audit step must distinguish legacy records from active file-based artifacts and outputs.

### WIR-030 — Entity and relationship records lack a consistently demonstrated case/artifact ownership chain

The entity-extraction engine accepts a client identifier, but the previously inspected insert paths do not visibly persist that identifier with the extracted entities and relationships. The artifact reference is used as an alias rather than establishing a clear foreign-key relationship to a canonical artifact record.

The engine creates entity relationships using both entity names and entity IDs. The Dig Review module, meanwhile, joins relationship endpoint columns as though they contain entity IDs.

That mismatch was documented in Pass 3 as WIR-014.

**Impact:** Even if entity extraction creates records successfully, downstream modules may not be able to reliably identify the originating client, case, or artifact—or resolve the relationship endpoints correctly.

This is a data-contract problem, not merely a missing user-interface feature.

### WIR-031 — The review queue and report-generation path are not yet proven to share a complete evidence chain

The Dig Review module queues entities and relationships for review. The report module subsequently selects confirmed review flags by client context, but the inspected query does not filter by the selected case.

The report then places the source table, source ID, and operator note into the PDF rather than visibly resolving each source into its underlying evidence.

Together, these behaviors leave gaps in the chain:

`Source artifact → extracted finding → review decision → case-specific report`

A record may be reviewable without being demonstrably tied to a specific source artifact, and a report may include confirmed findings without restricting them to the selected case.

**Impact:** A generated report may not reliably demonstrate which underlying evidence supports each conclusion or whether every finding belongs to the requested case.

This connects the earlier findings WIR-012 through WIR-017. These should be tracked together as an evidence-provenance and case-scoping problem.

---

## 4. What Is Established—and What Is Not

### Established by source inspection

* The payment module implements a Stripe Checkout flow.
* The payment module writes payment records to MySQL.
* The visible webhook path does not verify Stripe's signature.
* The visible payment handlers do not establish a complete client–case–report ownership check.
* Payment notification code reads client information from filesystem JSON.
* The entity-extraction and review modules have an identified relationship-column mismatch.
* Report generation and Vault use a mixture of MySQL records and filesystem discovery.
* The report query previously inspected does not scope confirmed findings by case.

### Not yet established

* The complete live MySQL schema, including foreign keys, indexes, and constraints.
* Whether authentication middleware or web-server rules protect payment endpoints.
* Whether the live server contains the same code as the public repository.
* Whether the Stripe account, webhook configuration, and production URLs are correctly configured.
* Which JSON files are still active system outputs and which are legacy records.
* Whether other modules provide validation or ownership checks not visible in the inspected paths.
* Whether actual payments, notifications, report downloads, and status checks succeed end to end.

These are open verification items, not confirmed failures.

---

## 5. Recommended Audit Order

Do not rebuild these modules yet. First establish the actual data model and the intended contracts.

1. **Inventory the database migrations and table definitions.** Establish the real columns, primary keys, foreign keys, and indexes for `clients`, `cases`, artifacts/documents, `entities`, `relationships`, `review_flags`, and `payments`.
2. **Trace client and case creation.** Identify which code creates canonical MySQL records and which code creates filesystem folders or JSON metadata.
3. **Trace artifact ownership.** Determine whether every ingested artifact can be traced to a canonical client, case, and source record.
4. **Trace entity and relationship persistence.** Establish the expected meaning of every relationship endpoint column and identify the canonical entity-extraction implementation.
5. **Trace review-to-report provenance.** Verify how a confirmed finding is linked to its source artifact and selected case.
6. **Trace the payment lifecycle.** Verify the payment schema, access controls, checkout creation, webhook verification, status reporting, and notification deduplication.
7. **Classify JSON files.** Mark each as active source data, active generated output, cache, migration residue, or confirmed legacy data only after examining its readers and writers.

### Pass 4 conclusion

The payment module is not simply missing: it has a recognizable checkout implementation and database writes. The main risks are in transaction verification, ownership validation, notification behavior, and consistency with the rest of the data model.

The broader issue is becoming clearer: LEGAiSEE has multiple components that perform meaningful work, but the contracts connecting their records are not consistently demonstrated. The next priority is to establish the canonical MySQL schema and trace the ownership of clients, cases, artifacts, extracted entities, reviews, reports, and payments before changing implementation.