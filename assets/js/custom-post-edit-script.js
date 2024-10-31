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

})( jQuery );