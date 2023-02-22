<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @property int    $task_id
 * @property int    $project_id
 * @property int    $task_start_date
 * @property int    $task_end_date
 * @property int    $created_at
 * @property int    $updated_at
 * @property int    $deleted_at
 * @property string $task_name
 */
class ContractHasTask extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contract_has_tasks';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contract_id',
        'task_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'contract' => 'int',
        'task_id'  => 'int',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [

    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    // Scopes...

    // Functions ...
    public function getHashidAttribute($value)
    {
        return Hashids::encode($this->getKey());
    }

    // Relations ...
    public function contract()
    {
        return $this->hasMany('App\Models\Contract');
    }
    public function task()
    {
        return $this->hasMany('App\Models\Task');
    }

}
