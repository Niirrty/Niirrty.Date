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
use Niirrty\IStringable;
use Niirrty\Type;
use PHPUnit\Framework\TestCase;


class DateTimeTest extends TestCase
{


   /**
    * @type \Niirrty\Date\DateTime[]
    */
   private $dateTimes = [];

   public function setUp()
   {

      $this->dateTimes[] = new DateTime( '2018-05-03 00:00:00', new \DateTimeZone( 'Europe/Berlin' ) );
      $this->dateTimes[] = new DateTime( '2017-02-04 11:01:11', new \DateTimeZone( 'UTC' ) );
      $this->dateTimes[] = new DateTime( '2009-07-06 15:01:40' );
      $this->dateTimes[] = new DateTime( '1960-11-10 23:59:59' );

      parent::setUp();

   }

   public function test_constructor()
   {

      $this->assertInstanceOf( DateTime::class, new DateTime() );

   }
   public function test_getYear()
   {

      $this->assertSame( 2018, $this->dateTimes[ 0 ]->getYear() );
      $this->assertSame( 2017, $this->dateTimes[ 1 ]->year );
      $this->assertSame( 2009, $this->dateTimes[ 2 ]->getYear() );
      $this->assertSame( 1960, $this->dateTimes[ 3 ]->year );

   }
   public function test_getMonth()
   {

      $this->assertSame( 5, $this->dateTimes[ 0 ]->getMonth() );
      $this->assertSame( 2, $this->dateTimes[ 1 ]->month );
      $this->assertSame( 7, $this->dateTimes[ 2 ]->getMonth() );
      $this->assertSame( 11, $this->dateTimes[ 3 ]->month );

   }
   public function test_getDay()
   {

      $this->assertSame( 3, $this->dateTimes[ 0 ]->getDay() );
      $this->assertSame( 4, $this->dateTimes[ 1 ]->day );
      $this->assertSame( 6, $this->dateTimes[ 2 ]->getDay() );
      $this->assertSame( 10, $this->dateTimes[ 3 ]->day );

   }
   public function test_getHour()
   {

      $this->assertSame( 0, $this->dateTimes[ 0 ]->getHour() );
      $this->assertSame( 11, $this->dateTimes[ 1 ]->hour );
      $this->assertSame( 15, $this->dateTimes[ 2 ]->getHour() );
      $this->assertSame( 23, $this->dateTimes[ 3 ]->hour );

   }
   public function test_getMinute()
   {

      $this->assertSame( 0, $this->dateTimes[ 0 ]->getMinute() );
      $this->assertSame( 1, $this->dateTimes[ 1 ]->minute );
      $this->assertSame( 1, $this->dateTimes[ 2 ]->getMinute() );
      $this->assertSame( 59, $this->dateTimes[ 3 ]->minute );

   }
   public function test_getSecond()
   {

      $this->assertSame( 0, $this->dateTimes[ 0 ]->getSecond() );
      $this->assertSame( 11, $this->dateTimes[ 1 ]->second );
      $this->assertSame( 40, $this->dateTimes[ 2 ]->getSecond() );
      $this->assertSame( 59, $this->dateTimes[ 3 ]->second );

   }
   public function test_getDayNumberOfWeek()
   {

      # 0=so 1=mo 2=di 3=mi 4=do 5=fr 6=sa
      $this->assertSame( 4, $this->dateTimes[ 0 ]->getDayNumberOfWeek() );
      $this->assertSame( 6, $this->dateTimes[ 1 ]->dayOfWeek );
      $this->assertSame( 1, $this->dateTimes[ 2 ]->getDayNumberOfWeek() );
      $this->assertSame( 4, $this->dateTimes[ 3 ]->getDayNumberOfWeek() );

   }
   public function test_getISO8601DayNumberOfWeek()
   {

      $this->assertSame( 4, $this->dateTimes[ 0 ]->getISO8601DayNumberOfWeek() );
      $this->assertSame( 6, $this->dateTimes[ 1 ]->getISO8601DayNumberOfWeek() );
      $this->assertSame( 1, $this->dateTimes[ 2 ]->getISO8601DayNumberOfWeek() );
      $this->assertSame( 4, $this->dateTimes[ 3 ]->getISO8601DayNumberOfWeek() );

   }
   public function test_getQuarter()
   {

      $this->assertSame( 2, $this->dateTimes[ 0 ]->getQuarter() );
      $this->assertSame( 1, $this->dateTimes[ 1 ]->getQuarter() );
      $this->assertSame( 3, $this->dateTimes[ 2 ]->getQuarter() );
      $this->assertSame( 4, $this->dateTimes[ 3 ]->getQuarter() );

   }
   public function test_getTimezoneOffsetRFC822()
   {

      $this->assertSame( '+0200', $this->dateTimes[ 0 ]->getTimezoneOffsetRFC822() );
      $this->assertSame( '+0000', $this->dateTimes[ 1 ]->getTimezoneOffsetRFC822() );

   }
   public function test_getTimezoneOffsetGMT()
   {

      $this->assertSame( '+02:00', $this->dateTimes[ 0 ]->getTimezoneOffsetGMT() );
      $this->assertSame( '+00:00', $this->dateTimes[ 1 ]->getTimezoneOffsetGMT() );

   }
   public function test_getTimezoneName()
   {

      $this->assertSame( 'Europe/Berlin', $this->dateTimes[ 0 ]->getTimezoneName() );
      $this->assertSame( 'UTC', $this->dateTimes[ 1 ]->getTimezoneName() );

   }
   public function test_getTimezoneNameShort()
   {

      $this->assertSame( 'CEST', $this->dateTimes[ 0 ]->getTimezoneNameShort() );
      $this->assertSame( 'UTC', $this->dateTimes[ 1 ]->getTimezoneNameShort() );

   }
   public function test_getTime()
   {

      $this->assertSame( '00:00:00', (string) $this->dateTimes[ 0 ]->getTime() );
      $this->assertSame( '11:01:11', (string) $this->dateTimes[ 1 ]->getTime() );
      $this->assertSame( '15:01:40', (string) $this->dateTimes[ 2 ]->getTime() );
      $this->assertSame( '23:59:59', (string) $this->dateTimes[ 3 ]->getTime() );

   }
   public function test_isLeapYear()
   {

      $this->assertFalse( $this->dateTimes[ 0 ]->isLeapYear() );
      $this->assertFalse( $this->dateTimes[ 1 ]->isLeapYear() );
      $this->assertFalse( $this->dateTimes[ 2 ]->isLeapYear() );
      $this->assertTrue( $this->dateTimes[ 3 ]->isLeapYear() );

   }
   public function test_getDaysOfYear()
   {

      $this->assertSame( 365, $this->dateTimes[ 0 ]->getDaysOfYear() );
      $this->assertSame( 365, $this->dateTimes[ 1 ]->daysOfYear );
      $this->assertSame( 365, $this->dateTimes[ 2 ]->getDaysOfYear() );
      $this->assertSame( 366, $this->dateTimes[ 3 ]->getDaysOfYear() );

   }
   public function test_getDaysOfMonth()
   {

      $this->assertSame( 31, $this->dateTimes[ 0 ]->getDaysOfMonth() );
      $this->assertSame( 28, $this->dateTimes[ 1 ]->daysOfMonth );
      $this->assertSame( 31, $this->dateTimes[ 2 ]->getDaysOfMonth() );
      $this->assertSame( 30, $this->dateTimes[ 3 ]->getDaysOfMonth() );

   }
   public function test_getDayOfYear()
   {

      $this->assertSame( 122, $this->dateTimes[ 0 ]->getDayOfYear() );
      $this->assertSame( 34, $this->dateTimes[ 1 ]->dayOfYear );
      $this->assertSame( 186, $this->dateTimes[ 2 ]->getDayOfYear() );
      $this->assertSame( 314, $this->dateTimes[ 3 ]->getDayOfYear() );

   }
   public function test_getISO8601WeekNumber()
   {

      $this->assertSame( 18, $this->dateTimes[ 0 ]->getISO8601WeekNumber() );
      $this->assertSame( 5, $this->dateTimes[ 1 ]->getISO8601WeekNumber() );
      $this->assertSame( 28, $this->dateTimes[ 2 ]->getISO8601WeekNumber() );
      $this->assertSame( 45, $this->dateTimes[ 3 ]->getISO8601WeekNumber() );

   }
   public function test_getDate()
   {

      $this->assertSame( '2018-05-03 00:00:00', (string) $this->dateTimes[ 0 ]->getDate() );
      $this->assertSame( '2017-02-04 00:00:00', (string) $this->dateTimes[ 1 ]->getDate() );
      $this->assertSame( '2009-07-06 00:00:00', (string) $this->dateTimes[ 2 ]->getDate() );
      $this->assertSame( '1960-11-10 00:00:00', (string) $this->dateTimes[ 3 ]->getDate() );

   }
   public function test_getWeekOfMonth()
   {

      $this->assertSame( 1, $this->dateTimes[ 0 ]->getWeekOfMonth() );
      $this->assertSame( 1, $this->dateTimes[ 1 ]->weekOfMonth );
      $this->assertSame( 1, $this->dateTimes[ 2 ]->getWeekOfMonth() );
      $this->assertSame( 2, $this->dateTimes[ 3 ]->getWeekOfMonth() );

   }
   public function test_getDifferenceYears()
   {

      $this->assertSame( 1, $this->dateTimes[ 0 ]->getDifferenceYears( $this->dateTimes[ 1 ] ) );
      $this->assertSame( 7, $this->dateTimes[ 1 ]->getDifferenceYears( $this->dateTimes[ 2 ] ) );
      $this->assertSame( -48, $this->dateTimes[ 2 ]->getDifferenceYears( $this->dateTimes[ 3 ], false ) );
      $this->assertSame( 57, $this->dateTimes[ 3 ]->getDifferenceYears( $this->dateTimes[ 0 ], false ) );

   }
   public function test_getAge()
   {

      $this->assertTrue( $this->dateTimes[ 1 ]->getAge() > 0 );

   }

   public function test_setTimeParts()
   {

      $this->assertSame( '2018-05-03 02:00:50', (string) $this->dateTimes[ 0 ]->setTimeParts( 2, 0, 50 ) );
      $this->assertSame( '2017-02-04 11:01:11', (string) $this->dateTimes[ 1 ]->setTimeParts() );
      $this->assertSame( '2017-02-04 11:09:11', (string) $this->dateTimes[ 1 ]->setTimeParts( null, 9 ) );
      $this->assertSame(
         '2018-05-03 08:08:08',
         (string) $this->dateTimes[ 0 ]->setTimeParts( [ 'hour' => 8, 'minute' => 8, 'second' => 8 ] )
      );
      $this->assertSame(
         '2018-05-03 07:07:07',
         (string) $this->dateTimes[ 0 ]->setTimeParts( [ 7, 7, 7 ] )
      );

   }
   public function test_changeTime()
   {

      $this->assertSame( '2018-05-03 17:17:17',
                         (string) $this->dateTimes[ 0 ]->changeTime( Time::Create( 17, 17, 17 ) ) );

   }
   public function test_setDateParts()
   {

      $this->assertSame( '2015-04-04 00:00:00', (string) $this->dateTimes[ 0 ]->setDateParts( 2015, 4, 4 ) );
      $this->assertSame( '2015-04-04 00:00:00', (string) $this->dateTimes[ 0 ]->setDateParts() );
      $this->assertSame( '2015-09-04 00:00:00', (string) $this->dateTimes[ 0 ]->setDateParts( null, 9 ) );

   }
   public function test_setISODate()
   {

      $this->assertSame( '2018-01-02 00:00:00', (string) $this->dateTimes[ 0 ]->setISODate( 2018, 1, 2 ) );

   }
   public function test_setYear()
   {

      $this->assertSame( '2015-05-03 00:00:00', (string) $this->dateTimes[ 0 ]->setYear( 2015 ) );
      $this->assertSame( DateTime::CurrentYear(), $this->dateTimes[ 1 ]->setYear()->getYear() );

   }
   public function test_setMonth()
   {

      $this->assertSame( 2, $this->dateTimes[ 0 ]->setMonth( 2 )->month );
      $this->assertSame( DateTime::CurrentMonth(), $this->dateTimes[ 1 ]->setMonth()->getMonth() );

   }
   public function test_setDay()
   {

      $this->assertSame( 22, $this->dateTimes[ 0 ]->setDay( 22 )->day );
      $this->assertSame( DateTime::CurrentDay(), $this->dateTimes[ 1 ]->setDay()->getDay() );

   }
   public function test_setHour()
   {

      $this->assertSame( 21, $this->dateTimes[ 0 ]->setHour( 21 )->hour );
      $this->assertSame( DateTime::CurrentHour(), $this->dateTimes[ 1 ]->setHour()->getHour() );

   }
   public function test_setMinute()
   {

      $this->assertSame( 47, $this->dateTimes[ 0 ]->setMinute( 47 )->minute );
      $this->assertSame( DateTime::CurrentMinute(), $this->dateTimes[ 1 ]->setMinute()->getMinute() );

   }
   public function test_setSecond()
   {

      $this->assertSame( 20, $this->dateTimes[ 0 ]->setSecond( 20 )->second );
      $this->assertSame( DateTime::CurrentSecond(), $this->dateTimes[ 1 ]->setSecond()->getSecond() );

   }
   public function test_setTimestamp()
   {

      $oldTZ = \date_default_timezone_get();
      \date_default_timezone_set( 'UTC' );

      $this->assertSame(
         '1999-04-05 01:02:03',
         (string) DateTime::Now()->setTimestamp( \mktime( 1, 2, 3, 4, 5, 1999 ) )
      );

      \date_default_timezone_set( $oldTZ );

   }
   public function test_setTimezone()
   {

      $this->assertSame(
         'UTC',
         $this->dateTimes[ 0 ]->setTimezone( new \DateTimeZone( 'UTC' ) )->getTimezoneName() );
      $this->assertSame(
         'Europe/Berlin',
         $this->dateTimes[ 0 ]->setTimezone( new \DateTimeZone( 'Europe/Berlin' ) )->getTimezoneName() );

   }

   public function test_addSeconds()
   {

      $this->assertSame( '2018-05-03 00:00:01', (string) $this->dateTimes[ 0 ]->addSeconds() );
      $this->assertSame( '2018-05-03 00:02:04', (string) $this->dateTimes[ 0 ]->addSeconds( 123 ) );
      $this->assertSame( '2018-05-03 00:01:52', (string) $this->dateTimes[ 0 ]->addSeconds( -12 ) );

   }
   public function test_move()
   {

      $this->assertSame(
         '1962-11-15 06:07:59',
         (string) $this->dateTimes[ 3 ]->move( new \DateInterval( 'P2Y4DT6H8M' ) ) );
      $this->assertSame(
         '1960-11-10 23:59:59',
         (string) $this->dateTimes[ 3 ]->move( new \DateInterval( 'P2Y4DT6H8M' ), true ) );

   }
   public function test_moveSeconds()
   {

      $this->assertSame( '2018-05-03 00:00:01', (string) $this->dateTimes[ 0 ]->moveSeconds() );
      $this->assertSame( '2018-05-03 00:02:04', (string) $this->dateTimes[ 0 ]->moveSeconds( 123 ) );
      $this->assertSame( '2018-05-03 00:01:52', (string) $this->dateTimes[ 0 ]->moveSeconds( -12 ) );

   }
   public function test_addMinutes()
   {

      $this->assertSame( '2018-05-03 00:01:00', (string) $this->dateTimes[ 0 ]->addMinutes() );
      $this->assertSame( '2018-05-03 02:04:00', (string) $this->dateTimes[ 0 ]->addMinutes( 123 ) );
      $this->assertSame( '2018-05-03 01:52:00', (string) $this->dateTimes[ 0 ]->addMinutes( -12 ) );

   }
   public function test_moveMinutes()
   {

      $this->assertSame( '2018-05-03 00:01:00', (string) $this->dateTimes[ 0 ]->moveMinutes() );
      $this->assertSame( '2018-05-03 02:04:00', (string) $this->dateTimes[ 0 ]->moveMinutes( 123 ) );
      $this->assertSame( '2018-05-03 01:52:00', (string) $this->dateTimes[ 0 ]->moveMinutes( -12 ) );

   }
   public function test_addHours()
   {

      $this->assertSame( '2018-05-03 01:00:00', (string) $this->dateTimes[ 0 ]->addHours() );
      $this->assertSame( '2018-05-03 13:00:00', (string) $this->dateTimes[ 0 ]->addHours( 12 ) );
      $this->assertSame( '2018-05-03 01:00:00', (string) $this->dateTimes[ 0 ]->addHours( -12 ) );

   }
   public function test_addDays()
   {

      $this->assertSame( '2018-05-04 00:00:00', (string) $this->dateTimes[ 0 ]->addDays() );
      $this->assertSame( '2018-05-13 00:00:00', (string) $this->dateTimes[ 0 ]->addDays( 9 ) );
      $this->assertSame( '2018-05-01 00:00:00', (string) $this->dateTimes[ 0 ]->addDays( -12 ) );

   }
   public function test_addYears()
   {

      $this->assertSame( '2019-05-03 00:00:00', (string) $this->dateTimes[ 0 ]->addYears() );
      $this->assertSame( '2142-05-03 00:00:00', (string) $this->dateTimes[ 0 ]->addYears( 123 ) );
      $this->assertSame( '2130-05-03 00:00:00', (string) $this->dateTimes[ 0 ]->addYears( -12 ) );

   }
   public function test_addWeeks()
   {

      $this->assertSame( '2018-05-10 00:00:00', (string) $this->dateTimes[ 0 ]->addWeeks() );
      $this->assertSame( '2018-05-24 00:00:00', (string) $this->dateTimes[ 0 ]->addWeeks( 2 ) );
      $this->assertSame( '2018-05-17 00:00:00', (string) $this->dateTimes[ 0 ]->addWeeks( -1 ) );

   }
   public function test_moveToEndOfDay()
   {

      $this->assertSame( '2018-05-03 23:59:59', (string) $this->dateTimes[ 0 ]->moveToEndOfDay() );

   }

   public function test_formatSqlDateTime()
   {

      $this->assertSame( '2018-05-03 00:00:00', $this->dateTimes[ 0 ]->formatSqlDateTime() );
      $this->assertSame( '2017-02-04 11:01:11', $this->dateTimes[ 1 ]->formatSqlDateTime() );
      $this->assertSame( '2009-07-06 15:01:40', $this->dateTimes[ 2 ]->formatSqlDateTime() );
      $this->assertSame( '1960-11-10 23:59:59', $this->dateTimes[ 3 ]->formatSqlDateTime() );

   }
   public function test_formatSqlDate()
   {

      $this->assertSame( '2018-05-03', $this->dateTimes[ 0 ]->formatSqlDate() );
      $this->assertSame( '2017-02-04', $this->dateTimes[ 1 ]->formatSqlDate() );
      $this->assertSame( '2009-07-06', $this->dateTimes[ 2 ]->formatSqlDate() );
      $this->assertSame( '1960-11-10', $this->dateTimes[ 3 ]->formatSqlDate() );

   }
   public function test_modify()
   {

      $this->assertSame( '2018-04-30 00:00:00', (string) $this->dateTimes[ 0 ]->modify( 'last monday' ) );

   }

   public function test_isset()
   {

      $this->assertTrue( isset( $this->dateTimes[ 0 ]->year ) );
      $this->assertFalse( isset( $this->dateTimes[ 0 ]->foo ) );

   }
   public function test_get()
   {

      $this->assertFalse( $this->dateTimes[ 0 ]->foo );

   }

   public function test_equals()
   {

      $this->assertTrue( $this->dateTimes[ 0 ]->equals( $this->dateTimes[ 0 ], true ) );
      $this->assertTrue( $this->dateTimes[ 0 ]->equals( '2018-05-03 00:00:00', false ) );
      $this->assertFalse( $this->dateTimes[ 0 ]->equals( '2018-05-03 00:00:00', true ) );
      $this->assertFalse( $this->dateTimes[ 0 ]->equals( 'Abc' ) );

   }

   public function test_Parse()
   {

      $this->assertFalse( DateTime::Parse( null ) );
      $this->assertSame(
         '2015-07-29 00:00:00',
         (string) DateTime::Parse( DateTime::Create( 2015, 7, 29 ) )
      );
      $this->assertSame(
         '2015-07-29 00:10:20',
         (string) DateTime::Parse( new \DateTime( '2015-07-29 00:10:20' ) )
      );
      $this->assertFalse( DateTime::Parse( [] ) );
      $this->assertFalse( DateTime::Parse( new \stdClass() ) );
      $this->assertSame(
         '2015-08-20',
         DateTime::Parse( \mktime( 2, 10, 14, 8, 20, 2015 ) )->formatSqlDate()
      );
      $this->assertSame(
         '2015-07-29 00:10:20',
         (string) DateTime::Parse( '2015-07-29 00:10:20' )
      );
      $this->assertSame(
         '2015-07-29 00:10:20',
         (string) DateTime::Parse( new class implements IStringable
            {
               public function __toString()
               {
                  return '2015-07-29 00:10:20';
               }
            }
         )
      );
      $this->assertFalse( DateTime::Parse( new Type( '2015-07-29 00:10:20' ) ) );
      $this->assertFalse( DateTime::Parse( '1......2....' ) );
      $this->assertSame(
         '2015-07-29 00:10:20',
         (string) DateTime::Parse( "2015-07-29 \r\n\t 00:10:20" )
      );

   }
   public function test_FromDateTime()
   {

      $this->assertSame( '2018-05-03 00:00:00', (string) DateTime::FromDateTime( $this->dateTimes[ 0 ] ) );

   }
   public function test_FromTimestamp()
   {

      $this->assertSame(
         '1999-04-05 01:02:03',
         (string) DateTime::FromTimestamp(
            \mktime( 1, 2, 3, 4, 5, 1999 ),
            new \DateTimezone( \date_default_timezone_get() )
         )
      );

   }
   public function test_FromFormat()
   {

      $this->assertSame(
         '2017-05-03 14:22:21',
         (string) DateTime::FromFormat( 'd.m.Y H:s:i', '03.05.2017 14:21:22' )
      );
      $this->assertSame(
         '2017-05-03 14:22:21',
         (string) DateTime::FromFormat( 'd.m.Y H:s:i', '03.05.2017 14:21:22', new \DateTimezone( \date_default_timezone_get() ) )
      );

   }
   public function test_FromFormatException()
   {

      $this->expectException( ArgumentException::class );
      DateTime::FromFormat( 'd.m.Y H:s:i', 'f.o-o B#a#r' );

   }
   public function test_FromTimestampUTC()
   {

      $this->assertSame(
         '1999-04-05 01:02:03',
         (string) DateTime::FromTimestampUTC( \mktime( 1, 2, 3, 4, 5, 1999 ) )
      );

   }
   public function test_CurrentYear()
   {

      $this->assertSame( (int) \date( 'Y' ), DateTime::CurrentYear() );

   }
   public function test_CurrentMonth()
   {

      $this->assertSame( (int) \date( 'm' ), DateTime::CurrentMonth() );

   }
   public function test_CurrentDay()
   {

      $this->assertSame( (int) \date( 'd' ), DateTime::CurrentDay() );

   }
   public function test_CurrentHour()
   {

      $this->assertSame( (int) \date( 'H' ), DateTime::CurrentHour() );

   }
   public function test_CurrentMinute()
   {

      $this->assertSame( (int) \date( 'i' ), DateTime::CurrentMinute() );

   }
   public function test_CurrentSecond()
   {

      $this->assertSame( (int) \date( 's' ), DateTime::CurrentSecond() );

   }
   public function test_CurrentMicroSecond()
   {

      $this->assertTrue( -1 < DateTime::CurrentMicroSecond() );

   }
   public function test_Now()
   {

      $this->assertSame( date( 'Y-m-d H:i:s' ), (string) DateTime::Now() );
      $this->assertSame( date( 'Y-m-d ' ) . '00:00:00', (string) DateTime::Now( null, true ) );
      $this->assertSame( date( 'Y-m-d ' ) . '23:59:59', (string) DateTime::Now( null, false, true ) );

   }
   public function test_FromFile()
   {

      $this->assertFalse( DateTime::FromFile( 'foo.bar', true ) );
      $this->assertInstanceOf( DateTime::class, DateTime::FromFile( __FILE__ ) );
      $this->assertFalse( DateTime::FromFile( 'foo.bar' ) );

   }
   public function test_GetDaysInMonth()
   {

      $this->assertSame( 28, DateTime::GetDaysInMonth( 2018, 2 ) );
      $this->assertSame( 28, DateTime::GetDaysInMonth( 2017, 2 ) );
      $this->assertSame( 29, DateTime::GetDaysInMonth( 2016, 2 ) );
      $this->assertSame( 28, DateTime::GetDaysInMonth( 2015, 2 ) );

   }
   public function test_MaxValue()
   {

      $this->assertSame( '9999-12-31 23:59:59', (string) DateTime::MaxValue() );

   }
   public function test_MinValue()
   {

      $this->assertSame( '0001-01-01 00:00:00', (string) DateTime::MinValue() );

   }
   public function test_EasterSunday()
   {

      $this->assertSame( '1960-04-17 00:00:00', (string) DateTime::EasterSunday( 1960 ) );
      $this->assertSame( '1961-04-02 00:00:00', (string) DateTime::EasterSunday( 1961 ) );
      $this->assertSame( '1962-04-22 00:00:00', (string) DateTime::EasterSunday( 1962 ) );
      $this->assertSame( '1963-04-14 00:00:00', (string) DateTime::EasterSunday( 1963 ) );
      $this->assertSame( '2015-04-05 00:00:00', (string) DateTime::EasterSunday( 2015 ) );
      $this->assertSame( '2016-03-27 00:00:00', (string) DateTime::EasterSunday( 2016 ) );
      $this->assertSame( '2017-04-16 00:00:00', (string) DateTime::EasterSunday( 2017 ) );
      $this->assertSame( '2018-04-01 00:00:00', (string) DateTime::EasterSunday( 2018 ) );

   }
   public function test_LeapYear()
   {

      $this->assertFalse( DateTime::LeapYear( 2018 ) );
      $this->assertFalse( DateTime::LeapYear( 2017 ) );
      $this->assertTrue( DateTime::LeapYear( 2016 ) );
      $this->assertFalse( DateTime::LeapYear( 2015 ) );

   }

}
