<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Increasedbudget extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'increasedbudgets';
    protected $primaryKey = 'increased_budget_id';



}
