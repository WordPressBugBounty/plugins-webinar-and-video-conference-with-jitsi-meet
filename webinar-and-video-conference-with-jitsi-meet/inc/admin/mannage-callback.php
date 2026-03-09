<?php
/**
 * If direct access than exit the file.
 *
 * @package JITSI_MEET_WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class mannage callback
 */
class Mannage_Callback {
	/**
	 * Checkbox sanitize
	 *
	 * @param   boolean $input  input sanitize.
	 *
	 * @return  boolean
	 */
	public function checkboxsanitize( $input ) {
		return ( isset( $input ) ? true : false );
	}

	/**
	 * Jitsi_settings_callback
	 *
	 * @param string $input  Input.
	 *
	 * @return  $input
	 */
	public function jitsi_settings_callback( $input ) {
		return $input;
	}

	/**
	 * Jitsi general
	 *
	 * @param array $args  args array.
	 *
	 * @return void
	 */
	public function jitsi_general( $args ) {
		$name        = $args['label_for'];
		$default     = isset( $args['default'] ) ? $args['default'] : '';
		$value       = get_option( $name, $default ) ? get_option( $name, $default ) : $default;
		$disabled    = isset( $args['disabled'] ) ? 'disabled' : '';
		$data_depend = isset( $args['depend'] ) ? " data-depend='" . wp_json_encode( $args['depend'] ) . "'" : '';

		if ( $disabled ) {
			$value = $default;
			//phpcs:ignore
			printf( '<div class="%3$s"><input class="jitsi-admin-field" type="text" name="%1$s" id="%1$s" value="%2$s"%4$s/></div>', esc_attr( $name ), esc_attr( $value ), esc_attr( $disabled ), $data_depend );
		} else {
			//phpcs:ignore
			printf( '<input class="jitsi-admin-field" type="text" name="%1$s" id="%1$s" value="%2$s"%3$s/>', esc_attr( $name ), esc_attr( $value ), $data_depend );
		}
	}

	/**
	 * Jitsi general disable
	 *
	 * @param array $args  $args array.
	 *
	 * @return  void
	 */
	public function jitsi_general_disable( $args ) {
		$name        = $args['label_for'];
		$default     = isset( $args['default'] ) ? $args['default'] : '';
		$value       = $default;
		$data_depend = isset( $args['depend'] ) ? " data-depend='" . wp_json_encode( $args['depend'] ) . "'" : '';
		printf( '<input class="jitsi-admin-field" disabled type="text" name="%1$s" id="%1$s" value="%2$s"%3$s/>', esc_attr( $name ), esc_attr( $value ), esc_attr( $data_depend ) );
	}

	/**
	 * Jitsi textrea
	 *
	 * @param array $args  textrea field.
	 *
	 * @return  void
	 */
	public function jitsi_textrea( $args ) {
		$name        = $args['label_for'];
		$value       = get_option( $name, '' );
		$data_depend = isset( $args['depend'] ) ? " data-depend='" . json_encode( $args['depend'] ) . "'" : '';

		//phpcs:ignore
		printf( '<textarea class="jitsi-admin-field" name="%1$s" id="%1$s" rows="4"%3$s>%2$s</textarea>', esc_attr( $name ), esc_attr( $value ), $data_depend );
	}

	/**
	 * Jitsi number field
	 *
	 * @param array $args  number field.
	 *
	 * @return  void
	 */
	public function jitsi_number( $args ) {
		$name     = $args['label_for'];
		$default  = intval( $args['default'] );
		$value    = get_option( $name, $default );
		$disabled = isset( $args['disabled'] ) ? 'disabled' : '';
		printf( '<div class="%3$s"><input class="jitsi-admin-field" type="number" name="%1$s" id="%1$s" value="%2$s"/></div>', esc_attr( $name ), intval( $value ), esc_attr( $disabled ) );
	}

	/**
	 * Jitsi select field
	 *
	 * @param  array $args  select field.
	 *
	 * @return  void
	 */
	public function jitsi_select( $args ) {
		$name       = $args['label_for'];
		$default    = isset( $args['default'] ) ? $args['default'] : '';
		$optionsarr = isset( $args['options'] ) ? $args['options'] : array();
		$disabled   = isset( $args['disabled'] ) && $args['disabled'];

		// Use default value for disabled fields, otherwise get saved value.
		$value = $disabled ? $default : get_option( $name, $default );

		// Build options securely.
		$options_html = '';
		foreach ( $optionsarr as $key => $val ) {
			$selected      = selected( $key, $value, false );
			$options_html .= sprintf(
				'<option value="%1$s" %3$s>%2$s</option>',
				esc_attr( $key ),
				esc_html( $val ),
				$selected
			);
		}

		// Prepare data-depend attribute if it exists.
		$data_depend_attr = '';
		if ( isset( $args['depend'] ) ) {
			$data_depend_attr = ' data-depend="' . esc_attr( wp_json_encode( $args['depend'] ) ) . '"';
		}

		if ( $disabled ) {
			// For disabled/premium fields: wrap entire field in disabled div (like jitsi_number, jitsi_general).
			printf(
				'<div class="disabled"><select class="jitsi-admin-field" name="%1$s" id="%1$s" disabled%2$s>%3$s</select></div>',
				esc_attr( $name ),
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped above
				$data_depend_attr,
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Content already escaped in the loop
				$options_html
			);
		} else {
			// For enabled fields: no wrapper div.
			printf(
				'<select class="jitsi-admin-field" name="%1$s" id="%1$s"%2$s>%3$s</select>',
				esc_attr( $name ),
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped above
				$data_depend_attr,
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Content already escaped in the loop
				$options_html
			);
		}
	}

	/**
	 * Jitsi switcher
	 *
	 * @param  array $args  switcher field.
	 *
	 * @return void
	 */
	public function jitsi_switch( $args ) {
		$name         = $args['label_for'];
		$default      = $args['default'];
		$value        = get_option( $name, $default ) ? 1 : 0;
		$disabled     = isset( $args['disabled'] ) ? 'disabled' : '';
		$new_tag      = '';
		$feature_type = '';

		if ( isset( $args['feature_type'] ) ) {
			$feature_type = $args['feature_type'];
			$new_tag      = 'new' === $feature_type ? '<span class="jitsi-new">' . __( ' New ', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span>' : '';
		}

		$class = $value ? ( $disabled ? 'jitsi-field-switch' : 'jitsi-field-switch active' ) : 'jitsi-field-switch';

		printf(
			'<div class="%1$s %2$s"><label class="%3$s"><input class="jitsi-admin-field" type="checkbox" name="%4$s" id="%4$s" value="1" %5$s/><span></span></label>%6$s</div>',
			esc_attr( $disabled ),
			esc_attr( $feature_type ),
			esc_attr( $class ),
			esc_attr( $name ),
			checked( 1, $value, false ),
			wp_kses_post( $new_tag )
		);
	}

	/**
	 * Jitsi multiswitcher
	 *
	 * @param array $args   multiswitcher field.
	 *
	 * @return  void
	 */
	public function jitsi_multiswitch( $args ) {
		$name       = $args['label_for'];
		$default    = $args['default'];
		$optionsarr = $args['options'];
		$value      = get_option( $name, $default );

		$allowed_html = [
			'svg'    => [
				'xmlns'       => [],
				'fill'        => [],
				'viewbox'     => [],
				'role'        => [],
				'aria-hidden' => [],
				'focusable'   => [],
				'height'      => [],
				'width'       => [],
			],
			'circle' => [
				'cx'   => [],
				'cy'   => [],
				'r'    => [],
				'fill' => [],
			],
			'path'   => [
				'd'               => [],
				'fill'            => [],
				'stroke'          => [],
				'stroke-width'    => [],
				'stroke-linejoin' => [],
				'mask'            => [],
				'fill-rule'       => [],
				'clip-rule'       => [],

			],
			'mask'   => [
				'id'        => [],
				'maskUnits' => [],
				'x'         => [],
				'y'         => [],
				'fill'      => [],
				'height'    => [],
				'width'     => [],
			],
			'rect'   => [
				'x'      => [],
				'y'      => [],
				'fill'   => [],
				'height' => [],
				'width'  => [],
			],
			'span'   => [
				'class' => [],
			],
		];

		echo '<div class="jitsi-admin-field jitsi-admin-field-multiswitch">';
		foreach ( $optionsarr as $key => $val ) {
			$selected = $key === $value ? 'checked' : '';
			if ( strpos( $key, 'disable-' ) === 0 ) {
				//phpcs:ignore
				echo '<label class="disabled"><input class="jitsi-admin-field" disabled type="radio" name="' . esc_attr( $name ) . '" value="' . esc_attr( $key ) . '" ' . esc_attr( $selected ) . '/><span>' . wp_kses( $val, $allowed_html ) . '</span></label>';
			} else {
				echo '<label><input class="jitsi-admin-field" type="radio" name="' . esc_attr( $name ) . '" value="' . esc_attr( $key ) . '" ' . esc_attr( $selected ) . ' /><span>' . wp_kses( $val, $allowed_html ) . '</span></label>';
			}
		}

		echo '</div>';
	}

	/**
	 * Jitsi single img field
	 *
	 * @param array $args  single image field.
	 *
	 * @return  void
	 */
	public function jitsi_single_img( $args ) {
		$name     = $args['label_for'];
		$default  = $args['default'];
		$value    = get_option( $name, $default );
		$disabled = isset( $args['disabled'] ) ? 'disabled' : ''; ?>
		<div class="jitsi-field-single-image <?php echo esc_attr( $disabled ); ?>">
			<div class="jitsi-uploader-preview">
				<?php
				if ( $value ) {
					printf( '<div id="%1$s-prev-wrap" class="jitsi-uploader-preview-img"><img  id="%1$s-prev" src="%2$s" alt="%3$s"/></div>', esc_attr( $name ), esc_url( $value ), esc_attr__( 'Preview Image Upload', 'webinar-and-video-conference-with-jitsi-meet' ) );
				}
				?>
				<div data-for="<?php echo esc_attr( $name ); ?>" class="jitsi-uploader-preview-placehold jitsi-uploader-button">
					<div data-for="<?php echo esc_attr( $name ); ?>">
						<svg data-for="<?php echo esc_attr( $name ); ?>" width="47" 
						<?php  // phpcs:ignore ?>
						height="30" viewBox="0 0 47 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M46.25 20.625C46.25 15.712 42.4707 11.6816 37.6608 11.2825C36.0069 4.7964 30.1261 0 23.125 0C16.1239 0 10.2431 4.7964 8.58925 11.2825C3.77926 11.6816 0 15.7119 0 20.625C0 25.8027 4.19733 30 9.375 30H19.5267V19.5267H15L23.2766 11.25L31.5533 19.5267H27.0267V30H36.875C42.0527 30 46.25 25.8027 46.25 20.625Z" fill="#0376DA"></path></svg>
						<h5 data-for="<?php echo esc_attr( $name ); ?>"><?php esc_html_e( 'Upload an image', 'webinar-and-video-conference-with-jitsi-meet' ); ?></h5>
						<p data-for="<?php echo esc_attr( $name ); ?>"><?php echo esc_attr( $args['size'] ); ?></p>
					</div>
				</div>
				<div class="jisti-uploader-btn-group">
					<input class="jitsi-admin-field" type="text" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value ? esc_attr( $value ) : esc_attr( $default ); ?>">

					<?php  // phpcs:ignore ?>
					<button data-for="<?php echo esc_attr( $name ); ?>" class="button jitsi-uploader-reset" type="button"><svg data-for="<?php echo esc_attr( $name ); ?>" size="20" color="#5E6D7A" viewBox="0 0 24 24" class="sc-htoDjs jivEt"><g><path fill-rule="evenodd" d="M8 2c-1.1046 0-2 .8954-2 2v2H3c-.5523 0-1 .4477-1 1s.4477 1 1 1h1.125l.7578 12.1248C4.9487 21.1788 5.8228 22 6.8789 22h10.2422c1.0561 0 1.9302-.8212 1.9961-1.8752L19.875 8H21c.5523 0 1-.4477 1-1s-.4477-1-1-1h-3V4c0-1.1046-.8954-2-2-2H8zm0 2v2h8V4H8zM6.1289 8h11.7422l-.75 12H6.8789l-.75-12zM9 11c0-.5523.4477-1 1-1s1 .4477 1 1v7c0 .5523-.4477 1-1 1s-1-.4477-1-1v-7zm5-1c-.5523 0-1 .4477-1 1v7c0 .5523.4477 1 1 1s1-.4477 1-1v-7c0-.5523-.4477-1-1-1z" clip-rule="evenodd"></path></g></svg></button>
					<button data-for="<?php echo esc_attr( $name ); ?>" class="button jitsi-uploader-button" type="button"><svg data-for="<?php echo esc_attr( $name ); ?>" size="20" color="#5E6D7A" viewBox="0 0 24 24" class="sc-htoDjs jivEt"><g>
						<?php  // phpcs:ignore ?>
					<path fill-rule="evenodd" d="M18.9706 3.4142l1.4142 1.4142c.7811.781.7811 2.0474 0 2.8285l-9.8995 9.8994-6.364 2.1214 2.1214-6.364 9.8995-9.8995c.781-.781 2.0474-.781 2.8284 0zm-1.4142 4.2426l1.4142-1.4142-1.4142-1.4142-1.4142 1.4142 1.4142 1.4143zm-1.4142 1.4143L14.728 7.6569 7.9908 14.394l-.7072 2.1213 2.1214-.7071 6.7372-6.7372z" clip-rule="evenodd"></path></g></svg></button>
				</div>
			</div>
		</div>
		<?php
	}

	public function jitsi_hosting_cards( $args ) {
		$name       = $args['label_for'];
		$default    = $args['default'];
		$optionsarr = $args['options'];
		$value      = ( isset( $_GET['select_api'] ) ) ? sanitize_text_field( wp_unslash( $_GET['select_api'] ) ) : get_option( $name, $default );
		$options    = '';

		echo '<h3 class="jitsi-section-title">' . __( 'Choose where your meetings will run:', 'webinar-and-video-conference-with-jitsi-meet' ) . '</h3>';

		foreach ( $optionsarr as $key => $val ) {
			$selected = $key == $value ? 'checked' : '';
			$card_class = 'card-' . $key;
			
			// Mark self-hosted as disabled in free version (check for disable- prefix)
			$is_disabled = ( strpos( $key, 'disable-' ) === 0 );
			$disabled_class = $is_disabled ? ' disabled' : '';
			$disabled_attr = $is_disabled ? ' disabled' : '';
			
			// Get the actual key without disable- prefix for icon matching
			$icon_key = $is_disabled ? str_replace( 'disable-', '', $key ) : $key;
			
			$icon = '';
			switch($icon_key) {
				case 'free': 
					$icon = '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="24" fill="#4083FF"/><path d="M32.9285 18.6308C32.6182 18.0102 32.2044 17.493 31.5838 17.1826C31.17 16.8723 30.6528 16.7689 30.239 16.6654C30.239 16.2517 30.0321 15.7345 29.9287 15.3207C30.7562 14.2863 30.9631 13.045 30.5493 11.8037C29.9287 10.0452 29.6184 9.11426 28.584 9.11426C28.3771 9.11426 28.2737 9.11426 28.0668 9.2177L27.7564 9.32114L27.5496 9.52802C27.4461 9.63146 27.3427 9.83834 27.3427 10.0452V10.3555V10.5624C27.3427 11.0796 27.2392 11.9072 27.2392 12.114C27.1358 12.3209 26.8255 12.8381 25.998 13.1485C25.8945 13.1485 25.8945 13.1485 25.7911 13.2519C25.2739 13.4588 24.3429 13.7691 23.7223 14.4932C23.205 15.1138 23.1016 15.631 22.9982 16.3551C22.8947 16.8723 22.7913 17.493 22.7913 18.2171H22.6878C21.8603 18.4239 19.9984 18.9411 19.0674 20.4928C18.3433 21.5272 18.2399 22.9753 18.7571 24.5269C18.8605 24.8373 18.964 25.1476 19.0674 25.3545C18.7571 25.251 18.4468 25.1476 18.033 25.0442H17.8261C16.4814 25.0442 14.7229 26.6992 14.7229 29.8024C14.7229 31.1472 14.8263 32.3885 15.1367 33.5263C15.3435 34.3538 15.5504 34.871 15.6539 34.9745L17.2055 37.8708L17.9296 34.6642C18.3433 32.9057 18.8605 32.1816 19.3777 31.7678C20.3087 32.3885 21.4466 32.8022 22.7913 32.8022C24.0326 32.8022 25.3773 32.3885 26.5152 31.7678C27.3427 31.2506 27.9633 30.7334 28.584 30.0093C28.6874 30.0093 28.7909 30.0093 28.8943 30.0093C29.3081 30.0093 30.4459 29.4921 31.3769 28.3543C31.8941 27.6302 32.4113 26.8026 32.7216 25.8717C33.1354 24.7338 33.3423 23.3891 33.4457 21.9409C33.4457 20.5962 33.3423 19.4583 32.9285 18.6308Z" fill="white"/></svg>';
					break;
				case 'branded':
					$icon = '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="24" fill="#10B981"/><path d="M33 18.5l-4 4V19a1 1 0 0 0-1-1H15a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h13a1 1 0 0 0 1-1v-3.5l4 4v-11z" fill="white"/></svg>';
					break;
				case 'jaas':
					$icon = '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="24" fill="#F45162"/><path fill-rule="evenodd" clip-rule="evenodd" d="M17.6605 24.45L17.6644 24.4454C17.8037 24.2778 18.9284 22.9261 18.9284 21.6027C18.9284 19.2784 16.9661 18 14.5511 18C11.5322 18.029 10.2039 19.8013 10.2039 21.6027C10.2039 22.6777 10.6869 23.404 11.3812 23.9852C10.9888 24.2757 9.6001 25.4088 9.6001 27.0359C9.6001 29.0115 11.2605 30.9 14.4001 30.9C17.6001 30.9 19.2001 29.0115 19.2001 27.0939C19.2001 25.8446 18.536 25.031 17.6605 24.45ZM27.8414 22.5H24.7892L24.0848 23.8132C23.9968 24.0175 23.8207 24.251 23.8207 24.251H23.7913C23.7913 24.251 23.6446 24.0175 23.5272 23.8132L22.8523 22.5H19.8L22.2065 26.2354L19.8294 30H22.8229L23.6446 28.4533C23.7326 28.3074 23.8501 28.0447 23.8501 28.0447H23.8793C23.8793 28.0447 23.9968 28.3074 24.0848 28.4533L24.9065 30H27.9L25.5229 26.2354L27.8414 22.5ZM15.6001 21.8613C15.6001 21.1645 15.1144 20.7 14.3144 20.7C13.543 20.7 13.2001 21.1355 13.2001 21.6871C13.2001 22.5 14.0858 22.9355 15.1715 23.4C15.2858 23.1968 15.6001 22.6161 15.6001 21.8613ZM36.8605 24.4792L36.8643 24.4745C37.0037 24.3063 38.1284 22.9483 38.1284 21.619C38.1284 19.2842 36.1661 18 33.7509 18C30.7321 18 29.4038 19.7803 29.4038 21.5898C29.4038 22.6697 29.8869 23.3993 30.5812 23.983C30.1887 24.2749 28.8001 25.4131 28.8001 27.0184C28.8001 29.003 30.4604 30.9 33.6 30.9C36.8001 30.9 38.4001 29.003 38.4001 27.0768C38.4001 25.8801 37.736 25.0629 36.8605 24.4792ZM12.9002 26.7294C12.9002 27.5529 13.5701 28.2001 14.4148 28.2001C15.3468 28.2001 15.9002 27.7589 15.9002 26.9059C15.9002 26.2552 14.9596 25.8295 13.8543 25.3291H13.8542L13.8532 25.3286C13.7599 25.2864 13.6653 25.2436 13.5701 25.2C13.2788 25.5236 12.9002 26.053 12.9002 26.7294ZM33.6147 28.2001C32.77 28.2001 32.1001 27.5529 32.1001 26.7294C32.1001 26.053 32.4788 25.5236 32.77 25.2C32.8656 25.2437 32.9605 25.2866 33.0541 25.3291H33.0542C34.1595 25.8295 35.1002 26.2552 35.1002 26.9059C35.1002 27.7589 34.5467 28.2001 33.6147 28.2001ZM34.8 21.8613C34.8 21.1645 34.3144 20.7 33.5143 20.7C32.7429 20.7 32.4001 21.1355 32.4001 21.6871C32.4001 22.5 33.2857 22.9355 34.3715 23.4C34.4857 23.1968 34.8 22.6161 34.8 21.8613Z" fill="white"/></svg>';
					break;
				case 'self':
					$icon = '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="24" fill="#10D7B0"/><path fill-rule="evenodd" clip-rule="evenodd" d="M31.0255 19.1455C31.0255 18.2051 30.6519 17.3033 29.987 16.6384C29.3221 15.9735 28.4203 15.6 27.48 15.6H15.0655C14.1252 15.6 13.2234 15.9735 12.5585 16.6384C11.8936 17.3033 11.52 18.2051 11.52 19.1455V23.7807C12.6884 23.0532 14.0463 22.6587 15.4449 22.6587C17.4144 22.6587 19.3032 23.4411 20.6958 24.8337C22.0884 26.2263 22.8707 28.1151 22.8707 30.0845C22.8707 30.9569 22.7172 31.8135 22.4251 32.6182H27.48C28.4203 32.6182 29.3221 32.2447 29.987 31.5798C30.6519 30.9149 31.0255 30.013 31.0255 29.0727V19.1455ZM21.2893 30.0847C21.2893 30.9702 21.0884 31.8351 20.7117 32.6182H16.1536V30.7932H18.2797C18.4676 30.7932 18.6479 30.7185 18.7808 30.5856C18.9137 30.4527 18.9884 30.2725 18.9884 30.0845C18.9884 29.8965 18.9137 29.7163 18.7808 29.5834C18.6479 29.4505 18.4676 29.3758 18.2797 29.3758H16.1536V27.2498C16.1536 27.0618 16.079 26.8815 15.946 26.7486C15.8131 26.6157 15.6329 26.5411 15.4449 26.5411C15.257 26.5411 15.0767 26.6157 14.9438 26.7486C14.8109 26.8815 14.7362 27.0618 14.7362 27.2498V29.3758H12.6102C12.4222 29.3758 12.242 29.4505 12.1091 29.5834C11.9762 29.7163 11.9015 29.8965 11.9015 30.0845C11.9015 30.2725 11.9762 30.4527 12.1091 30.5856C12.242 30.7185 12.4222 30.7932 12.6102 30.7932H14.7362V32.6029C13.9167 32.5265 13.1453 32.1666 12.5585 31.5798C11.8936 30.9149 11.52 30.013 11.52 29.0727V25.7536C12.5924 24.7818 13.9906 24.24 15.4446 24.24C16.9947 24.24 18.4814 24.8558 19.5775 25.9519C20.6736 27.048 21.2893 28.5346 21.2893 30.0847ZM32.16 27.2473L36.1088 30.3309C37.0403 31.0582 38.4 30.3945 38.4 29.2134V19.0053C38.4 17.8237 37.0403 17.1606 36.1088 17.8878L32.16 20.9709V27.2473Z" fill="white"/><path d="M21.2895 30.0847C21.2895 31.6348 20.6737 33.1214 19.5776 34.2175C18.4815 35.3136 16.9949 35.9294 15.4448 35.9294C13.8947 35.9294 12.4081 35.3136 11.312 34.2175C10.2159 33.1214 9.6001 31.6348 9.6001 30.0847C9.6001 28.5346 10.2159 27.048 11.312 25.9519C12.4081 24.8558 13.8947 24.24 15.4448 24.24C16.9949 24.24 18.4815 24.8558 19.5776 25.9519C20.6737 27.048 21.2895 28.5346 21.2895 30.0847ZM16.0942 27.487C16.0942 27.3148 16.0258 27.1496 15.904 27.0278C15.7822 26.9061 15.617 26.8376 15.4448 26.8376C15.2726 26.8376 15.1074 26.9061 14.9856 27.0278C14.8638 27.1496 14.7954 27.3148 14.7954 27.487V29.4353H12.8472C12.6749 29.4353 12.5097 29.5037 12.388 29.6255C12.2662 29.7473 12.1977 29.9125 12.1977 30.0847C12.1977 30.2569 12.2662 30.4221 12.388 30.5439C12.5097 30.6657 12.6749 30.7341 12.8472 30.7341H14.7954V32.6823C14.7954 32.8546 14.8638 33.0198 14.9856 33.1415C15.1074 33.2633 15.2726 33.3318 15.4448 33.3318C15.617 33.3318 15.7822 33.2633 15.904 33.1415C16.0258 33.0198 16.0942 32.8546 16.0942 32.6823V30.7341H18.0424C18.2147 30.7341 18.3799 30.6657 18.5017 30.5439C18.6234 30.4221 18.6919 30.2569 18.6919 30.0847C18.6919 29.9125 18.6234 29.7473 18.5017 29.6255C18.3799 29.5037 18.2147 29.4353 18.0424 29.4353H16.0942V27.487Z" fill="white"/></svg>';
					break;
			}

			$options .= sprintf(
				'<label class="hosting-card %1$s">
					<input class="jitsi-admin-field jitsi-api-trigger" type="radio" name="%2$s" value="%3$s" %4$s/>
					<div class="hosting-card-inner">
						<div class="selected-check">
							<svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
						</div>
						<div class="card-icon">%5$s</div>
						<div class="card-label">%6$s <span class="jitsi-new-tag">%7$s</span></div>
						<div class="card-desc">%8$s</div>
					</div>
				</label>',
				esc_attr( $card_class ),
				esc_attr( $name ),
				esc_attr( $key ),
				$selected,
				$icon,
				esc_html( $val['label'] ),
				__( 'New', 'webinar-and-video-conference-with-jitsi-meet' ),
				esc_html( $val['desc'] )
			);
		}

		printf( '<div class="jitsi-admin-field-hosting-cards">%1$s</div>', $options );

		// Custom JS for toggling
		?>
		<script>
		jQuery(document).ready(function($) {
			var urlParams = new URLSearchParams(window.location.search);
			var isWelcomePage = urlParams.get('page') === 'jitsi-meet-welcome';

			function togglePanels() {
				var selected = $('input[name="<?php echo esc_js($name); ?>"]:checked').val();
				
				// Strip 'disable-' prefix if present to match panel class
				var panelKey = selected.replace(/^disable-/, '');
				
				$('.jitsi-config-panel-wrap').hide();
				$('.jitsi-config-panel-' + panelKey).fadeIn();

				// Hide the main bottom Save Changes button for the Branded panel as it has its own above the FAQ
				// However, if we are on the welcome page, we should KEEP the submit buttons (Skip & Continue) visible.
				
				if (panelKey === 'branded' && !isWelcomePage) {
					$('#jaasOptionFormApi > .jitsi-setting-tab > p.submit').hide();
				} else {
					$('#jaasOptionFormApi > .jitsi-setting-tab > p.submit').show();
				}
			}
			$('.jitsi-api-trigger').on('change', togglePanels);
			togglePanels();

			// Domain field validation — runs on every keystroke.
			var lastVal = $('#jitsi_opt_subdomain_domain').val().trim();
			
			$('#jitsi_opt_subdomain_domain').on('input', function() {
				var val      = $(this).val().trim();
				var $btn     = $('.jitsi-btn-save-test');
				var $statusMsg = $('.jitsi-connection-status-msg');
				var $discBtn = $('.jitsi-btn-disconnect');

				// Only trigger "Domain changed" logic if the value actually changed.
				// This prevents the .trigger('input') on page load from resetting the visibility.
				if ( val !== lastVal ) {
					$btn.removeClass('is-connected').show().prop('disabled', val === '').text(<?php echo json_encode( __( 'Test Connection', 'webinar-and-video-conference-with-jitsi-meet' ) ); ?>);
					$discBtn.hide();
					
					if (!isWelcomePage) {
						$('.jitsi-branded-save-action').hide();
					}
					$statusMsg.html('<span class="jitsi-status-warning" style="background:transparent; border:none; padding:0;">' + <?php echo json_encode( __( 'Domain changed. Please re-test connection.', 'webinar-and-video-conference-with-jitsi-meet' ) ); ?> + '</span>');
					$('#jitsi_opt_subdomain_connected_hidden').val('0');
					lastVal = val;
				}

				if ( '' === val ) {
					$btn.prop('disabled', true).addClass('is-disabled');
				} else {
					$btn.prop('disabled', false).removeClass('is-disabled');
				}
			}).trigger('input');

			// Save and Test Connection
			$(document).on('click', '.jitsi-btn-save-test', function() {
				var $btn = $(this);
				if ($btn.hasClass('is-connected')) {
					console.log('[JitsiJWT] Save & Test clicked but button already has is-connected class — skipping.');
					return;
				}
				
				var domain = $('#jitsi_opt_subdomain_domain').val().trim();
				var $statusMsg = $('.jitsi-connection-status-msg');
				
				console.log('[JitsiJWT] Save & Test Connection clicked.');
				console.log('[JitsiJWT] Domain value being sent to server:', domain);
				
				$btn.prop('disabled', true).text(<?php echo json_encode( __( 'Connecting...', 'webinar-and-video-conference-with-jitsi-meet' ) ); ?>);
				$statusMsg.html('').removeClass('error-msg success-msg');

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'jitsi_connect_server',
						domain: domain,
						nonce: '<?php echo wp_create_nonce("jitsi_jwt_service_nonce"); ?>'
					},
					success: function(response) {
						console.log('[JitsiJWT] AJAX response (raw):', response);
						if (response.success) {
							console.log('[Jitsi_JWT_Service] SUCCESS — Connected to:', domain);
							lastVal = domain; // Mark this domain as the current connected one
							$btn.hide().addClass('is-connected');
							var host = domain.replace(/^https?:\/\//, '').replace(/\/$/, '');
							$statusMsg.html('<span class="jitsi-status-win" style="background:transparent; border:none; padding:0; color:#0e8a16;"><span class="jitsi-msg-icon">✅</span> ' + <?php echo json_encode( __( 'Connection tested successfully.', 'webinar-and-video-conference-with-jitsi-meet' ) ); ?> + '</span> <span style="font-size: 12px; opacity: 0.8; margin-left: 5px;">' + <?php echo json_encode( __( 'Click "Save Changes" to apply.', 'webinar-and-video-conference-with-jitsi-meet' ) ); ?> + '</span>');
							
							$('#jitsi_opt_subdomain_connected_hidden').val('1');
							
							$('.jitsi-btn-disconnect').hide();
							$('.jitsi-request-setup-link').hide(); 

							if (!isWelcomePage) {
								$('.jitsi-branded-save-action').fadeIn();
							}
						} else {
							console.log('[Jitsi_JWT_Service] ► FAIL — Server returned error:', response.data ? response.data.message : '(no message)', '| code:', response.data ? response.data.code : '(none)');
							
							// Ensure buttons reset to disconnected state
							$btn.prop('disabled', false).text(<?php echo json_encode( __( 'Test Connection', 'webinar-and-video-conference-with-jitsi-meet' ) ); ?>).show().removeClass('is-connected');
							$('.jitsi-btn-disconnect').hide();
							$('.jitsi-request-setup-link').show();
							if (!isWelcomePage) {
								$('.jitsi-branded-save-action').hide();
							}
							
							// Domain validation errors (DNS/unreachable/not-Jitsi) get amber warning style.
							// JWT/server errors get red error style.
							var domainErrorCodes = ['dns_failure', 'unreachable', 'not_jitsi', 'invalid_url'];
							var errorCode = response.data && response.data.code ? response.data.code : '';
							var isWarning = domainErrorCodes.indexOf(errorCode) !== -1;
							if (isWarning) {
								$statusMsg.html('<span class="jitsi-status-warning">' + response.data.message + '</span>');
							} else {
								$statusMsg.html('<span class="jitsi-status-error">' + response.data.message + '</span>');
							}
						}
					},
					error: function(xhr, status, error) {
						console.log('[Jitsi_JWT_Service] AJAX ERROR — status:', status, '| error:', error);
						
						// Ensure buttons reset to disconnected state
						$btn.prop('disabled', false).text(<?php echo json_encode( __( 'Test Connection', 'webinar-and-video-conference-with-jitsi-meet' ) ); ?>).removeClass('is-connected');
						$('.jitsi-btn-disconnect').hide();
						$('.jitsi-request-setup-link').show();
						if (!isWelcomePage) {
							$('.jitsi-branded-save-action').hide();
						}
						
						$statusMsg.html('<span class="jitsi-status-error">' + (response.data ? response.data.message : <?php echo json_encode( __( 'Connection failed. Please check your domain.', 'webinar-and-video-conference-with-jitsi-meet' ) ); ?>) + '</span>');
					}
				});
			});

			// Disconnect
			$(document).on('click', '.jitsi-btn-disconnect', function(e) {
				e.preventDefault();
				
				var $discBtn = $(this);
				var $connBtn = $('.jitsi-btn-save-test');
				var $statusMsg = $('.jitsi-connection-status-msg');

				console.log('[JitsiJWT] Disconnect clicked.');
				
				$connBtn.removeClass('is-connected').show().prop('disabled', false).text(<?php echo json_encode( __( 'Test Connection', 'webinar-and-video-conference-with-jitsi-meet' ) ); ?>);
				$discBtn.hide();
				$('.jitsi-request-setup-link').hide();
				
				if (!isWelcomePage) {
					$('.jitsi-branded-save-action').hide();
				}
				$statusMsg.html('<span class="jitsi-status-warning" style="background:transparent; border:none; padding:0;">' + <?php echo json_encode( __( 'Connection disconnected. Save changes to apply.', 'webinar-and-video-conference-with-jitsi-meet' ) ); ?> + '</span>');
				if (!isWelcomePage) {
					$('.jitsi-branded-save-action').fadeIn(); 
				}
				
				// Set hidden field to 0 so native form submit saves the disconnected state
				$('#jitsi_opt_subdomain_connected_hidden').val('0');
			});

			// FAQ Accordion
			$('.faq-toggle').on('click', function() {
				const $item = $(this).closest('.faq-item');
				const $content = $item.find('.faq-content');
				
				if ($item.hasClass('is-active')) {
					$content.slideUp(300);
					$item.removeClass('is-active');
				} else {
					// Close others
					$('.faq-item.is-active').find('.faq-content').slideUp(300);
					$('.faq-item.is-active').removeClass('is-active');
					
					$content.slideDown(300);
					$item.addClass('is-active');
				}
			});

			// Handle click on disabled hosting cards (premium feature)
			$('.hosting-card.disabled').on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				return false;
			});

			// Prevent radio button change for disabled cards
			$('.hosting-card.disabled input[type="radio"]').on('click', function(e) {
				e.preventDefault();
				return false;
			});

			// Handle click on disabled wrapper divs (premium feature)
			$(document).on('click', '.disabled', function(e) {
				// Only trigger if clicking directly on the disabled wrapper or its disabled children
				if ($(this).hasClass('disabled')) {
					e.preventDefault();
					return false;
				}
			});
		});
		</script>
		<?php
	}

	private function render_benefits($benefits, $cta_text = '', $cta_url = '') {
		echo '<div class="jitsi-side-info">';
		echo '<h4><span class="emoji-wrapper">' . esc_html__( '🎁', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span> ' . __( 'Benefits:', 'webinar-and-video-conference-with-jitsi-meet' ) . '</h4>';
		echo '<ul class="benefits-list">';
		
		$icons = [
			'ShieldCheck' => '<svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>',
			'Zap'         => '<svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" /></svg>',
			'Globe'       => '<svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" /></svg>',
			'Clock'       => '<svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>',
			'UserGroup'   => '<svg viewBox="0 0 20 20" fill="currentColor"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3.005 3.005 0 013.75-2.906z" /></svg>',
			'LockClosed'  => '<svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>',
		];

		foreach ( $benefits as $benefit ) {
			$icon_name = is_array($benefit) ? $benefit['icon'] : 'ShieldCheck';
			$text = is_array($benefit) ? $benefit['text'] : $benefit;
			$icon_svg = isset($icons[$icon_name]) ? $icons[$icon_name] : $icons['ShieldCheck'];

			echo '<li><div class="benefit-icon">' . $icon_svg . '</div><div class="benefit-text">' . esc_html( $text ) . '</div></li>';
		}
		echo '</ul>';
		if ( $cta_text && $cta_url ) {
			echo '<div class="jitsi-cta-box">';
			echo '<p class="cta-help-text"><strong>' . __( 'Need help setting up your branded server?', 'webinar-and-video-conference-with-jitsi-meet' ) . '</strong></p>';
			echo '<a href="' . esc_url( $cta_url ) . '" class="jitsi-btn jitsi-btn-cta" target="_blank"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>' . esc_html( $cta_text ) . '</a>';
			echo '</div>';
		}
		echo '</div>';
	}

	private function render_guide($steps, $footer_text = '') {
		echo '<div class="jitsi-setup-guide">';
		echo '<h4 class="guide-toggle"><svg class="toggle-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>' . __( 'How Hosted Meetings works?', 'webinar-and-video-conference-with-jitsi-meet' ) . '</h4>';
		echo '<div class="guide-steps-wrap" style="display:none;">';
		echo '<ol class="numbered-steps">';
		foreach ( $steps as $index => $step ) {
			echo '<li>' . $step . '</li>';
		}
		echo '</ol>';
		if ($footer_text) {
			echo '<p class="guide-footer">' . $footer_text . '</p>';
		}
		echo '</div>';
		echo '</div>';
	}

	public function jitsi_field_ui($id, $title, $desc, $content, $tooltip = []) {
		echo '<div class="jitsi-form-field-row">';
		echo '<div class="field-label-cell">';
		echo '<div class="label-with-tooltip">';
		echo '<label for="' . esc_attr($id) . '">' . esc_html($title) . '</label>';
		
		if (!empty($tooltip)) {
			echo '<span class="jitsi-tooltip-trigger">';
			echo '<svg size="20" viewBox="0 0 24 24" class="sc-htoDjs brCwHT"><g><path fill-rule="evenodd" d="M12 22C6.4771 22 2 17.5228 2 12 2 6.4771 6.4771 2 12 2c5.5228 0 10 4.4771 10 10 0 5.5228-4.4772 10-10 10zm0-2c4.4183 0 8-3.5817 8-8s-3.5817-8-8-8-8 3.5817-8 8 3.5817 8 8 8zm-.9023-2.1289c.2369.2057.5143.3086.832.3086.3073 0 .5781-.1042.8125-.3125.2344-.2083.3516-.4948.3516-.8594 0-.3281-.112-.6042-.336-.8281-.2239-.224-.5-.3359-.8281-.3359-.3333 0-.6146.1119-.8438.3359-.2291.2239-.3437.5-.3437.8281 0 .3698.1185.6576.3555.8633zm-2.504-9.7578c-.3177.5078-.4765 1.009-.4765 1.5039 0 .2396.1002.4622.3008.668.2005.2057.4466.3086.7383.3086.4947 0 .8307-.2943 1.0078-.8829.1875-.5625.4166-.9882.6875-1.2773.2708-.289.6927-.4336 1.2656-.4336.4896 0 .8893.1432 1.1992.4297.3099.2865.4648.638.4648 1.0547 0 .2135-.0507.4114-.1523.5937a2.242 2.242 0 0 1-.375.4961c-.1484.1485-.3893.3685-.7227.6602-.3802.3333-.6822.6211-.9062.8633-.224.2421-.4036.5234-.5391.8437-.1354.3203-.2031.6992-.2031 1.1367 0 .349.0925.612.2774.7891.1849.1771.4127.2656.6836.2656.5208 0 .8307-.2708.9296-.8125.0573-.2552.1003-.4336.1289-.5351a1.6557 1.6557 0 0 1 .1211-.3047c.0521-.1016.1315-.2136.2383-.336.1068-.1224.2487-.2643.4258-.4257.6406-.573 1.0846-.9805 1.332-1.2227.2474-.2422.461-.53.6407-.8633.1796-.3333.2695-.7213.2695-1.164 0-.5625-.1576-1.0834-.4727-1.5625-.3151-.4792-.7617-.8581-1.3398-1.1368-.5781-.2786-1.2448-.418-2-.418-.8125 0-1.5234.1667-2.1328.5-.6094.3334-1.073.754-1.3907 1.2618z" clip-rule="evenodd"></path></g></svg>';
			echo '<span class="jitsi-admin-tooltip">';
			echo '<span class="tooltip-arrow"></span>';
			if (isset($tooltip['image'])) {
				echo '<img src="' . esc_url($tooltip['image']) . '" alt="' . esc_attr($tooltip['text']) . '"/>';
			}
			if (isset($tooltip['text'])) {
				echo '<strong>' . esc_html($tooltip['text']) . '</strong>';
			}
			echo '</span>';
			echo '</span>';
		}
		
		echo '</div>'; // label-with-tooltip

		if ($desc) {
			echo '<p class="description">' . $desc . '</p>';
		}
		echo '</div>';
		echo '<div class="field-input-cell">';
		echo $content;
		echo '</div>';
		echo '</div>';
	}

	public function jitsi_api_panel_free($args) {
		echo '<div class="jitsi-config-panel-wrap jitsi-config-panel-free" style="display:none;">';
		echo '<div class="jitsi-layout-grid">';
		echo '<div class="jitsi-config-panel">';
		echo '<div class="jitsi-panel-header"><h3>' . __( 'Default Public Hosting', 'webinar-and-video-conference-with-jitsi-meet' ) . '</h3></div>';
		echo '<div class="jitsi-main-config">';
		
		// Render Domain Select
		$name = 'jitsi_opt_free_domain';
		$val = get_option($name, 'jitsi-01.csn.tu-chemnitz.de');
		$options = [
			'jitsi-01.csn.tu-chemnitz.de' => __( 'Domain One', 'webinar-and-video-conference-with-jitsi-meet' ),
			'meet.naveksoft.com'          => __( 'Domain Two', 'webinar-and-video-conference-with-jitsi-meet' ),
			'jitsi.unp.edu.ar'            => __( 'Domain Three', 'webinar-and-video-conference-with-jitsi-meet' ),
			'meet.evolix.org'             => __( 'Domain Four', 'webinar-and-video-conference-with-jitsi-meet' ),
		];
		$select = '<select class="jitsi-admin-field" name="' . esc_attr($name) . '" id="' . esc_attr($name) . '">';
		foreach ($options as $k => $v) {
			$select .= '<option value="' . esc_attr($k) . '" ' . selected($k, $val, false) . '>' . esc_html($v) . '</option>';
		}
		$select .= '</select>';
		
		$this->jitsi_field_ui($name, __('Default Public Domain', 'webinar-and-video-conference-with-jitsi-meet'), __('Select a public domain to run your meeting.', 'webinar-and-video-conference-with-jitsi-meet'), $select);
		
		echo '</div>'; // main-config
		echo '</div>'; // config-panel
		$this->render_benefits([
			__( 'Completely Free to Use', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( 'Instant Setup', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( 'No Account Required', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( 'Standard Privacy Features', 'webinar-and-video-conference-with-jitsi-meet' ),
		]);
		echo '</div>'; // layout-grid
		echo '</div>'; // wrap
	}

	public function jitsi_api_panel_branded($args) {
		echo '<div class="jitsi-config-panel-wrap jitsi-config-panel-branded" style="display:none;">';
		echo '<div class="jitsi-layout-grid">';
		echo '<div class="jitsi-grid-left-col">';
		echo '<div class="jitsi-config-panel">';
		echo '<div class="jitsi-panel-header"><h3>' . __( 'Managed Branded Meeting', 'webinar-and-video-conference-with-jitsi-meet' ) . '</h3><span class="panel-badge-pill"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>' . __( 'We’ll handle hosting', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span></div>';
		echo '<div class="jitsi-main-config">';
		
		echo '<p class="panel-desc">' . __('Get your own private branded meeting server (logo + brand name). We host and maintain it - just paste your Hosted Server Domain URL below and enjoy your branded meetings.', 'webinar-and-video-conference-with-jitsi-meet') . '</p>';

		// Render Domain Input
		$name      = 'jitsi_opt_subdomain_domain';
		$is_conn   = get_option( 'jitsi_opt_subdomain_connected', '0' );
		$val       = get_option( $name, '' );
		
		$disabled  = empty( trim( $val ) ) ? 'disabled' : '';
		
		// "Test Connection" button is hidden once fully connected
		$save_style = ( $is_conn == '1' ) ? 'display:none;' : '';
		
		// "Disconnect" button ONLY shows if verified in DB
		$disc_style = ( $is_conn == '1' && ! empty( $val ) ) ? '' : 'display:none;';

		$input = '<p style="margin-top: -5px; margin-bottom: 8px;">' . esc_html__( 'Paste the Domain URL we emailed you (example: yourbrand.jitsihosted.com)', 'webinar-and-video-conference-with-jitsi-meet' ) . '</p>';
		$input .= '<div class="jitsi-input-with-button">';
		$input .= '<input class="jitsi-admin-field" type="text" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '" placeholder="' . esc_attr__( 'Enter the Domain URL', 'webinar-and-video-conference-with-jitsi-meet' ) . '"/>';
		$input .= '<button type="button" class="jitsi-btn jitsi-btn-save-test ' . ( empty( trim( $val ) ) ? 'is-disabled' : '' ) . '" style="' . $save_style . '" ' . ( empty( trim( $val ) ) ? 'disabled' : '' ) . '>' . __( 'Test Connection', 'webinar-and-video-conference-with-jitsi-meet' ) . '</button>';
		$input .= '<button type="button" class="jitsi-btn jitsi-btn-disconnect" style="' . $disc_style . '">' . __( 'Disconnect', 'webinar-and-video-conference-with-jitsi-meet' ) . '</button>';
		$input .= '</div>';
		
		$status_html = '';
		if ( $is_conn == '1' && ! empty( $val ) ) {
			$host = preg_replace('#^https?://#', '', rtrim($val, '/'));
			$status_html = '<span class="jitsi-status-win"><span class="jitsi-msg-icon">' . esc_html__( '✅', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span> ' . __( 'Connected. Meetings will run on', 'webinar-and-video-conference-with-jitsi-meet' ) . ' <code class="jitsi-domain-badge">' . esc_html( $host ) . '</code></span>';
		}

		$input .= '<div class="jitsi-connection-status-msg" style="font-size: 13px;">' . $status_html . '</div>';
		$link_style = ( $is_conn == '1' ) ? 'display:none;' : 'margin-top: 4px;';
		$input .= '<p class="field-sub-link jitsi-request-setup-link" style="' . $link_style . '">' . __( 'Don\'t have a Hosted Server URL yet? ', 'webinar-and-video-conference-with-jitsi-meet' ) . '<a href="https://wppool.dev/webinar-and-video-conference-with-jitsi-meet/service/" target="_blank">' . __( 'Request setup now →', 'webinar-and-video-conference-with-jitsi-meet' ) . '</a></p>';
		
		// Add a hidden field for the connected status so it doesn't get cleared on form save
		$input .= '<input type="hidden" name="jitsi_opt_subdomain_connected" id="jitsi_opt_subdomain_connected_hidden" value="' . esc_attr( $is_conn ) . '" />';

		$this->jitsi_field_ui( $name, __( 'Hosted Server Domain:', 'webinar-and-video-conference-with-jitsi-meet' ), '', $input );

		$this->render_guide([
			__( '<strong>Request</strong> your branded setup first (<a href="https://wppool.dev/webinar-and-video-conference-with-jitsi-meet/service/" target="_blank">request now →</a>)', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( '<strong>We set it up</strong> and email your Hosted Server URL', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( '<strong>Paste the URL here</strong> → Test Connection → meetings start running on your hosted server', 'webinar-and-video-conference-with-jitsi-meet' )
		], '<span class="emoji-wrapper">' . esc_html__( '🤩', 'webinar-and-video-conference-with-jitsi-meet' ) . '</span> ' . __( 'That\'s it - no technical setup needed from you. Wahhhhhhhhhh!', 'webinar-and-video-conference-with-jitsi-meet' ) );

		echo '</div>'; // main-config
		echo '</div>'; // config-panel
		
		// The "Save Changes" button is purely driven by JS interaction now. 
		// If page loads connected -> no need to save. If page loads disconnected -> no need to save yet.
		// It only appears when they try a Test Connection or Disconnect action.
		$branded_save_style = 'margin-top: 30px; margin-bottom: 30px;';
		
		if ( $is_conn != '1' ) {
			$branded_save_style .= ' display: none;';
		}
		
		// Hide the inner Save Changes button specifically on the Welcome page
		if ( isset( $_SERVER['QUERY_STRING'] ) && strpos( sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) ), 'page=jitsi-meet-welcome' ) !== false ) {
			$branded_save_style .= ' display: none;';
		}
		
		echo '<div class="jitsi-branded-save-action" style="' . $branded_save_style . '">';
		echo '<p class="submit" style="margin: 0; padding: 0;"><input type="submit" name="submit" id="submit-branded" class="button button-primary jitsi-btn-brand-save" value="' . __( 'Save Changes', 'webinar-and-video-conference-with-jitsi-meet' ) . '"></p>';
		echo '</div>';

		$this->render_faq();
		echo '</div>'; // grid-left-col
		
		$this->render_benefits([
			__('Branded meeting URL', 'webinar-and-video-conference-with-jitsi-meet'),
			__('Branded logo and other customizations', 'webinar-and-video-conference-with-jitsi-meet'),
			__('No server cost + maintenance', 'webinar-and-video-conference-with-jitsi-meet'),
			__('Private hosting (no shared public server)', 'webinar-and-video-conference-with-jitsi-meet'),
			__('White-labeled experience', 'webinar-and-video-conference-with-jitsi-meet'),
			__('Live streaming support', 'webinar-and-video-conference-with-jitsi-meet'),
		], __('Request branded meeting server for FREE!', 'webinar-and-video-conference-with-jitsi-meet'), 'https://wppool.dev/webinar-and-video-conference-with-jitsi-meet/service/');

		echo '</div>'; // layout-grid
		echo '</div>'; // wrap
	}

	public function render_faq() {
		$faqs = [
			[
				'q' => __( 'What is a server?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( 'A server is a powerful, always-on computer that stores and runs the Jitsi software, allowing users to connect and hold video meetings from anywhere in the world. Think of it as the "home" for your meeting system that stays online 24/7.', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
			[
				'q' => __( 'What is a self-hosted FlexMeeting server?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( 'A self-hosted Jitsi server means the entire video conferencing system runs on your own server or hosting environment, not on Jitsi’s public infrastructure. This gives you full control, privacy, and customization flexibility.', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
			[
				'q' => __( 'Why should I use a self-hosted Jitsi server instead of using public Jitsi?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( 'Public Jitsi servers are shared, limited, and not secure for professional use. With self-hosting, you get: <br>- Enhanced privacy <br>- Better performance <br>- No limitations on usage <br>- Your own branding and domain <br>- Control over features and integrations', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
			[
				'q' => __( 'What do you provide in this service?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( '- We set up a Jitsi server on your VPS/cloud <br>- Secure it with SSL and firewalls <br>- Brand it with your logo and domain (optional) <br>- Integrate it into your website <br>- Provide admin access and documentation <br>- Offer post-installation support if needed', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
			[
				'q' => __( 'Do I need technical knowledge to maintain the server?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( 'No. We handle everything during setup. If you opt for our support plan, we also handle maintenance, upgrades, and any issues that arise.', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
			[
				'q' => __( 'What are the server requirements?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( 'Minimum requirements: <br>- Ubuntu/Debian VPS <br>- 4+ CPU cores <br>- 8GB+ RAM <br>- 100 Mbps+ bandwidth <br>We’ll guide you to choose the right hosting based on your expected usage.', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
			[
				'q' => __( 'Can I use this with my existing website or LMS?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( 'Yes. We can integrate Jitsi into any website, including WordPress, Moodle, TutorLMS, LearnDash, or even custom-built platforms.', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
			[
				'q' => __( 'How long does it take to set everything up?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( 'Typically between 1–3 business days, depending on your customization and hosting setup.', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
			[
				'q' => __( 'Can I record meetings or stream them?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( 'Yes, we can enable recording (using Jibri) and YouTube live streaming on request. Note that these features require additional server resources.', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
			[
				'q' => __( 'Is it one-time setup or recurring service?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( 'The setup is one-time unless you choose our optional support & maintenance plan for updates, backups, and ongoing help.', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
			[
				'q' => __( 'Ready to Launch Your Private Meeting System?', 'webinar-and-video-conference-with-jitsi-meet' ),
				'a' => __( 'We’ll handle all the technical work you just enjoy secure, high-quality meetings with your users. <br><br> <a href="https://wppool.dev/contact/" target="_blank" style="color: #3b82f6; font-weight: 600; text-decoration: none;">Contact Support &rarr;</a>', 'webinar-and-video-conference-with-jitsi-meet' ),
			],
		];
		?>
		<div class="jitsi-faq-section">
			<h2 class="faq-title"><?php esc_html_e( 'Frequently Asked Questions', 'webinar-and-video-conference-with-jitsi-meet' ); ?></h2>
			<div class="faq-accordion">
				<?php foreach ( $faqs as $faq ) : ?>
					<div class="faq-item">
						<button type="button" class="faq-toggle">
							<span><?php echo esc_html( $faq['q'] ); ?></span>
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
							</svg>
						</button>
						<div class="faq-content">
							<p><?php echo wp_kses_post( $faq['a'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="jitsi-faq-footer">
			</div>
		</div>
		<?php
	}

	public function jitsi_api_panel_jaas($args) {
		echo '<div class="jitsi-config-panel-wrap jitsi-config-panel-jaas" style="display:none;">';
		echo '<div class="jitsi-layout-grid">';
		echo '<div class="jitsi-config-panel">';
		echo '<div class="jitsi-panel-header"><h3>' . __( 'Jitsi as a Service (8x8)', 'webinar-and-video-conference-with-jitsi-meet' ) . '</h3></div>';
		echo '<div class="jitsi-main-config">';
		
		// Render App ID
		$name = 'jitsi_opt_app_id';
		$val = get_option($name, '');
		$input = '<textarea class="jitsi-admin-field" name="' . esc_attr($name) . '" id="' . esc_attr($name) . '" rows="2">' . esc_textarea($val) . '</textarea>';
		$this->jitsi_field_ui($name, __('APP ID', 'webinar-and-video-conference-with-jitsi-meet'), __('Get it from ', 'webinar-and-video-conference-with-jitsi-meet') . '<a href="https://jaas.8x8.vc/#/apikeys" target="_blank">JAAS Admin</a>', $input, [
			'image' => JITSI_MEET_WP_URL . '/assets/img/admin-setting-app.gif',
			'text'  => __('Copy the APP ID from JaaS admin', 'webinar-and-video-conference-with-jitsi-meet')
		]);

		// Render API Key
		$name = 'jitsi_opt_api_key';
		$val = get_option($name, '');
		$input = '<textarea class="jitsi-admin-field" name="' . esc_attr($name) . '" id="' . esc_attr($name) . '" rows="2">' . esc_textarea($val) . '</textarea>';
		$this->jitsi_field_ui($name, __('API Key', 'webinar-and-video-conference-with-jitsi-meet'), __('Get it from ', 'webinar-and-video-conference-with-jitsi-meet') . '<a href="https://jaas.8x8.vc/#/apikeys" target="_blank">JAAS Admin</a>', $input, [
			'image' => JITSI_MEET_WP_URL . '/assets/img/admin-setting-api.gif',
			'text'  => __('Copy the API Key from JaaS admin', 'webinar-and-video-conference-with-jitsi-meet')
		]);

		// Render Private Key
		$name = 'jitsi_opt_private_key';
		$val = get_option($name, '');
		$input = '<textarea class="jitsi-admin-field" name="' . esc_attr($name) . '" id="' . esc_attr($name) . '" rows="4">' . esc_textarea($val) . '</textarea>';
		$this->jitsi_field_ui($name, __('Private Key', 'webinar-and-video-conference-with-jitsi-meet'), __('Paste private key content here', 'webinar-and-video-conference-with-jitsi-meet'), $input, [
			'image' => JITSI_MEET_WP_URL . '/assets/img/admin-setting-genkey.gif',
			'text'  => __('Generate private key and download', 'webinar-and-video-conference-with-jitsi-meet')
		]);
		
		echo '</div>'; // main-config
		echo '</div>'; // config-panel
		$this->render_benefits([
			__( 'Enterprise Grade Reliability', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( 'Advanced Analytics', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( 'Global Low-latency Network', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( 'Secure Recorded Meetings', 'webinar-and-video-conference-with-jitsi-meet' ),
		]);
		echo '</div>'; // layout-grid
		echo '</div>'; // wrap
	}

	public function jitsi_api_panel_self($args) {
		echo '<div class="jitsi-config-panel-wrap jitsi-config-panel-self" style="display:none;">';
		echo '<div class="jitsi-layout-grid">';
		echo '<div class="jitsi-config-panel">';
		echo '<div class="jitsi-panel-header"><h3>' . __( 'Self-Hosted Server', 'webinar-and-video-conference-with-jitsi-meet' ) . '</h3></div>';
		echo '<div class="jitsi-main-config">';
		
		// Render Domain Input with Premium badge and disabled state
		$name = 'jitsi_opt_custom_domain';
		$val = get_option($name, '8x8.vc');
		$input = '<div class="disabled"><input class="jitsi-admin-field" type="text" name="' . esc_attr($name) . '" id="' . esc_attr($name) . '" value="' . esc_attr($val) . '" disabled/></div>';
		$this->jitsi_field_ui(
			$name, 
			__('Your Server Domain', 'webinar-and-video-conference-with-jitsi-meet'), 
			__('Enter your self-hosted Jitsi domain (e.g., meet.yourdomain.com)', 'webinar-and-video-conference-with-jitsi-meet') . '<span class="description desc-pro">' . __('Premium Feature', 'webinar-and-video-conference-with-jitsi-meet') . '</span>', 
			$input
		);
		
		echo '</div>'; // main-config
		echo '</div>'; // config-panel
		$this->render_benefits([
			__( 'Full Data Control', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( 'Custom Security Policies', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( 'No Third-party Tracking', 'webinar-and-video-conference-with-jitsi-meet' ),
			__( 'Infrastructure Ownership', 'webinar-and-video-conference-with-jitsi-meet' ),
		]);
		echo '</div>'; // layout-grid
		echo '</div>'; // wrap
	}

	public function jitsi_other_admin() {
		printf( '<p class="other-admin-setting">%1$s <a href="%2$s" target="_blank">%3$s</a></p>', __( 'Some settings like Company Logo, Background etc are currently not available via api. You can set your company logo, background etc from the', 'webinar-and-video-conference-with-jitsi-meet' ), esc_url( 'https://jaas.8x8.vc/#/branding' ), __( 'jaas console', 'webinar-and-video-conference-with-jitsi-meet' ) );
	}
}
