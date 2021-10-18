var 
el = wp.element,
ce = el.createElement,
ed = wp.editor,
bd = wp.blockEditor,
cp = wp.components;
 
wp.hooks.addFilter( 'blocks.registerBlockType', 'hcube/setcore-paragraph',( settings,name ) => {
	  
    if ( name === 'core/paragraph' && typeof settings.attributes !== 'undefined' ){
		settings.attributes = Object.assign( settings.attributes, {
			margintop:{ 		type: 'string', 	default: '', },
			marginleft:{ 		type: 'string', 	default: '', },
			marginright:{ 		type: 'string', 	default: '', },
			marginbottom:{ 		type: 'string', 	default: '', },
		}); 
	}

	return settings;
})

wp.hooks.addFilter( 'editor.BlockEdit', 'hcube/editcore-paragraph',  
	wp.compose.createHigherOrderComponent( function( BlockEdit ) {

		return function( props ) {
			
			const { name, attributes } = props;
			const { margintop, marginleft, marginright, marginbottom } = attributes; 
			
			return ce( el.Fragment, {}, 
				ce( BlockEdit, props ),
				name === 'core/paragraph' ? ce( bd.InspectorControls, {},
					ce( cp.PanelBody, { title: 'Margin', initialOpen: false },
						ce( 'div', { className: 'hcube_marginbox' },
							ce( cp.TextControl,{ label: 'Left',value: marginleft,onChange: function( val ) {props.setAttributes( { marginleft: val } );}}),
							ce( cp.TextControl,{ label: 'Right',value: marginright,onChange: function( val ) {props.setAttributes( { marginright: val } );}}),
							ce( cp.TextControl,{ label: 'Top',value: margintop,onChange: function( val ) {props.setAttributes( { margintop: val } );}}),
							ce( cp.TextControl,{ label: 'Bottom',value: marginbottom,onChange: function( val ) {props.setAttributes( { marginbottom: val } );}}),
						),
					)
					
				) : null
			);
		};
	})
) 

wp.hooks.addFilter('blocks.getSaveContent.extraProps','hcube/filterprops-paragraph',( props, element, attributes ) => {
	if( element.name === 'core/paragraph' ) {
		
		props.style = lodash.assign( props.style, {
			marginTop :		attributes.margintop,
			marginLeft :	attributes.marginleft,
			marginRight :	attributes.marginright,
			marginBottom :	attributes.marginbottom
		} );	
		
	}
	
	return props;
})
	