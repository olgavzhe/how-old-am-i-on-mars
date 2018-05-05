<?php

namespace App\Library\Service;

/**
 * Class HowOldAmIOnMars
 * @package App\Library\Service
 */
class HowOldAmIOnMars
{
    /**
     * Earth day in seconds
     * 24h
     * 24*3600 = 86400 sec
     */
    const EARTH_CONFIG_DAY_LENGTH = 86400;
    /**
     * Mars day in seconds
     * 24h 37 min
     * 24*3600 + 37*60 = 88620 sec
     *
     * 24h 40 min
     * 24*3600 + 40*60 = 88800 sec
     *
     * Earth day: 24 hours, 39 minutes, and 35.244 seconds
     * 24*3600 + 39*60 + 35 = 88775
     *
     * 88992
     */
    const MARS_CONFIG_DAY_LENGTH = 88992;
    /**
     * Mars year in Earth days
     */
    const MARS_CONFIG_YEAR_LENGTH_IN_EARTH_DAYS = 687;
    /**
     * Mars year in Mars days
     */
    const MARS_CONFIG_YEAR_LENGTH_IN_MARS_DAYS = 668;

    /**
     * Get Earth day length in seconds
     * @return int
     */
    protected function getEarthDayLength()
    {
        return self::EARTH_CONFIG_DAY_LENGTH;
    }

    /**
     * Get Mars day length in seconds
     *
     * @return int
     */
    protected function getMarsDayLength()
    {
        return self::MARS_CONFIG_DAY_LENGTH;
    }

    /**
     * Get Mars year length in days
     *
     * @return int
     */
    protected function getMarsYearLengthInEarthDays()
    {
        return self::MARS_CONFIG_YEAR_LENGTH_IN_EARTH_DAYS;
    }

    /**
     * @param string $datetime
     * @return int
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    protected function getDiffInSeconds($datetime = '')
    {
        if (is_string($datetime) === false || empty($datetime) === true) {
            throw new \InvalidArgumentException("Wrong date time string format.");
        }

        $now      = $this->getNowDatetime();
        $pastDate = new \DateTime($datetime);

        $result = $now->getTimestamp() - $pastDate->getTimestamp();

        if ($result < 0) {
            throw new \Exception("Date is in a future");
        }

        return $result;
    }

    /**
     * @param string $datetime
     * @return int
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    protected function getDiffInDays($datetime = '')
    {
        if (is_string($datetime) === false || empty($datetime) === true) {
            throw new \InvalidArgumentException("Wrong date time string format.");
        }

        $now      = $this->getNowDatetime();
        $pastDate = new \DateTime($datetime);

        $result = $pastDate->diff($now)->days;
        if ($result < 0) {
            throw new \Exception("Date is in a future");
        }

        return $result;
    }

    /**
     * Get current datetime
     *
     * @return \DateTime
     */
    protected function getNowDatetime()
    {
        return new \DateTime();
    }

    /**
     * Converts Earth days into whole Mars days
     *
     * @param int $days
     * @return int
     */
    public function convertEarthDaysInMarsDays($days = 0)
    {
        $result = 0;

        if (empty($days) === true
            || is_numeric($days) === false
            || (is_numeric($days) === true && $days < 0)
        ) {
            return $result;
        }

        $days               = intval($days);
        $earthDaysInSeconds = $this->getEarthDayLength() * $days;
        $marsDayInSeconds   = $this->getMarsDayLength();

        $result = ($earthDaysInSeconds - $earthDaysInSeconds % $marsDayInSeconds) / $marsDayInSeconds;

        return $result;
    }

    /**
     * Converts seconds into whole Mars days
     *
     * @param int $seconds
     * @return int
     */
    public function convertSecondsToMarsDays($seconds = 0)
    {
        $result = 0;

        if (empty($seconds) === true
            || is_numeric($seconds) === false
            || (is_numeric($seconds) === true && $seconds < 0)
        ) {
            return $result;
        }

        $marsDayLength = $this->getMarsDayLength();

        $result = ($seconds - $seconds % $marsDayLength) / $marsDayLength;

        return intval($result);
    }

    /**
     * Calculates Mars years from Earth days
     *
     * @param int $earthDays
     * @return int
     */
    public function getMarsYearsFromEarthDays($earthDays = 0)
    {
        $result = 0;

        if (empty($earthDays) === true
            || is_numeric($earthDays) === false
            || (is_numeric($earthDays) === true && $earthDays < 0)
        ) {
            return $result;
        }

        $earthDays      = intval($earthDays);
        $marsYearLength = $this->getMarsYearLengthInEarthDays();

        $result = ($earthDays - $earthDays % $marsYearLength) / $marsYearLength;

        return $result;
    }

    /**
     * Get age in Mars days, years
     *
     * @param string $dayOfBirthOnEarth
     * @return array
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function calculateMyAgeOnMars($dayOfBirthOnEarth = '')
    {
        $result = [];

        if (empty($dayOfBirthOnEarth) === true) {
            throw new \InvalidArgumentException("Day of birth is empty");
        }

        $secondsOnEarth = $this->getDiffInSeconds($dayOfBirthOnEarth);
        $daysOnEarth    = $this->getDiffInDays($dayOfBirthOnEarth);

        $marsDays  = $this->convertSecondsToMarsDays($secondsOnEarth);
        $marsYears = $this->getMarsYearsFromEarthDays($daysOnEarth);

        $result = [
            'in_days'  => $marsDays,
            'in_years' => $marsYears,
        ];

        return $result;
    }
}