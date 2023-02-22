<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $taskscon_id
 * @property int    $contract_id
 * @property int    $tasktaskcon_idcon_start_date
 * @property int    $taskcon_end_date
 * @property int    $created_at
 * @property int    $updated_at
 * @property int    $deleted_at
 * @property string $taskcon_name
 */
class Taskscon extends Model
{

    protected $table = 'taskscon';

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
        'contract_id','taskcon_name', 'taskcon_start_date', 'taskcon_end_date', 'created_at', 'updated_at', 'deleted_at',
        'taskcon_parent', 'taskcon_description', 'taskcon_budget_gov_operating', 'taskcon_budget_gov_investment', 'taskcon_budget_gov_utility', 'taskcon_budget_it_operating', 'taskcon_budget_it_investment',
    ];

 /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;



    use HasFactory;

 // Scopes...

    // Functions ...
    public function getHashidAttribute($value)
    {
        return Hashids::encode($this->getKey());
    }
    public function getProjectHashidAttribute($value)
    {
        return Hashids::encode($this->contrast_id);
    }
    // Relations ...

    public function subtaskc()
    {
        return $this->hasMany('App\Models\Taskscon', 'contract_id');
    }


    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }


    public function taskc()
    {
        return $this->belongsToMany('App\Models\contrast', 'contract_has_taskscon', 'taskcon_id', 'task_id');
    }


    public function contract()
    {
        return $this->belongsToMany('App\Models\Contract', 'contract_has_taskscon', 'taskcon_id', 'contract_id');
    }

}


