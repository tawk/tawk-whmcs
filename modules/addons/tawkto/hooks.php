<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Collection;
function tawkto_check($vars)
{

    $uid = $_SESSION['uid'];

    //get the code
    $widgetScript = Capsule::table('tbladdonmodules')->select('value')-> WHERE('module', '=' , 'tawkto')->WHERE('setting' , '=', 'tawkto-script')->pluck('value');

    if ($widgetScript instanceof Collection) {
        $widgetScript = $widgetScript->all();
    }

    if (is_array($widgetScript)) {
        $widgetScript = current($widgetScript);
    }

    if ($widgetScript) {
        // $widgetScript = addslashes($widgetScript); // this breaks the widget script when displayed on client side
        // $widgetScript = htmlentities($widgetScript); // this displays the script as html text and prevents proper rendering of the script
        $widgetScript = trim($widgetScript);
    } else {
        return;
    }

    // get the API key, if set
    $apikey =  Capsule::table('tbladdonmodules')->select('value')-> WHERE('module', '=' , 'tawkto')->WHERE('setting' , '=', 'tawkto-key')->pluck('value');
    if ($apikey instanceof Collection) {
        $apikey = $apikey->all();
    }
    if (is_array($apikey)) {
        $apikey = current($apikey);
    }
    if ($apikey) {
        $apikey = trim($apikey);
    }

    //no tawk-y (for now)
    $isenabled =  Capsule::table('tbladdonmodules')->select('value')-> WHERE('module', '=' , 'tawkto')->WHERE('setting' , '=', 'tawkto-enable')->WHERE('value' , 'on')->count();
    if (empty($isenabled)) {
        return;
    }

    //clients only
    $clientsonly =  Capsule::table('tbladdonmodules')->select('value')-> WHERE('module', '=' , 'tawkto')->WHERE('setting' , '=', 'tawkto-clientsonly')->WHERE('value' , 'on')->count();
    if (!empty($clientsonly)) {
        if (empty($uid)) {
            return;
        }
    }
    //maybe we just wanna chat with guests?
    $guestonly =  Capsule::table('tbladdonmodules')->select('value')-> WHERE('module', '=' , 'tawkto')->WHERE('setting' , '=', 'tawkto-unregonly')->WHERE('value' , 'on')->count();
    if (!empty($guestonly)) {
        if (!empty($uid)) {
            return;
        }
    }

    // no name is show by default
    $tawkname = "";
    if (isset($uid)) {
        //to name, or not to name, that is the question
        $showname =  Capsule::table('tbladdonmodules')->select('value')-> WHERE('module', '=' , 'tawkto')->WHERE('setting' , '=', 'tawkto-name')->WHERE('value' , 'on')->count();

        if ($showname) {
            //now we get what we get!
            foreach (Capsule::table('tblclients') ->WHERE('id', $uid)->get() as $tawkclients) {
                $fname = html_entity_decode($tawkclients->firstname, ENT_QUOTES);
                $tlname = html_entity_decode($tawkclients->lastname, ENT_QUOTES);
                $fname = addslashes($fname);
                $lname = addslashes($tlname);
                $company = $tawkclients->companyname;
                $emailaddress = $tawkclients->email;
            }

            // show in secure mode if api key is set. else, show basic name/email info
            if (($fname || $lname) && $emailaddress) {
                if ($apikey && strlen($apikey) > 10) {
                    $hash = hash_hmac("sha256", $emailaddress, $apikey);
                    $tawkname = "Tawk_API.visitor = {
                        name  : '{$fname} {$lname}',
                        email : '{$emailaddress}',
                        hash : '{$hash}'
                    };";
                } else {
                    $tawkname = "Tawk_API.visitor = {
                        name  : '{$fname} {$lname}',
                        email : '{$emailaddress}'
                    };";
                }
            }
        }
    }

    //get the key
    $tawkreturn = "$widgetScript";
    $tawkreturn = str_ireplace('</script>', $tawkname.'</script>', $tawkreturn);
    return($tawkreturn);
}
add_hook("ClientAreaFooterOutput",1,"tawkto_check");
