<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Residence extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['name',  'phone', 'sex', 'block', 'home_number', 'user_id'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
