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

function tawk_to_widget_embed_code_output($vars) {
	$widget = tawk_to_widget_retrieve_widget();

	if($widget['page_id'] === '' || $widget['widget_id'] === '') {
		return;
	}

	return '<!--Start of Tawk.to Script-->
		<script type="text/javascript">
		var $_Tawk_API={},$_Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src="https://embed.tawk.to/'.$widget['page_id'].'/'.$widget['widget_id'].'";
		s1.charset="UTF-8";
		s1.setAttribute("crossorigin","*");
		s0.parentNode.insertBefore(s1,s0);
		})();
		</script>
		<!--End of Tawk.to Script-->';
}

add_hook("ClientAreaFooterOutput", 1, "tawk_to_widget_embed_code_output");
