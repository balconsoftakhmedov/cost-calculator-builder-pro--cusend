<?php

namespace cBuilder\Classes;

use cBuilder\Classes\Database\Orders as OrdersModel;
use cBuilder\Classes\Database\Payments as PaymentModel;


class CCBPayments {
	public static $total;
	public static $calculatorId     = array();
	public static $params           = array();
	public static $paymentSettings  = array();
	public static $settings         = array();
	public static $general_settings = array();
	public static $customer         = array();
	public static $order            = array();
	public static $payment          = array();
	public static $errors           = array(
		'no_payment'  => 'No payment method',
		'no_action'   => 'No action',
		'no_nonce'    => 'nonce',
		'no_calc_id'  => 'No calculator id',
		'no_settings' => 'No settings',
		'no_order'    => 'Order not found',
	);
	protected static $paymentMethod = '';
	protected static $actionType    = 'render';

	/** @var \string[][]
	 * CCBWooCheckout not used here for now
	 */
	protected static $availablePayments = array(
		array(
			'name'  => 'paypal',
			'class' => 'cBuilder\Classes\Payments\CCBPayPal',
		),
		array(
			'name'  => 'stripe',
			'class' => 'cBuilder\Classes\Payments\CCBStripe',
		),
	);
	//protected static $permittedActions = array( 'ccb_payment' );
	//protected static $paymentNonce     = 'ccb_payment';


protected static $permittedActions = array('ccb_payment', 'ccb_paypal_payment', 'ccb_stripe_payment', 'calc_stripe_intent_payment' );



protected static $paymentNonce    = array(
		'paypal'       => 'ccb_paypal',
		'stripe'       => 'ccb_stripe',
		'woo_checkout' => 'ccb_woo_checkout',
		'ccb_payment' => 'ccb_payment',
	);
	/**
	 * return payment class from $availablePayments
	 * @return string
	 */
	private static function getPaymentClass() {
		$error = array(
			'status'  => 'error',
			'success' => false,
			'message' => self::$errors['no_payment'],
		);

		if ( ! array_key_exists( 'method', self::$params ) || ( array_key_exists( 'method', self::$params ) && ! in_array( self::$params['method'], array_column( self::$availablePayments, 'name' ), true ) ) ) {
			wp_send_json( $error );
		}
		$paymentKey = array_search( self::$params['method'], array_column( self::$availablePayments, 'name' ) );
		if ( false === $paymentKey ) {
			wp_send_json( $error );
		}

		if ( ! class_exists( self::$availablePayments[ $paymentKey ]['class'] ) ) {
			wp_send_json( $error );
		}

		return self::$availablePayments[ $paymentKey ]['class'];
	}

	/** render payment by cls */
	public static function renderPayment() {
		/** setPaymentData , generate all data */
		self::setPaymentData();

		$paymentCls = self::getPaymentClass();

		$result     = $paymentCls::{ self::$actionType }();

		wp_send_json( $result );
	}

	private static function validate() {

		if ( is_string( $_POST['data'] ) ) {
			self::$params = json_decode( str_replace( '\\', '', $_POST['data'] ), true );
		}

		/** check payment method */
		if ( ! array_key_exists( 'method', self::$params ) || ( array_key_exists( 'method', self::$params ) && ! in_array( self::$params['method'], array_column( self::$availablePayments, 'name' ), true ) ) ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_payment'],
				)
			);
		}

		self::$paymentMethod = self::$params['method'];

		/** check action */
		if ( ! array_key_exis![](../../../../themes/consulting-child/screenshot.png)ts( 'action', self::$params ) || ( array_key_exists( 'action', self::$params ) && ! in_array( self::$params['action'], self::$permittedActions, true ) ) ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_action'],
				)
			);
		}

		/** check nonce */
		if ( ! array_key_exists( 'nonce', self::$params ) || ( array_key_exists( 'nonce', self::$params ) && ! wp_verify_nonce( self::$params['nonce'], self::$paymentNonce ) ) ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_nonce'],
				)
			);
		}

		/** check calculator id */
		if ( ! array_key_exists( 'calcId', self::$params ) || ! self::$params['calcId'] ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_calc_id'],
				)
			);
		}

		if ( array_key_exists( 'action_type', self::$params ) && in_array( self::$params['action_type'], array( 'render', 'intent_payment' ) ) ) {
			self::$actionType = self::$params['action_type'];
		}
	}

	/** set and validate send data */
	public static function setPaymentData() {
		self::validate();

		self::$calculatorId    = self::$params['calcId'];
		self::$settings        = self::getSettings();
		self::$paymentSettings = self::getPaymentSettings();
		self::$total           = self::getTotal();

		if ( ! self::$paymentSettings ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_settings'],
				)
			);
			wp_die();
		}

		if ( ! is_null( self::$total ) && intval( self::$total ) <= 0 ) {
			wp_send_json(
				array(
					'success' => false,
					'status'  => 'error',
					'message' => __( 'Total must be more then 0', 'cost-calculator-builder-pro' ),
				)
			);
			wp_die();
		}

		if ( ! array_key_exists( 'order_id', self::$params ) || ! self::$params['order_id'] ) {
			wp_send_json(
				array(
					'success' => false,
					'status'  => 'error',
					'message' => self::$errors['no_order'],
				)
			);
			wp_die();
		}

		/** set payment method to order */
		self::$order = OrdersModel::get( 'id', self::$params['order_id'] );
		/** if order id exist, but order not found return error */
		if ( null === self::$order ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_order'],
				)
			);
		}

		self::$payment = PaymentModel::get( 'order_id', self::$params['order_id'] );

		/** if no payment , create */
		if ( null === self::$payment ) {
			self::createPayment();
		}

		self::$customer = self::getCustomerData();
		self::$payment  = self::updatePayment();

		do_action( 'ccb_payment_data_updated', self::$customer, self::$params, self::$order, self::$payment );
		self::updateOrder();
	}

	/** update order and payment rows statuses */
	public static function makePaid( $orderId, $paymentData ) {
		$orderId = sanitize_text_field( $orderId );

		try {
			OrdersModel::complete_order_by_id( $orderId );

			$paymentData['order_id']   = $orderId;
			$paymentData['status']     = PaymentModel::$completeStatus;
			$paymentData['updated_at'] = wp_date( 'Y-m-d H:i:s' );
			$paymentData['paid_at']    = wp_date( 'Y-m-d H:i:s' );

			$payment = PaymentModel::get( 'order_id', $orderId );
			if ( null === $payment ) {
				/** if no payment , create */
				$paymentData['created_at'] = wp_date( 'Y-m-d H:i:s' );
				PaymentModel::insert( $paymentData );
			} else {
				/** update if row exist */
				PaymentModel::update( $paymentData, array( 'order_id' => $orderId ) );
			}
		} catch ( Exception $e ) {
			// log here
			header( 'Status: 500 Server Error' );
		}
	}

	/** set payment transaction ( id from payment system ) */
	public static function setPaymentTransaction( $orderId, $transaction, $notes = array() ) {
		$orderId     = sanitize_text_field( $orderId );
		$transaction = sanitize_text_field( $transaction );
		$paymentData = array(
			'transaction' => sanitize_text_field( $transaction ),
			'updated_at'  => wp_date( 'Y-m-d H:i:s' ),
		);

		if ( ! empty( $notes ) ) {
			$paymentData['notes'] = serialize( array_map( 'sanitize_text_field', $notes ) ); // phpcs:ignore
		}

		PaymentModel::update( $paymentData, array( 'order_id' => $orderId ) );
	}

	protected static function getCustomerData() {
		if ( null === self::$order || ! is_object( self::$order ) || ! property_exists( self::$order, 'form_details' ) ) {
			return array();
		}

		$formDetails = json_decode( self::$order->form_details );
		if ( ! $formDetails || ! property_exists( $formDetails, 'fields' ) ) {
			return array();
		}

		$customer = array();
		foreach ( $formDetails->fields as $detail ) {
			$customer[ $detail->name ] = $detail->value;
		}

		do_action( 'ccb_get_customer_data', $customer );

		return $customer;
	}

	protected static function getSettings() {
		if ( empty( self::$settings ) ) {
			self::$settings = get_option( 'stm_ccb_form_settings_' . self::$calculatorId );
		}
		return self::$settings;
	}

	protected static function getGeneralSettings() {
		if ( empty( self::$general_settings ) ) {
			self::$general_settings = get_option( 'ccb_general_settings', CCBSettingsData::general_settings_data() );
		}
		return self::$general_settings;
	}

	protected static function getPaymentSettings() {
		$general_settings = self::getGeneralSettings();
		$settings         = self::getSettings();

		if ( ! empty( $general_settings[ self::$paymentMethod ] ) && ! empty( $general_settings[ self::$paymentMethod ]['use_in_all'] ) ) {
			foreach ( $general_settings[ self::$paymentMethod ] as $stripe_field_key => $stripe_field_value ) {
				if ( ! in_array( $stripe_field_key, array( 'enable', 'use_in_all' ), true ) ) {
					$settings[ self::$paymentMethod ][ $stripe_field_key ] = $stripe_field_value;
				}
			}
		}

		return isset( $settings[ self::$paymentMethod ] ) ? (array) $settings[ self::$paymentMethod ] : array();
	}

	protected static function getTotal() {
		$total = 0;
		if ( count( self::$params['calcTotals'] ) > 0 ) {
			foreach ( self::$params['calcTotals'] as $index => $value ) {
				$ccbDesc = null;
				if ( ! empty( self::$paymentSettings['formulas'] ) ) {
					foreach ( self::$paymentSettings['formulas'] as $formula ) {
						if ( isset( $formula['idx'] ) && intval( $index ) === intval( $formula['idx'] ) ) {
							$ccbDesc = true;
						}
					}
				}

				if ( ! is_null( $ccbDesc ) ) {
					$total += floatval( $value['total'] );
				}
			}
		}

		return $total;
	}

	protected static function updateOrder() {
		OrdersModel::update_order(
			array(
				'payment_method' => self::$paymentMethod,
			),
			self::$params['order_id']
		);
	}

	protected static function createPayment() {
		$paymentData = array(
			'type'     => self::$paymentMethod,
			'total'    => self::$total,
			'currency' => self::$settings['currency']['currency'],
		);
		PaymentModel::create_new_payment( $paymentData, self::$params['order_id'] );
	}

	protected static function updatePayment() {
		PaymentModel::update(
			array(
				'type'       => self::$paymentMethod,
				'updated_at' => wp_date( 'Y-m-d H:i:s' ),
			),
			array(
				'order_id' => self::$params['order_id'],
			)
		);

		return PaymentModel::get( 'order_id', self::$params['order_id'] );
	}
}
