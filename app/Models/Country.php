<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'country';
    protected $primaryKey = 'idcountry';

    public $fillable = [        
        'name',
        'created_user',
        'updated_user',        
    ];
    
    public function city() {
        return $this->hasMany(City::class);
    }
}
