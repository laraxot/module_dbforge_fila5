<?php

declare(strict_types=1);

namespace Modules\DbForge\Actions\Model;

use Modules\Xot\Actions\Model\DeleteTableIndexByModelClassIndexNameAction as XotDeleteTableIndexAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Entry point DbForge: l'implementazione vive nel modulo base Xot (una sola sorgente).
 */
class DeleteTableIndexByModelClassIndexNameAction
{
    use QueueableAction;

    public function execute(string $modelClass, string $indexName): void
    {
        app(XotDeleteTableIndexAction::class)->execute($modelClass, $indexName);
    }
}
