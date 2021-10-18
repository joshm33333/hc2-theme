
var 
el = wp.element,
ce = el.createElement,
ed = wp.editor,
bd = wp.blockEditor,
cp = wp.components;
 

wp.hooks.addFilter( 'blocks.registerBlockType', 'hcube/setcore-html',( settings,name ) => {
	  
    if ( name === 'core/html' && typeof settings.attributes !== 'undefined' ){
		settings.attributes = Object.assign( settings.attributes, {
			minimize:{ 					type: 'boolean', 	default: false, },
			maximize:{ 					type: 'boolean', 	default: false, },
			notice:{ 					type: 'string', 	default: '', },
			wide:{ 						type: 'number', 	default: 10, },
			color:{ 					type: 'string', 	default: '', },
		}); 
	}

	return settings;
})

wp.hooks.addFilter( 'editor.BlockEdit', 'hcube/editcore-html',  
	wp.compose.createHigherOrderComponent( function( BlockEdit ) {

		return function( props ) {
			
			const { name, attributes } = props;
			const { minimize, maximize, notice, wide, color } = attributes;
			
			return ce( el.Fragment, {}, 
				ce( BlockEdit, props ),
				name === 'core/html' ? ce( bd.InspectorControls, {},
					ce( cp.PanelBody, { className : 'hc2_code_panel', title: 'Settings', initialOpen: true }, 
					
						ce( cp.ToggleControl, { label:'Minimize', 				value:'1', 	checked: minimize,			onChange: function(val){ props.setAttributes({ minimize:val }) }}),
						ce( cp.ToggleControl, { label:'Full Height', 				value:'1', 	checked: maximize,			onChange: function(val){ props.setAttributes({ maximize:val }) }}),
						ce( cp.ButtonGroup, {},
							ce( cp.Button, {value:'1',		isDefault:( notice=='CSS'?false:true),				isPrimary:( notice=='CSS'?true:false),				onClick: function( val ) { props.setAttributes( { notice: 'CSS' } )}}, 'CSS' ),
							ce( cp.Button, {value:'1',		isDefault:( notice=='JavaScript'?false:true),		isPrimary:( notice=='JavaScript'?true:false),		onClick: function( val ) { props.setAttributes( { notice: 'JavaScript' } )}}, 'JavaScript' ),
							ce( cp.Button, {value:'1',		isDefault:( notice=='HTML'?false:true),				isPrimary:( notice=='HTML'?true:false),				onClick: function( val ) { props.setAttributes( { notice: 'HTML' } )}}, 'HTML' ),
							ce( cp.Button, {value:'1',		isDefault:( notice=='PHP'?false:true),				isPrimary:( notice=='PHP'?true:false),				onClick: function( val ) { props.setAttributes( { notice: 'PHP' } )}}, 'PHP' ),
						),
					),
					
				) : null
			);
		};
	})
) 

wp.hooks.addFilter('editor.BlockListBlock', 'hcube/filtereditor-html',
	wp.compose.createHigherOrderComponent( function( BlockListBlock ) {
		return props => {
			const { block, attributes } = props;
			const { minimize, maximize, notice, wide, color } = attributes;

			if ( block.name === 'core/html' ) {
				
				props = lodash.assign( props, { className: 
					( minimize ? " hc2-html-minimize " : " " ) + 
					( maximize ? " hc2-html-maximize " : " " ) + 
					( notice ? " hc2-html-notice-"+notice+" " : " " )
					
				} );
				
			}

			return ce( BlockListBlock, props );
		}
			
	})
)