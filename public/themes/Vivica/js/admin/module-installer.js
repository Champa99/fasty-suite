
/**
 * @component admin/module-installer
 * @author Champa
 */

'use strict';

var uploadingModule = false;

jQuery(function($) {

	const $module_input = $(".module-input");
	const $module_installer = $("#module_installer");
	const $module_information = $("#module_information");
	const $module_input_fname = $("#module_input_fname");
	const $module_loader = $("#module_loader");

	// Functions

	window.status='Test';

	function startInstall(moduleName) {

		$.ajax({
			type: 'POST',
			url: '/admin/module/installer/2',
			data: {
				_token: _token,
				m_name: moduleName
			},
			success: function(res) {
				alert(res);
				$("body").append(res);
			}
		});
	}

	// Events

	$module_input.change(function(){

		if(!uploadingModule && $module_input.val() != '') {

			$module_installer.fadeOut("fast", function() {

				$module_loader.fadeIn("fast");
			});

			uploadingModule = true;

			var
				props = $(this).prop('files')[0],
				image_data = new FormData()

			image_data.append('file', props);
			image_data.append('_token', _token);

			$.ajax({
				url: '/admin/module/installer',
				type: 'POST',
				dataType: 'text',
				cache: false,
				contentType: false,
				processData: false,
				data: image_data,
				success: function(res) {

					$module_loader.fadeOut("fast", function() {

						$module_information.html(res);

						if($("#changes_window").is(":hidden")) {
			
							$("#changes_toggler").removeClass('active');
						} else {
					
							$("#changes_toggler").addClass('active');
						}

						$module_information.fadeIn("fast");
					});

					$module_input.val('');
					$module_input_fname.val('');

					uploadingModule = false;
				}
			});
		}
	});

	$(document).delegate('#changes_toggler', 'click', function() {

		var elem = $("#changes_window");

		elem.toggle();
		
		if(elem.is(":hidden")) {

			$(this).removeClass('active');
		} else {

			$(this).addClass('active');
		}
	});

	$(document).delegate('#install_module', 'click', function() {

		var m_name = $(this).data('m');

		if($(this).hasClass('conflict-install')) {
			Swal({
				title: 'Are you sure?',
				text: "Installing this module will replace some files that your application is already using",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'I know what I\'m doing, install it!',
			  }).then((result) => {

				if (result.value) {

					startInstall(m_name);
				}
			});
		} else {

			startInstall(m_name);
		}
	});

	$(document).delegate('#remove_module', 'click', function() {

		$.ajax({
			type: 'POST',
			url: '/admin/module/installer/remove',
			data: {
				_token: _token,
				m_name: $(this).data('m')
			},
			success: function() {

				Swal('Success!', 'Module successfully removed!', 'success');

				$module_information.fadeOut("fast", function() {

					$(this).html('');
					$module_installer.fadeIn("fast");
				});
			}
		});
	});
});