<?php if ( in_array( CCC_Members::$member_pending, get_userdata( get_current_user_id() )->roles ) ) : ?>
	<p>We are reviewing your membership request. You will receive an email notification when your membership has been approved.</p>
<?php else : ?>
	<p>You need to be a member to access this page.</p>
	<form id="membership-request" method="post">
		<?php wp_nonce_field( 'ctdir_membership_request', 'ctdir_membership_request' ); ?>
		<input type="submit" name="submit" value="Request Site Membership" />
	</form>
<?php endif; ?>