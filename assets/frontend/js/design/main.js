/**
 * Design step entry point.
 */

import { createDesignStore } from './design-store.js';
import { DesignStep } from './DesignStep.js';
import { syncKitchenTypeFromUrl } from './design-selection-storage.js';

export function initDesignStep() {
	const root = document.getElementById( 'kcp-design-root' );

	if ( ! root || root.dataset.kcpDesignMounted === '1' ) {
		return;
	}

	root.dataset.kcpDesignMounted = '1';

	syncKitchenTypeFromUrl();

	const config = window.kcpDesignStep || {};
	const store = createDesignStore( config );
	const app = new DesignStep( root, store );

	app.init();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initDesignStep );
} else {
	initDesignStep();
}
