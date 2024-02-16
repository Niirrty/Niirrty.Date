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


use \Niirrty\{ArgumentException, IStringable, Type, TypeTool};


/**
 * This class defines a object for better date time handling.
 *
 * It can handle date times beginning with 0000-00-00 00:00:00
 *
 * @property-read int  $year
 * @property-read int  $month
 * @property-read int  $day
 * @property-read int  $hour
 * @property-read int  $minute
 * @property-read int  $second
 * @property-read int  $microSecond
 * @property-read int  $dayOfWeek
 * @property-read int  $dayOfYear
 * @property-read int  $weekOfYear
 * @property-read int  $daysInMonth
 * @property-read int  $timestamp
 * @property-read int  $weekOfMonth
 * @property-read int  $age
 * @property-read int  $quarter
 * @property-read int  $daysOfYear
 * @property-read bool $leapYear
 * @since         v0.1.0
 */
class DateTime extends \DateTime implements IStringable
{


    #region // – – –   P R I V A T E   C O N S T A N T S   – – – – – – – – – – – – – – – – – – – – –

    private const MONTH_NAMES_LONG_REGEX  = [
        '~(january|januaro|januari|januar|janvier|urtarrilaren|siječanj|януари|jaanuar|tammikuu|xaneiro|Ιανουάριος|janúar|gennaio|janvāris|sausis|jannar|јануари|styczeń|janeiro|ianuarie|январь|јануар|január|enero|leden|ocak|січень|ionawr|студзеня)~i',
        '~(februarie|february|februaro|februari|februar|février|otsaila|февруари|veebruar|helmikuu|febreiro|Φεβρουάριος|feabhra|febrúar|febbraio|febrer|februāris|vasaris|frar|luty|fevereiro|февраль|фебруар|február|febrero|únor|Şubat|лютого|Chwefror|лютага)~i',
        '~(märz|maerz|march|mars|marts|marto|mart|март|märts|maaliskuu|marzec|marzo|Μάρτιος|Márta|gājiens|kovas|Marzu|maart|março|martie|marec|březen|березня|március|Mawrth|сакавіка)~i',
        '~(aprilie|aprilis|aprilo|aprill|aprile|april|avril|април|huhtikuu|abril|Απρίλιος|aibreán|travanj|aprīlis|balandis|kwiecień|апреля|duben|nisan|квітня|április|Aprel|Ebrill)~i',
        '~(maiatza|maijs|maig|maio|mai|mayıs|mayo|may|majo|maj|май|toukokuu|Μάιος|bealtaine|maí|maggio|gegužė|mejju|мај|mei|мая|máj|květen|травня|május)~i',
        '~(junio|junij|juni|june|juin|juny|jun|юни|juuni|kesäkuu|xuño|Ιούνιος|meitheamh|júní|giugno|jūnijs|birželis|Ġunju|Јуни|czerwiec|Junho|iunie|июнь|јун|június|jún|červen|haziran|Червень|iyun|mehefin)~i',
        '~(juliol|julio|julij|juli|july|juillet|uztailaren|юли|juuli|heinäkuu|xullo|Ιούλιος|Iúil|júlí|luglio|srpanj|jūlijs|liepa|Lulju|lipiec|julho|iulie|июль|јул|júl|červenec|temmuz|липня|július|iyul|gorffennaf)~i',
        '~(augustus|augusts|augusti|august|août|abuztua|avgust|август|aŭgusto|elokuu|agosto|Αύγουστος|Lúnasa|ágúst|agost|rugpjūtis|Awissu|sierpień|srpen|ağustos|серпня|augusztus|awst)~i',
        '~(september|septembre|septembar|септември|septembro|syyskuu|setembro|Σεπτέμβριος|settembre|setembre|septembris|rugsėjis|settembru|wrzesień|septembrie|сентябрь|септембар|septembra|septiembre|září|eylül|вересень|szeptember|medi)~i',
        '~(oktober|october|octobre|urria|oktobar|октомври|oktobro|oktoober|lokakuu|outubro|Οκτώβριος|október|ottobre|octubre|listopad|oktobris|spalis|ottubru|październik|octombrie|октября|октобар|říjen|ekim|Жовтень|hydref)~i',
        '~(november|novembre|azaroa|novembar|ноември|novembro|marraskuu|Νοέμβριος|Samhain|nóvember|studeni|novembris|lapkritis|novembru|Ноември|listopad|noiembrie|ноябрь|новембар|noviembre|Kasım|Листопад|tachwedd)~i',
        '~(dezember|december|décembre|abendua|decembar|декември|decembro|detsember|joulukuu|Δεκέμβριος|nollaig|desember|dicembre|decembris|gruodis|Diċembru|grudzień|dezembro|decembrie|декабрь|децембар|diciembre|prosinec|Aralık|грудня|rhagfyr)~i',
    ];

    private const MONTH_NAMES_SHORT_REGEX = [
        '~(jan|urt|sij|jaa|tam|xan|gen|sau|јан|sty|ian|ene|led|oca|ion)~i',
        '~(feb|fév|ots|фев|veb|hel|Φεβ|fea|vas|fra|lut|fev|úno|Şub|Chw)~i',
        '~(mär|mar|мар|maa|Már|gāj|kov|bře|Maw)~i',
        '~(apr|avr|апр|huh|abr|Απρ|aib|tra|bal|kwi|dub|nis|ápr|Ebr)~i',
        '~(mai|may|maj|май|tou|Μάι|bea|maí|mag|geg|mej|mei|мая|máj|kvě)~i',
        '~(jun|jui|юни|juu|kes|xuñ|Ιού|jún|giu|jūn|bir|Ġun|Јун|cze|iun|июн|јун|čer|haz|iyu|meh)~i',
        '~(jul|jui|uzt|юли|juu|hei|xul|Iúi|júl|lug|srp|lie|Lul|lip|iul|июл|јул|čer|tem|iyu|gor)~i',
        '~(aug|aoû|abu|avg|авг|aŭg|elo|ago|Lún|ágú|rug|Awi|sie|ağu|aws)~i',
        '~(sep|сеп|syy|set|Σεπ|rug|wrz|сен|zář|eyl|sze|med)~i',
        '~(okt|oct|urr|окт|lok|out|Οκτ|ott|lis|spa|paź|říj|eki|Жов|hyd)~i',
        '~(nov|aza|ное|mar|Νοέ|Sam|nóv|stu|lap|noi|ноя|нов|Kas|tac)~i',
        '~(dez|dec|déc|abe|дек|det|jou|Δεκ|nol|des|dic|gru|Diċ|дец|pro|Ara|rha)~i',
    ];

    private const GETTER_FORMATS          = [
        'year'        => 'Y',
        'yearIso'     => 'o',
        'month'       => 'n',
        'day'         => 'j',
        'hour'        => 'G',
        'minute'      => 'i',
        'second'      => 's',
        'micro'       => 'u',
        'microSecond' => 'u',
        'dayOfWeek'   => 'w',
        'dayOfYear'   => 'z',
        'weekOfYear'  => 'W',
        'daysInMonth' => 't',
        'timestamp'   => 'U',
    ];

    #endregion


    #region // – – –   P U B L I C   C O N S T R U C T O R   – – – – – – – – – – – – – – – – – – – –

    /**
     * Init a new instance.
     *
     * @param string             $time
     * @param \DateTimeZone|null $timezone
     * @throws \Throwable
     */
    public function __construct( string $time = 'now', ?\DateTimeZone $timezone = null )
    {

        // Call the parent \DateTime constructor
        parent::__construct( $time, $timezone );

    }

    #endregion


    #region // – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –


    #region // - - -   G E T T E R   - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Returns the year (4 digits).
     *
     * @return int
     */
    public final function getYear(): int
    {

        return (int) $this->format( 'Y' );

    }

    /**
     * Returns the month number (1-12).
     *
     * @return integer
     */
    public final function getMonth(): int
    {

        return (int) $this->format( 'm' );

    }

    /**
     * Returns the day of the month (1-31).
     *
     * @return integer
     */
    public final function getDay(): int
    {

        return (int) $this->format( 'd' );

    }

    /**
     * Returns the hour (0-23)
     *
     * @return integer
     */
    public final function getHour(): int
    {

        return (int) $this->format( 'H' );

    }

    /**
     * Returns the minutes (0-59)
     *
     * @return integer
     */
    public final function getMinute(): int
    {

        return (int) $this->format( 'i' );

    }

    /**
     * Returns the seconds (0-59)
     *
     * @return integer
     */
    public final function getSecond(): int
    {

        return (int) $this->format( 's' );

    }

    /**
     * Returns the day number of current week  (0=Sunday to 6=Saturday)
     *
     * @return integer
     */
    public final function getDayNumberOfWeek(): int
    {

        return (int) $this->format( 'w' );

    }

    /**
     * Returns the ISO-8601 day number of current week  (1=Monday to 7=Sunday)
     *
     * @return integer
     */
    public final function getISO8601DayNumberOfWeek(): int
    {

        return (int) $this->format( 'N' );

    }

    /**
     * Returns the quarter (1-4)
     *
     * @return integer
     */
    public final function getQuarter(): int
    {

        $m = $this->getMonth();

        return (int) ( ( ( $m - ( $m % 3 ) ) / 3 ) + ( ( 0 === $m % 3 ) ? 0 : 1 ) );

    }

    /**
     * Returns the timezone offset by RFC822 (e.g.: -0800)
     *
     * @return string
     */
    public final function getTimezoneOffsetRFC822(): string
    {

        return $this->format( 'O' );

    }

    /**
     * Returns the GMT timezone offset. (e.g.: -08:00)
     *
     * @return string
     */
    public final function getTimezoneOffsetGMT(): string
    {

        return $this->format( 'P' );

    }

    /**
     * Returns the timezone name. (e.g.: Europe/Berlin)
     *
     * @return string
     */
    public final function getTimezoneName(): string
    {

        return $this->format( 'e' );

    }

    /**
     * Returns the short, abbr. timezone name. (e.g.: CET)
     *
     * @return string
     */
    public final function getTimezoneNameShort(): string
    {

        return $this->format( 'T' );

    }

    /**
     * Returns the currently defined time part as a {@see Time} instance.
     *
     * @return Time If no usable date time is defined it returns boolean FALSE.
     */
    public final function getTime(): Time
    {

        return new Time( $this->getHour(), $this->getMinute(), $this->getSecond() );

    }

    /**
     * Returns if current date time points to an leap year.
     *
     * @return boolean
     */
    public final function isLeapYear(): bool
    {

        return ( (int) $this->format( 'L' ) ) > 0;

    }

    /**
     * Returns the max count of days of current defined year.
     *
     * @return integer
     */
    public final function getDaysOfYear(): int
    {

        return $this->isLeapYear()
            ? 366
            : 365;

    }

    /**
     * Returns how many days the current month can have.
     *
     * @return integer (28-31)
     */
    public function getDaysOfMonth(): int
    {

        return (int) $this->format( 't' );

    }

    /**
     * Returns the day number in currently defined year.
     *
     * @return integer
     */
    public final function getDayOfYear(): int
    {

        return (int) $this->format( 'z' );

    }

    /**
     * Returns the ISO-8601 week number of year for current defined date. The week begins at monday!
     *
     * @return integer
     */
    public final function getISO8601WeekNumber(): int
    {

        return (int) $this->format( 'W' );

    }

    /**
     * Returns the date part of current instance, reduced to the time 00:00:00 as a new \Niirrty\Date\DateTime instance.
     *
     * @return DateTime
     */
    public final function getDate(): DateTime
    {

        return static::Create( $this->getYear(), $this->getMonth(), $this->getDay() );

    }

    /**
     * Gets the week number of the current instance date inside the current month.
     *
     * @return int
     */
    public final function getWeekOfMonth(): int
    {

        return (int) \ceil( $this->getDay() / 7 );

    }

    /**
     * Get the difference in years between current date time and defined.
     *
     * If no other date time is defined Now is used.
     *
     * @param DateTime|null $dt
     * @param bool          $abs Get the absolute of the difference
     *
     * @return int
     * @throws \Throwable
     */
    public final function getDifferenceYears( ?DateTime $dt = null, bool $abs = true ): int
    {

        $dt = $dt ?: static::Now( $this->getTimezone() );

        return (int) $this->diff( $dt, $abs )->format( '%r%y' );

    }

    /**
     * Gets the age for current date. This is the difference between instance date and current date, in years.
     *
     * @return int
     * @throws \Throwable
     */
    public final function getAge(): int
    {

        return $this->getDifferenceYears();

    }

    /**
     * Magic getter
     *
     * @param $name
     *
     * @return bool|int
     */
    public function __get( $name )
    {

        if ( \array_key_exists( $name, static::GETTER_FORMATS ) )
        {

            return (int) $this->format( static::GETTER_FORMATS[ $name ] );

        }

        $getterName = 'get' . \ucfirst( $name );

        if ( \method_exists( $this, $getterName ) )
        {
            return $this->{$getterName}();
        }

        return false;

    }

    #endregion


    #region // - - -   S E T T E R   - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Set an new time.
     *
     * @param array|int|null $hour   The new hour, or a array with hour minute + second,
     *                           or NULL if the current defined should be used.
     * @param int|null       $minute The new minute, or NULL if the current defined should be used.
     * @param int|null       $second The new second, or NULL if the current defined should be used.
     *
     * @return DateTime
     */
    public function setTimeParts( array|int|null $hour = null, ?int $minute = null, ?int $second = null ): DateTime
    {

        if ( \is_array( $hour ) && \count( $hour ) > 0 )
        {

            // $hour is a array with time information

            // Change all array keys to lower case
            $array = \array_change_key_case( $hour );

            if ( isset( $array[ 'hour' ] ) )
            {
                $this->setTime(
                    (int) $array[ 'hour' ],
                    isset( $array[ 'minute' ] ) ? (int) $array[ 'minute' ] : 0,
                    isset( $array[ 'second' ] ) ? (int) $array[ 'second' ] : 0
                );
            }
            else
            {
                $array = \array_values( $array );
                $this->setTime(
                    (int) $array[ 0 ],
                    isset( $array[ 1 ] ) ? (int) $array[ 1 ] : 0,
                    isset( $array[ 2 ] ) ? (int) $array[ 2 ] : 0
                );
            }

            return $this;

        }

        if ( null === $hour )
        {
            $hour = $this->getHour();
        }

        if ( null === $minute )
        {
            $minute = $this->getMinute();
        }

        if ( null === $second )
        {
            $second = $this->getSecond();
        }

        $this->setTime( $hour, $minute, $second );

        return $this;

    }

    /**
     * Set an new time.
     *
     * @param Time $time
     *
     * @return DateTime
     */
    public function changeTime( Time $time ): DateTime
    {

        return $this->setTime( $time->getHour(), $time->getMinute(), $time->getSecond() );

    }

    /**
     * Set an new date part. (The time part will be left unchanged)
     *
     * @param int|null $year  The new year, or NULL if the current defined should be used.
     * @param int|null $month The new month, or NULL if the current defined should be used.
     * @param int|null $day   The new day, or NULL if the current defined should be used.
     *
     * @return DateTime
     */
    public function setDateParts( ?int $year = null, ?int $month = null, ?int $day = null ): DateTime
    {

        $this->setDate(
            null === $year ? $this->getYear() : $year,
            null === $month ? $this->getMonth() : $month,
            null === $day ? $this->getDay() : $day
        );

        return $this;

    }

    /**
     * Sets a date by ISO-8601 conform data.
     *
     * @param int      $year The year
     * @param int      $week The Week number (Weeks begins at monday)
     * @param int|null $day  The day
     *
     * @return DateTime
     */
    public function setISODate( int $year, int $week, ?int $day = null ): DateTime
    {

        parent::setISODate( $year, $week, $day );

        return $this;

    }

    /**
     * Changes the current defined year to defined value.
     *
     * @param int|null $year The new year value. If the value NULL is used it means: Use the year of NOW()
     *
     * @return DateTime
     */
    public final function setYear( ?int $year = null ): DateTime
    {

        if ( null === $year )
        {
            $year = static::CurrentYear();
        }

        return $this->setDateParts( $year );

    }

    /**
     * Changes the current defined month to defined value.
     *
     * @param int|null $month The new month value. If the value NULL is used it means: Use the month of NOW()
     *
     * @return DateTime
     */
    public final function setMonth( ?int $month = null ): DateTime
    {

        if ( null === $month )
        {
            $month = static::CurrentMonth();
        }

        return $this->setDateParts( null, $month );

    }

    /**
     * Changes the current defined day to defined value.
     *
     * @param int|null $day The new day value. If the value NULL is used it means: Use the day of NOW()
     *
     * @return DateTime
     */
    public final function setDay( ?int $day = null ): DateTime
    {

        if ( null === $day )
        {
            $day = static::CurrentDay();
        }

        return $this->setDateParts( null, null, $day );

    }

    /**
     * Changes the current defined hour to defined value.
     *
     * @param int|null $hour The new hour value. If the value NULL is used it means: Use the hour of NOW()
     *
     * @return DateTime
     */
    public final function setHour( ?int $hour = null ): DateTime
    {

        if ( null === $hour )
        {
            $hour = static::CurrentHour();
        }

        return $this->setTimeParts( $hour );

    }

    /**
     * Changes the current defined minute to defined value.
     *
     * @param int|null $minute The new minute value. If the value NULL is used it means: Use the minute of NOW()
     *
     * @return DateTime
     */
    public final function setMinute( ?int $minute = null ): DateTime
    {

        if ( null === $minute )
        {
            $minute = static::CurrentMinute();
        }

        return $this->setTimeParts( null, $minute );

    }

    /**
     * Changes the current defined second to defined value.
     *
     * @param int|null $second The new second value. If the value NULL is used it means: Use the second of NOW()
     *
     * @return DateTime
     */
    public final function setSecond( ?int $second = null ): DateTime
    {

        if ( null === $second )
        {
            $second = static::CurrentSecond();
        }

        return $this->setTimeParts( null, null, $second );

    }

    /**
     * Sets the base value to current defined timestamp, but remember timestamps lets you to use only date times
     * in a limited range!
     *
     * @param int $unixTimestamp The unix timestamp.
     *
     * @return DateTime
     */
    public function setTimestamp( int $unixTimestamp ): DateTime
    {

        parent::setTimestamp( $unixTimestamp );

        return $this;

    }

    /**
     * Sets a new Timezone.
     *
     * @param \DateTimeZone $timezone
     *
     * @return DateTime
     */
    public function setTimezone( \DateTimeZone $timezone ): DateTime
    {

        parent::setTimezone( $timezone );

        return $this;

    }

    #endregion


    #region // - - -   A D D   M E T H O D S   - - - - - - - - - - - - - - - - -

    /**
     * Adds the defined number of seconds.
     *
     * @param integer $seconds The seconds to add (use a negative value to subtract/remove the seconds)
     *
     * @return DateTime Returns the current changed instance.
     * @throws \Exception
     */
    public final function addSeconds( int $seconds = 1 ): DateTime
    {

        return $this->move( new \DateInterval( 'PT' . \abs( $seconds ) . 'S' ), $seconds < 0 );

    }

    /**
     * Move the date time by defined interval.
     *
     * @param \DateInterval $interval
     * @param bool          $negative Move negative?
     *
     * @return DateTime
     */
    public final function move( \DateInterval $interval, bool $negative = false ): DateTime
    {

        if ( $negative )
        {
            $this->sub( $interval );
        }
        else
        {
            $this->add( $interval );
        }

        return $this;

    }

    /**
     * An alias of {@see DateTime::addSeconds}.
     *
     * @param integer $seconds The seconds to add (use a negative value to subtract/remove the seconds)
     *
     * @return DateTime Returns the current changed instance.
     * @throws \Exception
     */
    public final function moveSeconds( int $seconds = 1 ): DateTime
    {

        return $this->addSeconds( $seconds );

    }

    /**
     * Adds the defined number of minutes.
     *
     * @param integer $minutes The minutes to add (use a negative value to subtract/remove the minutes)
     *
     * @return DateTime Returns the current changed instance.
     * @throws \Exception
     */
    public final function addMinutes( int $minutes = 1 ): DateTime
    {

        return $this->move( new \DateInterval( 'PT' . \abs( $minutes ) . 'M' ), $minutes < 0 );

    }

    /**
     * An alias of {@see DateTime::addMinutes}.
     *
     * @param integer $minutes The minutes to add (use a negative value to subtract/remove the minutes)
     *
     * @return DateTime Returns the current changed instance.
     * @throws \Exception
     */
    public final function moveMinutes( int $minutes = 1 ): DateTime
    {

        return $this->move( new \DateInterval( 'PT' . \abs( $minutes ) . 'M' ), $minutes < 0 );

    }

    /**
     * Adds the defined number of hours.
     *
     * @param integer $hours The hours to add (use a negative value to subtract/remove the hours)
     *
     * @return DateTime Returns the current changed instance.
     * @throws \Exception
     */
    public final function addHours( int $hours = 1 ): DateTime
    {

        return $this->move( new \DateInterval( 'PT' . \abs( $hours ) . 'H' ), $hours < 0 );

    }

    /**
     * Adds the defined number of days.
     *
     * @param integer $days The days to add (use a negative value to subtract/remove the days)
     *
     * @return DateTime Returns the current changed instance.
     * @throws \Exception
     */
    public final function addDays( int $days = 1 ): DateTime
    {

        return $this->move( new \DateInterval( 'P' . \abs( $days ) . 'D' ), $days < 0 );

    }

    /**
     * Adds the defined number of years.
     *
     * @param integer $years The years to add (use a negative value to subtract/remove the years)
     *
     * @return DateTime Returns the current changed instance.
     * @throws \Exception
     */
    public final function addYears( int $years = 1 ): DateTime
    {

        return $this->move( new \DateInterval( 'P' . \abs( $years ) . 'Y' ), $years < 0 );

    }

    /**
     * Adds the defined number of weeks.
     *
     * @param integer $weeks The weeks to add (use a negative value to subtract/remove the weeks)
     *
     * @return DateTime Returns the current changed instance.
     * @throws \Exception
     */
    public final function addWeeks( int $weeks = 1 ): DateTime
    {

        return $this->move( new \DateInterval( 'P' . \abs( $weeks ) . 'W' ), $weeks < 0 );

    }

    /**
     * Moves the time part to 23:59:59.
     *
     * @return DateTime Returns the current changed instance.
     */
    public final function moveToEndOfDay(): DateTime
    {

        return $this->setTime( 23, 59, 59 );

    }

    #endregion


    #region // - - -   F O R M A T   M E T H O D S   - - - - - - - - - - - - - -

    /**
     * Formats the current instance to be usable as a SQL Datetime string. Format is: YYYY-mm-dd HH:MM:SS
     *
     * @return string
     */
    public final function formatSqlDateTime(): string
    {

        return $this->format( DateTimeFormat::SQL->value );

    }

    /**
     * Formats the current instance to be usable as a SQL Date string. Format is: YYYY-mm-dd
     *
     * @return string
     */
    public final function formatSqlDate(): string
    {

        return $this->format( DateTimeFormat::SQL_DATE->value );

    }

    /**
     * @inheritdoc
     */
    public final function modify( $modify ): DateTime
    {

        parent::modify( $modify );

        return $this;

    }

    #endregion


    #region // - - -   M A G I C   M E T H O D   O V E R R I D E S   - - - - - -

    /**
     * Returns The date time to be usable as a SQL Datetime string. Format is: Y-m-d H:i:s
     *
     * @return string
     */
    public function __toString()
    {

        return $this->formatSqlDateTime();

    }

    public function __isset( $name )
    {

        if ( \array_key_exists( $name, static::GETTER_FORMATS ) )
        {

            return true;

        }

        return \in_array( $name, [ 'weekOfMonth', 'age', 'quarter', 'daysOfYear', 'isLeapYear' ], true );

    }

    public function __set( $name, $value ) { }

    #endregion


    #region // - - -   O T H E R   M E T H O D S   - - - - - - - - - - - - - - -

    /**
     * Checks if current instance is equal to permitted $value.
     *
     * If $strict is set to TRUE it returns FALSE, if $value is not of type {@see DateTime}.
     *
     * If $strict is set to FALSE $value can also be:
     *
     * - a integer (Unix timestamp)
     * - a \DateTimeInterface instance
     * - a date time string like '2015-04-02' or '2015-04-02 12:00:01' or something other valid format
     *
     * @param mixed   $value  The value to compare with.
     * @param boolean $strict The value must be of type {@see DateTime}? (default=false)
     *
     * @return boolean         Returns TRUE if $value is equal to current instance, FALSE otherwise.
     * @throws \Throwable
     */
    public function equals( mixed $value, bool $strict = false ): bool
    {

        if ( $value instanceof \DateTimeInterface )
        {
            // Strict: The time stamp must be equal
            return $value->format( 'Y-m-d H:i:s' ) === $this->formatSqlDateTime();
        }

        if ( $strict )
        {
            // Strict + $value is no \UK\Date\DateTime instance returns FALSE
            return false;
        }

        $dt = DateTime::Parse( $value );

        if ( !( $dt instanceof DateTime ) )
        {
            return false;
        }

        return $dt->format( 'Y-m-d H:i:s' ) === $this->format( 'Y-m-d H:i:s' );

    }

    #endregion


    #endregion


    #region // – – –   P U B L I C   S T A T I C   M E T H O D S   – – – – – – – – – – – – – – – – –

    /**
     * Parses a value to a \Niirrty\Date\DateTime instance.
     *
     * @param mixed              $datetime The value to parse as DateTime. If can be a date(time) string, a unix timestamp
     *                                     , a object of type \DateTime or something that can be converted, by a string
     *                                     cast, to a valid date(time) string.
     * @param \DateTimeZone|null $timezone An optional TimeZone
     *
     * @return DateTime|bool Returns the created \Niirrty\Date\DateTime instance, or boolean FALSE if
     *                                     parsing fails.
     * @throws \Throwable
     */
    public static function Parse( mixed $datetime, ?\DateTimeZone $timezone = null ): bool|DateTime
    {

        if ( null === $datetime )
        {
            // NULL returns FALSE
            return false;
        }

        if ( $datetime instanceof DateTime )
        {
            // Already a \Niirrty\Date\DateTime => return it.
            return $datetime;
        }

        if ( $datetime instanceof \DateTimeInterface )
        {
            // \DateTime values can be handled directly without some other requirements.
            return new DateTime( $datetime->format( 'y-m-d H:i:s' ), $datetime->getTimezone() );
        }

        if ( is_array( $datetime ) || ( $datetime instanceof \stdClass ) )
        {
            return false;
        }

        if ( TypeTool::IsInteger( $datetime ) )
        {
            // Unix timestamp convert to DateTime string
            $dtime = new \DateTime();
            $dtime->setTimestamp( (int) $datetime );
            if ( null !== $timezone )
            {
                $dtime->setTimezone( $timezone );
            }
            return new DateTime( $dtime->format( 'y-m-d H:i:s' ), $dtime->getTimezone() );
        }

        if ( !\is_string( $datetime ) )
        {
            try
            {
                $type = new Type( $datetime );
            }
            catch ( \Throwable)
            {
                return false;
            }
            if ( ! $type->hasAssociatedString() )
            {
                // Not a string and not convertible to a string.
                return false;
            }
            // Getting the associated string value
            $datetime = $type->getStringValue();
        }

        // $datetime is a string now!

        try
        {
            return new DateTime( $datetime, $timezone );
        }
        catch ( \Throwable )
        {
            $replacements = [ '1.', '2.', '3.', '4.', '5.', '6.', '7.', '8.', '9.', '10.', '11.', '12.' ];
            // Replace all month names and short month names.
            $datetime = \preg_replace(
                static::MONTH_NAMES_SHORT_REGEX,
                $replacements,
                \preg_replace(
                    static::MONTH_NAMES_LONG_REGEX,
                    $replacements,
                    $datetime
                )
            );
            // Replace every thing that's not an [0-9.:+/ -]
            $datetime = \preg_replace( '~\s{2,}~', ' ', \preg_replace( '~[^0-9.:+/-]+~', ' ', $datetime ) );
        }

        if ( '' === \trim( $datetime ) )
        {
            return false;
        }

        try
        {
            return new DateTime( \trim( $datetime ), $timezone );
        }
        catch ( \Throwable )
        {
            return false;
        }

    }

    /**
     * Tries to parse a value as {@see DateTime} and return if it was successful.
     *
     * @param mixed              $value        The value to parse as DateTime. If can be a date(time) string, a unix
     *                                         timestamp, a object of type \DateTime or something that can be converted,
     *                                         by a string cast, to a valid date(time) string.
     * @param DateTime|null      $refDateTime  Returns the DateTime instance if the method returns true
     * @param \DateTimeZone|null $timezone     An optional TimeZone
     *
     * @return bool
     */
    public static function TryParse( mixed $value, ?DateTime &$refDateTime = null, ?\DateTimeZone $timezone = null ) : bool
    {

        $refDateTime = null;

        try
        {
            $dt = static::Parse( $value, $timezone );
            if ( false === $dt ) { return false; }
            $refDateTime = $dt;
            return true;
        }
        catch ( \Throwable )
        {
            return false;
        }

    }

    /**
     * Init's a new instance.
     *
     * @param integer $year   The year
     * @param integer $month  The month number (1-12)
     * @param integer $day    The day of month number (1-31 depending to leap year and month)
     * @param integer $hour   The Hour (0-23)
     * @param integer $minute The Minute (0-59)
     * @param integer $second The Second (0-59)
     *
     * @return DateTime
     */
    public static function Create(
        int $year, int $month, int $day, int $hour = 0, int $minute = 0, int $second = 0 ): DateTime
    {

        $dt = new DateTime();

        $dt->setDate( $year, $month, $day );
        $dt->setTime( $hour, $minute, $second );

        return $dt;

    }

    /**
     * Create a DateTime instance from PHP \DateTime instance.
     *
     * @param \DateTime $dt
     *
     * @return DateTime
     * @throws \Throwable
     */
    public static function FromDateTime( \DateTime $dt ): DateTime
    {

        if ( $dt instanceof DateTime )
        {
            return clone $dt;
        }

        return new DateTime( $dt->format( 'Y-m-d H:i:s.u' ), $dt->getTimezone() );

    }

    /**
     * @param int                $timestamp
     * @param \DateTimeZone|null $timezone
     *
     * @return DateTime
     * @throws \Throwable
     */
    public static function FromTimestamp( int $timestamp, ?\DateTimeZone $timezone = null ): DateTime
    {

        return static::Now( $timezone )->setTimestamp( $timestamp );

    }

    /**
     * Create a DateTime instance from a specific format.
     *
     * @param string             $format
     * @param string             $time
     * @param \DateTimeZone|null $timezone
     *
     * @return DateTime
     * @throws ArgumentException
     * @throws \Throwable
     */
    public static function FromFormat( string $format, string $time, ?\DateTimeZone $timezone = null ): DateTime
    {

        if ( $timezone !== null )
        {
            $dt = parent::createFromFormat( $format, $time, $timezone );
        }
        else
        {
            $dt = parent::createFromFormat( $format, $time );
        }

        if ( $dt instanceof \DateTime )
        {
            return static::FromDateTime( $dt );
        }

        throw new ArgumentException(
            'format',
            $format,
            \implode( \PHP_EOL, parent::getLastErrors() )
        );

    }

    /**
     * Create a DateTime instance from an UTC timestamp.
     *
     * @param int $timestamp
     *
     * @return DateTime
     * @throws \Throwable
     */
    public static function FromTimestampUTC( int $timestamp ): DateTime
    {

        return ( new DateTime( '@' . $timestamp ) )->setTimezone( new \DateTimeZone( 'UTC' ) );

    }

    /**
     * Returns the current year.
     *
     * @return integer
     */
    public static function CurrentYear(): int
    {

        return (int) \date( 'Y' );

    }

    /**
     * Returns the current month.
     *
     * @return integer
     */
    public static function CurrentMonth(): int
    {

        return (int) \date( 'm' );

    }

    /**
     * Returns the current day of month.
     *
     * @return integer
     */
    public static function CurrentDay(): int
    {

        return (int) \date( 'd' );

    }

    /**
     * Returns the current hour.
     *
     * @return integer
     */
    public static function CurrentHour(): int
    {

        return (int) \date( 'H' );

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
     * Returns the current microsecond.
     *
     * @return integer
     */
    public static function CurrentMicroSecond(): int
    {

        $dt = new \DateTime();

        return (int) $dt->format( 'u' );

    }

    /**
     * Init's a \Niirrty\Date\DateTime with current DateTime and returns it.
     *
     * @param \DateTimeZone|null $timezone
     * @param boolean            $useDayStart Set 00:00:00 as time? (default=FALSE)
     * @param boolean            $useDayEnd   Set 23:59:59 as time? (default=FALSE)
     *
     * @return DateTime
     * @throws \Throwable
     */
    public static function Now(
        ?\DateTimeZone $timezone = null, bool $useDayStart = false, bool $useDayEnd = false ): DateTime
    {

        $dt = new DateTime( 'now', $timezone );

        if ( $useDayStart )
        {
            $dt->setTime( 0, 0 );
        }
        else if ( $useDayEnd )
        {
            $dt->setTime( 23, 59, 59 );
        }

        return $dt;

    }

    /**
     * Gets the last change DateTime of defined file.
     *
     * @param string  $file              Get the last change time from this file.
     * @param boolean $checkIfFileExists Check if the file exists, before getting the datetime. (default=FALSE)
     *
     * @return DateTime|bool Returns the DateTime, or boolean FALSE if does not exist or is not
     *                                     accessible by PHP.
     */
    public static function FromFile( string $file, bool $checkIfFileExists = false ): bool|DateTime
    {

        if ( $checkIfFileExists && !\file_exists( $file ) )
        {
            return false;
        }

        try
        {
            return DateTime::Parse( \filemtime( $file ) );
        }
        catch ( \Throwable $ex )
        {
            unset( $ex );

            return false;
        }

    }

    /**
     * Gets the days of the defined month in defined year.
     *
     * @param integer $year
     * @param integer $month
     *
     * @return integer
     */
    public static function GetDaysInMonth( int $year, int $month ): int
    {

        $dt = new \DateTime();
        $dt->setDate( $year, $month, 2 );
        $dt->setTime( 0, 0, 2 );

        return (int) $dt->format( 't' );

    }

    /**
     * Create a DateTime instance for the greatest supported date.
     *
     * @return DateTime
     * @throws \Throwable
     */
    public static function MaxValue(): DateTime
    {

        if ( \PHP_INT_SIZE === 4 )
        {
            // 32 bit (+ Win 64 bit)
            return static::FromTimestamp( \PHP_INT_MAX );
        }

        // 64 bit
        return static::Create( 9999, 12, 31, 23, 59, 59 );

    }

    /**
     * Create a DateTime instance for the lowest supported date.
     *
     * @return DateTime
     * @throws \Throwable
     */
    public static function MinValue(): DateTime
    {

        if ( \PHP_INT_SIZE === 4 )
        {
            // 32 bit (+ Win 64 bit)
            return static::FromTimestamp( ~PHP_INT_MAX );
        }

        // 64 bit
        return static::Create( 1, 1, 1 );

    }

    /**
     * Get the date time for easter sunday at defined year
     *
     * @param int $year
     *
     * @return DateTime
     * @throws \Throwable
     */
    public static function EasterSunday( int $year ): DateTime
    {

        if ( $year > 1969 && $year < 2038 )
        {

            $dt = new DateTime( '@' . \easter_date( $year ) );

        }
        else
        {

            $gz = ( $year % 19 ) + 1;
            $jhd = self::div( $year, 100 ) + 1;
            $ksj = self::div( 3 * $jhd, 4 ) - 12;
            $corr = self::div( 8 * $jhd + 5, 25 ) - 5;
            $so = self::div( 5 * $year, 4 ) - $ksj - 10;
            $pakte = ( ( 11 * $gz + 20 + $corr - $ksj ) % 30 );

            if ( ( $pakte === 25 || $gz === 11 ) && $pakte === 24 )
            {
                $pakte++;
            }

            $n = 44 - $pakte;
            if ( $n < 21 )
            {
                $n += 30;
            }
            $n = $n + 7 - ( ( $so + $n ) % 7 );
            $n += self::LeapYear( $year )
                ? 1
                : 0;
            $n += 59;
            $a = self::LeapYear( $year )
                ? 1
                : 0;

            // Month
            $nm = $n;
            if ( $nm > ( 59 + $a ) )
            {
                $nm = $nm + 2 - $a;
            }
            $nm += 91;
            $month = self::div( 20 * $nm, 611 ) - 2;

            // Day
            $nt = $n;
            if ( $nt > ( 59 + $a ) )
            {
                $nt = $nt + 2 - $a;
            }
            $nt += 91;
            $m = self::div( 20 * $nt, 611 );
            $day = $nt - self::div( 611 * $m, 20 );

            $dt = DateTime::Create( $year, $month, $day );

        }

        if ( false === $dt->getTimezone()->getLocation() ||
             '+00:00' === $dt->getTimezone()->getName() )
        {
            $dt->setTimezone( new \DateTimeZone( 'Europe/Berlin' ) );
        }

        return $dt;

    }

    protected static function div( $a, $b ): float|int
    {

        return ( $a - ( $a % $b ) ) / $b;

    }

    /**
     * Gets if the defined year is a leap year.
     *
     * @param int $year
     *
     * @return bool
     */
    public static function LeapYear( int $year ): bool
    {

        return (
            ( ( $year % 4 == 0 ) and !( $year % 100 == 0 ) )
            and
            ( $year % 400 != 0 )
        );

    }

    #endregion


    /**
     * @throws \Throwable
     */
    public static function FromString( string $str, bool $throwOnError = false ) : bool|static
    {
        if ( $throwOnError )
        {
            return static::Parse( $str );
        }
        try
        {
            return static::Parse( $str );
        }
        catch ( \Throwable )
        {
            return false;
        }
    }

}

