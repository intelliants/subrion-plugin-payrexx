<?php
/******************************************************************************
 *
 * Subrion - open source content management system
 * Copyright (C) 2020 Intelliants, LLC <https://intelliants.com>
 *
 * This file is part of Subrion.
 *
 * Subrion is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Subrion is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Subrion. If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @link https://subrion.org/
 *
 ******************************************************************************/

$transaction = $temp_transaction;

switch ($action) {
    case 'completed':
        if (!empty($_GET['ref']) && !empty($_GET['amt']) && !empty($_GET['s']) && isset($_GET['payer']) && isset($_GET['currency'])) {
            if ($_GET['s'] == md5(IA_SALT . $transaction['id'])) {
                $transaction['reference_id'] = $_GET['ref'];
                $transaction['fullname'] = $_GET['payer'];
                $transaction['currency'] = $_GET['currency'];

                $transaction['status'] = iaTransaction::PASSED;

                $payer = explode(' ', $_GET['payer']);

                $order = [
                    'payment_gross' => (float)$_GET['amt'],
                    'mc_currency' => $_GET['currency'],
                    'payment_date' => date(iaDb::DATETIME_SHORT_FORMAT),
                    'payment_status' => iaLanguage::get(iaTransaction::PASSED),
                    'first_name' => iaSanitize::html($payer[0]),
                    'last_name' => isset($payer[1]) ? iaSanitize::html($payer[1]) : '',
                    'payer_email' => '',
                    'txn_id' => iaSanitize::html($transaction['reference_id']),
                ];
            }
        }

        break;

    case 'canceled':
        $error = true;
        $messages[] = iaLanguage::get('oops');

        $transaction['status'] = iaTransaction::FAILED;
}
