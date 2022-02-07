<?php

/**
 * Helper class for processing strings
 *
 * Вспомогательный класс для обработки строк
 *
 * @author Leonid Sheikman (leonid74)
 * @copyright 2019-2022 Leonid Sheikman
 * @see https://github.com/Leonid74/helpers-php
 *
 * This file is part of the project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leonid74\Helpers;

class StringHelper
{
    /**
     * Set the encoding by default
     */
    public static $encoding = 'UTF-8';

    /**
     * Most used common php functions.
     */
    // @codingStandardsIgnoreLine
    public static function mb_stristr( string $haystack, string $needle, bool $before_needle = false )
    {
        return function_exists( 'mb_stristr' )
            ? \mb_stristr( $haystack, $needle, $before_needle, static::$encoding )
            : \stristr( $haystack, $needle, $before_needle );
    }

    // @codingStandardsIgnoreLine
    public static function mb_strstr( string $haystack, string $needle, bool $before_needle = false )
    {
        return function_exists( 'mb_strstr' )
            ? \mb_strstr( $haystack, $needle, $before_needle, static::$encoding )
            : \strstr( $haystack, $needle, $before_needle );
    }

    // @codingStandardsIgnoreLine
    public static function mb_stripos( string $haystack, string $needle, int $start = 0 )
    {
        return function_exists( 'mb_stripos' )
            ? \mb_stripos( $haystack, $needle, $start, static::$encoding )
            : \stripos( $haystack, $needle, $start );
    }

    // @codingStandardsIgnoreLine
    public static function mb_strripos( string $haystack, string $needle, int $start = 0 )
    {
        return function_exists( 'mb_strripos' )
            ? \mb_strripos( $haystack, $needle, $start, static::$encoding )
            : \strripos( $haystack, $needle, $start );
    }

    // @codingStandardsIgnoreLine
    public static function mb_strpos( string $haystack, string $needle, int $start = 0 )
    {
        return function_exists( 'mb_strpos' )
            ? \mb_strpos( $haystack, $needle, $start, static::$encoding )
            : \strpos( $haystack, $needle, $start );
    }

    // @codingStandardsIgnoreLine
    public static function mb_strrpos( string $haystack, string $needle, int $start = 0 )
    {
        return function_exists( 'mb_strrpos' )
            ? \mb_strrpos( $haystack, $needle, $start, static::$encoding )
            : \strrpos( $haystack, $needle, $start );
    }

    // @codingStandardsIgnoreLine
    public static function mb_substr( string $string, int $start, int $length = null ): string
    {
        return function_exists( 'mb_substr' )
            ? \mb_substr( $string, $start, $length, static::$encoding )
            : \substr( $string, $start, $length );
    }

    // @codingStandardsIgnoreLine
    public static function mb_strlen( ?string $string = '' ): int
    {
        if ( '' === $string || \is_null( $string ) ) {
            return 0;
        }

        return function_exists( 'mb_strlen' )
            ? \mb_strlen( $string, static::$encoding )
            : \strlen( $string );
    }

    // @codingStandardsIgnoreLine
    public static function mb_strtolower( ?string $string = '' ): string
    {
        if ( '' === $string || \is_null( $string ) ) {
            return '';
        }

        return function_exists( 'mb_strtolower' )
            ? \mb_strtolower( $string, static::$encoding )
            : \strtolower( $string );
    }

    // @codingStandardsIgnoreLine
    public static function mb_strtoupper( ?string $string = '' ): string
    {
        if ( '' === $string || \is_null( $string ) ) {
            return '';
        }

        return function_exists( 'mb_strtoupper' )
            ? \mb_strtoupper( $string, static::$encoding )
            : \strtoupper( $string );
    }

    // @codingStandardsIgnoreLine
    public static function mb_ucfirst( ?string $string = '' ): string
    {
        if ( '' === $string || \is_null( $string ) ) {
            return '';
        }

        return self::mb_strtoupper( self::mb_substr( $string, 0, 1 ) ) . self::mb_substr( $string, 1 );
    }

    // @codingStandardsIgnoreLine
    public static function mb_convert_case( ?string $string = '' ): string
    {
        if ( '' === $string || \is_null( $string ) ) {
            return '';
        }

        return function_exists( 'mb_convert_case' )
            ? \mb_convert_case( $string, MB_CASE_TITLE, static::$encoding )
            : \ucfirst( $string );
    }

    // @codingStandardsIgnoreLine
    public static function htmlspecialchars( ?string $string = '' ): string
    {
        if ( '' === $string || \is_null( $string ) ) {
            return '';
        }

        return \htmlspecialchars( $string, ENT_COMPAT | ENT_SUBSTITUTE | ENT_HTML5, static::$encoding );
    }

    // @codingStandardsIgnoreLine
    public static function htmlspecialchars_decode( ?string $string = '' ): string
    {
        if ( '' === $string || \is_null( $string ) ) {
            return '';
        }

        return \htmlspecialchars_decode( $string, ENT_COMPAT | ENT_HTML5 );
    }

    // @codingStandardsIgnoreLine
    public static function htmlentities( ?string $string = '' ): string
    {
        if ( '' === $string || \is_null( $string ) ) {
            return '';
        }

        return \htmlentities( $string, ENT_COMPAT | ENT_SUBSTITUTE | ENT_HTML5, static::$encoding );
    }

    // @codingStandardsIgnoreLine
    public static function html_entity_decode( ?string $string = '' ): string
    {
        if ( '' === $string || \is_null( $string ) ) {
            return '';
        }

        return \html_entity_decode( $string, ENT_COMPAT | ENT_HTML5, static::$encoding );
    }

    // @codingStandardsIgnoreLine
    public static function utf8_urldecode( ?string $string = '' ): string
    {
        if ( '' === $string || \is_null( $string ) ) {
            return '';
        }

        $string = \preg_replace( "/%u([0-9a-f]{3,4})/i", "&#x\\1;", \urldecode( $string ) );
        return self::html_entity_decode( $string );
    }

    /**
     * Add BOM to the beginning of the string
     *
     * Добавление BOM в начало строки
     *
     * @param string $sString
     *
     * @return string
     */
    public static function addBOM( ?string $sString = '' ): string
    {
        if ( '' === $sString || \is_null( $sString ) ) {
            return '';
        }

        return \chr( 0xEF ) . \chr( 0xBB ) . \chr( 0xBF ) . $sString;
    }

    /**
     * Remove BOM from the beginning of the string
     *
     * Удаление BOM из начала строки
     *
     * @param string $sString
     *
     * @return string
     */
    public static function removeBOM( ?string $sString = '' ): string
    {
        if ( '' === $sString || \is_null( $sString ) ) {
            return '';
        }

        return 0 === \strncasecmp( \pack( 'CCC', 0xef, 0xbb, 0xbf ), $sString, 3 ) ? \mb_substr( $sString, 3 ) : $sString;
    }

    /**
     * Truncates the string to the specified length with the specified suffix (optional).
     *
     * Усекает строку до указанной длины с указанным суффиксом (опционально).
     *
     * StringHelper::truncateString('Lorem ipsum inum', 10);         // returns 'Lorem i...'
     * StringHelper::truncateString('Lorem ipsum inum', 15, '>>>');  // returns 'Lorem ipsum >>>'
     *
     * @param string $sString
     * @param int    $iLength (defaults to 100)
     * @param string $sSuffix (optional, defaults to '...')
     *
     * @return string
     */
    public static function truncateString( ?string $sString = '', ?int $iLength = 100, ?string $sSuffix = '...' ): string
    {
        if ( '' === $sString || \is_null( $sString ) ) {
            return '';
        }

        if ( $iLength <= 0 || \mb_strlen( $sString ) <= $iLength ) {
            return $sString;
        }

        return \mb_substr( $sString, 0, $iLength - \mb_strlen( $sSuffix ) ) . $sSuffix;
    }

    /**
     * Generating a unique UUID of type 4a27ab2e-ae70-419f-9a26-42a67805d87e.
     *
     * Генерация уникального UUID типа 4a27ab2e-ae70-419f-9a26-42a67805d87e.
     *
     * @return string
     *
     * @author myrusakov.ru
     * @edit   Leonid Sheikman (leonid74)
     */
    public static function generateUUID(): string
    {
        return \sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            \mt_rand( 0, 0xffff ),
            \mt_rand( 0, 0xffff ),
            \mt_rand( 0, 0xffff ),
            \mt_rand( 0, 0x0fff ) | 0x4000,
            \mt_rand( 0, 0x3fff ) | 0x8000,
            \mt_rand( 0, 0xffff ),
            \mt_rand( 0, 0xffff ),
            \mt_rand( 0, 0xffff )
        );
    }

    /**
     * Gets a prefixed real unique identifier based on the cryptographically secure function if it possible.
     *
     * Получаем действительно уникальный идентификатор (с префиксом), основанный на криптографически безопасных функциях, если они доступны.
     *
     * @param int    $length length of the unique identifier
     * @param string $prefix prefix of the unique identifier
     *
     * @return string
     */
    public static function generateUniqId( int $length = 5, string $prefix = '' ): string
    {
        if ( function_exists( 'random_bytes' ) ) {
            $bytes = \random_bytes( (int) \ceil( $length / 2 ) );
            return $prefix . \substr( \bin2hex( $bytes ), 0, $length );
        } elseif ( function_exists( 'openssl_random_pseudo_bytes' ) ) {
            $bytes = \openssl_random_pseudo_bytes( (int) \ceil( $length / 2 ) );
            return $prefix . \substr( \bin2hex( $bytes ), 0, $length );
        } else {
            return \substr( \str_shuffle( '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' ), 0, $length );
        }
    }
}
