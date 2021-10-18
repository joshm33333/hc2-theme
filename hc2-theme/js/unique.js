var 
el = wp.element,
ce = el.createElement,
bd = wp.blockEditor;
 
wp.hooks.addFilter( 'blocks.registerBlockType', 'hcube/setcore-unique',( settings,name ) => {
	  
    if ( name.indexOf('core/')>-1 && typeof settings.attributes !== 'undefined' ){
		settings.attributes = Object.assign( settings.attributes, {
			unique:{ 		type: 'string', 	default: ''},
		})
	}

	return settings;
})	
	
wp.hooks.addFilter( 'editor.BlockEdit', 'hcube/editcore-unique', 
	wp.compose.createHigherOrderComponent( function( BlockEdit ) {

		return function( props ) {
			
		
			const { name, attributes } = props;
			attributes.unique = Math.random().toString(36).substr(2, 9);
			
			return ce( el.Fragment, {},
				ce( BlockEdit, props ),
				ce( bd.InspectorControls, {},null
				) 
			);
		};
	})
)

wp.hooks.addFilter('blocks.getSaveElement','slug/modify-get-save-content-extra-props',( element, blockType, attributes  ) => {

	return element;
})
