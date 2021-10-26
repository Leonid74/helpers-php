<?php

/**
 * Helper class for processing strings
 *
 * This file is part of the project.
 *
 * @author Leonid Sheikman (leonid74)
 * @copyright 2019-2021 Leonid Sheikman
 * @see https://github.com/Leonid74/helpers-php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leonid74\Helpers;

class StringHelper
{
    /**
     * Remove BOM from the string
     *
     * @param string $sString
     *
     * @return string
     */
    public static function removeBOM( ?string $sString = '' ): string
    {
        if ( '' === $sString || is_null( $sString ) ) {
            return '';
        }

        return 0 === \strncasecmp( \pack( 'CCC', 0xef, 0xbb, 0xbf ), $sString, 3 ) ? \mb_substr( $sString, 3 ) : $sString;
    }

    /**
     * Truncates the string to the specified length with the specified suffix (optional).
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
    public static function truncateString( ?string $sString = '', int $iLength = 100, string $sSuffix = '...' ): string
    {
        if ( '' === $sString || is_null( $sString ) ) {
            return '';
        }

        if ( $iLength <= 0 || \mb_strlen( $sString ) <= $iLength ) {
            return $sString;
        }

        return \mb_substr( $sString, 0, $iLength - \mb_strlen( $sSuffix ) ) . $sSuffix;
    }
}
