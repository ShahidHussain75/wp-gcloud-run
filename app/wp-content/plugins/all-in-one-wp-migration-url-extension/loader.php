<?php
/**
 * Copyright (C) 2014-2020 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}

// Include all the files that you want to load in here
if ( defined( 'WP_CLI' ) ) {
	require_once AI1WMLE_VENDOR_PATH .
				DIRECTORY_SEPARATOR .
				'servmask' .
				DIRECTORY_SEPARATOR .
				'command' .
				DIRECTORY_SEPARATOR .
				'class-ai1wmle-url-wp-cli-command.php';

	require_once AI1WMLE_VENDOR_PATH .
				DIRECTORY_SEPARATOR .
				'servmask' .
				DIRECTORY_SEPARATOR .
				'command' .
				DIRECTORY_SEPARATOR .
				'class-ai1wm-backup-wp-cli-command.php';
}

require_once AI1WMLE_CONTROLLER_PATH .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-main-controller.php';

require_once AI1WMLE_CONTROLLER_PATH .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-export-controller.php';

require_once AI1WMLE_CONTROLLER_PATH .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-import-controller.php';

require_once AI1WMLE_CONTROLLER_PATH .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-settings-controller.php';

require_once AI1WMLE_IMPORT_PATH .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-import-url.php';

require_once AI1WMLE_IMPORT_PATH .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-import-download.php';

require_once AI1WMLE_IMPORT_PATH .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-import-settings.php';

require_once AI1WMLE_IMPORT_PATH .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-import-database.php';

require_once AI1WMLE_MODEL_PATH .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-settings.php';

require_once AI1WMLE_VENDOR_PATH .
			DIRECTORY_SEPARATOR .
			'url-client' .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-url-client.php';

require_once AI1WMLE_VENDOR_PATH .
			DIRECTORY_SEPARATOR .
			'url-client' .
			DIRECTORY_SEPARATOR .
			'class-ai1wmle-url-curl.php';
