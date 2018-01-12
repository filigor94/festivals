<?php

namespace App;

class Address extends Model
{
    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }
}
