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


/**
 * This fake enum declares a lot of pre defined date, time and date time formats.
 *
 * @since v0.1.0
 */
interface DateTimeFormat
{


    /**
     * Atom feed date time format. 'Y-m-d\TH:i:sP' for example '2005-08-15T15:52:01+00:00'
     */
    public const ATOM = 'Y-m-d\TH:i:sP';

    /**
     * Cookie date time format. 'l, d-M-Y H:i:s T' for example 'Monday, 15-Aug-05 15:52:01 UTC'
     */
    public const COOKIE = 'l, d-M-Y H:i:s T';

    /**
     * ISO 8601 date time format. 'Y-m-d\TH:i:sO' for example '2005-08-15T15:52:01+0000'
     */
    public const ISO8601 = 'Y-m-d\TH:i:sO';

    /**
     * RFC 822 date time format. 'D, d M y H:i:s O' for example 'Mon, 15 Aug 05 15:52:01 +0000'
     */
    public const RFC822 = 'D, d M y H:i:s O';

    /**
     * RFC 850 date time format. 'l, d-M-y H:i:s T' for example 'Monday, 15-Aug-05 15:52:01 UTC'
     */
    public const RFC850 = 'l, d-M-y H:i:s T';

    /**
     * RFC 1036 date time format. 'D, d M y H:i:s O' for example 'Mon, 15 Aug 05 15:52:01 +0000'
     */
    public const RFC1036 = 'D, d M y H:i:s O';

    /**
     * RFC 1123 date time format. 'D, d M Y H:i:s O' for example 'Mon, 15 Aug 2005 15:52:01 +0000'
     */
    public const RFC1123 = 'D, d M Y H:i:s O';

    /**
     * RFC 2822 date time format. 'D, d M Y H:i:s O' for example 'Mon, 15 Aug 2005 15:52:01 +0000'
     */
    public const RFC2822 = 'D, d M Y H:i:s O';

    /**
     * RFC 3339 date time format. 'Y-m-d\TH:i:sP' for example '2005-08-15T15:52:01+00:00'
     */
    public const RFC3339 = 'Y-m-d\TH:i:sP';

    /**
     * RSS feed date time format. 'D, d M Y H:i:s O' for example 'Mon, 15 Aug 2005 15:52:01 +0000'
     */
    public const RSS = 'D, d M Y H:i:s O';

    /**
     * W3C (World Wide Web Consortium) date time format. 'Y-m-d\TH:i:sP' for example '2005-08-15T15:52:01+00:00'
     */
    public const W3C = 'Y-m-d\TH:i:sP';

    /**
     * SQL date time format without time zone. 'Y-m-d H:i:s' for example '2005-08-15 15:52:01'
     */
    public const SQL = 'Y-m-d H:i:s';

    /**
     * SQL date time format with time zone. 'Y-m-d H:i:s T' for example '2005-08-15 15:52:01 UTC'
     */
    public const SQL_TZ = 'Y-m-d H:i:s T';

    /**
     * SQL date format. 'Y-m-d' for example '2005-08-15'
     */
    public const SQL_DATE = 'Y-m-d';

    /**
     * SQL time format. 'H:i:s' for example '15:52:01'
     */
    public const SQL_TIME = 'H:i:s';

    /**
     * Date format. 'Y-m-d' for example '2005-08-15'
     */
    public const DATE = 'Y-m-d';

    /**
     * Time format. 'H:i:s' for example '15:52:01'
     */
    public const TIME = 'H:i:s';


}

