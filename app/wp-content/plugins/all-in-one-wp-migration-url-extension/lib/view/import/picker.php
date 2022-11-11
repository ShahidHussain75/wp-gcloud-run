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
?>

<div id="ai1wmle-import-modal" class="ai1wmle-modal-container" role="dialog" tabindex="-1">
	<div class="ai1wmle-modal-action">
		<form v-on:submit.prevent="restore(file)">
			<h2><?php _e( 'Import from URL', AI1WMLE_PLUGIN_NAME ); ?></h2>
			<p>
				<label for="ai1wmle-import-url">
					<input type="url" class="ai1wmle-import-url" id="ai1wmle-import-url" v-on:input="browse($event)" placeholder="<?php _e( 'Please enter URL address of the .wpress backup file', AI1WMLE_PLUGIN_NAME ); ?>" />
				</label>
			</p>
			<p>
				<button type="button" class="ai1wm-button-red" id="ai1wmle-import-file-cancel" v-on:click="cancel">
					<i class="ai1wm-icon-notification"></i>
					<?php _e( 'Cancel', AI1WMLE_PLUGIN_NAME ); ?>
				</button>
				<template v-if="file">
					<button type="submit" class="ai1wm-button-green" id="ai1wmle-import-file" v-if="file.target.value">
						<i class="ai1wm-icon-publish"></i>
						<?php _e( 'Import', AI1WMLE_PLUGIN_NAME ); ?>
					</button>
				</template>
			</p>
		</form>
	</div>
</div>

<div id="ai1wmle-import-overlay" class="ai1wmle-overlay"></div>
