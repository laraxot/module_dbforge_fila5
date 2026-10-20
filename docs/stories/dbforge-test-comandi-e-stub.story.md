---
title: "Test dei comandi DbForge e decisione sullo stub del generatore di modelli"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: DbForge
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["../../../Xot/docs/stories/test-database-guard.story.md", "verdetto Pest P0 dell'utente", "run completo PHPStan finito"]
related: ["./debug-calls-removal-dbforge.story.md", "./dbforge-mixed-type-reduction.story.md", "../../../Quaeris/docs/stories/debug-calls-removal-quaeris.story.md"]
tags: [bmad, test, artisan, secrets, stub, duplicati]
---

# Test dei comandi DbForge e decisione sullo stub del generatore di modelli

Fase BMAD: Dev (test prima, poi decisioni su duplicati e stub).

## Richiesta

Come sviluppatore voglio test che bloccano la regressione del mascheramento delle credenziali e del parsing delle pagine, e una decisione chiara sullo stub `GenerateModelByTableAction`, cosi' che le correzioni fatte il 2026-10-20 (vedi `debug-calls-removal-dbforge.story.md`) non si perdano al prossimo ritocco.
Il comando `xot:view-db-config` stampa la configurazione dei database: se il mascheramento si rompe, le password finiscono a terminale e nei log.

## Scopo

`ViewDatabaseConfigCommand` mostra le connessioni di `config('database.connections')` con i segreti coperti da `********`. `ParsePrintPageStringCommand` espande `1-4,6,8-9` nell'elenco dei numeri di pagina e serve a chi prepara stampe. `GenerateModelByTableAction` doveva generare un modello Eloquent da una tabella e non e' mai stata scritta.

## Stato misurato

Misure del 2026-10-20 13:58Z da `/mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel`.
- Test DbForge: `rg -l -P -e '^(it|test)\(|function test|#\[Test\]' Modules/DbForge/tests` = 0. Controprova: lo stesso comando su `Modules/Quaeris/tests` = 61. Secondo metodo: `/usr/bin/find Modules/DbForge/tests -name '*Test.php' | wc -l` = 0 e `git grep -c -E "^(it|test)\(|function test|#\[Test\]" -- Modules/DbForge/tests` senza righe. In `tests/` ci sono solo `Pest.php`, `TestCase.php` e due `.gitkeep`.
- Base dei test: `tests/TestCase.php` usa `DatabaseTransactions` e `tests/Pest.php` ultima riga `pest()->extend(TestCase::class)->in(Unit, Feature)`: ogni test nuovo in quelle cartelle apre una transazione, cioe' tocca il database.
- Comandi nello stato attuale: `ViewDatabaseConfigCommand` (`xot:view-db-config`) appiattisce con `Arr::dot` e maschera se l'ultimo segmento della chiave contiene `password`, `passwd`, `secret`, `token`, `key`, `url`, `dsn` (`isSecret()` :79-82) e il valore e' `filled`. `ParsePrintPageStringCommand` (`xot:parse-print-page {str}`) stampa JSON, `FAILURE` su `InvalidArgumentException`. Il parsing sta in `Modules\Xot\Actions\ParsePrintPageStringAction`, che ha gia' un test in `Modules/Xot/tests/Unit/Actions/Parse/ParsePrintPageStringActionTest.php` con due casi ancora `->todo()` (nessuna pagina valida, intervallo invertito).
- Duplicati: `Modules/Xot/app/Console/Commands/` ha le stesse due classi, uguali a quelle di DbForge salvo namespace e una riga "Mirror di ... (canonico, stessa signature)" (`diff` di entrambe le coppie). Le 4 signature sono identiche a due a due: `rg -n -P -e "xot:view-db-config|xot:parse-print-page" Modules --glob '*.php'` = 4 righe (controprova `git grep -n -e ... -- 'Modules/*.php'` = 4). Registrazione: ogni modulo legge la propria `app/Console/Commands/_components.json` (`GetComponentsAction` restituisce il file se ha lo schema corrente) e tutte e due contengono tutte e due le classi (DbForge 13 voci, Xot 10, nessuna punta a un file mancante, verificato con uno script `python3 -I`). Quindi il nome e' registrato due volte e vince quello caricato per ultimo; quale sia non si legge dal codice (serve `artisan`, vietato oggi). Oggi non conta, perche' le due copie sono equivalenti.
- Stub: `GenerateModelByTableAction::execute()` lancia `LogicException` (`DbForge/app/Actions/Model/GenerateModelByTableAction.php:18-21`). Chiamanti nel codice: 0 (`rg -n -P -e GenerateModelByTableAction Modules Themes app --glob '*.php'` e `git grep -n -w` trovano solo le due classi, `coverage.xml` e 5 documenti). La copia in Xot ha lo stesso stub con messaggio inglese. Esistono generatori veri: `xot:generate-model {model_class}` (`GenerateModelByModelClassCommand`) e `db:models:generate` (`GenerateModelsFromSchemaCommand`).
- Osservato, fuori perimetro: 8 comandi di DbForge non sono in `_components.json` e quindi non risultano registrati (22 file in `Console/Commands`, 13 voci, `XotBaseCommand` e' astratta): `AnalyzeNamingCommand`, `DatabaseSchemaExportCommand`, `DatabaseSchemaExporterCommand`, `GenerateDbDocumentationCommand`, `GenerateModelsFromSchemaCommand`, `ImportMdbToMySQL`, `ImportMdbToSQLite`, `SearchStringInDatabaseCommand`. Quindi `db:models:generate` non e' oggi un'alternativa pronta.
- Lacuna del mascheramento, letta nel codice: guarda solo l'ultimo segmento. Un segreto in lista (`'password' => ['a', 'b']`) diventa `mysql.password.0` e `mysql.password.1` e si stampa in chiaro. Non provata con un'esecuzione.

## Lavoro

1. Base dei test senza database: togliere `use DatabaseTransactions;` da `tests/TestCase.php` (il modulo non ha test che ne abbiano bisogno), cosi' i test nuovi non aprono transazioni; chi un giorno ne ha bisogno lo dichiara nel file con `uses(DatabaseTransactions::class)`. Alternativa non provata: una seconda base di test con un secondo `pest()->extend()` sulle stesse cartelle; verificare prima che Pest non entri in conflitto.
2. `tests/Unit/Console/Commands/ViewDatabaseConfigCommandTest.php`: istanziare la classe DbForge direttamente (`setLaravel(app())` e `Symfony\Component\Console\Tester\CommandTester`), non per nome, perche' il nome e' ambiguo. Iniettare `config(['database.connections' => [...]])` con valori finti (`fake-secret-value`). Casi:

| Chiave | Valore | Atteso |
|---|---|---|
| `mysql.password` | `fake-secret-value` | `********` |
| `mysql.password` | `''` | non mascherato (vuoto) |
| `mysql.url` | `mysql://u:p@h/db` | `********` |
| `mysql.read.password` | valore finto | `********` |
| `mysql.username`, `mysql.host` | testo | in chiaro |
| `mysql.port`, `mysql.strict`, `mysql.options` | `3306`, `true`, `[]` | `3306`, `true`, `[]` |
| `mysql.password` come lista | `['a','b']` | `********` (rosso oggi: il test va scritto prima del fix) |
| `database.connections` non array | stringa | exit 1 e messaggio di errore |

3. Fix del caso lista in `isSecret()` (:79-82): controllare ogni segmento del percorso tranne il primo (il nome della connessione), con il test del passo 2 prima rosso poi verde.
4. `tests/Unit/Console/Commands/ParsePrintPageStringCommandTest.php`, stesso metodo, solo il contratto del comando (il parsing resta nel test di Xot): `1-4,6,8-9` exit 0 con `[1,2,3,4,6,8,9]`; `5` con `[5]`; `1-3,` con `[1,2,3]`; `abc` exit 1 con `No valid page numbers found`; `5-3` exit 1 con `End number must be greater than or equal to start number`.
5. Applicare le decisioni 1 e 2. Se si tolgono le classi di Xot, nello stesso cambio vanno tolte le loro voci da `Modules/Xot/app/Console/Commands/_components.json`: una voce senza file fa fallire l'avvio di `artisan` per tutto il progetto.

Rischio: toccare Xot (modulo di un'altra sessione) senza coordinarsi; per questo i passi 1-4 sono solo DbForge.

## Acceptance criteria

- [ ] `rg -l -P -e '^(it|test)\(|function test|#\[Test\]' Modules/DbForge/tests` >= 2 (oggi 0; controprova Quaeris 61).
- [ ] `rg -n DatabaseTransactions Modules/DbForge/tests/TestCase.php` = 0.
- [ ] Il test dei segreti ha il caso lista e prima del fix fallisce; dopo passa.
- [ ] I due file di test non toccano il database (prova nella Verifica).
- [ ] Decisione 1 registrata; se si cancella: `git grep -n -w GenerateModelByTableAction -- '*.php'` = 0.
- [ ] Decisione 2 registrata; se si dedup: `rg -n -P -e "xot:view-db-config|xot:parse-print-page" Modules --glob '*.php'` = 2 (oggi 4) e nessuna voce di `_components.json` senza file.
- [ ] PHPStan su `Modules/DbForge`: exit 0.

## Verifica

- Con Pest sbloccato: `cd laravel && ./vendor/bin/pest Modules/DbForge/tests` atteso verde, almeno 12 casi. Prova che il test morde: nel comando togliere `'url'` da `SECRET_KEY_PARTS` in una copia temporanea e vedere fallire il caso `mysql.url`.
- Prova di assenza del database: eseguire gli stessi test con `DB_HOST` puntato a un host irraggiungibile (le 8 connessioni con host di `laravel/config/database.php` leggono `env('DB_HOST')`; controllare che nessun modulo ne definisca altre con un'altra variabile): devono passare ugualmente. Se falliscono per connessione, l'avvio dell'app tocca il database e i test restano "con database" (vale la guardia).
- `php -l` sui file toccati e PHPStan col gate dei vincoli. Check statico delle voci: `python3 -I` che verifica che ogni `class` di `_components.json` abbia il file (stesso controllo gia' fatto il 2026-10-20: 0 voci rotte).

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: nei test solo valori finti, mai credenziali vere ne' lettura di `.env`; `Modules/Xot` non si tocca senza il via dell'altra sessione.

## Decisioni aperte

1. Stub `GenerateModelByTableAction`: cancellarlo in DbForge e in Xot (consigliato: 0 chiamanti, esiste solo per lanciare un errore, i generatori veri sono altrove) oppure implementarlo.
2. Duplicati dei due comandi: tenere DbForge come canonico (lo dice il commento dei mirror) e togliere le copie e le voci JSON in Xot, oppure tenere i mirror. Consiglio: togliere, ma la scelta e il momento sono dell'owner di Xot.
3. Test senza database prima della guardia e del verdetto: con `DB_HOST` irraggiungibile non possono toccare nulla, ma Pest e' fermo per ordine dell'utente. Chiedere se questi due file possono girare cosi'.
4. Mascherare anche `username` (gia' decisione aperta di `debug-calls-removal-dbforge.story.md`: su questa macchina username e password coincidono).

## Come ripartire

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel && rg -l -P -e '^(it|test)\(|function test|#\[Test\]' Modules/DbForge/tests | wc -l` per vedere se qualcuno ha gia' scritto test; leggere `ViewDatabaseConfigCommand.php` e `ParsePrintPageStringCommand.php`.
2. Chiedere le decisioni 1-3 all'utente.
3. Scrivere i due file di test (passi 1, 2, 4), farli passare con la prova a database irraggiungibile quando consentito, poi il fix del passo 3, PHPStan su `Modules/DbForge`, `status` e second brain.
