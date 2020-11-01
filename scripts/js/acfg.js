document.addEventListener( 'DOMContentLoaded', function () {

	/*
	 * See SplideJS docs at https://splidejs.com/options/
	 */
	var hasSplide = document.getElementsByClassName('splide');
	if (hasSplide.length > 0) {
		var splide = new Splide( '.splide', {
				type   : 'slide', // slide | loop | fade
				perPage: 3,
				height: '60vh',
				speed: 800,
				gap: 10,
				autoplay: false,
				cover: false
			}
		);
		splide.mount();
	}
	
});
