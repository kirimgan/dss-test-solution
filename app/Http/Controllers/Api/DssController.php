<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\DentalUsers;

class DssController extends Controller
{
    const LOGOUT_TIME = 60*60;

    protected $users;

    public function __construct(DentalUsers $users)
    {
        $this->users = $users;
    }

    /**
     * Display the specified resource.
     *
     * @param string $userid
     * @return \Illuminate\Http\Response
     */
    public function checkLogout($userId)
    {
        $user = $this->users->getLastUserData($userId);

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
