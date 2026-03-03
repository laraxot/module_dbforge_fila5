# PRD - DbForge Module

## 1. Executive Summary
The DbForge module provides tools for programmatically managing database schema and migrations across all modules in the PTVX platform.

## 2. Target Personas
- **Internal Developers:** Use the module to automate database changes.
- **DevOps Engineers:** Monitor and manage database state and migrations.
- **Architects:** Design and maintain database schema standards.

## 3. Functional Requirements
- Automate creation and execution of migrations.
- Provide a fluent interface for schema modification.
- Roll back migrations in case of deployment failures.
- Verify schema consistency across all modules.

## 4. Service Interface (The Contract)
- **API Endpoints:**
  - `POST /api/db-forge/migrate`: Run pending migrations.
  - `POST /api/db-forge/rollback`: Roll back the last migration.
- **Events:**
  - `DbMigrationExecuted`: Triggered when a migration completes.

## 5. System Architecture & Dependencies
- **Data Ownership:** Owns migration records and schema metadata.
- **Downstream Dependencies:** Depends on `Xot` and `laravel/framework`.

## 6. Non-Functional Requirements
- **Reliability:** Atomic operations for schema changes.
- **Observability:** Comprehensive logging for all database modifications.

## 7. Release Criteria
- PHPStan Level 10 compliance.
- Robust error handling for migration failures.
