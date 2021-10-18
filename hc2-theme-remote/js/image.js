var 
el = wp.element,
ce = el.createElement,
ed = wp.editor,
bd = wp.blockEditor,
cp = wp.components;
 
wp.hooks.addFilter( 'blocks.registerBlockType', 'hcube/setcore-image',( settings,name ) => {
	
    if ( name === 'core/image' && typeof settings.attributes !== 'undefined' ){
		settings.attributes = Object.assign( settings.attributes, {
			nolb:{ 				type: 'boolean', 	default: false, },
			full:{ 				type: 'boolean', 	default: false, },
			behind:{ 			type: 'boolean', 	default: false, },
			vpheight:{ 			type: 'string', 	default: 'default', },
			parallaxon:{ 		type: 'boolean', 	default: false, },
			parallaxspeed:{ 	type: 'number', 	default: 75, },
			mobileoff:{ 		type: 'boolean', 	default: false, },
			modal:{ 			type: 'boolean', 	default: false, },
			offset:{ 			type: 'boolean', 	default: true, },
			modalid:{ 			type: 'string', 	default: '', },
			trackertext:{ 		type: 'string', 	default: 'No Tracking', },
			
			ed_minimize:{ 		type: 'boolean', 	default: false, }
		});
	}

	return settings;
})

wp.hooks.addFilter( 'editor.BlockEdit', 'hcube/editcore-image', 
	wp.compose.createHigherOrderComponent( function( BlockEdit ) {
			
		return function( props ) {
			
			const { name, attributes } = props;
			const { nolb, ed_minimize, mobileoff, full, behind, vpheight, parallaxon, parallaxspeed, modal, modalid, offset, trackertext } = attributes;
			
			return ce( el.Fragment, {},
				ce( BlockEdit, props ),   
				name === 'core/image' ? ce( bd.InspectorControls, {},
					ce( cp.PanelBody, { title: 'Editor Settings', initialOpen: true },	
						ce( cp.ToggleControl, { label:'Minimize in Editior', 			value:'1', 	checked: ed_minimize,			onChange: function(val){ props.setAttributes({ ed_minimize:val }) }}),
					),
					ce( cp.PanelBody, { title: 'More Settings', initialOpen: true },	
						ce( cp.ToggleControl, { label:'Full Width', 				value:'1', 	checked: full,			onChange: function(val){ props.setAttributes({ full:val }) }}),
						ce( cp.ToggleControl, { label:'Behind Content',				value:'1', 	checked: behind,		onChange: function(val){ props.setAttributes({ behind:val }) }}),
						!behind?ce( cp.ToggleControl, { label:'Disable Lightbox Effect', 	value:'1', 	checked: nolb,			onChange: function(val){ props.setAttributes({ nolb:val }) }}):null,
						ce( cp.ToggleControl, { label:"Don't Center on Mobile", 	value:'1', 	checked: mobileoff,		onChange: function(val){ props.setAttributes({ mobileoff:val }) }}),
						ce( cp.ToggleControl, { label:'Is Lightbox Button',			value:'1', 	checked: modal,			onChange: function(val){ props.setAttributes({ modal:val }) }}),
						modal ? ce( 'div', {},
							ce( cp.TextControl, {label: 'Lightbox ID', 		value: modalid,									onChange: function( val ) { props.setAttributes( { modalid: val } )}} ),
						): null,
						
							'Height',
						ce( cp.ButtonGroup, {},
							ce( cp.Button, {value:'1',		isDefault:( vpheight=='default'?false:true),			isPrimary:( vpheight=='default'?true:false),			onClick: function( val ) { props.setAttributes( { vpheight: 'default' } )}}, 'Default' ),
							ce( cp.Button, {value:'1',		isDefault:( vpheight=='parent'?false:true),			isPrimary:( vpheight=='parent'?true:false),			onClick: function( val ) { props.setAttributes( { vpheight: 'parent' } )}}, 'Container' ),
							ce( cp.Button, {value:'1',		isDefault:( vpheight=='screen'?false:true),			isPrimary:( vpheight=='screen'?true:false),			onClick: function( val ) { props.setAttributes( { vpheight: 'screen' } )}}, 'Screen' ),
						),
						ce( el.RawHTML, null, '<br>' ),
						vpheight != 'default' ? ce( cp.ToggleControl, { label:'Parallax',				value:'1', 	checked:parallaxon,							onChange: function(val){ props.setAttributes({ parallaxon:val })}}) : null,
						parallaxon && vpheight != 'default' ? ce( 'div', { className: 'hcube_indentedControls' },
							ce( cp.RangeControl, { label:'Parallax Speed',			value:parallaxspeed,initialPosition:75,min:50,max:100,		onChange: function( val ) { props.setAttributes({ parallaxspeed:val })}}),
							ce( cp.ToggleControl, { label:'Offset Image', 			value:'1', 	checked: offset,			onChange: function(val){ props.setAttributes({ offset:val }) }}),
						) : null,
					)
				) : null
			);
		};
	})
) 


wp.hooks.addFilter('editor.BlockListBlock', 'hcube/filtereditor-image',
	wp.compose.createHigherOrderComponent( function( BlockListBlock ) {
		return props => {
			const { block, attributes } = props;
			const { ed_minimize } = attributes;

			if ( block.name === 'core/image' ) {
				if( ed_minimize ) props = lodash.assign( props, { className: "hcube-block-image-minimized" } );
			}

			return ce( BlockListBlock, props );
		}
			
	})
)


wp.hooks.addFilter('blocks.getSaveContent.extraProps','hcube/filterprops-image',( props, element, attributes ) => {
	if(element.name === 'core/image') {
		
		const { nolb, mobileoff, parallaxon, parallaxspeed, full, behind, vpheight, modal, modalid, offset, trackertext } = attributes;
		
		if( attributes.parallaxon ) { 
			props = lodash.assign( props, { 
				'amp-fx': 'parallax', 
				'data-parallax-factor': parallaxspeed / 100 
			} );	
			if( offset ) props.style = lodash.assign( props.style, { 
				'height': 'calc( 100% + ' + ( 100 - parallaxspeed  ) + 'vh )' ,
				'margin-top': ( ( 100 - parallaxspeed ) * -1 ) + 'vh' 
			} );
		}
			
		 
		if( attributes.mobileoff ) props = lodash.assign( props, { 
			'data-mobileoff': 'true'
		} );	
		
		if( modal ){
			props = lodash.assign( props, {  
				'data-vars-name'	: 'Open Modal - '+modalid ,
				'on' 				: 'tap:modal-'+modalid ,
				'role' 				: 'button',
				'tabindex' 			: '0'
			} );	
		}else{
			props = lodash.assign( props, { 
				'data-vars-name'	: 'Image - ' + trackertext   
			} );
		}
		
		if( nolb || behind ) props = lodash.assign( props, {  
			'data-amp-auto-lightbox-disable'	: '' ,
		} );	
			
		props = lodash.assign( props, { 
			'data-full-width': 				( typeof full !== 'undefined' 			&& full ? 			'true' : 'false' ),
			'data-position-absolute': 		( typeof behind !== 'undefined' 		&& behind ? 		'true' : 'false' ),
			'data-fixed-height': 			( vpheight === 'screen' 				&& vpheight ? 		'true' : 'false' ),
			'data-parent-height': 			( vpheight === 'parent' 				&& vpheight ? 		'true' : 'false' )
		} );	
		
		
	}
	
	return props;
})