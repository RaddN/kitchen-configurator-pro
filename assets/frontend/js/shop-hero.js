( function () {
	'use strict';

	const CONFIGURATOR_STATE_KEY = 'kcp_configurator_state';
	const DESIGN_SELECTIONS_KEY = 'kcp_design_selections';

	const initSlideshow = ( root ) => {
		const slides = Array.from( root.querySelectorAll( '.kcp-shop-hero__slide' ) );

		if ( slides.length <= 1 ) {
			slides.forEach( ( slide ) => slide.classList.add( 'is-active' ) );
			return;
		}

		const interval = Math.max( 2000, parseInt( root.dataset.interval || '4000', 10 ) || 4000 );
		let activeIndex = slides.findIndex( ( slide ) => slide.classList.contains( 'is-active' ) );

		if ( activeIndex < 0 ) {
			activeIndex = 0;
			slides[ 0 ].classList.add( 'is-active' );
		}

		const showSlide = ( nextIndex ) => {
			slides[ activeIndex ].classList.remove( 'is-active' );
			activeIndex = nextIndex;
			slides[ activeIndex ].classList.add( 'is-active' );
		};

		window.setInterval( () => {
			showSlide( ( activeIndex + 1 ) % slides.length );
		}, interval );
	};

	const normalizeKitchenType = ( value ) => {
		return String( value || '' ).trim().toLowerCase() === 'greeploos' ? 'greeploos' : 'greep';
	};

	const persistKitchenType = ( kitchenType ) => {
		const value = normalizeKitchenType( kitchenType );
		let state = {};

		try {
			state = JSON.parse( window.localStorage.getItem( CONFIGURATOR_STATE_KEY ) || '{}' ) || {};
		} catch ( error ) {
			state = {};
		}

		const selections = state.selections && typeof state.selections === 'object'
			? state.selections
			: {};
		const nextState = {
			kitchen_type: value,
			selections,
		};

		try {
			window.localStorage.setItem( CONFIGURATOR_STATE_KEY, JSON.stringify( nextState ) );
		} catch ( error ) {
			// Storage can fail in private contexts; the configurator still opens.
		}

		try {
			window.sessionStorage.setItem( DESIGN_SELECTIONS_KEY, JSON.stringify( selections ) );
		} catch ( error ) {
			// Ignore storage errors.
		}
	};

	const initConfiguratorFlow = () => {
		const landing = document.querySelector( '.kcp-configurator-landing' );

		if ( ! landing ) {
			return;
		}

		const designPanel = landing.querySelector( '[data-kcp-configurator-design]' );
		const landingMain = landing.querySelector( '.kcp-configurator-landing__main' );
		const hero = landing.querySelector( '.kcp-shop-hero' );
		const startButtons = landing.querySelectorAll( '[data-kcp-configurator-start]' );

		if ( ! designPanel || ! startButtons.length ) {
			return;
		}

		const showDesignStep = async ( kitchenType ) => {
			persistKitchenType( kitchenType );

			if ( hero ) {
				hero.hidden = true;
			}

			if ( landingMain ) {
				landingMain.hidden = true;
			}

			designPanel.hidden = false;
			window.scrollTo( { top: 0, behavior: 'auto' } );

			const designScriptUrl = window.kcpConfiguratorLanding?.designScriptUrl || '';

			if ( designScriptUrl ) {
				try {
					const designModule = await import( designScriptUrl );

					if ( typeof designModule.initDesignStep === 'function' ) {
						designModule.initDesignStep();
					}
				} catch ( error ) {
					// Leave the mount visible so failures are obvious during QA.
					window.console.error( 'Unable to load design step.', error );
				}
			}
		};

		startButtons.forEach( ( button ) => {
			button.addEventListener( 'click', ( event ) => {
				event.preventDefault();
				showDesignStep( button.dataset.kcpKitchenType || 'greep' );
			} );
		} );
	};

	document.addEventListener( 'DOMContentLoaded', () => {
		initConfiguratorFlow();

		if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
			document.querySelectorAll( '.kcp-shop-hero__slideshow' ).forEach( ( root ) => {
				const slides = root.querySelectorAll( '.kcp-shop-hero__slide' );

				slides.forEach( ( slide, index ) => {
					slide.classList.toggle( 'is-active', 0 === index );
				} );
			} );

			return;
		}

		document.querySelectorAll( '.kcp-shop-hero__slideshow' ).forEach( initSlideshow );
	} );
}() );
