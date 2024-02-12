<?php declare(strict_types=1);

/**
 * Helper class for processing files
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

class FileHelper
{
    /**
     * Gets name of the filename only (without dot and extension).
     * If the file name contains several dots (file.name.ext) - return all parts before the last dot.
     *
     * @param string $sFilename
     * @param string $default
     *
     * @return string
     */
    public static function getFileNameOnly(?string $sFilename = '', string $default = ''): string
    {
        if ('' === $sFilename || \is_null($sFilename)) {
            return $default;
        }

        $sParsed = \pathinfo(\trim($sFilename), PATHINFO_FILENAME);

        return $sParsed ? $sParsed : $default;
    }

    /**
     * Gets filename extension only (without dot and name)
     *
     * @param string $sFilename
     * @param string $default
     *
     * @return string
     */
    public static function getFileExtOnly(?string $sFilename = '', string $default = ''): string
    {
        if ('' === $sFilename || \is_null($sFilename)) {
            return $default;
        }

        $sParsed = \pathinfo(\trim($sFilename), PATHINFO_EXTENSION);

        return $sParsed ? $sParsed : $default;
    }
}
