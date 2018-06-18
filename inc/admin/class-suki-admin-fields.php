<?php
/**
 * Class contains render functions for all admin setting fields
 *
 * @package Suki
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Suki_Admin_Fields {
	/**
	 * ====================================================
	 * Render functions
	 * ====================================================
	 */

	/**
	 * Render function wrapper
	 *
	 * @param array $args
	 */
	public static function render_field( $args ) {
		if ( ! isset( $args['name'] ) ) return;

		$args = wp_parse_args( $args, array(
			'type'        => 'text',
			'description' => '',
		) );

		if ( ! isset( $args['id'] ) ) {
			$args['id'] = sanitize_html_class( preg_replace( '/\[(.*?)\]/', '__$1', $args['name'] ) );
		}

		$function = 'render_' . $args['type'];
		if ( method_exists( 'Suki_Admin_Fields', $function ) ) {
			self::$function( $args );
		}

		if ( '' !== $args['description'] ) : ?>
			<p class="description"><?php echo ( $args['description'] ); // WPCS: XSS OK ?></p>
		<?php endif;
	}

	/**
	 * Text control
	 *
	 * @param array $args
	 */
	private static function render_text( $args ) {
		if ( ! isset( $args['name'] ) ) return;

		$args = wp_parse_args( $args, array(
			'value'       => '',
			'placeholder' => '',
			'class'       => 'regular-text',
		) );
		?>
		<input type="text" id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>" class="suki-admin-text-control <?php echo esc_attr( $args['class'] ); ?>" value="<?php echo esc_attr( $args['value'] ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>">
		<?php
	}

	/**
	 * Textarea control
	 *
	 * @param array $args
	 */
	private static function render_textarea( $args ) {
		if ( ! isset( $args['name'] ) ) return;

		$args = wp_parse_args( $args, array(
			'value'       => '',
			'placeholder' => '',
			'class'       => 'regular-text',
			'rows'        => 3,
		) );
		?>
		<textarea id="<?php echo esc_attr( $args['id'] ); ?>" rows="<?php echo esc_attr( $args['rows'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>" class="suki-admin-text-control <?php echo esc_attr( $args['class'] ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"><?php echo esc_html( $args['value'] ); ?></textarea>
		<?php
	}

	/**
	 * URL control
	 *
	 * @param array $args
	 */
	private static function render_url( $args ) {
		if ( ! isset( $args['name'] ) ) return;

		$args = wp_parse_args( $args, array(
			'value'       => '',
			'placeholder' => '',
			'class'       => 'regular-text',
		) );
		?>
		<input type="url" id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>" class="suki-admin-url-control <?php echo esc_attr( $args['class'] ); ?>" value="<?php echo esc_attr( $args['value'] ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>">
		<?php
	}

	/**
	 * Number control
	 *
	 * @param array $args
	 */
	private static function render_number( $args ) {
		if ( ! isset( $args['name'] ) ) return;

		$args = wp_parse_args( $args, array(
			'value'       => '',
			'placeholder' => '',
			'min'         => '',
			'max'         => '',
			'step'        => '',
			'class'       => 'small-text',
		) );
		?>
		<input type="number" id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>" class="suki-admin-number-control <?php echo esc_attr( $args['class'] ); ?>" value="<?php echo esc_attr( $args['value'] ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>" min="<?php echo esc_attr( $args['min'] ); ?>" max="<?php echo esc_attr( $args['max'] ); ?>" step="<?php echo esc_attr( $args['step'] ); ?>">
		<?php
	}

	/**
	 * Checkbox control
	 *
	 * @param array $args
	 */
	private static function render_checkbox( $args ) {
		if ( ! isset( $args['name'] ) ) return;

		$args = wp_parse_args( $args, array(
			'value'        => '',
			'return_value' => 1,
			'label'        => '',
			'class'        => '',
			'wrapper'      => true,
		) );

		if ( $args['wrapper'] ) : ?>
			<fieldset>
		<?php endif; ?>

		<?php if ( ! empty( $args['label'] ) ) : ?>
			<label class="suki-admin-checkbox-control <?php echo esc_attr( $args['class'] ); ?>">
		<?php endif; ?>

		<input type="checkbox" id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>" value="<?php echo esc_attr( $args['return_value'] ); ?>" <?php checked( $args['return_value'], $args['value'] ); ?>>
		<?php echo ( $args['label'] ); // WPCS: XSS OK ?>
			
		<?php if ( ! empty( $args['label'] ) ) : ?>
			</label>
		<?php endif; ?>

		<?php if ( $args['wrapper'] ) : ?>
			</fieldset>
		<?php endif;
	}

	/**
	 * Color control
	 *
	 * @param array $args
	 */
	private static function render_color( $args ) {
		if ( ! isset( $args['name'] ) ) return;

		wp_enqueue_script( 'wp-color-picker-alpha' );

		$args = wp_parse_args( $args, array(
			'value'       => '',
			'default'     => '',
			'label'       => '',
			'class'       => '',
		) );
		?>
		<div class="suki-admin-color-control">
			<input type="text" id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>" value="<?php echo esc_attr( $args['value'] ); ?>" maxlength="30" placeholder="<?php esc_attr_e( 'Hex / RGBA', 'suki' ); ?>" data-default-color="<?php echo esc_attr( $args['default'] ); ?>" data-alpha="true">
		</div>
		<?php
	}

	/**
	 * Select control
	 *
	 * @param array $args
	 */
	private static function render_select( $args ) {
		if ( ! isset( $args['name'] ) ) return;

		$args = wp_parse_args( $args, array(
			'value'       => '',
			'placeholder' => '',
			'choices'     => array(),
			'class'       => '',
		) );
		?>
		<select id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>" class="suki-admin-select-control <?php echo esc_attr( $args['class'] ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>">
			<?php self::select_options_markup( $args['choices'], $args['value'] ); ?>
		</select>
		<?php
	}

	/**
	 * Multiselect control
	 *
	 * @param array $args
	 */
	private static function render_multiselect( $args ) {
		if ( ! isset( $args['name'] ) ) return;

		wp_enqueue_script( 'select2' );

		$args = wp_parse_args( $args, array(
			'value'       => array(),
			'placeholder' => '',
			'choices'     => array(),
			'class'       => 'widefat',
		) );
		?>
		<select id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['id'] ); ?>[]" multiple class="suki-admin-multiselect-control <?php echo esc_attr( $args['class'] ); ?>" data-placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>">
			<?php self::select_options_markup( $args['choices'], $args['value'] ); ?>
		</select>
		<?php
	}

	/**
	 * Upload control
	 *
	 * @param array $args
	 */
	private static function render_upload( $args ) {
		if ( ! isset( $args['name'] ) ) return;

		wp_enqueue_media();

		$args = wp_parse_args( $args, array(
			'value'        => '',
			'description'  => '',
			'placeholder'  => '',
			'class'        => 'regular-text',
			'library'      => '',
			'frame_title'  => esc_html__( 'Upload & choose file', 'suki' ),
			'frame_button' => esc_html__( 'Choose', 'suki' ),
		) );
		?>
		<span id="<?php echo esc_attr( $args['id'] ); ?>" class="suki-admin-upload-control" data-title="<?php echo esc_attr( $args['frame_title'] ); ?>" data-button="<?php echo esc_attr( $args['frame_button'] ); ?>" data-library="<?php echo esc_attr( implode( ',', (array) $args['library'] ) ); ?>">
			<input type="url" name="<?php echo esc_attr( $args['name'] ); ?>" value="<?php echo esc_attr( $args['value'] ); ?>" class="suki-admin-upload-control-text <?php echo esc_attr( $args['class'] ); ?>">
			<a href="#" class="suki-admin-upload-control-button button button-small"><span class="dashicons dashicons-upload"></span></a>
		</span>
		<?php
	}

	/**
	 * Repeater control
	 *
	 * @param array $args
	 */
	private static function render_repeater( $args ) {
		if ( ! isset( $args['name'] ) ) return;
		if ( 0 === count( $args['fields'] ) ) return;

		wp_enqueue_script( 'jquery-repeater' );

		$args = wp_parse_args( $args, array(
			'value'       => array(),
			'fields'      => array(),
			'class'       => '',
			'button_text' => esc_html__( 'Add New', 'suki' ),
			'start_empty' => true,
		) );

		foreach ( $args['fields'] as $id => $field ) {
			$args['fields'][ $id ] = wp_parse_args( $field, array(
				'type'        => 'text',
				'label'       => '',
				'placeholder' => '',
			) );
		}
		?>
		<div id="<?php echo esc_attr( $args['id'] ); ?>" class="suki-admin-repeater-control <?php echo esc_attr( $args['class'] ); ?>">
			<ul data-repeater-list="<?php echo esc_attr( $args['id'] ); ?>" class="suki-admin-repeater-control-list">
				<?php if ( 0 < count( $args['value'] ) ) : ?>
					<?php foreach ( $args['value'] as $i => $item ) : ?>
						<li data-repeater-item class="suki-admin-repeater-control-item postbox">
							<div class="suki-admin-form">
								<?php foreach ( $args['fields'] as $id => $field ) : ?>
									<div class="suki-admin-form-row">
										<?php if ( '' !== $field['label'] ) : ?>
											<label class="suki-admin-form-label"><?php echo ( $field['label'] ); // WPCS: XSS OK ?></label>
										<?php endif; ?>
										<div class="suki-admin-form-field">
											<?php
											$field['id'] = $id;
											$field['value'] = suki_array_value( $item, $id );

											self::render_field( $field );
											?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							
							<a href="javascript:;" data-repeater-delete type="button" class="suki-admin-repeater-control-delete button button-small"><span class="dashicons dashicons-no-alt"></span></a>
						</li>
					<?php endforeach; ?>
				<?php else: ?>
					<li data-repeater-item class="suki-admin-repeater-control-item postbox" <?php echo $args['start_empty'] ? 'style="display: none;"' : ''; ?>>
						<div class="suki-admin-form">
							<?php foreach ( $args['fields'] as $id => $field ) : ?>
								<div class="suki-admin-form-row">
									<?php if ( '' !== $field['label'] ) : ?>
										<label class="suki-admin-form-label"><?php echo ( $field['label'] ); // WPCS: XSS OK ?></label>
									<?php endif; ?>
									<div class="suki-admin-form-field">
										<?php
										$field['id'] = $id;

										switch ( $field['type'] ) {
											case 'select':
												$field['value'] = '';
												break;
											
											default:
												$field['value'] = '';
												break;
										}

										self::render_field( $field );
										?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>

						<a href="javascript:;" data-repeater-delete type="button" class="suki-admin-repeater-control-delete button button-small"><span class="dashicons dashicons-no-alt"></span></a>
					</li>
				<?php endif; ?>
			</ul>
			<input data-repeater-create type="button" class="suki-admin-repeater-control-add button" value="<?php echo esc_attr( $args['button_text'] ); ?>">
		</div>
		<?php
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	private static function select_options_markup( $array, $value = '', $echo = true ) {
		$output = '';

		if ( array_keys( $array ) === range( 0, count( $array ) - 1 ) ) {
			$array = self::convert_array_to_associative( $array );
		}

		foreach ( $array as $a1 => $a2 ) {

			if ( is_array( $a2 ) ) {
				// Add <optgroup> and do recursive
				$output .= '<optgroup label="' . esc_attr( $a1 ) . '">';
				$output .= self::select_options_markup( $a2, $value, false );
				$output .= '</optgroup>';
			} else {
				// Check selected state
				if ( is_array( $value ) ) {
					$selected = in_array( $a1, $value ) ? selected( true, true, false ) : '';
				} else {
					$selected = selected( $a1, $value, false );
				}

				$output .= '<option value="' . esc_attr( $a1 ) . '" ' . $selected . '>' . $a2 . '</option>';
			}
		}

		if ( $echo ) {
			echo $output; // WPCS: XSS OK
		} else {
			return $output;
		}
	}

	public static function convert_array_to_associative( $array ) {
		$assoc = array();

		foreach ( $array as $key => $value ) {
			$assoc[ $value ] = $value;
		}

		return $assoc;
	}

	/**
	 * ====================================================
	 * Sanitization functions
	 * ====================================================
	 */
	
	/**
	 * Sanitize checkbox.
	 * 
	 * @param boolean $value
	 * @return boolean
	 */
	public function sanitize_checkbox( $value ) {
		return 1 == $value ? 1 : 0;
	}
	
	/**
	 * Sanitize color picker palette entry.
	 * 
	 * @param array $values
	 * @return array
	 */
	public function sanitize_color( $values ) {
		$sanitized = array();
		
		foreach ( $values as $value ) {
			if ( preg_match( '/#([a-fA-F0-9]){3}(([a-fA-F0-9]){3})?\b/', $value ) || preg_match( '/rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)/', $value ) ) {
				$sanitized[] = $value;
			} else {
				$sanitized[] = '';
			}
		}

		return $sanitized;
	}
}