---
title: "Architecture — DbForge"
type: architecture
module: DbForge
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
  - ../../Xot/docs/bmad/livewire-widget-project-context.md
---

# Architecture DbForge

Nessun flusso HTTP → widget: zero classi `Http\Livewire`, nessuna directory `app/Filament` nel modulo. `LivewireComponentsListCommand` è un comando Artisan diagnostico, non un componente. Verdetto verificato: [livewire-inventory.md](./livewire-inventory.md).
