jQuery.noConflict();

function file_rm_ajax() {
	jQuery("input[name^='file_rm']").live("click", function() {

		var $fileId = jQuery(this).attr("id");

		jQuery("#" + $fileId).remove();



		jQuery.ajax({
			type: "post",
			url: $AjaxUrl,
			data: {
				action: "file_rm",
				file_id: $fileId,
				_ajax_nonce: $ajaxNonce},
			beforeSend: function() {
				jQuery("." + $fileId).css({display: ""});
			}, //fadeIn loading just when link is clicked
			success: function() { //so, if data is retrieved, store it in html
				jQuery("#file_deleted_" + $fileId).fadeOut("fast", function() {
					jQuery(this).remove()
				}); //animation
				jQuery("#image_" + $fileId).fadeOut("fast", function() {
					jQuery(this).parent().remove()
				});

			}
		}); //close jQuery.ajax
		return false;
	});
}






function file_up_ajax() {
	if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
		uploader_after35();
	} else {
		uploader_before35();
	}
}

function uploader_before35() {
	jQuery("input.button[id^='file_up_']").bind("click", function() {
		var $this = jQuery(this), tbframeInterval;
		var option_id = $this.attr('id').replace(/^file_up_/, '');
		tb_show('', 'media-upload.php?post_id=0&type=image&TB_iframe=true&width=670&height=600');
		tbframeInterval = setInterval(function() {
			jQuery('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image');
			jQuery('#TB_iframeContent').contents().find('#go_button').val('Use This Image');
		}, 1000);

		// Send img url
		window.send_to_editor = function(html) {

			clearInterval(tbframeInterval);

			var HTMLObj = jQuery(html),
					imgUrl = (HTMLObj.attr('href')) ? HTMLObj.find('img').attr('src') : HTMLObj.attr('src');

			if (!imgUrl || imgUrl.length == 0) {
				imgUrl = jQuery(html).attr('src');
			}

			if (imgUrl && imgUrl.length) {
				uploader_ajax($this, option_id, imgUrl);
			}
			tb_remove();
		};

	});
}

function uploader_after35() {
	var _custom_media = true,
			_orig_send_attachment = wp.media.editor.send.attachment;

	jQuery("input.button[id^='file_up_']").bind("click", function() {
		var $this = jQuery(this),
				option_id = $this.attr('id').replace(/^file_up_/, '');

		_custom_media = true;
		wp.media.editor.send.attachment = function(props, attachment) {
			if (_custom_media) {
				uploader_ajax($this, option_id, attachment.url);
			} else {
				return _orig_send_attachment.apply(this, [props, attachment]);
			}
			;
		};
		wp.media.editor.open($this);
		return false;
	});
	jQuery('.add_media').on('click', function() {
		_custom_media = false;
	});
}

function uploader_ajax(obj, option_id, imgUrl)
{
	jQuery.ajax({
		type: "post",
		url: $AjaxUrl,
		data: {
			action: "file_up",
			field_id: option_id,
			src: imgUrl,
			_ajax_nonce: $ajaxNonce},
		success: function() {
			var img = jQuery('#image_file_rm_' + option_id);
			if (img && img.length)
			{
				img.attr('src', imgUrl);
				img.attr('title', '<img src="' + imgUrl + '" alt=\'\' />');
			}
			else
			{
				//custom upload
				var imgWrapClass = 'float-left image_wrap';
				var delBtnClass = '';
				if (obj.data('type') == 'common')
				{
					jQuery('<div class="' + imgWrapClass + '"><img src="' + imgUrl + '" alt="" id="image_file_rm_' + option_id + '" class="ml_img" /></div>'
							+ '<div id="file_deleted_file_rm_' + option_id + '" class="' + delBtnClass + '">'
							+ '<div><input type="button" name="file_rm_' + option_id + '" id="file_rm_' + option_id + '" class="button" value="Delete" /></div>'
							+ '</div>'
							+ '</div>').insertBefore(obj.closest('div.image-label'));
				} else if (obj.data('type') == 'multiple') {
					var option = obj.data('option'),
							ids = [0];

					obj.closest('li').find('.slide').each(function() {
						ids.push(jQuery(this).data('id'));
					});
					var id = Math.max.apply(Math, ids) + 1;

					obj.closest('li').find('.images_cont').append(
							'<div class="slide" data-id="' + id + '">' +
							'<div class="' + imgWrapClass + '"><img class="ml_img" src="' + imgUrl + '" title="<img src=\'' + imgUrl + '\'/>" /></div>' +
							'<input type="hidden" name="' + option + '[' + id + '][src]" value="' + imgUrl + '" />' +
							'<input type="hidden" name="' + option + '[' + id + '][type]" value="image" />' +
							'<input type="button" class="button slide_rm" value="Delete" />' +
							'<div style="clear: both;"></div>' +
							'</div>'
							);
				} else if (obj.data('type') == 'sound') {
					obj.closest('li').find('#sound_' + obj.data('option')).val(imgUrl);
				} else {
					imgWrapClass = 'favicon_bg';
					delBtnClass = 'float-left';
					jQuery('<div class="' + imgWrapClass + '"><img src="' + imgUrl + '" alt="" id="image_file_rm_' + option_id + '" class="ml_img" /></div>'
							+ '<div id="file_deleted_file_rm_' + option_id + '" class="' + delBtnClass + '">'
							+ '<div><input type="button" name="file_rm_' + option_id + '" id="file_rm_' + option_id + '" class="button" value="Delete" /></div>'
							+ '</div>'
							+ '</div>').insertBefore(obj.closest('div.image-label'));
				}

			}
		}
	}); //close jQuery.ajax
}


function install_dummy() {
	jQuery("input[name^='install_dummy']").bind("click", function() {
		var dummy_type = jQuery("input:radio:checked").val();

		jQuery.ajax({
			type: "post",
			url: $AjaxUrl,
			dataType: 'json',
			data: {action: "install_dummy", dummy_type: dummy_type, _ajax_nonce: $ajaxNonce},
			beforeSend: function() {
				jQuery(".install_dummy_result").html('');
				jQuery(".install_dummy_loading").css({display: "block"});
				jQuery("input[name^='install_dummy']").attr('disabled', 'disabled');
				jQuery(".install_dummy_result").html("Importing dummy content...<br /> Please wait, it can take up to a few minutes.");

			}, //fadeIn loading just when link is clicked
			success: function(response) { //so, if data is retrieved, store it in html
				jQuery("input[name^='install_dummy']").removeAttr('disabled');
				var dummy_result = jQuery(".install_dummy_result");
				if (typeof response != 'undefined')
				{
					if (response.hasOwnProperty('status'))
					{
						switch (response.status)
						{
							case 'success':
								jQuery("input[name^='install_dummy']").remove();
								dummy_result.html('Completed');
								break;
							case 'error':
								dummy_result.html('<font color="red">' + response.data + '</font>');
								if (!response.hasOwnProperty('need_plugin'))
								{
									jQuery("input[name^='install_dummy']").remove();
								}
								break;
							default:
								break;
						}

					}
				}

			},
			complete: function() {
				jQuery(".install_dummy_loading").css({display: "none"});
			}
		}); //close jQuery.ajax
		return false;
	});
}



jQuery(document).ready(function() {
	jQuery(":checkbox").iButton();

	jQuery('.ml_help[title], .ml_img[title]').qtip({
		content: {
			text: false
		},
		style: {
			tip: "bottomLeft",
			classes: "ui-tooltip-dark"
		},
		position: {
			at: "top right",
			my: "bottom left"
		}
	}
	);


	function sidebar_rm_ajax() {
		jQuery("input[name^='sidebar_rm']").bind("click", function() {

			var $sidebarId = jQuery(this).attr("id");
			var $sidebarName = jQuery("#sidebar_generator_" + $sidebarId).val();
			jQuery("#sidebar_generator_" + $sidebarId).remove();

			var $arraySidebarInputs = new Array;
			jQuery("input[name^='sidebar_generator_']").each(function(id) {
				$updateSidebars = jQuery("input[name^='sidebar_generator_']").get(id);
				$arraySidebarInputs.push($updateSidebars.value);
			});

			var $sidebarInputsStr = $arraySidebarInputs.join(",");

			jQuery.ajax({
				type: "post",
				url: $AjaxUrl,
				data: {
					action: "sidebar_rm",
					sidebar: $sidebarInputsStr,
					sidebar_id: $sidebarId,
					sidebar_name: $sidebarName,
					_ajax_nonce: $ajaxNonce
				},
				beforeSend: function() {
					jQuery(".sidebar_rm_" + $sidebarId).css({display: ""}); //fadeIn loading just when link is clicked
				},
				success: function(html) { //so, if data is retrieved, store it in html
					jQuery("#sidebar_cell_" + $sidebarId).fadeOut("fast"); //animation
				}
			}); //close jQuery.ajax
			return false;
		});
	}
	//Google fonts preview
	function changegfont() {
		var str = "";
		jQuery("[id$=_gfont_title] option:selected,[id$=_logo_gfont] option:selected").each(function() {
			str += jQuery(this).text() + "";
		});
		if (str && str.length)
		{
			var link = ("<link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=" + str + "' media='screen' />");
			jQuery("head").append(link);
			jQuery(".gfont_preview").css("font-family", str);
		}

	}
	jQuery("[id$=_gfont_title],[id$=_logo_gfont]").closest("div").before('<div class="gfont_preview">The quick brown fox jumps over the lazy dog</div>');
	changegfont();
	jQuery("[id$=_gfont_title],[id$=_logo_gfont]").change(function() {
		changegfont();
	});


	jQuery("[id$=_gfont_title],[id$=_logo_gfont]").keyup(function() {
		changegfont();
	});


	jQuery("[id$=_gfont_title],[id$=_logo_gfont]").keydown(function() {
		changegfont();
	});

	/*
	 * Toggling group of elements.
	 */
	jQuery('label.toggle').click(function() {
		var ul = jQuery(this).closest('li').find('ul:first');
		if (ul && ul.length > 0)
		{
			jQuery(this).toggleClass('down');
			ul.toggle('slow');
		}
	});


	// Reset button check
	jQuery('.ml_reset').click(function(e) {
		e.preventDefault();
		var result = confirm("Reset all options?");
		if (result == true) {
			jQuery('#ml_reset').submit();
		}
	});

	sidebar_rm_ajax();
	file_up_ajax()
	file_rm_ajax();
	install_dummy();

	jQuery(".slide_rm").live("click", function() {
		jQuery(this).parent().remove();
	});
});