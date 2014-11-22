<?php
/**
 * @author     Tawk.to
 * @copyright  Copyright (c) Tawk.to 2014
 * @license    http://www.whmcs.com/license/ WHMCS Eula
 * @link       https://tawk.to
 */

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");
?>

<iframe
	id="tawkIframe"
	src=""
	style="min-height: 400px; width : 100%; border: none; margin-top: 20px">
</iframe>

<script type="text/javascript">
	var currentHost = window.location.protocol + "//" + window.location.host,
		url = "<?php echo $iframe_url?>&parentDomain=" + currentHost,
		baseUrl = '<?php echo $base_url ?>',
		current_id_tab = '{$tab_id}',
		controller = '<?php echo $ajax_link ?>';

	jQuery('#tawkIframe').attr('src', url);

	var iframe = jQuery('#tawk_widget_customization')[0];

	window.addEventListener('message', function(e) {

		if(e.origin === baseUrl) {

			if(e.data.action === 'setWidget') {
				setWidget(e);
			}

			if(e.data.action === 'removeWidget') {
				removeWidget(e);
			}
		}
	});

	function setWidget(e) {

		$.ajax({
			type     : 'POST',
			url      : controller,
			dataType : 'json',
			data     : {
				action     : 'set',
				page_id     : e.data.pageId,
				widget_id   : e.data.widgetId
			},
			success : function(r) {
				if(r.success) {
					e.source.postMessage({action: 'setDone'} , baseUrl);
				} else {
					e.source.postMessage({action: 'setFail'} , baseUrl);
				}
			}
		});
	}

	function removeWidget(e) {
		$.ajax({
			type     : 'POST',
			url      : controller,
			dataType : 'json',
			data     : {
				action : 'remove',
			},
			success : function(r) {
				if(r.success) {
					e.source.postMessage({action: 'removeDone'} , baseUrl);
				} else {
					e.source.postMessage({action: 'removeFail'} , baseUrl);
				}
			}
		});
	}
</script>