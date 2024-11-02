<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'is_freemoney'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
