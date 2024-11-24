<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['user_id', 'name', 'description'];

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_category');
    }
}
