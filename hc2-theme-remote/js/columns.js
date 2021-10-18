var 
el = wp.element,
ce = el.createElement,
ed = wp.editor,
bd = wp.blockEditor,
cp = wp.components;
 
wp.hooks.addFilter( 'blocks.registerBlockType', 'hcube/setcore-columns',( settings,name ) => {
	  
    if ( name === 'core/columns' && typeof settings.attributes !== 'undefined' ){
		settings.attributes = Object.assign( settings.attributes, {
			unique:{ 		type: 'string', 	default: ''},
			onecol:{ 		type: 'number', 	default: 599},
			colorda:{		type: 'number', 	default: 1, },
			colordb:{		type: 'number', 	default: 2, },
			colordc:{		type: 'number', 	default: 3, },
			colordd:{		type: 'number', 	default: 4, },
			colorde:{		type: 'number', 	default: 5, },
			colordf:{		type: 'number', 	default: 6, },
		}); 
	}

	return settings;
})

wp.hooks.addFilter( 'editor.BlockEdit', 'hcube/editcore-columns', 
	wp.compose.createHigherOrderComponent( function( BlockEdit ) {
	
		return function( props ) {
			
			const { name, attributes } = props;
			const { columns, onecol, colorda, colordb, colordc, colordd, colorde, colordf } = attributes;
			
			return ce( el.Fragment, {},
				ce( BlockEdit, props ),
				name === 'core/columns' ? ce( bd.InspectorControls, {},
					ce( cp.PanelBody, { title: 'Mobile Settings', initialOpen: false },
						ce( cp.RangeControl, {label: 'Collapase Width',value: onecol,initialPosition:599,min:0,max:2000,onChange:function(val){props.setAttributes({onecol:val})}}),
						ce( 'div', { className: 'hcube_customsixval' },
							ce( 'label', { className: 'hcube_customreorder components-base-control__label' }, 'Mobile Order' ),
							ce( cp.RangeControl,{label: 'Col 1',value: colorda,initialPosition:1,min:1,max:6,onChange:function(val){props.setAttributes({colorda:val})}}),
							ce( cp.RangeControl,{label: 'Col 2',value: colordb,initialPosition:2,min:1,max:6,onChange:function(val){props.setAttributes({colordb:val})}}),
							ce( cp.RangeControl,{label: 'Col 3',value: colordc,initialPosition:3,min:1,max:6,onChange:function(val){props.setAttributes({colordc:val})}}),
							ce( cp.RangeControl,{label: 'Col 4',value: colordd,initialPosition:4,min:1,max:6,onChange:function(val){props.setAttributes({colordd:val})}}),
							ce( cp.RangeControl,{label: 'Col 5',value: colorde,initialPosition:5,min:1,max:6,onChange:function(val){props.setAttributes({colorde:val})}}),
							ce( cp.RangeControl,{label: 'Col 6',value: colordf,initialPosition:6,min:1,max:6,onChange:function(val){props.setAttributes({colordf:val})}}),
						)
					)
		
				) : null
			);
		};
	})
)
			


wp.hooks.addFilter('blocks.getSaveContent.extraProps','hcube/filterprops-columns',( props, element, attributes ) => {
	if(element.name === 'core/columns') {
		
		const { unique } = attributes;
		
		props = lodash.assign( props, { 'data-unique-id' : unique } );	
		
	}
	
	return props;
})

 

wp.hooks.addFilter('blocks.getSaveElement','hcube/filteroutput-columns',( element, blockType, attributes  ) => {
	
		const { unique, colorda, colordb, colordc, colordd, colorde, colordf } = attributes;
		
    if ( blockType.name === 'core/columns' ) {
		return ce( element.type, element.props , 
			element.props.children,
			ce( 'style', {}, 
				'@media (max-width:'+attributes.onecol+'px){' +
					'[data-unique-id="'+attributes.unique+'"]{flex-wrap:wrap;}' +
					'[data-unique-id="'+attributes.unique+'"] > div{flex-basis:100% !important;max-width:100% !important;margin-left:0px !important; }' +
					'[data-unique-id="'+attributes.unique+'"] > div:nth-child(1) {order: ' + colorda + ';}' +
					'[data-unique-id="'+attributes.unique+'"] > div:nth-child(2) {order: ' + colordb + ';}' +
					'[data-unique-id="'+attributes.unique+'"] > div:nth-child(3) {order: ' + colordc + ';}' +
					'[data-unique-id="'+attributes.unique+'"] > div:nth-child(4) {order: ' + colordd + ';}' +
					'[data-unique-id="'+attributes.unique+'"] > div:nth-child(5) {order: ' + colorde + ';}' +
					'[data-unique-id="'+attributes.unique+'"] > div:nth-child(6) {order: ' + colordf + ';}' +
				'}' ), 
			
		);
	}

	return element;
})
