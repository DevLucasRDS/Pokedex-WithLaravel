<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['team_name', 'trainer_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'pokemon_team', 'team_id', 'pokemon_id')
            ->withPivot('slot')
            ->withTimestamps();
    }
}
