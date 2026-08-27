# 0030_GLOSSARY.md

Version: 1.0  
Status: DRAFT — LOCK UPON APPROVAL

---

# PURPOSE

This chapter defines the official terminology used throughout the LEGAiSEE Project Manager application.

The purpose of this glossary is to maintain consistent language across:

- Bible documentation
- Database design
- Application code
- User interface
- API documentation
- Testing
- Future development

Terms defined here are authoritative.

---

# APPLICATION TERMS

## LEGAiSEE Project Manager

The standalone project management application built for the LEGAiSEE platform.

It provides enterprise project planning, execution, collaboration, documentation, reporting, and intelligence-enhanced workflows.

---

## Application

The complete Project Manager software system.

Includes:

- Runtime code
- Database
- API
- Frontend
- Storage
- Tests
- Documentation

---

## Project Bible

The complete collection of governing Markdown documentation defining the system.

The Project Bible is the source of truth for all implementation decisions.

---

## Batch

A controlled development unit consisting of:

- Bible chapters
- Owned production files
- Database objects
- API endpoints
- Tests

A batch must be completed before the next batch begins.

---

## Build

The controlled process of converting approved documentation into working software.

---

## Build Status

The current documented state of project construction.

Stored in:


governance/BUILD_STATUS.md


---

## Current Build Target

The next approved construction objective.

Stored in:


governance/CURRENT_BUILD_TARGET.md


---

# ARCHITECTURE TERMS

## Architecture

The approved structural design of the application.

Defines:

- Components
- Relationships
- Responsibilities
- Boundaries
- Rules

---

## Component

A reusable software unit with a defined responsibility.

Examples:

- Router
- Controller
- Service
- UI component

---

## Layer

A separation of responsibilities within the application.

Examples:

- Presentation layer
- Business layer
- Data layer

---

## Module

A logical grouping of related functionality.

A module does not necessarily represent a physical folder.

---

## Integration

A connection between Project Manager and another LEGAiSEE system.

Examples:

- Authentication
- Clients
- Cases
- Graph
- Search

---

# SOFTWARE TERMS

## Production File

Any file that belongs to the deployed application.

Examples:

- PHP files
- JavaScript files
- CSS files
- Configuration files

---

## Owned File

A production file that has a documented owning Bible chapter.

---

## Canonical File Registry

The authoritative list of approved production files.

Defines:

- File name
- Location
- Purpose
- Owner chapter
- Status

Stored in:


0910_CANONICAL_FILE_REGISTRY.md


---

## Source of Truth

The authoritative location where information is defined.

For architecture:

Project Bible

For code:

Canonical files

For data:

Database schema

---

## Drift

Any unauthorized deviation from approved architecture, documentation, naming, files, or workflows.

Examples:

- Creating undocumented files
- Changing folder structure
- Adding features without documentation

---

## Dependency

A required relationship between software components.

Examples:

- Class dependency
- Package dependency
- Database dependency

---

# DATABASE TERMS

## Database

The structured storage system used by Project Manager.

---

## Schema

The formal definition of database structure.

Includes:

- Tables
- Columns
- Indexes
- Constraints
- Relationships

---

## Table

A database structure storing related records.

---

## Record

A single stored database entry.

---

## Relationship

A defined connection between data entities.

Example:

A project contains tasks.

---

## Migration

A controlled database change.

Examples:

- Create table
- Add column
- Modify constraint

---

# APPLICATION OBJECT TERMS

## Model

An object representing a business entity.

Examples:

- Project
- Task
- User

---

## Repository

A data access layer responsible for communication with the database.

Repositories contain persistence logic only.

---

## Service

A business logic layer responsible for workflows and rules.

Services coordinate operations.

---

## Controller

A request handling layer responsible for receiving requests and returning responses.

Controllers do not contain business rules.

---

## Middleware

A request processing layer executed before or around application logic.

Examples:

- Authentication
- Authorization
- Logging

---

## API

An interface allowing systems or applications to communicate.

---

## Endpoint

A specific API operation.

Defined by:

- URL
- HTTP method
- Request format
- Response format

---

# SECURITY TERMS

## Authentication

The process of verifying identity.

Answers:

"Who are you?"

---

## Authorization

The process of determining permissions.

Answers:

"What are you allowed to do?"

---

## Role

A named collection of permissions assigned to a user.

---

## Permission

A specific allowed action.

Example:


project.create


---

## Policy

A rule determining whether an action is allowed.

---

## Audit Log

A historical record of important system actions.

---

# USER EXPERIENCE TERMS

## User Interface (UI)

The visible interaction layer of the application.

---

## Component Library

A collection of reusable interface elements.

Examples:

- Buttons
- Forms
- Tables
- Modals

---

## Workspace

The primary environment where users manage projects.

---

## Dashboard

A summary view displaying important information and metrics.

---

## Workflow

A defined sequence of actions required to complete an objective.

---

# PROJECT MANAGEMENT TERMS

## Project

A temporary initiative with defined goals, resources, and outcomes.

---

## Task

A specific unit of work within a project.

---

## Milestone

A significant project checkpoint.

---

## Dependency

A relationship where one activity relies on another.

---

## Deliverable

A completed output produced by a project.

---

## Resource

A person, asset, or capability required for project execution.

---

## Risk

A potential event that may negatively affect project success.

---

## Issue

A current problem requiring resolution.

---

## Change Request

A formal request to modify approved project scope.

---

# LEGAiSEE INTELLIGENCE TERMS

## Intelligence Engine

The LEGAiSEE capability responsible for analysis and insights.

---

## Graph Engine

The LEGAiSEE capability responsible for relationship mapping.

---

## Memory Ingest

The process of capturing and preserving institutional knowledge.

---

## Search Engine

The system responsible for locating stored information.

---

## Report Engine

The system responsible for generating structured outputs.

---

# STATUS TERMS

## Draft

A document or artifact awaiting approval.

---

## Approved

A document accepted by the project owner.

---

## Locked

An approved document that cannot be changed without authorization.

---

## Complete

A batch or artifact meeting all acceptance requirements.

---

## Deprecated

An artifact no longer used but retained for historical reference.

---

# ACCEPTANCE REQUIREMENTS

This glossary is complete when:

- Core terminology is defined
- Development terminology is consistent
- Technical terminology is standardized
- Future documentation uses these definitions

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

0015_FILE_OWNERSHIP.md

0020_BUILD_RULES.md

TESTS REQUIRED

Glossary consistency validation

Terminology usage validation

Documentation reference validation

NEXT BUILD TARGET

Approval and lock Batch 2