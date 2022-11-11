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

class Ai1wmle_URL_Client {

	/**
	 * File URL
	 *
	 * @var string
	 */
	protected $file_url = null;

	public function __construct( $url ) {
		$this->file_url = $url;
	}

	/**
	 * Set file URL
	 *
	 * @param  string $url URL string
	 * @return void
	 */
	public function set_file_url( $url ) {
		$this->file_url = $url;
	}

	/**
	 * Get file URL
	 *
	 * @return string
	 */
	public function get_file_url() {
		return $this->file_url;
	}

	/**
	 * Get scheme
	 *
	 * @return string
	 */
	public function get_scheme() {
		return parse_url( $this->file_url, PHP_URL_SCHEME );
	}

	/**
	 * Get hostname
	 *
	 * @return string
	 */
	public function get_hostname() {
		return parse_url( $this->file_url, PHP_URL_HOST );
	}

	/**
	 * Get port
	 *
	 * @return integer
	 */
	public function get_port() {
		return parse_url( $this->file_url, PHP_URL_PORT );
	}

	/**
	 * Get username
	 *
	 * @return string
	 */
	public function get_username() {
		return parse_url( $this->file_url, PHP_URL_USER );
	}

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function get_password() {
		return parse_url( $this->file_url, PHP_URL_PASS );
	}

	/**
	 * Get path
	 *
	 * @return string
	 */
	public function get_path() {
		return parse_url( $this->file_url, PHP_URL_PATH );
	}

	/**
	 * Get query
	 *
	 * @return string
	 */
	public function get_query() {
		return parse_url( $this->file_url, PHP_URL_QUERY );
	}

	/**
	 * Get effective URL
	 *
	 * @return string
	 */
	public function get_effective_url() {
		$api = new Ai1wmle_URL_Curl;
		$api->set_base_url( $this->file_url );
		$api->set_effective_url( $this->file_url );
		$api->set_option( CURLOPT_HEADER, true );
		$api->set_option( CURLOPT_NOBODY, true );

		try {
			$api->make_request();
		} catch ( Ai1wmle_Error_Exception $e ) {
			// 405 Method Not Allowed
		}

		return $api->get_effective_url();
	}

	/**
	 * Get file size
	 *
	 * @return integer
	 */
	public function get_file_size() {
		$api = new Ai1wmle_URL_Curl;
		$api->set_base_url( $this->file_url );
		$api->set_option( CURLOPT_HEADER, true );
		$api->set_option( CURLOPT_NOBODY, true );

		try {
			$api->make_request();
		} catch ( Ai1wmle_Error_Exception $e ) {
			// 405 Method Not Allowed
		}

		return $api->get_content_length();
	}

	/**
	 * Get file ranges
	 *
	 * @return string
	 */
	public function get_file_ranges() {
		$api = new Ai1wmle_URL_Curl;
		$api->set_base_url( $this->file_url );
		$api->set_option( CURLOPT_HEADER, true );
		$api->set_option( CURLOPT_NOBODY, true );

		try {
			$response = $api->make_request();
		} catch ( Ai1wmle_Error_Exception $e ) {
			// 405 Method Not Allowed
		}

		if ( isset( $response['accept-ranges'] ) ) {
			return $response['accept-ranges'];
		}
	}

	/**
	 * Get file cookies
	 *
	 * @param  string $cookies_path Cookies path
	 * @return string
	 */
	public function get_file_cookies( $cookies_path = null ) {
		$api = new Ai1wmle_URL_Curl;
		$api->set_base_url( $this->file_url );
		$api->set_option( CURLOPT_HEADER, true );
		$api->set_option( CURLOPT_NOBODY, true );
		$api->set_option( CURLOPT_COOKIEJAR, $cookies_path );

		// The name of a file to save all internal cookies to when the handle is closed,
		// e.g. after a call to curl_close.
		if ( $cookies_path ) {
			$api->set_option( CURLOPT_COOKIEJAR, $cookies_path );
		}

		try {
			$response = $api->make_request();
		} catch ( Ai1wmle_Error_Exception $e ) {
			// 405 Method Not Allowed
		}

		$api->close_connection();

		if ( isset( $response['set-cookie'] ) ) {
			return $response['set-cookie'];
		}
	}

	/**
	 * Get WeTransfer CSRF token
	 *
	 * @return string
	 */
	public function get_wetransfer_csrf_token() {
		$api = new Ai1wmle_URL_Curl;
		$api->set_base_url( $this->file_url );

		try {
			$response = $api->make_request();
		} catch ( Ai1wmle_Error_Exception $e ) {
			throw $e;
		}

		$matches = array();
		if ( preg_match( '/name="csrf-token" content="([^"]+)"/i', $response, $matches ) ) {
			if ( isset( $matches[1] ) ) {
				return $matches[1];
			}
		}
	}

	/**
	 * Get WeTransfer direct link
	 *
	 * @param  string $csrf_token    CSRF Token
	 * @param  string $security_hash Security hash
	 * @param  string $recipient_id  Recipient ID
	 * @return string
	 */
	public function get_wetransfer_direct_link( $csrf_token, $security_hash, $recipient_id = '' ) {
		if ( empty( $recipient_id ) ) {
			$post = array(
				'intent'        => 'entire_transfer',
				'security_hash' => $security_hash,
			);
		} else {
			$post = array(
				'intent'        => 'entire_transfer',
				'security_hash' => $security_hash,
				'recipient_id'  => $recipient_id,
			);
		}

		$api = new Ai1wmle_URL_Curl;
		$api->set_base_url( $this->file_url );
		$api->set_header( 'Content-Type', 'application/json' );
		$api->set_header( 'x-csrf-token', $csrf_token );
		$api->set_header( 'x-requested-with', 'XMLHttpRequest' );
		$api->set_option( CURLOPT_POST, true );
		$api->set_option( CURLOPT_POSTFIELDS, json_encode( $post ) );

		try {
			$response = $api->make_request( true );
		} catch ( Ai1wmle_Error_Exception $e ) {
			throw $e;
		}

		if ( isset( $response['direct_link'] ) ) {
			return $response['direct_link'];
		}
	}

	/**
	 * Get pCloud direct link
	 *
	 * @return string
	 */
	public function get_pcloud_direct_link() {
		$api = new Ai1wmle_URL_Curl;
		$api->set_base_url( $this->file_url );
		$api->set_header( 'Content-Type', 'application/json' );

		try {
			$response = $api->make_request( true );
		} catch ( Ai1wmle_Error_Exception $e ) {
			throw $e;
		}

		if ( isset( $response['hosts'][0] ) ) {
			if ( isset( $response['path'] ) ) {
				return 'https://' . $response['hosts'][0] . $response['path'];
			}
		}
	}

	/**
	 * Download file
	 *
	 * @param  string  $file_path    File path
	 * @param  string  $cookies_path Cookies path
	 * @return boolean
	 */
	public function download_file( $file_path, $cookies_path = null ) {
		if ( ( $file_stream = fopen( $file_path, 'wb' ) ) ) {
			rewind( $file_stream );

			// Download file to file stream
			$api = new Ai1wmle_URL_Curl;
			$api->set_base_url( $this->file_url );
			$api->set_option( CURLOPT_FILE, $file_stream );

			// The name of the file containing the cookie data. The cookie file can be in Netscape format,
			// or just plain HTTP-style headers dumped into a file. If the name is an empty string,
			// no cookies are loaded, but cookie handling is still enabled.
			if ( is_file( $cookies_path ) ) {
				$api->set_option( CURLOPT_COOKIEFILE, $cookies_path );
			}

			/**
			 * The $handler parameter was added in PHP version 5.5.0 breaking backwards compatibility.
			 * If we are using PHP version lower than 5.5.0, we need to shift the arguments.
			 *
			 * @see http://php.net/manual/en/function.curl-setopt.php#refsect1-function.curl-setopt-changelog
			 */
			if ( version_compare( PHP_VERSION, '5.5.0', '>=' ) ) {
				$api->set_option( CURLOPT_NOPROGRESS, false );
				$api->set_option( CURLOPT_PROGRESSFUNCTION, array( $this, 'download_file_progress_callback_php55' ) );
			} elseif ( version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
				$api->set_option( CURLOPT_NOPROGRESS, false );
				$api->set_option( CURLOPT_PROGRESSFUNCTION, array( $this, 'download_file_progress_callback_php53' ) );
			}

			try {
				$api->make_request();
			} catch ( Ai1wmle_Error_Exception $e ) {
				throw $e;
			}

			fclose( $file_stream );
		}

		return true;
	}

	/**
	 * Download file progress callback (PHP >= 5.5.0)
	 *
	 * @param  resource $handler              cURL handler
	 * @param  integer  $download_file_size   Download file size
	 * @param  integer  $download_file_offset Download file offset
	 * @param  integer  $upload_file_size     Upload file size
	 * @param  integer  $upload_file_offset   Upload file offset
	 * @return integer
	 */
	public function download_file_progress_callback_php55( $handler, $download_file_size, $download_file_offset, $upload_file_size, $upload_file_size_offset ) {
		if ( $download_file_size > 0 ) {
			// Get progress
			$progress = (int) ( ( $download_file_offset / $download_file_size ) * 100 );

			// Set progress
			Ai1wm_Status::progress( $progress );
		}

		return 0;
	}

	/**
	 * Download file progress callback (PHP >= 5.3.0, PHP <= 5.5.0)
	 *
	 * @param  integer  $download_file_size   Download file size
	 * @param  integer  $download_file_offset Download file offset
	 * @param  integer  $upload_file_size     Upload file size
	 * @param  integer  $upload_file_offset   Upload file offset
	 * @return integer
	 */
	public function download_file_progress_callback_php53( $download_file_size, $download_file_offset, $upload_file_size, $upload_file_size_offset ) {
		if ( $download_file_size > 0 ) {
			// Get progress
			$progress = (int) ( ( $download_file_offset / $download_file_size ) * 100 );

			// Set progress
			Ai1wm_Status::progress( $progress );
		}

		return 0;
	}

	/**
	 * Download file chunk
	 *
	 * @param  resource $file_stream      File stream
	 * @param  integer  $file_range_start File range start
	 * @param  integer  $file_range_end   File range end
	 * @return boolean
	 */
	public function download_file_chunk( $file_stream, $file_range_start = 0, $file_range_end = 0 ) {
		$api = new Ai1wmle_URL_Curl;
		$api->set_base_url( $this->file_url );
		$api->set_option( CURLOPT_RANGE, sprintf( '%d-%d', $file_range_start, $file_range_end ) );

		try {
			$file_chunk_data = $api->make_request();
		} catch ( Ai1wmle_Error_Exception $e ) {
			throw $e;
		}

		// Copy file chunk data into file stream
		if ( fwrite( $file_stream, $file_chunk_data ) === false ) {
			throw new Ai1wmle_Error_Exception( __( 'Unable to save the file from URL address', AI1WMLE_PLUGIN_NAME ) );
		}

		return true;
	}
}
