<?php declare( strict_types=1 );
/**
 * Helper class for processing strings
 * Класс для обработки строк
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
     * Add trailing slash to the string
     * Добавление слэша к концу строки.
     *
     * @param string $str
     *
     * @return string
     *
     * @author Leonid Sheikman <leonid@sheikman.ru>
     */
    public static function addTrailingSlash( string $str = '' ): string
    {
        return \rtrim( $str, '/' ) . '/';
    }

    /**
     * Remove trailing slash from the string
     * Удаление слэша в конце строки.
     *
     * @param string $str
     *
     * @return string
     *
     * @author Leonid Sheikman <leonid@sheikman.ru>
     */
    public static function removeTrailingSlash( string $str = '' ): string
    {
        return \rtrim( $str, '/' );
    }

    /**
     * Add slash to the beginning of the string
     * Добавление слэша к началу строки.
     *
     * @param string $str
     *
     * @return string
     *
     * @author Leonid Sheikman <leonid@sheikman.ru>
     */
    public static function prependSlash( string $str = '' ): string
    {
        return '/' . \ltrim( $str, '/' );
    }

    /**
     * Remove BOM from the string
     * Удаление BOM из строки.
     *
     * @param string $str
     *
     * @return string
     *
     * @author Leonid Sheikman <leonid@sheikman.ru>
     */
    public static function removeBOM( string $str = '' ): string
    {
        return 0 === \strncasecmp( \pack( 'CCC', 0xef, 0xbb, 0xbf ), $str, 3 ) ? \mb_substr( $str, 3 ) : $str;
    }
}
