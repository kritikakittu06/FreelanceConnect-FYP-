<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
     protected $fillable = [
          'transaction_id',
          'paid_by',
          'paid_to',
          'post_project_id',
          'amount',
     ];
}
