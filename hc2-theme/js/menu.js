var 
el = wp.element,
ce = el.createElement,
ed = wp.editor,
bd = wp.blockEditor,
cp = wp.components;

wp.blocks.registerBlockType('hcube/menu', {
	title: 'Navigation',
	icon: {foreground: '#ffaa1e',src: 'menu'},
	category: 'hcube-blocks',
	attributes: {
		unique: {type: 'string',default: ''},
		fixtop: {type: 'number',default: 0},
		opacity: {type: 'string',default: 'ff'},
		menu: {type: 'string',default: 'main-menu'},
		align: {type: 'string',default: 'right'},
		maxwidth: {type: 'string',default: '1000px'},
		style: {type: 'string',default: 'normal'},
		color: {type: 'string',default: '#000'},
		background: {type: 'string',default: 'rgba(0,0,0,0)'},
		dropdown: {type: 'string',default: 'rgba(0,0,0,0)'},
		accent: {type: 'string',default: '#333'},
		position: {type: 'string',default: 'relative'}, 
		size: {type: 'string',default: 'sizeb'},
		media: {type: 'string',default: ''},
		logoscale: {type: 'number',default: 250},
		logopos: {type: 'number',default: 0},
		zoom: {type: 'boolean',default: false}
	},
	edit: function(props) { 
		
		const { name, attributes } = props;
		const { fixtop, unique, logoscale, logopos, zoom, media, opacity, menu, align, maxwidth, style, color, background, dropdown, accent, position, size } = attributes;

		if( name === 'hcube/menu' ) {
			props.attributes.unique = Math.random().toString(36).substr(2, 9);
		}
			
		return ce("div",null,
			ce(
				bd.InspectorControls , 
				{ key: 'controls' },
				ce( cp.PanelBody, { title: 'Logo', initialOpen: false }, 
					ce( 'div', { className: 'hcube_mediapanel' },
						ce( bd.MediaUpload, {
							onSelect: function( media ) {return props.setAttributes({media: media.url})},
							type: 'image',
							render: function( obj ) {  
								return ce( cp.Button, {className: 'components-icon-button image-block-btn is-button is-default is-large',onClick: obj.open},
									ce( 'svg', { className: 'dashicon dashicons-edit', width: '20', height: '20' },
										ce( 'path', { d: "M2.25 1h15.5c.69 0 1.25.56 1.25 1.25v15.5c0 .69-.56 1.25-1.25 1.25H2.25C1.56 19 1 18.44 1 17.75V2.25C1 1.56 1.56 1 2.25 1zM17 17V3H3v14h14zM10 6c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2zm3 5s0-6 3-6v10c0 .55-.45 1-1 1H5c-.55 0-1-.45-1-1V8c2 0 3 4 3 4s1-3 3-3 3 2 3 2z" } )
									),ce( 'span', {},'Select image'),)}}),
					),
					ce( 'img', { className: 'hcube_imagePreview', src: media }, null ),
					ce( cp.ToggleControl,{label:'Big Logo Animation',value:'1',checked:zoom,onChange: function(val){props.setAttributes({zoom:val})}}),
					zoom?ce( cp.RangeControl,{label: 'Scale Percentage',value: logoscale,initialPosition:250,min:100,max:500,onChange:function(val){props.setAttributes({logoscale:val})}}):null,
					zoom?ce( cp.RangeControl,{label: 'Vertical Adjustment',value: logopos,initialPosition:0,min:-250,max:250,onChange:function(val){props.setAttributes({logopos:val})}}):null,
				),
				ce( cp.PanelBody, { title: 'Settings', initialOpen: true }, 
					ce( cp.TextControl,{ label: 'Menu Slug',value: menu,onChange: function( val ) {props.setAttributes( { menu: val } );}}),
					ce( cp.TextControl,{ label: 'Minimum Width',value: maxwidth,onChange: function( val ) {props.setAttributes( { maxwidth: val } );}}),
					ce( cp.ButtonGroup, {},
						ce( cp.Button, { value:'1',isDefault:(align=='left'?false:true),isPrimary:(align=='left'?true:false),onClick: function( val ) {props.setAttributes( { align: 'left' } )}}, 'Align Left' ),
						ce( cp.Button, { value:'1',isDefault:(align=='right'?false:true),isPrimary:(align=='right'?true:false),onClick: function( val ) {props.setAttributes( { align: 'right' } )}}, 'Align Right' ),
					),
					ce( cp.ButtonGroup, {},
						ce( cp.Button, { value:'1',isDefault:(size=='sizeb'?false:true),isPrimary:(size=='sizeb'?true:false),onClick: function( val ) {props.setAttributes( { size: 'sizeb' } )}}, 'Big Buttons' ),
						ce( cp.Button, { value:'1',isDefault:(size=='sizea'?false:true),isPrimary:(size=='sizea'?true:false),onClick: function( val ) {props.setAttributes( { size: 'sizea' } )}}, 'Small Buttons' ),
					),
					ce(cp.ButtonGroup, {},
						ce( cp.Button, { value:'1',isDefault:(position=='relative'?false:true),isPrimary:(position=='relative'?true:false),onClick: function( val ) {props.setAttributes( { position: 'relative' } )}}, 'Default' ),
						ce( cp.Button, { value:'1',isDefault:(position=='sticky'?false:true),isPrimary:(position=='sticky'?true:false),onClick: function( val ) {props.setAttributes( { position: 'sticky' } )}}, 'Sticky' ),
						ce( cp.Button, { value:'1',isDefault:(position=='fixed'?false:true),isPrimary:(position=='fixed'?true:false),onClick: function( val ) {props.setAttributes( { position: 'fixed' } )}}, 'Fixed' ),
					),
					( position=='fixed' || position=='sticky' )? ce( 'div', { className: 'hcube_indentedControls' }, ce( cp.RangeControl,{label: 'Distance from Top',value: fixtop,initialPosition:0,min:0,max:200,onChange:function(val){props.setAttributes({fixtop:val})}}) ) : null,
				),
				ce( cp.PanelBody, { title: 'Color Settings', initialOpen: false }, 
					ce( 'div', { className: 'hcube_customcolorpanel' }, 
						'Text Color', 	
						ce( cp.ColorIndicator , { colorValue: color } ),
						ce( cp.ColorPalette, { colors: hcubecolors, value: color, onChange: function( val ) { props.setAttributes( { color: val } ) } } ),
					),
					ce( 'div', { className: 'hcube_customcolorpanel' },
						'Background Color', 	
						ce( cp.ColorIndicator , { colorValue: background } ),
						ce( cp.ColorPalette, { colors: hcubecolors, value: background, onChange: function( val ) { props.setAttributes( { background: val } ) } } ),
					),
					ce( 'div', { className: 'hcube_indentedControls' }, ce( cp.RangeControl, { label:'Background Opacity', value:parseInt(opacity, 16),initialPosition:255,min:0,max:255,	onChange: function( val ) { props.setAttributes({ opacity:val.toString(16) })}}) ),
					ce( 'div', { className: 'hcube_customcolorpanel' },
						'Dropdown Color', 	
						ce( cp.ColorIndicator , { colorValue: dropdown } ),
						ce( cp.ColorPalette, { colors: hcubecolors, value: dropdown, onChange: function( val ) { props.setAttributes( { dropdown: val } ) } } ),
					),
					ce( 'div', { className: 'hcube_customcolorpanel' },
						'Accent Color', 	
						ce( cp.ColorIndicator , { colorValue: accent } ),
						ce( cp.ColorPalette, { colors: hcubecolors, value: accent, onChange: function( val ) { props.setAttributes( { accent: val } ) } } ),
					)
						
				) 
			),
			ce("div", { className: "hcube_editor_nav "+align+" "+style+" "+size, style: { backgroundColor: background, backgroundImage: 'url('+media+')', color: color, borderBottom: '5px solid ' + dropdown } }, 
				"Navigation",
				ce("i", { className: "fas fa-bars", style: { color: accent } }, null ), 
			)
		
		); 
	},
	save: function(props) {
		
		const { attributes } = props;
		const { fixtop, unique, logoscale, logopos, zoom, media, opacity, menu, align, maxwidth, style, color, background, dropdown, accent, position, size } = attributes;

		return ce( el.RawHTML, null, 
			'</div><nav id="hcube-menu-'+unique+'" class="hcube-menu hcube-menu-'+align+' hcube-menu-'+style+' hcube-menu-'+size+'" data-full-width="true" style="top:'+fixtop+'px" >'+
				'<div class="hcube-menu-inner">'+
					'<div id="hcube-animtar-'+unique+'" class="hcube-menu-logo hcube-animation-wrapper hcube-animation-logo"></div>'+
					'[nav menu="'+menu+'"]'+ 
				'</div>'+
				'<div class="hcube-hamburger" aria-label="Menu" tabIndex="0" role="button" data-vars-name="Hamburger Menu" on="tap:hcube-menu-'+unique+'.toggleClass(class=hcube-menu-open)"><i class="fas fa-bars"></i></div>'+
				'<style>'+
					( zoom ? 'nav#hcube-menu-'+unique+' .hcube-animation-logo{transform: translate(0px,'+( logopos )+'px) scale('+( logoscale / 100 )+');}' : '' )+ 
					( zoom ? 'nav#hcube-menu-'+unique+' .hcube-menu-open > .hcube-hamburger {background:inherit !important;}' : '' )+
					'.hcube-menu-open > .hcube-hamburger {background: '+dropdown+' !important;}'+
					'nav#hcube-menu-'+unique+'.hcube-menu-normal .hcube-menu-logo{background-image: url('+ media.replace( 'http:', 'https:' ) +');}'+
					
					'nav#hcube-menu-'+unique+'.hcube-menu-sizea > div > div > ul > li > [data-mega]{top:51px}'+
					'nav#hcube-menu-'+unique+'.hcube-menu-sizeb > div > div > ul > li > [data-mega]{top:65px}'+

					'nav#hcube-menu-'+unique+' > div > div > ul > li.hcube-menu-open > a {border-top: 3px solid '+accent+';}'+

					'nav#hcube-menu-'+unique+'.hcube-menu-normal  [data-button="true"]{background: '+accent+';}'+
				
					( position == 'sticky' ? '.hcube-content nav#hcube-menu-'+unique+'{position: sticky;position: -webkit-sticky;position: -moz-sticky;position: -ms-sticky;position: -o-sticky;top: 0;}' :'')+
					( position == 'fixed' ? '.hcube-content nav#hcube-menu-'+unique+'{position: fixed;top: 0;}' :'')+
					
					'nav#hcube-menu-'+unique+' .hcube-menu-logo{height:70px;}'+
						
					'nav#hcube-menu-'+unique+'.hcube-menu-normal > div {text-align: '+align+';}'+
					'nav#hcube-menu-'+unique+'.hcube-menu-normal > div > div {display:inline-block;}'+
					
					'nav#hcube-menu-'+unique+',#hcube-menu-'+unique+' a,'+
					'nav#hcube-menu-'+unique+',#hcube-menu-'+unique+' li{color:'+color+';}'+
					'nav#hcube-menu-'+unique+' {background-color:'+background+opacity+';}'+
					'nav#hcube-menu-'+unique+'.hcube-menu-normal {z-index: 999999999;}'+
					'nav#hcube-menu-'+unique+'.hcube-menu-open {z-index: 9999999999;}'+
					
					'nav#hcube-menu-'+unique+' ul.sub-menu {background: '+dropdown+' ;}'+
					'nav#hcube-menu-'+unique+' li.hcube-menu-open > ul.sub-menu {border-bottom: 1px solid '+accent+';border-top: 3px solid '+accent+' ;}'+
					'nav#hcube-menu-'+unique+' ul ul li.hcube-menu-open > ul.sub-menu {border-left: 1px solid '+accent+';border-right: 1px solid '+accent+';}'+
					'nav#hcube-menu-'+unique+' li.menu-item-has-children > a:after {border-left: 3px solid '+accent+';border-bottom: 3px solid '+accent+';}'+
					'nav#hcube-menu-'+unique+' a > i {color:'+accent+'}'+
					'nav#hcube-menu-'+unique+' .sub-menu li.hcube-menu-open > a, nav#hcube-menu-'+unique+' .sub-menu li.hcube-menu-open > a > i {color: white;    padding-right: 30px;}'+
					'nav#hcube-menu-'+unique+' .sub-menu li.hcube-menu-open > a:not(#_) {background: '+accent+';    padding-left: 30px;}'+
					
					'nav#hcube-menu-'+unique+' li.menu-item:not(.hcube-menu-open) li > a {padding-left: 0;padding-right: 0;}'+

					'nav#hcube-menu-'+unique+' > div > div > ul > li > a > i { display:none;}'+
					
					
					'nav#hcube-menu-'+unique+'.hcube-menu-sizeb ul ul a > i {padding-right: 27px;}'+
					'nav#hcube-menu-'+unique+'.hcube-menu-sizeb ul ul a {padding-left: 27px;}'+
					
					'nav#hcube-menu-'+unique+'.hcube-menu-sizeb .sub-menu li.hcube-menu-open > a > i {padding-right: 37px;}'+
					'nav#hcube-menu-'+unique+'.hcube-menu-sizeb .sub-menu li.hcube-menu-open > a {padding-left: 37px;}'+
						
					'@media (min-width:'+maxwidth+'){'+

						'nav#hcube-menu-'+unique+'.hcube-menu-sizea .hcube-menu-logo{height:55px;}'+
						'nav#hcube-menu-'+unique+' li.menu-item > a:hover, nav#hcube-menu-'+unique+' li.menu-item.hcube-menu-open > a{    background: rgba(0,0,0,.2);}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-sizea.hcube-menu-normal {height: 55px;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-sizeb.hcube-menu-normal {height: 70px;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-normal.hcube-menu-right .hcube-menu-logo{background-position: 20px center;left: 0;right:auto;transform-origin:top left;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-normal.hcube-menu-left .hcube-menu-logo{background-position: calc( 100% - 20px ) center;right: 0;left:auto;transform-origin:top right;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-normal > div > div > ul > li > ul.sub-menu{left:auto;right:auto;'+align+':0;}'+
						'nav#hcube-menu-'+unique+' > div > div > ul > li > ul > li > a:not(#_):not(#_):hover {background: linear-gradient( 90deg,rgba(0,0,0,.2),transparent) }'+
						'nav#hcube-menu-'+unique+' > div > div > ul > li > ul > li.hcube-menu-open > a:not(#_):not(#_) {background: linear-gradient( 90deg,'+accent+',transparent) }'+
						'nav#hcube-menu-'+unique+'.hcube-menu-sizea ul ul .sub-menu {left: 55px;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-sizeb ul ul .sub-menu {left: 70px;}'+
						'nav#hcube-menu-'+unique+' > div > div > ul > li > a[href],nav#hcube-menu-'+unique+' > div > div > ul > li.menu-item > a{color: '+color+';    opacity: 1;}'+

					'}'+

					'@media (max-width:'+maxwidth+'){'+
						'nav#hcube-menu-'+unique+'.hcube-menu-sizeb a > i {padding-right: 27px;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-sizeb a {padding-left: 27px;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-normal .hcube-menu-logo{background-position: 20px center;left: 0;right:auto;transform-origin:top left;}'+
						
						'nav#hcube-menu-'+unique+'.hcube-menu-normal [data-button="true"]{background: transparent;}'+
						
						'nav#hcube-menu-'+unique+' .hcube-mega-media {display:none;}'+
						
						'nav#hcube-menu-'+unique+'.hcube-menu-normal > div > div > ul > li.hcube-mega-menu > ul > li{width:100%;}'+
						
						'nav#hcube-menu-'+unique+' ul ul{    margin: -3px 0 0 0;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-sizea > div > div > ul > li > ul.sub-menu {    margin-top: -55px;left: 55px;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-sizeb > div > div > ul > li > ul.sub-menu {    margin-top: -70px;left: 70px;}'+
						
						'nav#hcube-menu-'+unique+' li.hcube-menu-open > a, nav#hcube-menu-'+unique+' li.hcube-menu-open > a > i {color: white;  }'+
						'nav#hcube-menu-'+unique+' li.hcube-menu-open > a {background: '+accent+';    }'+
						
						'nav#hcube-menu-'+unique+'.hcube-menu-sizea ul ul .sub-menu a {padding-left: 30px;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-sizeb ul ul .sub-menu a {padding-left: 37px;}'+
						
						'nav#hcube-menu-'+unique+' > div > div > ul > li > a > i { display:inline-block;}'+
						'nav#hcube-menu-'+unique+' ul.menu {border-top: 3px solid transparent;border-bottom: 1px solid transparent;}'+
						
						'nav#hcube-menu-'+unique+' ul.menu{margin-top: 70px;}'+
						
						'nav#hcube-menu-'+unique+' ul.menu {position: absolute;    left: 0;    top: 0;width: 0;transition: all .3s;overflow: hidden;margin-bottom: 0;background-color:'+dropdown+';padding: 0px;box-sizing: border-box;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-open ul.menu {overflow:visible;width: 100%;    box-shadow: 0 30px 30px -20px #000;border-top: 3px solid '+accent+';border-bottom: 1px solid '+accent+';}'+
						
						'nav#hcube-menu-'+unique+' li.hcube-menu-open > ul.sub-menu {width:calc( 100% - 70px );}'+
						'nav#hcube-menu-'+unique+' div.hcube-hamburger{color:'+accent+';display: block;position: absolute;right: 13px;top: 15px;background: none !important;font-size: 28px;cursor: pointer;height: auto !important;outline: none;padding: 5px 10px;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-open li:before{display:inline}'+
						'nav#hcube-menu-'+unique+' ul.menu li {display: block;padding: 0;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-open ul.menu li:before {margin-right: 8px;	}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-open > div > div {width: 100%;	    float: none;    display: inline-block;    overflow: hidden;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-normal {height: 70px;padding: 0;    overflow: visible;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-normal > div {height: 70px;background-size: auto 40px;}'+
						'nav#hcube-menu-'+unique+':not(.hcube-menu-open) .sub-menu {width:0;}'+
						'nav#hcube-menu-'+unique+'.hcube-menu-normal.hcube-menu-open > .hcube-menu-inner {overflow-y: scroll;overflow-x: hidden;height: 100vh;}'+
						'nav#hcube-menu-'+unique+' ul ul li.hcube-menu-open > ul.sub-menu {position: relative;display: inline-block;width: 100%;}'+

					'}'+
					'@media (max-width:450px){'+
						'div#hcube-animtar-'+unique+':not(#_) {max-width: calc('+(10000/logoscale)+'% - '+(10000/logoscale)+'px );margin-left: 25px;background-size: contain;background-position: 50% 50%;}'+
					'}'+
				'</style>'+
			'</nav>'+
			'<div class="hcube-menu-outer">'+
				( zoom ?
					'<amp-animation id="hcube-anima-'+unique+'" layout="nodisplay" ><script type="application/json">{ "direction": "alternate", "duration": "300", "delay": 0, "fill": "both", "selector": "#hcube-animtar-'+unique+'", "keyframes": {"easing": "ease-out", "transform": "scale(1) translate(0,0)"} }</script></amp-animation>'+
					'<amp-animation id="hcube-animb-'+unique+'" layout="nodisplay" ><script type="application/json">{ "direction": "alternate", "duration": "300", "delay": 0, "fill": "both", "selector": "#hcube-animtar-'+unique+'", "keyframes": {"easing": "ease-out", "transform": "scale('+( logoscale / 100 )+') translate(0px,'+( logopos )+'px)"} }</script></amp-animation>'+
					'<amp-position-observer intersection-ratios="0" on="exit:hcube-anima-'+unique+'.start;enter:hcube-animb-'+unique+'.start" layout="nodisplay"></amp-position-observer>'
				:'')+
			'</div><div>'
		)
		
	}
})
			