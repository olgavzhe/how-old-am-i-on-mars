<?php

namespace SillyDevelopment\HowOldAmIOnMars\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SillyDevelopment\HowOldAmIOnMars\LoginHistory;

/**
 * Class LoginHistoryController
 * @package SillyDevelopment\HowOldAmIOnMars\Controllers
 */
class LoginHistoryController extends \App\Http\Controllers\Controller
{
    /**
     * Get a list of login history
     *
     * @return \Illuminate\Http\Response
     */
    public function getLoginHistory()
    {
        /** @var \App\User $user */
        $user = auth()->user();

        $requestsHistory = LoginHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $result = response()->view('facebook::login-history.history_table',
            ['loginHistory' => $requestsHistory],
            Response::HTTP_OK
        );

        return $result;
    }
}
