// phpcs:ignore Squiz.Commenting.FileComment.Missing
/**
 * Description of the file
 *
 * @file
 *
 * @package SIQRP
 */

function siqrpMakeTheSwitch($, data, url)
{
	$.get(
		url,
		data,
		function (resp) {
			if (resp === 'ok') {
				window.location.href = './admin.php?page=siqrp';
			}
		}
	);
}

jQuery( document ).ready(
	function ($) {
		$( '.siqrp_switch_button' ).on(
			'click',
			function (e) {
				e.preventDefault();
				var url = ajaxurl,
				data    = {
					action: 'siqrp_switch',
					go: $( this ).data( 'go' ),
					_ajax_nonce: $( '#siqrp_switch-nonce' ).val(),
				};

				if (data.go === 'basic') {
					$( '#wpwrap' ).after(
						'<div id="siqrp_pro_disable_overlay">' +
						'</div>' +
						'<div id="siqrp_pro_disable_confirm">' +
						'<p>' +
						'Are you sure you would like to deactivate SIQRP Pro? ' +
						'Doing so will remove all <strong>SIQRP Pro</strong> ' +
						'content from your site, including sidebar widgets.' +
						'</p>' +
						'<br/>' +
						'<a id="siqrp_proceed_deactivation" class="button">Deactivate SIQRP Pro</a>' +
						'&nbsp;&nbsp;&nbsp;&nbsp;' +
						'<a id="siqrp_cancel_deactivation" class="button-primary">Cancel Deactivation</a>' +
						'</div>',
					);
					$( '#siqrp_proceed_deactivation' ).on(
						'click',
						function () {
							siqrpMakeTheSwitch( $, data, url );
						}
					);

					$( '#siqrp_cancel_deactivation' ).on(
						'click',
						function () {
							window.location.reload();
						}
					);
				} else {
					siqrpMakeTheSwitch( $, data, url );
				}
			}
		);

		$( '#siqrp-display-mode-save' ).on(
			'click',
			function (e) {
				e.preventDefault();
				var url = $( this ).attr( 'href' ),
				data    = {
					ypsdt: true,
					types: [],
				};

				$( this ).after( $( '<span class="spinner"></span>' ) );

				var i = 0;
				$( 'input', '#siqrp-display-mode' ).each(
					function (idx, val) {
						if (val.checked) {
							data.types[i] = val.value;
							i++;
						}
					}
				);

				$.get(
					url,
					data,
					function (resp) {
						setTimeout(
							function () {
								if (resp === 'ok') {
										$( '.spinner', '#siqrp-display-mode' ).remove();
								} else {
									$( '#siqrp-display-mode' ).append(
										$(
											'<span style="vertical-align: middle" class="error-message">Something went wrong saving your settings. Please refresh the page and try again.</span>',
										),
									);
								}
							},
							1000
						);
					}
				);
			}
		);
	}
);
