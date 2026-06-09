<?php
/**
 * Paystack gateway integration.
 *
 * @package QuickDonate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Paystack gateway.
 */
class QuickDonate_Paystack_Gateway implements QuickDonate_Gateway_Interface {

	/**
	 * Verification endpoint.
	 */
	const VERIFY_URL = 'https://api.paystack.co/transaction/verify/';

	/**
	 * Return the gateway ID.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'paystack';
	}

	/**
	 * Return the gateway label.
	 *
	 * @return string
	 */
	public function get_label() {
		return __( 'Paystack', 'quickdonate' );
	}

	/**
	 * Determine whether the gateway is configured.
	 *
	 * @param array $settings Plugin settings.
	 * @return bool
	 */
	public function is_configured( $settings ) {
		return '' !== $this->get_public_key( $settings ) && '' !== $this->get_secret_key( $settings );
	}

	/**
	 * Return the current public key.
	 *
	 * @param array $settings Plugin settings.
	 * @return string
	 */
	public function get_public_key( $settings ) {
		$mode = isset( $settings['mode'] ) && 'live' === $settings['mode'] ? 'live' : 'test';

		return sanitize_text_field(
			'live' === $mode
				? ( $settings['public_key_live'] ?? '' )
				: ( $settings['public_key_test'] ?? '' )
		);
	}

	/**
	 * Verify a Paystack transaction reference.
	 *
	 * @param string $reference Transaction reference.
	 * @param string $email     Donor email.
	 * @param int    $amount    Amount in smallest currency unit.
	 * @param string $currency  Currency code.
	 * @param array  $settings  Plugin settings.
	 * @return array|WP_Error
	 */
	public function verify_transaction( $reference, $email, $amount, $currency, $settings ) {
		$secret_key = $this->get_secret_key( $settings );

		if ( '' === $secret_key ) {
			return new WP_Error(
				'gateway_not_configured',
				__( 'Payment gateway not configured. Please contact the site administrator.', 'quickdonate' ),
				array( 'status' => 500 )
			);
		}

		$response = wp_remote_get(
			self::VERIFY_URL . rawurlencode( $reference ),
			array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $secret_key,
					'Cache-Control' => 'no-cache',
				),
				'timeout' => 30,
			)
		);

		if ( is_wp_error( $response ) ) {
			return new WP_Error(
				'gateway_request_failed',
				__( 'Could not connect to the payment gateway. Please try again later.', 'quickdonate' ),
				array( 'status' => 502 )
			);
		}

		$body      = wp_remote_retrieve_body( $response );
		$http_code = (int) wp_remote_retrieve_response_code( $response );
		$data      = json_decode( $body, true );

		if (
			200 !== $http_code ||
			empty( $data['status'] ) ||
			true !== $data['status'] ||
			empty( $data['data']['status'] ) ||
			'success' !== $data['data']['status']
		) {
			$message = ! empty( $data['message'] ) ? sanitize_text_field( $data['message'] ) : __( 'Payment verification failed.', 'quickdonate' );

			return new WP_Error( 'verification_failed', $message, array( 'status' => 402 ) );
		}

		$verified_amount    = absint( $data['data']['amount'] ?? 0 );
		$verified_currency  = strtoupper( sanitize_text_field( $data['data']['currency'] ?? '' ) );
		$verified_reference = sanitize_text_field( $data['data']['reference'] ?? '' );
		$verified_email     = sanitize_email( $data['data']['customer']['email'] ?? '' );

		if (
			$verified_amount !== $amount ||
			$verified_currency !== $currency ||
			$verified_reference !== $reference ||
			$verified_email !== $email
		) {
			return new WP_Error(
				'mismatch',
				__( 'Payment verification details did not match. Transaction rejected.', 'quickdonate' ),
				array( 'status' => 402 )
			);
		}

		return array(
			'reference' => $verified_reference,
			'email'     => $verified_email,
			'amount'    => $verified_amount,
			'currency'  => $verified_currency,
			'status'    => 'success',
		);
	}

	/**
	 * Return the current secret key.
	 *
	 * @param array $settings Plugin settings.
	 * @return string
	 */
	private function get_secret_key( $settings ) {
		$mode = isset( $settings['mode'] ) && 'live' === $settings['mode'] ? 'live' : 'test';

		return sanitize_text_field(
			'live' === $mode
				? ( $settings['secret_key_live'] ?? '' )
				: ( $settings['secret_key_test'] ?? '' )
		);
	}
}
