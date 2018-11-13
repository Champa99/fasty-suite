
/**
 * @component login/index
 * @author Champa
 */

'use strict';

jQuery(function($) {

	const $login_form = $("#login_form");
	const $login_button = $("#login_button");
	const $login_modul_holder = $("#login_modul_holder");
	const $wrong_credentials = $("#wrong_credentials");

	$login_form.submit(function(e) {

		e.preventDefault();

		$wrong_credentials.removeClass('open');
		$login_button.enableLoader(true);

		$.ajax({
			type: 'POST',
			url: '/login/auth',
			data: $(this).serialize(),
			success: function(res) {

				res = JSON.parse(res);

				switch(res.code) {

					case 1:
						redirect(res.payload);
						break;

					default:
						$login_modul_holder.animateCss('shake', function() {

							$wrong_credentials.addClass('open');
						});
						break;
				}

				$login_button.enableLoader(false);
			}
		});
	})
});