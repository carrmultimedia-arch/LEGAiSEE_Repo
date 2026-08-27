# 0330_ATTACHMENT_MODEL.md

Version: 1.0

Status: DRAFT

---

# PURPOSE

Defines document and attachment storage architecture.

---

# ATTACHMENT PURPOSE

Attachments allow projects, tasks, cases, clients, and reports to store related files.

---

# ATTACHMENT TABLE

Future table:

attachments


Columns:

id

entity_type

entity_id

filename

storage_path

mime_type

file_size

uploaded_by

created_at


---

# STORAGE RULES

Files are stored outside database.

Database stores:

- Metadata
- Ownership
- Relationships

---

# SECURITY RULES

Attachments require:

- Permission validation
- Access logging
- File validation

---

FILES CREATED

NONE

FILES MODIFIED

NONE

DATABASE TABLES

attachments

API ENDPOINTS

NONE

DEPENDENCIES

0300_DATABASE_ARCHITECTURE.md

TESTS REQUIRED

Attachment model validation