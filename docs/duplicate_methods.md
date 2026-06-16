# Metodi duplicati — DbForge

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **47**
- Metodi duplicati trovati: **21**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `handle` | 20 | candidato a trait/helper |
| `execute` | 8 | candidato a trait/helper |
| `__construct` | 7 | candidato a trait/helper |
| `definition` | 5 | candidato a trait/helper |
| `byUser` | 4 | candidato a trait/helper |
| `failed` | 4 | candidato a trait/helper |
| `completed` | 3 | candidato a trait/helper |
| `pending` | 3 | candidato a trait/helper |
| `running` | 3 | candidato a trait/helper |
| `casts` | 2 | possibile duplicazione |
| `compressed` | 2 | possibile duplicazione |
| `delete` | 2 | possibile duplicazione |
| `encrypted` | 2 | possibile duplicazione |
| `forTable` | 2 | possibile duplicazione |
| `getTableColumns` | 2 | possibile duplicazione |
| `getTableForeignKeys` | 2 | possibile duplicazione |
| `getTableIndexes` | 2 | possibile duplicazione |
| `indexExists` | 2 | possibile duplicazione |
| `large` | 2 | possibile duplicazione |
| `small` | 2 | possibile duplicazione |

... altri 1 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
