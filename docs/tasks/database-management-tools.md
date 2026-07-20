# Task 001: Implement Advanced Database Management Tools

## Description
Create comprehensive database management tools including schema browser, query builder, data editor, migration management, and database comparison features.

## Context
The DbForge module needs powerful tools for database administration, schema management, and data manipulation with support for multiple databases and advanced operations.

## Requirements

### Functional Requirements
- Schema browser (tables, columns, indexes, relations)
- Visual query builder
- Data editor with CRUD operations
- Migration management (create, run, rollback)
- Database comparison and synchronization
- SQL editor with syntax highlighting
- Import/export functionality
- Performance analysis tools
- Backup and restore

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Support multiple database types (MySQL, PostgreSQL, SQLite)
- DatabaseTransactions for tests
- MySQL with "_test" suffix for testing

## Implementation Steps

### 1. Database Schema
- [ ] Create `dbforge_saved_queries` table
  - id (uuid/ulid)
  - tenant_id
  - user_id
  - name (string)
  - query (text)
  - description (text, nullable)
  - is_favorite (boolean, default false)
  - tags (json, nullable)
  - last_executed_at (nullable)
  - execution_count (default 0)
  - timestamps

- [ ] Create `dbforge_migrations_tracking` table
  - id (uuid/ulid)
  - tenant_id
  - migration_name (string)
  - batch (int)
  - status (enum: 'pending', 'running', 'completed', 'failed')
  - started_at (nullable)
  - completed_at (nullable)
  - error_message (nullable)
  - timestamps

### 2. Schema Service
- [ ] Create `DatabaseSchemaService`
  - `getTables(): array`
  - `getTableColumns(string $table): array`
  - `getTableIndexes(string $table): array`
  - `getTableRelations(string $table): array`
  - `getForeignKeys(string $table): array`
  - `getTableSize(string $table): array`
  - `getDatabaseSize(): array`
  - `analyzeSchema(string $table): array`

### 3. Query Builder Service
- [ ] Create `QueryBuilderService`
  - `buildSelect(array $tables, array $columns, array $joins, array $wheres, array $group, array $order, int $limit, int $offset): string`
  - `parseQuery(string $query): array`
  - `validateQuery(string $query): array`
  - `explainQuery(string $query): array`
  - `optimizeQuery(string $query): string`

### 4. Data Editor Service
- [ ] Create `DataEditorService`
  - `selectData(string $table, array $filters, int $limit, int $offset): Collection`
  - `insertData(string $table, array $data): bool`
  - `updateData(string $table, array $data, array $where): int`
  - `deleteData(string $table, array $where): int`
  - `bulkInsert(string $table, array $data): int`
  - `bulkUpdate(string $table, array $data, array $where): int`
  - `bulkDelete(string $table, array $where): int`

### 5. Migration Manager Service
- [ ] Create `MigrationManagerService`
  - `createMigration(string $name, array $options): string` (file path)
  - `runMigrations(array $migrations = []): array`
  - `rollbackMigration(int $steps = 1): array`
  - `resetMigrations(): array`
  - `getMigrationStatus(): array`
  - `getPendingMigrations(): array`
  - `getMigrationLog(): Collection`

### 6. Database Comparison Service
- [ ] Create `DatabaseComparisonService`
  - `compareSchemas(string $db1, string $db2): array`
  - `generateSyncScript(array $differences): string`
  - `applySyncScript(string $script): array`
  - `compareTables(string $table1, string $table2): array`
  - `compareData(string $table, array $key): array`

### 7. SQL Editor Service
- [ ] Create `SqlEditorService`
  - `executeQuery(string $query, array $bindings = []): array`
  - `executeScript(string $script): array`
  - `formatQuery(string $query): string`
  - `highlightSyntax(string $query): string`
  - `getQueryHistory(string $userId): Collection`
  - `saveQuery(string $query, string $name, string $userId): bool`

### 8. Import/Export Service
- [ ] Create `DataImportExportService`
  - `exportTable(string $table, string $format, array $options): string` (file path)
  - `exportQuery(string $query, string $format): string`
  - `importData(string $table, string $file, string $format): array`
  - `exportSchema(string $format): string`
  - `importSchema(string $file): array`

- [ ] Support formats
  - CSV
  - Excel
  - JSON
  - SQL
  - XML

### 9. Performance Analysis Service
- [ ] Create `PerformanceAnalysisService`
  - `analyzeSlowQueries(): array`
  - `getTableIndexUsage(string $table): array`
  - `suggestIndexes(string $table): array`
  - `analyzeQueryPerformance(string $query): array`
  - `getDatabaseMetrics(): array`
  - `optimizeDatabase(): array`

### 10. Backup and Restore Service
- [ ] Create `BackupRestoreService`
  - `createBackup(array $options): string` (backup file)
  - `restoreBackup(string $backupFile): array`
  - `scheduleBackup(array $schedule): bool`
  - `listBackups(): array`
  - `deleteBackup(string $backupId): bool`

### 11. Filament Resources
- [ ] Create `DatabaseSchemaResource`
  - Schema browser
  - Table details
  - Column information
  - Relation viewer

- [ ] Create `QueryBuilderResource`
  - Visual query builder
  - Query editor
  - Results viewer
  - Query history

- [ ] Create `DataEditorResource`
  - Table data viewer
  - CRUD operations
  - Bulk operations
  - Data validation

- [ ] Create `MigrationManagerResource`
  - Migration list
  - Run/rollback migrations
  - Migration status
  - Create new migration

- [ ] Create `DatabaseToolsResource`
  - Import/export
  - Backup/restore
  - Performance analysis
  - Database comparison

### 12. Widgets
- [ ] Create `DatabaseStatsWidget`
  - Database size
  - Table count
  - Row count
  - Index usage

- [ ] Create `SlowQueriesWidget`
  - Recent slow queries
  - Query analysis
  - Optimization suggestions

### 13. API Endpoints
- [ ] `GET /api/dbforge/schema` - Get schema
- [ ] `GET /api/dbforge/tables/{table}` - Get table details
- [ ] `POST /api/dbforge/query` - Execute query
- [ ] `POST /api/dbforge/data/{table}` - Data operations
- [ ] `POST /api/dbforge/migrate` - Run migrations
- [ ] `GET /api/dbforge/performance` - Performance metrics

### 14. Actions
- [ ] Create `ExecuteQueryAction`
- [ ] Create `RunMigrationAction`
- [ ] Create `CreateBackupAction`
- [ ] Create `OptimizeDatabaseAction`

### 15. Tests
- [ ] Create `SchemaServiceTest`
- [ ] Create `QueryBuilderServiceTest`
- [ ] Create `DataEditorServiceTest`
- [ ] Create `MigrationManagerTest`
- [ ] Create `ImportExportTest`

### 16. Documentation
- [ ] Create database tools guide
- [ ] Document query builder
- [ ] Create migration guide
- [ ] Add performance tuning guide

## Acceptance Criteria
- [ ] Schema browsing works correctly
- [ ] Query builder generates valid SQL
- [ ] Data editor performs CRUD operations
- [ ] Migration management is functional
- [ ] Database comparison works
- [ ] Import/export supports all formats
- [ ] Performance analysis provides insights
- [ ] Backup/restore is reliable
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Xot module (base classes)
- Tenant module (multi-database)
- Filament 5.x (admin UI)
- Laravel Database (schema management)

## Estimated Time
- Database schema: 2 hours
- Schema service: 4 hours
- Query builder: 6 hours
- Data editor: 5 hours
- Migration manager: 4 hours
- Database comparison: 5 hours
- SQL editor: 4 hours
- Import/export: 5 hours
- Performance analysis: 5 hours
- Backup/restore: 4 hours
- Filament integration: 8 hours
- Widgets: 3 hours
- API endpoints: 3 hours
- Actions: 2 hours
- Tests: 8 hours
- Documentation: 3 hours

**Total: 71 hours (9 days)**

## Priority
**High** - Core database tools

## Related Tasks
- Task 002: Advanced Database Features
- Task 003: Database Security and Auditing

## Notes
- Use read-only connections for schema browsing
- Implement query timeout protection
- Use transactions for data operations
- Validate all SQL before execution
- Implement query result pagination
- Add SQL injection protection
- Use MySQL "_test" suffix for testing

---

**Created**: 2026-01-31
**Status**: Pending
**Assignee**: TBD