<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright  (c) 2017, Ni Irrty
 * @license        MIT
 * @since          2018-05-02
 * @version        0.1.0
 */


namespace Niirrty\Date\Tests;


use Mockery\Matcher\NoArgs;
use Niirrty\ArgumentException;
use Niirrty\Date\DateTime;
use Niirrty\Date\Time;
use Niirrty\Date\TimeFormat;
use PHPUnit\Framework\TestCase;


class TimeTest extends TestCase
{


    /**
     * @type \Niirrty\Date\Time
     */
    private $timeMorning;

    /**
     * @type \Niirrty\Date\Time
     */
    private $timeLunch;

    /**
     * @type \Niirrty\Date\Time
     */
    private $timeEvening;

    /**
     * @type \Niirrty\Date\Time
     */
    private $timeNight;

    public function setUp() : void
    {

        $this->timeMorning = new Time( 5, 19, 52 );
        $this->timeLunch = new Time( 11, 54, 33 );
        $this->timeEvening = new Time( 18, 18, 4 );
        $this->timeNight = new Time( 22, 45, 15 );

        parent::setUp();

    }

    public function test_constructor()
    {

        $this->assertInstanceOf( Time::class, new Time( null, null, null ) );

    }

    public function test_getHour()
    {

        $this->assertSame( 5, $this->timeMorning->getHour() );
        $this->assertSame( 11, $this->timeLunch->getHour() );
        $this->assertSame( 18, $this->timeEvening->getHour() );
        $this->assertSame( 22, $this->timeNight->getHour() );

    }

    public function test_getMinute()
    {

        $this->assertSame( 19, $this->timeMorning->getMinute() );
        $this->assertSame( 54, $this->timeLunch->getMinute() );
        $this->assertSame( 18, $this->timeEvening->getMinute() );
        $this->assertSame( 45, $this->timeNight->getMinute() );

    }

    public function test_getSecond()
    {

        $this->assertSame( 52, $this->timeMorning->getSecond() );
        $this->assertSame( 33, $this->timeLunch->getSecond() );
        $this->assertSame( 4, $this->timeEvening->getSecond() );
        $this->assertSame( 15, $this->timeNight->getSecond() );

    }

    public function test_getSecondsAbsolute()
    {

        $this->assertSame( ( 3600 * 5 ) + ( 19 * 60 ) + 52, $this->timeMorning->getSecondsAbsolute() );
        $this->assertSame( ( 3600 * 11 ) + ( 54 * 60 ) + 33, $this->timeLunch->getSecondsAbsolute() );
        $this->assertSame( ( 3600 * 18 ) + ( 18 * 60 ) + 4, $this->timeEvening->getSecondsAbsolute() );
        $this->assertSame( ( 3600 * 22 ) + ( 45 * 60 ) + 15, $this->timeNight->getSecondsAbsolute() );

    }

    public function test_setHour()
    {

        $this->assertSame( Time::CurrentHour(), $this->timeMorning->setHour()->getHour() );
        $this->assertSame( 4, $this->timeMorning->setHour( 4 )->getHour() );
        $this->assertSame( 0, $this->timeMorning->setHour( -2 )->getHour() );
        $this->assertSame( 23, $this->timeMorning->setHour( 30 )->getHour() );

    }

    public function test_setMinute()
    {

        $this->assertSame( Time::CurrentMinute(), $this->timeMorning->setMinute()->getMinute() );
        $this->assertSame( 49, $this->timeMorning->setMinute( 49 )->getMinute() );
        $this->assertSame( 0, $this->timeMorning->setMinute( -5 )->getMinute() );
        $this->assertSame( 59, $this->timeMorning->setMinute( 70 )->getMinute() );

    }

    public function test_setSecond()
    {

        $this->assertSame( Time::CurrentSecond(), $this->timeMorning->setSecond()->getSecond() );
        $this->assertSame( 9, $this->timeMorning->setSecond( 9 )->getSecond() );
        $this->assertSame( 0, $this->timeMorning->setSecond( -12 )->getSecond() );
        $this->assertSame( 59, $this->timeMorning->setSecond( 65 )->getSecond() );

    }

    public function test_setSecondsAbsolute()
    {

        $this->timeMorning->setSecondsAbsolute( ( 3600 * 4 ) + ( 22 * 60 ) + 26 );
        $this->assertSame( 4, $this->timeMorning->getHour() );
        $this->assertSame( 22, $this->timeMorning->getMinute() );
        $this->assertSame( 26, $this->timeMorning->getSecond() );
        $this->timeMorning->setSecondsAbsolute( 40 );
        $this->assertSame( 0, $this->timeMorning->getHour() );
        $this->assertSame( 0, $this->timeMorning->getMinute() );
        $this->assertSame( 40, $this->timeMorning->getSecond() );
        $this->timeMorning->setSecondsAbsolute( 80 );
        $this->assertSame( 0, $this->timeMorning->getHour() );
        $this->assertSame( 1, $this->timeMorning->getMinute() );
        $this->assertSame( 20, $this->timeMorning->getSecond() );

    }

    public function test_setSecondsAbsoluteException1()
    {

        $this->expectException( ArgumentException::class );
        $this->timeMorning->setSecondsAbsolute( -100 );

    }

    public function test_setSecondsAbsoluteException2()
    {

        $this->expectException( ArgumentException::class );
        $this->timeMorning->setSecondsAbsolute( 86400 );

    }

    public function test_toString()
    {

        $this->assertSame( '05:19:52', (string) $this->timeMorning );
        $this->assertSame( '11:54:33', (string) $this->timeLunch );
        $this->assertSame( '18:18:04', (string) $this->timeEvening );
        $this->assertSame( '22:45:15', (string) $this->timeNight );

    }

    public function test_toArray()
    {

        $this->assertSame( [ 'hours' => 5, 'minutes' => 19, 'seconds' => 52 ], $this->timeMorning->toArray() );
        $this->assertSame( [ 'hours' => 11, 'minutes' => 54, 'seconds' => 33 ], $this->timeLunch->toArray() );
        $this->assertSame( [ 'hours' => 18, 'minutes' => 18, 'seconds' => 4 ], $this->timeEvening->toArray() );
        $this->assertSame( [ 'hours' => 22, 'minutes' => 45, 'seconds' => 15 ], $this->timeNight->toArray() );

    }

    public function test_clone()
    {

        $clone = clone $this->timeMorning;
        $this->assertEquals( $this->timeMorning, $clone );
        $this->assertNotSame( $this->timeMorning, $clone );

    }

    public function test_isEndOfDay()
    {

        $this->assertFalse( $this->timeMorning->isEndOfDay() );
        $this->assertFalse( $this->timeLunch->isEndOfDay() );
        $this->assertFalse( $this->timeEvening->isEndOfDay() );
        $this->assertFalse( $this->timeNight->isEndOfDay() );
        $this->assertFalse( Time::Create( 0, 0, 0 )->isEndOfDay() );
        $this->assertTrue( Time::Create( 23, 59, 59 )->isEndOfDay() );

    }

    public function test_isStartOfDay()
    {

        $this->assertFalse( $this->timeMorning->isStartOfDay() );
        $this->assertFalse( $this->timeLunch->isStartOfDay() );
        $this->assertFalse( $this->timeEvening->isStartOfDay() );
        $this->assertFalse( $this->timeNight->isStartOfDay() );
        $this->assertTrue( Time::Create( 0, 0, 0 )->isStartOfDay() );
        $this->assertFalse( Time::Create( 23, 59, 59 )->isStartOfDay() );

    }

    public function test_isAnteMeridiem()
    {

        $this->assertTrue( $this->timeMorning->isAnteMeridiem() );
        $this->assertTrue( $this->timeLunch->isAnteMeridiem() );
        $this->assertFalse( $this->timeEvening->isAnteMeridiem() );
        $this->assertFalse( $this->timeNight->isAnteMeridiem() );
        $this->assertFalse( Time::Create( 0, 0, 0 )->isAnteMeridiem() );
        $this->assertFalse( Time::Create( 23, 59, 59 )->isAnteMeridiem() );

    }

    public function test_isPostMeridiem()
    {

        $this->assertFalse( $this->timeMorning->isPostMeridiem() );
        $this->assertFalse( $this->timeLunch->isPostMeridiem() );
        $this->assertTrue( $this->timeEvening->isPostMeridiem() );
        $this->assertTrue( $this->timeNight->isPostMeridiem() );
        $this->assertTrue( Time::Create( 0, 0, 0 )->isPostMeridiem() );
        $this->assertTrue( Time::Create( 23, 59, 59 )->isPostMeridiem() );

    }

    public function test_addSeconds()
    {

        $this->assertSame( 53, $this->timeMorning->addSeconds()->getSecond() );
        $this->assertSame( 3, $this->timeMorning->addSeconds( 10 )->getSecond() );
        $this->assertSame( 5, $this->timeMorning->getHour() );
        $this->assertSame( 20, $this->timeMorning->getMinute() );
        $this->assertSame( 52, $this->timeMorning->addSeconds( -11 )->getSecond() );
        $this->assertSame( 5, $this->timeMorning->getHour() );
        $this->assertSame( 19, $this->timeMorning->getMinute() );
        $this->assertSame( '00:00:00', (string) Time::Create( 0, 0, 0 )->addSeconds( -10 ) );
        $this->assertSame( '00:00:00', (string) Time::Create( 0, 0, 10 )->addSeconds( -11 ) );
        $this->assertSame( '23:59:59', (string) Time::Create( 23, 59, 59 )->addSeconds( 10 ) );
        $this->assertSame( '23:59:59', (string) Time::Create( 23, 59, 50 )->addSeconds( 11 ) );

    }

    public function test_addMinutes()
    {

        $this->assertSame( '00:05:00', (string) Time::Create( 0, 1, 0 )->addMinutes( 4 ) );

    }

    public function test_addHours()
    {

        $this->assertSame( '09:05:00', (string) Time::Create( 2, 5, 0 )->addHours( 7 ) );

    }

    public function test_format()
    {

        $this->assertSame( 'amAM5505051952', $this->timeMorning->format( 'aAgGhHis' ) );
        $this->assertSame( 'pmPM61806181804', $this->timeEvening->format( 'aAgGhHis' ) );
        $this->assertSame( 'amA5505051952', $this->timeMorning->format( 'a\\AgGhHis' ) );
        $this->assertSame( 'am\\AM5505051952', $this->timeMorning->format( 'a\\\\AgGhHis' ) );
        $this->assertSame( 'am\\A5\\_505051952', $this->timeMorning->format( 'a\\\\\\Ag\\_GhHis' ) );
        $this->assertSame( '06:18:04 PM', $this->timeEvening->format( TimeFormat::FULL_12H->value ) );
        $this->assertSame( '05:19:52 AM', $this->timeMorning->format( TimeFormat::FULL_12H->value ) );
        $this->assertSame( '06:18 PM', $this->timeEvening->format( TimeFormat::SHORT_12H->value ) );
        $this->assertSame( '05:19 AM', $this->timeMorning->format( TimeFormat::SHORT_12H->value ) );
        $this->assertSame( '18:18:04', $this->timeEvening->format( TimeFormat::FULL_24H->value ) );
        $this->assertSame( '05:19:52', $this->timeMorning->format( TimeFormat::FULL_24H->value ) );
        $this->assertSame( '18:18', $this->timeEvening->format( TimeFormat::SHORT_24H->value ) );
        $this->assertSame( '05:19', $this->timeMorning->format( TimeFormat::SHORT_24H->value ) );
        $this->assertSame( '12:18:04 PM', Time::Parse( '00:18:04' )->format( TimeFormat::FULL_12H->value ) );
        $this->assertSame( '11:54:33 AM', $this->timeLunch->format( TimeFormat::FULL_12H->value ) );

    }

    public function test_compare()
    {

        $this->assertSame( 1, $this->timeMorning->compare( $this->timeLunch ) );
        $this->assertSame( 0, $this->timeMorning->compare( $this->timeMorning ) );
        $this->assertSame( -1, $this->timeLunch->compare( $this->timeMorning ) );

    }

    public function test_equals()
    {

        $this->assertTrue( $this->timeMorning->equals( '05:19:52' ) );
        $this->assertFalse( $this->timeMorning->equals( '05:19:52', true ) );
        $this->assertFalse( $this->timeMorning->equals( $this->timeEvening ) );
        $this->assertFalse( $this->timeMorning->equals( 'Abcdefghij K' ) );

    }

    public function test_unserialize()
    {

        $time = \unserialize( 'C:17:"Niirrty\Date\Time":60:{a:3:{s:5:"hours";i:5;s:7:"minutes";i:19;s:7:"seconds";i:52;}}' );

        $this->assertSame( '05:19:52', (string) $time );

    }

    public function test_Parse()
    {

        $this->assertSame( '05:19:52', (string) Time::Parse( '05:19:52' ) );
        $this->assertSame( '11:54:33', (string) Time::Parse( $this->timeLunch ) );
        $this->assertSame( '05:39:52', (string) Time::Parse( new DateTime( '2018-04-04 05:39:52' ) ) );
        $this->assertSame( '05:14:52', (string) Time::Parse( new \DateTime( '2018-04-04 05:14:52' ) ) );
        $this->assertFalse( Time::Parse( 'Abcdef' ) );

    }

    public function test_TryParse()
    {

        $this->assertTrue( Time::TryParse( '05:19:52', $refTime ) );
        $this->assertSame( '05:19:52', (string) $refTime );
        $this->assertTrue( Time::TryParse( $this->timeLunch, $refTime ) );
        $this->assertSame( '11:54:33', (string) $refTime );
        $this->assertTrue( Time::TryParse( new DateTime( '2018-04-04 05:39:52' ), $refTime ) );
        $this->assertSame( '05:39:52', (string) $refTime );
        $this->assertTrue( Time::TryParse( new \DateTime( '2018-04-04 05:14:52' ), $refTime ) );
        $this->assertSame( '05:14:52', (string) $refTime );
        $this->assertFalse( Time::TryParse( 'Abcdef', $refTime ) );

    }

    public function test_Now()
    {

        $this->assertSame( ( DateTime::Now()->format( 'h:i:s' ) ), Time::Now()->format( 'h:i:s' ) );

    }


}
