<?php

/**
 * Helper class for processing Emails
 *
 * Вспомогательный класс для обработки адресов Email
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

class EmailHelper
{
    /**
     * Checking the validity of the email address.
     *
     * Проверка валидности email адреса.
     *
     * @param string $sString
     *
     * @return bool
     */
    public static function isEmailValid( ?string $sString = '' ): bool
    {
        if ( '' === $sString || \is_null( $sString ) ) {
            return false;
        }

        // According to the FQDN add a dot to the end of the string and check if the domain has an mx record
        if ( \function_exists( 'filter_var' ) && \filter_var( $sString, FILTER_VALIDATE_EMAIL ) && \checkdnsrr( \ltrim( \stristr( $sString, '@' ), '@' ) . '.', 'MX' ) ) {
            return true;
        }

        // Сheck using a regular expression if the filter_var() function does not exist
        if ( \preg_match( '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/sD', $sString ) && \preg_match( '/@.+\./', $sString ) && \checkdnsrr( \ltrim( \stristr( $sString, '@' ), '@' ) . '.', 'MX' ) ) {
            return true;
        }

        return false;
    }
}
