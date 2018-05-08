<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Library\Service\HowOldAmIOnMars as Service;

/**
 * Class HowOldAmIOnMarsController
 * @package App\Http\Controllers\Api
 */
class HowOldAmIOnMarsController extends \App\Http\Controllers\Controller
{
    /**
     * Api point to calculate age of Mars based on a date of birth on Earth
     *
     * @param \App\Library\Service\HowOldAmIOnMars $service
     * @param string $dateOfBirth
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateMyAge(Service $service, $dateOfBirth = '')
    {
        try {
            $result = ['data' => $service->calculateMyAgeOnMars($dateOfBirth)];
            $code   = 200;
        } catch (\Exception $exception) {
            $result = ['error' => $exception->getMessage()];
            $code   = 400;
        }

        return response()->json($result, $code);
    }

    /**
     * Api point to calculate if one is allowed to drink alcohol on Mars
     * based on a date of birth on Earth
     *
     * @param \App\Library\Service\HowOldAmIOnMars $service
     * @param string $dateOfBirth
     * @return \Illuminate\Http\JsonResponse
     */
    public function amIAllowedToDrinkAlcoholOnMars(Service $service, $dateOfBirth = '')
    {
        try {
            $ageResult = $service->calculateMyAgeOnMars($dateOfBirth);

            $result = ['data' => $service->checkAlcoholAgeOnMars($ageResult['in_years'])];
            $code   = 200;
        } catch (\Exception $exception) {
            $result = ['error' => $exception->getMessage()];
            $code   = 400;
        }

        return response()->json($result, $code);
    }
}
