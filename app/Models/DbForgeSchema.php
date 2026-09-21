<?php

declare(strict_types=1);

namespace Modules\DbForge\Models;

use Illuminate\Support\Carbon;
use Modules\Quaeris\Models\Profile;
use Modules\Xot\Contracts\ProfileContract;

/**
 * DbForgeSchema model.
 *
 * @property int $id
 * @property string $schema_name
 * @property string $connection_name
 * @property array<string, mixed>|null $schema_definition
 * @property string $status
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 *
 * @method static \Modules\DbForge\Database\Factories\DbForgeSchemaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DbForgeSchema newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DbForgeSchema newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DbForgeSchema query()
 *
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class DbForgeSchema extends BaseModel
{
    protected $table = 'dbforge_schemas';

    /** @var list<string> */
    protected $fillable = [
        'schema_name',
        'connection_name',
        'schema_definition',
        'status',
        'created_by',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'schema_definition' => 'array',
            'created_by' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
