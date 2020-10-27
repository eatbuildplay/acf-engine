document.addEventListener( 'DOMContentLoaded', function () {

	/*
	 * See SplideJS docs at https://splidejs.com/options/
	 */
	var splide = new Splide( '.splide', {
			type   : 'slide', // slide | loop | fade
			perPage: 2,
			speed: 800,
			height: '50vh',
			gap: 10,
			autoplay: false,
			cover: true
		}
	);
	splide.mount();

});
