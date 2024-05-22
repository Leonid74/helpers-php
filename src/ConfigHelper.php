<?php declare(strict_types=1);

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
 * @copyright 2019-2024 Leonid Sheikman
 *
 * @see https://github.com/Leonid74/helpers-php
 *
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
     * Argument used in parse_ini_file()
     *
     * @var bool
     */
    public static $iniProcessSections = true;

    /**
     * Argument used in parse_ini_file()
     *
     * @var int
     */
    public static $iniScannerMode = INI_SCANNER_TYPED;

    /**
     * Config data
     *
     * @var array
     */
    protected static $data = [];

    /**
     * Load config file
     *
     * @param string $path           Path to file
     * @param bool   $prefixFilename Prefix the key with the filename
     * @param string $prefixCustom   Custom prefix for the key
     *
     * @return void
     */
    public static function loadFile(string $path, ?bool $prefixFilename = false, ?string $prefixCustom = null): void
    {
        $pathInfo = \pathinfo($path);

        // Add prefix
        $prefix = $prefixFilename ? $pathInfo['filename'] : '';

        if ($prefixCustom !== null) {
            $prefix = $prefixCustom . '.' . $prefix;
        }

        // Load file content
        $content = self::getFileContent($path, $pathInfo);
        self::loadArray($content, $prefix);
    }

    /**
     * Load an array into the config
     *
     * @param array  $data   Data to load
     * @param string $prefix Prefix the keys (optional)
     *
     * @return void
     */
    public static function loadArray(array $data, ?string $prefix = null): void
    {
        foreach ($data as $key => $val) {
            $key = $prefix ? $prefix . '.' . $key : $key;
            self::set($key, $val);
        }
    }

    /**
     * Get the data from the config by key
     *
     * @param string $key     Key
     * @param mixed  $default Default value
     *
     * @return mixed Value
     */
    public static function get(string $key, $default = null)
    {
        return static::$data[$key] ?? $default;
    }

    /**
     * Get complete config as array
     *
     * @return array
     */
    public static function all(): array
    {
        return static::$data;
    }

    /**
     * Check if the array has the key
     *
     * @param string $key Key name
     *
     * @return bool
     */
    public static function hasKey(string $key): bool
    {
        return isset(self::$data[$key]);
    }

    /**
     * Alias of hasKey
     *
     * @see hasKey
     *
     * @param string $key Key name
     *
     * @return bool
     */
    public static function exists(string $key): bool
    {
        return self::hasKey($key);
    }

    /**
     * Pack the config file and return the packed configuration.
     *
     * @param string $file Path to the config file
     *
     * @return array
     *
     * @throws \RuntimeException
     */
    public static function getPackedConfig(string $file): array
    {
        if (empty($file) || !\file_exists($file)) {
            throw new \InvalidArgumentException('Empty or non-existent config file');
        }

        $packedFilename = self::getPackedFilename($file);

        if (!\file_exists($packedFilename) || \filemtime($packedFilename) <= \filemtime($file)) {
            $packedConfig = self::packConfigFile($file);
            self::writePackedConfig($packedFilename, $packedConfig);
        }

        $options = require $packedFilename;
        if (!\is_array($options) || empty($options)) {
            throw new \RuntimeException('Invalid packed config file');
        }

        return $options;
    }

    /**
     * Get file content as PHP array
     *
     * @param string $path     Path to file
     * @param array  $pathInfo pathinfo() array
     *
     * @return array
     *
     * @throws \Exception
     */
    protected static function getFileContent(string $path, array $pathInfo): array
    {
        switch ($pathInfo['extension']) {
            case 'php':
                $options = require $path;

                break;
            case 'ini':
                $options = \parse_ini_file($path, static::$iniProcessSections, static::$iniScannerMode);

                break;
            case 'json':
                $options = \json_decode(\file_get_contents($path), true);

                break;
            default:
                throw new \Exception('Unsupported filetype: ' . $pathInfo['extension']);
        }

        return \is_array($options) ? $options : [];
    }

    /**
     * Set the data to the config
     *
     * @param string $key   Key name
     * @param mixed  $value Value
     *
     * @return void
     */
    protected static function set(string $key, $value): void
    {
        if (\is_array($value)) {
            foreach ($value as $subKey => $subValue) {
                self::set($key . '.' . $subKey, $subValue);
            }
        }

        // Set
        static::$data[$key] = $value;
    }

    /**
     * Get the packed filename based on the original filename.
     *
     * @param string $file Path to the original config file
     *
     * @return string
     */
    private static function getPackedFilename(string $file): string
    {
        return \dirname($file) . DIRECTORY_SEPARATOR . \basename($file, '.php') . '.packed.php';
    }

    /**
     * Pack the config file by removing comments and multiple spaces.
     *
     * @param string $file Path to the original config file
     *
     * @return string Packed config content
     */
    private static function packConfigFile(string $file): string
    {
        $configTmp     = '';
        $commentTokens = [T_COMMENT, T_DOC_COMMENT];
        $tokens        = \token_get_all(\file_get_contents($file));

        foreach ($tokens as $token) {
            if (\is_array($token) && \in_array($token[0], $commentTokens)) {
                continue;
            }
            $configTmp .= \is_array($token) ? $token[1] : $token;
        }

        return \trim(\preg_replace('/\s+/', ' ', $configTmp));
    }

    /**
     * Write the packed config to a file with retries.
     *
     * @param string $packedFilename Path to the packed config file
     * @param string $packedConfig   Packed config content
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    private static function writePackedConfig(string $packedFilename, string $packedConfig): void
    {
        for ($i = 0; $i < 3; ++$i) {
            if (\file_put_contents($packedFilename, $packedConfig, LOCK_EX) !== false) {
                return;
            }
            \usleep(100000);
        }

        throw new \RuntimeException('Failed to write packed config file');
    }
}
