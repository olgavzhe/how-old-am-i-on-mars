<?php

namespace Tests\Unit;

use App\Library\Service\HowOldAmIOnMars;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HowOldAmIOnMarsTest extends TestCase
{
    /**
     * @var HowOldAmIOnMars
     */
    protected $service;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->service = new HowOldAmIOnMars();
        $this->service = $this->getMockBuilder(HowOldAmIOnMars::class)
            ->setMethods(['getNowDatetime'])
            ->getMock();
    }

    /**
     * @covers \App\Library\Service\HowOldAmIOnMars::convertEarthDaysInMarsDays
     *
     * @group Service
     * @small
     */
    public function test_ConvertEarthDaysInMarsDays()
    {
        /**
         * Normal tests
         */
        $marsDays = $this->service->convertEarthDaysInMarsDays(1);
        $this->assertEquals(0, $marsDays);

        $marsDays = $this->service->convertEarthDaysInMarsDays(2);
        $this->assertEquals(1, $marsDays);

        $marsDays = $this->service->convertEarthDaysInMarsDays(56.4);
        $this->assertEquals(54, $marsDays);

        $marsDays = $this->service->convertEarthDaysInMarsDays('3');
        $this->assertEquals(2, $marsDays);

        /**
         * Wrong arguments
         */
        $marsDays = $this->service->convertEarthDaysInMarsDays(null);
        $this->assertEquals(0, $marsDays);

        $marsDays = $this->service->convertEarthDaysInMarsDays('');
        $this->assertEquals(0, $marsDays);

        $marsDays = $this->service->convertEarthDaysInMarsDays(-3);
        $this->assertEquals(0, $marsDays);
    }

    /**
     * @covers \App\Library\Service\HowOldAmIOnMars::getMarsYearsFromEarthDays()
     *
     * @group Service
     * @small
     */
    public function test_GetMarsYearsFromMarsDays()
    {
        /**
         * Normal tests
         */
        $marsYears = $this->service->getMarsYearsFromEarthDays(1);
        $this->assertEquals(0, $marsYears);

        $marsYears = $this->service->getMarsYearsFromEarthDays(2);
        $this->assertEquals(0, $marsYears);

        $marsYears = $this->service->getMarsYearsFromEarthDays(687);
        $this->assertEquals(1, $marsYears);

        $marsYears = $this->service->getMarsYearsFromEarthDays(978.4);
        $this->assertEquals(1, $marsYears);

        $marsYears = $this->service->getMarsYearsFromEarthDays('34567');
        $this->assertEquals(50, $marsYears);

        /**
         * Wrong arguments
         */
        $marsYears = $this->service->getMarsYearsFromEarthDays(null);
        $this->assertEquals(0, $marsYears);

        $marsYears = $this->service->getMarsYearsFromEarthDays('');
        $this->assertEquals(0, $marsYears);

        $marsYears = $this->service->getMarsYearsFromEarthDays(-45);
        $this->assertEquals(0, $marsYears);
    }

    /**
     * @covers \App\Library\Service\HowOldAmIOnMars::calculateMyAgeOnMars
     *
     * @group Service
     * @small
     */
    public function test_CalculateMyAgeOnMars_Normal()
    {
        /**
         * Normal tests
         */
        $this->service->expects($this->atLeastOnce())
            ->method('getNowDatetime')
            ->will($this->returnValue(new \DateTime('2018-05-05 18:00:00')));
        /**
         * 1988-02-02 00:00:00
         * 2018-05-05 18:00:00
         *
         * 954720000 seconds
         * 11050 days
         */
        $expectedResult = [
            'in_days'  => 10728,
            'in_years' => 16
        ];
        $result         = $this->service->calculateMyAgeOnMars('1988-02-02');
        $this->assertEquals($expectedResult, $result);

        /**
         * 1984-01-31 00:00:00
         * 2018-05-05 18:00:00
         *
         * 1081123200 seconds
         * 12513 days
         */
        $expectedResult = [
            'in_days'  => 12149,
            'in_years' => 18
        ];
        $result         = $this->service->calculateMyAgeOnMars('1984-01-31');
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers \App\Library\Service\HowOldAmIOnMars::calculateMyAgeOnMars
     *
     * @expectedException \Exception
     *
     * @group Service
     * @small
     */
    public function test_CalculateMyAgeOnMars_Exception()
    {
        $this->service->expects($this->once())
            ->method('getNowDatetime')
            ->will($this->returnValue(new \DateTime('2018-05-05 18:00:00')));
        $this->service->calculateMyAgeOnMars('some string');
    }

    /**
     * @covers \App\Library\Service\HowOldAmIOnMars::calculateMyAgeOnMars
     *
     * @expectedException \InvalidArgumentException
     *
     * @group Service
     * @small
     */
    public function test_CalculateMyAgeOnMars_InvalidArgumentException()
    {
        $this->service->expects($this->never())
            ->method('getNowDatetime')
            ->will($this->returnValue(new \DateTime('2018-05-05 18:00:00')));

        $this->service->calculateMyAgeOnMars(19880202);
    }

    /**
     * @covers \App\Library\Service\HowOldAmIOnMars::convertSecondsToMarsDays
     *
     * @group Service
     * @small
     */
    public function test_ConvertSecondsToMarsDays()
    {
        /**
         * Normal tests
         */
        $marsDays = $this->service->convertSecondsToMarsDays(1);
        $this->assertEquals(0, $marsDays);

        $marsDays = $this->service->convertSecondsToMarsDays(954776381);
        $this->assertEquals(10728, $marsDays);

        $marsDays = $this->service->convertSecondsToMarsDays('954776381.67');
        $this->assertEquals(10728, $marsDays);

        /**
         * Wrong arguments
         */
        $marsDays = $this->service->convertSecondsToMarsDays(null);
        $this->assertEquals(0, $marsDays);

        $marsDays = $this->service->convertSecondsToMarsDays('');
        $this->assertEquals(0, $marsDays);

        $marsDays = $this->service->convertSecondsToMarsDays(-3);
        $this->assertEquals(0, $marsDays);
    }
}
