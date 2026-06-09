<?php
/**
 * Payment gateway interface.
 *
 * @package QuickDonate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contract for supported gateways.
 */
interface QuickDonate_Gateway_Interface {

	/**
	 * Return the gateway ID.
	 *
	 * @return string
	 */
	public function get_id();

	/**
	 * Return the gateway label.
	 *
	 * @return string
	 */
	public function get_label();

	/**
	 * Determine whether the gateway is configured.
	 *
	 * @param array $settings Plugin settings.
	 * @return bool
	 */
	public function is_configured( $settings );

	/**
	 * Return the frontend public key, if applicable.
	 *
	 * @param array $settings Plugin settings.
	 * @return string
	 */
	public function get_public_key( $settings );

	/**
	 * Verify a transaction reference server-side.
	 *
	 * @param string $reference Transaction reference.
	 * @param string $email     Donor email.
	 * @param int    $amount    Amount in smallest currency unit.
	 * @param string $currency  Currency code.
	 * @param array  $settings  Plugin settings.
	 * @return array|WP_Error
	 */
	public function verify_transaction( $reference, $email, $amount, $currency, $settings );
}
