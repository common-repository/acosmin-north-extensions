<?php
/**
 * Instagram API
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

if( ! class_exists( 'Northe_API_Instagram' ) ) {
	/**
	 * Instagram Api, used in sections and widgets.
	 */
	class Northe_API_Instagram {

		/**
		 * @var Northe_API_Instagram The reference to *Singleton* instance of this class
		 */
		private static $instance;

		/**
		 * Instagram Access Token
		 *
		 * @var string
		 */
		protected $access_token;

		/**
		 * Returns the *Singleton* instance of this class.
		 *
		 * @return Northe_API_Instagram The *Singleton* instance.
		 */
		public static function getInstance()
		{
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		protected function __construct() {
			$options = get_option( 'northe-instagram-settings' );
			$this->access_token = $options[ 'access-token' ];
		}

		/**
		 * @param $screen_name string Instagram username
		 * @param $image_limit int    Number of images to retrieve
		 * @param $image_width int    Desired image width to retrieve
		 *
		 * @return array|bool Array of tweets or false if method fails
		 */
		public function get_items( $image_limit, $image_width ) {

			$transient = 'northe_instagram_is_configured';

			$response = wp_remote_get( sprintf( 'https://api.instagram.com/v1/users/self/media/recent/?access_token=%s&count=%s', $this->access_token, $image_limit ) );

			if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
				set_transient( $transient, false, MINUTE_IN_SECONDS );

				return false;
			}

			$data = json_decode( wp_remote_retrieve_body( $response ) );

			$result = array();
			$username = '';
			foreach ( $data->data as $item ) {

				if(empty($username)){
					$username = $item->user->username;
				}

				$result[] = array(
					'link'          => $item->link,
					'image-url'     => $item->images->{ $this->get_best_size( $image_width ) }->url,
					'image-caption' => !empty( $item->caption->text ) ? $item->caption->text : ''
				);
			}

			$result = array( 'items' => $result, 'username'=>$username );
			set_transient( $transient, $result, 30 * MINUTE_IN_SECONDS );

			return $result;
		}

		/**
		 * @param $screen_name string Instagram username
		 *
		 * @return bool|int Instagram user id or false on error
		 */
		protected function get_user_id( $screen_name ) {
			$user_id_option = 'northe_instagram_uid_' . $screen_name;

			if ( false !== ( $user_id = get_option( $user_id_option ) ) ) {
				return $user_id;
			}

			$response = wp_remote_get( sprintf( 'https://api.instagram.com/v1/users/search?q=%s&access_token=%s', $screen_name, $this->access_token ) );

			if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
				return false;
			}

			$result = json_decode( wp_remote_retrieve_body( $response ) );

			if ( ! isset( $result->data ) ) {
				return false;
			}

			$user_id = false;

			foreach ( $result->data as $user ) {
				if ( $user->username === $screen_name ) {
					$user_id = $user->id;

					break;
				}
			}

			update_option( $user_id_option, $user_id );

			return $user_id;
		}

		/**
		 * @param $desired_width int Desired image width in pixels
		 *
		 * @return string Image size for Instagram API
		 */
		protected function get_best_size( $desired_width ) {
			$size = 'thumbnail';
			$sizes = array(
				'thumbnail'           => 150,
				'low_resolution'      => 306,
				'standard_resolution' => 640
			);

			$diff = PHP_INT_MAX;

			foreach ( $sizes as $key => $value ) {
				if ( abs( $desired_width - $value ) < $diff ) {
					$size = $key;
					$diff = abs( $desired_width - $value );
				}
			}

			return $size;
		}

		/**
		 * Check if given access token is valid for Instagram Api.
		 */
		public static function is_access_token_valid( $access_token ) {
			$response = wp_remote_get( sprintf( 'https://api.instagram.com/v1/users/self/?access_token=%s', $access_token ) );

			if ( is_wp_error( $response ) ) {
				return $response;
			}

			if ( 200 != wp_remote_retrieve_response_code( $response ) ) {
				return false;
			}

			return true;
		}

		public function is_configured() {
			$transient = 'northe_instagram_is_configured';

			if ( false !== ( $result = get_transient( $transient ) ) ) {
				if ( 'yes' === $result ) {
					return true;
				}

				if ( 'no' === $result ) {
					return false;
				}
			}

			$condition = $this->is_access_token_valid( $this->access_token );

			if ( true === $condition ) {
				set_transient( $transient, 'yes', DAY_IN_SECONDS );

				return true;
			}

			set_transient( $transient, 'no', DAY_IN_SECONDS );

			return false;
		}

		public static function reset_cache() {
			delete_transient( 'northe_instagram_is_configured' );
		}

		public function get_access_token() {
			return $this->access_token;
		}

		public function set_access_token( $access_token ) {
			$this->access_token = $access_token;
		}

	}
}
