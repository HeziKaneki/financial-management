<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyAuto extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'monthly_income', 'monthly_expense'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
