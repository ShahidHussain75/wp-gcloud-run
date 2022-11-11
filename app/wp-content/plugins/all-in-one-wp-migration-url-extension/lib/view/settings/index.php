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

<div class="ai1wm-container">
	<div class="ai1wm-row">
		<div class="ai1wm-left">
			<div class="ai1wm-holder">
				<h1><i class="ai1wm-icon-gear"></i> <?php _e( 'URL Settings', AI1WMLE_PLUGIN_NAME ); ?></h1>
				<br />
				<br />

				<?php if ( Ai1wm_Message::has( 'success' ) ) : ?>
					<div class="ai1wm-message ai1wm-success-message">
						<p><?php echo Ai1wm_Message::get( 'success' ); ?></p>
					</div>
				<?php elseif ( Ai1wm_Message::has( 'error' ) ) : ?>
					<div class="ai1wm-message ai1wm-error-message">
						<p><?php echo Ai1wm_Message::get( 'error' ); ?></p>
					</div>
				<?php endif; ?>

				<?php if ( Ai1wm_Message::has( 'settings' ) ) : ?>
					<div class="ai1wm-message ai1wm-success-message">
						<p><?php echo Ai1wm_Message::get( 'settings' ); ?></p>
					</div>
				<?php endif; ?>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php?action=ai1wmle_url_settings' ) ); ?>">
					<article class="ai1wmle-article">
						<h3><?php _e( 'Transfer settings', AI1WMLE_PLUGIN_NAME ); ?></h3>
						<div class="ai1wm-field">
							<label><?php _e( 'Slow internet (Home)', AI1WMLE_PLUGIN_NAME ); ?></label>
							<input name="ai1wmle_url_file_chunk_size" min="5242880" max="20971520" step="5242880" type="range" value="<?php echo $file_chunk_size; ?>" id="ai1wmle-url-file-chunk-size" />
							<label><?php _e( 'Fast Internet (Internet Servers)', AI1WMLE_PLUGIN_NAME ); ?></label>
						</div>
					</article>

					<p>
						<button type="submit" class="ai1wm-button-blue" name="ai1wmle_url_update" id="ai1wmle-url-update">
							<i class="ai1wm-icon-database"></i>
							<?php _e( 'Update', AI1WMLE_PLUGIN_NAME ); ?>
						</button>
					</p>
				</form>
			</div>
		</div>
		<div class="ai1wm-right">
			<div class="ai1wm-sidebar">
				<div class="ai1wm-segment">
					<?php if ( ! AI1WM_DEBUG ) : ?>
						<?php include AI1WM_TEMPLATES_PATH . '/common/share-buttons.php'; ?>
					<?php endif; ?>

					<h2><?php _e( 'Leave Feedback', AI1WMLE_PLUGIN_NAME ); ?></h2>

					<?php include AI1WM_TEMPLATES_PATH . '/common/leave-feedback.php'; ?>
				</div>
			</div>
		</div>
	</div>
</div>
