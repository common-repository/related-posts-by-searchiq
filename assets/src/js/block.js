/**
 * Description of the file
 *
 * @file
 *
 * @package SIQRP
 */

(function (blocks, i18n, element, components, editor, blockEditor) {
	var el               = element.createElement;
	var useEffect        = element.useEffect;
	const
	{
		registerBlockType,
		createBlock
	}                    = blocks;
	const
	{
		__
	}                    = i18n; // translation functions.
	var ServerSideRender = wp.serverSideRender;
	const
	{
		RichText,
		InspectorControls
	}                    = blockEditor;

	const iconEl = el(
		'svg',
		{
			width: '48',
			height: '48',
			viewBox: '0 0 48 48',
			fill: 'none'
		},
		[
		el(
			'rect',
			{
				width: '48',
				height: '48',
				fill: '#CD2B14'
				}
		),
		el(
			'path',
			{
				fillRule: 'evenodd',
				clipRule: 'evenodd',
				d: 'M3.3457 43.3665H45.3457V3.59375H3.3457V43.3665Z',
				fill: '#CD2B14',
				}
		),
		el(
			'path',
			{
				d: 'M8.32117 36.3626H13.012V18.8138H8.32117V36.3626ZM10.6485 16.4501C10.2425 16.4501 9.85478 16.3729 9.48475 16.2172C9.1145 16.0624 8.79208 15.8475 8.51797 15.5728C8.24328 15.2987 8.02833 14.9819 7.87325 14.6235C7.71793 14.2656 7.64062 13.8716 7.64062 13.4416C7.64062 13.0119 7.71793 12.618 7.87325 12.2598C8.02833 11.9018 8.24328 11.5856 8.51797 11.3109C8.79208 11.0364 9.1145 10.8218 9.48475 10.6661C9.85478 10.511 10.2425 10.4336 10.6485 10.4336C11.4841 10.4336 12.2002 10.7262 12.7974 11.3109C13.3936 11.8961 13.6924 12.6064 13.6924 13.4416C13.6924 14.2779 13.3936 14.9879 12.7974 15.5728C12.2002 16.158 11.4841 16.4501 10.6485 16.4501Z',
				fill: 'white',
				}
		),
		el(
			'path',
			{
				d: 'M28.463 28.2091L31.8502 25.9059L34.4923 29.9025C35.1018 29.2032 35.5813 28.3841 35.9317 27.4468C36.2817 26.5102 36.4567 25.4771 36.4567 24.3477C36.4567 23.1062 36.2477 21.9715 35.83 20.9437C35.4121 19.9163 34.8359 19.0416 34.1026 18.3184C33.3686 17.5962 32.5108 17.0315 31.5282 16.625C30.5462 16.2185 29.4905 16.0152 28.3614 16.0152C27.232 16.0152 26.1766 16.2185 25.1943 16.625C24.2123 17.0315 23.3538 17.5962 22.6202 18.3184C21.8862 19.0416 21.3104 19.9163 20.8928 20.9437C20.4745 21.9715 20.2661 23.1062 20.2661 24.3477C20.2661 25.5898 20.4745 26.7246 20.8928 27.7517C21.3104 28.7795 21.8862 29.6545 22.6202 30.377C23.3538 31.0999 24.2123 31.6639 25.1943 32.0704C26.1766 32.477 27.232 32.6802 28.3614 32.6802C28.8578 32.6802 29.332 32.6351 29.7842 32.5446C30.2355 32.4547 30.6757 32.3302 31.1048 32.1721L28.463 28.2091ZM33.6113 35.9318C32.8208 36.2707 31.9855 36.5355 31.1048 36.7277C30.2244 36.9192 29.3097 37.0158 28.3614 37.0158C26.5546 37.0158 24.878 36.688 23.3316 36.0334C21.7846 35.3789 20.4465 34.481 19.3178 33.3405C18.1881 32.2003 17.3023 30.8569 16.6589 29.3099C16.0154 27.7635 15.6934 26.1091 15.6934 24.3477C15.6934 22.5863 16.0154 20.9326 16.6589 19.3856C17.3023 17.8392 18.1881 16.4951 19.3178 15.3546C20.4465 14.2148 21.7846 13.3172 23.3316 12.6617C24.878 12.0074 26.5546 11.6797 28.3614 11.6797C30.1679 11.6797 31.8442 12.0074 33.3915 12.6617C34.9379 13.3172 36.2759 14.2148 37.4053 15.3546C38.5341 16.4951 39.4205 17.8392 40.0639 19.3856C40.7077 20.9326 41.0294 22.5863 41.0294 24.3477C41.0294 26.2222 40.6791 27.9607 39.9791 29.5639C39.2791 31.1672 38.2968 32.5446 37.0325 33.6962L38.8955 36.4736L35.5083 38.7432L33.6113 35.9318Z',
				fill: 'white',
				}
		),
		el(
			'path',
			{
				fillRule: 'evenodd',
				clipRule: 'evenodd',
				d: 'M29.963 29.6845L28.3965 27.3345L30.405 25.9688L31.9718 28.3387L33.4781 30.5883L34.5826 32.2353L32.5743 33.5811L31.4493 31.914L29.963 29.6845Z',
				stroke: '#CD2B14',
				strokeWidth: '6.42329',
				}
		),
		el(
			'path',
			{
				fillRule: 'evenodd',
				clipRule: 'evenodd',
				d: 'M31.0383 32.235L28.3965 28.272L31.7837 25.9688L34.4258 29.9654L36.9659 33.7591L38.8286 36.5365L35.4418 38.8061L33.5447 35.9947L31.0383 32.235Z',
				fill: 'white',
				}
		),
		]
	);

	const
	{
		TextControl,
		CheckboxControl,
		RadioControl,
		SelectControl,
		TextareaControl,
		ToggleControl,
		RangeControl,
		Panel,
		PanelBody,
		PanelRow,
	} = components;

	registerBlockType(
		'siqrp/siqrp-block',
		{
			title: __( 'SearchIQ Related Posts', 'related-posts-by-searchiq' ),
			description: __(
				'Display related posts by SearchIQ',
				'related-posts-by-searchiq',
			),
		category: 'siqrp',
		icon: iconEl,
		keywords: [
				__( 'siqrp', 'related-posts-by-searchiq' ),
				__( 'yet another', 'related-posts-by-searchiq' ),
				__( 'related posts', 'related-posts-by-searchiq' ),
				__( 'contextual', 'related-posts-by-searchiq' ),
				__( 'popular', 'related-posts-by-searchiq' ),
				__( 'similar', 'related-posts-by-searchiq' ),
				__( 'grid', 'related-posts-by-searchiq' ),
				__( 'you may also', 'related-posts-by-searchiq' ),
				__( 'posts', 'related-posts-by-searchiq' ),
		],
		supports:
		{
			html: false,
			},

			transforms:
			{
				from: [
				{
					type: 'block',
					blocks: ['core/legacy-widget'],
					isMatch: (
					{
							idBase,
							instance
					}) =>
				{
					if ( ! instance || ! instance.raw ) {
						// Can't transform if raw instance is not shown in REST API..
						return false;
					}
					return idBase === 'siqrp_widget';
					},
					transform: (
					{
							instance,
							...rest
					}) =>
				{
					const template = instance.raw.template;
					const heading  =
					'heading' in instance.raw ?
					instance.raw.heading :
					template === 'grid' || template === 'list' || template === 'minimal' ?
					instance.raw.thumbnails_heading :
					instance.raw.title;
					return createBlock(
						'siqrp/siqrp-block',
						{
							name: 'siqrp_widget',
							template: template,
							heading: heading,
							domain: 'widget',
						}
					);
					},
				}, ],
			},

			attributes:
			{
				reference_id:
				{
					type: 'string',
					default: '',
						},
						heading:
							{
								type: 'string',
								default: __( siqrp_localized.heading, 'related-posts-by-searchiq' ),
									},
									limit:
										{
											type: 'number',
											default: 3,
												},
												template:
															{
																type: 'string',
																default: siqrp_localized.selected_theme_style,
																	},
																	siqrp_preview:
																	{
																		type: 'string',
																	},
																	domain:
																	{
																		type: 'string',
																		default: 'block',
																			},
																			siqrp_is_admin:
																			{
																				type: 'boolean',
																				default: siqrp_localized.siqrp_is_admin,
																					},
																					},
																					example:
																									{
																										attributes:
																										{
																											siqrp_preview: 'siqrp_preview',
																										},
																					},
																					edit: function (props) {
																						const attributes    = props.attributes;
																						const setAttributes = props.setAttributes;
																						var template        = Object.keys( siqrp_localized.template ).map(
																							function (key) {
																																	return {
																																		value: key,
																																		label: siqrp_localized.template[key]
																								};
																							}
																						);

																						if (props.isSelected) {
																							// console.debug(props.attributes);.
																						}

																						// Functions to update attributes..
																						function changeGrid(template)
																						{
																							setAttributes(
																								{
																									template
																								}
																							);
																						}

																						function shouldShowHeading(template)
																						{
																							const is_widget = siqrp_localized.default_domain === 'widget';
																							if (is_widget) {
																								return ['', 'list', 'grid', 'minimal'].includes(
																									template,
																								);
																							}

																							return ['','list', 'grid', 'minimal'].includes( template );
																						}

																						useEffect(
																							() =>
																							{
																								setAttributes(
																									{
																										domain: siqrp_localized.default_domain
																									}
																								);
																							},
																							[]
																						);

																						return [
																						/**
																						 * Server side render
																						 */
																						el(
																							'div',
																							{
																								className: props.className
																							},
																							el(
																								ServerSideRender,
																								{
																									block: 'siqrp/siqrp-block',
																									attributes: attributes,
																								}
																							),
																						),

																						/**
																						 * Inspector
																						 */
																						el(
																							InspectorControls,
																							{},
																							el(
																								PanelBody,
																								{
																									title: 'SearchIQ Related Posts Settings',
																									initialOpen: true
																								},
																								el(
																									TextControl,
																									{
																										label: __(
																											'Reference ID (Optional)',
																											'related-posts-by-searchiq',
																										),
																									value: attributes.reference_id,
																									help: __(
																										'The ID of the post to use for finding related posts. Defaults to current post.',
																										'related-posts-by-searchiq',
																									),
																									onChange: function (val) {
																										setAttributes(
																											{
																												reference_id: val
																											}
																										);
																									},
																									}
																								),
																								el(
																									TextControl,
																									{
																										label: __(
																											'Maximum number of posts',
																											'related-posts-by-searchiq',
																										),
																									value: attributes.limit,
																									onChange: function (val) {
																										setAttributes(
																											{
																												limit: parseInt( val )
																											}
																										);
																									},
																										type: 'number',
																										min: 1,
																										step: 1,
																									}
																								),
																								el(
																									SelectControl,
																									{
																										value: attributes.template,
																										label: __( 'Theme', 'related-posts-by-searchiq' ),
																										onChange: changeGrid,
																										options: template,
																									}
																								),
																								shouldShowHeading( attributes.template ) &&
																								el(
																									TextControl,
																									{
																										label: __( 'Heading', 'related-posts-by-searchiq' ),
																										value: attributes.heading,
																										onChange: function (val) {
																											setAttributes(
																												{
																													heading: val
																												}
																											);
																										},
																									}
																								),
																							),
																						),
																						];
																					},

																					save()
																					{
																						return null; // save has to exist. This all we need.
			},
		}
	);
})(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element,
	window.wp.components,
	window.wp.editor,
	window.wp.blockEditor,
	window.wp.serverSideRender,
);

// Support for Legacy Widgets per WP 5.8 widgets change.
(function ($) {
	$( document ).on(
		'widget-added',
		function () {
			$( '.siqrp-widget-select-control', '#wpbody' ).each( ensureTemplateChoice );
			$( '.siqrp-widget-select-control select', '#wpbody' ).on(
				'change',
				ensureTemplateChoice,
			);

			function ensureTemplateChoice(e)
			{
				if (typeof e === 'object' && 'type' in e) {
					e.stopImmediatePropagation();
				}
				var this_form = $( this ).closest( 'form' ),
				widget_id     = this_form.find( '.widget-id' ).val();
				// if this widget is just in staging:.
				if (/__i__$/.test( widget_id )) {
					return;
				}

				const select       = $( '#widget-' + widget_id + '-template_file' ).val();
				const show_heading = select === 'list' || select === 'grid';
				$( '#widget-' + widget_id + '-heading' )
				.closest( 'p' )
				.toggle( show_heading );
			}
		}
	);
})( jQuery );