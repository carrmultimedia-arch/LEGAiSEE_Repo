# 0020_BUILD_RULES.md

Version: 1.0  
Status: DRAFT — LOCK UPON APPROVAL

---

# PURPOSE

This chapter defines the mandatory construction rules for the LEGAiSEE Project Manager application.

These rules govern:

- Documentation
- Architecture
- Code generation
- Database creation
- API creation
- Testing
- Deployment preparation
- Change management

These rules exist to prevent project drift and maintain a reproducible build process.

---

# PRIMARY BUILD PRINCIPLE

The Project Bible is the controlling specification.

The implementation must follow the Bible.

The implementation does not redefine the Bible.

No production artifact may exist without documentation authority.

---

# BUILD SEQUENCE

Every build batch shall follow this exact sequence:

Complete Bible Chapters

↓

Review and Approval

↓

Lock Approved Chapters

↓

Generate Owned Production Files

↓

Generate Database Objects

↓

Generate API Components

↓

Generate Tests

↓

Execute Acceptance Testing

↓

Update BUILD_STATUS.md

↓

Update CURRENT_BUILD_TARGET.md

↓

Continue To Next Batch

No step may be skipped.

---

# BATCH RULES

Development shall occur in controlled batches.

A batch consists of:

- Bible chapters
- Owned production files
- Database objects
- API endpoints
- Tests

Each batch must be completed before the next batch begins.

---

# DOCUMENTATION FIRST RULE

No code shall be generated before the governing documentation exists.

Required order:


Requirement

↓

Architecture

↓

Specification

↓

Implementation

↓

Testing


---

# APPROVAL RULE

A chapter is considered active only after approval.

Before approval:

- Chapter is draft
- Code cannot depend on it

After approval:

- Chapter becomes locked
- Code may be generated from it

---

# LOCK RULE

Locked chapters are immutable.

A locked chapter may not be:

- Rewritten
- Reorganized
- Renamed
- Expanded

unless explicitly authorized.

Approved changes require:

- New version
- Change record
- Impact review

---

# FILE CREATION RULE

A production file may only be created when:

1. It exists in the Canonical File Registry
2. It has an owner chapter
3. Its purpose is documented
4. Its dependencies are documented
5. Required tests are documented

---

# NO INVENTION RULE

The following are prohibited:

- New folders
- New architecture layers
- New file names
- New database tables
- New APIs
- New dependencies

unless authorized by:

- Canonical File Registry update
- Bible chapter update
- Owner approval

---

# CODE GENERATION RULES

Generated code must:

- Be complete
- Be production ready
- Follow approved architecture
- Include error handling
- Follow naming standards
- Include required documentation
- Contain no placeholder logic

---

# PROHIBITED CODE

The following are not permitted:

- TODO implementations
- Stub functions
- Fake data
- Temporary bypasses
- Comment-only implementations
- Hardcoded production secrets
- Undocumented behavior

---

# DATABASE RULES

Database objects require:

- Owning chapter
- Schema documentation
- Migration plan
- Relationship definition
- Test coverage

No database table may exist only because code requires it.

The schema defines the code.

---

# API RULES

Every API endpoint requires:

- Specification
- Authentication requirement
- Authorization requirement
- Request format
- Response format
- Error handling
- Tests

No undocumented endpoint may exist.

---

# TEST RULES

Every production feature requires testing.

Required testing categories:

## Unit Tests

Validate individual components.

## Integration Tests

Validate component interaction.

## Acceptance Tests

Validate user requirements.

---

# TEST FAILURE RULE

A failed acceptance test blocks progression.

The batch remains incomplete until resolved.

---

# DEPENDENCY RULES

Dependencies must be:

- Necessary
- Documented
- Approved
- Maintained

Adding dependencies requires justification.

---

# CONFIGURATION RULES

Configuration must be centralized.

Prohibited:

- Hardcoded environment values
- Duplicate configuration sources
- Hidden settings

---

# SECURITY RULES

Every feature must consider:

- Authentication
- Authorization
- Validation
- Data protection
- Audit requirements

Security cannot be added after implementation.

---

# DOCUMENTATION MAINTENANCE

Every completed batch must update:


BUILD_STATUS.md

CURRENT_BUILD_TARGET.md

CHANGELOG.md


---

# CHANGE MANAGEMENT

Requested improvements after approval go into:


TODO.md


Version 1 architecture remains unchanged.

---

# BUILD COMPLETION DEFINITION

A batch is complete only when:

- Documentation approved
- Files generated
- Database updated if required
- API updated if required
- Tests completed
- Acceptance passed
- Status documents updated

---

# BUILD INTEGRITY CHECK

Before starting every batch verify:

- Current target is correct
- Previous batch is complete
- No unauthorized files exist
- No architecture drift occurred

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

TESTS REQUIRED

Governance validation

Build sequence validation

Unauthorized artifact detection

Documentation-first validation
