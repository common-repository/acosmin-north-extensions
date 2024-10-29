/**
 * Instagram JS - Settings page
 *
 * Based on `Instagram Widget by WPZOOM` plugin (http://www.wpzoom.com/plugins/instagram-widget/)
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @author    WPZOOM (http://www.wpzoom.com/)
 * @copyright Copyright (C) 2008-2017 WPZOOM (http://www.wpzoom.com/)
 * @link      http://www.wpzoom.com/plugins/instagram-widget/
 * @link      https://wordpress.org/plugins/instagram-widget-by-wpzoom/
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since     1.0.0
 *
 * This file is a fork and may contain modifications of the original code
 */

'use strict';

jQuery(function($) {
	var hash = window.location.hash;

	if (hash.indexOf('access_token') > 0) {
		var input = $('#northe-instagram-settings_access-token');

		input.val(hash.split('=').pop());

		input.parents('form').find('#submit').click();
	}

	$('.northe-instagram-widget .button-connect').on('click', function(event) {
		if ($(this).find('.northe-instagarm-connected').length) {
			var confirm = window.confirm(northe_instagram_admin.i18n_connect_confirm);

			if (!confirm) {
				event.preventDefault();
			}
		}
	});
});
