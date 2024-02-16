<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright      © 2017-2021, Niirrty
 * @package        Niirrty\Date
 * @since          2017-03-20
 * @version        0.4.0
 */


declare( strict_types=1 );


namespace Niirrty\Date;


use \Niirrty\{ArgumentException, IArrayable, IStringable};


/**
 * This class defines an object for better time handling.
 *
 * @since         v0.1.0
 */
class Time implements IStringable, IArrayable, \Serializable
{


    #region // – – –   P R O T E C T E D   F I E L D S   – – – – – – – – – – – – – – – – – – – – – –

    /**
     * The hour(s) part
     *
     * @var int
     */
    protected int $_hours;

    /**
     * The minute(s) part
     *
     * @var int
     */
    protected int $_minutes;

    /**
     * The second(s) part
     *
     * @var int
     */
    protected int $_seconds;

    #endregion


    #region // – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –

    /**
     * Init a new instance.
     *
     * @param int|null $hour   The hour (0-23) If null is defined, the current hour will be used.
     * @param int|null $minute The minute (0-59) If null is defined, the current minute will be used.
     * @param int|null $second The second (0-59) If null is defined, the current second will be used.
     */
    public function __construct( ?int $hour = null, ?int $minute = null, ?int $second = null )
    {

        // Use current hour|minute|second if none is defined
        if ( null === $hour )
        {
            $hour = static::CurrentHour();
        }

        if ( null === $minute )
        {
            $minute = static::CurrentMinute();
        }

        if ( null === $second )
        {
            $second = static::CurrentSecond();
        }

        // Ensure hour, minute and second is in a valid range
        $hour   = \min( 23, \max( 0, $hour ) );
        $minute = \min( 59, \max( 0, $minute ) );
        $second = \min( 59, \max( 0, $second ) );

        $this->_hours   = (int) $hour;
        $this->_minutes = (int) $minute;
        $this->_seconds = (int) $second;

    }

    #endregion


    #region // – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –


    #region # - - -   G E T T E R   - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Returns the hour.
     *
     * @return int
     */
    public function getHour(): int
    {

        return $this->_hours;

    }

    /**
     * Returns the minute.
     *
     * @return int
     */
    public function getMinute(): int
    {

        return $this->_minutes;

    }

    /**
     * Returns the second.
     *
     * @return int
     */
    public function getSecond(): int
    {

        return $this->_seconds;

    }

    /**
     * Get a value in seconds that represents the hour + minutes + seconds as seconds :-)
     * (e.g. 60 = 00:01:00)
     *
     * @return integer
     */
    public function getSecondsAbsolute(): int
    {

        return
            ( $this->_hours * 60 * 60 ) // Hours in seconds
            +                           // +
            ( $this->_minutes * 60 )    // Minutes in seconds
            +                           // +
            $this->_seconds;            // Seconds

    }

    #endregion


    #region # - - -   S E T T E R   - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Sets the hour.
     *
     * @param int|null $value The hour (0-23 or NULL if current hour should be used)
     *
     * @return Time
     */
    public function setHour( ?int $value = null ): self
    {

        if ( null === $value )
        {

            $this->_hours = static::CurrentHour();

            return $this;

        }

        $this->_hours = $value;

        if ( $this->_hours < 0 )
        {
            $this->_hours = 0;
        }

        if ( $this->_hours > 23 )
        {
            $this->_hours = 23;
        }

        return $this;

    }

    /**
     * Sets the minute.
     *
     * @param int|null $value The minute (0-59 or NULL if current minute should be used)
     *
     * @return Time
     */
    public function setMinute( ?int $value = null ): self
    {

        if ( null === $value )
        {

            $this->_minutes = static::CurrentMinute();

            return $this;

        }

        $this->_minutes = $value;

        if ( $this->_minutes < 0 )
        {
            $this->_minutes = 0;
        }

        if ( $this->_minutes > 59 )
        {
            $this->_minutes = 59;
        }

        return $this;

    }

    /**
     * Sets the second.
     *
     * @param int|NULL $value The second (0-59 or NULL if current second should be used)
     *
     * @return Time
     */
    public function setSecond( ?int $value = null ): self
    {

        if ( null === $value )
        {

            $this->_seconds = static::CurrentSecond();

            return $this;

        }

        $this->_seconds = $value;

        if ( $this->_seconds < 0 )
        {
            $this->_seconds = 0;
        }

        if ( $this->_seconds > 59 )
        {
            $this->_seconds = 59;
        }

        return $this;

    }

    /**
     * Sets a value in seconds that represents the hour + minutes + seconds as seconds :-)
     *
     * @param integer $value The absolute seconds, representing the time. (e.g. 60 = 00:01:00)
     *
     * @return Time
     * @throws ArgumentException If $value is lower than 0 or bigger than 86399.
     */
    public function setSecondsAbsolute( int $value ): self
    {

        if ( $value < 0 )
        {
            throw new ArgumentException(
                'secondsAbsolute', $value, 'An absolute-seconds time value can not be lower that 0!' );
        }

        if ( $value > 86399 )
        {
            throw new ArgumentException(
                'secondsAbsolute', $value,
                'An absolute-seconds time value can not be higher than 86399! (23:59:59)'
            );
        }

        if ( $value < 60 )
        {

            // $value is lower than a minute (0-59 seconds)
            $this->_hours = 0;
            $this->_minutes = 0;
            $this->_seconds = $value;

            return $this;

        }

        // extract the seconds part
        $this->_seconds = $value % 60;

        // and remove the seconds part
        $value -= $this->_seconds;

        if ( $value < 3600 )
        {

            // The rest of $value is not a full hour.
            // Getting the minutes (0-59)
            $this->_hours = 0;
            $this->_minutes = $value / 60;

            return $this;

        }

        // value is 3600 or higher (1 hour or more)
        // extract the minutes part
        $this->_minutes = (int) ( ( $value % 3600 ) / 60 );

        // and remove the minutes part
        $value -= (int) ( $this->_minutes * 60 );

        // value is now 3600 or a multiple of it.
        $this->_hours = (int) ( $value / 3600 );

        return $this;

    }

    #endregion


    #region # - - -   O T H E R   M E T H O D S   - - - - - - - - - - - - - - -

    /**
     * Returns the time with format H:i:s.
     *
     * @return string
     */
    public function __toString()
    {

        return \sprintf(
            "%'.02d:%'.02d:%'.02d",
            $this->_hours,
            $this->_minutes,
            $this->_seconds
        );

    }

    /**
     * Returns all instance data as an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {

        return [
            'hours'   => $this->_hours,
            'minutes' => $this->_minutes,
            'seconds' => $this->_seconds,
        ];

    }

    /**
     * @inherit-doc
     */
    public function __clone()
    {

        $tmpZero = 0;

        $this->_hours   = $tmpZero + $this->_hours;
        $this->_minutes = $tmpZero + $this->_minutes;
        $this->_seconds = $tmpZero + $this->_seconds;

    }

    /**
     * Returns if the current time points to the day end (23:59:59).
     *
     * @return boolean
     * @see    Time::isStartOfDay
     */
    public final function isEndOfDay(): bool
    {

        return
            $this->_hours === 23
            &&
            $this->_minutes === 59
            &&
            $this->_seconds === 59;

    }

    /**
     * Returns if the current time points to the day start (00:00:00).
     *
     * @return boolean
     * @see    Time::isEndOfDay
     */
    public final function isStartOfDay(): bool
    {

        return
            $this->_hours === 0
            &&
            $this->_minutes === 0
            &&
            $this->_seconds === 0;

    }

    /**
     * Returns if the current Time is inside the AM range. (Otherwise it will be a part of the PM range)
     *
     * @return boolean
     * @see    Time::isPostMeridiem
     */
    public final function isAnteMeridiem(): bool
    {

        return $this->_hours > 0
               &&
               $this->_hours < 13;

    }

    /**
     * Returns if the current Time is inside the PM range. (Otherwise it will be a part of the AM range)
     *
     * @return boolean
     * @see    Time::isAnteMeridiem
     */
    public final function isPostMeridiem(): bool
    {

        return !$this->isAnteMeridiem();

    }

    /**
     * Adds or removes (negative values) the defined number of seconds. If the resulting time is out of the
     * allowed time range (0-86399 seconds absolute) only the usable seconds are added or removed!
     *
     * @param integer $seconds The seconds to add|remove (use a negative value to subtract/remove the seconds)
     *
     * @return Time Returns the current changed instance.
     * @throws ArgumentException If resulting time is bigger than 23:59:59 or lower than 00:00:00
     */
    public final function addSeconds( int $seconds = 1 ): Time
    {

        if ( 0 === $seconds ||
             ( $seconds > 0 && $this->isEndOfDay() ) ||
             ( $seconds < 0 && $this->isStartOfDay() )
        )
        {

            // There is nothing to do
            return $this;

        }

        // Getting the currently absolute seconds
        $absSeconds = $this->getSecondsAbsolute();

        // Calculate the new absolute seconds
        $tmp = $absSeconds + $seconds;

        if ( $tmp > 86399 )
        {
            // Ensure $tmp is not bigger than 23:59:59
            $tmp = 86399;
        }

        if ( $tmp < 0 )
        {
            // Ensure $tmp is not lower than 00:00:00
            $tmp = 0;
        }

        // Setting the new time
        $this->setSecondsAbsolute( $tmp );

        return $this;

    }

    /**
     * Adds or removes (negative values) the defined number of full minutes. If the resulting time is out of the
     * allowed time range only the usable minutes + seconds are added or removed!
     *
     * @param integer $minutes The full minutes to add|remove (use a negative value to subtract/remove the minutes)
     *
     * @return Time Returns the current changed instance.
     * @throws ArgumentException If resulting time is bigger than 23:59:59 or lower than 00:00:00
     */
    public final function addMinutes( int $minutes = 1 ): Time
    {

        return $this->addSeconds( $minutes * 60 );

    }

    /**
     * Adds or removes (negative values) the defined number of hours. If the resulting time is out of the
     * allowed time range only the usable hours + minutes + seconds are added or removed!
     *
     * @param integer $hours The hours to add|remove (use a negative value to subtract/remove the hours)
     *
     * @return Time Returns the current changed instance.
     * @throws ArgumentException If resulting time is bigger than 23:59:59 or lower than 00:00:00
     */
    public final function addHours( int $hours = 1 ): Time
    {

        return $this->addSeconds( $hours * 3600 );

    }

    /**
     * Formats the current time and returns it as a string.
     *
     * The following format parameters are parsed:
     *
     * - <b>a</b> (am or pm): Lower case Ante meridiem (01:00:00 - 12:59:59) and Post meridiem (13:00:00 - 00:59:59)
     * - <b>A</b> (AM or PM): Upper case Ante meridiem (01:00:00 - 12:59:59) and Post meridiem (13:00:00 - 00:59:59)
     * - <b>g</b> (1 - 12): The hour with 12h format without leading zero
     * - <b>G</b> (0 - 23): The hour with 24h format without leading zero
     * - <b>h</b> (01 - 12): The hour with 12h format with leading zero
     * - <b>H</b> (00 - 23): The hour with 24h format with leading zero
     * - <b>i</b> (00 - 59): The minute with leading zero
     * - <b>s</b> (00 - 59): The second with leading zero
     *
     * If you use one of the characters not meaning a format marker, you have to escape it with a leading
     * backslash!
     *
     * @param string $formatString The Time formatting string. e.g.: H:i:s for 04:02:01
     *
     * @return string
     */
    public final function format( string $formatString ): string
    {

        // Handle often used directly

        if ( $formatString === TimeFormat::FULL_12H->value )
        {  // h:i:s A
            return \sprintf(
                "%'.02d:%'.02d:%'.02d %s",
                $this->get12hHour(),
                $this->_minutes,
                $this->_seconds,
                $this->getMeridiem()
            );
        }

        if ( $formatString === TimeFormat::SHORT_12H->value )
        {
            return \sprintf(
                "%'.02d:%'.02d %s",
                $this->get12hHour(),
                $this->_minutes,
                $this->getMeridiem()
            );
        }

        if ( $formatString === TimeFormat::FULL_24H->value )
        {
            return \sprintf(
                "%'.02d:%'.02d:%'.02d",
                $this->_hours,
                $this->_minutes,
                $this->_seconds
            );
        }

        if ( $formatString === TimeFormat::SHORT_24H->value )
        {
            return \sprintf(
                "%'.02d:%'.02d",
                $this->_hours,
                $this->_minutes
            );
        }

        $formatChars = [ 'a', 'A', 'g', 'G', 'h', 'H', 'i', 's' ];
        $backslashCount = 0;
        $result = '';

        for ( $i = 0, $c = \strlen( $formatString ); $i < $c; ++$i )
        {

            // Handle each single character
            $char = $formatString[ $i ];

            if ( \in_array( $char, $formatChars ) )
            {

                // The current char is a format char that should be replaced in normal cases.

                if ( $backslashCount > 0 )
                {

                    // But there was a backslash before. So it should be used as it?

                    if ( 0 === $backslashCount % 2 )
                    {
                        // 2, 4, 6, etc. backslashes => the current char is not escaped
                        $result .= \str_repeat( '\\', $backslashCount / 2 );
                        $backslashCount = 0;
                    }
                    else
                    {
                        //  \A => A oder \\\A => \A oder \\\\\A => \\A
                        if ( $backslashCount > 1 )
                        {
                            // Append the unsaved backslashes if there are more than 1 (the last will be ignored)
                            $result .= \str_repeat( '\\', ( $backslashCount - 1 ) / 2 );
                        }
                        // Append the current char as it
                        $result .= $char;
                        // empty the $backslashCount
                        $backslashCount = 0;
                        // Goto next char
                        continue;
                    }

                }

                $result .= match ( $char )
                {
                    'a' => $this->getMeridiem( true ),
                    'A' => $this->getMeridiem(),
                    'g' => (string) $this->get12hHour(),
                    'G' => (string) $this->_hours,
                    'h' => \sprintf( "%'.02d", $this->get12hHour() ),
                    'H' => \sprintf( "%'.02d", $this->_hours ),
                    'i' => \sprintf( "%'.02d", $this->_minutes ),
                    's' => \sprintf( "%'.02d", $this->_seconds ),
                };

                continue;

            }

            if ( $char === '\\' )
            {
                ++$backslashCount;
                continue;
            }

            // Not a special meaning char
            if ( $backslashCount > 0 )
            {
                $result .= \str_repeat( '\\', $backslashCount );
                $backslashCount = 0;
            }

            $result .= $char;

        }

        return $result;

    }

    /**
     * Compares the current instance with the defined. It returns -1, if $value is higher (newer) than current one,
     * 0 if both times are equal, or 1, if current is higher (newer) than $value.
     *
     * @param mixed $value
     *
     * @return int|bool -1, 0, 1 oder (bool)FALSE if comparing fails because $value is of an unusable type
     * @throws \Throwable
     */
    public function compare( mixed $value ): bool|int
    {

        if ( !( $value instanceof Time ) )
        {

            if ( false === ( $value = Time::Parse( $value ) ) )
            {
                return false;
            }

        }

        $val = $value->getSecondsAbsolute();
        $thi = $this->getSecondsAbsolute();

        return ( $val <=> $thi );

    }

    /**
     * Checks if current instance is equal to permitted $value.
     *
     * If $strict is set to TRUE it returns FALSE, if $value is not of type {@see Time}.
     *
     * If $strict is set to FALSE $value can also be:
     *
     * - an integer (Unix timestamp)
     * - a \DateTime instance
     * - a \Niirrty\Date\DateTime instance
     * - a date time string like '2015-04-02 12:00:01' or something other valid format
     * - a time string like '12:00:01' or something other valid format
     *
     * @param mixed   $value  The value to compare with.
     * @param boolean $strict The value must be of type {@see Time}? (default=false)
     *
     * @return boolean         Returns TRUE if $value is equal to current instance, FALSE otherwise.
     * @throws \Throwable
     */
    public function equals( mixed $value, bool $strict = false ): bool
    {

        if ( $value instanceof Time )
        {
            // Strict: The time stamp must be equal
            return $value->getSecondsAbsolute() === $this->getSecondsAbsolute();
        }

        if ( $strict )
        {
            // Strict + $value is no \Beluga\Time instance returns FALSE
            return false;
        }

        if ( false === ( $t = Time::Parse( $value ) ) )
        {
            return false;
        }

        return $t->getSecondsAbsolute() === $this->getSecondsAbsolute();

    }

    /**
     * String representation of object
     *
     * @link  http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize(): string
    {

        return \serialize( $this->toArray() );

    }

    /**
     * Constructs the object
     *
     * @link  http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @return void
     * @since 5.1.0
     */
    public function unserialize( string $serialized ) : void
    {

        $data = \unserialize( $serialized );

        $this->_hours = $data[ 'hours' ] ?? $this->_hours;
        $this->_minutes = $data[ 'minutes' ] ?? $this->_minutes;
        $this->_seconds = $data[ 'seconds' ] ?? $this->_seconds;

    }

    #endregion


    #endregion


    #region // – – –   P R O T E C T E D   M E T H O D S   – – – – – – – – – – – – – – – – – – – – –

    /**
     * Returns the hour in 12-hour format. (e.g. 13:00 is 01:00 etc.)
     *
     * @return integer
     */
    protected function get12hHour(): int
    {

        if ( $this->isAnteMeridiem() )
        {
            return $this->getHour();
        }

        if ( 0 === $this->_hours )
        {
            return 12;
        }

        if ( $this->_hours > 12 )
        {
            return $this->_hours - 12;
        }

        return $this->_hours;

    }

    /**
     * Returns the current meridiem (in lower case am|pm or in upper case AM|PM)
     *
     * @param boolean $lowercase Return in lower case?
     *
     * @return string
     */
    protected function getMeridiem( bool $lowercase = false ): string
    {

        if ( $this->_hours > 0 && $this->_hours < 13 )
        {

            return $lowercase ? 'am' : 'AM';

        }

        return $lowercase ? 'pm' : 'PM';

    }

    #endregion


    #region // - - -   P U B L I C   S T A T I C   M E T H O D S   – – – – – – – – – – – – – – – – –

    /**
     * Parses a time definition to a \Niirrty\Date\Time instance.
     *
     * @param mixed $timeDefinition    The value to parse as Time. It can be a (date) time string, a unix timestamp, a
     *                                 object of type \Niirrty\DateTime or \DateTime or something that can be converted,
     *                                 by a string cast, to a valid time string.
     *
     * @return Time|bool Returns the created Time instance, or boolean FALSE if parsing fails.
     * @throws \Throwable
     */
    public static function Parse( mixed $timeDefinition ): Time|bool
    {

        if ( $timeDefinition instanceof Time )
        {
            // No converting needed! Return as it.
            return $timeDefinition;
        }

        if ( $timeDefinition instanceof DateTime )
        {
            return $timeDefinition->getTime();
        }

        if ( $timeDefinition instanceof \DateTime )
        {
            return DateTime::FromDateTime( $timeDefinition )->getTime();
        }

        if ( false !== ( $dt = DateTime::Parse( $timeDefinition ) ) )
        {
            return $dt->getTime();
        }

        return false;

    }

    /**
     * Tries to parse a time definition to a \Niirrty\Time instance.
     *
     * @param mixed     $timeDefinition The value to parse as Time. It can be a (date) time string, a unix timestamp, a
     *                                  object of type \Niirrty\DateTime or \DateTime or something that can be converted,
     *                                  by a string cast, to a valid time string.
     * @param Time|null $refTime        Returns the new Time instance if the method returns TRUE
     *
     * @return bool                  Returns if the parsing was successful.
     * @throws \Throwable
     */
    public static function TryParse( mixed $timeDefinition, ?Time &$refTime = null ): bool
    {

        if ( $timeDefinition instanceof Time )
        {

            // No converting needed! Return as it.

            $refTime = $timeDefinition;

            return true;

        }

        if ( $timeDefinition instanceof DateTime )
        {

            $refTime = $timeDefinition->getTime();

            return true;

        }

        if ( $timeDefinition instanceof \DateTime )
        {

            $refTime = DateTime::FromDateTime( $timeDefinition )->getTime();

            return true;

        }

        if ( false !== ( $dt = DateTime::Parse( $timeDefinition ) ) )
        {

            $refTime = $dt->getTime();

            return true;

        }

        return false;

    }

    /**
     * Returns the current hour.
     *
     * @return integer
     */
    public static function CurrentHour(): int
    {

        return (int) \date( 'h' );

    }

    /**
     * Returns the current minute.
     *
     * @return integer
     */
    public static function CurrentMinute(): int
    {

        return (int) \date( 'i' );

    }

    /**
     * Returns the current second.
     *
     * @return integer
     */
    public static function CurrentSecond(): int
    {

        return (int) \date( 's' );

    }

    /**
     * Returns the current time.
     *
     * @return Time
     */
    public static function Now(): Time
    {

        return new Time( self::CurrentHour(), self::CurrentMinute(), self::CurrentSecond() );

    }

    /**
     * Static way to create a new Time instance.
     *
     * @param int|null $hour   The hour (0-23) If null is defined, the current hour will be used.
     * @param int|null $minute The minute (0-59) If null is defined, the current minute will be used.
     * @param int|null $second The second (0-59) If null is defined, the current second will be used.
     *
     * @return Time
     */
    public static function Create( ?int $hour = null, ?int $minute = null, ?int $second = null ): Time
    {

        return new Time( $hour, $minute, $second );

    }

    public static function FromArray( array $array, bool $throwOnError = false ) : bool|static
    {

        # 'hours' 'minutes' 'seconds'
        $hours   = ! empty( $array[ 'hours' ] )
                 ? \intval( $array[ 'hours' ] )
                 : ( empty( $array[ 'hour' ] ) ? \intval( $array[ 'hour' ] ) : 0 );
        $minutes = ! empty( $array[ 'minutes' ] )
                 ? \intval( $array[ 'minutes' ] )
                 : ( empty( $array[ 'minute' ] ) ? \intval( $array[ 'minute' ] ) : 0 );
        $seconds = ! empty( $array[ 'seconds' ] )
                 ? \intval( $array[ 'seconds' ] )
                 : ( empty( $array[ 'second' ] ) ? \intval( $array[ 'second' ] ) : 0 );
        $hours   = \min( 23, \max( 0, $hours ) );
        $minutes = \min( 59, \max( 0, $minutes ) );
        $seconds = \min( 59, \max( 0, $seconds ) );

        if ( 0 === ( $hours + $minutes + $seconds ) )
        {
            if ( ! $throwOnError )
            {
                return false;
            }
            throw new ArgumentException( 'array', $array, 'Invalid array format for time data!' );
        }

        return new self( $hours, $minutes, $seconds );

    }

    /**
     * @throws \Throwable
     * @throws ArgumentException
     */
    public static function FromString( string $str, bool $throwOnError = false ) : bool|static
    {

        $time = null;
        if ( static::TryParse( $str, $time ) )
        {
            return $time;
        }

        if ( ! $throwOnError )
        {
            return false;
        }

        throw new ArgumentException( 'str', $str, 'Invalid string format for time data!' );

    }

    #endregion


    public function __serialize() : array
    {

        return $this->toArray();

    }

    public function __unserialize( array $data ) : void
    {

        try
        {
            $instance = static::FromArray( $data );
        }
        catch ( \Throwable )
        {
            $instance = false;
        }
        if ( false === $instance )
        {
            $this->_hours = 0;
            $this->_minutes = 0;
            $this->_seconds = 0;
        }
        else
        {
            $this->_hours = $instance->getHour();
            $this->_minutes = $instance->getMinute();
            $this->_seconds = $instance->getSecond();
        }

    }

}

