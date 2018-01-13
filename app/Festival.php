<?php

namespace App;

class Festival extends Model
{
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function getImageAttribute($value)
    {
        return asset('storage/festivals') . '/' . $value;
    }
}
