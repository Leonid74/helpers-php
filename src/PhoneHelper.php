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
        '7' => [
            'Россия'    => ['9'],
            'Казахстан' => ['7'],
        ],
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
        '1' => [
            'США' => [
                '201', '202', '203', '205', '206', '207', '208', '209', '210', '212', '213', '214', '215', '216', '217', '218', '219', '224', '225', '228', '229', '231', '234', '239', '240', '248', '251', '252', '253', '254', '256', '260', '262', '267', '269', '270', '272', '276', '281', '301', '302', '303', '304', '305', '307', '308', '309', '310', '312', '313', '314', '315', '316', '317', '318', '319', '320', '321', '323', '325', '330', '331', '334', '336', '337', '339', '346', '347', '351', '352', '360', '361', '364', '380', '385', '386', '401', '402', '404', '405', '406', '407', '408', '409', '410', '412', '413', '414', '415', '417', '419', '423', '424', '425', '430', '432', '434', '435', '440', '442', '443', '458', '463', '469', '470', '475', '478', '479', '480', '484', '501', '502', '503', '504', '505', '507', '508', '509', '510', '512', '513', '515', '516', '517', '518', '520', '530', '531', '534', '539', '540', '541', '551', '559', '561', '562', '563', '564', '567', '570', '571', '573', '574', '575', '580', '585', '586', '601', '602', '603', '605', '606', '607', '608', '609', '610', '612', '614', '615', '616', '617', '618', '619', '620', '623', '626', '628', '629', '630', '631', '636', '641', '646', '650', '651', '657', '660', '661', '662', '667', '669', '678', '681', '682', '701', '702', '703', '704', '706', '707', '708', '712', '713', '714', '715', '716', '717', '718', '719', '720', '724', '725', '727', '730', '731', '732', '734', '737', '740', '743', '747', '754', '757', '760', '762', '763', '765', '769', '770', '772', '773', '774', '775', '779', '781', '785', '786', '801', '802', '803', '804', '805', '806', '808', '810', '812', '813', '814', '815', '816', '817', '818', '828', '830', '831', '832', '838', '839', '840', '843', '845', '847', '848', '850', '854', '856', '857', '858', '859', '860', '862', '863', '864', '865', '870', '872', '878', '901', '903', '904', '906', '907', '908', '909', '910', '912', '913', '914', '915', '916', '917', '918', '919', '920', '925', '928', '929', '930', '931', '934', '936', '937', '938', '940', '941', '947', '949', '951', '952', '954', '956', '959', '970', '971', '972', '973', '975', '978', '979', '980', '984', '985', '989',
            ],
            'Канада' => [
                '204', '226', '236', '249', '250', '289', '306', '343', '365', '387', '403', '416', '418', '431', '437', '438', '450', '506', '514', '519', '548', '579', '581', '587', '604', '613', '639', '647', '672', '705', '709', '742', '778', '780', '782', '807', '819', '825', '867', '873', '902', '905',
            ]
        ],
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
            'countryName'     => self::getCountryNameFromPhoneNumber($phoneNumber, $countryCode),
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
            if (\is_array($country)) {
                foreach ($country as $subCode => $prefixes) {
                    foreach ($prefixes as $prefix) {
                        if (\str_starts_with($phoneNumber, '+' . $code . $prefix)) {
                            return $code;
                        }
                    }
                }
            } else {
                if (\str_starts_with($phoneNumber, '+' . $code)) {
                    return $code;
                }
            }
        }

        return null;
    }

    /**
     * Determines the name of the country by phone number and code of the country.
     *
     * Определяем название страны по номеру телефона и коду страны.
     *
     * @param string $phoneNumber the formatted phone number
     * @param string $countryCode the country code
     *
     * @return string|null the country code, or null if the country code cannot be determined
     */
    private static function getCountryNameFromPhoneNumber(string $phoneNumber, string $countryCode): ?string
    {
        $country = self::$countryCodes[$countryCode];

        if (\is_array($country)) {
            foreach ($country as $name => $prefixes) {
                foreach ($prefixes as $prefix) {
                    if (\str_starts_with($phoneNumber, '+' . $countryCode . $prefix)) {
                        return $name;
                    }
                }
            }
        } else {
            return $country;
        }

        return null;
    }
}
