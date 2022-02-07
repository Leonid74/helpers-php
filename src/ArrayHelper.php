<?php

/**
 * Helper class for processing arrays
 *
 * Вспомогательный класс для обработки массивов
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

class ArrayHelper
{
    /**
     * Checks if the given KEY or INDEX exists in the one- or multi-dimensional array.
     * Arrays in PHP handle an integer key and a string integer key identically, so it is
     * pointless to specify a type match for keys
     *
     * Проверяет, существует ли данный КЛЮЧ или ИНДЕКС в одно- или многомерном массиве.
     * Массивы в PHP обрабатывают целочисленный ключ и строковый целочисленный ключ одинаково, поэтому
     * бессмысленно указывать соответствие типов для ключей
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
        ?bool $bCaseInsensitive = false,
        ?bool $bProcessSubarrays = true
    ): bool {
        $result = false;

        if ( '' !== $mNeedle && !\is_null( $mNeedle ) ) {
            foreach ( $aHaystack as $key => $mItem ) {
                $result = $bCaseInsensitive ? \mb_strtolower( $mNeedle ) == \mb_strtolower( $key ) : (string) $mNeedle == (string) $key;

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
     * Checks if the given VALUE exists in the one- or multi-dimensional array.
     *
     * Проверяет, существует ли данное ЗНАЧЕНИЕ в одно- или многомерном массиве.
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
        ?bool $bCaseInsensitive = false,
        ?bool $bProcessSubarrays = true,
        ?bool $bStrictTypes = false
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
     * Checks whether any of the values from the aNeedles array are contained in the sHaystack.
     *
     * Проверяет, содержатся ли какие-либо значения из массива aNeedles в строке sHaystack.
     *
     * @param string $sHaystack
     * @param array  $aNeedles
     * @param int    $iOffset  (optional, defaults to 0)
     * @param bool   $bCaseInSensitive (optional, defaults to false)
     *
     * @return bool
     */
    public static function arrayNeedlesExists(
        string $sHaystack,
        array $aNeedles,
        ?int $iOffset = 0,
        ?bool $bCaseInSensitive = false
    ): bool {
        foreach ( $aNeedles as $needle ) {
            if ( ( $bCaseInSensitive ? \stripos( $sHaystack, $needle, $iOffset ) : \strpos( $sHaystack, $needle, $iOffset ) ) !== false ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Searches in the one- or multi-dimensional array for a given VALUE and returns the first
     * corresponding key if successful.
     *
     * Выполняет поиск в одно- или многомерном массиве заданного ЗНАЧЕНИЯ и возвращает первый
     * соответствующий ключ в случае успеха.
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
        ?bool $bCaseInsensitive = false,
        ?bool $bProcessSubarrays = true,
        ?bool $bStrictTypes = false
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
     * Searches in the one- or multi-dimensional array for a given SUBSTRING in the VALUE and returns the first
     * corresponding key if successful.
     *
     * Выполняет поиск в одно- или многомерном массиве заданной ПОДСТРОКИ в ЗНАЧЕНИИ и возвращает первый
     * соответствующий ключ в случае успеха.
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
        ?bool $bCaseInsensitive = false,
        ?bool $bProcessSubarrays = true
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

    /**
     * An array combined into a string (for example, to save to CSV).
     * Nested subarrays will also be combined into a string with a subseparator.
     *
     * Массив объединённый в строку (к примеру, для сохранения в CSV).
     * Вложенные подмассивы будут также объединены в строку с разделителем subseparator.
     *
     * @param array $aHaystack
     * @param string $default
     * @param string $separator
     * @param string $subseparator
     * @param bool $isRecursion (service parameter)
     *
     * @return string converted array to string
    */
    public static function arrayToCsvString(
        array $aHaystack,
        ?string $default = '',
        ?string $separator = ';',
        ?string $subseparator = '|',
        ?bool $isRecursion = false
    ): string {
        if ( empty( $aHaystack ) || ( !\is_array( $aHaystack ) && !\is_object( $aHaystack ) ) ) {
            return $default;
        }

        $separator = $isRecursion ? $separator : '"' . $separator . '"';

        $res = [];
        foreach ( $aHaystack as $row ) {
            $res[] = \is_array( $row ) ? \trim( self::arrayToCsvString( $row, $default, $subseparator, '||', true ), "\"\n\r" ) : \trim( $row );
        }

        return '"' . \implode( $separator, $res ) . '"' . PHP_EOL;
    }

    /**
     * Flatten Multidimensional Array.
     *
     * Превратить Многомерный Массив в одномерный.
     *
     * @param array $aHaystack
     * @param string|bool $prefix
     *
     * @return array
     *
     * @author https://github.com/php-curl-class/php-curl-class
     * @edit   Leonid Sheikman (leonid74)
     */
    public static function arrayFlattenMulti(
        array $aHaystack,
        $prefix = false
    ): array {
        $return = [];
        if ( \is_array( $aHaystack ) || \is_object( $aHaystack ) ) {
            if ( empty( $aHaystack ) ) {
                $return[$prefix] = '';
            } else {
                foreach ( $aHaystack as $key => $val ) {
                    if ( \is_scalar( $val ) ) {
                        if ( $prefix ) {
                            $return[$prefix . '[' . $key . ']'] = $val;
                        } else {
                            $return[$key] = $val;
                        }
                    } else {
                        $return = \array_merge(
                            $return,
                            self::arrayFlattenMulti(
                                $val,
                                $prefix ? $prefix . '[' . $key . ']' : $key
                            )
                        );
                    }
                }
            }
        } elseif ( $aHaystack === null ) {
            $return[$prefix] = $aHaystack;
        }
        return $return;
    }
}
