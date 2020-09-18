<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright  (c) 2017, Ni Irrty
 * @license        MIT
 * @since          2018-05-02
 * @version        0.1.0
 */


namespace Niirrty\Date\Tests;


use Niirrty\Date\DateIntervalBuilder;
use PHPUnit\Framework\TestCase;


class DateIntervalBuilderTest extends TestCase
{

    public function setUp()
    {

        parent::setUp();

    }

    /**
     * @throws \Exception
     */
    public function test_Init()
    {

        $interval = DateIntervalBuilder::Init()
                                           ->setYears( 2 )->setMonths( 6 )->setDays( 12 )
                                           ->setHours( 8 )->setMinutes( 27 )->setSeconds( 14 )
                                           ->toDateInterval();

        $this->assertSame( 2, $interval->y );
        $this->assertSame( 6, $interval->m );
        $this->assertSame( 12, $interval->d );
        $this->assertSame( 8, $interval->h );
        $this->assertSame( 27, $interval->i );
        $this->assertSame( 14, $interval->s );

    }


}
