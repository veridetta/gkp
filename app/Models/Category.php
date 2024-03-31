<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'description', 'amount','type'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getAmountFormattedAttribute()
    {
        return 'Rp. ' . number_format($this->amount, 0, ',', '.');
    }
}
