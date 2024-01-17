<?php

namespace cBuilder\Classes\Payments;

use cBuilder\Classes\CCBPayments;
use cBuilder\Classes\Database\Payments;

class CCBStripe extends CCBPayments {

	private static $token;
	private static $defaultCurrency = 'usd';
	private static $url             = 'https://api.stripe.com/v1/payment_intents/';

	public static function intent_payment() {
		parent::setPaymentData();
		if ( array_key_exists( 'paymentIntentId', self::$params ) && ! empty( self::$params['paymentIntentId'] ) ) {
			// Confirm the PaymentIntent to finalize payment after handling a required action
			$retrieve = wp_remote_get(
				esc_url( self::$url . self::$params['paymentIntentId'] ),
				array(
					'headers' => array(
						'Authorization' => 'Bearer ' . self::$paymentSettings['secretKey'],
					),
				)
			);
			$retrieve = wp_remote_retrieve_body( $retrieve );
			$retrieve = json_decode( $retrieve, true );

			$request = wp_remote_post(
				esc_url( self::$url . $retrieve['id'] . '/confirm' ),
				array( 'headers' => array( 'Authorization' => 'Bearer ' . self::$paymentSettings['secretKey'] ) )
			);
		}

		if ( array_key_exists( 'paymentMethodId', self::$params ) && ! empty( self::$params['paymentMethodId'] ) ) {
			// Create new PaymentIntent with a PaymentMethod ID from the client.
			$calculatorTitle        = get_post_meta( self::$calculatorId, 'stm-name', true );
			$metaData               = self::$customer;
			$metaData['order_id']   = self::$params['order_id'];
			$metaData['calculator'] = $calculatorTitle;

			/** set order details to metadata */
			if ( null !== self::$order && is_object( self::$order ) && property_exists( self::$order, 'order_details' ) ) {
				foreach ( json_decode( self::$order->order_details ) as $detail ) {

					/** remove text field from send data */
					if ( 'text' === preg_replace( '/\_field_id.*/', '', $detail->alias ) ) {
						continue;
					}

					$summary_value = number_format( (float) $detail->value, 2, '.', '' );
					if ( property_exists( $detail, 'summary_view' ) && property_exists( $detail, 'extraView' ) ) {
						if ( 'show_label_not_calculable' === $detail->summary_view ) {
							$summary_value = $detail->extraView;
						} elseif ( 'show_label_calculable' === $detail->summary_view ) {
							$summary_value = '(' . $detail->extraView . ') ' . $summary_value;
						}
					}
					$metaData[ $detail->title ] = $summary_value;
				}
			}

			$metaData = self::meta_data_filter( $metaData );

			if ( isset( self::$params['order_id'] ) ) {
				Payments::update_payment_total_by_order_id( self::$params['order_id'], floatval( self::$total ) );
			}

			$sum = str_replace( '.', '', floatval( self::$total ) * 100 );

			$args = array(
				'amount'              => substr( $sum, 0, 8 ),
				'currency'            => isset( self::$paymentSettings['currency'] ) ? self::$paymentSettings['currency'] : self::$defaultCurrency,
				'payment_method'      => self::$params['paymentMethodId'],
				'confirmation_method' => 'manual',
				'confirm'             => 'true',
				'description'         => __( 'Calculator', 'cost-calculator-builder-pro' ) . ' - ' . $calculatorTitle,
				'metadata'            => $metaData,
			);

			$request = wp_remote_post(
				rtrim( self::$url, '/' ),
				array(
					'headers' => array( 'Authorization' => 'Bearer ' . self::$paymentSettings['secretKey'] ),
					'body'    => $args,
				)
			);
		}

		$response = wp_remote_retrieve_body( $request );
		$response = json_decode( $response, true );

		if ( ! empty( $response['error'] ) ) {
			return array(
				'success' => false,
				'status'  => 'error',
				'message' => $response['error']['message'],
			);
		}

		wp_send_json( self::parse_response( $response ) );
	}

	/**
	 * Generate and Return Response
	 *
	 * @param $request
	 */
	public static function parse_response( $response ) {
		$result = array( 'success' => false );
		switch ( $response['status'] ) {
			case 'requires_action':
			case 'requires_source_action':
				/** Card requires authentication **/
				$result['success']         = true;
				$result['status']          = 'success';
				$result['requiresAction']  = true;
				$result['paymentIntentId'] = $response['id'];
				$result['clientSecret']    = $response['client_secret'];
				break;
			case 'requires_payment_method':
			case 'requires_source':
				/**  Card was not properly authenticated, suggest a new payment method **/
				$result['status']  = 'error';
				$result['message'] = __( 'Your card was denied, please provide a new payment method!', 'cost-calculator-builder-pro' );
				break;
			case 'succeeded':
				/**  Payment is complete, authentication not required **/
				$result['success']      = true;
				$result['status']       = 'success';
				$result['clientSecret'] = $response['client_secret'];
				$orderId                = $response['metadata']['order_id'];

				CCBPayments::setPaymentTransaction( $orderId, $response['id'], $response );
		}

		return $result;
	}

	public static function render() {
		self::$token = ( ! empty( self::$params['token_id'] ) ) ? self::$params['token_id'] : '';
		$request     = wp_remote_get(
			esc_url( self::$url . self::$token ),
			array(
				'headers' => array( 'Authorization' => 'Bearer ' . self::$paymentSettings['secretKey'] ),
			)
		);

		$request = wp_remote_retrieve_body( $request );
		$request = json_decode( $request, true );

		/* Check if paid */
		if ( ! empty( $request['status'] ) && ! empty( $request['amount'] ) && $request['status'] == 'succeeded' && $request['amount'] == floatval( self::$total ) * 100 ) { // phpcs:ignore
			$paymentData = array(
				'type'     => 'stripe',
				'currency' => self::$settings['currency']['currency'],
				'total'    => self::$total,
			);

			CCBPayments::makePaid( self::$params['order_id'], $paymentData );

			return array(
				'success' => true,
				'reload'  => true,
				'status'  => 'success',
				'message' => esc_html__( 'Payment Received! Thank You for Payment', 'cost-calculator-builder-pro' ),
			);
		}

		return array(
			'success' => false,
			'reload'  => false,
			'status'  => 'error',
			'message' => esc_html__( 'Error occurred. Please try again', 'cost-calculator-builder-pro' ),
		);
	}

	public static function meta_data_filter( $data ) {
		$result = array();
		foreach ( $data as $key => $value ) {
			$data_key            = strlen( $key ) > 40 ? substr( $key, 0, 37 ) . '...' : $key;
			$result[ $data_key ] = $value;
		}
		return $result;
	}
}
