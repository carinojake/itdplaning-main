<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int    $task_id
 * @property int    $project_id
 * @property int    $task_start_date
 * @property int    $task_end_date
 * @property int    $created_at
 * @property int    $updated_at
 * @property int    $deleted_at
 * @property string $task_name
 * @var int $taskcosttotal
 */
class Task extends Model
{
   /*  use SoftDeletes; */
    /**
     * The database table used by the model.
     *
     * @var string
     * @var int $taskcosttotal
     */
    protected $table = 'tasks';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'task_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'task_name', 'task_start_date', 'task_end_date', 'created_at', 'updated_at', 'deleted_at','task_pay','task_pay_date',
        'task_parent', 'task_description', 'task_budget_gov_operating', 'task_budget_gov_investment', 'task_budget_gov_utility', 'task_budget_it_operating', 'task_budget_it_investment',
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
        'task_id' => 'int', 'project_id' => 'int', 'task_name' => 'string', 'task_start_date' => 'timestamp', 'task_end_date' => 'timestamp', 'created_at' => 'timestamp', 'updated_at' => 'timestamp', 'deleted_at' => 'timestamp','task_pay_date' => 'timestamp',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'task_start_date', 'task_end_date', 'created_at', 'updated_at', 'deleted_at','task_pay_date',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;

    // Scopes...

    // Functions ...
    public function getHashidAttribute($value)
    {
        return Hashids::encode($this->getKey());
    }

    public function getProjectHashidAttribute($value)
    {
        return Hashids::encode($this->project_id);
    }

    // Relations ...
    public function subtask()
    {
        return $this->hasMany('App\Models\Task', 'task_parent');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }



    public function contract()
    {
        return $this->belongsToMany('App\Models\Contract', 'contract_has_tasks', 'task_id', 'contract_id');
    }



    public function taskconsend()
    {
        return $this->belongsToMany('App\Models\Taskcon', 'task_has_taskcons', 'taskcon_id', 'task_id');
    }
}
