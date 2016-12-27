(function() {
//	var th_wpml_lang = '';
	tinymce.create('tinymce.plugins.th_buttons', {
		init: function(ed, url) {
			ed.addButton('highlight', {
				title: 'Highlight',
				onclick: function() {

					ed.focus();
					ed.selection.setContent(' [highlight] ' + ed.selection.getContent() + ' [/highlight] ');

				},
				image: url + "/shortcodes/img/ed_highlight.png"
			});

			ed.addCommand('buttons', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/buttons.php' + th_wpml_lang,
					width: 350,
					height: 540,
					inline: 1
				});

			});

			ed.addButton('buttons', {
				title: 'Insert Button',
				cmd: 'buttons',
				image: url + "/shortcodes/img/ed_buttons.png"
			});

			ed.addCommand('portfolio', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/portfolio.php' + th_wpml_lang,
					width: 350,
					height: 710,
					inline: 1
				});

			});
			ed.addButton('portfolio', {
				title: 'portfolio',
				cmd: 'portfolio',
				image: url + "/shortcodes/img/ed_portfolio.png"
			});

			ed.addCommand('blog', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/blog.php' + th_wpml_lang,
					width: 350,
					height: 410,
					inline: 1
				});
			});
			ed.addButton('blog', {
				title: 'Insert Blog',
				cmd: 'blog',
				image: url + "/../../images/img/ed_blog.png"
			});

			ed.addButton('th_table', {
				title: 'Table',
				onclick: function() {

					ed.focus();
					ed.selection.setContent(' [th_table] <table> <thead><tr><th>Header 1</th><th>Header 2</th></tr></thead> <tbody><tr><td>Division 1</td><td>Division 2</td></tr></tbody> </table> [/th_table] ');

				},
				image: url + "/shortcodes/img/ed_table.png"
			});

			ed.addCommand('contactForm', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/contactForm.php' + th_wpml_lang,
					width: 900,
					height: 700,
					inline: 1
				});
			});
			ed.addButton('contactForm', {
				title: 'Insert Contact Form',
				cmd: 'contactForm',
				image: url + "/shortcodes/img/ed_contactForm.png"
			});

			ed.addButton('list', {
				title: 'Insert List',
				cmd: 'list',
				image: url + "/shortcodes/img/ed_list.png"
			});

			ed.addCommand('list', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/list.php' + th_wpml_lang,
					width: 350,
					height: 330,
					inline: 1
				});
			});

			ed.addButton('testimonial', {
				title: 'Insert testimonial',
				cmd: 'testimonial',
				image: url + "/shortcodes/img/ed_testimonial.png"
			});

			ed.addCommand('testimonial', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/testimonial.php' + th_wpml_lang,
					width: 350,
					height: 330,
					inline: 1
				});
			});

			ed.addCommand('notifications', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/notifications.php' + th_wpml_lang,
					width: 350,
					height: 330,
					inline: 1
				});

			});

			ed.addButton('notifications', {
				title: 'Insert Notification',
				cmd: 'notifications',
				image: url + "/shortcodes/img/ed_notifications.png"
			});

			ed.addButton('divider', {
				title: 'Insert Separator line',
				image: url + "/shortcodes/img/ed_divider.png",
				onclick: function() {
					ed.selection.setContent("<hr>");
				}
			});


			ed.addCommand('toggle', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/toggle.php' + th_wpml_lang,
					width: 350,
					height: 540,
					inline: 1
				});

			});

			ed.addButton('toggle', {
				cmd: 'toggle',
				title: 'Insert Toggle',
				image: url + "/shortcodes/img/ed_toggle.png"
			});
			ed.addButton('tabs', {
				title: 'Insert Tabs',
				onclick: function() {
					ed.focus();
					ed.selection.setContent('[tabgroup] <br>[tab title="Tab 1"]' + ed.selection.getContent() + '[/tab] <br>[tab title="Tab 2"]Tab 2 content goes here.[/tab] <br>[tab title="Tab 3"]Tab 3 content goes here.[/tab] <br>[/tabgroup]');

				},
				image: url + "/shortcodes/img/ed_tabs.png"
			});

			ed.addCommand('social_link', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/social_link.php' + th_wpml_lang,
					width: 350,
					height: 470,
					inline: 1
				});

			});
			ed.addButton('social_link', {
				title: 'Insert Social Link',
				cmd: 'social_link',
				image: url + "/shortcodes/img/ed_social.png"
			});

			ed.addCommand('social_button', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/social_button.php' + th_wpml_lang,
					width: 350,
					height: 700,
					inline: 1
				});

			});
			ed.addButton('social_button', {
				title: 'Insert Share Button',
				cmd: 'social_button',
				image: url + "/shortcodes/img/ed_social_button.png"
			});
			ed.addCommand('teaser', function() {
				ed.windowManager.open({
					file: url + '/shortcodes/teaser.php' + th_wpml_lang,
					width: 350,
					height: 550,
					inline: 1
				});

			});
			
		ed.addButton('columns', {
				type: 'menubutton',
				text: false,
				icon: false,
				menu: [
					{text: 'Column 1/2', onclick: function() {
							ed.insertContent(' [one_half]  [/one_half] ');
						}},
					{text: 'Column 1/2 last', onclick: function() {
							ed.insertContent(' [one_half last=last]  [/one_half] ');
						}},
					{text: 'Column 1/3', onclick: function() {
							ed.insertContent(' [one_third]  [/one_third] ');
						}},
					{text: 'Column 1/3 last', onclick: function() {
							ed.insertContent(' [one_third last=last]  [/one_third] ');
						}},
					{text: 'Column 1/4', onclick: function() {
							ed.insertContent(' [one_fourth]  [/one_fourth] ');
						}},
					{text: 'Column 1/4 last', onclick: function() {
							ed.insertContent(' [one_fourth last=last]  [/one_fourth] ');
						}},
					{text: 'Column 2/3', onclick: function() {
							ed.insertContent(' [two_third]  [/two_third] ');
						}},
					{text: 'Column 2/3 last', onclick: function() {
							ed.insertContent(' [two_third last=last]  [/two_third] ');
						}},
					{text: 'Column 3/4', onclick: function() {
							ed.insertContent(' [three_fourth]  [/three_fourth] ');
						}},
					{text: 'Column 3/4 last', onclick: function() {
							ed.insertContent(' [three_fourth last=last]  [/three_fourth] ');
						}}
				]
			});
		},
		addImmediate: function(d, e, a) {
			d.add({title: e, onclick: function() {
					tinyMCE.activeEditor.execCommand("mceInsertContent", false, a)
				}})
		}
	});

	tinymce.PluginManager.add('th_buttons', tinymce.plugins.th_buttons);
	
})();

