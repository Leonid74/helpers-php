<?php

/**
 * Helper class for processing arrays
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

class ArrayHelper
{
    /**
     * Checking for the presence of a key in a single or multi dimensional array
     *
     * @param mixed $mKey
     * @param array $aHaystack
     *
     * @return bool
     */
    public static function arrayKeyExists( mixed $mKey, array $aHaystack ): bool
    {
        if ( \array_key_exists( $mKey, $aHaystack ) ) {
            return true;
        }

        if ( \is_iterable( $aHaystack ) ) {
            foreach ( $aHaystack as $value ) {
                if ( \is_array( $value ) ) {
                    if ( self::arrayKeyExists( $mKey, $value ) ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
