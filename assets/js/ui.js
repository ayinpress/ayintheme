/**
 * File primary-navigation.js.
 *
 * Required to open and close the mobile navigation.
 */
( function($) {

	/**
	 * Menu Toggle Behaviors
	 *
	 * @param {Element} element
	 */
	var navMenu = function ( id ){
		var wrapper         = document.body; // this is the element to which a CSS class is added when a mobile nav menu is open
		var openButton    	= document.getElementById( `${ id }-open-menu` );
		var closeButton    	= document.getElementById( `${ id }-close-menu` );

		if ( openButton && closeButton ){
			openButton.onclick = function() {
				wrapper.classList.add( `${ id }-navigation-open` );
				wrapper.classList.add( 'lock-scrolling' );
				closeButton.focus();
			}

			closeButton.onclick = function() {
				wrapper.classList.remove( `${ id }-navigation-open` );
				wrapper.classList.remove( 'lock-scrolling' );
				openButton.focus();
			}
		}

		/**
		 * Trap keyboard navigation in the menu modal.
		 * Adapted from TwentyTwenty
		 */
		document.addEventListener( 'keydown', function( event ) {
			if ( ! wrapper.classList.contains( `${ id }-navigation-open` ) ){
				return;
			} 
			var modal, elements, selectors, lastEl, firstEl, activeEl, tabKey, shiftKey, escKey;

			modal = document.querySelector( `.${ id }-navigation` );
			selectors = "input, a, button";
			elements = modal.querySelectorAll( selectors );
			elements = Array.prototype.slice.call( elements );
			elements = elements.filter( function( el ) {
				return ! el.classList.contains( 'woocommerce-cart-link' ); // ignore this element because it's hidden on mobile
			});
			tabKey = event.keyCode === 9;
			shiftKey = event.shiftKey;
			escKey = event.keyCode === 27;
			activeEl = document.activeElement;
			lastEl = elements[ elements.length - 1 ];
			firstEl = elements[0];

			if ( escKey ) {
				event.preventDefault();
				wrapper.classList.remove( `${ id }-navigation-open`, 'lock-scrolling' );
				openButton.focus();
			}

			if ( ! shiftKey && tabKey && lastEl === activeEl ) {
				event.preventDefault();
				firstEl.focus();
			}

			if ( shiftKey && tabKey && firstEl === activeEl ) {
				event.preventDefault();
				lastEl.focus();
			}

			// If there are no elements in the menu, don't move the focus
			if ( tabKey && firstEl === lastEl ) {
				event.preventDefault();
			}
		});
	}

	window.addEventListener( 'load', function() {
		new navMenu( 'primary' );
		new navMenu( 'woo' );
	});

	let lastScrollY, currentScrollY = 0;
	const minScrollDiff = 8;
	const header = document.getElementById('masthead');

	document.addEventListener('scroll', function(){
		currentScrollY = window.scrollY;
		
		// if ( currentScrollY > lastScrollY && currentScrollY - lastScrollY > minScrollDiff ){
		if ( Math.abs(currentScrollY - lastScrollY) > minScrollDiff || currentScrollY > 150) {
			if ( currentScrollY > 70 ){
				document.body.classList.add( 'hide-menu' );
			} else {
				document.body.classList.remove( 'hide-menu' );
			}
		}

		lastScrollY = currentScrollY;

	});

	const journalToggle = document.getElementById('toggle-toc');
	if (journalToggle){
		journalToggle.addEventListener('click', function(){
			const journalToc = document.getElementById('journal-toc');
			if ( journalToc.classList.contains('open')){
				journalToc.classList.remove('open');
				document.body.classList.remove( 'lock-scrolling' );
			} else {
				journalToc.classList.add('open');
				header.classList.add( 'scroll-up' ); 
				document.body.classList.add( 'lock-scrolling' );
			}
		});
	}

	if ( typeof( bodymovin ) !== 'undefined' && bodymovin.loadAnimation ){
		var animation = bodymovin.loadAnimation({
			container: document.getElementsByClassName('custom-logo-link')[0],// Required
			path: '/wp-content/themes/ayintheme/assets/img/ayin-logo-animation.json', // Required
			renderer: 'svg', // Required
			loop: false, // Optional
			autoplay: true, // Optional
		});
	}
	
	if ( typeof(baguetteBox) !== 'undefined' && baguetteBox.run ){
		var options = {
			captions: function (t) {
				var e = t.parentElement.getElementsByTagName("figcaption")[0];
				return !!e && e.innerHTML;
			},
			filter: /.+\.(gif|jpe?g|png|webp|svg)/i,
		};
		baguetteBox.run(".wp-block-gallery", options);
		baguetteBox.run(".gallery", options);
		baguetteBox.run(".wp-block-image", options);
	}

	const journalPreview = document.getElementById('journal-work-preview');

	if (journalPreview){
		journalPreview.style.backgroundImage = "url(/uploads/2021/02/5Aa.031.jpg)";

		var journalArtists = document.getElementsByClassName('journal-artist-preview');
		for ( var i in journalArtists ){
			if (typeof(journalArtists[i]) === 'object'){
				const thumbnail = journalArtists[i].dataset.thumbnail;
				journalArtists[i].addEventListener('mouseover', function(){
					document.getElementById('journal-work-preview').style.backgroundImage = `url(${thumbnail}`;
				});
			}
		}
	}

} )();