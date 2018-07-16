<?php

namespace SillyDevelopment\HowOldAmIOnMars\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use SillyDevelopment\HowOldAmIOnMars\RequestsHistory;

/**
 * Class RequestsHistoryController
 * @package SillyDevelopment\HowOldAmIOnMars\Controllers
 */
class RequestsHistoryController extends \App\Http\Controllers\Controller
{
    /**
     * Get a list of requests history
     *
     * @return \Illuminate\Http\Response
     */
    public function getRequestsHistory()
    {
        /** @var \App\User $user */
        $user = auth()->user();

        $requestsHistory = RequestsHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $result = response()->view('how-old-am-i-on-mars::requests-history.history_table',
            ['requestsHistory' => $requestsHistory],
            Response::HTTP_OK
        );

        return $result;
    }
}
