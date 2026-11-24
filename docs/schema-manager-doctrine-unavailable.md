# Schema manager Doctrine non disponibile

`GetSchemaManagerByModelClassAction` chiama `$connection->getDoctrineSchemaManager()` solo se il metodo esiste
(`method_exists`). Con il Laravel installato (13.x) `Illuminate\Database\Connection` non lo espone piu':
l'Action lancia sempre `RuntimeException`. PHPStan non lo vede, perche' la guardia `method_exists` nasconde il caso.

## Cosa fare al posto

Per modificare lo schema di un model usare lo Schema builder di Laravel sulla connessione del model:

```php
Schema::connection($model->getConnectionName())->table($table, static function (Blueprint $blueprint) use ($indexName): void {
    $blueprint->dropIndex($indexName);
});
```

Vantaggi: gli identificatori sono quotati dal grammar (`AbstractSchemaManager::dropIndex()` di DBAL
concatena nome indice e tabella senza quotarli) e non serve il package Doctrine.

## `DeleteTableIndexByModelClassIndexNameAction`

- Prima: `introspectTable...()->dropIndex()` agiva solo sull'oggetto `Table` in memoria, nessun `ALTER TABLE`;
  inoltre dipendeva dall'Action che lancia sempre. Non ha chiamanti in `Modules/` e `Themes/`.
- Ora: esegue davvero `DROP INDEX` tramite Schema builder. E' un cambio di comportamento: chi la collega
  in futuro ottiene la cancellazione reale dell'indice, non un no-op.
- Gemella: `Xot/app/Actions/Model/DeleteTableIndexByModelClassIndexNameAction` ha ancora la versione in memoria
  (`edit()->dropIndexByUnquotedName()->create()`): da allineare o eliminare.
- Stesso difetto (Doctrine non disponibile) in `Query/CreateTableIndexByModelClassColumnsAction` di DbForge,
  limitato a un blocco commentato.
