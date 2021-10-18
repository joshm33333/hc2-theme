
			function findObjectByKey(array, key, value) {
				for (var i = 0; i < array.length; i++) {
					if (array[i][key] === value) {
						return array[i];
					}
				}
				return null;
			}
			
var 
el = wp.element,
ce = el.createElement,
ed = wp.editor,
bd = wp.blockEditor,
cp = wp.components;
 
wp.hooks.addFilter( 'blocks.registerBlockType', 'hcube/setcore-group',( settings,name ) => {
	
	var preset_string = { type: 'string', default: '' };
	var preset_bool = { type: 'boolean', default: false };
	  
    if ( name === 'core/group' && typeof settings.attributes !== 'undefined' ){
		settings.attributes = Object.assign( settings.attributes, {
			
			mediaid:preset_string,		href:preset_string,			modalid:preset_string,
			margintop:preset_string,	marginleft:preset_string,	marginright:preset_string,	marginbottom:preset_string,
			paddingtop:preset_string,	paddingleft:preset_string,	paddingright:preset_string,	paddingbottom:preset_string,
			inline:preset_bool,	full:preset_bool,	overflow:preset_bool,	fullcontent:preset_bool,	height:preset_bool,
			uniqueurl:preset_bool,		uniqueurl_ifstatement:preset_string,
			
			sticky: {type: 'string',default: 'relative'}, 
			vertical: {type: 'string',default: 'top'}, 
		
			maxdisplay:preset_bool,
			maxdisplaywidth:{ 			type: 'number', 	default: 300, },
			maxdisplayside:{ 			type: 'string', 	default: '', },
			maxdisplaysnap:{ 			type: 'number', 	default: 600, },
			
			maxvison:preset_bool,maxvis:{ 			type: 'number', 	default: 1000, },
			minvison:preset_bool,minvis:{ 			type: 'number', 	default: 600, },
			centeron:preset_bool,center:{ 			type: 'number', 	default: 600, },
			
			animate:{ 								type: 'string', 	default: 'none', },
			animtype:{ 								type: 'string', 	default: 'dir', },
			duration:{ 								type: 'string', 	default: 2000, },
			opacity:{ 								type: 'number', 	default: 255, },
			
			cardelay:{ 								type: 'string', 	default: 2000, },
			carheight:{ 							type: 'string', 	default: '400', },
			carwidth:{ 								type: 'string', 	default: '1200', },
			
			faqmode:{ 								type: 'boolean', 	default: false, },
			hiddeng:{ 								type: 'boolean', 	default: false, },
			
			person:{ 								type: 'boolean', 	default: false, },
			gen_person:{ 							type: 'boolean', 	default: true, },
			person_byid:{ 							type: 'boolean', 	default: true, },
			person_isauthor:{ 						type: 'boolean', 	default: true, },
			author_id:{ 							type: 'string', 	default: '' },
			person_name:{ 							type: 'string', 	default: '' },
			person_description:{ 					type: 'string', 	default: '' },
			person_telephone:{ 						type: 'string', 	default: '' },
			person_gender:{ 						type: 'string', 	default: '' },
			person_birthdate:{ 						type: 'string', 	default: '' },
			person_jobtitle:{ 						type: 'string', 	default: '' },
			person_email:{ 							type: 'string', 	default: '' },
			person_image:{ 							type: 'string', 	default: '' },
			person_sameas:{ 						type: 'string', 	default: '' },
			
			counttarget:{ 							type: 'string', 	default: '2021-06-01T09:00:00+08:00' },
			
			func:{ 									type: 'string', 	default: 'none', }, 
			template_def:{							type: 'string', 	default: 'non', }, 
			template_def_spe:{						type: 'string', 	default: '', }, 
			template_height:{						type: 'string', 	default: '', }, 
			template_mode:{							type: 'string', 	default: 'gps', }, 
			accordion:{ 							type: 'boolean', 	default: true, },
			section:{ 								type: 'boolean', 	default: false, },
			acchead:{ 								type: 'boolean', 	default: false, },
			expanded:{ 								type: 'boolean', 	default: false, },
			
			ed_minimize:{ 								type: 'boolean', 	default: false, }
			
		}); 
	}

	return settings;
})

wp.hooks.addFilter( 'editor.BlockEdit', 'hcube/editcore-group',  
	wp.compose.createHigherOrderComponent( function( BlockEdit ) {

		return function( props ) {
			
			const { name, attributes } = props;
			const { template_height, template_mode, template_def, template_def_spe, expanded, vertical, inline, hiddeng, ed_minimize, overflow, opacity, func, href, full, height, fullcontent, counttarget,
					faqmode, gen_person, person_byid, person, person_isauthor, author_id, person_name, person_description, person_gender, person_birthdate, person_jobtitle, person_telephone, person_email, person_image, person_sameas,
					mediaid, modalid, center, centeron, accordion, section, acchead, animate, duration, animtype,
					margintop, marginleft, marginright, marginbottom, uniqueurl, uniqueurl_ifstatement,
					paddingtop, paddingleft, paddingright, paddingbottom,
					maxdisplay, maxdisplayside, maxdisplaywidth, maxdisplaysnap,
					maxvison, minvison, maxvis, minvis, cardelay, carheight, carwidth,
					backgroundColor, customBackgroundColor, sticky					} = attributes;
			
			return ce( el.Fragment, {}, 
				ce( BlockEdit, props ),
				name === 'core/group' ? ce( bd.InspectorControls, {},
					
					ce( cp.PanelBody, { title: 'Editor Settings', initialOpen: false },	
						ce( cp.ToggleControl, { label:'Minimize in Editior', 			value:'1', 	checked: ed_minimize,			onChange: function(val){ props.setAttributes({ ed_minimize:val }) }}),
					),
					ce( cp.PanelBody, { className: 'hcube_smallControsl', title: 'Display', initialOpen: false },
						ce( cp.RangeControl, 	{ label:'Background Opacity',					value:opacity,initialPosition:255,min:0,max:255,	onChange: function( val ) { props.setAttributes({ opacity:val   	})}}),
						ce(cp.ButtonGroup, {},
							ce( cp.Button, { value:'1',isDefault:(sticky=='relative'?false:true),isPrimary:(sticky=='relative'?true:false),onClick: function( val ) {props.setAttributes( { sticky: 'relative' } )}}, 'Default' ),
							ce( cp.Button, { value:'1',isDefault:(sticky=='sticky'?false:true),isPrimary:(sticky=='sticky'?true:false),onClick: function( val ) {props.setAttributes( { sticky: 'sticky' } )}}, 'Sticky' ),
							ce( cp.Button, { value:'1',isDefault:(sticky=='fixed'?false:true),isPrimary:(sticky=='fixed'?true:false),onClick: function( val ) {props.setAttributes( { sticky: 'fixed' } )}}, 'Fixed' ),
							sticky != 'relative' ? ce ( cp.ButtonGroup, {},
								ce( cp.Button, { value:'1',isDefault:(vertical=='top'?false:true),isPrimary:(vertical=='top'?true:false),onClick: function( val ) {props.setAttributes( { vertical: 'top' } )}}, 'Top' ),
								ce( cp.Button, { value:'1',isDefault:(vertical=='bottom'?false:true),isPrimary:(vertical=='bottom'?true:false),onClick: function( val ) {props.setAttributes( { vertical: 'bottom' } )}}, 'Bottom' ),
							) : null,
						),
						ce( cp.ToggleControl, 	{ label:'Hidden', 					value:'1', 	checked: hiddeng,						onChange: function( val ) { props.setAttributes({ hiddeng:val		})}}),
						ce( cp.ToggleControl, 	{ label:'Allow Wrapping', 			value:'1', 	checked: inline,						onChange: function( val ) { props.setAttributes({ inline:val		})}}),
						ce( cp.ToggleControl, 	{ label:'Overflow Visible', 		value:'1', 	checked: overflow,						onChange: function( val ) { props.setAttributes({ overflow:val 		})}}),
						
						ce( cp.ToggleControl, { label:'Constrained Width',	value:'1', 	checked: ( maxdisplay ),	onChange: function(val){ props.setAttributes({ maxdisplay: val }) }}),
						maxdisplay? ce( 'div', { className: 'hcube_indentedControls' },
							ce( cp.ButtonGroup, {},
								ce( cp.Button, {value:'1', isDefault:( maxdisplayside=='margin-left'?false:true), isPrimary:( maxdisplayside=='margin-left'?true:false), onClick: function( val ) { props.setAttributes( { maxdisplayside: 'margin-left' } ); }}, 'Left' ),
								ce( cp.Button, {value:'1', isDefault:( maxdisplayside==''?false:true), isPrimary:( maxdisplayside==''?true:false), onClick: function( val ) { props.setAttributes( { maxdisplayside: '' } ); }}, 'Center' ),
								ce( cp.Button, {value:'1', isDefault:( maxdisplayside=='margin-right'?false:true), isPrimary:( maxdisplayside=='margin-right'?true:false), onClick: function( val ) { props.setAttributes( { maxdisplayside: 'margin-right' } ); }}, 'Right' ),
							),	
							ce( cp.RangeControl, {label: 'Group Width',value: maxdisplaywidth,initialPosition:300,min:0,max:1200,onChange:function(val){props.setAttributes({maxdisplaywidth:val})}}),
							ce( cp.RangeControl, {label: 'Min Screen Width',value: maxdisplaysnap,initialPosition:600,min:0,max:1200,onChange:function(val){props.setAttributes({maxdisplaysnap:val})}})
						) : null,
						
						ce( cp.ToggleControl, { label:'Center Content on Mobile',	value:'1', 	checked: ( centeron ),	onChange: function(val){ props.setAttributes({ centeron: val }) }}),
						centeron ? ce( 'div', { className: 'hcube_indentedControls' },
							ce( cp.RangeControl, {label: 'Screen Width',value: center,initialPosition:600,min:1,max:4000,onChange:function(val){props.setAttributes({center:val})}})
						) : null,
						
						ce( cp.ToggleControl, { label:'Max Visible Width',	value:'1', 	checked: ( maxvison ),	onChange: function(val){ props.setAttributes({ maxvison: val }) }}),
						maxvison ? ce( 'div', { className: 'hcube_indentedControls' }, 
							ce( cp.RangeControl, {label: 'Screen Width',value: maxvis,initialPosition:1000,min:0,max:4000,onChange:function(val){props.setAttributes({maxvis:val})}}) 
						) : null,
					
						ce( cp.ToggleControl, { label:'Min Visible Width',	value:'1', 	checked: ( minvison ),	onChange: function(val){ props.setAttributes({ minvison: val }) }}),
						minvison ? ce( 'div', { className: 'hcube_indentedControls' }, 
							ce( cp.RangeControl, {label: 'Screen Width',value: minvis,initialPosition:600,min:0,max:4000,onChange:function(val){props.setAttributes({minvis:val})}}) 
						) : null,
						
					),
					ce( cp.PanelBody, { title: 'Padding & Margin', initialOpen: margintop||marginleft||marginright||marginbottom||paddingtop||paddingleft||paddingright||paddingbottom },	
						ce( 'div', { className: 'hcube_marginbox' },
							ce( cp.TextControl,		{ label: 'Left',	value: marginleft,			onChange: function( val ) { props.setAttributes({ marginleft: val 	})}}),
							ce( cp.TextControl,		{ label: 'Right',	value: marginright,			onChange: function( val ) { props.setAttributes({ marginright: val 	})}}),
							ce( cp.TextControl,		{ label: 'Top',		value: margintop,			onChange: function( val ) { props.setAttributes({ margintop: val 	})}}),
							ce( cp.TextControl,		{ label: 'Bottom',	value: marginbottom,		onChange: function( val ) { props.setAttributes({ marginbottom: val })}}), 
						),
						
						ce( 'div', { className: 'hcube_marginbox' },
							ce( cp.TextControl,		{ label: 'Left',	value: paddingleft,			onChange: function( val ) { props.setAttributes({ paddingleft: val 		})}}),
							ce( cp.TextControl,		{ label: 'Right',	value: paddingright,		onChange: function( val ) { props.setAttributes({ paddingright: val 	})}}),
							ce( cp.TextControl,		{ label: 'Top',		value: paddingtop,			onChange: function( val ) { props.setAttributes({ paddingtop: val 		})}}),
							ce( cp.TextControl,		{ label: 'Bottom',	value: paddingbottom,		onChange: function( val ) { props.setAttributes({ paddingbottom: val 	})}}),
						),

					),
					ce( cp.PanelBody, { title: 'Functions', initialOpen: func !== 'none' },	
						ce( cp.SelectControl, 	{label: 'Function', value: func, options: [
								{ label: 'Basic', value: 'none' },
								{ label: 'Lightbox', value: 'modal' },
								{ label: 'Accordion', value: 'accordion' },
								{ label: 'Countdown', value: 'countdown' },
								{ label: 'Template', value: 'template' },
								{ label: 'Mega Menu Content' , value: 'media' }
							], onChange: function( val ) { props.setAttributes( { func: val } )}} ),	
						func === 'countdown' ? ce( 'div', { className: 'hcube_indentedControls' },
							ce( cp.TextControl,{ placeholder: '2021-06-01T09:00:00+08:00', label: 'Target Date/Time',value: counttarget,onChange: function( val ) {props.setAttributes( { counttarget: val } );}}),		
						): null,	
						func === 'template' ? ce( 'div', { className: 'hcube_indentedControls' },
							ce( cp.TextControl, {label: 'Height',value: template_height,onChange: function( val ) {props.setAttributes( { template_height: val } );}}),
							ce( cp.ButtonGroup, {},
								ce( cp.Button, {value:'1',		isDefault:( template_def=='all'?false:true),	isPrimary:( template_def=='all'?true:false),	onClick: function( val ) { props.setAttributes( { template_def: 'all' } )}}, 'All' ),
								ce( cp.Button, {value:'1',		isDefault:( template_def=='non'?false:true),	isPrimary:( template_def=='non'?true:false),	onClick: function( val ) { props.setAttributes( { template_def: 'non' } )}}, 'None' ),
								ce( cp.Button, {value:'1',		isDefault:( template_def=='cls'?false:true),	isPrimary:( template_def=='cls'?true:false),	onClick: function( val ) { props.setAttributes( { template_def: 'cls' } )}}, 'Nearest' ),
								ce( cp.Button, {value:'1',		isDefault:( template_def=='spe'?false:true),	isPrimary:( template_def=='spe'?true:false),	onClick: function( val ) { props.setAttributes( { template_def: 'spe' } )}}, 'Specify' ),
							),	
							ce( cp.ButtonGroup, {},
								ce( cp.Button, {value:'1',		isDefault:( template_mode=='gps'?false:true),	isPrimary:( template_mode=='gps'?true:false),	onClick: function( val ) { props.setAttributes( { template_mode: 'gps' } )}}, 'Nearest Address' ),
								ce( cp.Button, {value:'1',		isDefault:( template_mode=='first'?false:true),	isPrimary:( template_mode=='first'?true:false),	onClick: function( val ) { props.setAttributes( { template_mode: 'first' } )}}, 'First Visit' ),
							),	
							template_def=='spe'?ce( cp.TextControl, {label: 'Address ID',value: template_def_spe,onChange: function( val ) {props.setAttributes( { template_def_spe: val } );}}):null,
						): null,				
						func === 'none' ? ce( 'div', { className: 'hcube_indentedControls' }, 
							ce( 'p', { className: 'hcube_linktitle' }, href ),
							ce( ed.URLInputButton, { url: href, onChange: function( url ) { props.setAttributes( { href: url } ) } } ) 
						) : null,
						func === 'carousel' ? ce( 'div', { className: 'hcube_indentedControls' },
							ce( cp.TextControl, {label: 'Delay in Milliseconds',value: cardelay,onChange: function( val ) {props.setAttributes( { cardelay: val } );}}),
							ce( cp.TextControl, {label: 'Height',value: carheight,onChange: function( val ) {props.setAttributes( { carheight: val } );}}),
							ce( cp.TextControl, {label: 'Width',value: carwidth,onChange: function( val ) {props.setAttributes( { carwidth: val } );}})
						): null,
						func === 'accordion' ? ce( 'div', { className: 'hcube_indentedControls' }, 
							ce( cp.ButtonGroup, {},
								ce( cp.Button, {value:'1',		isDefault:( section ),			isPrimary:( accordion ),		onClick: function( val ) { props.setAttributes( { accordion: true } ); props.setAttributes( { section: false } ); }}, 'Parent' ),
								ce( cp.Button, {value:'1',		isDefault:( accordion ),		isPrimary:( section ),			onClick: function( val ) { props.setAttributes( { accordion: false } ); props.setAttributes( { section: true } ); }}, 'Child' ),
								section ? ce( cp.ToggleControl, { className: 'hcube_extramarg', label:'Expanded on Desktop',	value:'1', 	checked: expanded,			onChange: function( val ) { props.setAttributes({ expanded:val })}}) : null,
								section ? ce( cp.ToggleControl, { className: 'hcube_extramarg', label:'No Content',				value:'1', 	checked: acchead,			onChange: function( val ) { props.setAttributes({ acchead:val })}}) : null,
							)
						) : null,	
						func === 'media' ? ce( 'div', { className: 'hcube_indentedControls' }, ce( cp.TextControl, 	{ label: 'ID', 			value: mediaid,					onChange: function( val ) { props.setAttributes({ mediaid: val 	})}}) ) : null,
						func === 'modal' ? ce( 'div', { className: 'hcube_indentedControls' }, ce( cp.TextControl, 	{ label: 'ID', 			value: modalid,					onChange: function( val ) { props.setAttributes({ modalid: val 	})}}) ) : null,
					),
					ce( cp.PanelBody, { title: 'Schema', initialOpen: func !== 'none' },	
						ce( cp.ToggleControl, 	{ className: 'hcube_extramarg', label:'Is a FAQ',		value:'1', 	checked: faqmode,			onChange: function( val ) { props.setAttributes({ faqmode:val		})}}),
					),		
					
					func === 'none' ? 
						ce( cp.PanelBody, { title: 'Animation', initialOpen: false },
							ce( cp.ToggleControl, { label:'Enable',	value:'1', 	checked: (animate=='none'?false:true),	onChange: function(val){ props.setAttributes({ animate: (val?'left':'none') }) }}),
							
							animate !== 'none' ? 
							
								ce( 'div', {},
									ce( cp.SelectControl, 	{label: 'Style', value: animtype, options: [
										{ label: 'Fade In', value: 'dir' }, 
										{ label: 'Fly In', value: 'fly' }
									], onChange: function( val ) { props.setAttributes( { animtype: val } )}} ),	
								
									ce( cp.ButtonGroup, {},
										ce( cp.Button, {value:'1',		isDefault:( animate=='top'?false:true),				isPrimary:( animate=='top'?true:false),				onClick: function( val ) { props.setAttributes( { animate: 'top' } )}}, 'Top' ),
										ce( cp.Button, {value:'1',		isDefault:( animate=='bottom'?false:true),			isPrimary:( animate=='bottom'?true:false),			onClick: function( val ) { props.setAttributes( { animate: 'bottom' } )}}, 'Bottom' ),
										ce( cp.Button, {value:'1',		isDefault:( animate=='left'?false:true),			isPrimary:( animate=='left'?true:false),			onClick: function( val ) { props.setAttributes( { animate: 'left' } )}}, 'Left' ),
										ce( cp.Button, {value:'1',		isDefault:( animate=='right'?false:true),			isPrimary:( animate=='right'?true:false),			onClick: function( val ) { props.setAttributes( { animate: 'right' } )}}, 'Right' ),
									),
									
									ce( cp.TextControl, {label: 'Duration in Milliseconds',value: duration,onChange: function( val ) {props.setAttributes( { duration: val } );}})
								
								)
							: null,
							
						) 
					: null,
					
					
				) : null
			); 
		};
	})
) 


			
wp.hooks.addFilter('editor.BlockListBlock', 'hcube/filtereditor-group',
	wp.compose.createHigherOrderComponent( function( BlockListBlock ) {
		return props => {
			const { block, attributes } = props;
			const { func, section, uniqueurl, uniqueurl_ifstatement,accordion, ed_minimize, opacity, backgroundColor, customBackgroundColor, maxdisplaywidth, maxdisplay, minvison, minvis, maxvison, maxvis } = attributes;

			if ( block.name === 'core/group' ) {
				
				props = lodash.assign( props, { className: 
					( ed_minimize ? " hcube-block-group-minimized " : " " ) +
					( maxvison ? " hcube_maxvis " : " " ) + 
					( uniqueurl ? " hcube_ifstate " : " " ) + 
					( minvison ? " hcube_minvis " : " " ) 
				} );
				
				var rawhtml = '<style>';
				
				if( backgroundColor || customBackgroundColor )				rawhtml +=	'[data-block="'+props.clientId+'"] > div					{ background:'+( backgroundColor ? ( findObjectByKey(hcubecolors, 0, backgroundColor) ? findObjectByKey(hcubecolors, 0, backgroundColor).color : '' ) : customBackgroundColor ) + (opacity.toString(16))+' !important; }';
				if( maxvison )												rawhtml +=	'#block-'+props.clientId+'.hcube_maxvis:after								{ content:"Max: '+maxvis+'"; }';
				if( minvison )												rawhtml +=	'#block-'+props.clientId+'.hcube_minvis:before								{ content:"Min: '+minvis+'"; }';
				if( uniqueurl )												rawhtml +=	'#block-'+props.clientId+'.hcube_ifstate:after								{ content:"'+uniqueurl_ifstatement+'"; }';
				
				rawhtml += '</style>';
				
				return ce( 'div' , null, ce( BlockListBlock, props ), ce( el.RawHTML , null, rawhtml ) );
			}

			return ce( BlockListBlock, props );
		}
			
	})
)


wp.hooks.addFilter('blocks.getSaveContent.extraProps','hcube/filterprops-group',( props, element, attributes ) => {
	 
	if( element.name === 'core/group' ) { 
	
		const { template_mode, template_height, template_def, template_def_spe, expanded, section, vertical, inline, hiddeng, maxdisplay, maxdisplayside, maxdisplaywidth, counttarget, carheight, carwidth, cardelay, unique, sticky, func, href, modalid, animate, animtype, duration, opacity, backgroundColor, customBackgroundColor } = attributes;
		
		props = lodash.assign( props, { 'data-unique-id': unique } );
		
		var template_url;
		if( template_mode == 'gps' ) template_url = 'https://'+window.location.hostname+'/wp-json/hcube/v1/hcube_addressfilter?default='+template_def+'&specify='+template_def_spe;
		if( template_mode == 'first' ) template_url = 'https://'+window.location.hostname+'/wp-json/hcube/v1/hcube_firstvisit';
		
		if( hiddeng ) 										props = lodash.assign( props, { 'hidden': 'true' } );
		if( modalid != '' && func === 'modal' ) 			props = lodash.assign( props, { id: 'modal-' + modalid, layout: "nodisplay", scrollable: "true", on: "tap:modal-"+modalid+".close" } );
		if( counttarget != '' && func === 'countdown' ) 	props = lodash.assign( props, { 'end-date': counttarget, 'layout': 'fill' } );
		if( func === 'template' ) 							props = lodash.assign( props, { 'width': 'auto', 'height': template_height+'px', 'layout': 'fixed-height', 'credentials':"include", 'src': template_url } );
		if( func === 'carousel' ) 							props = lodash.assign( props, { 'type': 'slides', 'loop': '', autoplay: '', 'delay': cardelay, 'height': carheight, 'width': carwidth } );
		if( href != '' && func === 'none' ) 				props = lodash.assign( props, { href: href } );	
		if( animate != 'none' && func === 'none' )			props = lodash.assign( props, { 'amp-fx': ( animtype === 'dir' ? "fade-in " : "" ) + "fly-in-" + animate, 'data-duration': duration + 'ms' } );	
		if( expanded && section && func === 'accordion' )	props = lodash.assign( props, { 'data-expanded': 'true' } );
			
		if( inline ) 							props.style = lodash.assign( props.style, { 'display': 'inline' } );	
		if( func === 'carousel' ) 							props.style = lodash.assign( props.style, { 'max-width': '100%' } );	
		if( backgroundColor || customBackgroundColor ) 		props.style = lodash.assign( props.style, { 'background-color': (( backgroundColor ? ( hcubecolors[parseInt(backgroundColor.split('slug_')[1])-1] ? hcubecolors[parseInt(backgroundColor.split('slug_')[1])-1].color : '' ) : customBackgroundColor) +  opacity.toString(16) ) } );	
		if( sticky != 'relative' )				 			props.style = lodash.assign( props.style, { 'position': sticky, 'left': '0', 'right': '0', 'top': '0', 'z-index': '2' } );	
		if( sticky != 'relative' && vertical == 'bottom' )	props.style = lodash.assign( props.style, { 'top': 'auto', 'bottom': '0' } );	
		if( sticky != 'relative' && vertical == 'top' )	 	props.style = lodash.assign( props.style, { 'bottom': 'auto', 'top': '0' } );	
		if( maxdisplay )									props.style = lodash.assign( props.style, { 'max-width': maxdisplaywidth+'px' } );
		if( maxdisplay && maxdisplayside=='margin-left' )	props.style = lodash.assign( props.style, { 'margin-left': '0' } );
		if( maxdisplay && maxdisplayside=='margin-right' )	props.style = lodash.assign( props.style, { 'margin-right': '0' } );	 
		
	}
	
	return props;
})


wp.hooks.addFilter('blocks.getSaveElement','hcube/filteroutput-group', ( element, blockType, attributes  ) => {
	
    if ( blockType.name === 'core/group' ) {	
	
		const { acchead, unique, overflow, func, href, full, height, fullcontent, counttarget,
			faqmode, person, gen_person, person_byid, person_isauthor, author_id, person_name, person_description, person_gender, person_birthdate, person_jobtitle, person_email, person_telephone, person_image, person_sameas,
			mediaid, modalid, center, centeron, accordion, section, animate, duration, animtype,
			margintop, marginleft, marginright, marginbottom, uniqueurl, uniqueurl_ifstatement,
			maxdisplay, maxdisplaysnap, paddingtop, paddingleft, paddingright, paddingbottom,
			maxvison, minvison, maxvis, minvis					} = attributes;
		
 
		var rawhtml = '';
		if( func === 'none' ){
			rawhtml = '<style>';

			if( full ) 			rawhtml += '	div.hcube-content [data-unique-id="' + unique + '"]												{width:100%;max-width:100%;}' ;
			if( fullcontent ) 	rawhtml += '	div.hcube-content [data-unique-id="' + unique + '"] > div										{max-width: 100%;}' ;
			if( height ) 		rawhtml += '	div.hcube-content [data-unique-id="' + unique + '"]												{height:100vh;min-height: 600px;}' ;
			if( overflow ) 		rawhtml += '	div.hcube-content [data-unique-id="' + unique + '"]												{overflow:visible;}' ;
				
			if( centeron ) 		rawhtml += '	@media (max-width:' + center + 'px){' +
												'div.hcube-content [data-unique-id="' + unique + '"],[data-unique-id="' + unique + '"] *	{text-align:center !important;}' +
												'div.hcube-content [data-unique-id="' + unique + '"] .wp-block-button						{margin: 0px 10px 20px 10px;float: none;display: inline-block;}' +
												'div.hcube-content [data-unique-id="' + unique + '"] .wp-block-button.aligncenter			{margin-left: 0px ;margin-right: 0px ;}' +
											'}' ;
														
			if( maxdisplay ) 	rawhtml += '	@media (max-width:' + (maxdisplaysnap) + 'px){' +
												'div.hcube-content [data-unique-id="' + unique + '"]:not(#_):not(#_):not(#_):not(#_):not(#_)	{max-width:100% !important;}' +
											'}' ;
											
			if( maxvison ) 		rawhtml += '	@media (min-width:' + (maxvis+1) + 'px){' +
												'div.hcube-content [data-unique-id="' + unique + '"]										{display:none;}' +
											'}' ;
														
			if( minvison ) 		rawhtml += '	@media (max-width:' + (minvis-1) + 'px){' +
												'div.hcube-content [data-unique-id="' + unique + '"]										{display:none;}' +
											'}' ;
														
			
								rawhtml += 'div.hcube-content [data-unique-id="' + unique + '"] {' +
												'margin-top:' + margintop + ';' +
												'margin-left:' + marginleft + ';' +
												'margin-right:' + marginright + ';' +
												'margin-bottom:' + marginbottom + ';' +
												'padding-top:' + paddingtop + ';' +
												'padding-left:' + paddingleft + ';' +
												'padding-right:' + paddingright + ';' + 
												'padding-bottom:' + paddingbottom + ';' +
											'}' ;
				 
			rawhtml += '</style>';
		
		
		}
	
	
		var ele = ce( 'div' , element.props , element.props.children, ce( el.RawHTML, null, rawhtml ) );
		if( href != '' && func === 'none' ) 	ele = ce( 'a' , 				element.props, 	element.props.children, 					ce( el.RawHTML, null, rawhtml ) );
		if( modalid!='' && func === 'modal' ) 	ele = ce( 'amp-lightbox', 		element.props, 	element.props.children, 					ce( el.RawHTML, null, rawhtml ) );
		if( func === 'carousel' ) 				ele = ce( 'amp-carousel' , 		element.props, 	element.props.children.props.children, 		ce( el.RawHTML, null, rawhtml ) );
		if( section && func === 'accordion' ) 	ele = ce( 'section', 			element.props, 	element.props.children.props.children, 		ce( el.RawHTML, null, rawhtml ) );
		if( func === 'countdown' ) 				ele = ce( 'amp-date-countdown', element.props, 	ce( 'template', { 'type': 'amp-mustache' }, element.props.children.props.children, ce( el.RawHTML, null, rawhtml ) ) );
		if( accordion && func === 'accordion' ) ele = ce( 'div', 				element.props, 	ce( 'amp-accordion', { className: 'wp-block-group__inner-container', 'expand-single-section':'', 'animate':'' }, element.props.children.props.children, ce( el.RawHTML, null, rawhtml ) ) );	
		if( acchead && section && func === 'accordion' ) 	ele = ce( 'section', element.props, 	element.props.children.props.children, 	ce( 'div', null ),	ce( el.RawHTML, null, rawhtml ) );
		if( func === 'template' ) 				ele = ce( 'amp-list', 			element.props, 	ce( 'template', { 'type': 'amp-mustache' }, element.props.children.props.children, ce( el.RawHTML, null, rawhtml ) ) );
		if( uniqueurl && !section ) 						ele = ce( 'div', 				element.props, 	ce( el.RawHTML, null, '<f?php if( '+uniqueurl_ifstatement+' ){ ?f>'), element.props.children, 					ce( el.RawHTML, null, rawhtml ),ce( el.RawHTML, null, '<f?php } ?f>')  );

		return ele;
		
	}

	return element;
})

