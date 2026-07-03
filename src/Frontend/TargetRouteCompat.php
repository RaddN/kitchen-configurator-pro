<?php
/**
 * Target configurator subdomain route compatibility.
 *
 * @package KitchenConfiguratorPro
 */

declare(strict_types=1);

namespace KitchenConfiguratorPro\Frontend;

use KitchenConfiguratorPro\Support\Helpers;

/**
 * Maps the reference site's .html URL contract onto WordPress/WooCommerce views.
 */
final class TargetRouteCompat {

	private const REWRITE_VERSION = '3';

	public const ROUTE_CONFIGURATOR = 'configurator';
	public const ROUTE_CONFIGURATOR_EMPTY = 'configurator_empty';
	public const ROUTE_ASSISTANT = 'assistant';
	public const ROUTE_SHOP_HOME = 'shop_home';
	public const ROUTE_CHECKOUT_EMPTY = 'checkout_empty';

	/**
	 * Register hooks.
	 */
	public function register(): void {
		add_action( 'init', array( $this, 'register_rewrite_rules' ), 18 );
		add_action( 'init', array( $this, 'maybe_flush_rewrite_rules' ), 100 );
		add_filter( 'query_vars', array( $this, 'register_query_vars' ) );
		add_filter( 'redirect_canonical', array( $this, 'disable_canonical_redirect' ), 10, 2 );
		add_filter( 'pre_get_document_title', array( $this, 'document_title' ), 99 );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'template_redirect', array( $this, 'render_virtual_route' ), 2 );
	}

	/**
	 * Register exact target-style .html routes.
	 */
	public function register_rewrite_rules(): void {
		add_rewrite_rule( '^configurator\.html$', 'index.php?kcp_target_route=' . self::ROUTE_CONFIGURATOR, 'top' );
		add_rewrite_rule( '^configurator/-\.html$', 'index.php?kcp_target_route=' . self::ROUTE_CONFIGURATOR_EMPTY, 'top' );
		add_rewrite_rule( '^assistent\.html$', 'index.php?kcp_target_route=' . self::ROUTE_ASSISTANT, 'top' );
		add_rewrite_rule( '^shop\.html$', 'index.php?kcp_target_route=' . self::ROUTE_SHOP_HOME, 'top' );
		add_rewrite_rule( '^afrekenen/-\.html$', 'index.php?kcp_target_route=' . self::ROUTE_CHECKOUT_EMPTY, 'top' );
		add_rewrite_rule( '^afrekenen\.html$', 'index.php?pagename=cart', 'top' );

		if ( class_exists( 'WooCommerce' ) ) {
			add_rewrite_rule( '^shop/vipp/verlichting/wandlamp\.html$', 'index.php?product=wandlamp', 'top' );
			add_rewrite_rule( '^shop/([^/]+)\.html$', 'index.php?product_cat=$matches[1]', 'top' );
			add_rewrite_rule( '^shop/([^/]+)/([^/]+)\.html$', 'index.php?product_cat=$matches[2]', 'top' );
		}
	}

	/**
	 * @param array<int, string> $vars Public query vars.
	 * @return array<int, string>
	 */
	public function register_query_vars( array $vars ): array {
		$vars[] = 'kcp_target_route';

		return $vars;
	}

	/**
	 * Whether the current request is one of the virtual target routes.
	 */
	public static function is_route( string $route = '' ): bool {
		$current = (string) get_query_var( 'kcp_target_route', '' );

		if ( '' === $route ) {
			return '' !== $current;
		}

		return $current === $route;
	}

	/**
	 * Whether the current virtual route should use the KKF shell.
	 */
	public static function uses_shell(): bool {
		return self::is_route();
	}

	/**
	 * Whether the current request is using the target .html URL surface.
	 */
	public static function is_target_request(): bool {
		if ( self::is_route() ) {
			return true;
		}

		$path = self::current_relative_request_path();

		return (bool) (
			preg_match( '#^(?:configurator|assistent|shop|afrekenen)(?:/.*)?\.html$#', $path )
			|| preg_match( '#^kasten/.+\.html$#', $path )
		);
	}

	/**
	 * Target-compatible configurator URL.
	 */
	public static function configurator_url(): string {
		return home_url( '/configurator.html' );
	}

	/**
	 * Target-compatible webshop URL.
	 */
	public static function shop_home_url(): string {
		return home_url( '/shop.html' );
	}

	/**
	 * Target-compatible cart URL.
	 */
	public static function cart_url(): string {
		return home_url( '/afrekenen.html' );
	}

	/**
	 * Add storefront classes to virtual target pages.
	 *
	 * @param array<int, string> $classes Body classes.
	 * @return array<int, string>
	 */
	public function body_class( array $classes ): array {
		if ( self::is_route( self::ROUTE_SHOP_HOME ) ) {
			$classes[] = 'kcp-shop-active';
			$classes[] = 'kcp-shop-home-active';
		}

		return $classes;
	}

	/**
	 * Enqueue assets for target virtual pages that bypass WooCommerce templates.
	 */
	public function enqueue_assets(): void {
		if ( ! self::is_route( self::ROUTE_SHOP_HOME ) ) {
			return;
		}

		wp_enqueue_style(
			'kcp-shop',
			KCP_PLUGIN_URL . 'assets/frontend/css/shop.css',
			array(),
			KCP_VERSION
		);
	}

	/**
	 * Keep target .html URLs stable; WordPress would otherwise append a slash.
	 *
	 * @param string|false $redirect_url  Canonical redirect URL.
	 * @param string       $requested_url Requested URL.
	 * @return string|false
	 */
	public function disable_canonical_redirect( string|false $redirect_url, string $requested_url ): string|false {
		$path = (string) wp_parse_url( $requested_url, PHP_URL_PATH );

		if ( preg_match( '#/(?:configurator|assistent|shop|afrekenen)(?:/.*)?\.html$#', $path ) ) {
			return false;
		}

		if ( preg_match( '#/kasten/.+\.html$#', $path ) ) {
			return false;
		}

		return $redirect_url;
	}

	/**
	 * Override titles for target aliases that map to existing WP/Woo routes.
	 *
	 * @param string $title Document title.
	 */
	public function document_title( string $title ): string {
		if ( 'afrekenen.html' === $this->current_request_path() ) {
			return __( 'Afrekenen', 'kitchen-configurator-pro' );
		}

		return $title;
	}

	/**
	 * Render virtual routes that do not map to a real WP object.
	 */
	public function render_virtual_route(): void {
		$route = (string) get_query_var( 'kcp_target_route', '' );

		if ( '' === $route ) {
			return;
		}

		status_header( 200 );

		global $wp_query;
		if ( $wp_query instanceof \WP_Query ) {
			$wp_query->is_404 = false;
		}

		$title = $this->title_for_route( $route );
		if ( '' !== $title ) {
			add_filter(
				'pre_get_document_title',
				static fn (): string => $title,
				99
			);
		}

		get_header();

		if ( self::ROUTE_CONFIGURATOR === $route ) {
			echo do_shortcode( '[kcp_configurator_landing]' );
		} elseif ( self::ROUTE_SHOP_HOME === $route ) {
			$template = KCP_PLUGIN_DIR . 'templates/woocommerce/partials/shop-home.php';

			if ( is_readable( $template ) ) {
				include $template;
			}
		}

		get_footer();
		exit;
	}

	/**
	 * @return string
	 */
	private function title_for_route( string $route ): string {
		return match ( $route ) {
			self::ROUTE_CONFIGURATOR => __( 'Configurator | jouw nieuwe keukenkasten zelf online samenstellen', 'kitchen-configurator-pro' ),
			self::ROUTE_ASSISTANT => __( 'Virtuele Assistent | Wij helpen jou op weg naar jouw nieuwe keuken', 'kitchen-configurator-pro' ),
			self::ROUTE_SHOP_HOME => __( 'KeukenKastenFabriek | webwinkel voor Vipp Quooker en Buster+Punch', 'kitchen-configurator-pro' ),
			default => '',
		};
	}

	/**
	 * Current request path relative to the WordPress home path.
	 */
	private function current_request_path(): string {
		return self::current_relative_request_path();
	}

	/**
	 * Current request path relative to the WordPress home path.
	 */
	private static function current_relative_request_path(): string {
		$uri = isset( $_SERVER['REQUEST_URI'] )
			? (string) wp_unslash( $_SERVER['REQUEST_URI'] )
			: '';
		$path = trim( (string) wp_parse_url( $uri, PHP_URL_PATH ), '/' );

		if ( '' === $path ) {
			return '';
		}

		$home_path = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );

		if ( '' !== $home_path && str_starts_with( $path, $home_path . '/' ) ) {
			return substr( $path, strlen( $home_path ) + 1 );
		}

		return $path;
	}

	/**
	 * Flush rewrite rules after this compatibility map changes.
	 */
	public function maybe_flush_rewrite_rules(): void {
		$stored_version = (string) get_option( 'kcp_target_route_rewrite_version', '' );

		if ( self::REWRITE_VERSION === $stored_version ) {
			return;
		}

		update_option( 'kcp_target_route_rewrite_version', self::REWRITE_VERSION, false );
		Helpers::flush_rewrite_rules();
	}
}
