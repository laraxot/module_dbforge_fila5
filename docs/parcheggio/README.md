---
title: "File parcheggiati — DbForge"
slug: parcheggio
module: DbForge
document_type: index
category: documentation
type: index
status: active
language: it-IT
created: 2026-11-18
updated: 2026-11-18
tags: [parcheggio, debito-tecnico]
description: "File con estensione finta spostati fuori da app/ in DbForge, con il motivo per ciascuna famiglia."
---

# File parcheggiati — DbForge

File spostati qui da `app/` il 2026-11-18. In `app/` sta solo codice che gira.

Un'estensione finta — `.boh`, `.up`, `.test`, `.disabled`, `.to_migra` — non
tiene un file fuori dal codice: lo rende invisibile a chi cerca e vivo per chi
lo trova. Il percorso dentro `parcheggio/` e' quello d'origine, quindi si sa
sempre da dove veniva.

| File (percorso d'origine sotto `app/`) | Byte |
|---|---|
| `app/Console/Commands/DatabaseSchemaExporterCommand.to_migra` | 10836 |
| `app/Console/Commands/GenerateDbDocumentationCommand.to_migra` | 11715 |

## Cosa sono questi `.to_migra`

Due comandi — `DatabaseSchemaExporterCommand` e
`GenerateDbDocumentationCommand` — presenti **identici anche in Xot**, parcheggiati
in entrambi i moduli. L'unica differenza fra le due copie e' la riga del
namespace:

```
< namespace Modules\DbForge\Console\Commands;
> namespace Modules\Xot\Console\Commands;
```

Il nome dice "da migrare": qualcuno stava spostando questi comandi da un modulo
all'altro e si e' fermato a metà, lasciando due copie parcheggiate e nessuna
viva. Se vanno ripresi, la casa giusta e' DbForge — e' il modulo per gli
strumenti sul database — e la copia in Xot va cancellata, non tenuta come
riserva.

## Prima di riprenderne uno

Questi file **non sono stati esaminati riga per riga**: sono stati spostati,
non giudicati. Prima di copiarne uno nel codice vivo, confrontalo con quello
che c'e' adesso: in uno di questi, a ottobre, c'erano 135 righe di lavoro non
fuso che per poco non sono state cancellate. Quando il lavoro e' finito,
cancella il file parcheggiato.

Tracciato in
[module_quaeris_fila5#61](https://github.com/laraxot/module_quaeris_fila5/issues/61).
