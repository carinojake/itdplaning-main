<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @property int    $id
 * @property int    $type
 * @property int    $start_date
 * @property int    $end_date
 * @property int    $budget_gov_operating
 * @property int    $budget_gov_investment
 * @property int    $budget_gov_utility
 * @property int    $budget_it_operating
 * @property int    $budget_it_investment
 * @property int    $cost
 * @property int    $owner
 * @property int    $craeted_at
 * @property int    $updated_at
 * @property string $name
 * @property string $description
 * @property int    $reguiar_id
 */
class Project extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'project_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
     'project_fiscal_year' , 'reguiar_id' , 'project_name', 'project_description', 'project_type', 'project_start_date', 'project_end_date', 'budget_gov_operating', 'budget_gov_investment', 'budget_gov_utility', 'budget_it_operating', 'budget_it_investment', 'project_cost', 'project_owner', 'craeted_at', 'updated_at',
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
       'reguiar_id'    => 'int', 'project_id'    => 'int', 'project_name' => 'string', 'project_description' => 'string', 'project_type' => 'int', 'project_start_date' => 'timestamp', 'project_end_date' => 'timestamp',
        //'budget_gov_operating' => 'decimal', 'budget_gov_investment' => 'decimal', 'budget_gov_utility' => 'decimal', 'budget_it_operating' => 'decimal', 'budget_it_investment' => 'decimal', 'project_cost' => 'decimal',
        'project_owner' => 'int', 'craeted_at'   => 'timestamp', 'updated_at'       => 'timestamp',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'project_start_date', 'project_end_date', 'craeted_at', 'updated_at',
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
    public function task()
    {
        return $this->hasMany('App\Models\Task', 'project_id');
    }
    public function main_task()
    {
        return $this->task()->whereNull('task_parent');
    }

    public function contract()
    {
        // return $this->hasMany('App\Models\ContractHasTask', 'project_id');
        return $this->hasManyThrough(
            'App\Models\ContractHasTask',
            'App\Models\Task',
            'project_id',
            'task_id',
            'project_id',
            'task_id',
        );
    }
}
