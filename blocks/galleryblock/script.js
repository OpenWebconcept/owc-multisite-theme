/* globals jQuery */


$(document).ready(function () {
	var $slider = $('.image-gallery');

	function sliderInit() {
		$slider.each(function() {
			var $sliderParent = $(this).parent();
			$(this).slick({
				infinite: true,
				dots: false,
				arrows: true,
				rows: 0,
				slide: '.impression-item',
				appendArrows: ".slider-pagination",
				slidesToShow: 1,
				slidesToScroll: 1,
				prevArrow: '<button type="button" class="slick-arrow slick-prev"><i class="fa-light fa-chevron-left" aria-hidden="true"></i><span class="screen-reader-text">vorige</span></button>',
				nextArrow: '<button type="button" class="slick-arrow slick-next"><i class="fa-light fa-chevron-right" aria-hidden="true"></i><span class="screen-reader-text">volgende</span></button>',
				customPaging : function( slider, i ) {
					return '<button><i class="fas fa-circle"></i><span class="screen-reader-text">Go to slide '+i+'</span></button>';
				},
			});
	
			if ($(this).find('.item').length > 1) {
				$(this).siblings('.slides-numbers').show();
			}
	
			$(this).on('afterChange', function(event, slick, currentSlide){
				$sliderParent.find('.slides-numbers .active').html(currentSlide + 1);
			});
	
			var sliderItemsNum = $(this).find('.slick-slide').not('.slick-cloned').length;
			$sliderParent.find('.slides-numbers .total').html(sliderItemsNum);
	
		});
	};

	sliderInit();

		$('.slick-prev').on('click', function () {
			$($slider).slick('slickPrev');
		});
		$('.slick-next').on('click', function () {
			$($slider).slick('slickNext');
		});
	

});

