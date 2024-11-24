<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'amount', 'type', 'source', 'destination'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'transaction_category');
    }
}
