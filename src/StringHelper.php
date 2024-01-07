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
     * Set the default encoding.
     * Can be reassign like this: \Leonid74\Helpers\StringHelper::$defaultEncoding = 'Windows-1251';
     */
    public static $defaultEncoding = 'UTF-8';

    /**
     * Set the array of hiding data, using hidingData() function.
     * Can be set like this: \Leonid74\Helpers\StringHelper::$aDataToHide[] = 'secret token';
     *                       \Leonid74\Helpers\StringHelper::$aDataToHide[] = 'another confidentional data';
     */
    public static $aDataToHide = [];

    /**
     * Most used common php functions.
     */
    // @codingStandardsIgnoreLine
    public static function mb_stristr(string $haystack, string $needle, bool $before_needle = false)
    {
        return function_exists('mb_stristr')
            ? \mb_stristr($haystack, $needle, $before_needle, static::$defaultEncoding)
            : \stristr($haystack, $needle, $before_needle);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strstr(string $haystack, string $needle, bool $before_needle = false)
    {
        return function_exists('mb_strstr')
            ? \mb_strstr($haystack, $needle, $before_needle, static::$defaultEncoding)
            : \strstr($haystack, $needle, $before_needle);
    }

    // @codingStandardsIgnoreLine
    public static function mb_stripos(string $haystack, string $needle, int $start = 0)
    {
        return function_exists('mb_stripos')
            ? \mb_stripos($haystack, $needle, $start, static::$defaultEncoding)
            : \stripos($haystack, $needle, $start);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strripos(string $haystack, string $needle, int $start = 0)
    {
        return function_exists('mb_strripos')
            ? \mb_strripos($haystack, $needle, $start, static::$defaultEncoding)
            : \strripos($haystack, $needle, $start);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strpos(string $haystack, string $needle, int $start = 0)
    {
        return function_exists('mb_strpos')
            ? \mb_strpos($haystack, $needle, $start, static::$defaultEncoding)
            : \strpos($haystack, $needle, $start);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strrpos(string $haystack, string $needle, int $start = 0)
    {
        return function_exists('mb_strrpos')
            ? \mb_strrpos($haystack, $needle, $start, static::$defaultEncoding)
            : \strrpos($haystack, $needle, $start);
    }

    // @codingStandardsIgnoreLine
    public static function mb_substr(string $string, int $start, int $length = null): string
    {
        return function_exists('mb_substr')
            ? \mb_substr($string, $start, $length, static::$defaultEncoding)
            : \substr($string, $start, $length);
    }

    // @codingStandardsIgnoreLine
    public static function mb_substr_replace(string $string, string $replacement, int $start, int $length = null): string
    {
        if (\is_null($length)) {
            return static::mb_substr($string, 0, $start) . $replacement;
        }

        if ($length < 0) {
            $length = static::mb_strlen($string) - $start + $length;
        }

        return static::mb_substr($string, 0, $start) .
            $replacement .
            static::mb_substr($string, $start + $length, static::mb_strlen($string));
    }

    // @codingStandardsIgnoreLine
    public static function mb_strlen(?string $string = ''): int
    {
        if ('' === $string || \is_null($string)) {
            return 0;
        }

        return function_exists('mb_strlen')
            ? \mb_strlen($string, static::$defaultEncoding)
            : \strlen($string);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strtolower(?string $string = '', ?string $sDefault = ''): string
    {
        if ('' === $string || \is_null($string)) {
            return $sDefault;
        }

        return function_exists('mb_strtolower')
            ? \mb_strtolower($string, static::$defaultEncoding)
            : \strtolower($string);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strtoupper(?string $string = '', ?string $sDefault = ''): string
    {
        if ('' === $string || \is_null($string)) {
            return $sDefault;
        }

        return function_exists('mb_strtoupper')
            ? \mb_strtoupper($string, static::$defaultEncoding)
            : \strtoupper($string);
    }

    // @codingStandardsIgnoreLine
    public static function mb_ucfirst(?string $string = '', ?string $sDefault = ''): string
    {
        if ('' === $string || \is_null($string)) {
            return $sDefault;
        }

        return self::mb_strtoupper(self::mb_substr($string, 0, 1)) . self::mb_substr($string, 1);
    }

    // @codingStandardsIgnoreLine
    public static function mb_convert_case(?string $string = '', ?string $sDefault = ''): string
    {
        if ('' === $string || \is_null($string)) {
            return $sDefault;
        }

        return function_exists('mb_convert_case')
            ? \mb_convert_case($string, MB_CASE_TITLE, static::$defaultEncoding)
            : \ucfirst($string);
    }

    // @codingStandardsIgnoreLine
    public static function htmlspecialchars(?string $string = '', ?string $sDefault = ''): string
    {
        if ('' === $string || \is_null($string)) {
            return $sDefault;
        }

        return \htmlspecialchars($string, ENT_COMPAT | ENT_SUBSTITUTE | ENT_HTML5, static::$defaultEncoding);
    }

    // @codingStandardsIgnoreLine
    public static function htmlspecialchars_decode(?string $string = '', ?string $sDefault = ''): string
    {
        if ('' === $string || \is_null($string)) {
            return $sDefault;
        }

        return \htmlspecialchars_decode($string, ENT_COMPAT | ENT_HTML5);
    }

    // @codingStandardsIgnoreLine
    public static function htmlentities(?string $string = '', ?string $sDefault = ''): string
    {
        if ('' === $string || \is_null($string)) {
            return $sDefault;
        }

        return \htmlentities($string, ENT_COMPAT | ENT_SUBSTITUTE | ENT_HTML5, static::$defaultEncoding);
    }

    // @codingStandardsIgnoreLine
    public static function html_entity_decode(?string $string = '', ?string $sDefault = ''): string
    {
        if ('' === $string || \is_null($string)) {
            return $sDefault;
        }

        return \html_entity_decode($string, ENT_COMPAT | ENT_HTML5, static::$defaultEncoding);
    }

    // @codingStandardsIgnoreLine
    public static function utf8_urldecode(?string $string = '', ?string $sDefault = ''): string
    {
        if ('' === $string || \is_null($string)) {
            return $sDefault;
        }

        $string = \preg_replace("/%u([0-9a-f]{3,4})/i", "&#x\\1;", \urldecode($string));
        return self::html_entity_decode($string);
    }

    /**
     * Add BOM to the beginning of the string
     *
     * Добавление BOM в начало строки
     *
     * @param string $sString
     * @param string $sDefault
     *
     * @return string
     */
    public static function addBOM(?string $sString = '', ?string $sDefault = ''): string
    {
        if ('' === $sString || \is_null($sString)) {
            return $sDefault;
        }

        return \chr(0xEF) . \chr(0xBB) . \chr(0xBF) . $sString;
    }

    /**
     * Remove BOM from the beginning of the string
     *
     * Удаление BOM из начала строки
     *
     * @param string $sString
     * @param string $sDefault
     *
     * @return string
     */
    public static function removeBOM(?string $sString = '', ?string $sDefault = ''): string
    {
        if ('' === $sString || \is_null($sString)) {
            return $sDefault;
        }

        return 0 === \strncasecmp(\pack('CCC', 0xef, 0xbb, 0xbf), $sString, 3) ? \mb_substr($sString, 3) : $sString;
    }

    /**
     * Replace <br> to \n.
     *
     * Замена <br> на \n.
     *
     * @param string $sString
     * @param string $sDefault
     *
     * @return string
     */
    public static function br2nl(?string $sString = '', ?string $sDefault = ''): string
    {
        if ('' === $sString || \is_null($sString)) {
            return $sDefault;
        }

        return \preg_replace('/\<br(\s*)?\/?\>/i', "\n", $sString);
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
     * @param string $sDefault
     *
     * @return string
     */
    public static function truncateString(?string $sString = '', ?int $iLength = 100, ?string $sSuffix = '...', ?string $sDefault = ''): string
    {
        if ('' === $sString || \is_null($sString)) {
            return $sDefault;
        }

        if ($iLength <= 0 || \mb_strlen($sString) <= $iLength) {
            return $sString;
        }

        return \mb_substr($sString, 0, $iLength - \mb_strlen($sSuffix)) . $sSuffix;
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
            \mt_rand(0, 0xffff),
            \mt_rand(0, 0xffff),
            \mt_rand(0, 0xffff),
            \mt_rand(0, 0x0fff) | 0x4000,
            \mt_rand(0, 0x3fff) | 0x8000,
            \mt_rand(0, 0xffff),
            \mt_rand(0, 0xffff),
            \mt_rand(0, 0xffff)
        );
    }

    /**
     * Gets a truly unique identifier (with a prefix) based on cryptographically secure
     * functions, if available, otherwise a random ID is created
     *
     * Получаем действительно уникальный идентификатор (с префиксом), основанный на криптографически безопасных
     * функциях, если они доступны, в противном случае создается случайный ID
     *
     * @param int    $length length of the unique identifier
     * @param string $prefix prefix of the unique identifier
     *
     * @return string
     */
    public static function generateUniqId(int $length = 5, string $prefix = ''): string
    {
        if (function_exists('random_bytes')) {
            $bytes = \random_bytes((int) \ceil($length / 2));
            return $prefix . \substr(\bin2hex($bytes), 0, $length);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = \openssl_random_pseudo_bytes((int) \ceil($length / 2));
            return $prefix . \substr(\bin2hex($bytes), 0, $length);
        } else {
            return \substr(\str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
        }
    }

    /**
     * Hiding any data in the output information (ideal for a log).
     *
     * Скрытие любых данных в выводимой информации (идеально - для лога).
     *
     * @param mixed $data
     * @param array $aDataToHide
     *
     * @return string
     */
    // @codingStandardsIgnoreLine
    public static function hidingData($data = null, array $aDataToHide = []): string
    {
        if (empty($data) || (empty(static::$aDataToHide) && empty($aDataToHide))) {
            return $data;
        }

        $aDataToHide = empty(static::$aDataToHide)
            ? $aDataToHide
            : (empty($aDataToHide)
                ? static::$aDataToHide
                : \array_merge(static::$aDataToHide, $aDataToHide));

        return \str_replace($aDataToHide, '**hided**', \is_scalar($data) ? (string) $data : \var_export($data, true));
    }

    /**
     * Checking whether a string is encoded in Base64 format
     *
     * Проверка, закодирована ли строка в формате Base64
     *
     * @param string $data
     * @param array $enc
     *
     * @return bool
     */
    public static function isBase64Encoded(?string $sString = '', ?array $enc = ['UTF-8', 'ASCII']): bool
    {
        if ('' === $sString || \is_null($sString)) {
            return false;
        }

        try {
            if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $sString)) {
                return false;
            }

            $sDecoded = base64_decode($sString, true);
            if (false === $sDecoded) {
                return false;
            }

            if (!in_array(mb_detect_encoding($sDecoded, null, true), $enc)) {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Returns a transliterated string (originally containing á é ò characters, etc.) containing only Latin characters
     *
     * Возвращает транслитерированную строку (исходно содержащую символы á é ò и т.п.), содержащую только латинские символы
     *
     * @param string $sString
     * @param string $sDefault
     *
     * @return string
     */
    public static function toLatinString(?string $sString = '', ?string $sDefault = ''): string
    {
        if ('' === $sString || \is_null($sString)) {
            return $sDefault;
        }

        return transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0180-\u7fff] remove', $sString);
    }

    /**
     * Minimal string cleaning:
     * - service characters, tabs and line breaks are removed
     * - double spaces are replaced by one
     * - removes spaces at the beginning and end of the line
     *
     * Минимальная очистка строки:
     *  - удаляются служебные символы, табуляция и переносы строк
     *  - двойные пробелы заменяются на один
     *  - удаляются пробелы в начале и конце строки
     *
     * @param string $sString
     * @param string $sDefault
     *
     * @return string
     */
    public static function minClean(?string $sString = '', ?string $sDefault = ''): string
    {
        if ('' === $sString || \is_null($sString)) {
            return $sDefault;
        }

        $sString = \str_ireplace(["\0", '\\a', '\\b', "\v", "\e", "\f", "\t", "\r", "\n"], ' ', $sString);
        $sString = \preg_replace('/[\s]{2,}/', ' ', $sString);
        $sString = \trim($sString);

        return (0 == \mb_strlen($sString, static::$defaultEncoding)) ? $sDefault : $sString;
    }

    /**
     * Formatted print of variable
     *
     * Форматированный вывод переменной
     *
     * @param $mixVar Переменная для вывода
     * @param $sTitle Заголовок перед выводом переменной
     *
     * @return void
     */
    // @codingStandardsIgnoreLine
    public static function printVar($mixVar, string $sTitle = ''): void
    {
        // read backtrace
        $bt = \debug_backtrace();
        // read file
        $file = \file($bt[0]['file']);
        // select exact print_var_name($varname) line
        $src = $file[$bt[0]['line'] - 1];
        // search pattern
        $pat = '#(.*)' . __FUNCTION__ . ' *?\( *?(.*) *?\)(.*)#i';
        // extract $varname from match no 2
        $var = \trim(\preg_replace($pat, '$2', $src));
        // print to browser
        if (!empty($sTitle)) {
            $var = $sTitle . ': ' . \str_replace(", '" . $sTitle . "'", '', $var);
        }
        // @codingStandardsIgnoreLine
        echo '<pre>' . $var . ' = ' . \print_r(\current(\func_get_args()), true) . '</pre>';
    }

    /**
     * Replaces all occurrences of a search string in the file with a replacement string.
     *
     * Заменяет строку в файле на другую строку и информирует, была ли выполнена замена.
     *
     * @param string $filename      path to the file where replacements should be done
     * @param string $searchString  search string that needs to be replaced
     * @param string $replaceString Replacement string. If not provided, defaults to an empty string.
     * @param string $enc           The encoding. Defaults to the value of static::$defaultEncoding.
     *
     * @throws \RuntimeException if file input/output errors occur, an exception is thrown
     *
     * @return array Returns an associative array with keys 'result', 'message', and 'replaced'.
     *               'result' - boolean indicating the success of the operation (true on success).
     *               'message' - a message about the outcome of the operation or an error that occurred.
     *               'replaced' - boolean flag indicating whether a replacement has been performed (true if a replacement was made).
     */
    public function replaceStringInFile(string $filename, string $searchString, string $replaceString = '', string $enc = ''): array
    {
        $response = [
            'result'   => false,
            'message'  => 'An unspecified error occurred.',
            'replaced' => false,
        ];

        // Validate input parameters
        if (\trim($filename) === '') {
            $response['message'] = 'File name cannot be empty.';

            return $response;
        }

        if (\trim($searchString) === '') {
            $response['message'] = 'Search string cannot be empty.';

            return $response;
        }

        // Checking the existence of the file
        if (\file_exists($filename) === false) {
            $response['message'] = "File does not exist: '{$filename}'.";

            return $response;
        }

        try {
            // Read the entire file content
            $fileContent = \file_get_contents($filename);
            if ($fileContent === false) {
                throw new \RuntimeException("Cannot read the file '{$filename}'.");
            }

            // Set the encoding
            if (\trim($enc) === '') {
                $enc = self::$defaultEncoding;
            }

            // Check for the presence of the search string within the file content and
            if (\mb_strpos($fileContent, $searchString, 0, $enc) === false) {
                $response['message'] = 'Search string not found, no replacement necessary.';
                $response['result'] = true;
            } else {
                // Attempt replacement
                $updatedContent = \str_replace($searchString, $replaceString, $fileContent);

                // Create the temporary file for write
                $tmpFile = \tempnam(\sys_get_temp_dir(), 'TMP_');
                if ($tmpFile === false) {
                    throw new \RuntimeException('Cannot create temporary file.');
                }

                // Write the updated content to temporary file
                if (\file_put_contents($tmpFile, $updatedContent) === false) {
                    throw new \RuntimeException("Cannot write to temporary file '{$tmpFile}'.");
                }

                // Replace the original file with temporary file
                if (\rename($tmpFile, $filename) === false) {
                    throw new \RuntimeException("Cannot replace the original file '{$filename}' with temporary file '{$tmpFile}'.");
                }

                // Update response on success
                $response['result'] = true;
                $response['message'] = "Successful replace string '{$searchString}' with string '{$replaceString}'.";
                $response['replaced'] = true;
            }
        } catch (\Throwable $e) {
            // Capture all Throwable errors
            $response['message'] = "Error occurred: {$e->getMessage()}";
        }

        return $response;
    }
}
