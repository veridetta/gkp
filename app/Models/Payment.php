<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['category_id', 'residence_id','user_id', 'description', 'amount', 'date', 'month', 'year'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

    public function getAmountFormattedAttribute()
    {
        return 'Rp. ' . number_format($this->amount, 0, ',', '.');
    }
}
