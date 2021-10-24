<?php declare( strict_types=1 );
/**
 * Helper class for processing files
 * Класс для обработки файлов
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

class FileHelper
{
    /**
     * Gets name of the filename only (without dot and extension)
     * Получаем только имя файла без точки и без расширения.
     *
     * @param string $filename
     *
     * @return string|bool
     *
     * @author Leonid Sheikman <leonid@sheikman.ru>
     */
    public static function getFileNameOnly( string $filename = '' ): string
    {
        return ( is_string( $filename ) && !empty( trim( $filename ) ) ) ? pathinfo( $filename, PATHINFO_FILENAME ) : false;
    }

    /**
     * Gets filename extension only (without dot and name)
     * Получаем только расширение файла без точки и без имени.
     *
     * @param string $filename
     *
     * @return string|bool
     *
     * @author Leonid Sheikman <leonid@sheikman.ru>
     */
    public static function getFileExtOnly( string $filename = '' ): string
    {
        return ( is_string( $filename ) && !empty( trim( $filename ) ) ) ? pathinfo( $filename, PATHINFO_EXTENSION ) : false;
    }
}
