<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DentalUsers extends Model
{
    public $table = 'dental_users';
    public $guarded = ['id'];
    public $timestamps = false;

    public function getLastUserData($userId)
    {
        return $this::where('userid', $userId)->first();
    }
}
