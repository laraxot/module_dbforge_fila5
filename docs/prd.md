# DbForge - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: DbForge Module Team

## 1. Purpose & Vision
The DbForge module provides a suite of **database engineering and scaffolding utilities** for the Laraxot ecosystem. Its vision is to serve as a complete developer tool that syncs database schemas with application code (Models, Filament Resources, Pest Tests) to speed up module development.

## 2. Problem Statement
Developer productivity is hampered by:
- Manual creation of models and resources from existing database tables.
- Drifting schemas that are not reflected in application code.
- Repetitive boilerplate for basic CRUD generation.
- Difficulty in inspecting and manipulating database structure in multi-tenant environments.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Developer** | Module Builder | Scaffolding tools to generate application code from DB. |
| **System Admin** | Infrastructure Manager | Database inspection and maintenance utilities. |
| **Integrator** | System Analyst | Analyze existing schemas for legacy integrations. |

## 4. Scope
### In Scope
- Database schema inspection and metadata extraction.
- Automatic generation of Xot-compliant Models.
- Automatic generation of XotBase Filament Resources.
- Syncing database changes with application artifacts.
- Utilities for database manipulation and cleanup.

### Out of Scope
- Database backups and restoration (delegated to standard Laravel/Spatie tools).
- Designing new database schemas (use migrations instead).

## 5. Functional Requirements (Prioritized)

### P0: Developer Scaffolding (Must-have)
- **FR-001: Schema Inspection**: Retrieve detailed information about columns, types, and indexes from any connected database.
- **FR-002: Automatic Model Generation**: Generate `XotBaseModel` files from existing tables, including property annotations and relation suggestions.
- **FR-003: Filament Resource Scaffolding**: Generate `XotBaseResource` and associated pages from models/tables.

### P1: Maintenance & QA (Important)
- **FR-004: Sync Verification**: Identify discrepancies between database schema and application artifacts.
- **FR-006: DB Manipulation Utils**: Standardized tools for database cleanup and inspection in multi-tenant environments.

### P2: Advanced Productivity (Nice-to-have)
- **FR-005: Automatic Test Generation**: Generate basic Pest feature tests for a given database table or resource.
- **FR-007: AI-Driven Mapping**: AI suggestions for complex relationship mapping and type casting.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Developer-Only Service**: DbForge MUST NOT have any runtime dependencies on domain modules.
- **Interoperability**: Interacts with any database connection managed by the `Setting` module.
- **Independence**: Generation logic is abstracted from specific database vendors (MySQL, PostgreSQL).

### Performance & Safety
- **NFR-001: Safety**: Scaffolding MUST NOT overwrite existing code without explicit user confirmation.
- **NFR-002: Precision**: Accurate mapping between SQL types and PHP/Filament types.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance for all utilities.

## 7. Technical Architecture
### Dependencies
- **Xot**: Core framework.
- **Setting**: For managing various database connections.
### Integration Points
- Directly interacts with various database drivers via the `DatabaseConnection` model from `Setting`.

## 8. User Experience
- Interactive CLI commands for generation.
- Admin interface to browse tables and trigger code generation.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Time-to-Resource | < 30 seconds | Time to generate ready-to-use CRUD from table. |
| Code Compliance | 100% | Generated code must pass PHPStan Level 10. |
| PHPStan Compliance | Level 10 | Static analysis. |

## 10. Risks & Assumptions
### Assumptions
- Database schema is reasonably well-structured (naming conventions).
- DB user has sufficient privileges to read metadata.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Overwriting custom code | High | Mandatory `-force` flag and file diffs. |
| Complex schema mapping | Medium | Manual override for type mapping. |

## 11. Dependencies & Constraints
- PHP 8.3+, Laravel 12.
- Adheres to Super Mucca coding standards.

## 12. Release Plan
### Phase 1: Core Scaffolding (In Progress)
- Schema inspection. ✅
- Basic model generation. ✅
### Phase 2: Complete Scaffolding (Planned)
- Advanced Filament resource generation.
- Automatic Pest test generation.

## 13. References
- [roadmap.md](roadmap.md)
