/**
 * Description of the file
 *
 * @file
 *
 * @package SIQRP
 */

let intervalCheckPostIsSaved;
let ajaxRequest;
(function ($) {
	$( document ).on(
		"keyup",
		"#siqrp_display_web input[name='limit']",
		function () {
			if ($( this ).val() != "") {
				$( "div[data-value='grid'] .image" ).attr( "class", "image size-" + $( this ).val() );
			}
		}
	);
	$( '#new-tag-post_tag' ).suggest(
		ajaxurl + "?action=ajax-tag-search&tax=post_tag",
		{
			multiple: true,
			delay: 50,
			minchars: 1,
			filter: function (response) {
				console.log( "response-tags", response )
				// JSON.parse, etc.
			},
			onSelect: function () {
				$( ".selected-tags ul" ).append( createHtmlForSelected( this.value ) );
				console.log( "value-tags: ", this.value );
				this.value = '';
			}
		}
	);

	$( '#new-tag-category' ).suggest(
		ajaxurl + "?action=ajax-tag-search&tax=category",
		{
			multiple: true,
			delay: 50,
			minchars: 1,
			filter: function (response) {
				console.log( "response-category", response )
				// JSON.parse, etc.
			},
			onSelect: function () {
				$( ".selected-categories ul" ).append( createHtmlForSelected( this.value ) );
				console.log( "value-category: ", this.value );
				this.value = '';
			}
		}
	);

	function createHtmlForSelected(value)
	{
		var selected = value.split( ',' );
		var html     = '';
		for (i in selected) {
			if ($.trim( selected[i] ) != "") {
				html += '<li>' + selected[i] + '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Remove.</span></button></li>';
			}
		}
		return html;
	}

	$( document ).on(
		"click",
		"#tag_checkbox_all",
		function () {
			if ($( this ).is( ":checked" )) {
				$( 'input[name*="tag_checkbox"]' ).prop( "checked", "checked" ).attr( "checked", "checked" );
			} else {
				$( 'input[name*="tag_checkbox"]' ).prop( "checked", false ).removeAttr( "checked" );
			}
		}
	);

	$( document ).on(
		"click",
		"input[name^='tag_checkbox']",
		function () {
			var length_total   = $( "input[name^='tag_checkbox']" ).not( 'input[name="tag_checkbox[all]"]' ).length;
			var length_checked = $( "input[name^='tag_checkbox']:checked" ).not( 'input[name="tag_checkbox[all]"]' ).length;
			if (length_total == length_checked) {
				$( 'input[name="tag_checkbox[all]"]' ).prop( "checked", "checked" ).attr( "checked", "checked" );
			} else {
				$( 'input[name="tag_checkbox[all]"]' ).prop( "checked", false ).removeAttr( "checked" );
			}
		}
	);

	$( document ).on(
		"click",
		"#category_checkbox_all",
		function () {
			if ($( this ).is( ":checked" )) {
				$( 'input[name*="category_checkbox"]' ).prop( "checked", "checked" ).attr( "checked", "checked" );
			} else {
				$( 'input[name*="category_checkbox"]' ).prop( "checked", false ).removeAttr( "checked" );
			}
		}
	);

	$( document ).on(
		"click",
		"input[name^='category_checkbox']",
		function () {
			var length_total   = $( "input[name^='category_checkbox']" ).not( 'input[name="category_checkbox[all]"]' ).length;
			var length_checked = $( "input[name^='category_checkbox']:checked" ).not( 'input[name="category_checkbox[all]"]' ).length;
			if (length_total == length_checked) {
				$( 'input[name="category_checkbox[all]"]' ).prop( "checked", "checked" ).attr( "checked", "checked" );
			} else {
				$( 'input[name="category_checkbox[all]"]' ).prop( "checked", false ).removeAttr( "checked" );
			}
		}
	);
	if (wp.data != undefined && wp.data.subscribe != undefined) {
		wp.data.subscribe(
			function () {
				let editor = wp.data.select( 'core/editor' );

				if (editor && editor.isSavingPost()
					&& ! editor.isAutosavingPost()
					&& editor.didPostSaveRequestSucceed()
				) {

					if ( ! intervalCheckPostIsSaved) {
						intervalCheckPostIsSaved = setInterval(
							function () {
								if ( ! wp.data.select( 'core/editor' ).isSavingPost()) {
									$( '#siqrp-refresh' ).trigger( "click" );
									clearInterval( intervalCheckPostIsSaved );
									intervalCheckPostIsSaved = null;
								}
							},
							800
						);
					}
				}
			}
		);
	}

})( jQuery );