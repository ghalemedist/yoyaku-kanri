<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Yoyakujikan;

class Yoyakubi extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'date', 
        'description', 
        'is_active', 
        'is_display'
    ];
   
    public function yoyakujikan()
    {
        return $this->hasMany(Yoyakujikan::class);
    }

}
