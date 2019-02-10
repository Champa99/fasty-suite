
/**
 * @component admin/utils
 * @author Champa
 */

'use strict';

function initSubmenu(items, startActive = 1) {

	const $sub_menu = $("#sub_menu");
	const $submenu_hover = $(".submenu-hover");
	var dom = '';

	items.forEach(function(item) {
			
		if(item.parent == startActive) {
			dom += '<a href="' + item.link + '" class="submenu-item">' +
				'<i class="icon ' + item.icon + '"></i>' +
				item.text +
			'</a>';
		}
	});

	$sub_menu.html(dom);

	$submenu_hover.mouseover(function() {

		dom = '';
		var id = $(this).data('id');

		$submenu_hover.removeClass('active');
		$(this).addClass('active');

		items.forEach(function(item) {
			
			if(item.parent == id) {
				dom += '<a href="' + item.link + '" class="submenu-item">' +
					'<i class="icon ' + item.icon + '"></i>' +
					item.text +
				'</a>';
			}
		});

		$sub_menu.delay(500).queue(function() {
			$(this).html(dom);
		});
	});
}