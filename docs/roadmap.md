# Roadmap Modulo DbForge - Database Engineering

**Data Aggiornamento**: 2026-01-31  
**Status**: 📋 IN MANUTENZIONE  
**Versione**: 1.5.0

## 🎯 Obiettivo

Trasformare DbForge in un tool di scaffolding completo che non solo generi modelli, ma anche Risorse Filament e Test Pest sincronizzati con lo schema DB.

## 🚨 TODO e Miglioramenti Identificati

### 1. Fix Comandi Console
**Problema**: Il comando `GenerateModelsFromSchemaCommand.php` contiene controlli ridondanti (isset su proprietà statiche o simili) che sporcano i log.
**Priorità**: 🔴 Alta
**Task**: Rivedere la linea 237 e normalizzare i check.

### 2. Allineamento Filament v5 (Clusters)
**Problema**: Le utility DB sono sparse. Devono essere raggruppate in un Cluster "Core" o "Database".
**Priorità**: 🟢 Bassa - Funzionale ma non prioritario.

### 3. Integrazione con Spatie Schema-Diff
**Problema**: Migliorare la rilevazione dei drift tra schema locale e produzione.
**Priorità**: 🟡 Media

## 📋 Piano d'Azione

### Fase 1: Qualità Codice (Settimana 1)
- [ ] Fix bug `isset` segnalato.
- [ ] Aggiornamento `AdminPanelProvider` per compatibilità totale Filament v5.
- [ ] Pulizia documentazione redundante (es. file di merge conflict).

### Fase 2: Scaffolding Avanzato (Settimana 2)
- [ ] Generazione automatica di `Searchable` e `Sortable` in base agli indici DB.

## 🔗 Collegamenti
- [README](./README.md)
- [Filosophy](./philosophy.md)