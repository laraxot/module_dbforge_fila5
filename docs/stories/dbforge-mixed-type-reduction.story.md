---
title: "DbForge — mixed type reduction audit"
status: done
module: DbForge
date: 2026-09-04
---

# Story: DbForge — `mixed` type reduction audit

**Fase BMAD**: Refactor / qualità (audit + correzione mirata dei tipi, nessuna
modifica funzionale).

**Contesto**: convenzione di progetto — "cerchiamo di non usare mixed, quando lo
troviamo cerchiamo di sostituirlo con qualcosa di adeguato" — applicata a
`Modules/DbForge` (17 file con `mixed` all'avvio).

**Azione**: censiti tutti gli usi di `mixed` (nativi e in docblock) su 17 file
tramite `grep -rnE '\bmixed\b' Modules/DbForge --include="*.php"`. Ogni occorrenza è
stata letta nel contesto reale (chiamante, contratto vendor, consumer a valle) prima
di decidere se sostituirla, distinguendo type-hint nativi (priorità alta) da docblock
generici (`array<string, mixed>`, già adeguati quando il valore è genuinamente
eterogeneo).

**Esito**: **2 file modificati**, 15 rivisti e lasciati invariati (dettaglio
per-file completo in `docs/coverage.md`, sezione "2026-09-04 — mixed type reduction
audit"):

- `app/Console/Commands/AnalyzeNamingCommand.php` — `Schema::getColumnListing()`
  ritorna realmente `list<string>` (verificato nel sorgente vendor Laravel), la
  `mixed` locale era solo un workaround per il fatto che l'estensione Larastan di
  PHPStan è disattivata di proposito in questo repo. Sostituita con `list<string>` /
  `string`; il file ora non ha più nessun `mixed`.
- `app/Console/Commands/GenerateDbDocumentationCommand.php` — i parametri `array<mixed,
  mixed>` di tre metodi (`generateDocumentation`, `generateTableDocumentation`,
  `generateRelationshipDocumentation`) sono diventati `array<string, mixed>`: le
  chiavi dello schema JSON decodificato sono sempre stringhe letterali nell'uso reale
  (`'tables'`, `'columns'`, `'indices'`, ecc.). Serviti anche cast `@var` puntuali ai
  tre call site per far quadrare PHPStan (il tipo dedotto da `json_decode(...,
  true)` dopo `is_array()` resta `array<mixed, mixed>` finché non lo si asserisce
  esplicitamente).

Il resto (`mixed` in `@property array<string, mixed>` sui model per colonne JSON,
`definition(): array` nelle factory che rispecchia il contratto vendor di
`Illuminate\...\Factory::definition()`, closure su righe DB non tipizzabili con
certezza per via del facade `DB::`/`Schema::` non risolto da Larastan) rientra nelle
eccezioni esplicite del task — payload genuinamente polimorfi o vincoli di libreria,
non pigrizia.

Nessun `@phpstan-ignore` aggiunto, nessuna modifica a `phpstan.neon`, nessun
allargamento di tipi già più stretti.

**Verifica**:
- PHPStan (`./vendor/bin/phpstan analyse Modules/DbForge --no-progress
  --error-format=table`): **0 errori prima → 0 errori dopo**.
- PHPMD (`./tools/phpmd.sh Modules/DbForge text ../docs/phpmd.ruleset.xml`): eseguito
  senza crash; findings pre-esistenti (complessità/else-expression su metodi non
  toccati), non correlati a questo diff.
- Pest: **non verificabile** — `Modules/DbForge/phpunit.xml` non esiste e
  `Modules/DbForge/tests/` non contiene test veri (solo `TestCase.php`, `Pest.php` e
  directory `Unit`/`Feature` vuote con `.gitkeep`).

**Collisioni**: nessuna trovata. `git status --short` sul modulo era pulito
all'avvio. I riferimenti a "DbForge" in `docs/chat/` risalgono a luglio-agosto 2026
(sync forward-only, consolidamento docs, marker di merge già risolti) e non
riguardano questo lavoro.

**Dettaglio completo**: vedi `docs/coverage.md`, sezione "2026-09-04 — mixed type
reduction audit".
