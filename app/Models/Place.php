<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $table = 'place';
    protected $primaryKey = 'idplace';

    public $fillable = [        
        'name',
        'idcity',  
        'created_user',
        'updated_user', 
    ]; 

    public function city() {
        return $this->belongsTo(City::class);
    }
    
}
