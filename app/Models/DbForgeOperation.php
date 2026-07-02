<?php

declare(strict_types=1);

namespace Modules\DbForge\Models;

/**
 * DbForgeOperation model.
 *
 * @property int $id
 * @property string $operation_type
 * @property string $table_name
 * @property array<string, mixed>|null $operation_data
 * @property string $status
 * @property string|null $error_message
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @method static \Modules\DbForge\Database\Factories\DbForgeOperationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DbForgeOperation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DbForgeOperation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DbForgeOperation query()
 * @mixin \Eloquent
 */
class DbForgeOperation extends BaseModel
{
    protected $table = 'dbforge_operations';

    /** @var list<string> */
    protected $fillable = [
        'operation_type',
        'table_name',
        'operation_data',
        'status',
        'error_message',
        'created_by',
        'completed_at',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'operation_data' => 'array',
            'created_by' => 'integer',
            'completed_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
