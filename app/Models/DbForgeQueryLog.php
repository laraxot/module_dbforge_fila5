<?php

declare(strict_types=1);

namespace Modules\DbForge\Models;

/**
 * DbForgeQueryLog model.
 *
 * @property int $id
 * @property string $query_sql
 * @property array<string, mixed>|null $query_bindings
 * @property float|null $query_time
 * @property int|null $user_id
 * @property string|null $connection_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Modules\DbForge\Database\Factories\DbForgeQueryLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DbForgeQueryLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DbForgeQueryLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DbForgeQueryLog query()
 * @property-read \Modules\Quaeris\Models\Profile|null $creator
 * @property-read \Modules\Quaeris\Models\Profile|null $deleter
 * @property-read \Modules\Quaeris\Models\Profile|null $updater
 * @mixin \Eloquent
 */
class DbForgeQueryLog extends BaseModel
{
    protected $table = 'dbforge_query_logs';

    /** @var list<string> */
    protected $fillable = [
        'query_sql',
        'query_bindings',
        'query_time',
        'user_id',
        'connection_name',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'query_bindings' => 'array',
            'query_time' => 'float',
            'user_id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
