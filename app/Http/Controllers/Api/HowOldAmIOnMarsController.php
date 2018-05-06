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
    public function calculateMyAge(Service $service, $dateOfBirth = '')
    {
        try {
            $result = ['data' => $service->calculateMyAgeOnMars($dateOfBirth)];
            $code   = 200;
        } catch (\Exception $exception) {
            $result = ['error' => $exception->getMessage()];
            $code   = 200;
        }

        return response()->json($result, $code);
    }

    public function amIAllowedToDrinkAlcoholOnMars(Service $service, $dateOfBirth = '')
    {
        try {
            $ageResult = $service->calculateMyAgeOnMars($dateOfBirth);

            $result = ['data' => $service->checkAlcoholAgeOnMars($ageResult['in_years'])];
            $code   = 200;
        } catch (\Exception $exception) {
            $result = ['error' => $exception->getMessage()];
            $code   = 200;
        }

        return response()->json($result, $code);
    }
}
