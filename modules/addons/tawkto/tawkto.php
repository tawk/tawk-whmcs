<?php
/**
 * WHMCS tawk.to Addon Module
 *
 */
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function tawkto_config() {
    $configarray = array(
        "name" => "tawk.to WHMCS Module",
        "description" => "A module designed to make it easier for clients to integrate tawk.to into their websites, with no template edits",
        "version" => "1.2.0",
        "author" => "<a href='https://www.tawk.to/'>tawk.to</a> Team",
        "language" => "english",
        "fields" => array(
                "tawkto-script" => array (
                        "FriendlyName" => "tawk.to Script",
                        "Type" => "textarea",
                        "Rows" => "10",
                        "Cols" => "100",
                        "Description" => "Enter the tawk.to widget script here",
                        "Default" => "",
                    ),
                "tawkto-key" => array (
                        "FriendlyName" => "API Key",
                        "Type" =>  "text",
                        "Size" => "55",
                        "Description" => "Obtained by going to the <a href=https://dashboard.tawk.to>tawk.to dashboard</a>, clicking on the 'Admin' menu, then viewing 'Property Settings' ",
                        "Default" => "",
                    ),
                "tawkto-enable" => array (
                        "FriendlyName" => "Enable mod?",
                        "Type" =>  "yesno",
                        "Size" => "55",
                        "Description" => "A quick way to enable or disable this mod on your website ",
                        "Default" => "",
                    ),
                "tawkto-name" => array ("FriendlyName" => "Show name if logged in?",
                        "Type" =>  "yesno",
                        "Size" => "55",
                        "Description" => "Do you want your user's name displayed in their chat (requires WHMCS login)? ",
                        "Default" => "",
                    ),
                "tawkto-clientsonly" => array ("FriendlyName" => "Only show to clients?",
                        "Type" =>  "yesno",
                        "Size" => "55",
                        "Description" => "Hide from unregistered users?",
                        "Default" => "",
                    ),
                "tawkto-unregonly" => array ("FriendlyName" => "Only show to unregistered?",
                        "Type" =>  "yesno",
                        "Size" => "55",
                        "Description" => "Hide from registered users?",
                        "Default" => "",
                    ),
        	)
    );
    return $configarray;
}
