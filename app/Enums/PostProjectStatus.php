<?php

namespace App\Enums;

enum PostProjectStatus: string{
     case PENDING = 'pending';
     case ACCEPTED = 'accepted';
     case REJECTED = 'rejected';
     case COMPLETED = 'completed';

     public function label() : string
     {
          return match ($this){
               self::PENDING => 'Pending',
               self::ACCEPTED => 'Accepted',
               self::REJECTED => 'Rejected',
               self::COMPLETED => 'Completed',
          };
     }

     public function statusClass() : string
     {
          return match ($this){
               self::PENDING                   => 'indigo',
               self::ACCEPTED, self::COMPLETED => 'green',
               self::REJECTED                  => 'red',
          };
     }


}