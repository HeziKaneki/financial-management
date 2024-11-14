<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monthly extends Model
{
    protected $fillable = [
        'fund_id',
        'amount',
    ];

    public function fund() {
        return $this->belongsTo(Fund::class);
    }
}
