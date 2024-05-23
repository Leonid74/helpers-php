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
    private static $countryCodes = [
        '1'   => 'США/Канада',
        '7'   => 'Россия/Казахстан',
        '20'  => 'Египет',
        '21'  => 'Южная Африка',
        '22'  => 'Марокко',
        '23'  => 'Алжир',
        '24'  => 'Замбия',
        '25'  => 'Зимбабве',
        '26'  => 'Мозамбик',
        '27'  => 'Южная Африка',
        '28'  => 'Эритрея',
        '29'  => 'Эфиопия',
        '30'  => 'Греция',
        '31'  => 'Нидерланды',
        '32'  => 'Бельгия',
        '33'  => 'Франция',
        '34'  => 'Испания',
        '36'  => 'Венгрия',
        '39'  => 'Италия',
        '40'  => 'Румыния',
        '41'  => 'Швейцария',
        '43'  => 'Австрия',
        '44'  => 'Великобритания',
        '45'  => 'Дания',
        '46'  => 'Швеция',
        '47'  => 'Норвегия',
        '48'  => 'Польша',
        '49'  => 'Германия',
        '50'  => 'Бангладеш',
        '51'  => 'Перу',
        '52'  => 'Мексика',
        '53'  => 'Куба',
        '54'  => 'Аргентина',
        '55'  => 'Бразилия',
        '56'  => 'Чили',
        '60'  => 'Малайзия',
        '61'  => 'Австралия',
        '62'  => 'Индонезия',
        '63'  => 'Филиппины',
        '64'  => 'Новая Зеландия',
        '65'  => 'Сингапур',
        '66'  => 'Таиланд',
        '81'  => 'Япония',
        '82'  => 'Южная Корея',
        '84'  => 'Вьетнам',
        '86'  => 'Китай',
        '90'  => 'Турция',
        '91'  => 'Индия',
        '92'  => 'Пакистан',
        '93'  => 'Афганистан',
        '94'  => 'Шри-Ланка',
        '95'  => 'Мьянма',
        '98'  => 'Иран',
        '370' => 'Литва',
        '371' => 'Латвия',
        '372' => 'Эстония',
        '373' => 'Молдова',
        '374' => 'Армения',
        '375' => 'Беларусь',
        '376' => 'Андорра',
        '377' => 'Монако',
        '378' => 'Сан-Марино',
        '380' => 'Украина',
        '381' => 'Сербия',
        '382' => 'Черногория',
        '383' => 'Косово',
        '385' => 'Хорватия',
        '386' => 'Словения',
        '387' => 'Босния и Герцеговина',
        '389' => 'Северная Македония',
        '420' => 'Чехия',
        '421' => 'Словакия',
        '423' => 'Лихтенштейн',
        '994' => 'Азербайджан',
        '995' => 'Грузия',
        '996' => 'Киргизия',
        '998' => 'Узбекистан',
    ];

    /**
     * Formats an international mobile phone number by removing non-numeric characters,
     * ensuring it starts with a plus sign, and determining the country based on the phone number.
     *
     * Форматируем международный мобильный номер телефона, удаляя нечисловые символы,
     * добавляя знак плюс в начале и определяя страну по номеру телефона.
     *
     * @param string|null $phoneNumber the original phone number
     *
     * @return array|null an array with the formatted phone number and country code, or null if the number is invalid
     */
    public static function formatInternationalMobilePhoneNumber(?string $phoneNumber): ?array
    {
        if (empty($phoneNumber)) {
            return null;
        }

        // Remove everything except numbers and plus sign
        $phoneNumber = \preg_replace('/[^\d+]/', '', $phoneNumber);

        // If the number begins with 8 and has a length of 11 characters, replace 8 by +7 (for Russian numbers)
        if ($phoneNumber[0] === '8' && \strlen($phoneNumber) === 11) {
            $phoneNumber = '+7' . \substr($phoneNumber, 1);
        }

        // Add plus sign if not present
        if ($phoneNumber[0] !== '+') {
            $phoneNumber = '+' . $phoneNumber;
        }

        // Determine the country code based on the phone number
        $countryCode = self::getCountryCodeFromPhoneNumber($phoneNumber);

        if ($countryCode === null) {
            return null;
        }

        return [
            'formattedNumber' => $phoneNumber,
            'countryCode'     => $countryCode,
            'countryName'     => self::$countryCodes[$countryCode],
        ];
    }

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
     * @param string|null $string
     *
     * @return bool|string
     *
     * @author kirkizh.ru
     *
     * @edit   Leonid Sheikman (leonid74)
     */
    public static function getValidRusPhone(?string $string = '')
    {
        if (null === $string || '' === $string) {
            return false;
        }

        $string = \preg_replace('#[^0-9+]+#uis', '', \trim((string) $string));

        if (!\preg_match('#^(?:\\+?7|8|)(.*?)$#uis', $string, $aTmp)) {
            return false;
        }

        $string = '+7' . \preg_replace('#[^0-9]+#uis', '', $aTmp[1]);

        if (!\preg_match('#^\\+7[0-9]{10}$#uis', $string, $aTmp)) {
            return false;
        }

        return $string;
    }

    /**
     * Checking the phone number for existence through the sms.ru
     *
     * Проверка номера телефона на существование через sms.ru
     *
     * @param string $string
     * @param string $apiToken
     * @param string $apiSmsId API Key to SMS.RU
     *
     * @return stdClass()
     */
    public static function isPhoneExist(string $string, string $apiToken)
    {
        $oResult               = new \stdClass();
        $oResult->phone        = $string;
        $oResult->phone_exists = 'unknown';
        $oResult->is_error     = false;

        if (empty($string)) {
            $oResult->phone_exists = false;

            return $oResult;
        }

        try {
            // doing 3 attempts to check the number
            $i = 1;
            do {
                $json = \json_decode(
                    \file_get_contents("https://sms.ru/sms/cost?api_id={$apiToken}&to={$string}&msg=" . \urlencode('Test' . \microtime(true)) . '&json=1')
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

    /**
     * Determines the country code from the phone number.
     *
     * Определяем код страны по номеру телефона.
     *
     * @param string $phoneNumber the formatted phone number
     *
     * @return string|null the country code, or null if the country code cannot be determined
     */
    private static function getCountryCodeFromPhoneNumber(string $phoneNumber): ?string
    {
        // Extract the country code from the phone number
        foreach (self::$countryCodes as $code => $country) {
            if (\str_starts_with($phoneNumber, '+' . $code)) {
                return $code;
            }
        }

        return null;
    }
}
