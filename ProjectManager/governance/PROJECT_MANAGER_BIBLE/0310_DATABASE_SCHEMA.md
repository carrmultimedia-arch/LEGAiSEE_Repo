# 0310_DATABASE_SCHEMA.md

Version: 1.0

Status: DRAFT

---

# PURPOSE

Defines the canonical database schema.

No database table may exist without registration here.

---

# CORE TABLES

## users

Purpose:

Stores authenticated system users.

Columns:

id

name

email

password_hash

active

created_at

updated_at


---

## roles

Purpose:

Stores user roles.

Columns:

id

name

description

created_at

updated_at


---

## permissions

Purpose:

Stores available permissions.

Columns:

id

name

description

created_at

updated_at


---

## role_permissions

Purpose:

Maps permissions to roles.

Columns:

id

role_id

permission_id


---

## user_roles

Purpose:

Maps users to roles.

Columns:

id

user_id

role_id


---

# PROJECT TABLES

Reserved for:

0500_PROJECT_WORKSPACE.md

---

# INTEGRATION TABLES

Reserved for:

0700_SYSTEM_INTEGRATIONS.md

---

# AUDIT TABLES

Reserved for:

0340_ACTIVITY_LOG.md

---

FILES CREATED

NONE

FILES MODIFIED

NONE

DATABASE TABLES

users

roles

permissions

role_permissions

user_roles

API ENDPOINTS

NONE

DEPENDENCIES

0300_DATABASE_ARCHITECTURE.md

TESTS REQUIRED

Schema validation

NEXT BUILD TARGET

0320_RELATIONSHIP_MODEL.md