# 0130_PERMISSION_MODEL.md

Version: 1.0  
Status: DRAFT — LOCK UPON APPROVAL

---

# PURPOSE

This chapter defines the authorization and permission framework for LEGAiSEE Project Manager.

The permission model establishes:

- Available permissions
- Permission structure
- Role-to-permission relationships
- Access control rules
- Security enforcement requirements

This chapter is the specification authority for:

- `permissions.php`
- `app/Policies/*`
- `app/Models/Permission.php`
- `app/Models/Role.php`
- `app/Services/AuthorizationService.php`

---

# AUTHORIZATION PRINCIPLE

LEGAiSEE Project Manager uses role-based access control (RBAC).

The authorization model follows:


User

↓

Role Assignment

↓

Role Permissions

↓

Permission Check

↓

Allowed / Denied Action


A user may only perform actions granted through assigned permissions.

---

# AUTHENTICATION VS AUTHORIZATION

## Authentication

Determines:

"Who is the user?"

Handled through:

- LEGAiSEE authentication integration
- User identity validation
- Session management

---

## Authorization

Determines:

"What is the user allowed to do?"

Handled through:

- Roles
- Permissions
- Policies
- Authorization services

---

# PERMISSION STRUCTURE

Permissions use a resource-action naming convention.

Format:


resource.action


Examples:


project.create

task.update

user.manage


---

# PERMISSION CATEGORIES

## User Permissions

Controls user management.

Permissions:


user.view

user.create

user.update

user.delete

user.manage


---

## Role Permissions

Controls role management.

Permissions:


role.view

role.create

role.update

role.delete

role.assign


---

## Permission Administration

Controls security configuration.

Permissions:


permission.view

permission.assign

permission.manage


---

## Project Permissions

Controls project operations.

Permissions:


project.view

project.create

project.update

project.delete

project.archive

project.manage


---

## Task Permissions

Controls task operations.

Permissions:


task.view

task.create

task.update

task.delete

task.assign

task.complete


---

## Document Permissions

Controls project files and documents.

Permissions:


document.view

document.create

document.update

document.delete

document.download


---

## Collaboration Permissions

Controls collaboration features.

Permissions:


comment.create

comment.update

comment.delete

note.create

note.update

note.delete


---

## Reporting Permissions

Controls reporting access.

Permissions:


report.view

report.create

report.export


---

## Integration Permissions

Controls LEGAiSEE system connections.

Permissions:


integration.view

integration.manage


---

# DEFAULT ROLE PERMISSION MODEL

## Administrator

Default permissions:


Full system access.

---

## Project Manager

Default permissions:


project.*
task.*
document.*
comment.*
note.*
report.view
report.create


---

## Team Member

Default permissions:


project.view
task.view
task.update
task.complete
document.view
comment.create
note.create


---

## Client

Default permissions:


project.view
document.view
comment.create


---

## Viewer

Default permissions:


project.view
document.view
report.view


---

# PERMISSION EVALUATION

Authorization checks must evaluate:

1. User identity
2. Assigned roles
3. Assigned permissions
4. Project membership
5. Resource ownership
6. Security policies

---

# DENIAL RULE

Access is denied when:

- User is unauthenticated
- Permission does not exist
- Role does not grant permission
- Policy rejects action
- Resource is unavailable

---

# POLICY SYSTEM

Policies provide resource-specific authorization.

Examples:


ProjectPolicy

TaskPolicy

DocumentPolicy

UserPolicy


Policies determine whether an authenticated user may interact with a specific resource.

---

# AUTHORIZATION SERVICE

The Authorization Service provides centralized permission checks.

Responsibilities:

- Check permissions
- Evaluate roles
- Evaluate policies
- Return authorization decisions
- Support API security

---

# PERMISSION STORAGE MODEL

Permissions are stored using:


users

roles

permissions

role_permissions

user_roles


---

# DATABASE RELATIONSHIPS

## Users

A user may have multiple roles.

Relationship:


users
|
|
user_roles
|
|
roles


---

## Roles

A role may have multiple permissions.

Relationship:


roles
|
|
role_permissions
|
|
permissions


---

# SECURITY REQUIREMENTS

The system must prevent:

- Privilege escalation
- Unauthorized role changes
- Permission bypasses
- Direct unauthorized API access
- Hidden administrative access

---

# AUDIT REQUIREMENTS

The system must record:

- Role assignments
- Permission changes
- Authorization failures
- Administrative actions

---

# VERSION 1 LIMITATIONS

Version 1 does not include:

- Attribute-based access control
- Custom policy scripting
- Dynamic permission generation

Future enhancements require approval.

---

# ACCEPTANCE REQUIREMENTS

This chapter is complete when:

- RBAC model is defined
- Permissions are defined
- Role relationships are defined
- Security rules are defined
- Authorization requirements are documented

---

FILES CREATED

NONE

FILES MODIFIED

NONE

DATABASE TABLES

Defined:


users
roles
permissions
role_permissions
user_roles


---

API ENDPOINTS

Defined:


/api/auth/*

/api/users/*

/api/permissions/*


---

DEPENDENCIES

0100_PRODUCT_OVERVIEW.md

0110_FEATURE_MATRIX.md

0120_USER_ROLES.md

0015_FILE_OWNERSHIP.md

0020_BUILD_RULES.md

---

TESTS REQUIRED

Permission tests

Role tests

Authorization tests

Authentication tests

---

NEXT BUILD TARGET

Approve and lock Batch 3 documentation.

Proceed to owned production file generation:

permissions.php

app/Policies/*

app/Models/User.php

app/Models/Role.php

app/Models/Permission.php

app/Services/AuthorizationService.php

app/Controllers/AuthController.php