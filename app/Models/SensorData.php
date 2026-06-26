<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model {
    protected $table = 'sensor_data'; // Matches your ERD
    protected $primaryKey = 'sensor_id';
    protected $guarded = []; 
}