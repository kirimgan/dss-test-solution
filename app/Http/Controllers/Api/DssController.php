<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\DentalUsers;

class DssController extends Controller
{
    const LOGOUT_TIME = 60*60;

    /**
     * Display the specified resource.
     *
     * @param string $userid
     * @return \Illuminate\Http\Response
     */
    public function checkLogout($userId)
    {
        $dentalUsers = new DentalUsers();
        $user = $dentalUsers->getLastUserData($userId);

        $lastAccessedTimestamp = strtotime($user->last_accessed_date);
        $currentTimestamp = time();

        if ($lastAccessedTimestamp > $currentTimestamp - self::LOGOUT_TIME) {
            $resetTime = (self::LOGOUT_TIME - ($currentTimestamp - $lastAccessedTimestamp)) * 1000;

            return response()->json(array(
                'reset_time'=> $resetTime
            ));
        } else {

            return response()->json(array(
                'logout'=> true
            ));
        }
    }
}
