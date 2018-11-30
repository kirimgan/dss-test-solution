<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DentalUsers extends Model
{
    public $table = 'dental_users';
    public $guarded = ['id'];
    public $timestamps = false;
}
