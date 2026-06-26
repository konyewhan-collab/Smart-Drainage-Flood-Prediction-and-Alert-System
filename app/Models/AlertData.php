<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AlertData extends Model {
    protected $table = 'alert_data'; 
    protected $primaryKey = 'alert_id';
    protected $guarded = []; 
}