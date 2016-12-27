(function ($, d) {
	$(d).ready(function () {
		$('.select_wide').parent().addClass('wide_wrap');

		try {
			var $block = $('.ml_admin_page');

			$block.find('li.subheader').each(function () {
				var group = $(this).data('group');
				if (group) {
					if ($('.' + group).length > 0) {
						$(this).append(
								$('<div>', {'class': 'expand'}).click(function () {
							$(this).parent().find('.opt_list li').toggleClass('hidden');

						})
								);
					}
				}
				$('<ul>', {'class': 'opt_list ' + group}).append($('.' + group)).appendTo('.subheader[data-group=' + group + ']');
			});

		} catch (e) {
			console.log('options expander error ' + e);
		}









		var templates = {
			'template-menu.php': ['#page_menu', '#bg_options', '#bg_additional_options'],
			'template-contact.php': ['#map_options', '#sidebar_chooser', '#bg_options', '#bg_additional_options', '#post_layout', '#page_color_option', '#read_more_text'],
			'template-slideshow.php': ['#page_slideshow_cat', '#page_slideshow_controls', '#post_layout'],
			'template-portfolio.php': ['#bg_options', '#page_portfolio_cat', '#ajax_load_images', '#grid_options', '#bg_additional_options', '#post_layout'],
			'default': ['#sidebar_chooser', '#bg_options', '#bg_additional_options', '#post_layout', '#page_color_option']
		};

		function metaboxSwitcher(template) {
			$(templates['template-menu.php'].join(',')).hide();
			$(templates['template-contact.php'].join(',')).hide();
			$(templates['template-slideshow.php'].join(',')).hide();
			$(templates['template-portfolio.php'].join(',')).hide();
			$(templates['default'].join(',')).hide();
			$(templates[template].join(',')).show();
			(template === 'template-slideshow.php') ? switchSlideshowSettings() : onChangeBGOption();
		}

		function switchSlideshowSettings() {
			$('#ml_custom_slideshow_options').attr('checked') ? $('#page_slideshow_settings').show() : $('#page_slideshow_settings').hide();
		}

		function onChangeBGOption() {
			switchSlideshowSettings();
			$('#page_slideshow_cat, #page_slideshow_settings, #bg_additional_options, #bg_video_options').hide();
			if ($('#ml_slideshow_option').val() === 'custom') {
				$('#page_slideshow_cat').show();
			} else if ($('#ml_slideshow_option').val() === 'image') {
				$('#bg_additional_options').show();
			} else if ($('#ml_slideshow_option').val() === 'video') {
				$('#ml_video_image').closest('tr').hide();
				$('#bg_video_options').show();
				if ($('#ml_video_poster').val() === 'custom') {
					$('#ml_video_image').closest('tr').show();
				}
			}
		}

		function add_audio() {

		}

		function onChangeColorOptions() {
			$('#ml_custom_color_options').attr('checked') ? $('#date_color_options, #color_options, #slideshow_color_options').show() : $('#date_color_options, #color_options, #slideshow_color_options').hide();
		}

		try {
			onChangeColorOptions();
			$('#ml_custom_color_options').change(onChangeColorOptions);

			// choose template
			var $selected = $('#page_template').find(':selected');
			if ($selected.length === 0) {
				onChangeBGOption();

			}

			var current_template = $selected.val();

			if (current_template in templates) {
				metaboxSwitcher(current_template);
			}

			// slideshow
			$('#page_template').change(function () {
				metaboxSwitcher($(this).val());
			});
			$('#ml_slideshow_option, #ml_video_poster').change(onChangeBGOption);
			$('#ml_custom_slideshow_options').change(switchSlideshowSettings);

		} catch (e) {
			console.log(e);
		}

	});

})(jQuery, document);