<?php declare(strict_types=1);

/**
 * Helper class for processing URL/URI strings
 *
 * This file is part of the project.
 *
 * @author Leonid Sheikman (leonid74)
 * @copyright 2019-2024 Leonid Sheikman
 *
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
     * @param string|null $sUrl
     *
     * @return string
     */
    public static function addTrailingSlash(?string $sUrl = ''): string
    {
        if (null === $sUrl || '' === $sUrl) {
            return '/';
        }

        return \rtrim($sUrl, '/') . '/';
    }

    /**
     * Remove a trailing slash from the string
     *
     * UrlHelper::removeTrailingSlash('https://aaa.bbb.ccc/');  // returns 'https://aaa.bbb.ccc'
     *
     * @param string|null $sUrl
     *
     * @return string
     */
    public static function removeTrailingSlash(?string $sUrl = ''): string
    {
        if (null === $sUrl || '' === $sUrl) {
            return '';
        }

        return \rtrim($sUrl, '/');
    }

    /**
     * Add a slash to the beginning of the string
     *
     * UrlHelper::prependSlash('aaa/bbb/ccc');   // returns '/aaa/bbb/ccc'
     * UrlHelper::prependSlash('/aaa/bbb/ccc');  // returns '/aaa/bbb/ccc'
     *
     * @param string|null $sUrl
     *
     * @return string
     */
    public static function prependSlash(?string $sUrl = ''): string
    {
        if (null === $sUrl || '' === $sUrl) {
            return '/';
        }

        return '/' . \ltrim($sUrl, '/');
    }

    /**
     * Gets the hostname without the scheme prefix only
     *
     * UrlHelper::getHostOnly('https://aaa.bbb.ccc:9090/path?arg=value#anchor');  // returns 'aaa.bbb.ccc'
     *
     * @param string|null $sUrl
     *
     * @return string
     */
    public static function getHostOnly(?string $sUrl = ''): string
    {
        if (null === $sUrl || '' === $sUrl) {
            return '';
        }

        $aParsedUrl = \parse_url(\trim($sUrl));

        return $aParsedUrl['host'] ? $aParsedUrl['host'] : \array_shift(\explode('/', $aParsedUrl['path'], 2));
    }

    /**
     * Gets the hostname with the scheme prefix only
     *
     * UrlHelper::getHostWithScheme('https://aaa.bbb.ccc:9090/path?arg=value#anchor');  // returns 'https://aaa.bbb.ccc'
     *
     * @param string|null $sUrl
     *
     * @return string
     */
    public static function getHostWithScheme(?string $sUrl = ''): string
    {
        if (null === $sUrl || '' === $sUrl) {
            return '';
        }

        $aParsedUrl = \parse_url(\trim($sUrl));

        return $aParsedUrl['scheme'] . '://' . ($aParsedUrl['host'] ? $aParsedUrl['host'] : \array_shift(\explode('/', $aParsedUrl['path'], 2)));
    }

    /**
     * Gets the hostname with the scheme prefix and path only
     *
     * UrlHelper::getHostWithSchemeAndPath('https://aaa.bbb.ccc:9090/path?arg=value#anchor');  // returns 'https://aaa.bbb.ccc/path'
     *
     * @param string|null $sUrl
     *
     * @return string
     */
    public static function getHostWithSchemeAndPath(?string $sUrl = ''): string
    {
        if (null === $sUrl || '' === $sUrl) {
            return '';
        }

        $aParsedUrl = \parse_url(\trim($sUrl));

        return $aParsedUrl['scheme'] . '://' . ($aParsedUrl['host'] ? $aParsedUrl['host'] . $aParsedUrl['path'] : \array_shift(\explode('/', $aParsedUrl['path'], 2)));
    }

    /**
     * base64 variant encoding with replace characters (=+/) in result string
     *
     * @param string|null $sUrl string to encode
     *
     * @return string encoded base64url string
     */
    public static function base64EncodeUrl(?string $sUrl = ''): string
    {
        if (null === $sUrl || '' === $sUrl) {
            return '';
        }

        return \str_replace(['+', '/', '='], ['-', '_', ''], \base64_encode($sUrl));
    }

    /**
     * base64 variant decoding with replace characters (-_) in result string
     *
     * @param string|null $sUrl string to decode
     *
     * @return string decoded base64url string
     */
    public static function base64DecodeUrl(?string $sUrl = ''): string
    {
        if (null === $sUrl || '' === $sUrl) {
            return '';
        }

        return \base64_decode(\str_replace(['-', '_'], ['+', '/'], $sUrl));
    }
}
