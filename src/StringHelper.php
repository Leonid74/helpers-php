<?php declare(strict_types=1);

/**
 * Helper class for processing strings
 *
 * Вспомогательный класс для обработки строк
 *
 * @author Leonid Sheikman (leonid74)
 * @copyright 2019-2024 Leonid Sheikman
 *
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
     *
     * @param string $haystack
     * @param string $needle
     * @param bool   $before_needle
     */
    // @codingStandardsIgnoreLine
    public static function mb_stristr(string $haystack, string $needle, bool $before_needle = false)
    {
        return \function_exists('mb_stristr')
            ? \mb_stristr($haystack, $needle, $before_needle, static::$defaultEncoding)
            : \stristr($haystack, $needle, $before_needle);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strstr(string $haystack, string $needle, bool $before_needle = false)
    {
        return \function_exists('mb_strstr')
            ? \mb_strstr($haystack, $needle, $before_needle, static::$defaultEncoding)
            : \strstr($haystack, $needle, $before_needle);
    }

    // @codingStandardsIgnoreLine
    public static function mb_stripos(string $haystack, string $needle, int $start = 0)
    {
        return \function_exists('mb_stripos')
            ? \mb_stripos($haystack, $needle, $start, static::$defaultEncoding)
            : \stripos($haystack, $needle, $start);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strripos(string $haystack, string $needle, int $start = 0)
    {
        return \function_exists('mb_strripos')
            ? \mb_strripos($haystack, $needle, $start, static::$defaultEncoding)
            : \strripos($haystack, $needle, $start);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strpos(string $haystack, string $needle, int $start = 0)
    {
        return \function_exists('mb_strpos')
            ? \mb_strpos($haystack, $needle, $start, static::$defaultEncoding)
            : \strpos($haystack, $needle, $start);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strrpos(string $haystack, string $needle, int $start = 0)
    {
        return \function_exists('mb_strrpos')
            ? \mb_strrpos($haystack, $needle, $start, static::$defaultEncoding)
            : \strrpos($haystack, $needle, $start);
    }

    // @codingStandardsIgnoreLine
    public static function mb_substr(string $string, int $start, int $length = null): string
    {
        return \function_exists('mb_substr')
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
        if (null === $string || '' === $string) {
            return 0;
        }

        return \function_exists('mb_strlen')
            ? \mb_strlen($string, static::$defaultEncoding)
            : \strlen($string);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strtolower(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return \function_exists('mb_strtolower')
            ? \mb_strtolower($string, static::$defaultEncoding)
            : \strtolower($string);
    }

    // @codingStandardsIgnoreLine
    public static function mb_strtoupper(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return \function_exists('mb_strtoupper')
            ? \mb_strtoupper($string, static::$defaultEncoding)
            : \strtoupper($string);
    }

    // @codingStandardsIgnoreLine
    public static function mb_ucfirst(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return self::mb_strtoupper(self::mb_substr($string, 0, 1)) . self::mb_substr($string, 1);
    }

    // @codingStandardsIgnoreLine
    public static function mb_convert_case(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return \function_exists('mb_convert_case')
            ? \mb_convert_case($string, MB_CASE_TITLE, static::$defaultEncoding)
            : \ucfirst($string);
    }

    // @codingStandardsIgnoreLine
    public static function htmlspecialchars(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return \htmlspecialchars($string, ENT_COMPAT | ENT_SUBSTITUTE | ENT_HTML5, static::$defaultEncoding);
    }

    // @codingStandardsIgnoreLine
    public static function htmlspecialchars_decode(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return \htmlspecialchars_decode($string, ENT_COMPAT | ENT_HTML5);
    }

    // @codingStandardsIgnoreLine
    public static function htmlentities(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return \htmlentities($string, ENT_COMPAT | ENT_SUBSTITUTE | ENT_HTML5, static::$defaultEncoding);
    }

    // @codingStandardsIgnoreLine
    public static function html_entity_decode(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return \html_entity_decode($string, ENT_COMPAT | ENT_HTML5, static::$defaultEncoding);
    }

    // @codingStandardsIgnoreLine
    public static function utf8_urldecode(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        $string = \preg_replace('/%u([0-9a-f]{3,4})/i', '&#x\\1;', \urldecode($string));

        return self::html_entity_decode($string);
    }

    /**
     * Add BOM to the beginning of the string
     *
     * Добавление BOM в начало строки
     *
     * @param string $string
     * @param string $default
     *
     * @return string
     */
    public static function addBOM(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return \chr(0xEF) . \chr(0xBB) . \chr(0xBF) . $string;
    }

    /**
     * Remove BOM from the beginning of the string
     *
     * Удаление BOM из начала строки
     *
     * @param string $string
     * @param string $default
     *
     * @return string
     */
    public static function removeBOM(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return 0 === \strncasecmp(\pack('CCC', 0xEF, 0xBB, 0xBF), $string, 3) ? \mb_substr($string, 3) : $string;
    }

    /**
     * Replace <br> to \n.
     *
     * Замена <br> на \n.
     *
     * @param string $string
     * @param string $default
     *
     * @return string
     */
    public static function br2nl(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return \preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
    }

    /**
     * Truncates the string to the specified length with the specified suffix (optional).
     *
     * Усекает строку до указанной длины с указанным суффиксом (опционально).
     *
     * StringHelper::truncateString('Lorem ipsum inum', 10);         // returns 'Lorem i...'
     * StringHelper::truncateString('Lorem ipsum inum', 15, '>>>');  // returns 'Lorem ipsum >>>'
     *
     * @param string $string
     * @param int    $iLength  (defaults to 100)
     * @param string $sSuffix  (optional, defaults to '...')
     * @param string $default
     *
     * @return string
     */
    public static function truncateString(?string $string = '', ?int $iLength = 100, ?string $sSuffix = '...', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        if ($iLength <= 0 || \mb_strlen($string) <= $iLength) {
            return $string;
        }

        return \mb_substr($string, 0, $iLength - \mb_strlen($sSuffix)) . $sSuffix;
    }

    /**
     * Generating a unique UUID v4 of (4a27ab2e-ae70-419f-9a26-42a67805d87e).
     *
     * Генерация уникального UUID версии 4 (4a27ab2e-ae70-419f-9a26-42a67805d87e).
     *
     * @return string string uuid
     */
    public static function generateUUID(): string
    {
        $bytes = \random_bytes(16);

        // Устанавливаем версию 4 (биты 12-15 первого символа времени)
        $bytes[6] = \chr(\ord($bytes[6]) & 0x0F | 0x40);

        // Устанавливаем вариант RFC 4122 (10xx), изменяя биты 6-7 первого символа последовательности
        $bytes[8] = \chr(\ord($bytes[8]) & 0x3F | 0x80);

        // Форматируем и возвращаем UUID
        return \vsprintf('%s%s-%s-%s-%s-%s%s%s', \str_split(\bin2hex($bytes), 4));
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
        if (\function_exists('random_bytes')) {
            $bytes = \random_bytes((int) \ceil($length / 2));

            return $prefix . \substr(\bin2hex($bytes), 0, $length);
        } elseif (\function_exists('openssl_random_pseudo_bytes')) {
            $bytes = \openssl_random_pseudo_bytes((int) \ceil($length / 2));

            return $prefix . \substr(\bin2hex($bytes), 0, $length);
        }

        return \substr(\str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
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
            return $data ?: '';
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
     * @param ?string $string
     * @param array   $enc
     * @param string  $data
     *
     * @return bool
     */
    public static function isBase64Encoded(?string $string = '', ?array $enc = ['UTF-8', 'ASCII']): bool
    {
        if (null === $string || '' === $string) {
            return false;
        }

        try {
            if (!\preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)) {
                return false;
            }

            $sDecoded = \base64_decode($string, true);
            if (false === $sDecoded) {
                return false;
            }

            if (!\in_array(\mb_detect_encoding($sDecoded, null, true), $enc)) {
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
     * @param string $string
     * @param string $default
     *
     * @return string
     */
    public static function toLatinString(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        return \transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0180-\u7fff] remove', $string);
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
     * @param string $string
     * @param string $default
     *
     * @return string
     */
    public static function minClean(?string $string = '', ?string $default = ''): string
    {
        if (null === $string || '' === $string) {
            return $default;
        }

        $string = \str_ireplace(["\0", '\\a', '\\b', "\v", "\e", "\f", "\t", "\r", "\n"], ' ', $string);
        $string = \preg_replace('/[\s]{2,}/', ' ', $string);
        $string = \trim($string);

        return (0 == \mb_strlen($string, static::$defaultEncoding)) ? $default : $string;
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
     * @return array Returns an associative array with keys 'result', 'message', and 'replaced'.
     *               'result' - boolean indicating the success of the operation (true on success).
     *               'message' - a message about the outcome of the operation or an error that occurred.
     *               'replaced' - boolean flag indicating whether a replacement has been performed (true if a replacement was made).
     *
     * @throws \RuntimeException if file input/output errors occur, an exception is thrown
     */
    public static function replaceStringInFile(string $filename, string $searchString, string $replaceString = '', string $enc = ''): array
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
                $response['result']  = true;
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
                $response['result']   = true;
                $response['message']  = "Successful replace string '{$searchString}' with string '{$replaceString}'.";
                $response['replaced'] = true;
            }
        } catch (\Throwable $e) {
            // Capture all Throwable errors
            $response['message'] = "Error occurred: {$e->getMessage()}";
        }

        return $response;
    }

    /**
     * Trims a string to a specified length, preserving the integrity of the last word.
     *
     * Обрезаем строку до заданной длины с учетом целостности последнего слова.
     *
     * This function will trim the input string to a maximum specified length without
     * cutting off the last word. If the next word would exceed the length limit,
     * the string is trimmed up to the previous word. If no spaces are found within
     * the limit, or if the first word exceeds the limit, an empty string is returned.
     *
     * @param string|null $string    the input string to be trimmed
     * @param int         $maxLength the maximum allowed length of the output string
     * @param string      $default  default value
     *
     * @return string the trimmed string with preserved last word integrity up to maxLength
     */
    public static function trimStringToLastWord(?string $string = '', int $maxLength = 0, string $default = ''): string
    {
        if (null === $string || '' === $string || 0 == $maxLength) {
            return $default;
        }

        $string = \trim($string);

        // Return the original string if it is within maxLength.
        if (static::mb_strlen($string) <= $maxLength) {
            return $string;
        }

        // Trim the string to maxLength first to see if we're cutting through a word.
        $trimmedString = static::mb_substr($string, 0, $maxLength);

        // Check if we are on a space or just passed one; if so, we can return early.
        if ($string[$maxLength] == ' ' || $string[$maxLength - 1] == ' ') {
            return \rtrim($trimmedString);
        }

        // Find the last space in our trimmed string to avoid cutting off a word.
        $lastSpacePosition = \strrpos($trimmedString, ' ');

        // If there's no space at all, return an empty string as we cannot preserve any word.
        if ($lastSpacePosition === false) {
            return $default;
        }

        // Return substring up to the last found space position.
        return static::mb_substr($trimmedString, 0, $lastSpacePosition);
    }

    /**
     * Split string with full name (LFS) into 3 parts, remove multiple spaces.
     *
     * Разбиваем строку с ФИО на 3 части, удаляем множественные пробелы.
     *
     * @param string|null $string string with full name
     *
     * @return array
     *
     * @author Leonid Sheikman <leonid@sheikman.ru>
     */
    public function splitFullname(?string $string = ''): array
    {
        if (null === $string || '' === $string) {
            return [];
        }

        $dataRaw = \explode(' ', \trim(\preg_replace('/[\s]{2,}/', ' ', $string)));
        $data    = [
            'lastname'   => $dataRaw[0] ?? '',
            'firstname'  => $dataRaw[1] ?? '',
            'secondname' => $dataRaw[2] ?? '',
        ];
        $data['fullname_lfs'] = $data['lastname'] . ($data['firstname'] ? ' ' . $data['firstname'] : '') . ($data['secondname'] ? ' ' . $data['secondname'] : '');
        $data['fullname_lf']  = $data['lastname'] . ($data['firstname'] ? ' ' . $data['firstname'] : '');
        $data['fullname_fl']  = $data['firstname'] . ($data['lastname'] ? ' ' . $data['lastname'] : '');

        return $data;
    }

    /**
     * Escapes HTML special characters in a string by replacing predefined entities (for Telegram purposes).
     *
     * Экранируем некоторые HTML символы в строке для использования в Телеграм
     *
     * @param string $string the original string to escape HTML special characters
     *
     * @return string the escaped string with HTML special characters replaced
     */
    public static function escapeTelegramHTML(string $string): string
    {
        return self::replaceKeyToValue($string, [
            '&' => '&amp;',
            '<' => '&lt;',
            '>' => '&gt;',
            '"' => '&quot;',
            "'" => '&#039;',
        ]);
    }

    /**
     * Escapes Markdown special characters in a string by replacing them with escape sequences (for Telegram purposes).
     *
     * Экранируем некоторые Markdown символы в строке для использования в Телеграм
     *
     * @param string $string the original string to escape Markdown special characters
     *
     * @return string the escaped string with Markdown special characters replaced
     */
    public static function escapeTelegramMarkdown(string $string): string
    {
        return self::replaceKeyToValue($string, [
            '\\' => '\\\\',
            '_'  => '\_',
            '*'  => '\*',
            '`'  => '\`',
            '['  => '\[',
        ]);
    }

    /**
     * Escapes Markdown V2 special characters in a string by replacing them with escape sequences (for Telegram purposes).
     *
     * Экранируем некоторые Markdown V2 символы в строке для использования в Телеграм
     *
     * @param string $string the original string to escape Markdown special characters
     *
     * @return string the escaped string with Markdown special characters replaced
     */
    public static function escapeTelegramMarkdownV2(string $string): string
    {
        return self::replaceKeyToValue($string, [
            '\\' => '\\\\',
            '_'  => '\_',
            '*'  => '\*',
            '['  => '\[',
            ']'  => '\]',
            '('  => '\(',
            ')'  => '\)',
            '~'  => '\~',
            '`'  => '\`',
            '>'  => '\>',
            '#'  => '\#',
            '+'  => '\+',
            '-'  => '\-',
            '='  => '\=',
            '|'  => '\|',
            '{'  => '\{',
            '}'  => '\}',
            '.'  => '\.',
            '!'  => '\!',
        ]);
    }

    /**
     * Replaces keys with corresponding values in a string using str_replace function.
     *
     * Заменяем символы в строке, используя для замены ключи и значения массива.
     *
     * @param string $string the original string to perform replacements on
     * @param array  $array  an associative array where keys are to be replaced with values
     *
     * @return string the modified string after performing the replacements
     */
    private static function replaceKeyToValue(string $string, array $array): string
    {
        return \str_replace(
            \array_keys($array),
            \array_values($array),
            $string
        );
    }
}
