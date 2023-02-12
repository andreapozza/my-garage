<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    use HasFactory;

    public function save(array $options = [])
    {
        // If no user has been assigned, assign the current user's id
        if (!$this->user_id && auth()) {
            $this->user_id = auth()->user()->id;
        }

        return parent::save($options);
    }
}
