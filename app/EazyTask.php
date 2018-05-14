<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $task_type_id
 * @property string $name
 * @property string $description
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 * @property EazyTaskType $eazyTaskType
 */
class EazyTask extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['task_type_id', 'name', 'description', 'date', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eazyTaskType()
    {
        return $this->belongsTo('App\EazyTaskType', 'task_type_id');
    }
}
