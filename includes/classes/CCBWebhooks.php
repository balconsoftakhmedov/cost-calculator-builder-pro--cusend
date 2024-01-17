<?php

namespace cBuilder\Classes;

class CCBWebhooks {
	public static function init() {
		self::initialize_hooks();
	}

	public static function initialize_hooks() {
		add_action(
			'ccb_contact_form_message_template_before',
			function( $args, $calc_id ) {
				$calc_id      = intval( $calc_id );
				$ccb_settings = get_option( 'stm_ccb_form_settings_' . $calc_id );
				$settings     = ! empty( $ccb_settings['webhooks'] ) ? $ccb_settings['webhooks'] : array();
				if ( false === $settings['enableSendForms'] || empty( $settings['send_form_url'] ) ) {
					return;
				}
				$args       = self::format_form_data( $args );
				$secret_key = $settings['secret_key_send_form'] ?? '';
				$hook_type  = 'ccb_contact_form_message_template_before';
				$response   = self::send_request( $settings['send_form_url'], $args, $hook_type, $secret_key );
				if ( ! is_wp_error( $response ) ) {
					$response_code = wp_remote_retrieve_response_code( $response );
				} else {
					$error_message = $response->get_error_message();
				}
			},
			10,
			2
		);
		add_action(
			'ccb_payment_data_updated',
			function( $customer, $params, $order, $payment ) {
				$args = array(
					'customer' => $customer,
					'params'   => $params,
					'order'    => $order,
					'payment'  => $payment,
				);

				if ( ! isset( $params['calc_id'] ) ) {
					return;
				}

				$calc_id      = intval( $params['calc_id'] );
				$ccb_settings = get_option( 'stm_ccb_form_settings_' . $calc_id );
				$settings     = ! empty( $ccb_settings['webhooks'] ) ? $ccb_settings['webhooks'] : array();
				if ( ! isset( $settings['enablePaymentBtn'] ) || false === $settings['enablePaymentBtn'] || empty( $settings['payment_btn_url'] ) ) {
					return;
				}

				$data = self::format_payment_data( $args );

				$secret_key = $settings['secret_key_payment_btn'] ?? '';
				$hook_type  = 'ccb_payment_data_updated';
				$response   = self::send_request( $settings['payment_btn_url'], $data, $hook_type, $secret_key );

				if ( ! is_wp_error( $response ) ) {
					$response_code = wp_remote_retrieve_response_code( $response );
				} else {
					$error_message = $response->get_error_message();
				}
			},
			10,
			4
		);
		add_action(
			'ccb_after_send_invoice',
			function( $email_send, $user_email, $subject, $email_body, $headers, $string_attachment, $pdf_path, $id ) {
				$calc_id      = intval( $id );
				$ccb_settings = get_option( 'stm_ccb_form_settings_' . $calc_id );
				$settings     = ! empty( $ccb_settings['webhooks'] ) ? $ccb_settings['webhooks'] : array();
				if ( false === $settings['enableEmailQuote'] || empty( $settings['email_quote_url'] ) ) {
					return;
				}
				$boundary   = wp_generate_password( 24 );
				$data       = self::format_email_quote_data( $email_send, $user_email, $subject, $email_body, $headers, $string_attachment, $pdf_path, $id, $boundary );
				$secret_key = $settings['secret_key_email_quote'] ?? '';
				$hook_type  = 'ccb_after_send_invoice';
				$response   = self::send_request( $settings['email_quote_url'], $data, $hook_type, $secret_key, $boundary );
				if ( ! is_wp_error( $response ) ) {
					$response_code = wp_remote_retrieve_response_code( $response );
				} else {
					$error_message = $response->get_error_message();
				}
			},
			10,
			8
		);
	}

	public static function format_form_data( $args ) {
		$quotes        = array();
		$totals        = array();
		$files         = array();
		$labels_quotes = array();

		foreach ( $args['fields'] as $quote ) {
			$options        = array();
			$labels_options = array();
			if ( isset( $quote['options'] ) ) {
				foreach ( $quote['options'] as $option ) {
					if ( isset( $option['label'] ) ) {
						$label = $option['label'];
						// Check if the label already exists
						if ( isset( $labels_options[ $label ] ) ) {
							// Duplicate label found, generate a new key with "_1" suffix
							$counter = 1;
							do {
								$new_label = $label . '_' . $counter;
								++$counter;
							} while ( isset( $labels_options[ $new_label ] ) );

							$label = $new_label;
						}

						$labels_options[ $label ] = true;

						$options[ $label ] = array(
							'title' => $option['label'] ?? '',
							'value' => $option['value'] ?? '',
						);
					}
				}
			}
			$label = $quote['label'];
			if ( isset( $labels_quotes[ $label ] ) ) {
				$counter   = 1;
				$new_label = $label . '_' . $counter;
				do {
					$new_label = $label . '_' . $counter;
					++$counter;
				} while ( isset( $labels_quotes[ $new_label ] ) );
				$label = $new_label;
			}

			$labels_quotes[ $label ] = true;

			$quotes[ $label ] = array(
				'title'     => $quote['label'],
				'options'   => $options,
				'value'     => $quote['value'],
				'converted' => $quote['converted'],
			);
		}
		$customer = array(
			'name'    => $args['send_fields'][0]['value'],
			'email'   => $args['send_fields'][1]['value'],
			'phone'   => $args['send_fields'][2]['value'],
			'message' => $args['send_fields'][3]['value'],
		);
		foreach ( $args['totals'] as $total ) {
			$totals[ $total['title'] ] = array(
				'title'     => $total['title'],
				'value'     => preg_replace( '/[^\d.]+/', '', $total['value'] ),
				'converted' => $total['value'],
			);
		}
		foreach ( $args['files'] as $key => $value ) {
			foreach ( $value as $file ) {
				$files[] = array(
					'title'    => $key,
					'filename' => $file['filename'],
					'url'      => $file['url'],
					'type'     => $file['type'],
				);
			}
		}

		$data = array(
			'element'    => $quotes,
			'customer'   => $customer,
			'total'      => $totals,
			'files'      => $files,
			'created_at' => gmdate( 'Y-m-d H:i:s', time() ),
		);

		return $data;
	}

	public static function format_payment_data( $args ) {
		$quotes          = array();
		$totals          = array();
		$labels_options  = array();
		$labels_quotes   = array();
		$args['payment'] = json_decode( wp_json_encode( $args['payment'] ), true );
		foreach ( $args['params']['descriptions'] as $quote ) {
			$options = array();
			if ( isset( $quote['options'] ) ) {
				foreach ( $quote['options'] as $option ) {
					if ( isset( $option['label'] ) ) {
						$label = $option['label'];
						// Check if the label already exists
						if ( isset( $labels_options[ $label ] ) ) {
							// Duplicate label found, generate a new key with "_1" suffix
							$counter = 1;
							do {
								$new_label = $label . '_' . $counter;
								++$counter;
							} while ( isset( $labels_options[ $new_label ] ) );

							$label = $new_label;
						}

						$labels_options[ $label ] = true;

						$options[ $label ] = array(
							'title' => $option['label'] ?? '',
							'value' => $option['value'] ?? '',
						);
					}
				}
			}
			$label = $quote['label'];
			if ( isset( $labels_quotes[ $label ] ) ) {
				$counter = 1;
				do {
					$new_label = $label . '_' . $counter;
					++$counter;
				} while ( isset( $labels_quotes[ $new_label ] ) );
				$label = $new_label;
			}

			$labels_quotes[ $label ] = true;
			$quotes[ $label ]        = array(
				'title'     => $quote['label'],
				'options'   => $options,
				'value'     => $quote['value'],
				'converted' => $quote['converted'],
			);
		}
		foreach ( $args['params']['calcTotals'] as $total ) {
			$totals[ $total['label'] ] = array(
				'title'     => $total['label'],
				'value'     => $total['total'],
				'converted' => $total['converted'],
			);
		}
		$order_details = json_decode( $args['order']->order_details );
		$files         = array();
		foreach ( $order_details as $order_detail ) {
			if ( strpos( $order_detail->alias, 'file_upload_field' ) === 0 ) {
				$options = json_decode( $order_detail->options );
				foreach ( $options as $option ) {
					$files[] = array(
						'title'    => $order_detail->title,
						'filename' => basename( $option->file ),
						'type'     => $option->type,
						'url'      => $option->url,
					);
				}
			}
		}
		$data = array(
			'calc_id'        => $args['params']['calc_id'],
			'payment_id'     => $args['payment']['id'],
			'order_id'       => $args['payment']['order_id'],
			'calc_name'      => $args['params']['item_name'],
			'customer'       => $args['customer'],
			'element'        => $quotes,
			'total'          => $totals,
			'overall_total'  => $args['payment']['total'],
			'tax'            => $args['payment']['tax'],
			'status'         => $args['payment']['status'],
			'currency'       => $args['payment']['currency'],
			'created_at'     => $args['payment']['created_at'],
			'updated_at'     => $args['payment']['updated_at'],
			'payment_method' => $args['params']['method'],
			'files'          => $files,
		);

		return $data;
	}

	public static function format_email_quote_data( $email_send, $user_email, $subject, $email_body, $headers, $string_attachment, $pdf_path, $id, $boundary ) {
		$body         = '';
		$data['data'] = array(
			'email_send' => $email_send,
			'user_email' => $user_email,
			'subject'    => $subject,
			'email_body' => $email_body,
			'headers'    => $headers,
			'id'         => $id,
			'created_at' => gmdate( 'Y-m-d H:i:s', time() ),
		);

		foreach ( $data['data'] as $key => $element ) {
			$body .= '--' . $boundary . "\r\n";
			$body .= 'Content-Disposition: form-data; name="' . $key . '"' . "\r\n\r\n";
			$body .= $element . "\r\n";
		}
		$body .= '--' . $boundary . "\r\n";
		$body .= 'Content-Disposition: form-data; name="file"; filename="' . $string_attachment['filename'] . '"' . "\r\n";
		$body .= 'Content-Type: application/pdf' . "\r\n";
		$body .= "\r\n";
		$body .= file_get_contents( $pdf_path ) . "\r\n"; // phpcs:ignore

		$body .= '--' . $boundary . '--';

		return $body;
	}

	public static function send_demo_webhook() {
		check_ajax_referer( 'ccb_webhook_nonce', 'nonce' );
		if ( isset( $_POST['action'] ) && 'ccb_send_demo_webhook' === $_POST['action'] ) {
			$data           = json_decode( stripslashes( $_POST['data'] ) );
			$type           = filter_var( $data->type, FILTER_SANITIZE_STRING );
			$calc_id        = intval( filter_var( $_POST['calc_id'], FILTER_SANITIZE_STRING ) );
			$url            = filter_var( $data->url, FILTER_SANITIZE_STRING );
			$fields         = get_post_meta( $calc_id, 'stm-fields', true );
			$quotes         = array();
			$totals         = array();
			$labels_options = array();
			$labels_quotes  = array();
			$key            = 0;
			$total_key      = 'total_' . $key;
			foreach ( $fields as $quote ) {
				$options = array();
				if ( isset( $quote['options'] ) ) {
					foreach ( $quote['options'] as $option ) {
						// Check if the label already exists
						$label = $option['optionText'];
						if ( isset( $labels_options[ $label ] ) ) {
							// Duplicate label found, generate a new key with "_1" suffix
							$counter = 1;
							do {
								$new_label = $label . '_' . $counter;
								++$counter;
							} while ( isset( $labels_options[ $new_label ] ) );

							$label = $new_label;
						}

						$labels_options[ $label ] = true;
						$options[ $label ]        = array(
							'title' => $option['optionText'],
							'value' => $option['optionValue'],
						);
					}
				}

				$label = $quote['label'];
				if ( isset( $labels_quotes[ $label ] ) ) {
					$counter = 1;
					do {
						$new_label = $label . '_' . $counter;
						++$counter;
					} while ( isset( $labels_quotes[ $new_label ] ) );
					$label = $new_label;
				}

				$labels_quotes[ $label ] = true;

				$quotes[ $label ] = array(
					'title'     => $quote['label'],
					'options'   => $options,
					'value'     => 100,
					'converted' => '$100',
				);

				if ( 'Total' === $quote['type'] ) {
					$totals[ $quote['label'] ] = array(
						'title'     => $quote['label'],
						'value'     => '100',
						'converted' => '$100',
					);
				}
			}
			$customer     = array(
				'name'    => 'John Doe',
				'email'   => 'test@stylemixthemes.com',
				'phone'   => '+1111111111',
				'message' => 'This is a sample message',
			);
			$total        = 100;
			$payment_data = array(
				'payment_method' => 'stripe',
				'total'          => 100,
			);
			$files        = array(
				array(
					'title'    => 'file_upload_field_id_12',
					'filename' => 'image.png',
					'url'      => 'https://demo-webhsite.com/wp-content/uploads/2023/06/image.png',
					'type'     => 'image/png',
				),
				array(
					'title'    => 'file_upload_field_id_13',
					'filename' => 'file.pdf',
					'url'      => 'https://demo-webhsite.com/wp-content/uploads/2023/06/file.pdf',
					'type'     => 'application/pdf',
				),
			);

			if ( 'send-payment' === $type ) {
				$data = array(
					'calc_id'        => $calc_id,
					'calc_name'      => 'Demo Calculator',
					'customer'       => $customer,
					'element'        => $quotes,
					'total'          => $totals,
					'payment_method' => 'paypal',
				);
			} elseif ( 'send-form' === $type ) {
				$data = array(
					'element'    => $quotes,
					'customer'   => $customer,
					'total'      => $totals,
					'files'      => $files,
					'created_at' => gmdate( 'Y-m-d H:i:s', time() ),
				);

			} elseif ( 'send-email-quote' === $type ) {
				$data = array(
					'email_send'        => 1,
					'user_email'        => 'test@stylemixthemes.com',
					'subject'           => 'This is a demo subject',
					'email_body'        => 'This is a demo email body',
					'headers'           => 'From : John Doe <johndoe@stylemixthemes.com>',
					'string_attachment' => 'attachment.pdf',
					'id'                => $calc_id,
					'created_at'        => gmdate( 'Y-m-d H:i:s', time() ),
				);
			}
		}

		$response = wp_remote_post(
			$url,
			array(
				'body' => $data,
			)
		);
		if ( ! is_wp_error( $response ) ) {
			$response_code = wp_remote_retrieve_response_code( $response );
			if ( 200 === $response_code ) {
				$response['success'] = true;
				$response['message'] = 'Webhook sent successfully';
				$response            = wp_json_encode( $response );
			}
		} else {
			$error_message = $response->get_error_message();
		}
		echo esc_html( $response );
		die();
	}

	public static function send_request( $url, $data, $hook_type, $secret_key = '', $boundary = '' ) {
		$headers = array(
			'ccbsecretkey' => $secret_key,
		);

		if ( 'ccb_after_send_invoice' === $hook_type ) {
			$headers['content-type'] = 'multipart/form-data; boundary=' . $boundary;
		}
		$response = wp_remote_post(
			$url,
			array(
				'headers' => $headers,
				'body'    => $data,
			)
		);

		return $response;
	}


}
