# 🛠️ **DbForge Module** - Schema Automation & Intelligence

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Database Management](https://img.shields.io/badge/Tools-Forge%20%7C%20Migrate%20%7C%20Seed-orange.svg)](https://laravel.com/docs/11.x/migrations)

> **🚀 Modulo DbForge**: Il cuore dell'ingegneria del database per Laraxot. Automatizza la creazione del codice a partire dallo schema, gestisce migrazioni complesse e fornisce un'interfaccia visuale per la manipolazione della struttura dati.

## 📋 **Panoramica**

Il modulo **DbForge** non è un semplice gestore di migrazioni, ma un vero "fabbro" del database.

- 🧬 **Reverse Engineering**: Generazione automatica di modelli Eloquent, Migrazioni e Factory a partire da tabelle esistenti.
- 🏗️ **Schema Guard**: Monitoraggio delle differenze tra schema fisico e definizioni del codice.
- ⚡ **Filament DB Manager**: Pannello amministrativo per eseguire query, visualizzare strutture e gestire indici senza tool esterni.
- 🧹 **Code Cleaning**: Strumenti per normalizzare i nomi dei campi e rimuovere ridondanze nello schema.

## ⚡ **Funzionalità Core**

### 🧩 **Automated Code Generation**
Comandi CLI avanzati per accelerare lo sviluppo trasformando lo schema SQL in classi PHP pronte per l'uso (Level 10 compliant).

### 🧘 **Philosophical Design**
Il database è la "verità assoluta". Il codice deve riflettere lo schema in modo fedele e automatizzato.

## 🚀 **Quick Start**

### 📦 **Generazione Modelli da Schema**
```bash
php artisan dbforge:generate-models --table=users
```

### ⚙️ **Verifica Stato Database**
Consultare la dashboard **DbForge** nell'Admin Panel per un check rapido sull'integrità delle migrazioni.

## 📚 **Documentazione Centrale**

- 📖 **[Indice Documentazione](./index.md)** - Guida completa al modulo.
- 🙏 **[Filosofia](./philosophy.md)** - Perché lo schema-first è fondamentale.
- 🗺️ **[Roadmap](./roadmap.md)** - Verso la generazione automatica dei Form Filament.
- 🏗️ **[Nesting Guide](./filament-nesting-complete-guide.md)** - Come organizziamo le tabelle correlate.

---

**🔄 Ultimo aggiornamento**: 31 Gennaio 2026
**📦 Versione**: 1.5.0
**✅ PHPStan level 10**: Compliance verificata