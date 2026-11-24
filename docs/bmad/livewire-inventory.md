---
title: "Inventario Http/Livewire → Filament widget — DbForge"
type: inventory
module: DbForge
status: approved
track: campaign
related:
  - ./livewire-widget-project-context.md
  - ./livewire-widget-decision-log.md
  - ./livewire-widget-epics.md
  - ./livewire-widget-prd.md
  - ../../Xot/docs/bmad/livewire-widget-project-context.md
  - ../../Cms/docs/bmad/livewire-inventory.md
---

# Inventario: Livewire HTTP → Filament — modulo DbForge

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo DbForge per la campagna di conversione Livewire → Filament widget. Formato e metodo sono ripresi da [Modules/Cms/docs/bmad/livewire-inventory.md](../../Cms/docs/bmad/livewire-inventory.md), con la differenza che qui non esiste nemmeno una classe da classificare: il risultato verificato è **zero componenti Livewire**.

## Metodo (codice, non assunzione)

```bash
find Modules/DbForge -path '*/vendor/*' -prune -o -name '*.php' -print | xargs grep -l 'extends.*\(Component\|Livewire\)'
find Modules/DbForge -iname '*livewire*' -not -path '*/vendor/*'
ls Modules/DbForge/app/Http/Livewire/ Modules/DbForge/app/Livewire/
grep -rn "@livewire" Modules/DbForge --include="*.blade.php"
grep -rn "<livewire:" Modules/DbForge --include="*.blade.php"
find Modules/DbForge/app/Filament -iname '*widget*'
ls Modules/DbForge/resources/views/pages
```

## Classi Livewire trovate: zero

Il primo comando (`extends Component|Livewire` su tutti i `.php` del modulo, vendor escluso) non restituisce alcun file. In dettaglio:

| Posizione | Esito |
|---|---|
| `Modules/DbForge/app/Http/Livewire/` | La directory esiste ma contiene solo `_components.json` (contenuto: `[]`, cioè zero alias registrati) — nessun `.php`, nemmeno `.gitkeep` |
| `Modules/DbForge/app/Livewire/` | Non esiste |
| `find -iname '*livewire*'` | Unici hit: i file di questa campagna in `docs/bmad/`, la directory vuota `app/Http/Livewire`, e `app/Console/Commands/LivewireComponentsListCommand.php` (vedi nota sotto). Nessuna classe componente, nessuna vista `livewire/` |

### Nota collaterale: `LivewireComponentsListCommand` non è un componente

`Modules/DbForge/app/Console/Commands/LivewireComponentsListCommand.php` estende `Illuminate\Console\Command` (riga 13), non `Livewire\Component`: è il comando Artisan `xot:livewire-list` (signature riga 21) che "rileva tutti i componenti registrati di Livewire" — uno strumento di diagnostica che *legge* il registry Livewire, non un componente da convertire. Va citato perché è l'unico file `.php` del modulo con "Livewire" nel nome, ma è fuori dal perimetro della campagna.

Conclusione verificata: il modulo **non possiede** alcun componente Livewire, né classico (`Http/Livewire`) né nel layout Livewire 3/4 (`app/Livewire`).

## Verifica del montaggio: zero hit nelle viste del modulo

Il modulo può comunque *montare* componenti altrui senza possederne. Verificato su tutti i 2 file `.blade.php` di `Modules/DbForge/resources/views/`:

| Meccanismo | Comando | Esito |
|---|---|---|
| `@livewire(...)` | `grep -rn "@livewire" Modules/DbForge --include="*.blade.php"` | **0 hit** |
| `<livewire:... />` | `grep -rn "<livewire:" Modules/DbForge --include="*.blade.php"` | **0 hit** |
| Pagina Folio/Volt | `ls Modules/DbForge/resources/views/pages` | La directory `pages/` non esiste: DbForge non contribuisce rotte Folio/Volt |

Conclusione verificata: DbForge non monta nessun componente Livewire, proprio o altrui.

## Widget Filament esistenti nel modulo DbForge: nessuno (nessun `app/Filament`)

`find Modules/DbForge/app/Filament -iname '*widget*'` non restituisce nulla perché **la directory `app/Filament/` non esiste**: `Modules/DbForge/app/` contiene solo `Actions, Console, Http, Models, Providers, View`. Il modulo non ha alcuna superficie Filament propria — niente Pages, niente Resources, niente Widgets. Il punto in cui `XotBasePanelProvider` cerca automaticamente i widget di un modulo (`discoverWidgets(base_path('Modules/'.$this->module.'/app/Filament/Widgets'), ...)`) non ha quindi alcun path da scandire per DbForge.

## Classificazione

| Classe | Alias/hook | Gemello widget | Cluster | Nota |
|---|---|---|---|---|
| — | — | — | — | Tabella vuota: zero classi da classificare |

**Cluster A: zero candidati.** Non esistono componenti Livewire in DbForge, quindi nessuno può essere montato nel chrome di un panel Filament.

**Cluster B: zero candidati.** Il modulo non ha alcun Filament Widget esistente — non ha nemmeno `app/Filament/` — quindi non c'è nulla che duplichi un ipotetico componente.

**Cluster C: zero candidati.** Non c'è alcuna pagina/componente instradato da escludere.

## Verdetto

**Nessun candidato, nessuna story di implementazione.** DbForge è un modulo di infrastruttura (migration/schema tooling via Actions, Console, Models): non ha superficie UI Livewire né Filament widget da migrare. Questo file resta come gate anti-scope-creep: chiunque proponga un widget DbForge deve prima creare o individuare il componente reale e rieseguire questo inventario.

## Riferimenti correlati (non SSoT, coerenti col verdetto)

- [livewire-widget-architecture.md](./livewire-widget-architecture.md)
- [livewire-widget-brainstorming.md](./livewire-widget-brainstorming.md)
- [livewire-widget-decision-log.md](./livewire-widget-decision-log.md)
- [livewire-widget-epics.md](./livewire-widget-epics.md)
- [livewire-widget-prd.md](./livewire-widget-prd.md)
- [livewire-widget-product-brief.md](./livewire-widget-product-brief.md)
- [livewire-widget-project-context.md](./livewire-widget-project-context.md)
- [livewire-widget-tech-spec.md](./livewire-widget-tech-spec.md)
- [livewire-widget-ux.md](./livewire-widget-ux.md)

## Successo

- [x] Inventario completo del modulo (0 classi trovate, `extends Component|Livewire` su tutti i `.php`)
- [x] Verifica montaggio nelle viste del modulo (`@livewire`, `<livewire:`, Folio `pages/` assente)
- [x] Verifica widget gemelli (`app/Filament/` del tutto assente)
- [x] Nessun widget nuovo proposto senza prima verificare l'esistenza di un componente
- [x] Nessuna story di conversione creata (zero candidati reali)
