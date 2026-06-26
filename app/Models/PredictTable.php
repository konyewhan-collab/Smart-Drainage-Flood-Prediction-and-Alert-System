<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PredictTable extends Model {
    protected $table = 'predict_table'; // Matches your ERD
    protected $primaryKey = 'predict_id';
    protected $guarded = []; 
}