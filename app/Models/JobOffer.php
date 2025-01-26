<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'budget', 'deadline'];
}

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'user_id'];
}

