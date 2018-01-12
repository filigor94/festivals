<?php

namespace App;

class Festival extends Model
{
    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
