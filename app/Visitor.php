<?php

namespace App;

class Visitor extends Model
{
    public function festivals()
    {
        return $this->belongsToMany(Festival::class);
    }
}
