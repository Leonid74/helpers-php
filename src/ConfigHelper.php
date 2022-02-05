<?php declare( strict_types=1 );

/**
 * Helper class for working with configs.
 * Supports multiple configs and multidimensional arrays.
 * Built-in support for PHP, INI and JSON files.
 *
 * Простой статический класс для работы с конфигами.
 * Поддерживает несколько конфигураций и многомерные массивы.
 * Встроенная поддержка файлов PHP, INI и JSON.
 *
 * @author Leonid Sheikman (leonid74)
 * @copyright 2019-2022 Leonid Sheikman
 * @see https://github.com/Leonid74/helpers-php
 * @uses parts of code (https://github.com/xy2z/LiteConfig)
 *
 * This file is part of the project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Leonid74\Helpers;

/**
 * Simple Config Class
 */
class ConfigHelper
{
    /**
     * Argument used in file_parse_ini()
     *
     * @var boolean
     */
    public static $iniProcessSections = true;

    /**
     * Argument used in file_parse_ini()
     *
     * @var integer
     */
    public static $iniScannerMode = INI_SCANNER_TYPED;

    /**
     * Config data
     *
     * @var array
     */
    protected static $aData = [];

    /**
     * Load config file
     *
     * @param string $sPath Path to file
     * @param boolean $bPrefixFilename Prefix the key with the filename
     * @param string $sPrefixCustom Prefix the key
     *
     * @return void
     */
    public static function loadFile( string $sPath, ?bool $bPrefixFilename = false, ?string $sPrefixCustom = null ): void
    {
        $aPathinfo = \pathinfo( $sPath );

        // Add prefix
        $sPrefix = $bPrefixFilename ? $aPathinfo['filename'] : null;

        if ( $sPrefixCustom !== null ) {
            $sPrefix = $sPrefixCustom . '.' . $sPrefix;
        }

        // Load file content
        $mixContent = static::getFileContent( $sPath, $aPathinfo );
        static::loadArray( $mixContent, $sPrefix );
    }

    /**
     * Load an array into the config
     *
     * @param array $aData Data to load.
     * @param string $sPrefix Prefix the keys (optional)
     *
     * @return void
     */
    public static function loadArray( array $aData, ?string $sPrefix = null ): void
    {
        foreach ( $aData as $key => $val ) {
            if ( $sPrefix !== null ) {
                $key = $sPrefix . '.' . $key;
            }

            static::set( $key, $val );
        }
    }

    /**
     * Get the data from the config by key
     *
     * @param string $key Key
     * @param mixed $default default value
     *
     * @return mixed Value
     */
    public static function get( string $key, $default = null )
    {
        return static::$aData[$key] ?? $default;
    }

    /**
     * Get complete config as array
     *
     * @return array
     */
    public static function all(): array
    {
        return static::$aData;
    }

    /**
     * Check if the array has the key
     *
     * @param string $key Key name
     *
     * @return bool
     */
    public static function hasKey( string $key ): bool
    {
        return isset( self::$aData[$key] );
    }

    /**
     * Alias of hasKey
     *
     * @see hasKey
     *
     * @return bool
     */
    public static function exists( string $key ): bool
    {
        return self::hasKey( $key );
    }

    /**
     * Get file content as php array
     *
     * @param string $sPath Path to file
     * @param array $aPathinfo pathinfo() array
     *
     * @return array
     */
    protected static function getFileContent( string $sPath, array $aPathinfo ): array
    {
        switch ( $aPathinfo['extension'] ) {
            case 'php':
                $aOptions = require( $sPath );
                break;

            case 'ini':
                $aOptions = \parse_ini_file( $sPath, static::$iniProcessSections, static::$iniScannerMode );
                break;

            case 'json':
                $aOptions = \json_decode( \file_get_contents( $sPath ), true );
                break;

            default:
                throw new \Exception( 'Unsupported filetype: ' . $aPathinfo['extension'] );
        }

        return \is_array( $aOptions ) ? $aOptions : [];
    }

    /**
     * Set the data to the config
     *
     * @param string $key Key name
     * @param mixed $value Value
     *
     * @return void
     */
    protected static function set( string $key, $value ): void
    {
        if ( \is_array( $value ) ) {
            foreach ( $value as $key2 => $val2 ) {
                $key_path = $key . '.' . $key2;
                static::set( $key_path, $val2 );
            }
        }

        // Set
        static::$aData[$key] = $value;
    }
}
