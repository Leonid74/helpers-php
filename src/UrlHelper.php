<?php declare( strict_types=1 );
/**
 * Helper class for processing URL/URI strings
 * Класс для обработки данных из строк URL/URI
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
     * Gets hostname only
     * Получаем имя хоста без схемы (hostname.ru).
     *
     * @param string $urlAddress 'http://username:password@hostname:9090/path?arg=value#anchor'
     *
     * @return string hostname.ru
     *
     * @author Leonid Sheikman <leonid@sheikman.ru>
     */
    public static function getHostOnly( string $urlAddress = '' ): string
    {
        if ( empty( $urlAddress ) ) {
            return '';
        }

        $parseUrl = parse_url( trim( $urlAddress ) );

        return trim( $parseUrl['host'] ? $parseUrl['host'] : array_shift( explode( '/', $parseUrl['path'], 2 ) ) );
    }

    /**
     * Gets hostname and scheme only
     * Получаем имя хоста со схемой (https://hostname.ru).
     *
     * @param string $urlAddress 'http://username:password@hostname:9090/path?arg=value#anchor'
     *
     * @return string https://hostname.ru
     *
     * @author Leonid Sheikman <leonid@sheikman.ru>
     */
    public static function getHostWithScheme( string $urlAddress = '' ): string
    {
        if ( empty( $urlAddress ) ) {
            return '';
        }

        $parseUrl = parse_url( trim( $urlAddress ) );

        return $parseUrl['scheme'] . '://' . ( trim( $parseUrl['host'] ? $parseUrl['host'] : array_shift( explode( '/', $parseUrl['path'], 2 ) ) ) );
    }

    /**
     * Gets hostname with scheme and path only
     * Получаем имя хоста со схемой и путём, без параметров запроса (https://hostname.ru/path).
     *
     * @param string $urlAddress 'http://username:password@hostname:9090/path?arg=value#anchor'
     *
     * @return string https://hostname.ru/path
     *
     * @author Leonid Sheikman <leonid@sheikman.ru>
     */
    public static function getHostWithSchemeAndPath( string $urlAddress = '' ): string
    {
        if ( empty( $urlAddress ) ) {
            return '';
        }

        $parseUrl = parse_url( trim( $urlAddress ) );

        return $parseUrl['scheme'] . '://' . ( trim( $parseUrl['host'] ? $parseUrl['host'] . $parseUrl['path'] : array_shift( explode( '/', $parseUrl['path'], 2 ) ) ) );
    }
}
