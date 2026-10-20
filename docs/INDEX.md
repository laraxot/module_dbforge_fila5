---
title: "DbForge — Indice canonico docs"
status: canonical
module: DbForge
updated: 2026-10-20
---

> Indice canonico. Indici storici alternativi: `00-index.md`, `README.md`, `CHANGELOG.md`, `wiki/index.md`, `tasks/tasks-index.md`, `roadmap/README.md`. Nessun file storico cancellato.

> Convenzione: [Docs Organization — Modules & Themes](../../Xot/docs/conventions/docs-organization.md)

# DbForge — Indice docs

Modulo DbForge (database / schema manager / strumenti DB).

## Panoramica
- [README.md](./README.md) — presentazione
- [00-index.md](./00-index.md) — indice storico
- [CHANGELOG.md](./CHANGELOG.md) — cambiamenti
- [COVERAGE.md / coverage.md](./coverage.md) — copertura
- [DECISION-LOG.md / decision-log.md](./decision-log.md) — decisioni

## Architettura
- [schema/](./schema/) — schema DB (se presente `.gitkeep`, documentazione schema)
- [mysql-remote/README.md](./mysql-remote/README.md) — MySQL remoto
- [bmad/](./bmad/) — dossier BMAD (decision-log, tech-spec, prd, ux, architecture)
- [schema-manager-doctrine-unavailable.md](./schema-manager-doctrine-unavailable.md)

## PHPStan
- Quality reports integrati in [coverage.md](./coverage.md) e `stories/`

## BMAD / Stories
- [bmad/](./bmad/) — dossier BMAD (10 file: `livewire-widget-*.md`)
- [stories/](./stories/) — storie feature (es. `dbforge-mixed-type-reduction.story.md`)
- [stories/debug-calls-removal-dbforge.story.md](./stories/debug-calls-removal-dbforge.story.md) — rimozione `dddx()` da stub e comandi Artisan, con mascheramento dei segreti

## Testing
- [tasks/](./tasks/) — task operativi (es. `database-management-tools.md`)
- [tasks/tasks-index.md](./tasks/tasks-index.md) — indice task
- `tests/` — se presente in sottostruttura

## API / Guide
- [outputs/README.md](./outputs/README.md) — output
- [raw/README.md](./raw/README.md) — note grezze
- [wiki/](./wiki/) — wiki (`index.md`, `commands/`, `concepts/`, `memories/`, `rules/`, `skills/`)
- [roadmap/README.md](./roadmap/README.md) — piano

## Struttura
- `bmad/` — dossier BMAD (10 file)
- `stories/` — storie feature (2 file)
- `wiki/` — wiki completa (`commands/`, `concepts/`, `memories/`, `rules/`, `skills/`)
- `schema/` — documentazione schema
- `mysql-remote/` — documentazione remoto
- `tasks/`, `roadmap/` — pianificazione
- `outputs/`, `raw/`, `logs/` — archivi

---
*Aggiornato: 2026-10-20 — conforme a `docs-organization.md`; `INDEX.md` creato; `00-index.md`, `README.md`, `CHANGELOG.md` mantenuti.
