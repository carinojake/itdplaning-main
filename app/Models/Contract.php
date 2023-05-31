<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @property int    $contract_id
 * @property int    $contract_number
 * @property int    $created_at
 * @property int    $updated_at
 * @property int    $deleted_at
 * @property int    $contract_pr_budget
 * @property int    $contract_pa_budget
 *
 * @property string $contract_name
 * @property string $contract_year
 * @property string $contract_description
 * @property string $contract_type
 * @property string $contract_status
 * @property string $contract_projectplan
 * @property string $contract_mm
 * @property string $contract_pr
 * @property string $contract_pa

 *
 */
class Contract extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contracts';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'contract_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contract_name', 'contract_number', 'contract_year',
        'contract_description', 'contract_type', 'contract_status',
        'contract_start_date', 'contract_end_date', 'created_at', 'updated_at', 'deleted_at',
        'contract_owner','contract_refund_pa_budget','contract_refund_pa_status','contract_peryear_pa_budget',
        'contract_projectplan', 'contract_mm', 'contract_pr', 'contract_pa', 'contract_pr_budget', 'contract_pa_butget',

              // เพิ่มฟิลด์ใหม่ที่นี่

              'mm_butget',
              // ฟิลด์อื่น ๆ ที่มีอยู่
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'contract_id' => 'int',
        'contract_name' => 'string',
        'contract_number' => 'string',
        'contract_year' => 'string',
        'contract_description' => 'string',
        'contract_type' => 'string',
        'contract_status' => 'string',
        'contract_start_date' => 'timestamp',
        'contract_end_date' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'contract_sign_date' => 'timestamp',
        'contract_projectplan' =>'string',
        'contract_mm' =>'string',
        'contract_pr' =>'string',
        'contract_pa' =>'string',



    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'contract_start_date', 'contract_end_date', 'created_at', 'updated_at', 'deleted_at', 'contract_sign_date',
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

    // Relations ...
    public function taskcont()
    {
        return $this->belongsToMany('App\Models\Task', 'contract_has_tasks', 'contract_id', 'task_id');
    }
    public function contract()
    {
        return $this->belongsToMany('App\Models\Taskcon', 'contract_has_taskscon', 'taskcon_id', 'task_id');
    }
    //public function taskcon()
    //{
      //  return $this->hasMany('App\Models\Taskcon', 'contract_id');
    //}


    public function taskcon()
    {
        return $this->hasMany('App\Models\Taskcon', 'contract_id');
    }
    public function main_taskcon()
    {
        return $this->taskcon()->whereNull('taskcon_parent');
    }

    public function task()
    {
        // return $this->hasMany('App\Models\ContractHasTask', 'project_id');
        return $this->hasManyThrough(
            'App\Models\ContractHasTaskcon',
            'App\Models\Taskcon',
            'contract_id',
            'taskcon_id',
            'contract_id',
            'taskcon_id',
        );
    }


        // Relations ...


        public function main_task()
        {
            return $this->task()->whereNull('task_parent');
        }

        public function main_task_with_project($task_parent)
        {
            return $this->main_task()->join('projects', 'tasks.project_id', '=', 'projects.project_id')->where('tasks.task_parent', $task_parent)->select('tasks.*', 'projects.project_id as project_project_id')->get();
        }


}
