<?php

require_once( 'class-slack.php' );

class Strl_Error_Handler {
	public static function handle() {
		$error = error_get_last();
		if ( null === $error ) {
			return;
		}

		$siteurl  = get_bloginfo( 'wpurl' );
		$sitename = get_bloginfo( 'name' );
		$message  = Strl_Error_Handler::format( $error, $siteurl, $sitename );

		Strl_Error_Handler::send_slack_message( $message );
	}

	public static function format( $error, $siteurl, $sitename ) {
		$trace = print_r( debug_backtrace( false ), true );

		// $errno   = $error['type'];
		// $errfile = $error['file'];
		// $errline = $error['line'];
		$errstr  = $error['message'];
		$message = "Error in $siteurl [ *Error:* $errstr ]";
		return $message;
	}

	public static function send_slack_message( $text ) {
		$found         = false;
		$errormessages = array( '.bzr', 'en_dig.js', 'en_dlg.js', '/', 'is_dir(): open_basedir restriction in effect. File(/) is not within the allowed path(s):' );

		foreach ( $errormessages as $errormessage ) {
			if ( strpos( $text, $errormessage ) !== false ) {
				$found = true;
			}
		}

		if ( false === $found ) {
			// slack
			$slack = new Slack( 'https://hooks.slack.com/services/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' );

			// Create a new message
			$message = new SlackMessage( $slack );
			$message->setText( $text );

			// echo success or failure
			$message->send();
		}
	}
}

register_shutdown_function( array( 'Strl_Error_Handler', 'handle' ) );
