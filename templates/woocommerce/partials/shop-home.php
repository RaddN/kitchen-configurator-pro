<?php
/**
 * Target webshop homepage.
 *
 * @package KitchenConfiguratorPro
 */

defined( 'ABSPATH' ) || exit;

use KitchenConfiguratorPro\Services\ShopBrandLandingService;

$asset_url = static function ( string $filename ): string {
	return KCP_PLUGIN_URL . 'assets/frontend/images/shop-promo/' . ltrim( $filename, '/' );
};

$target_url = static function ( string $path ): string {
	return home_url( '/' . ltrim( $path, '/' ) );
};

$categories = array(
	array(
		'label'    => 'BORA',
		'url'      => $target_url( 'shop/bora.html' ),
		'children' => array(),
	),
	array(
		'label'    => 'Quooker',
		'url'      => $target_url( 'shop/quooker.html' ),
		'children' => array(
			array( 'label' => 'Quooker front', 'url' => $target_url( 'shop/quooker/quooker-front.html' ) ),
			array( 'label' => 'Quooker flex', 'url' => $target_url( 'shop/quooker/quooker-flex.html' ) ),
			array( 'label' => 'Quooker fusion square', 'url' => $target_url( 'shop/quooker/quooker-fusion-square.html' ) ),
			array( 'label' => 'Quooker fusion round', 'url' => $target_url( 'shop/quooker/quooker-fusion-round.html' ) ),
			array( 'label' => 'Quooker classic fusion square', 'url' => $target_url( 'shop/quooker/quooker-classic-fusion-square.html' ) ),
			array( 'label' => 'Quooker classic fusion round', 'url' => $target_url( 'shop/quooker/quooker-classic-fusion-round.html' ) ),
			array( 'label' => 'Quooker zeeppomp', 'url' => $target_url( 'shop/quooker/quooker-zeeppomp.html' ) ),
		),
	),
	array(
		'label'    => 'vipp',
		'url'      => $target_url( 'shop/vipp.html' ),
		'children' => array(
			array( 'label' => 'meubels', 'url' => $target_url( 'shop/vipp/meubels.html' ) ),
			array( 'label' => 'accessoires', 'url' => $target_url( 'shop/vipp/accessoires.html' ) ),
			array( 'label' => 'pedaalemmer', 'url' => $target_url( 'shop/vipp/pedaalemmer.html' ) ),
			array( 'label' => 'verlichting', 'url' => $target_url( 'shop/vipp/verlichting.html' ) ),
			array( 'label' => 'servies', 'url' => $target_url( 'shop/vipp/servies.html' ) ),
		),
	),
	array(
		'label'    => 'monsterbox',
		'url'      => $target_url( 'shop/monsterbox.html' ),
		'children' => array(),
	),
	array(
		'label'    => 'Buster+Punch',
		'url'      => $target_url( 'shop/buster-punch.html' ),
		'children' => array(
			array( 'label' => 'closet bar', 'url' => $target_url( 'shop/buster-punch/closet-bar.html' ) ),
			array( 'label' => 'furniture knob', 'url' => $target_url( 'shop/buster-punch/furniture-knob.html' ) ),
			array( 'label' => 'pull bar', 'url' => $target_url( 'shop/buster-punch/pull-bar.html' ) ),
		),
	),
	array(
		'label'    => 'spoelbakken',
		'url'      => $target_url( 'shop/spoelbakken.html' ),
		'children' => array(
			array( 'label' => 'accessoires', 'url' => $target_url( 'shop/spoelbakken/accessoires.html' ) ),
			array( 'label' => 'Spoelbakken black line', 'url' => $target_url( 'shop/spoelbakken/spoelbakken-black-line.html' ) ),
			array( 'label' => 'spoelbakken gun metal', 'url' => $target_url( 'shop/spoelbakken/spoelbakken-gun-metal.html' ) ),
			array( 'label' => 'spoelbakken roestvrij staal', 'url' => $target_url( 'shop/spoelbakken/spoelbakken-roestvrij-staal.html' ) ),
			array( 'label' => 'spoelbakken white line', 'url' => $target_url( 'shop/spoelbakken/spoelbakken-white-line.html' ) ),
		),
	),
	array(
		'label'    => 'kastindeling & accessoires',
		'url'      => $target_url( 'shop/kastindeling-accessoires.html' ),
		'children' => array(
			array( 'label' => 'bestekindeling kunststof', 'url' => $target_url( 'shop/kastindeling-accessoires/bestekindeling-kunststof.html' ) ),
			array( 'label' => 'stopcontacten', 'url' => $target_url( 'shop/kastindeling-accessoires/stopcontacten.html' ) ),
			array( 'label' => 'opleggreep', 'url' => $target_url( 'shop/kastindeling-accessoires/opleggreep.html' ) ),
			array( 'label' => 'antislipmat op rol', 'url' => $target_url( 'shop/kastindeling-accessoires/antislipmat-op-rol.html' ) ),
		),
	),
	array(
		'label'    => 'kunststofreiniger',
		'url'      => $target_url( 'shop/kunststofreiniger.html' ),
		'children' => array(),
	),
);

$static_cards = array(
	array(
		'label'       => 'Quooker fusion square',
		'url'         => $target_url( 'shop/quooker/quooker-fusion-square.html' ),
		'price'       => '1.390,-',
		'was'         => '1.745,-',
		'stock'       => 'op voorraad',
		'brand_label' => 'Quooker',
	),
	array(
		'label'       => 'Quooker front',
		'url'         => $target_url( 'shop/quooker/quooker-front.html' ),
		'price'       => '1.310,-',
		'was'         => '1.645,-',
		'stock'       => 'op voorraad',
		'brand_label' => 'Quooker',
	),
	array(
		'label'       => 'Quooker flex',
		'url'         => $target_url( 'shop/quooker/quooker-flex.html' ),
		'price'       => '1.550,-',
		'was'         => '1.945,-',
		'stock'       => 'op voorraad',
		'brand_label' => 'Quooker',
	),
);

$popular_cards = array(
	array( 'label' => 'monsterbox', 'url' => $target_url( 'shop/monsterbox.html' ), 'price' => '35,-', 'stock' => 'op voorraad' ),
	array( 'label' => 'kunststofreiniger', 'url' => $target_url( 'shop/kunststofreiniger.html' ), 'price' => '50,-', 'stock' => 'op voorraad' ),
	array( 'label' => 'stopcontacten', 'url' => $target_url( 'shop/kastindeling-accessoires/stopcontacten.html' ), 'price' => '25,-', 'stock' => 'op voorraad' ),
	array( 'label' => 'elektronisch push to open systeem', 'url' => $target_url( 'shop/kastindeling-accessoires/elektronisch-push-to-open-systeem.html' ), 'price' => '40,-', 'stock' => 'op voorraad' ),
);

$promo_tiles = array(
	array(
		'label' => 'van MoMa, zo jouw keuken in',
		'url'   => $target_url( 'shop/vipp/pedaalemmer.html' ),
		'image' => $asset_url( 'vipp-poster.jpg' ),
	),
	array(
		'label' => 'de perfecte greep van Buster + Punch',
		'url'   => $target_url( 'shop/buster-punch.html' ),
		'image' => $asset_url( 'buster-poster.jpg' ),
	),
	array(
		'label' => 'de fijnste accessoires van vipp',
		'url'   => $target_url( 'shop/vipp/accessoires.html' ),
		'image' => $asset_url( 'quooker-poster.jpg' ),
	),
);

$usps = array(
	array( 'icon' => 'sneller-rondje.svg', 'label' => 'geen verzendkosten voor accessoires' ),
	array( 'icon' => 'hulp-rondje.svg', 'label' => '4.8/5 beoordeling keukenkastenfabriek' ),
	array( 'icon' => 'palet-rondje.svg', 'label' => 'alleen de beste premium merken' ),
	array( 'icon' => 'fabriek-rondje.svg', 'label' => 'showroom met ondersteuning' ),
);

$quooker_products = function_exists( 'wc_get_products' )
	? wc_get_products(
		array(
			'status'   => 'publish',
			'limit'    => 3,
			'category' => array( 'quooker' ),
			'orderby'  => 'date',
			'order'    => 'DESC',
		)
	)
	: array();

$quooker_products = array_values(
	array_filter(
		$quooker_products,
		static fn ( $product ): bool => $product instanceof WC_Product && $product->is_visible()
	)
);

$render_static_card = static function ( array $card ) use ( $asset_url ): void {
	$brand_label = (string) ( $card['brand_label'] ?? '' );
	?>
	<a class="kcp-shop-home-card" href="<?php echo esc_url( (string) ( $card['url'] ?? '#' ) ); ?>">
		<span class="kcp-shop-home-card__media" aria-hidden="true">
			<span class="kcp-shop-home-card__badge"><?php echo esc_html( '' !== $brand_label ? $brand_label : 'KKF' ); ?></span>
			<img class="kcp-shop-home-card__mark" src="<?php echo esc_url( $asset_url( 'quooker-badge.svg' ) ); ?>" alt="" loading="lazy" decoding="async" />
		</span>
		<span class="kcp-shop-home-card__name"><?php echo esc_html( (string) ( $card['label'] ?? '' ) ); ?></span>
		<span class="kcp-shop-home-card__meta">
			<span class="kcp-shop-home-card__price"><?php echo esc_html( (string) ( $card['price'] ?? '' ) ); ?></span>
			<?php if ( '' !== (string) ( $card['was'] ?? '' ) ) : ?>
				<span class="kcp-shop-home-card__was"><?php echo esc_html( (string) $card['was'] ); ?></span>
			<?php endif; ?>
			<span class="kcp-shop-home-card__stock"><?php echo esc_html( (string) ( $card['stock'] ?? '' ) ); ?></span>
		</span>
	</a>
	<?php
};
?>
<main class="kcp-shop-home" aria-labelledby="kcp-shop-home-title">
	<nav class="kcp-shop-home__breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'kitchen-configurator-pro' ); ?>">
		<a href="<?php echo esc_url( $target_url( 'shop.html' ) ); ?>"><?php esc_html_e( 'Webwinkel', 'kitchen-configurator-pro' ); ?></a>
	</nav>

	<div class="kcp-shop-home__layout">
		<aside class="kcp-shop-home__sidebar" aria-label="<?php esc_attr_e( 'Webshop categorieen', 'kitchen-configurator-pro' ); ?>">
			<nav class="kcp-shop-home-nav">
				<?php foreach ( $categories as $category ) : ?>
					<?php
					$children = is_array( $category['children'] ?? null ) ? $category['children'] : array();
					?>
					<div class="kcp-shop-home-nav__group<?php echo ! empty( $children ) ? ' has-children' : ''; ?>">
						<a class="kcp-shop-home-nav__link" href="<?php echo esc_url( (string) ( $category['url'] ?? '#' ) ); ?>">
							<?php echo esc_html( (string) ( $category['label'] ?? '' ) ); ?>
						</a>
						<?php if ( ! empty( $children ) ) : ?>
							<div class="kcp-shop-home-nav__children">
								<?php foreach ( $children as $child ) : ?>
									<a class="kcp-shop-home-nav__child" href="<?php echo esc_url( (string) ( $child['url'] ?? '#' ) ); ?>">
										<?php echo esc_html( (string) ( $child['label'] ?? '' ) ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</nav>
		</aside>

		<div class="kcp-shop-home__main">
			<h1 id="kcp-shop-home-title" class="kcp-shop-home__title"><?php esc_html_e( 'webshop', 'kitchen-configurator-pro' ); ?></h1>

			<a class="kcp-shop-home-hero" href="<?php echo esc_url( $target_url( 'shop/quooker.html' ) ); ?>">
				<img
					class="kcp-shop-home-hero__image"
					src="<?php echo esc_url( $asset_url( 'quooker-poster.jpg' ) ); ?>"
					alt=""
					fetchpriority="high"
					decoding="async"
				/>
				<span class="kcp-shop-home-hero__badge">
					<img src="<?php echo esc_url( $asset_url( 'quooker-badge.svg' ) ); ?>" alt="<?php esc_attr_e( 'Quooker', 'kitchen-configurator-pro' ); ?>" />
				</span>
				<span class="kcp-shop-home-hero__content">
					<span class="kcp-shop-home-hero__title"><?php esc_html_e( 'de kraan die alles kan', 'kitchen-configurator-pro' ); ?></span>
					<span class="kcp-shop-home-hero__cta"><?php esc_html_e( 'bekijk ons assortiment', 'kitchen-configurator-pro' ); ?></span>
				</span>
			</a>

			<section class="kcp-shop-home-section" aria-labelledby="kcp-shop-home-quooker">
				<div class="kcp-shop-home-section__header">
					<h2 id="kcp-shop-home-quooker" class="kcp-shop-home-section__title"><?php esc_html_e( 'Quooker', 'kitchen-configurator-pro' ); ?></h2>
				</div>
				<div class="kcp-shop-home-grid kcp-shop-home-grid--featured">
					<?php if ( ! empty( $quooker_products ) ) : ?>
						<ul class="kcp-shop-home-products">
							<?php
							foreach ( $quooker_products as $product ) {
								if ( $product instanceof WC_Product ) {
									ShopBrandLandingService::render_product_card( $product, 'kcp-shop-home-products__item' );
								}
							}
							?>
						</ul>
					<?php else : ?>
						<?php foreach ( $static_cards as $card ) : ?>
							<?php $render_static_card( $card ); ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>

	<section class="kcp-shop-home-usps" aria-label="<?php esc_attr_e( 'Webshop voordelen', 'kitchen-configurator-pro' ); ?>">
		<?php foreach ( $usps as $usp ) : ?>
			<div class="kcp-shop-home-usps__item">
				<img class="kcp-shop-home-usps__icon" src="<?php echo esc_url( $asset_url( (string) ( $usp['icon'] ?? '' ) ) ); ?>" alt="" loading="lazy" decoding="async" />
				<span><?php echo esc_html( (string) ( $usp['label'] ?? '' ) ); ?></span>
			</div>
		<?php endforeach; ?>
	</section>

	<section class="kcp-shop-home-tiles" aria-label="<?php esc_attr_e( 'Webshop highlights', 'kitchen-configurator-pro' ); ?>">
		<?php foreach ( $promo_tiles as $tile ) : ?>
			<a class="kcp-shop-home-tile" href="<?php echo esc_url( (string) ( $tile['url'] ?? '#' ) ); ?>">
				<img class="kcp-shop-home-tile__image" src="<?php echo esc_url( (string) ( $tile['image'] ?? '' ) ); ?>" alt="" loading="lazy" decoding="async" />
				<span class="kcp-shop-home-tile__label"><?php echo esc_html( (string) ( $tile['label'] ?? '' ) ); ?></span>
			</a>
		<?php endforeach; ?>
	</section>

	<section class="kcp-shop-home-section" aria-labelledby="kcp-shop-home-popular">
		<h2 id="kcp-shop-home-popular" class="kcp-shop-home-section__title"><?php esc_html_e( 'populaire producten', 'kitchen-configurator-pro' ); ?></h2>
		<div class="kcp-shop-home-grid kcp-shop-home-grid--popular">
			<?php foreach ( $popular_cards as $card ) : ?>
				<?php $render_static_card( $card ); ?>
			<?php endforeach; ?>
		</div>
	</section>
</main>
