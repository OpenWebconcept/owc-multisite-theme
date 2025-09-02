/* globals $ */
var strl_responsive_images = function( ){

	var me = this,
	defaultSizes =  {
			xs: 'only screen and (max-width : 480px)',
			s: 'only screen and (min-width : 481px)',
			m: 'only screen and (min-width : 768px)',
			l: 'only screen and (min-width : 1280px)',
			xl: 'only screen and (min-width : 1921px)'
		};

	me.version = '1.0.0';

	me.update = function(id){
		var id = typeof id === 'string' ? '#' + id : '',
				images = $('.image[data-sizes][data-srcset]'),
				//images = $("img"+id+"[data-sizes][data-srcset]");
				sizes, s, img, srcs, siz;

		for ( var i = 0, l = images.length; i<l; i++ ) { // eslint-disable-line
			img   = $(images[i]);
			srcs  = img.attr('data-srcset').split(',');
			sizes = img.attr('data-sizes').split(',');
			for ( var ii = 0, ll = sizes.length; ii<ll; ii++ ) { // eslint-disable-line
				siz = sizes[ii].trim();
				s   = defaultSizes[siz] || siz;
				if( window.matchMedia(s).matches ){

					if( 'url("'+srcs[ii].trim()+'")' !== img.css('background-image') ){
						// console.log('CHANGED SIZE: '+ srcs[ii].trim() );
					}
					img.css('background-image', 'url('+srcs[ii].trim()+')');
					break;
				}
			}
		}
	};

	//init start
	$(document).ready(function(){
		me.update();
	});

	//on window resize
	$(window).resize(me.update);
}

strl_responsive_images();
