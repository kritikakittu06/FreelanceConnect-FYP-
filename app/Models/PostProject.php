<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PostProject extends Model
{
    protected $fillable = ['freelancer_id', 'project_name', 'project_description'];

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }
}

