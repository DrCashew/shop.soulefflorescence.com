jQuery( '.penci-owl-carousel-slider' ).each( function () {
  var $this = jQuery( this ),
    $auto = true,
    $dots = false,
    $nav = true,
    $loop = true,
    $rtl = false,
    $dataauto = $this.data( 'auto' ),
    $items_desktop = 1,
    $items_tablet = 1,
    $items_tabsmall = 1,
    $items_mobile = 1,
    $speed = 1200,
    $item = 1,
    $margin = 0,
    $autotime = 8000,
    $datalazy = false;

  if( jQuery('html').attr('dir') === 'rtl' ) {
    $rtl = true;
  }
  if ( $this.attr('data-dots') ) {
    $dots = true;
  }
  if ( $this.attr('data-loop') ) {
    $loop = false;
  }
  if ( $this.attr('data-nav') ) {
    $nav = false;
  }

  if ( $this.attr('data-margin') ) {
    $margin = parseInt( $this.data('margin') );
  }
  if ( $this.attr('data-desktop') ) {
    $items_desktop = parseInt( $this.data('desktop') );
  }
  if ( $this.attr('data-tablet') ) {
    $items_tablet = parseInt( $this.data('tablet') );
  }
  if ( $this.attr('data-tabsmall') ) {
    $items_tabsmall = parseInt( $this.data('tabsmall') );
  }
  if ( $this.attr('data-mobile') ) {
    $items_mobile = parseInt( $this.data('mobile') );
  }
  if ( $this.attr('data-speed') ) {
    $speed = parseInt( $this.data('speed') );
  }
  if ( $this.attr('data-autotime') ) {
    $autotime = parseInt( $this.data('autotime') );
  }
  if ( $this.attr('data-item') ) {
    $item = parseInt( $this.data('item') );
  }
  if ( $this.attr('data-lazy') ) {
    $datalazy = true;
  }

  var owl_args = {
    loop              : $loop,
    rtl               : $rtl,
    margin            : $margin,
    items             : $item,
    slideBy           : $item,
    lazyLoad          : $datalazy,
    navSpeed          : $speed,
    dotsSpeed         : $speed,
    nav               : $nav,
    dots              : $dots,
    navText           : ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
    autoplay          : $dataauto,
    autoplayTimeout   : $autotime,
    autoHeight        : true,
    autoplayHoverPause: true,
    autoplaySpeed     : $speed,

    responsive        : {
      0   : {
        items  : $items_mobile,
        slideBy: $items_mobile
      },
      480 : {
        items  : $items_tabsmall,
        slideBy: $items_tabsmall
      },
      768 : {
        items  : $items_tablet,
        slideBy: $items_tablet
      },
      1170: {
        items  : $items_desktop,
        slideBy: $items_desktop
      }
    }
  };

  				if ( $this.hasClass( 'penci-headline-posts' ) ) {
  					owl_args['animateOut'] = 'slideOutUp';
  					owl_args['animateIn'] = 'slideInUp';
  				}

  				$this.imagesLoaded( function() { $this.owlCarousel( owl_args ); } );

  				$this.on('changed.owl.carousel', function(event) {
  					$this.find( '.penci-lazy' ).Lazy( {
  						effect: 'fadeIn',
  						effectTime: 300,
  						scrollDirection: 'both'
  					} );
  				});
  			} );
