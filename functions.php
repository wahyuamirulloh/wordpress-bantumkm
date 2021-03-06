<?php
$version = wp_get_theme()->get('version');

function wp_register_styles() {
	wp_enqueue_style('bantumkm_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css', $version);
	wp_enqueue_style('bantumkm_style', get_template_directory_uri() . '/style.css', $version);
	wp_enqueue_style('raleway_fonts', get_template_directory_uri() . '/assets/fonts/Raleway-Regular.ttf', $version);
	wp_enqueue_style('open_sans_fonts', get_template_directory_uri() . '/assets/fonts/OpenSans-Regular.ttf', $version);
}
function wp_register_scripts() {
	wp_enqueue_script('bantumkm_script', get_template_directory_uri() . '/assets/js/script.js', $version);
}

// WordPress theme support
function wp_theme_support() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('custom-logo', array(
		'height' => 200,
		'width' => 400
	));
}

// Custom Post Type Product
function wp_custom_post_type_product() {
	$support = array(
		'title',
		'custom-fields',
		'editor',
		'thumbnail',
	);
	$labels = array(
		'name' => _x('Produk', 'plural'),
		'singular_name' => _x('Produk', 'singular'),
		'add_new' => _x('Tambah Produk', 'add new')
	);
	$args = array(
		'supports' => $support,
		'labels' => $labels,
		'description' => 'Add your product to be displayed on Product page',
		'public' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'product'),
		'has_archive' => true,
		'publicly_queryable' => true,
	);
	register_post_type('Products', $args);
}

// Custom Post Type Blog
function wp_custom_post_type_blog() {
	$support = array(
		'title',
		'editor',
		'thumbnail',
	);
	$labels = array(
		'name' => _x('Blog', 'plural'),
		'singular_name' => _x('Blog', 'singular'),
		'add_new' => _x('Tambah Blog', 'add new')
	);
	$args = array(
		'supports' => $support,
		'labels' => $labels,
		'public' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'blog'),
		'has_archive' => true,
		'taxonomies' => array('post_tag'),
	);
	register_post_type('Blog', $args);
}

// ACF Add Local Fields
if( function_exists('acf_add_local_field_group') ){
	acf_add_local_field_group(
		array(
			'key' => 'product_group',
			'title' => 'Pengaturan Produk',
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'products'
					),
				),
			),
		),
	);

	// Product Price ACF
	acf_add_local_field(array(
		'key' => 'price_field',
		'label' => 'Harga',
		'name' => 'price',
		'type' => 'number',
		'parent' => 'product_group',
	));

	// Product Discount ACF
	acf_add_local_field(array(
		'key' => 'discount_field',
		'label' => 'Diskon (%)',
		'name' => 'discount',
		'type' => 'number',
		'parent' => 'product_group',
	));

	// Product Promo ACF
	acf_add_local_field(array(
		'key' => 'promo_field',
		'label' => 'Promosi Produk',
		'name' => 'promo',
		'type' => 'checkbox',
		'choices' => array(
			'gratisongkir' => '🚚 Gratis Ongkir',
			'cashback' => '💰 Cashback',
			'cod' => '💵 Bayar di Tempat',
		),
		'return_format' => 'label',
		'parent' => 'product_group'
	));

	// Product Shipped From ACF
	acf_add_local_field(array(
		'key' => 'shipped_field',
		'label' => 'Dikirim Dari',
		'name' => 'shipped',
		'type' => 'text',
		'parent' => 'product_group',
	));
}


// Navigation Menu
function register_my_menus(){
	register_nav_menu(
		'header-menu', __('Header Menu')
	);
}

// Customize Register Contacts
function wp_customize_register_contactsinfo($wp_customize) {
	$wp_customize->add_section('wp_contactinfo_section', array(
		'title' => 'Informasi Kontak',
		'priority' => 30
	));

	$wp_customize->add_setting('wp_contactinfo-contact', array());
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'wp_contactinfo_control',
		array(
			'label' => __('Informasi Kontak', 'wp'),
			'description' => 'Akan digunakan sebagai link menuju WhatsApp kamu disetiap produk, gunakan 62xx',
			'section' => 'wp_contactinfo_section',
			'settings' => 'wp_contactinfo-contact',
			'priority' => 1,
			'default' => '6281283708972'
		)
	));

	$wp_customize->add_setting('wp_contactinfo-address', array());
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'wp_contactaddress_control',
		array(
			'label' => __('Informasi Alamat', 'wp'),
			'description' => 'Alamat yang akan dicantumkan di footer untuk memudahkan pembeli menemukan lokasi',
			'section' => 'wp_contactinfo_section',
			'settings' => 'wp_contactinfo-address',
			'priority' => 1,
			'default' => 'Jl. Kh. Umar Rawailat'
		)
	));
}

// Customize Register GreetingsOrder
function wp_customize_register_greetingsorder($wp_customize) {
	$wp_customize->add_section('wp_greetingsorder_section', array(
		'title' => 'Kata Sapaan Orderan',
		'priority' => 30
	));

	$wp_customize->add_setting('wp_greetingsorder-text', array());
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'wp_greetingsorder_control',
		array(
			'label' => __('Sapaan Untuk Pelanggan', 'wp'),
			'description' => 'Digunakan sebagai perkataan sapaan untuk pelanggan saat memesan barang ( Contoh : Halo, Selamat Pagi )',
			'section' => 'wp_greetingsorder_section',
			'settings' => 'wp_greetingsorder-text',
			'priority' => 1,
			'default' => 'Halo, Selamat pagi'
		)
	));
}

// Customize Konfigurasi Tambahan
function wp_customize_register_advancedsetting($wp_customize) {
	$wp_customize->add_section('wp_advconfig_section', array(
		'title' => 'Konfigurasi Tambahan',
		'priority' => 30
	));
	
	$wp_customize->add_setting('wp_advconfig-subtextproduk', array());
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'wp_advconfig_subtextproduk',
		array(
			'label' => __('Sub-Text untuk halaman Produk', 'wp'),
			'description' => 'Masukkan kalimat untuk subtext pada heading Produk ( Contoh : Produk murah tiap hari )',
			'section' => 'wp_advconfig_section',
			'settings' => 'wp_advconfig-subtextproduk',
			'priority' => 1,
			'default' => 'Produk murah setiap hari !'
		)
	));

	$wp_customize->add_setting('wp_advconfig-subtextblog', array());
	$wp_customize->add_control(new WP_Customize_Control(
		$wp_customize,
		'wp_advconfig_subtextblog',
		array(
			'label' => __('Sub-Text untuk halaman Blog dan Berita', 'wp'),
			'description' => 'Masukkan kalimat untuk subtext pada heading Blog dan Berita ( Contoh : Berita terbaru yang paling akurat )',
			'section' => 'wp_advconfig_section',
			'settings' => 'wp_advconfig-subtextblog',
			'priority' => 1,
			'default' => 'Berita terbaru dan teraktual hari ini'
		)
	));
}

// Bootstrap a button post link
function post_link_attributes_bootsbutton() {
	return 'class="btn btn-primary"';
}

// Excerpt Limit
function wp_custom_excerpt_limit($length) {
	return 20;
}

// Customize website functionality
add_action('wp_enqueue_scripts', 'wp_register_styles');
add_action('wp_enqueue_scripts', 'wp_register_scripts');
add_action('after_setup_theme', 'wp_theme_support');

// Registering post type
add_action('init', 'wp_custom_post_type_product');
add_action('init', 'wp_custom_post_type_blog');

// Registering nav menu
add_action('init', 'register_my_menus');

// Register Customize Register
add_action('customize_register', 'wp_customize_register_contactsinfo');
add_action('customize_register', 'wp_customize_register_greetingsorder');
add_action('customize_register', 'wp_customize_register_advancedsetting');

// Excerpt Configuration
add_filter('excerpt_more', function(){
	return ' ...';
});

// Applying excerpt limit
add_filter('excerpt_length', 'wp_custom_excerpt_limit');

// Applying Bootstrap Button Style post_link
add_filter('next_posts_link_attributes', 'post_link_attributes_bootsbutton');
add_filter('previous_posts_link_attributes', 'post_link_attributes_bootsbutton');

?>