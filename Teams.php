<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'team_id',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
    public function pokemon()
    {
        return $this->belongsToMany(Pokemon::class, 'team_pokemon');
    }
}
