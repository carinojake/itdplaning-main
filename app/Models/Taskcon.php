<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @property int    $taskcon_id
 * @property int    $contract_id

 * @property int    $taskcon_end_date
 * @property int    $created_at
 * @property int    $updated_at
 * @property int    $deleted_at
 * @property string $taskcon_name
 */




class Taskcon extends Model
{
    protected $table = 'taskcons';

     /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'taskcon_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contract_id',
        'taskcon_name',
         'taskcon_description',
         'taskcon_parent',
         'taskcon_budget_gov_operating',
         'taskcon_budget_gov_investment',
         'taskcon_budget_gov_utility',
         'taskcon_budget_it_operating',
         'taskcon_budget_it_investment',
         'taskcon_start_date',
         'taskcon_end_date',
         'created_at',
         'updated_at',
         'deleted_at',
         'taskcon_cost_gov_operating',
         'taskcon_cost_gov_investment',
         'taskcon_cost_gov_utility',
         'taskcon_cost_it_operating',
         'taskcon_cost_it_investment',
         'taskcon_status'
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
        'taskcon_id' => 'int', 'contract_id' => 'int', 'taskcon_name' => 'string', 'taskcon_start_date' => 'timestamp', 'taskcon_end_date' => 'timestamp', 'created_at' => 'timestamp', 'updated_at' => 'timestamp', 'deleted_at' => 'timestamp',
    ];


   /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'taskcon_start_date', 'taskcon_end_date', 'created_at', 'updated_at', 'deleted_at',
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



    public function getContractHashidAttribute($value)
    {
        return Hashids::encode($this->contract_id);
    }


    public function gettaskHashidAttribute($value)
    {
        return Hashids::encode($this->task_id);
    }

    // Relations ...
    public function subtaskcon()
    {
        return $this->hasMany('App\Models\Taskcon', 'taskcon_parent');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }



    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }

    public function contract()
    {
        return $this->belongsToMany('App\Models\Contract', 'contract_has_taskcons', 'taskcon_id', 'task_id');
    }


    public function taskconsend()
    {
        return $this->belongsToMany('App\Models\Taskcon', 'task_has_taskcons', 'taskcon_id', 'task_id');
    }
}
