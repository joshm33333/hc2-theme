var 
el = wp.element,
ce = el.createElement,
ed = wp.editor,
bd = wp.blockEditor,
cp = wp.components;
 

wp.hooks.addFilter('blocks.getSaveContent.extraProps','hcube/filterprops-column',( props, element, attributes ) => {
	if(element.name === 'core/column') {
		
		
		props.className = 'hcube-block-column';
		var w = (attributes.width?attributes.width:'50');
		props.style = lodash.assign( props.style, { 'flex-basis': w+'%','max-width': w+'%' } );
		if( attributes.verticalAlignment == 'center' ) props.style = lodash.assign( props.style, { 'align-self': 'center' } );
		if( attributes.verticalAlignment == 'top' ) props.style = lodash.assign( props.style, { 'align-self': 'flex-start' } );
		if( attributes.verticalAlignment == 'bottom' ) props.style = lodash.assign( props.style, { 'align-self': 'flex-end' } );
	}
	
	return props;
})    