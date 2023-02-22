<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @property int    $taskcon_id
 * @property int    $contract_id
 * @property int    $taskcon_start_date
 * @property int    $taskcon_end_date
 * @property int    $created_at
 * @property int    $updated_at
 * @property int    $deleted_at
 * @property string $taskcon_name
 */
class ContractHasTaskcon extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contract_has_taskscon';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id',
        'taskcon_id',
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
        'task' => 'int',
        'taskcon_id'  => 'int',
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

    public function taskcon()
    {
        return $this->hasMany('App\Models\Taskcon');
    }

}
