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
     * Add BOM to the beginning of the string
     *
     * Добавление BOM в начало строки
     *
     * @param string $sString
     *
     * @return string
     */
    public static function addBOM( ?string $sString = null ): string
    {
        return \chr( 0xEF ) . \chr( 0xBB ) . \chr( 0xBF ) . ( $sString ?? '' );
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
    public static function truncateString( ?string $sString = '', int $iLength = 100, string $sSuffix = '...' ): string
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
}
