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
     * @param mixed $mNeedle
     * @param array $aHaystack
     * @param bool  $bCaseInsensitive (optional, defaults to false)
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
        if ( '' === $mNeedle || \is_null( $mNeedle ) ) {
            return false;
        }

        if ( 0 === count( $aHaystack ) ) {
            return false;
        }

        if ( $bCaseInsensitive ) {
            if ( \in_array( \mb_strtolower( $mNeedle ), \array_map( 'mb_strtolower', \array_keys( $aHaystack ) ) ) ) {
                return true;
            }
        } else {
            if ( \array_key_exists( $mNeedle, $aHaystack ) ) {
                return true;
            }
        }

        if ( $bProcessSubarrays ) {
            foreach ( $aHaystack as $item ) {
                if ( \is_array( $item ) ) {
                    if ( self::arrayKeyExists( $mNeedle, $item, $bCaseInsensitive, $bProcessSubarrays ) ) {
                        return true;
                    }
                }
            }
        }

        return false;
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
        if ( '' === $mNeedle || \is_null( $mNeedle ) ) {
            return false;
        }

        foreach ( $aHaystack as $mItem ) {
            if ( \is_array( $mItem ) ) {
                if ( !$bProcessSubarrays ) {
                    continue;
                }
                $bResult = self::arrayValueExists( $mNeedle, $mItem, $bCaseInsensitive, $bProcessSubarrays, $bStrictTypes );
            } else {
                if ( $bCaseInsensitive ) {
                    $bResult = $bStrictTypes ? ( \gettype( $mNeedle ) == \gettype( $mItem ) && \mb_strtolower( $mNeedle ) == \mb_strtolower( $mItem ) ) : \mb_strtolower( $mNeedle ) == \mb_strtolower( $mItem );
                } else {
                    $bResult = $bStrictTypes ? $mNeedle === $mItem : (string) $mNeedle == (string) $mItem;
                }
            }

            if ( $bResult ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Searches in the one- or multi-dimensional array for a given VALUE and returns the first corresponding key if successful
     *
     * @param mixed $mNeedle
     * @param array $aHaystack
     * @param bool  $bCaseInsensitive (optional, defaults to false)
     * @param bool  $bProcessSubarrays (optional, defaults to true)
     *
     * @return mixed
     */
    public static function arraySearch(
        ?mixed $mNeedle,
        array $aHaystack,
        bool $bCaseInsensitive = false,
        bool $bProcessSubarrays = true
    ): mixed {
        if ( '' === $mNeedle || \is_null( $mNeedle ) ) {
            return false;
        }

        if ( 0 === count( $aHaystack ) ) {
            return false;
        }

        if ( $bCaseInsensitive ) {
            $result = \array_search( \mb_strtolower( $mNeedle ), \array_map( 'mb_strtolower', $aHaystack ) );
        } else {
            $result = \array_search( $mNeedle, $aHaystack );
        }
        if ( false !== $result ) {
            return $result;
        }

        if ( $bProcessSubarrays ) {
            foreach ( $aHaystack as $item ) {
                if ( \is_array( $item ) ) {
                    $result = self::arraySearch( $mNeedle, $item, $bCaseInsensitive, $bProcessSubarrays );
                    if ( false !== $result ) {
                        return $result;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Searches in the one- or multi-dimensional array for a given SUBSTRING and returns the first corresponding key if successful
     *
     * @param mixed $mNeedle
     * @param array $aHaystack
     * @param bool  $bCaseInsensitive (optional, defaults to false)
     * @param bool  $bProcessSubarrays (optional, defaults to true)
     *
     * @return mixed
     */
    public static function arrayStrPos(
        ?mixed $mNeedle,
        array $aHaystack,
        bool $bCaseInsensitive = false,
        bool $bProcessSubarrays = true
    ): mixed {
        if ( '' === $mNeedle || \is_null( $mNeedle ) ) {
            return false;
        }

        if ( 0 === count( $aHaystack ) ) {
            return false;
        }

        $result = false;
        if ( $bCaseInsensitive ) {
            foreach ( $aHaystack as $key => $item ) {
                if ( \is_array( $item ) ) {
                    $result = self::arrayStrPos( $mNeedle, $item, $bCaseInsensitive, $bProcessSubarrays );
                    if ( false !== $result ) {
                        break;
                    }
                } else {
                    if ( false !== \mb_stripos( $item, $mNeedle ) ) {
                        $result = $key;
                        break;
                    }
                }
            }
        } else {
            foreach ( $aHaystack as $key => $item ) {
                if ( \is_array( $item ) ) {
                    $result = self::arrayStrPos( $mNeedle, $item, $bCaseInsensitive, $bProcessSubarrays );
                    if ( false !== $result ) {
                        break;
                    }
                } else {
                    if ( false !== \mb_strpos( $item, $mNeedle ) ) {
                        $result = $key;
                        break;
                    }
                }
            }
        }
        if ( false !== $result ) {
            return $result;
        }

        if ( $bProcessSubarrays ) {
            foreach ( $aHaystack as $item ) {
                if ( \is_array( $item ) ) {
                    if ( self::arraySearch( $mNeedle, $item, $bCaseInsensitive, $bProcessSubarrays ) ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
