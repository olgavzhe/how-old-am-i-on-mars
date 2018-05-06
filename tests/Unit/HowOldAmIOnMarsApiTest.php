<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HowOldAmIOnMarsApiTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\Api\HowOldAmIOnMarsController::calculateMyAge
     *
     * @group Api
     */
    public function test_MyMarsAge_19880202_Success()
    {
        $this->json('GET', 'api/mymarsage/19880202')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'in_days',
                    'in_years',
                ],
            ]);
    }

    /**
     * @covers \App\Http\Controllers\Api\HowOldAmIOnMarsController::calculateMyAge
     *
     * @group Api
     */
    public function test_MyMarsAge_Fail_WrongArguments()
    {
        /**
         * Wrong argument
         */
        $this->json('GET', 'api/mymarsage/somestring')
            ->assertStatus(200)
            ->assertJsonStructure(['error']);

        /**
         * Empty date of birth
         */
        $this->json('GET', 'api/mymarsage/')
            ->assertStatus(200)
            ->assertJsonStructure(['error']);

        /**
         * Future date
         */
        $this->json('GET', 'api/mymarsage/20300303')
            ->assertStatus(200)
            ->assertJsonStructure(['error']);
    }

    /**
     * @covers \App\Http\Controllers\Api\HowOldAmIOnMarsController::amIAllowedToDrinkAlcoholOnMars
     *
     * @group Api
     */
    public function test_AmIAllowedToDrinkAlcoholOnMars_19840101_Success()
    {
        $this->json('GET', 'api/amIAllowedToDrinkAlcoholOnMars/19840101')
            ->assertStatus(200)
            ->assertExactJson([
                'data' => true,
            ]);
    }
}
