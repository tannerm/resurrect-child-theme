<?php

CCC_BP_Custom::get_instance();
class CCC_BP_Custom {

	/**
	 * @var
	 */
	protected static $_instance;

	/**
	 * Only make one instance of the CCC_BP_Custom
	 *
	 * @return CCC_BP_Custom
	 */
	public static function get_instance() {
		if ( ! self::$_instance instanceof CCC_BP_Custom ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Add Hooks and Actions
	 */
	protected function __construct() {
		add_action( 'bbp_new_topic', array( $this, 'new_topic_notify' ), 10, 4 );
	}

	public function new_topic_notify( $topic_id, $forum_id, $anonymous_data, $topic_author ) {
		$group_ids = bbp_get_forum_group_ids( $forum_id );
		$members = array();

		foreach( $group_ids as $id ) {
			$group_members = groups_get_group_members( array(
				'group_id' => $id,
				'exclude_admins_mods' => false,
			) );
			$members = array_merge( $members, $group_members['members'] );
		}

		foreach( $members as $member ) {
			$this->new_topic_notify_member( $member, $topic_id, $forum_id );
		}

	}

	protected function new_topic_notify_member( $user, $topic_id, $forum_id ) {
		ob_start();
		include( __DIR__ . '/email-templates/new_topic.php' );
		$content = ob_get_clean();
		$subject = sprintf( 'New Topic Posted In: %s', get_the_title( $forum_id ) );

		$headers = array( 'Content-Type: text/html; charset=UTF-8' );
		wp_mail( $user->email, $subject, $content, $headers );
	}

}