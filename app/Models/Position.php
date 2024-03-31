<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Position extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(PositionUser::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function positionUsers()
    {
        return $this->hasMany(PositionUser::class);
    }

}
