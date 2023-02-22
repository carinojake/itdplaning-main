<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int    $regular_id
 * @property int    $regular_name
 * @property int    $regular_description
 * @property int    $created_at
 * @property int    $updated_at
 * @property int    $deleted_at

 */
class Regular extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'regular';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'regular_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regular_name', 'regular_description', 'craeted_at', 'updated_at',
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
        'regular_id'    => 'int', 'regular_name' => 'string', 'regular_description' => 'string'
        //'budget_gov_operating' => 'decimal', 'budget_gov_investment' => 'decimal', 'budget_gov_utility' => 'decimal', 'budget_it_operating' => 'decimal', 'budget_it_investment' => 'decimal', 'project_cost' => 'decimal',
        , 'craeted_at'   => 'timestamp', 'updated_at'       => 'timestamp',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
         'craeted_at', 'updated_at',
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
  //  public function task()
   // {
     //   return $this->hasMany('App\Models\Task', 'project_id');
    //}
    //public function main_task()
    //{
      //  return $this->task()->whereNull('task_parent');
    //}

    //public function contract()
    //{
        // return $this->hasMany('App\Models\ContractHasTask', 'project_id');
      //  return $this->hasManyThrough(
        //    'App\Models\ContractHasTask',
          //  'App\Models\Task',
            //'project_id',
            //'task_id',
            //'project_id',
            //'task_id',
       // );
   // }

    use HasFactory;
}
