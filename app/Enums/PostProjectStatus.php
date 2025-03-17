<?php

namespace App\Enums;

enum PostProjectStatus: string{
     case PENDING = 'pending';
     case ACCEPTED = 'accepted';
     case REJECTED = 'rejected';

     case COMPLETED = 'completed';
}