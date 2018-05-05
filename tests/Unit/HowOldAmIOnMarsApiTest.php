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
    public function test_19880202_Success()
    {
        $this->json('GET', 'api/mymarsage/19880202')
            ->assertStatus(200)
            ->assertExactJson([
                'data' => [
                    'in_days'  => 10728,
                    'in_years' => 16,
                ],
            ]);
    }

    /**
     * @covers \App\Http\Controllers\Api\HowOldAmIOnMarsController::calculateMyAge
     *
     * @group Api
     */
    public function test_Fail_WrongArguments()
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
}
