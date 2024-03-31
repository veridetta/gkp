<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Cashflow extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = ['user_id', 'description', 'amount', 'date','in','out','image','type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountFormattedAttribute()
    {
        return 'Rp. ' . number_format($this->amount, 0, ',', '.');
    }
}
