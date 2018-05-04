<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright  (c) 2017, Niirrty
 * @package        Niirrty\Date
 * @since          2017-03-20
 * @version        0.2.0
 */


declare( strict_types = 1 );


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
   const ATOM     = \DateTime::ATOM;

   /**
    * Cookie date time format. 'l, d-M-Y H:i:s T' for example 'Monday, 15-Aug-05 15:52:01 UTC'
    */
   const COOKIE   = \DateTime::COOKIE;

   /**
    * ISO 8601 date time format. 'Y-m-d\TH:i:sO' for example '2005-08-15T15:52:01+0000'
    */
   const ISO8601  = \DateTime::ISO8601;

   /**
    * RFC 822 date time format. 'D, d M y H:i:s O' for example 'Mon, 15 Aug 05 15:52:01 +0000'
    */
   const RFC822   = \DateTime::RFC822;

   /**
    * RFC 850 date time format. 'l, d-M-y H:i:s T' for example 'Monday, 15-Aug-05 15:52:01 UTC'
    */
   const RFC850   = \DateTime::RFC850;

   /**
    * RFC 1036 date time format. 'D, d M y H:i:s O' for example 'Mon, 15 Aug 05 15:52:01 +0000'
    */
   const RFC1036  = \DateTime::RFC1036;

   /**
    * RFC 1123 date time format. 'D, d M Y H:i:s O' for example 'Mon, 15 Aug 2005 15:52:01 +0000'
    */
   const RFC1123  = \DateTime::RFC1123;

   /**
    * RFC 2822 date time format. 'D, d M Y H:i:s O' for example 'Mon, 15 Aug 2005 15:52:01 +0000'
    */
   const RFC2822  = \DateTime::RFC2822;

   /**
    * RFC 3339 date time format. 'Y-m-d\TH:i:sP' for example '2005-08-15T15:52:01+00:00'
    */
   const RFC3339  = \DateTime::RFC3339;

   /**
    * RSS feed date time format. 'D, d M Y H:i:s O' for example 'Mon, 15 Aug 2005 15:52:01 +0000'
    */
   const RSS      = \DateTime::RSS;

   /**
    * W3C (World Wide Web Consortium) date time format. 'Y-m-d\TH:i:sP' for example '2005-08-15T15:52:01+00:00'
    */
   const W3C      = \DateTime::W3C;

   /**
    * SQL date time format without time zone. 'Y-m-d H:i:s' for example '2005-08-15 15:52:01'
    */
   const SQL      = 'Y-m-d H:i:s';

   /**
    * SQL date time format with time zone. 'Y-m-d H:i:s T' for example '2005-08-15 15:52:01 UTC'
    */
   const SQL_TZ   = 'Y-m-d H:i:s T';

   /**
    * SQL date format. 'Y-m-d' for example '2005-08-15'
    */
   const SQL_DATE = 'Y-m-d';

   /**
    * SQL time format. 'H:i:s' for example '15:52:01'
    */
   const SQL_TIME = 'H:i:s';

   /**
    * Date format. 'Y-m-d' for example '2005-08-15'
    */
   const DATE = 'Y-m-d';

   /**
    * Time format. 'H:i:s' for example '15:52:01'
    */
   const TIME = 'H:i:s';

}

