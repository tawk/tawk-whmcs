<?php
/**
 * @author     Tawk.to
 * @copyright  Copyright (c) Tawk.to 2014
 * @license    http://www.whmcs.com/license/ WHMCS Eula
 * @link       https://tawk.to
 */

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

function tawk_to_widget_retrieve_widget() {
    $result = select_query('tawk_to_widget_settings', 'page_id, widget_id', array('id' => 1));
    $data = mysql_fetch_array($result);

    if(!$data || !isset($data['page_id']) || !isset($data['widget_id'])) {
        return array('page_id' => '', 'widget_id' => '');
    }

    return $data;
}