# 0120_USER_ROLES.md

Version: 1.0  
Status: DRAFT — LOCK UPON APPROVAL

---

# PURPOSE

This chapter defines the official user roles within LEGAiSEE Project Manager.

Roles determine:

- User responsibilities
- Access boundaries
- Default permission groups
- System interaction levels

Roles provide the foundation for the permission model defined in:


0130_PERMISSION_MODEL.md


---

# ROLE MODEL PRINCIPLE

LEGAiSEE Project Manager uses role-based access control (RBAC).

A role represents a collection of permissions assigned to a user.

Permissions define actions.

Roles define groups of actions.

---

# USER ROLE DEFINITIONS

The Version 1 system contains the following primary roles:


Administrator

Project Manager

Team Member

Client

Viewer


---

# ADMINISTRATOR

## Purpose

The Administrator manages system configuration, users, security, and access control.

---

## Responsibilities

Administrators may:

- Manage users
- Assign roles
- Manage permissions
- Configure system settings
- Review audit information
- Manage integrations

---

## Access Level

Full system access.

---

## Restrictions

Administrator actions remain subject to:

- Audit logging
- Security controls
- Governance rules

---

# PROJECT MANAGER

## Purpose

The Project Manager manages project execution and team coordination.

---

## Responsibilities

Project Managers may:

- Create projects
- Configure project settings
- Assign tasks
- Manage milestones
- Review progress
- Generate reports
- Coordinate team activity

---

## Access Level

Project-level management access.

---

## Restrictions

Project Managers cannot:

- Modify system security configuration
- Manage global permissions
- Override administrator controls

---

# TEAM MEMBER

## Purpose

The Team Member performs assigned project work.

---

## Responsibilities

Team Members may:

- View assigned projects
- Update assigned tasks
- Add notes
- Upload files
- Participate in collaboration

---

## Access Level

Assigned project access.

---

## Restrictions

Team Members cannot:

- Create global users
- Modify permissions
- Change project ownership

---

# CLIENT

## Purpose

The Client role provides controlled external access.

---

## Responsibilities

Clients may:

- View shared projects
- Review approved documents
- Participate in approved communication areas

---

## Access Level

Restricted external access.

---

## Restrictions

Clients cannot:

- View internal-only information
- Modify system configuration
- Access unrelated projects

---

# VIEWER

## Purpose

The Viewer role provides read-only access.

---

## Responsibilities

Viewers may:

- View permitted projects
- Review available information

---

## Access Level

Read-only.

---

## Restrictions

Viewers cannot:

- Create records
- Modify records
- Manage users
- Change permissions

---

# ROLE ASSIGNMENT RULES

Users may have:

- One primary role
- Multiple assigned roles
- Project-specific permissions

The final access decision is determined by:

- User identity
- Assigned roles
- Permissions
- Project membership
- Security policies

---

# PROJECT ROLE ASSIGNMENT

Project-level roles may differ from global roles.

Example:

A user may be:

Global:


Team Member


Project:


Project Manager


Access must always follow the most restrictive applicable security rule.

---

# ROLE HIERARCHY

Default hierarchy:


Administrator

↓

Project Manager

↓

Team Member

↓

Client

↓

Viewer


Hierarchy does not automatically grant permissions.

Permissions must be explicitly assigned.

---

# ROLE MANAGEMENT REQUIREMENTS

The system shall support:

- Creating roles
- Assigning roles
- Removing roles
- Reviewing role assignments
- Auditing role changes

---

# ROLE SECURITY RULES

The system must prevent:

- Unauthorized privilege escalation
- Unauthorized role changes
- Hidden permissions
- Untracked access changes

---

# FUTURE ROLE SUPPORT

Future versions may introduce:

- Portfolio Manager
- Executive Reviewer
- Auditor
- External Partner
- AI Agent

Future roles require approval.

---

# ACCEPTANCE REQUIREMENTS

This chapter is complete when:

- User roles are defined
- Responsibilities are documented
- Access levels are defined
- Restrictions are documented
- Role hierarchy is established

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

0100_PRODUCT_OVERVIEW.md

0110_FEATURE_MATRIX.md

TESTS REQUIRED

Role definition validation

Role hierarchy validation

Role assignment validation
