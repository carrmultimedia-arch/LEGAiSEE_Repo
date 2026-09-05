LEGAiSEE Master System Law — Part II Build Spec
The Identity Layer (tree_nodes)
Status: OPEN — first build item, per Master System Law v1.0 build order. Prepared by: Claude (architect) for executor build. Governing doc: Master System Law v1.0, Part II.

1. Purpose
Replace three fragmented identity schemes — client_id/case_id (used by network_add_node.php), brain_id (used by the nine Brain pipeline files), and raw rows in prospect_ingests (MySQL, no shared key) — with a single universal node system. Every client, project, sub-project, and individual work item becomes one row in one table: tree_nodes. Everything else in the system attaches to node_id going forward. No new feature is permitted to invent its own identity scheme.

2. Schema
CREATE TABLE tree_nodes (
  node_id     INT UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id   INT UNSIGNED NULL,
  name        VARCHAR(255) NOT NULL,
  node_type   ENUM('client','project','subproject','item') NOT NULL,
  sort_order  INT NOT NULL DEFAULT 0,
  created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
              ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (node_id),
  KEY idx_parent (parent_id),
  CONSTRAINT fk_tree_nodes_parent
    FOREIGN KEY (parent_id) REFERENCES tree_nodes(node_id)
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

Notes:
parent_id NULL = top-level (client) node. No separate "clients" table — a client is just a node with no parent.
node_type informs UI rendering only. It never restricts how deep the tree can go — a node of any type can have children.
ON DELETE RESTRICT on the FK is a second line of defense under the app-level delete-block in §4.4 — the DB itself refuses to orphan children even if the API layer is bypassed.
sort_order preserves intentional ordering John enters (e.g. "1. Tour, 2. Interview, 3. Social") — never re-sort alphabetically in the UI.
Important environment constraint: this server runs MySQL 5.7 (Percona), which does not support recursive CTEs (WITH RECURSIVE requires MySQL 8.0+). get_tree (§4.5) must build the tree in PHP from a flat query, not via a recursive SQL query. Given LEGAiSEE's capped client volume, total node count will stay small (low thousands at most), so fetching the relevant rows in one query and assembling the tree in PHP is the correct approach — do not attempt a recursive-CTE workaround or per-level round-trip queries.

3. File Location & Access Pattern
New file: api/tree.php
Per Command Center Rule 4 (Part VII): this is a JSON endpoint, called directly — it must not route through shell.php.
Per Rule 2: all DB access goes through kernel_db() — no direct mysqli/PDO calls elsewhere in this file.
Action is selected via a single action POST parameter, matching the existing pattern used by network_add_node.php.
All responses: single JSON object, single echo, matching the single-read/single-write/single-echo fix already applied to network_add_node.php. No duplicate output.

4. Endpoints
All actions live in api/tree.php, dispatched on action.
4.1 create
Params: parent_id (int, nullable), name (string, required), node_type (enum, required), sort_order (int, optional).
Validation:
name non-empty, trimmed, max 255 chars.
node_type must be one of the four allowed values.
If parent_id given, it must exist in tree_nodes — else return an error, don't silently null it out.
If sort_order omitted, default to MAX(sort_order)+1 among siblings (same parent_id), or 0 if no siblings exist.
Response: the newly created node as a JSON object (node_id, parent_id, name, node_type, sort_order, created_at, updated_at).
4.2 rename
Params: node_id (required), name (required).
Validation: node_id must exist. name non-empty, max 255 chars.
Response: the updated node object.
4.3 move
Params: node_id (required), new_parent_id (nullable — null moves node to top level).
Validation:
node_id must exist.
If new_parent_id given, it must exist.
Circular-reference check (required): new_parent_id must not be node_id itself, and must not be a descendant of node_id. Walk up from new_parent_id toward the root, in PHP, checking each ancestor against node_id; reject with a clear error if a match is found before reaching a null parent.
Response: the updated node object.
4.4 delete
Params: node_id (required).
Validation:
node_id must exist.
Default behavior is to block, not cascade. Query SELECT COUNT(*) FROM tree_nodes WHERE parent_id = :node_id. If count

 0, do not delete. Return an error response that states the child count so the UI can surface "this node has N children — remove or move them first" rather than a generic failure.



Only delete when child count is 0.
Response: on success, {"deleted": true, "node_id": ...}. On block, {"deleted": false, "reason": "has_children", "child_count": N}.
4.5 get_tree
Params: node_id (optional — omit for all top-level nodes).
Behavior:
If node_id omitted: fetch all nodes where parent_id IS NULL (top-level/client nodes only) for the initial UI render — do not eagerly fetch every descendant of every client in one call.
If node_id given: fetch that node plus its full subtree. Implementation: one query pulling all nodes whose parent_id chains back to node_id is not possible in a single MySQL 5.7 statement without recursion, so fetch all nodes in a bounded working set (e.g. all nodes sharing the same top-level ancestor, or all nodes if the table stays small — decide based on actual row count once migrated) and assemble the parent→children structure in PHP by grouping on parent_id, then recursing from node_id downward through that in-memory structure.
Response: nested JSON — each node object with a children array, recursively.

5. Migration of Existing Data
One-time migration, run once tree_nodes exists:
Insert the three live prospects currently in prospect_ingests — Brad Moore Builders, Faust Hotel, Cowboy Plumbing — as three new top-level nodes (parent_id NULL, node_type = 'client').
ALTER TABLE prospect_ingests ADD COLUMN node_id INT UNSIGNED NULL, ADD CONSTRAINT fk_prospect_node FOREIGN KEY (node_id) REFERENCES tree_nodes(node_id); — prospect_ingests is not replaced, it gains a reference to the new system.
UPDATE prospect_ingests SET node_id = <new id> WHERE <matching row> for each of the three, matched by name/existing identifying field.
Confirm all three rows have a non-null node_id before considering this step done.

6. Explicitly Out of Scope for This Build Item
Per Master Law rule against mid-build detours, this spec covers only tree_nodes + api/tree.php + the three-prospect migration. The following are separate, later build items and should not be touched here:
Re-pointing network_add_node.php's queue path to node_id
Revising brain_start.php and the other Brain pipeline files to persist/ read node_id
Rebuilding intake.php as a node-bound form
Demoting search.php to a secondary filter
These are listed in Part V of the Master Law and follow only after this layer is live and confirmed working.

