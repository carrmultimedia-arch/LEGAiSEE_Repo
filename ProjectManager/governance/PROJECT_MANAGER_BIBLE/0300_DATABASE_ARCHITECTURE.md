# 0300_DATABASE_ARCHITECTURE.md

Version: 1.0

Status: DRAFT

---

# PURPOSE

Defines the database architecture for LEGAiSEE Project Manager.

The database layer provides persistent storage for:

- Users
- Roles
- Permissions
- Projects
- Tasks
- Documents
- Attachments
- Activity history
- Integration records

---

# DATABASE ENGINE

Primary Database:

MySQL

Character Set:

utf8mb4

Collation:

utf8mb4_unicode_ci

---

# DATABASE PRINCIPLES

The system database must:

- Maintain normalized relational structures.
- Preserve historical records.
- Support permission filtering.
- Support LEGAiSEE integrations.
- Support audit tracking.
- Avoid undocumented tables.

---

# CONNECTION

Database access is managed through:

database/connection.php

Database abstraction:

app/Core/Database.php

---

# MIGRATION SYSTEM

All schema changes must be created through:

database/migrations/

Migration files are sequential.

Format:

NNN_description.php

---

# TABLE OWNERSHIP

Every table must have:

- Owning Bible chapter
- Migration file
- Model
- Repository if required
- Tests

---

# TIMESTAMP STANDARD

All primary tables include:

created_at

updated_at

---

# ID STANDARD

Primary keys:

INTEGER AUTO_INCREMENT

Foreign keys:

INTEGER

---

# DATABASE SECURITY

Requirements:

- Prepared statements only
- No raw user SQL input
- Password hashing required
- Permission checks required

---

FILES CREATED

NONE

FILES MODIFIED

NONE

DATABASE TABLES

NONE

API ENDPOINTS

NONE

DEPENDENCIES

NONE

TESTS REQUIRED

Database architecture validation

NEXT BUILD TARGET

0310_DATABASE_SCHEMA.md