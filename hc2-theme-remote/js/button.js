var 
el = wp.element,
ce = el.createElement,
ed = wp.editor,
bd = wp.blockEditor,
cp = wp.components;
 

wp.hooks.addFilter( 'blocks.registerBlockType', 'hcube/setcore-button',( settings,name ) => {
	  
    if ( name === 'core/button' && typeof settings.attributes !== 'undefined' ){
		settings.attributes = Object.assign( settings.attributes, {
			fullwidth:{ 				type: 'boolean', 	default: false, },
			func:{ 						type: 'string', 	default: '', },
			modalid:{ 					type: 'string', 	default: '', },
			modaloff:{ 					type: 'boolean', 	default: false, },
			targetanchor:{ 				type: 'string', 	default: 'hcube_top', }
		}); 
	}

	return settings;
})

wp.hooks.addFilter('editor.BlockListBlock', 'hcube/filtereditor-button',
	wp.compose.createHigherOrderComponent( function( BlockListBlock ) {
		return props => {
			const { block, attributes } = props;
			const { fullwidth } = attributes;

			if ( block.name === 'core/button' ) {
				
				props = lodash.assign( props, { className: 
					( fullwidth ? " hc2-button-fullwidth " : " " )
				} );
				
			}

			return ce( BlockListBlock, props );
		}
			
	})
)

wp.hooks.addFilter( 'editor.BlockEdit', 'hcube/editcore-button',  
	wp.compose.createHigherOrderComponent( function( BlockEdit ) {

		return function( props ) {
			
			const { name, attributes } = props;
			const { fullwidth, func, modalid, modaloff, targetanchor } = attributes;
			
			return ce( el.Fragment, {}, 
				ce( BlockEdit, props ),
				name === 'core/button' ? ce( bd.InspectorControls, {},
					ce( cp.PanelBody, { title: 'More Settings', initialOpen: true },
						ce( cp.ToggleControl, { label:'Full Width', 				value:'1', 	checked: fullwidth,			onChange: function(val){ props.setAttributes({ fullwidth:val }) }}),
						
						
						ce( cp.SelectControl, 	{label: 'Function', value: func, options: [
								{ label: 'Default', value: '' },
								{ label: 'Lightbox', value: 'modal' },
								{ label: 'Smooth Scroll', value: 'scroll' }
							], onChange: function( val ) { props.setAttributes( { func: val } )}} ),	
						
							func == 'scroll' ? ce( 'div', { className: 'hcube_indentedControls' },
								ce( cp.TextControl, {label: 'Target Anchor',value: targetanchor,onChange: function( val ) {props.setAttributes( { targetanchor: val } );}}),
							): null,
							
							func == 'modal' ? ce( 'div', { className: 'hcube_indentedControls' },
								ce( cp.TextControl, {label: 'Lightbox ID', 					value: modalid,							onChange: function( val ) { props.setAttributes( { modalid: val } )}} ),
								ce( cp.ToggleControl, { label:'Lightbox Close Button', 		value:'1', 	checked: modaloff,			onChange: function(val){ props.setAttributes({ modaloff:val }) }})
							): null,
					),
					
				) : null
			);
		};
	})
) 


wp.hooks.addFilter('blocks.getSaveContent.extraProps','hcube/filterprops-button',( props, element, attributes ) => {
	if(element.name === 'core/button') {
		
		const { fullwidth, func, modalid, modaloff, targetanchor, text } = attributes;
		
		props = lodash.assign( props, { 
			'data-vars-name'	: 'Button - ' + text  ,
			'data-full-width' : fullwidth ? 'true' : 'false' 
		} );
		
		if( func == 'modal' ) props = lodash.assign( props, {  
				'data-vars-name'	: (modaloff?'Close':'Open')+' Modal - ' + modalid ,
				'on' 				: 'tap:modal-'+modalid+(modaloff?'.close':'') ,
				'role' 				: 'button',
				'tabindex' 			: '0'
			} );	
			
		if( func == 'scroll' ) props = lodash.assign( props, {  
				'data-vars-name'	: 'Scroll To ' + targetanchor ,
				'on' 				: 'tap:' + targetanchor + '.scrollTo(duration=500)',
				'role' 				: 'button',
				'tabindex' 			: '0'
			} );
		
	}
	
	return props;
})



