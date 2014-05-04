<?php
$user_login = ( empty( $_POST['user_login'] ) ) ? '' : $_POST['user_login'];
$user_email = ( empty( $_POST['user_email'] ) ) ? '' : $_POST['user_email'];
$user_meta = array(
	'user_firstname' => array(
		'label'    => 'First Name',
		'required' => true,
	),
	'user_lastname'  => array(
		'label'    => 'Last Name',
		'required' => true,
	),
	'user_email'     => array(
		'label'    => 'Email',
		'required' => true,
	),
);
?>
<div id="ctdir_dashboard_login">
	<p>You must be logged in to access this page. Please login or register.</p>
	<div class="login form">
		<h3>Login:</h3>
		<form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
			<p>
				<label for="user_login"><?php _e('Username') ?><br />
					<input type="text" name="log" id="user_login" class="input" size="20" /></label>
			</p>
			<p>
				<label for="user_pass"><?php _e('Password') ?><br />
					<input type="password" name="pwd" id="user_pass" class="input" value="" size="25" /></label>
			</p>
			<?php do_action( 'login_form' ); ?>
			<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_attr_e('Remember Me'); ?></label></p>
			<p class="submit">
				<input type="submit" name="wp-submit" id="wp-submit" value="<?php esc_attr_e('Log In'); ?>" />
				<input type="hidden" name="redirect_to" value="<?php echo get_permalink(); ?>" />
				<input type="hidden" name="testcookie" value="1" />
			</p>
		</form>
	</div>

	<div class="registration form">
		<h3>Don't have an account? Please register below:</h3>
		<?php if ( ! empty( CCC_Dashboard::$login_errors['registration'] ) ) : ?>
			<div class="message error">
				<?php foreach( CCC_Dashboard::$login_errors['registration'] as $error ) : ?>
					<p><?php echo wp_kses_post( $error ); ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<form name="registerform" id="registerform" method="post">

			<input type="text" name="username" id="username" class="honeypot" />
			<input type="text" name="password" id="password" class="honeypot" />

			<?php
			foreach( $user_meta as $id => $meta ) : ?>
				<?php $value = ( empty( $_POST[$id] ) ) ? '' : $_POST[$id]; ?>
				<p>
					<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $meta['label'] ); ?><br />
						<input type="text" name="<?php echo esc_attr( $id ); ?>" id="<?php echo esc_attr( $id ); ?>" class="input" value="<?php echo esc_attr( $value ); ?>" size="25" /></label>
				</p>
			<?php endforeach; ?>
			<p>
				<label for="pass1"><?php _e('New password') ?><br />
					<input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" /></label>
			</p>

			<p>
				<label for="pass2"><?php _e('Confirm new password') ?><br />
					<input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" /></label>
			</p>

			<div id="pass-strength-result" class="hide-if-no-js"><?php _e('Strength indicator'); ?></div>
			<p class="description indicator-hint"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).'); ?></p>

			<input type="hidden" name="redirect_to" value="<?php echo get_permalink(); ?>?action=registered" />
			<?php wp_nonce_field( 'ccc_register_user', 'ccc_register_user' ); ?>
			<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" value="Register" /></p>
		</form>
	</div>
</div>