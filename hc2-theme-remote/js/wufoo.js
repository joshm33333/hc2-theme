var 
el = wp.element,
ce = el.createElement,
ed = wp.editor,
bd = wp.blockEditor,
cp = wp.components;
 
wp.blocks.registerBlockType( 'hcube/wufoo', {
	title: 'Wufoo Form',
	icon: { foreground: '#ffaa1e', src: 'clipboard' },
	category: 'hcube-blocks',
	attributes: {
		formurl: { type: 'string', default: '' },
		frameheight: { type: 'string', default: '' },
	},
	
  
	edit: function( props ) {
		
		const { formurl, frameheight } = props.attributes;
			
		return ce( "div", null,
			ce(
				bd.InspectorControls ,
				{ key: 'controls' },
				ce( cp.PanelBody, { title: 'Settings', initialOpen: true }, 
					ce( cp.TextControl,{ placeholder: 'https://hcube.wufoo.com/forms/FORM_ID/', label: 'Form Permanent Link',value: formurl.slice(0, -1),onChange: function( val ) {props.setAttributes( { formurl: val+'/' } );}}),
					ce( cp.TextControl,{ label: 'Default Height',value: frameheight,onChange: function( val ) {props.setAttributes( { frameheight: val } );}}),
				)
			),
			ce( wp.serverSideRender, { block: "hcube/wufoo", attributes: props.attributes })
		
		);
	},
	save: function( props ) { return null; }
})