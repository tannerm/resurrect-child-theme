<?php

/**
 * Dashboard
 *
 * Create a dashboard for managing accounts
 *
 * @package ccc
 * @since 0.1.0
 *
 */

new CCC_Dashboard();
class CCC_Dashboard {

	/**
	 * static variable for storing login/registration errors
	 *
	 * @var array
	 */
	public static $login_errors = array();

	function __construct(){
		add_action( 'template_redirect',        array( $this, 'member_request'         ) );
		add_action( 'update_user_meta',         array( $this, 'notify_member_accepted' ), 10, 4 );

		add_action( 'template_redirect',        array( $this, 'register_user'          ) );
	}

	/**
	 * Handle user registration
	 *
	 * @return bool
	 */
	function register_user() {

		/** make sure this is a registration submission */
		if ( empty( $_POST['ccc_register_user'] ) ) {
			return false;
		}

		/** Verify nonce */
		if ( ! wp_verify_nonce( $_POST['ccc_register_user'], 'ccc_register_user' ) ) {
			self::$login_errors['registration']['nonce_error'] = 'Something went wrong, please try again. If this issue persists let us know.';
			return false;
		}

		if ( ! empty( $_POST['username'] ) || ! empty( $_POST['password'] ) ) {
			self::$login_errors['registration']['honeypot'] = 'You are a robot... please leave';
			return false;
		}

		/** make sure we have the necessary information */
		if ( empty( $_POST['user_firstname'] ) || empty( $_POST['user_lastname'] ) || empty( $_POST['user_email'] ) || empty( $_POST['pass1'] ) || empty( $_POST['pass2'] ) ) {
			self::$login_errors['registration']['missing_information'] = 'It appears that some information is missing. Please make sure you have entered a valid first name, last name, email address, and password.';
			return false;
		}

		if ( $_POST['pass1'] !== $_POST['pass2'] ) {
			self::$login_errors['registration']['password_missmatch'] = 'Ooops! The two passwords that you entered did not match, please try again.';
			return false;
		}

		$user = array(
			'first_name'    => $_POST['user_firstname'],
			'last_name'     => $_POST['user_lastname'],
			'user_email'    => $_POST['user_email'],
			'user_login'    => $_POST['user_email'],
			'user_pass'     => $_POST['pass1'],
			'user_nicename' => $_POST['user_firstname'] . $_POST['user_lastname'],
			'display_name'  => strtolower( $_POST['user_firstname']. ' ' . substr( $_POST['user_lastname'], 0, 1 ) ),
		);

		/** attempt to register user */
		$user_id = wp_insert_user( $user );

		/** catch any errors */
		if ( is_wp_error( $user_id ) ) {
			if ( isset( $user_id->errors['invalid_email'] ) ) {
				self::$login_errors['registration']['invalid_email'] = 'The email you entered does not appear valid, please try again.';
			}

			if ( isset( $user_id->errors['username_exists'] ) || isset( $user_id->errors['existing_user_email'] ) ) {
				self::$login_errors['registration']['username_exists'] = 'The username or email you entered already exists. Would you like to <a href="' . wp_lostpassword_url( get_permalink() ) . '">reset your password</a>?';
			}

			return false;
		}

		add_user_to_blog( get_current_blog_id(), $user_id, get_site_option( 'default_user_role', 'subscriber' ) );

		$credentials = array(
			'user_login' => $_POST['user_email'],
			'user_password' => $_POST['pass1'],
		);

		wp_signon( $credentials );

		wp_redirect( add_query_arg( 'action', 'registered', get_permalink() ) );
		exit;
	}

	/**
	 * @param $meta_id
	 * @param $user_id
	 * @param $meta_key
	 * @param $new_role
	 */
	function notify_member_accepted( $meta_id, $user_id, $meta_key, $new_role ) {
		if ( 'wp_capabilities' !== $meta_key ) {
			return;
		}

		$userdata = get_userdata( $user_id );
		$old_role = array_shift( $userdata->roles );

		// We only care if member is being promoted from pending member to member
		if ( CCC_Members::$member_pending !== $old_role || ! isset( $new_role[CCC_Members::$member] ) ) {
			return;
		}

		wp_mail( $userdata->user_email, 'Membership Notification', 'Your account has been approved for membership.' );
	}

	/**
	 * Handle request for membership
	 */
	function member_request() {
		if ( empty( $_POST['ccc_membership_request'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['ccc_membership_request'], 'ccc_membership_request' ) ) {
			return;
		}

		wp_update_user( array( 'ID' => get_current_user_id(), 'role' => CCC_Members::$member_pending ) );
		wp_redirect( get_permalink() );
		exit;
	}

}

function ccc_login_form() {
	$text = "Login";

	if ( is_user_logged_in() ) {
		$user = get_user_by( 'id', get_current_user_id() );
		$text = "Welcome, " . ucwords( $user->display_name );
	}

	printf( '<a href="/wp-admin" class="el-icon-user resurrect-text-icon"> %s</a>', $text );

}

class CCC_Members {

	public static $member = 'ctdir_member';
	public static $member_pending = 'ctdir_member_pending';

	static function add_members_role() {
		add_role( self::$member,
			__( 'Member' ),
			array(
				'read'         => true,  // true allows this capability
				'edit_posts'   => true,
				'delete_posts' => false, // Use false to explicitly deny
			)
		);

		add_role(
			self::$member_pending,
			__( 'Pending Member' ),
			array(
				'read' => true,
			)
		);
	}

}
