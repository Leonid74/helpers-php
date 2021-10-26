<?php

/**
 * Helper class for processing URL/URI strings
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

class UrlHelper
{
    /**
     * Add a trailing slash to the string
     *
     * UrlHelper::addTrailingSlash('https://aaa.bbb.ccc');   // returns 'https://aaa.bbb.ccc/'
     * UrlHelper::addTrailingSlash('https://aaa.bbb.ccc/');  // returns 'https://aaa.bbb.ccc/'
     *
     * @param string $sUrl
     *
     * @return string
     */
    public static function addTrailingSlash( ?string $sUrl = '' ): string
    {
        if ( '' === $sUrl || \is_null( $sUrl ) ) {
            return '/';
        }

        return \rtrim( $sUrl, '/' ) . '/';
    }

    /**
     * Remove a trailing slash from the string
     *
     * UrlHelper::removeTrailingSlash('https://aaa.bbb.ccc/');  // returns 'https://aaa.bbb.ccc'
     *
     * @param string $sUrl
     *
     * @return string
     */
    public static function removeTrailingSlash( ?string $sUrl = '' ): string
    {
        if ( '' === $sUrl || \is_null( $sUrl ) ) {
            return '';
        }

        return \rtrim( $sUrl, '/' );
    }

    /**
     * Add a slash to the beginning of the string
     *
     * UrlHelper::prependSlash('aaa/bbb/ccc');   // returns '/aaa/bbb/ccc'
     * UrlHelper::prependSlash('/aaa/bbb/ccc');  // returns '/aaa/bbb/ccc'
     *
     * @param string $sUrl
     *
     * @return string
     */
    public static function prependSlash( ?string $sUrl = '' ): string
    {
        if ( '' === $sUrl || \is_null( $sUrl ) ) {
            return '/';
        }

        return '/' . \ltrim( $sUrl, '/' );
    }

    /**
     * Gets the hostname without the scheme prefix only
     *
     * UrlHelper::getHostOnly('https://aaa.bbb.ccc:9090/path?arg=value#anchor');  // returns 'aaa.bbb.ccc'
     *
     * @param string $sUrl
     *
     * @return string
     */
    public static function getHostOnly( ?string $sUrl = '' ): string
    {
        if ( '' === $sUrl || \is_null( $sUrl ) ) {
            return '';
        }

        $aParsedUrl = \parse_url( \trim( $sUrl ) );

        return $aParsedUrl['host'] ? $aParsedUrl['host'] : \array_shift( \explode( '/', $aParsedUrl['path'], 2 ) );
    }

    /**
     * Gets the hostname with the scheme prefix only
     *
     * UrlHelper::getHostWithScheme('https://aaa.bbb.ccc:9090/path?arg=value#anchor');  // returns 'https://aaa.bbb.ccc'
     *
     * @param string $sUrl
     *
     * @return string
     */
    public static function getHostWithScheme( ?string $sUrl = '' ): string
    {
        if ( '' === $sUrl || \is_null( $sUrl ) ) {
            return '';
        }

        $aParsedUrl = \parse_url( \trim( $sUrl ) );

        return $aParsedUrl['scheme'] . '://' . ( $aParsedUrl['host'] ? $aParsedUrl['host'] : \array_shift( \explode( '/', $aParsedUrl['path'], 2 ) ) );
    }

    /**
     * Gets the hostname with the scheme prefix and path only
     *
     * UrlHelper::getHostWithSchemeAndPath('https://aaa.bbb.ccc:9090/path?arg=value#anchor');  // returns 'https://aaa.bbb.ccc/path'
     *
     * @param string $sUrl
     *
     * @return string
     */
    public static function getHostWithSchemeAndPath( ?string $sUrl = '' ): string
    {
        if ( '' === $sUrl || \is_null( $sUrl ) ) {
            return '';
        }

        $aParsedUrl = \parse_url( \trim( $sUrl ) );

        return $aParsedUrl['scheme'] . '://' . ( $aParsedUrl['host'] ? $aParsedUrl['host'] . $aParsedUrl['path'] : \array_shift( \explode( '/', $aParsedUrl['path'], 2 ) ) );
    }
}
