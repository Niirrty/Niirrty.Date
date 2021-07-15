<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright      © 2020-2021, Niirrty
 * @package        Niirrty\Date
 * @since          2020-09-18
 * @version        0.4.0
 */


declare( strict_types = 1 );


namespace Niirrty\Date;


/**
 * A helping Class to build a DateInterval by separate values.
 *
 * usage:
 *
 * <code>
 * $interval = DateIntervalBuilder::Init()
 *     ->setDays( 4 )
 *     ->setHours( 12 )
 *     ->toDateInterval();
 * </code>
 *
 * @package Niirrty\Date
 */
class DateIntervalBuilder
{

    private int $_years  = 0;
    private int $_months = 0;
    private int $_days   = 0;
    private int $_hours = 0;
    private int $_minutes = 0;
    private int $_seconds = 0;

    public function __construct() { }

    public static function Init() : DateIntervalBuilder
    {

        return new self();

    }

    /**
     * @param int $years
     *
     * @return DateIntervalBuilder
     */
    public function setYears( int $years ): DateIntervalBuilder
    {

        $this->_years = $years;

        return $this;

    }

    /**
     * @param int $months
     *
     * @return DateIntervalBuilder
     */
    public function setMonths( int $months ): DateIntervalBuilder
    {

        $this->_months = $months;

        return $this;

    }

    /**
     * @param int $days
     *
     * @return DateIntervalBuilder
     */
    public function setDays( int $days ): DateIntervalBuilder
    {

        $this->_days = $days;

        return $this;

    }

    /**
     * @param int $years
     * @param int $months
     * @param int $days
     * @return DateIntervalBuilder
     */
    public function setDateParts(  int $years = 0, int $months = 0, int $days = 0 ): DateIntervalBuilder
    {

        $this->_years  = $years;
        $this->_months = $months;
        $this->_days   = $days;

        return $this;

    }

    /**
     * @param int $hours
     *
     * @return DateIntervalBuilder
     */
    public function setHours( int $hours ): DateIntervalBuilder
    {

        $this->_hours = $hours;

        return $this;

    }

    /**
     * @param int $minutes
     *
     * @return DateIntervalBuilder
     */
    public function setMinutes( int $minutes ): DateIntervalBuilder
    {

        $this->_minutes = $minutes;

        return $this;

    }

    /**
     * @param int $seconds
     *
     * @return DateIntervalBuilder
     */
    public function setSeconds( int $seconds ): DateIntervalBuilder
    {

        $this->_seconds = $seconds;

        return $this;

    }

    /**
     * @param int $hours
     * @param int $minutes
     * @param int $seconds
     * @return DateIntervalBuilder
     */
    public function setTimeParts(  int $hours = 0, int $minutes = 0, int $seconds = 0 ): DateIntervalBuilder
    {

        $this->_hours   = $hours;
        $this->_minutes = $minutes;
        $this->_seconds = $seconds;

        return $this;

    }

    /**
     * @param bool $invert Inverts the Interval to a negative Timespan
     *
     * @return \DateInterval
     * @throws \Exception
     */
    public function toDateInterval( bool $invert = false ) : \DateInterval
    {

        $format = 'P';

        if ( 0 !== $this->_years ) { $format .= \abs( $this->_years ) . 'Y'; }
        if ( 0 !== $this->_months ) { $format .= \abs( $this->_months ) . 'M'; }
        if ( 0 !== $this->_days ) { $format .= \abs( $this->_days ) . 'D'; }
        $hasTimePart = false;
        if ( 0 !== $this->_hours ) { $format .= 'T' . \abs( $this->_hours ) . 'H'; $hasTimePart = true; }
        if ( 0 !== $this->_minutes ) {
            $format .= ( $hasTimePart ? '' : 'T' ) . \abs( $this->_minutes ) . 'M';
            $hasTimePart = true; }
        if ( 0 !== $this->_seconds ) { $format .= ( $hasTimePart ? '' : 'T' ) . \abs( $this->_seconds ) . 'S'; }

        $interval = new \DateInterval( $format );

        if ( $invert ) { $interval->invert = 1; }

        return $interval;

    }


}

