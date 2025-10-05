<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillables=[
        'user_id',
        'title',
        'description'
    ];

      public function user()
    {
        return $this->belongsTo(User::class);
    }
}
