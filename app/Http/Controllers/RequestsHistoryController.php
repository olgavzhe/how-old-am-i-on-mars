<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use App\RequestsHistory;

/**
 * Class RequestsHistoryController
 * @package App\Http\Controllers
 */
class RequestsHistoryController extends Controller
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

        $result = response()->view('requests-history.history_table',
            ['requestsHistory' => $requestsHistory],
            Response::HTTP_OK
        );

        return $result;
    }
}
