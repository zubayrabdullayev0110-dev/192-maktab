<?php
/**
 * Plugin Name:       192-maktab sayti
 * Description:       Shayxontohur tumanidagi 192-maktab sahifasi: [maktab192] shortkodi, to‘liq sahifa shabloni, sozlamalar va ota-onalar arizalari.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Text Domain:       maktab-192
 * License:           GPL-2.0-or-later
 *
 * @package Maktab192
 */

defined( 'ABSPATH' ) || exit;

define( 'MAKTAB192_VERSION', '1.0.0' );
define( 'MAKTAB192_FILE', __FILE__ );
define( 'MAKTAB192_DIR', plugin_dir_path( __FILE__ ) );
define( 'MAKTAB192_URL', plugin_dir_url( __FILE__ ) );
define( 'MAKTAB192_TEMPLATE', 'maktab192-full.php' );

/* -------------------------------------------------------------------------
 * Sozlamalar
 * ---------------------------------------------------------------------- */

/**
 * Default settings.
 *
 * @return array
 */
function maktab192_defaults() {
	return array(
		'phone'        => '+998 99 839 86 04',
		'address'      => 'Toshkent sh., Shayxontohur tumani, Ko‘kcha, Qo‘rg‘oncha ko‘chasi',
		'landmark'     => 'Ko‘kcha, «Koshona» to‘yxonasi ro‘parasida',
		'hours'        => 'Dushanba – Shanba, 8:00 – 19:00',
		'lat'          => '41.3265223',
		'lng'          => '69.1990431',
		'notify_email' => '',
		'tg_token'     => '',
		'tg_chat'      => '',
	);
}

/**
 * Saved settings merged over defaults.
 *
 * @return array
 */
function maktab192_options() {
	$saved = get_option( 'maktab192_options', array() );
	return wp_parse_args( is_array( $saved ) ? $saved : array(), maktab192_defaults() );
}

/**
 * Sanitize settings on save.
 *
 * @param array $in Raw input.
 * @return array
 */
function maktab192_sanitize( $in ) {
	$d   = maktab192_defaults();
	$in  = is_array( $in ) ? $in : array();
	$out = array();
	foreach ( array( 'phone', 'address', 'landmark', 'hours', 'tg_token', 'tg_chat' ) as $k ) {
		$out[ $k ] = isset( $in[ $k ] ) ? sanitize_text_field( $in[ $k ] ) : $d[ $k ];
	}
	foreach ( array( 'lat', 'lng' ) as $k ) {
		$v         = isset( $in[ $k ] ) ? str_replace( ',', '.', trim( $in[ $k ] ) ) : '';
		$out[ $k ] = is_numeric( $v ) ? $v : $d[ $k ];
	}
	$out['notify_email'] = isset( $in['notify_email'] ) ? sanitize_email( $in['notify_email'] ) : '';
	return $out;
}

add_action(
	'admin_init',
	function () {
		register_setting(
			'maktab192',
			'maktab192_options',
			array( 'sanitize_callback' => 'maktab192_sanitize' )
		);
	}
);

add_action(
	'admin_menu',
	function () {
		add_menu_page( '192-maktab', '192-maktab', 'manage_options', 'maktab192', 'maktab192_settings_page', 'dashicons-welcome-learn-more', 25 );
		add_submenu_page( 'maktab192', 'Sozlamalar', 'Sozlamalar', 'manage_options', 'maktab192', 'maktab192_settings_page' );
		add_submenu_page( 'maktab192', 'Arizalar', 'Arizalar', 'edit_posts', 'edit.php?post_type=maktab192_ariza' );
	}
);

/**
 * Settings screen.
 */
function maktab192_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$o      = maktab192_options();
	$page   = (int) get_option( 'maktab192_page_id' );
	$fields = array(
		'phone'        => array( 'Telefon raqam', 'Masalan: +998 71 123 45 67. Bo‘sh bo‘lsa, saytda ko‘rsatilmaydi.' ),
		'address'      => array( 'Manzil', '' ),
		'landmark'     => array( 'Mo‘ljal', '' ),
		'hours'        => array( 'Ish vaqti', '' ),
		'lat'          => array( 'Xarita: kenglik (lat)', '' ),
		'lng'          => array( 'Xarita: uzunlik (lng)', '' ),
		'notify_email' => array( 'Arizalar keladigan email', 'Bo‘sh bo‘lsa, sayt administratori email\'iga yuboriladi.' ),
		'tg_token'     => array( 'Telegram bot tokeni', 'Ixtiyoriy. @BotFather bergan token.' ),
		'tg_chat'      => array( 'Telegram chat ID', 'Ixtiyoriy. Arizalar shu chat yoki guruhga keladi.' ),
	);
	?>
	<div class="wrap">
		<h1>192-maktab — sozlamalar</h1>
		<?php if ( $page && get_post( $page ) ) : ?>
			<p>Maktab sahifasi: <a href="<?php echo esc_url( get_permalink( $page ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( get_permalink( $page ) ); ?></a></p>
		<?php endif; ?>
		<p>Sahifani istalgan joyga qo‘yish uchun shortkod: <code>[maktab192]</code></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'maktab192' ); ?>
			<table class="form-table" role="presentation">
				<?php foreach ( $fields as $key => $f ) : ?>
					<tr>
						<th scope="row"><label for="m192-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $f[0] ); ?></label></th>
						<td>
							<input class="regular-text" id="m192-<?php echo esc_attr( $key ); ?>" name="maktab192_options[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $o[ $key ] ); ?>" type="<?php echo 'notify_email' === $key ? 'email' : 'text'; ?>">
							<?php if ( $f[1] ) : ?><p class="description"><?php echo esc_html( $f[1] ); ?></p><?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php submit_button( 'Saqlash' ); ?>
		</form>
	</div>
	<?php
}

/* -------------------------------------------------------------------------
 * Arizalar (ota-onalar arizasi) — ichki post turi
 * ---------------------------------------------------------------------- */

add_action(
	'init',
	function () {
		register_post_type(
			'maktab192_ariza',
			array(
				'labels'          => array(
					'name'          => 'Arizalar',
					'singular_name' => 'Ariza',
					'edit_item'     => 'Arizani ko‘rish',
					'search_items'  => 'Arizalarni qidirish',
					'not_found'     => 'Hozircha ariza yo‘q',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => false,
				'supports'        => array( 'title' ),
				'capability_type' => 'post',
				'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'    => true,
			)
		);
	}
);

/**
 * Field labels for an application.
 *
 * @return array
 */
function maktab192_ariza_fields() {
	return array(
		'ota_ona' => 'Ota-ona',
		'telefon' => 'Telefon',
		'farzand' => 'Farzand',
		'sinf'    => 'Sinf',
		'savol'   => 'Savol',
	);
}

add_filter(
	'manage_maktab192_ariza_posts_columns',
	function () {
		return array(
			'cb'      => '<input type="checkbox" />',
			'title'   => 'Ota-ona',
			'telefon' => 'Telefon',
			'farzand' => 'Farzand',
			'sinf'    => 'Sinf',
			'date'    => 'Sana',
		);
	}
);

add_action(
	'manage_maktab192_ariza_posts_custom_column',
	function ( $col, $post_id ) {
		$v = get_post_meta( $post_id, $col, true );
		if ( 'telefon' === $col && $v ) {
			printf( '<a href="tel:%s">%s</a>', esc_attr( preg_replace( '/[^0-9+]/', '', $v ) ), esc_html( $v ) );
			return;
		}
		echo esc_html( $v );
	},
	10,
	2
);

add_action(
	'add_meta_boxes_maktab192_ariza',
	function () {
		add_meta_box(
			'maktab192_ariza_info',
			'Ariza ma’lumotlari',
			function ( $post ) {
				echo '<table class="widefat striped"><tbody>';
				foreach ( maktab192_ariza_fields() as $k => $label ) {
					printf( '<tr><th style="width:160px">%s</th><td>%s</td></tr>', esc_html( $label ), nl2br( esc_html( get_post_meta( $post->ID, $k, true ) ) ) );
				}
				echo '</tbody></table>';
			},
			null,
			'normal',
			'high'
		);
	}
);

/**
 * Handle the front-end application form (AJAX).
 */
function maktab192_submit() {
	check_ajax_referer( 'maktab192_ariza', 'nonce' );

	if ( ! empty( $_POST['bot_field'] ) ) {
		wp_send_json_success(); // Spam: jim qabul qilamiz.
	}

	$data = array();
	foreach ( array_keys( maktab192_ariza_fields() ) as $k ) {
		$raw        = isset( $_POST[ $k ] ) ? wp_unslash( $_POST[ $k ] ) : '';
		$data[ $k ] = 'savol' === $k ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
	}
	$data['savol'] = mb_substr( $data['savol'], 0, 2000 );

	if ( '' === $data['ota_ona'] || '' === $data['farzand'] || '' === $data['sinf'] || ! preg_match( '/^[+0-9 ()\-]{9,20}$/', $data['telefon'] ) ) {
		wp_send_json_error( array( 'message' => 'Iltimos, barcha maydonlarni to‘g‘ri to‘ldiring.' ), 400 );
	}

	// Bir IP dan daqiqasiga bittadan ortiq ariza qabul qilinmaydi.
	$ip_key = 'maktab192_rl_' . md5( isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '' );
	if ( get_transient( $ip_key ) ) {
		wp_send_json_error( array( 'message' => 'Iltimos, bir ozdan keyin qayta urinib ko‘ring.' ), 429 );
	}
	set_transient( $ip_key, 1, MINUTE_IN_SECONDS );

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'maktab192_ariza',
			'post_status' => 'private',
			'post_title'  => $data['ota_ona'],
		),
		true
	);
	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( array( 'message' => 'Xatolik yuz berdi.' ), 500 );
	}
	foreach ( $data as $k => $v ) {
		update_post_meta( $post_id, $k, $v );
	}

	maktab192_notify( $data, $post_id );
	wp_send_json_success();
}
add_action( 'wp_ajax_maktab192_ariza', 'maktab192_submit' );
add_action( 'wp_ajax_nopriv_maktab192_ariza', 'maktab192_submit' );

/**
 * Send email (and optionally Telegram) notification about a new application.
 *
 * @param array $data    Application fields.
 * @param int   $post_id Application post ID.
 */
function maktab192_notify( $data, $post_id ) {
	$o     = maktab192_options();
	$lines = array( 'Yangi ariza — 192-maktab', '' );
	foreach ( maktab192_ariza_fields() as $k => $label ) {
		if ( '' !== $data[ $k ] ) {
			$lines[] = $label . ': ' . $data[ $k ];
		}
	}
	$lines[] = '';
	$lines[] = admin_url( 'post.php?post=' . $post_id . '&action=edit' );
	$text    = implode( "\n", $lines );

	$to = $o['notify_email'] ? $o['notify_email'] : get_option( 'admin_email' );
	wp_mail( $to, 'Yangi ariza: ' . $data['farzand'] . ' (' . $data['sinf'] . ')', $text );

	if ( $o['tg_token'] && $o['tg_chat'] ) {
		wp_remote_post(
			'https://api.telegram.org/bot' . rawurlencode( $o['tg_token'] ) . '/sendMessage',
			array(
				'timeout'  => 8,
				'blocking' => false,
				'body'     => array(
					'chat_id' => $o['tg_chat'],
					'text'    => $text,
				),
			)
		);
	}
}

/* -------------------------------------------------------------------------
 * Front: shortkod, assetlar, to‘liq sahifa shabloni
 * ---------------------------------------------------------------------- */

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_register_style( 'maktab192-fonts', 'https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Caveat:wght@600;700&display=swap', array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_register_style( 'maktab192', MAKTAB192_URL . 'assets/maktab.css', array( 'maktab192-fonts' ), MAKTAB192_VERSION );
		wp_register_script( 'maktab192', MAKTAB192_URL . 'assets/maktab.js', array(), MAKTAB192_VERSION, true );
		wp_localize_script(
			'maktab192',
			'MAKTAB192',
			array(
				'ajax'  => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'maktab192_ariza' ),
			)
		);
		if ( maktab192_is_full_page() ) {
			wp_enqueue_style( 'maktab192' );
			wp_enqueue_script( 'maktab192' );
		}
	}
);

/**
 * Render the school page markup.
 *
 * @return string
 */
function maktab192_render() {
	wp_enqueue_style( 'maktab192' );
	wp_enqueue_script( 'maktab192' );
	ob_start();
	include MAKTAB192_DIR . 'templates/school.php';
	return ob_get_clean();
}
add_shortcode( 'maktab192', 'maktab192_render' );

/**
 * Whether the current request is a page using the plugin's full-page template.
 *
 * @return bool
 */
function maktab192_is_full_page() {
	return is_page() && MAKTAB192_TEMPLATE === get_page_template_slug( get_queried_object_id() );
}

add_filter(
	'theme_page_templates',
	function ( $templates ) {
		$templates[ MAKTAB192_TEMPLATE ] = '192-maktab (to‘liq sahifa)';
		return $templates;
	}
);

add_filter(
	'template_include',
	function ( $template ) {
		return maktab192_is_full_page() ? MAKTAB192_DIR . 'templates/full-page.php' : $template;
	}
);

// To‘liq sahifada mavzu (theme) stillari dizaynni buzmasligi uchun ularni o‘chiramiz.
add_action(
	'wp_print_styles',
	function () {
		if ( ! maktab192_is_full_page() ) {
			return;
		}
		$keep = array( 'maktab192', 'maktab192-fonts', 'admin-bar', 'dashicons' );
		foreach ( wp_styles()->queue as $handle ) {
			if ( ! in_array( $handle, $keep, true ) ) {
				wp_dequeue_style( $handle );
			}
		}
	},
	100
);

/* -------------------------------------------------------------------------
 * Faollashtirish: maktab sahifasini yaratish
 * ---------------------------------------------------------------------- */

register_activation_hook(
	__FILE__,
	function () {
		$existing = (int) get_option( 'maktab192_page_id' );
		if ( $existing && get_post( $existing ) ) {
			return;
		}
		$page_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => '192-maktab',
				'post_name'    => 'maktab-192',
				'post_content' => '<!-- wp:shortcode -->[maktab192]<!-- /wp:shortcode -->',
			)
		);
		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', MAKTAB192_TEMPLATE );
			update_option( 'maktab192_page_id', $page_id );
		}
	}
);

add_filter(
	'plugin_action_links_' . plugin_basename( __FILE__ ),
	function ( $links ) {
		array_unshift( $links, '<a href="' . esc_url( admin_url( 'admin.php?page=maktab192' ) ) . '">Sozlamalar</a>' );
		return $links;
	}
);
