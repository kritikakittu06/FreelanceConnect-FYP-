<?php

namespace App\Enums;

enum UserRole: string{
     case ADMIN = 'admin';
     case FREELANCER = 'freelancer';
     case CLIENT = 'client';
}