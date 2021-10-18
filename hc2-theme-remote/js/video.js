var 
el = wp.element,
ce = el.createElement,
ed = wp.editor,
bd = wp.blockEditor,
cp = wp.components;
 
wp.hooks.addFilter( 'blocks.registerBlockType', 'hcube/setcore-video',( settings,name ) => {
	
    if ( name === 'core/video' && typeof settings.attributes !== 'undefined' ){
		settings.attributes = Object.assign( settings.attributes, {
			full:{ 		type: 'boolean', 	default: false, },
			behind:{ 	type: 'boolean', 	default: false, },
			vpheight:{ 	type: 'string', 	default: 'default', }
		});
	}

	return settings;
})

wp.hooks.addFilter( 'editor.BlockEdit', 'hcube/editcore-video', 
	wp.compose.createHigherOrderComponent( function( BlockEdit ) {

		return function( props ) {
			
			const { name, attributes } = props;
			
			return ce( el.Fragment, {},
				ce( BlockEdit, props ),   
				name === 'core/video' ? ce( bd.InspectorControls, {},
					ce( cp.PanelBody, { title: 'More Settings', initialOpen: true },
						ce( cp.ToggleControl, { label:'Full Width', 		value:'1', 	checked:props.attributes.full,		onChange: function(val){ props.setAttributes({full:val}) }}),
						ce( cp.ToggleControl, { label:'Behind Content',		value:'1', 	checked:props.attributes.behind,	onChange: function(val){ props.setAttributes({behind:val}) }}),
						
							'Height',
						ce( cp.ButtonGroup, {},
							ce( cp.Button, {value:'1',		isDefault:( props.attributes.vpheight=='default'?false:true),			isPrimary:( props.attributes.vpheight=='default'?true:false),			onClick: function( val ) { props.setAttributes( { vpheight: 'default' } )}}, 'Default' ),
							ce( cp.Button, {value:'1',		isDefault:( props.attributes.vpheight=='parent'?false:true),			isPrimary:( props.attributes.vpheight=='parent'?true:false),			onClick: function( val ) { props.setAttributes( { vpheight: 'parent' } )}}, 'Container' ),
							ce( cp.Button, {value:'1',		isDefault:( props.attributes.vpheight=='screen'?false:true),			isPrimary:( props.attributes.vpheight=='screen'?true:false),			onClick: function( val ) { props.setAttributes( { vpheight: 'screen' } )}}, 'Screen' ),
						)
					)
				) : null
			);
		};
	})
)


wp.hooks.addFilter('blocks.getSaveContent.extraProps','hcube/filterprops-video',( props, element, attributes ) => {
	if(element.name === 'core/video') {
		
		props = lodash.assign( props, { 
			'data-full-width': 				( typeof attributes.full !== 'undefined' 			&& attributes.full ? 			'true' : 'false' ),
			'data-position-absolute': 		( typeof attributes.behind !== 'undefined' 			&& attributes.behind ? 			'true' : 'false' ),
			'data-fixed-height': 			( attributes.vpheight === 'screen' 					&& attributes.vpheight ? 			'true' : 'false' ),
			'data-parent-height': 			( attributes.vpheight === 'parent' 					&& attributes.vpheight ? 			'true' : 'false' )
		} );	
		
	}
	
	return props;
})