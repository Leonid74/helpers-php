<?php declare(strict_types=1);

/**
 * Helper class for processing Phone numbers
 *
 * Вспомогательный класс для обработки телефонных номеров
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

class PhoneHelper
{
    /**
     * Formats a Russian mobile phone number by removing non-numeric characters and converting it starting with +7.
     *
     * Форматирует российский мобильный телефонный номер, удаляя нецифровые символы и преобразуя его в формат с +7.
     *
     * @param string|null $phoneNumber the original phone number
     *
     * @return string|null a formatted phone number starting with +7, or null if the number is invalid
     */
    public static function formatRussianMobilePhoneNumber(?string $phoneNumber): ?string
    {
        if (empty($phoneNumber)) {
            return null;
        }

        // Delete everything except the numbers
        $phoneNumber = \preg_replace('/\D/', '', $phoneNumber);

        // Check the length of the number (it should be 11 digits)
        if (\strlen($phoneNumber) === 11) {
            // Make sure that the number starts with 7 or 8 and replace it with +7
            if ($phoneNumber[0] === '7' || $phoneNumber[0] === '8') {
                return '+7' . \substr($phoneNumber, 1);
            }
        }

        return null;
    }

    /**
     * (Deprecated) Checking the validity of the Phone number.
     * The function accepts a phone number in an arbitrary format and returns a phone
     * number in the format +7xxxxxxxxxx or false if the input phone number does not pass validation.
     *
     * (Метод устарел) Проверка валидности номера телефона.
     * Функция принимает телефонный номер в произвольном формате и возвращает телефонный
     * номер в формате +7xxxxxxxxxx или false, если входной номер телефона не проходит проверку валидности.
     *
     * @param string $sString
     *
     * @return bool|string
     *
     * @author kirkizh.ru
     *
     * @edit   Leonid Sheikman (leonid74)
     */
    public static function getValidRusPhone(?string $sString = '')
    {
        if ('' === $sString || \is_null($sString)) {
            return false;
        }

        $sString = \preg_replace('#[^0-9+]+#uis', '', \trim((string) $sString));

        if (!\preg_match('#^(?:\\+?7|8|)(.*?)$#uis', $sString, $aTmp)) {
            return false;
        }

        $sString = '+7' . \preg_replace('#[^0-9]+#uis', '', $aTmp[1]);

        if (!\preg_match('#^\\+7[0-9]{10}$#uis', $sString, $aTmp)) {
            return false;
        }

        return $sString;
    }

    /**
     * Checking the phone number for existence through the sms.ru
     *
     * Проверка номера телефона на существование через sms.ru
     *
     * @param string $sString
     * @param string $apiToken
     * @param string $apiSmsId API Key to SMS.RU
     *
     * @return stdClass()
     */
    public static function isPhoneExist(string $sString, string $apiToken)
    {
        $oResult               = new \stdClass();
        $oResult->phone        = $sString;
        $oResult->phone_exists = 'unknown';
        $oResult->is_error     = false;

        if (empty($sString)) {
            $oResult->phone_exists = false;

            return $oResult;
        }

        try {
            // doing 3 attempts to check the number
            $i = 1;
            do {
                $json = \json_decode(
                    \file_get_contents("https://sms.ru/sms/cost?api_id={$apiToken}&to={$sString}&msg=" . \urlencode('Test' . \microtime(true)) . '&json=1')
                );

                if ((\json_last_error() === JSON_ERROR_NONE) && $json) {
                    if ($json->status === 'OK') {
                        foreach ($json->sms as $data) {
                            $oResult->is_error = false;
                            if ($data->status === 'OK') {
                                // The message has been processed, the number exists
                                $oResult->phone_exists = true;

                                return $oResult;
                            }
                            // The message has been processed, the number does not exists
                            $oResult->phone_exists = false;

                            return $oResult;
                        }
                    } else {
                        // The request was not executed (possibly an authorization error, parameters, etc...)
                        $oResult->phone_exists = 'unknown';
                        $oResult->is_error     = true;
                        $oResult->errors[]     = $json->status_code . ': ' . $json->status_text;
                    }
                } else {
                    // The request was not executed (Error decoding the response or Failed to establish connection with the server)
                    $oResult->phone_exists = 'unknown';
                    $oResult->is_error     = true;
                    $oResult->errors[]     = 'Error decoding the response or Failed to establish connection with the server';
                }

                \usleep(500000);
            } while (++$i <= 3);
        } catch (\Exception $e) {
            $oResult->phone_exists = 'unknown';
            $oResult->is_error     = true;
            $oResult->errors[]     = 'A critical error occurred while checking the phone: (' . $e->getCode() . ') ' . $e->getMessage();
        }

        return $oResult;
    }
}
