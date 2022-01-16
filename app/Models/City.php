<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'city';
    protected $primaryKey = 'idcity';

    public $fillable = [        
        'name',
        'idcountry',  
        'created_user',
        'updated_user', 
    ]; 

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function place() {
        return $this->hasMany(Place::class);
    }
}
