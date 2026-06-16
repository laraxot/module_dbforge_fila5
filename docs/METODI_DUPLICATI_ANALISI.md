---
module: DbForge
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi DbForge

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **DbForge**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `active` (13 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeSchemaFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `inactive` (9 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeSchemaFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `failed` (8 occorrenze)

**Moduli coinvolti:** DbForge, Job, Notify, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeBackupFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeMigrationFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeOperationFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeQueryLogFactory.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `pending` (5 occorrenze)

**Moduli coinvolti:** DbForge, Tenant

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeBackupFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeMigrationFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeOperationFactory.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `completed` (4 occorrenze)

**Moduli coinvolti:** DbForge, IndennitaResponsabilita

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeBackupFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeMigrationFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeOperationFactory.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `byUser` (4 occorrenze)

**Moduli coinvolti:** DbForge

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeBackupFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeMigrationFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeOperationFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeQueryLogFactory.php`

[Riflessione: Duplicato interno al modulo DbForge — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `running` (3 occorrenze)

**Moduli coinvolti:** DbForge

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeBackupFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeMigrationFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeOperationFactory.php`

[Riflessione: Duplicato interno al modulo DbForge — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `indexExists` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Actions/Query/CreateTableIndexByModelClassColumnsAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `validateColumnsExist` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Actions/Query/CreateTableIndexByModelClassColumnsAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `small` (2 occorrenze)

**Moduli coinvolti:** DbForge

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeBackupFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeSchemaFactory.php`

[Riflessione: Duplicato interno al modulo DbForge — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `replaceClass` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Console/Commands/GenerateModelClassCommand.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `large` (2 occorrenze)

**Moduli coinvolti:** DbForge

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeBackupFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeSchemaFactory.php`

[Riflessione: Duplicato interno al modulo DbForge — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `isValidConnection` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Actions/Query/GetFieldnamesByTablenameAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `importTablesIntoMySQL` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Console/Commands/ImportMdbToMySQL.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getTableIndexes` (2 occorrenze)

**Moduli coinvolti:** DbForge

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Console/Commands/DatabaseSchemaExportCommand.php`
- `./laravel/Modules/DbForge/app/Console/Commands/DatabaseSchemaExporterCommand.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTableForeignKeys` (2 occorrenze)

**Moduli coinvolti:** DbForge

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Console/Commands/DatabaseSchemaExportCommand.php`
- `./laravel/Modules/DbForge/app/Console/Commands/DatabaseSchemaExporterCommand.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStub` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Console/Commands/GenerateModelClassCommand.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDefaultNamespace` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Console/Commands/GenerateModelClassCommand.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `generateIndexName` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Actions/Query/CreateTableIndexByModelClassColumnsAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `forTable` (2 occorrenze)

**Moduli coinvolti:** DbForge

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeOperationFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeQueryLogFactory.php`

[Riflessione: Duplicato interno al modulo DbForge — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `exportTablesToSQL` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in DbForge:**

- `./laravel/Modules/DbForge/app/Console/Commands/ImportMdbToMySQL.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `encrypted` (2 occorrenze)

**Moduli coinvolti:** DbForge

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeBackupFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeSchemaFactory.php`

[Riflessione: Duplicato interno al modulo DbForge — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `createTable` (2 occorrenze)

**Moduli coinvolti:** DbForge, Sigma

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeOperationFactory.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `compressed` (2 occorrenze)

**Moduli coinvolti:** DbForge

**File in DbForge:**

- `./laravel/Modules/DbForge/database/factories/DbForgeBackupFactory.php`
- `./laravel/Modules/DbForge/database/factories/DbForgeSchemaFactory.php`

[Riflessione: Duplicato interno al modulo DbForge — valutare estrazione in trait di modulo o classe base]

---

## Riflessioni per DbForge

- **Totale metodi duplicati che coinvolgono DbForge:** 24
- **Di cui cross-modulo:** 15
- **Di cui interni al modulo:** 9

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 15 metodi
- **altro:** 9 metodi

### Moduli con maggiori duplicazioni incrociate

- **Tenant:** 12 metodi in comune
- **Xot:** 12 metodi in comune
- **User:** 4 metodi in comune
- **Setting:** 2 metodi in comune
- **UI:** 2 metodi in comune
- **Notify:** 2 metodi in comune
- **Job:** 1 metodi in comune
- **IndennitaResponsabilita:** 1 metodi in comune
- **Sigma:** 1 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
