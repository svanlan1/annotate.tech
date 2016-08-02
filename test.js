$('input[data-val=' + localStorage.getItem('pin_size') + ']').prop('checked', true);

	var style = css($(".marker-res-type-issue"));
	if(!localStorage.getItem('head-style')) {

	}
	//$("#heading_style_current").css(style);
	for(var i in style) {
		var li = $('<li />').html('<span class="css-prop">' + i + '</span>: <span class="css-val">' + style[i] + '</span>').appendTo('#heading_style_current ul');
	}





	if(localStorage.getItem('use_bg') === 'true') {
		$('#box_bg_color_chk').prop('checked', true);
		$('.bg_color_show_hide').show();
		$('.border_width_example div').css({
			'background-color': localStorage.getItem('box_bg_color'),
			'opacity': '.3'
		});
	} else {
		$('#box_bg_color_chk').prop('checked', false);
		$('.border_width_example').css({
			'background-color': 'none',
			'opacity': '1.0'
		});
	}

	if(localStorage.getItem('show_tips') === 'true') {
		$('#show_tips-chk').prop('checked', true);
	}

	$('#show_tips-chk').change(function() {
		if($(this).prop('checked') === true) {
			localStorage.setItem('show_tips', 'true')
		} else {
			localStorage.setItem('show_tips', 'false');
		}
	})

	$('#box_bg_color_chk').click(function() {
		if($('.bg_color_show_hide').css('display') === 'none') {
			$('.bg_color_show_hide').show();
			localStorage.setItem('use_bg', 'true');
		} else {
			$('.bg_color_show_hide').hide();
			localStorage.setItem('use_bg', 'false');
			localStorage.setItem('box_bg_color', '');
		}
	});



	$('#change_rec_style').click(function() {
		if($(this).attr('aria-expanded') === 'false') {
			$('.default_options_a[aria-expanded=true]').attr('aria-expanded', 'false');
			$('#change_rec_style_div').slideDown('fast');
			$(this).attr('aria-expanded', 'true');
		} else {
			$('#change_rec_style_div').slideUp('slow');
			$(this).attr('aria-expanded', 'false');
		}
		
	});	


	

	$('input[name=pin_size]').click(function() {
		localStorage.setItem('pin_size', $(this).attr('data-val'));
	});

	if(localStorage.getItem('icon_pack_1') === 'true') {
		var icon_val = true;
	} else {
		var icon_val = false;
	}

	$('#icon_pack_1').prop('checked', icon_val).click(function() {
		if($(this).prop('checked') === true) {
			localStorage.setItem('icon_pack_1', 'true');
		} else {
			localStorage.setItem('icon_pack_1', 'false');
		}
	});


	$('#def_ops, #change_recs, #show_faq, #os_ops').click(function() {
		$('.split').hide();
		//if($(this).attr('aria-expanded') === 'false') {
			$('.tabs a').attr('aria-expanded', 'false');
			$('*').removeClass('tab-selected');
			$('#' + $(this).attr('aria-controls')).show();
			$(this).attr('aria-expanded', 'true');
			$(this).addClass('tab-selected');
		//} else {
			//$('#' + $(this).attr('aria-controls')).hide();
			//$(this).attr('aria-expanded', 'false');
		//}
	});

	$('.default_markers a').click(function(e) {
		$('*').removeClass('marker-flag-selected');
		$(this).addClass('marker-flag-selected');
		localStorage.setItem('flag-color', $(this).attr('data-val'));
		$('#default_pin').attr('src', 'images/pins/pin_24_' + localStorage.getItem('flag-color') + '.png').css('width', localStorage.getItem('pin_size'));
		savePresets();
	});

	$('#a11y').click(function() {
		localStorage.setItem('set', 'a11y');
		$('#marker_index_options').html('');
		loadOptions();
		savePresets();
	});

	$('#html').click(function(e) {
		localStorage.setItem('set', 'html');
		$('#marker_index_options').html('');
		loadOptions();
		savePresets();
	});

	$('#blank').click(function() {
		localStorage.setItem('set', 'blank');
		savePresets();
	});

	$('.marker_preset_reset_btn').click(function() {
		resetPresets();
		location.reload();
	});



	$('#marker_select_pin_width').change(function() {
		localStorage.setItem('pin_size', $(this).val() + 'px');
		$('#default_pin').css('width', localStorage.getItem('pin_size'));
	}).keydown(function(e) {
		if(e.which === 38) {
			if($(this).val() < 96) {
				localStorage.setItem('pin_size', parseInt($(this).val()) + 1 + 'px');
				$(this).val(parseInt($(this).val()) + 1);				
			} 
		} else if(e.which === 40) {
			if($(this).val() > 0) {
				localStorage.setItem('pin_size', $(this).val() - 1 + 'px');
				$(this).val($(this).val() - 1);					
			}
		}
		$('#default_pin').css('width', localStorage.getItem('pin_size'));
	}).bind('mousewheel', function(e){
        e.preventDefault();
        if(e.originalEvent.wheelDelta /120 > 0) {
			if($(this).val() < 96) {
				localStorage.setItem('pin_size', parseInt($(this).val()) + 1 + 'px');
				$(this).val(parseInt($(this).val()) + 1);				
			}
        }
        else{
			if($(this).val() > 0) {
				localStorage.setItem('pin_size', $(this).val() - 1 + 'px');
				$(this).val($(this).val() - 1);					
			}
        }
    });

	$('#marker_select_border_color').change(function() {
		localStorage.setItem('box_color', '#' + $(this).val());
		$('.border_width_example').css({
			'border': localStorage.getItem('box_width') + 'px solid ' +localStorage.getItem('box_color')
		});	
		showAlert();	
	});

	$('#marker_select_highlight_color').change(function() {
		localStorage.setItem('highlight_color', '#' + $(this).val());
		showAlert();
	});

	$("#marker_select_box_background").change(function() {
		localStorage.setItem('box_bg_color', '#' + $(this).val());
		$('.border_width_example div').css({
			'background-color': localStorage.getItem('box_bg_color'),
			'opacity': '.3'
		});		
	})

	$('#add-new-req ').click(function() {
		user_submitted++;
		var new_req = $('#marker_index_options p').eq(1).clone();
		if(new_req.length > 0) {
			$(new_req).find('a').text('User submitted rule').click(function() {
				if($(this).attr('aria-expanded') === 'false') {
					$(this).parent().find('input, textarea, button').show();
				} else {
					$(this).parent().find('input, textarea, button').hide();
				}
				
			});
			//$(new_req).find('input').attr('data-val').;
			$(new_req).find('input, textarea').attr('id', 'marker_options_textarea_usersubmitted_' + user_submitted).val('').css('display', 'block');
			$(new_req).find('label').attr('for', 'marker_options_textarea_usersubmitted_' + user_submitted).css('display', 'block');
			$(new_req).find('button').css('display', 'block');
			$(new_req).prependTo('#marker_index_options');
			$(new_req).find('button').click(function() {
				savePresets();
			});
		} else {
			//<a href="javascript:void(0);" class="marker_options_label_anchor" aria-expanded="true" style="display: block;">User submitted rule</a>
			var a = $('<a />').attr('href', 'javascript:void(0);').addClass('marker_options_label_anchor').attr('aria-expanded', 'true').css('display', 'block').text('User submitted rule ' + user_submitted).appendTo('#marker_index_options');
			var lname = $('<label />').attr('for', 'marker_options_input_add' + user_submitted).addClass('input-label').text('Value').appendTo('#marker_index_options').css('display', 'block');
			var name = $('<input />').addClass('marker_options_input marker').attr('id', 'marker_options_input_add' + user_submitted).attr('type', 'text').appendTo('#marker_index_options').css('display', 'block');

			var qNameL = $('<label />').addClass('input-label').css('display', 'block').attr('for', 'marker_options_textarea_usersubmitted_' + user_submitted).text('QuickName').appendTo('#marker_index_options');
			var qNameT = $('<textarea />').addClass('marker_options_input marker').attr({
				'aria-label': 'Quickname',
				'data-type': 'QuickName',
				'style': 'display: block;',
				'id': 'marker_options_textarea_usersubmitted_' + user_submitted
			}).appendTo('#marker_index_options');

			var recL = $('<label />').addClass('input-label').css('display', 'block').attr('for', 'marker_options_textarea_rec_usersubmitted_' + user_submitted).text('Recommendation').appendTo('#marker_index_options');
			var recT = $('<textarea />').addClass('marker_options_input marker').attr({
				'aria-label': 'Recommendation',
				'data-type': 'Recommendation',
				'style': 'display: block;',
				'id': 'marker_options_textarea_rec_usersubmitted_' + user_submitted
			}).appendTo('#marker_index_options');

			var exL = $('<label />').addClass('input-label').css('display', 'block').attr('for', 'marker_options_ex_textarea_usersubmitted_' + user_submitted).text('Example').appendTo('#marker_index_options');
			var exR = $('<textarea />').addClass('marker_options_input marker').attr({
				'aria-label': 'Example',
				'data-type': 'Example',
				'style': 'display: block;',
				'id': 'marker_options_ex_textarea_usersubmitted_' + user_submitted
			}).appendTo('#marker_index_options');

			//<button id="marker_save_btn_1" class="marker_preset_save_btn" style="display: block;">Save</button>
			var but = $('<button />').attr({
				'id': 'user_submitted_rule_save_btn_' + user_submitted,
				'class': 'marker_preset_save_btn',
				'style': 'display: block;'
			}).text('Save').click(function(e) {
				savePresets();
			}).appendTo('#marker_index_options');

			var butCan = $('<button />').attr({
				'id': 'user_submitted_rule_cancel_btn_' + user_submitted,
				'class': 'marker-remove-rec-link marker_preset_save_btn',
				'style': 'display: block;'
			}).text('Cancel').appendTo('#marker_index_options');					

		}
		
	});