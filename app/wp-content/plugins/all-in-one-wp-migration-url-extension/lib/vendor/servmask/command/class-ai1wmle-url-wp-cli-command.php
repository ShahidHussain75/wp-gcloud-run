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

if ( defined( 'WP_CLI' ) ) {
	class Ai1wmle_URL_WP_CLI_Command extends WP_CLI_Command {
		public function __construct() {
			if ( ! defined( 'AI1WM_PLUGIN_NAME' ) ) {
				WP_CLI::error_multi_line(
					array(
						__( 'URL Extension requires All-in-One WP Migration plugin to be activated. ', AI1WMLE_PLUGIN_NAME ),
						__( 'You can get a copy of it here: https://wordpress.org/plugins/all-in-one-wp-migration/', AI1WMLE_PLUGIN_NAME ),
					)
				);
				exit;
			}

			if ( is_multisite() && ! defined( 'AI1WMME_PLUGIN_NAME' ) ) {
				WP_CLI::error_multi_line(
					array(
						__( 'WordPress Multisite is supported via our All-in-One WP Migration Multisite Extension.', AI1WMLE_PLUGIN_NAME ),
						__( 'You can get a copy of it here: https://servmask.com/products/multisite-extension', AI1WMLE_PLUGIN_NAME ),
					)
				);
				exit;
			}

			if ( ! is_dir( AI1WM_STORAGE_PATH ) ) {
				if ( ! mkdir( AI1WM_STORAGE_PATH ) ) {
					WP_CLI::error_multi_line(
						array(
							sprintf( __( 'All-in-One WP Migration is not able to create <strong>%s</strong> folder.', AI1WMLE_PLUGIN_NAME ), AI1WM_STORAGE_PATH ),
							__( 'You will need to create this folder and grant it read/write/execute permissions (0777) for the All-in-One WP Migration plugin to function properly.', AI1WMLE_PLUGIN_NAME ),
						)
					);
					exit;
				}
			}

			if ( ! is_dir( AI1WM_BACKUPS_PATH ) ) {
				if ( ! mkdir( AI1WM_BACKUPS_PATH ) ) {
					WP_CLI::error_multi_line(
						array(
							sprintf( __( 'All-in-One WP Migration is not able to create <strong>%s</strong> folder.', AI1WMLE_PLUGIN_NAME ), AI1WM_BACKUPS_PATH ),
							__( 'You will need to create this folder and grant it read/write/execute permissions (0777) for the All-in-One WP Migration plugin to function properly.', AI1WMLE_PLUGIN_NAME ),
						)
					);
					exit;
				}
			}
		}

		/**
		 * Restores a backup from URL.
		 *
		 * ## OPTIONS
		 *
		 * <URL>
		 * : URL address of the .wpress backup file
		 *
		 * [--yes]
		 * : Automatically confirm the restore operation
		 *
		 * ## EXAMPLES
		 *
		 * $ wp ai1wm url restore 'https://drive.google.com/open?id=1KVl6lXQeTBmDdlZKX29IAoDbbz_CAxC8'
		 * Restore in progress...
		 * Restore complete.
		 *
		 * $ wp ai1wm url restore 'https://drive.google.com/open?id=1KVl6lXQeTBmDdlZKX29IAoDbbz_CAxC8' --yes
		 * @subcommand restore
		 */
		public function restore( $args = array(), $assoc_args = array() ) {
			if ( ! isset( $args[0] ) ) {
				WP_CLI::error_multi_line(
					array(
						__( 'A backup URL must be provided in order to proceed with the restore process.', AI1WMLE_PLUGIN_NAME ),
						__( 'Example: wp ai1wm url restore \'https://drive.google.com/open?id=1KVl6lXQeTBmDdlZKX29IAoDbbz_CAxC8\'', AI1WMLE_PLUGIN_NAME ),
					)
				);
				exit;
			}

			$params = array(
				'archive'    => ai1wm_storage_folder(),
				'storage'    => ai1wm_storage_folder(),
				'file_url'   => $args[0],
				'cli_args'   => $assoc_args,
				'secret_key' => get_option( AI1WM_SECRET_KEY, false ),
			);

			WP_CLI::log( 'Restore in progress...' );

			try {

				// Disable completed timeout
				add_filter( 'ai1wm_completed_timeout', '__return_zero' );

				// Run import filters
				$params = Ai1wm_Import_Controller::import( $params );

			} catch ( Exception $e ) {
				WP_CLI::error( __( sprintf( 'Unable to import: %s', $e->getMessage() ), AI1WM_PLUGIN_NAME ) );
				exit;
			}

			WP_CLI::success( 'Restore complete.' );
		}
	}
}
