(function($) {
$(function(){

	var legacy_api_url = wc_product_slider_vars.legacy_api_url;
	var wc_product_sliders_localStorage = "wc-product-sliders-backbone";

	//MVC for Product Slider
	var wc_product_slider = { apps:{}, models:{}, collections:{}, views:{} };

	_.templateSettings = {
  		evaluate: /\{\{(.+?)\}\}/g,
    	interpolate: /\{\{=(.+?)\}\}/g,
    	escape: /\{\{-(.+?)\}\}/g
	}

	wc_product_slider.models.Slide = Backbone.Model.extend({
		defaults: {
			item_title: '',
			item_link: null,
			product_price: '',
			img_url: null,
			index_product: 1
		}
	});

	wc_product_slider.collections.Slides = Backbone.Collection.extend({
		model: wc_product_slider.models.Slide,

		totalSlides: function() {
			return this.length;
		}

	});

	wc_product_slider.views.SlideView = Backbone.View.extend({

		widgetItemTpl: _.template( $('#wc_product_slider_widget_item_tpl').html() ),
		mobileItemTpl: _.template( $('#wc_product_slider_mobile_item_tpl').html() ),

		initialize: function() {
			this.listenTo( this.model, 'destroy', this.remove );
		},

		renderWidgetItem: function() {
			console.log('WC Product Slider - Rendering Slide ' + this.model.get('item_title') + ' on Widget Slider');
			this.setElement(this.widgetItemTpl(this.model.toJSON()));

			return this;
		},

		renderMobileItem: function() {
			console.log('WC Product Slider - Rendering Slide ' + this.model.get('item_title') + ' on Mobile Slider');
			this.setElement(this.mobileItemTpl(this.model.toJSON()));

			return this;
		},

	});

	wc_product_slider.views.SliderView = Backbone.View.extend({

		initialize: function() {
			console.log('WC Product Slider - Init');
			this.listenTo( this.collection, 'add', this.addItem );

			this.sliderID = this.$el.attr('id');;

			this.slider_skin_type = 'widget';
			this.slider_id = this.$el.data('slider-id');
			this.slider_settings = this.$el.data('slider-settings');
			this.sliders_localStorage = new Backbone.LocalStorage( wc_product_sliders_localStorage );
			this.slider = this.$('.wc-product-slider');
			this.loadItems();
		},

		loadItems: function() {
			slider_skin_type = this.$el.data('slider-skin-type');
			if ( typeof slider_skin_type !== 'undefined' ) this.slider_skin_type = slider_skin_type;

			now = new Date();
			var data = this.sliders_localStorage.find( { id: this.slider_id } );

			if (data && data.value.length) {
				// clear cached if this data is older
				if ( now.getTime().toString() > data.timestamp  ) {
					this.sliders_localStorage.destroy({ id: this.slider_id });
					data = false;
				}
			}

			if (data && data.value.length) {
				if($.fn.lazyLoadXT !== undefined) {
					console.log('WC Product Slider - cycle bootstrap');
					this.creatItems(data.value);
				} else {
					this.slider.on( 'cycle-bootstrap', function() {
						console.log('WC Product Slider - cycle bootstrap');
						this.creatItems(data.value);
					}.bind( this ));
					this.slider.cycle();
				}
			} else {
				$.post( legacy_api_url, { action: 'get_slider_items', slider_id: this.slider_id, slider_settings: this.slider_settings }, function( itemsData ) {
					if($.fn.lazyLoadXT !== undefined) {
						console.log('WC Product Slider - cycle bootstrap');
						this.creatItems(itemsData);
					} else {
						this.slider.on( 'cycle-bootstrap', function() {
							console.log('WC Product Slider - cycle bootstrap');
							this.creatItems(itemsData);
						}.bind( this ));
						this.slider.cycle();
					}

					tomorrow = new Date(now.getTime() + (3 * 24 * 60 * 60 * 1000)); // cached in 3 days
					tomorrow_str = tomorrow.getTime().toString();
					try {
						this.sliders_localStorage.create( { id: this.slider_id, value: itemsData, timestamp: tomorrow_str } );
					} catch (e) {
						console.log("Storage failed: " + e);
						this.emptyCached();
						this.sliders_localStorage.create( { id: this.slider_id, value: itemsData, timestamp: tomorrow_str } );
					}
				}.bind( this ));
			}
		},

		creatItems: function ( itemsData ) {
			if ( itemsData.length > 0 ) {
				$.each( itemsData, function ( index, data ) {
					this.collection.add( data );
				}.bind( this ));
			} else {
				this.$el.hide();
			}

			if($.fn.lazyLoadXT !== undefined) {
				function a3_product_slider_removeLazyOverlay( slideID ) {
					setTimeout( function() {
						$('#' + slideID ).parent('div').find('.a3-cycle-lazy-hidden').remove();
					}, 700 );
				}
				function a3_product_slider_callCycleLazy( slideID ) {
					$('#' + slideID ).imagesLoaded().done( function( instance ) {
						//console.log('all images of this slider successfully loaded');
						$('#' + slideID ).children('.wc-product-slider').cycle();
						a3_product_slider_removeLazyOverlay( slideID );
					});
				}

				var slideID = this.sliderID;
				//$(window).bind("load", function() {
					var checkLoadAllImages = setInterval( function() {
						//console.log('Checking is relpace src of all images');
						if ( $('#' + slideID + ' img.cycle-wc-product-image.lazy-hidden').length < 1 ) {
							//console.log('Clear interval check replace src of all images');
							clearInterval(checkLoadAllImages);
							a3_product_slider_callCycleLazy( slideID );
						}
					}, 1000 );
				//});

				this.slider.find("img.cycle-wc-product-image.lazy-hidden").on('lazyload', function(){
					$('#' + slideID).find('img.cycle-wc-product-image.lazy-hidden').each(function(){
						if ( typeof $(this).attr('data-src') !== 'undefined' ) {
							$(this).attr("src", $(this).attr('data-src') );
							$(this).removeClass('lazy-hidden');
						}
					});
				}).lazyLoadXT({visibleOnly: false});
			}
		},

		addItem: function ( slideModel ) {
			console.log('WC Product Slider - Added Slide ' + slideModel.get('item_title') );
			var slideView = new wc_product_slider.views.SlideView({ model: slideModel });
			switch( this.slider_skin_type ) {
				case 'mobile':
					this.slider.append( slideView.renderMobileItem().el );
				break;

				default:
					this.slider.append( slideView.renderWidgetItem().el );
				break;
			}
		},

		emptyCached: function() {
			this.sliders_localStorage._clear();
			return false;
		}
	});

	wc_product_slider.apps.App = {
		initialize: function() {

			var wc_product_slider_containers = $( '.wc-product-slider-container' );
			if ( wc_product_slider_containers.length ) {
				$(".wc-product-slider-container").each( function() {
					collection = new wc_product_slider.collections.Slides;
					new wc_product_slider.views.SliderView( { collection: collection, el : this } );
				});
			}
		},

	};

	wc_product_sliders_app.addInitializer(function(){
		var wc_product_slider_app = wc_product_slider.apps.App;
		wc_product_slider_app.initialize();
	});

});
})(jQuery);
