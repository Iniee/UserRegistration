<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait CodeTrait
{
    public function codeGenerator($length = 6)
    {
       return Str::padLeft(random_int(0, 999), 4, '0');
    }
}