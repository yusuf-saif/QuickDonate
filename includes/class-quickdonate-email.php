<?php
/**
 * Donor thank-you email handler.
 *
 * @package QuickDonate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles sending thank-you emails to donors.
 */
class QuickDonate_Email {

	/**
	 * Default email subject.
	 */
	const DEFAULT_SUBJECT = 'Thank you for your donation - {site_name}';

	/**
	 * Default email body.
	 */
	const DEFAULT_BODY = "Hi,\n\nThank you for your generous donation of {currency} {amount}.\nYour support means a lot to us.\n\nTransaction reference: {reference}\n\n- {site_name}";

	/**
	 * Send a thank-you email after verified success.
	 *
	 * @param string $donor_email Verified donor email.
	 * @param float  $amount      Amount in major currency units.
	 * @param string $currency    Currency code.
	 * @param string $reference   Transaction reference.
	 * @return bool
	 */
	public static function send( $donor_email, $amount, $currency, $reference ) {
		$settings = QuickDonate_Plugin::get_settings();

		if ( '1' !== $settings['email_enabled'] || ! is_email( $donor_email ) ) {
			return false;
		}

		$placeholders = array(
			'{amount}'    => number_format( (float) $amount, 2 ),
			'{currency}'  => sanitize_text_field( $currency ),
			'{email}'     => sanitize_email( $donor_email ),
			'{reference}' => sanitize_text_field( $reference ),
			'{site_name}' => wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
		);

		$subject = str_replace(
			array_keys( $placeholders ),
			array_values( $placeholders ),
			sanitize_text_field( $settings['email_subject'] ? $settings['email_subject'] : self::DEFAULT_SUBJECT )
		);

		$body = str_replace(
			array_keys( $placeholders ),
			array_values( $placeholders ),
			wp_kses_post( $settings['email_body'] ? $settings['email_body'] : self::DEFAULT_BODY )
		);

		$from_name  = $settings['email_from_name'] ? sanitize_text_field( $settings['email_from_name'] ) : wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
		$from_email = is_email( $settings['email_from_email'] ) ? sanitize_email( $settings['email_from_email'] ) : get_bloginfo( 'admin_email' );

		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			'From: ' . $from_name . ' <' . $from_email . '>',
		);

		return wp_mail( sanitize_email( $donor_email ), $subject, $body, $headers );
	}
}
