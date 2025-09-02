/* globals tinymce */

(function(){
	// Add WYSIWYG Stuurlui button
	tinymce.create('tinymce.plugins.strl_buttons', {
		init : function(ed, url){
			url = url.replace('/js', '');

			ed.addButton('shortcodes', {
				title: 'STRL Shortcodes',
				type: 'menubutton',
				image: url + '/img/icon-strl-blue.svg',
				menu: [{
					text: 'Button',
					onclick: function(){
						ed.windowManager.open({
							width: 700,
							height: 400,
							title: 'Button',
							body: [{
								type: 'textbox',
								id: 'button-text',
								name: 'text',
								label: 'Tekst',
								value: '',
							}, {
								type: 'textbox',
								id: 'button-link',
								name: 'link',
								label: 'Link',
								value: ''
							}, {
								type: 'textbox',
								id: 'button-title',
								name: 'title',
								label: 'Title',
								value: ''
							}, {
								type   : 'listbox',
								name   : 'target',
								label  : 'Doel',
								id : 'button-target',
								values : [
									{ value: '_parent', text: 'Huidige venster' },
									{ value: '_blank', text: 'Nieuw venster' },
								],
								value : 'blue'
							}, {
								type   : 'listbox',
								name   : 'type',
								label  : 'Type',
								id : 'button-class',
								values : [
									{ value: 'btn', text: 'Primair' },
									{ value: 'btn icon', text: 'Primair met pijltje' },
									{ value: 'secondary', text: 'Secondary' },
									{ value: 'secondary icon', text: 'Secondary pijltje' },
									{ value: 'tertiary', text: 'Tertiary' },
									{ value: 'tertiary icon', text: 'Tertiary met pijltje' },
									{ value: 'quaternary', text: 'Quaternary' },
									{ value: 'quaternary icon', text: 'Quaternary met pijltje' },
									{ value: 'white ', text: 'Wit' },
									{ value: 'white icon', text: 'Wit met pijltje' },
								],
								value : ''
							}],
							onsubmit: function(e){
								title = '';
								if ( e.data.title ) {
									title = ' title="' + e.data.title + '"';
								}
								type = '';
								if ( e.data.type ) {
									type = ' type="' + e.data.type + '"';
								}
								ed.insertContent('[btn link="' + e.data.link + '" target="' + e.data.target + '"' + type + ' ' + title + ']' + e.data.text + '[/btn]');
							}
						});
					}
				},{
					text: 'Test HTML',
					onclick: function(){
						ed.windowManager.open({
							width: 700,
							height: 400,
							title: 'Test HTML',
							body: [{
								type: 'textbox',
								name: 'text',
								label: 'Test HTML',
								value: '<h1>Dit is een gestylede h1</h1><h2>Dit is een gestylede h2</h2><p>Dit is een paragraaf.</p><h3>Dit is een gestylede h3</h3><p>Dit is de tekst onder de gestylede h3.</p><h4>Dit is een gestylede h4</h4><p>Dit is de tekst onder de gestylede h4.</p><strong>Deze tekst is bold,</strong> <em>dit italic</em><p>Pellentesque id est finibus, vulputate dolor nec, eleifend nisl. Fusce auctor cursus nisi, <a href="">ac vehicula nunc porttitor</a> vel. Integer non ante bibendum, cursus diam ut, porttitor est. Morbi et orci turpis. Cras fermentum nulla placerat, sollicitudin metus ut, vehicula metus. Quisque feugiat nibh eget risus hendrerit interdum. Vivamus vitae lobortis est. Donec eu dapibus enim. In hac habitasse platea dictumst. Morbi sit amet purus eleifend, convallis neque vitae, sodales ante. Mauris vel gravida risus. Sed vitae turpis augue.</p><ul><li><strong>BOLDmMauris vel gravida risus.</strong></li><li><a href="">Pellentesque id est finibus</a>.</li><li><em>ITALIC Vulputate dolor nec.</em></li></ul><p>Pellentesque id est finibus, vulputate dolor nec, eleifend nisl. Fusce auctor cursus nisi, ac vehicula nunc porttitor vel.</p><ul><li>Mauris vel gravida risus.</li><li><a href="">Pellentesque id est finibus.</a></li><li>Vulputate dolor nec.</li></ul><p>Pellentesque id est finibus, vulputate dolor nec, eleifend nisl. Fusce auctor cursus nisi, ac vehicula nunc porttitor vel. </p> [btn link="/" target="_parent" type=""]Dit is een button[/btn] [btn link="/" target="_parent" type="ghost"]Dit is een button[/btn] [accordion title="Accordion titel"]Accordion content[/accordion] [tooltip title="Dit is een tooltip"]Dit is de content van de tooltip[/tooltip]<blockquote>Dit is een bloockquote</blockquote>',
								minHeight: 200,
								multiline: true
							}],
							onsubmit: function(e){
								ed.insertContent(e.data.text);
							}
						});
					}
				},
				{
					text: 'Uitgelicht',
					onclick: function(){
						ed.windowManager.open({
							width: 700,
							height: 400,
							title: 'Uitgelicht',
							body: [{
								type: 'textbox',
								name: 'text',
								label: 'Uitgelicht',
								minHeight: 200,
								multiline: true
							}],
							onsubmit: function(e){
								ed.insertContent(
									'[featured]' + e.data.text + '[/featured]'
								);
							}
						});
					}
				}
			]
			});

		},
	});
	tinymce.PluginManager.add( 'strl_buttons', tinymce.plugins.strl_buttons );
})();
