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

if (iaView::REQUEST_HTML == $iaView->getRequestType()) {
    iaBreadcrumb::remove(iaBreadcrumb::POSITION_LAST);
    $iaView->set('nocsrf', true);

    $data = file_get_contents('php://input');

    if (empty($data)) {
        return iaView::errorPage(iaView::ERROR_NOT_FOUND);
    }

    $iaView->disableLayout();

    $iaTransaction = $iaCore->factory('transaction');

    $params = json_decode($data);
    if (!empty($params)) {
        $transaction = $iaTransaction->getBy('sec_key', iaSanitize::paranoid($params->transaction->invoice->number));

        $values = [
            'date_paid' => date(iaDb::DATETIME_FORMAT),
            'date_updated' => date(iaDb::DATETIME_FORMAT),
            'reference_id' => $params->transaction->uuid,
            'notes' => 'Updated via IPN at ' . date(iaDb::DATETIME_FORMAT),
        ];

        if ($params->transaction->status == 'confirmed') {
            $values['status'] = iaTransaction::PASSED;
        }

        $iaDb->update($values, iaDb::convertIds($transaction['id']), null, iaTransaction::getTable());

        $iaTransaction->addIpnLogEntry(IA_CURRENT_MODULE, $params, 'Valid');

        return;
    }

    $iaTransaction->addIpnLogEntry(IA_CURRENT_MODULE, $params, 'Invalid');
}
