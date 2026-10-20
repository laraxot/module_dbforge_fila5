---
title: "[STORY] Chiamate dddx() in produzione: stub, comando di parsing pagine e comando di config database"
type: story
status: review
priority: high
created: 2026-10-20
updated: 2026-10-20
module: DbForge
tags: [debug, dddx, artisan, secrets, stub, bmad]
related:
  - ../../../Quaeris/docs/stories/debug-calls-removal-quaeris.story.md
---

# [STORY] Chiamate `dddx()` in produzione nel modulo DbForge

**Fase BMAD:** Dev (correzione mirata) con verifica reale in coda.

## Richiesta

`dddx()` (`Modules/Xot/helpers/Helper.php`) termina con `dd($data)` senza condizioni: stampa un dump con percorsi e dati e uccide il processo. Una misura con tokenizer PHP trova tre chiamate attive in DbForge. Le altre tre voci del tokenizer (`var_export` e `print_r` in `GenerateModelsFromSchemaCommand` e `StartQueryLogAction`) usano il secondo argomento `true`, restituiscono una stringa e sono legittime.

## Sito 1: `GenerateModelByTableAction::execute()`

**Scopo capito.** Stub "WIP" per generare un modello Eloquent da una tabella, con riferimenti a `krlove/eloquent-model-generator` e `laracademy/generators`. Non e' mai stato implementato.

**Chiamanti.** Nessuno, verificato con `rg -P` e `git grep -w`: la classe compare solo nella dichiarazione e in report di copertura. Per questo non e' stata cancellata.

**Cosa e' stato fatto.** `dddx('WIP')` sostituito da `throw new LogicException('GenerateModelByTableAction::execute() non implementato')`: se qualcuno la invoca fallisce con un errore chiaro e tracciabile invece di stampare un dump.

**Rischio.** Nullo (nessun chiamante).

## Sito 2: `ParsePrintPageStringCommand` (`xot:parse-print-page {str}`)

**Scopo capito.** Strumento da sviluppatore: espande una stringa come `1-4,6,8-9` nell'elenco dei numeri di pagina, delegando a `Modules\Xot\Actions\ParsePrintPageStringAction`. Il `dddx` era l'output pensato.

**Cosa e' stato fatto.** `handle()` ora restituisce `int`: stampa l'elenco come JSON con `Safe\json_encode` (`[1,2,3,4,6,8,9]`) e termina con `SUCCESS`. Una stringa senza pagine valide solleva `InvalidArgumentException` nell'Action: il comando la intercetta, stampa l'errore con `$this->error()` e termina con `FAILURE`. Descrizione del comando corretta (era " esplode").

**Rischio.** Basso. Comando solo da console, nessuna dipendenza esterna.

## Sito 3: `ViewDatabaseConfigCommand` (`xot:view-db-config`)

**Scopo capito.** Mostrare la configurazione delle connessioni database senza le password. Il codice vecchio mascherava solo la chiave `password` del primo livello (e la creava anche se assente), ignorava `url` (puo' contenere `utente:password@host`) e array annidati, e poi chiamava `dddx`.

**Cosa e' stato fatto.** `handle()` appiattisce `database.connections` con `Arr::dot` e stampa una tabella `Chiave / Valore` con `$this->table()`. Il valore e' sostituito da `********` se l'ultimo segmento della chiave contiene `password`, `passwd`, `secret`, `token`, `key`, `url` o `dsn` e il valore non e' vuoto. Rimosso `Webmozart\Assert` (ora controllo esplicito con `FAILURE`). Descrizione corretta.

**Rischio.** Basso. Lo `username` resta visibile di proposito (serve al debug).

## Verifica funzionale (2026-10-20)

Esecuzione dei due comandi in un processo `artisan tinker` con output catturato (nessun valore segreto stampato nei log di questa verifica):
- `xot:view-db-config`: uscita 0, 27 righe `*.password`, tutte `********`, zero non mascherate.
- `xot:parse-print-page 1-4,6,8-9`: uscita 0, output `[1,2,3,4,6,8,9]`. Con `abc`: uscita 1, messaggio `No valid page numbers found`.

## Esito (2026-10-20)

- **Tokenizer** su `Modules/DbForge/app`: 0 `dddx`/`dd`/`dump`. Restano `var_export(..., true)` (2) e `print_r(..., true)` (1), legittimi perche' restituiscono una stringa.
- **`php -l`:** pulito sui tre file.
- **PHPStan** (gate condiviso, `phpstan.neon` unica): `Modules/DbForge` intero, exit 0, nessun errore.
- **Pest:** non eseguito (database di test assente, regola MySQL).

## Decisioni aperte

1. **Duplicati in Xot.** `Modules/Xot` contiene copie identiche di `GenerateModelByTableAction` (ancora con `dddx('WIP')`), `ParsePrintPageStringCommand` e `ViewDatabaseConfigCommand` (ancora con `dddx`). I due comandi hanno la stessa signature (`xot:parse-print-page`, `xot:view-db-config`) in entrambi i moduli: ne vince uno solo, con rischio che resti attivo quello non corretto. Modulo di un'altra sessione, non toccato. Da decidere quale copia tenere.
2. **Username e password uguali.** Su questa macchina username e password della connessione coincidono: il mascheramento della password e' vano se si stampa lo username. Decidere se mascherare anche `username`.
3. **Implementare o rimuovere** `GenerateModelByTableAction`, che esiste solo come stub.
