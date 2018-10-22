
/**
 * @component login/index
 * @author Champa
 */

'use strict';

jQuery(function($) {

	const $login_form = $("#login_form");
	const $login_button = $("#login_button");
	const $login_window = $("#login_window");

	$login_form.submit(function(e) {

		e.preventDefault();

		$login_button.enableLoader(true);

		$.ajax({
			type: 'POST',
			url: '/login/auth',
			data: $(this).serialize(),
			success: function(res) {

				res = JSON.parse(res);

				switch(res.code) {

					case 1:
						redirect('/');
						break;

					default:
						$login_window.animateCss('shake');
						break;
				}

				$login_button.enableLoader(false);
			}
		});
	})
});