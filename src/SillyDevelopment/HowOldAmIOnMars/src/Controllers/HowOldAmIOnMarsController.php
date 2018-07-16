<?php

namespace SillyDevelopment\HowOldAmIOnMars\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use SillyDevelopment\HowOldAmIOnMars\Service\HowOldAmIOnMars;
use SillyDevelopment\HowOldAmIOnMars\RequestsHistory;

/**
 * Class HowOldAmIOnMarsController
 * @package SillyDevelopment\HowOldAmIOnMars\Controllers
 */
class HowOldAmIOnMarsController extends \App\Http\Controllers\Controller
{
    /**
     * Calculate age based on birthday from an authorised user birthday
     *
     * @param \SillyDevelopment\HowOldAmIOnMars\Service\HowOldAmIOnMars $howOldAmIOnMarsService
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAge(HowOldAmIOnMars $howOldAmIOnMarsService, Request $request)
    {
        try {
            /** @var \App\User $user */
            $user = auth()->user();

            $calculationResult = $howOldAmIOnMarsService->calculateMyAgeOnMars($user->facebook_birthday);
        } catch (\Exception $exception) {
            $result = response()->view('how-old-am-i-on-mars::mars.check_age',
                ['error' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST);

            return $result;
        }

        $this->createRequestHistory($user->id, $user->facebook_birthday);

        $result = response()->view('how-old-am-i-on-mars::mars.check_age',
            [
                'myAgeOnMars' => [
                    'birthday' => $user->facebook_birthday,
                    'in_days'  => $calculationResult['in_days'],
                    'in_years' => $calculationResult['in_years']
                ]
            ],
            Response::HTTP_OK);

        return $result;
    }

    /**
     * Calculate age based on birthday from a post request
     *
     * @param \SillyDevelopment\HowOldAmIOnMars\Service\HowOldAmIOnMars $howOldAmIOnMarsService
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postAge(HowOldAmIOnMars $howOldAmIOnMarsService, Request $request)
    {
        try {
            /** @var \App\User $user */
            $user = auth()->user();

            $birthday = $request->get('birthday');

            $calculationResult = $howOldAmIOnMarsService->calculateMyAgeOnMars($birthday);
        } catch (\Exception $exception) {
            $result = response()->view('how-old-am-i-on-mars::mars.check_age',
                ['error' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST);

            return $result;
        }

        $this->createRequestHistory($user->id, $birthday);

        $result = response()->view('how-old-am-i-on-mars::mars.check_age',
            [
                'myAgeOnMars' => [
                    'birthday' => $birthday,
                    'in_days'  => $calculationResult['in_days'],
                    'in_years' => $calculationResult['in_years']
                ]
            ],
            Response::HTTP_OK);

        return $result;
    }

    /**
     * Create a request history
     *
     * @param int $userId
     * @param string $birthday
     */
    private function createRequestHistory($userId, $birthday)
    {
        RequestsHistory::create([
            'user_id'  => $userId,
            'birthday' => $birthday,
        ]);
    }
}
