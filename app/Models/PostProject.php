<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PostProject extends Model
{
    protected $fillable = ['freelancer_id', 'project_name', 'project_description', 'budget', 'deadline'];

    public function freelancer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }
}

