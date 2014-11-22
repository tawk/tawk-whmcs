<?php
/**
 * @author     Tawk.to
 * @copyright  Copyright (c) Tawk.to 2014
 * @license    http://www.whmcs.com/license/ WHMCS Eula
 * @link       https://tawk.to
 */

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

require_once dirname(__FILE__) . '/functions.php';

define('TAWK_TO_WIDGET_PLUGINS_BASE_URL', 'https://plugins.tawk.to');

function tawk_to_widget_config() {
    return array(
        "name" => "Tawk to widget",
        "description" => "This addon allows to change tawk.to widget which is used in your whmcs installation",
        "version" => "1.0",
        "author" => "Tawkto",
        "language" => "english"
    );
}

function tawk_to_widget_activate() {

    full_query("CREATE TABLE IF NOT EXISTS `tawk_to_widget_settings` (
      `id` int NOT NULL PRIMARY KEY,
      `page_id` varchar(100) NOT NULL,
      `widget_id` varchar(100) NOT NULL
    )  DEFAULT CHARSET=utf8;");

    return array('status'=>'success', 'description'=>'Tawk.to widget addon enabled, make sure to enable user access and then go to Addons => Tawk.to widget and choose widget you want to use');
}

function tawk_to_widget_deactivate() {
    full_query('drop table `tawk_to_widget_settings`');
    return array('status'=>'success', 'description'=>'Tawk.to widget addon dactived. Tawk.to widget will not be displayed');
}

function tawk_to_widget_output($vars) {

    if(isset($_GET['ajax'])) {
        header('Content-Type: application/json');

        if(isset($_POST['action']) && $_POST['action'] === 'set' && isset($_POST['page_id']) && isset($_POST['widget_id'])) {
            $page_id = mysql_real_escape_string($_POST['page_id']);
            $widget_id = mysql_real_escape_string($_POST['widget_id']);

            full_query("insert into tawk_to_widget_settings
              (id, page_id, widget_id)
              values(1, '" . $page_id . "', '" . $widget_id . "')
              on duplicate key update page_id='".$page_id."', widget_id='".$widget_id."'");

            echo json_encode(array('success' => TRUE));
        } else if(isset($_POST['action'])  && $_POST['action'] === 'remove') {
            full_query('delete from `tawk_to_widget_settings` where id=1');
            echo json_encode(array('success' => TRUE));
        } else {
            echo json_encode(array('success' => FALSE));
        }

        die();
    }

    $widget = tawk_to_widget_retrieve_widget();

    $iframe_url = TAWK_TO_WIDGET_PLUGINS_BASE_URL.'/generic/widgets?currentWidgetId='.$widget['widget_id'].'&currentPageId='.$widget['page_id'];
    $base_url = TAWK_TO_WIDGET_PLUGINS_BASE_URL;
    $ajax_link = $vars['modulelink'] . '&ajax=1';

    require dirname(__FILE__) . '/templates/widget_choose_iframe.php';
}