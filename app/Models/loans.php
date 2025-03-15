<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loans extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'user_id', 'loan_date', 'return_date', 'status'];

    public function books()
    {
        return $this->belongsTo(books::class);
    }

    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}