# DbForge Module - Roadmap

"Database engineering: scaffolding e utilities."

## Visione

Trasformare DbForge in tool di scaffolding completo che genera modelli, Risorse Filament e Test Pest sincronizzati con lo schema DB.

## Stato attuale

| Metrica | Valore |
|---------|--------|
| PHPStan Level 10 | Compliance |
| XotBase Compliance | Sì |
| Status | In manutenzione |

## Fasi di sviluppo

### Fase 1: Qualità (In Progress)
- [x] PHPStan Level 10 Compliance
- [x] Pulizia documentazione
- [x] GitHub Action automation
- [ ] Fix bug isset in GenerateModelsFromSchemaCommand
- [ ] Aggiornamento AdminPanelProvider Filament v5

### Fase 2: Scaffolding (Planned)
- [ ] Generazione automatica Searchable e Sortable da indici DB
- [ ] Cluster "Database" per utility DB
- [ ] Integrazione Spatie Schema-Diff per drift detection

### Fase 3: Advanced (Future)
- [ ] Generazione completa Resource da schema
- [ ] Migration diff automatico
- [ ] Documentazione schema

## Checklist qualità

- [x] PHPStan Level 10
- [ ] Zero bug noti
- [ ] Documentazione comandi

## Collegamenti

- [README](README.md)
- [philosophy](philosophy.md)

---

**Ultimo aggiornamento**: 2026-02-24