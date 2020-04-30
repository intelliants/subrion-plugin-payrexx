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

$formValues['user_id'] = $iaCore->get('payrexx_user_id');
$formValues['project_id'] = $iaCore->get('payrexx_project_id');
$formValues['currency_id'] = $iaCore->get('payrexx_currency');
$formValues['language_id'] = strtoupper($iaView->language);
$formValues['amount'] = $plan['cost'];
$formValues['reason_1'] = $transaction['operation'];

$formValues['user_variable_0'] = $transaction['sec_key'];
$formValues['user_variable_1'] = md5(IA_SALT . $transaction['id']);
$formValues['user_variable_2'] = IA_URL_LANG;

$iaView->assign('formValues', $formValues);
