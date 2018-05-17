<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\LoginHistory;

/**
 * Class LoginHistoryController
 * @package App\Http\Controllers
 */
class LoginHistoryController extends Controller
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

        $result = response()->view('login-history.history_table',
            ['loginHistory' => $requestsHistory],
            Response::HTTP_OK
        );

        return $result;
    }
}
