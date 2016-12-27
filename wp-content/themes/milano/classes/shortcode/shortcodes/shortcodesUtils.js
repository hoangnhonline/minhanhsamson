function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function submitData($form, content) {
	try {
		var monoShortcodes = ['social_link', 'testimonial', 'portfolio', 'blog'];
		
		$form = $form || jQuery('form');
		if(window.tinyMCE) {
			var selectedContent = content || tinyMCE.activeEditor.selection.getContent(),
				id = tinyMCE.activeEditor.editorId || 'content',
				shortcodeName = $form.attr('name'),
				shortcode = ' [' + shortcodeName + ' ';

			$form.find('[data-name]').each(function() {
				var $this	=	jQuery(this),
					type	=	$this.data('type'),
					value	=	($this.attr('type') === 'checkbox')
							?	($this.is(':checked')) ? 'on' : ''
							:	$this.val() || '';
				value = fitValue(type, value);
				shortcode += $this.data('name') + '="' + value + '" ';
			});

			shortcode += (monoShortcodes.indexOf(shortcodeName) == -1) ? ']' + selectedContent + '[/' + shortcodeName + '] ' : '/]';

			if(window.tinyMCE) {
			var id;
			var tmce_ver=window.tinyMCE.majorVersion;
			if(typeof tinyMCE.activeEditor.editorId != 'undefined')
			{
				id =  tinyMCE.activeEditor.editorId;
			}
			else
			{
				id = 'content';
			}
		if (tmce_ver>="4") {
			window.tinyMCE.execCommand('mceInsertContent', false, shortcode);
			} else {
			window.tinyMCE.execInstanceCommand(id, 'mceInsertContent', false, shortcode);
			}

			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		}
	} catch (e) {
		console.error(e);
	}
	return;
}

function fitValue(type, value) {
	switch(type) {
		case 'url':
			var pattern = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
			if (!pattern.test(value)) {
				alert('url is not valid');
				throw 'url is not valid';
			}
			break;
		case 'number':
			value = parseInt(value, 10);
			break;
		default:
			break;
	}
	return value;
}