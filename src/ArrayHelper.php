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
     * Checks if the given KEY or INDEX exists in the one- or multi-dimensional array
     *
     * Arrays in PHP handle an integer key and a string integer key identically, so it is
     * pointless to specify a type match for keys
     *
     * @param mixed $mNeedle
     * @param array $aHaystack
     * @param bool  $bCaseInsensitive  (optional, defaults to false)
     * @param bool  $bProcessSubarrays (optional, defaults to true)
     *
     * @return bool
     */
    public static function arrayKeyExists(
        $mNeedle,
        array $aHaystack,
        bool $bCaseInsensitive = false,
        bool $bProcessSubarrays = true
    ): bool {
        $result = false;

        if ( '' !== $mNeedle && !\is_null( $mNeedle ) ) {
            foreach ( $aHaystack as $key => $mItem ) {
                if ( $bCaseInsensitive ) {
                    $result = \mb_strtolower( $mNeedle ) == \mb_strtolower( $key );
                } else {
                    $result = (string) $mNeedle == (string) $key;
                }

                if ( $result ) {
                    break;
                }

                if ( $bProcessSubarrays && \is_array( $mItem ) ) {
                    $result = self::arrayKeyExists( $mNeedle, $mItem, $bCaseInsensitive, $bProcessSubarrays );

                    if ( $result ) {
                        break;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Checks if the given VALUE exists in the one- or multi-dimensional array
     *
     * @param mixed $mNeedle
     * @param array $aHaystack
     * @param bool  $bCaseInsensitive  (optional, defaults to false)
     * @param bool  $bProcessSubarrays (optional, defaults to true)
     * @param bool  $bStrictTypes      (optional, defaults to false)
     *
     * @return bool
     */
    public static function arrayValueExists(
        $mNeedle,
        array $aHaystack,
        bool $bCaseInsensitive = false,
        bool $bProcessSubarrays = true,
        bool $bStrictTypes = false
    ): bool {
        $result = false;

        if ( '' !== $mNeedle && !\is_null( $mNeedle ) ) {
            foreach ( $aHaystack as $mItem ) {
                if ( \is_array( $mItem ) ) {
                    if ( !$bProcessSubarrays ) {
                        continue;
                    }
                    $result = self::arrayValueExists( $mNeedle, $mItem, $bCaseInsensitive, $bProcessSubarrays, $bStrictTypes );
                } else {
                    if ( $bCaseInsensitive ) {
                        $result = $bStrictTypes ? ( \gettype( $mNeedle ) == \gettype( $mItem ) && \mb_strtolower( $mNeedle ) == \mb_strtolower( $mItem ) ) : \mb_strtolower( $mNeedle ) == \mb_strtolower( $mItem );
                    } else {
                        $result = $bStrictTypes ? $mNeedle === $mItem : (string) $mNeedle == (string) $mItem;
                    }
                }

                if ( $result ) {
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Searches in the one- or multi-dimensional array for a given VALUE and returns the first
     * corresponding key if successful
     *
     * @param mixed $mNeedle
     * @param array $aHaystack
     * @param bool  $bCaseInsensitive  (optional, defaults to false)
     * @param bool  $bProcessSubarrays (optional, defaults to true)
     * @param bool  $bStrictTypes      (optional, defaults to false)
     *
     * @return mixed
     */
    public static function arraySearch(
        $mNeedle,
        array $aHaystack,
        bool $bCaseInsensitive = false,
        bool $bProcessSubarrays = true,
        bool $bStrictTypes = false
    ) {
        $result = false;

        if ( '' !== $mNeedle && !\is_null( $mNeedle ) ) {
            foreach ( $aHaystack as $key => $mItem ) {
                if ( \is_array( $mItem ) ) {
                    if ( !$bProcessSubarrays ) {
                        continue;
                    }
                    $result = self::arraySearch( $mNeedle, $mItem, $bCaseInsensitive, $bProcessSubarrays, $bStrictTypes );

                    if ( false !== $result ) {
                        break;
                    }
                } else {
                    if ( $bCaseInsensitive ) {
                        $result = $bStrictTypes ? ( \gettype( $mNeedle ) == \gettype( $mItem ) && \mb_strtolower( $mNeedle ) == \mb_strtolower( $mItem ) ) : \mb_strtolower( $mNeedle ) == \mb_strtolower( $mItem );
                    } else {
                        $result = $bStrictTypes ? $mNeedle === $mItem : (string) $mNeedle == (string) $mItem;
                    }

                    if ( false !== $result ) {
                        $result = $key;
                        break;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Searches in the one- or multi-dimensional array for a given SUBSTRING and returns the first
     * corresponding key if successful
     *
     * @param mixed $mNeedle
     * @param array $aHaystack
     * @param bool  $bCaseInsensitive (optional, defaults to false)
     * @param bool  $bProcessSubarrays (optional, defaults to true)
     *
     * @return mixed
     */
    public static function arrayStrPos(
        $mNeedle,
        array $aHaystack,
        bool $bCaseInsensitive = false,
        bool $bProcessSubarrays = true
    ) {
        $result = false;

        if ( '' !== $mNeedle && !\is_null( $mNeedle ) ) {
            foreach ( $aHaystack as $key => $mItem ) {
                if ( \is_array( $mItem ) ) {
                    if ( !$bProcessSubarrays ) {
                        continue;
                    }
                    $result = self::arrayStrPos( $mNeedle, $mItem, $bCaseInsensitive, $bProcessSubarrays );

                    if ( false !== $result ) {
                        break;
                    }
                } else {
                    if ( false !== ( $bCaseInsensitive ? \mb_stripos( $mItem, $mNeedle ) : \mb_strpos( $mItem, $mNeedle ) ) ) {
                        $result = $key;
                        break;
                    }
                }
            }
        }

        return $result;
    }
}
