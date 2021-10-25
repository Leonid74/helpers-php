<?php declare( strict_types=1 );
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
     * Add a trailing slash to the string
     *
     * @param string $sString
     *
     * @return string
     */
    public static function addTrailingSlash( string $sString = '' ): string
    {
        return \rtrim( $sString, '/' ) . '/';
    }

    /**
     * Remove a trailing slash from the string
     *
     * @param string $sString
     *
     * @return string
     */
    public static function removeTrailingSlash( string $sString = '' ): string
    {
        return \rtrim( $sString, '/' );
    }

    /**
     * Add a slash to the beginning of the string
     *
     * @param string $sString
     *
     * @return string
     */
    public static function prependSlash( string $sString = '' ): string
    {
        return '/' . \ltrim( $sString, '/' );
    }

    /**
     * Remove BOM from the string
     *
     * @param string $sString
     *
     * @return string
     */
    public static function removeBOM( string $sString = '' ): string
    {
        return 0 === \strncasecmp( \pack( 'CCC', 0xef, 0xbb, 0xbf ), $sString, 3 ) ? \mb_substr( $sString, 3 ) : $sString;
    }

    /**
     * Truncates the string to the specified length with the specified suffix (optional).
     *
     * StringHelper::truncateString('Lorem ipsum inum', 10);         // returns 'Lorem i...'
     * StringHelper::truncateString('Lorem ipsum inum', 15, '>>>');  // returns 'Lorem ipsum >>>'
     *
     * @param string $sString
     * @param int    $iLength
     * @param string $sSuffix (optional, defaults to '...')
     *
     * @return string
     */
    public static function truncateString( string $sString, int $iLength, ?string $sSuffix = '...' ): string
    {
        $iLengthOfSuffix = \mb_strlen( $sSuffix );

        if ( \mb_strlen( $sString ) <= ( $iLength - $iLengthOfSuffix ) ) {
            return $sString;
        }

        $sTruncatedString = \mb_substr( $sString, 0, $iLength - $iLengthOfSuffix );

        return $sTruncatedString . $sSuffix;
    }
}
