// last updated 2015-04-28 12:18:36

// file 0.engine.js start

try { 
/* declare global scope */
if (!window.console) console = {log: function() {}};
var Core = function($) {
	
	var widgets = [],
		lib = [];

	this.DEBUG = false;

	var extendDefaults = function(obj, options) {
		for (var option in obj.defaults) {
			obj[option] = (options && options.hasOwnProperty(option)) ? options[option] : obj.defaults[option];
		}
	};
	
	var inherit = function(className, options) {
		var parent = lib[className]['extends'] || 'Base';
		if (!(parent in lib)) { throw 'no such parent';}
		if (parent !== 'Base') {
			inherit(parent, options);
		}
		lib[className].definition.prototype = new lib[parent].definition($);
		// extend parent options by incoming options
		extendDefaults(lib[className].definition.prototype, options);
	};
	
	this.defaults = {
		'prefix': 'ml',
		'themePath': '/wp-content/themes/milano',
		'origin':'',
		'disableSound': false,
		'menu_opened': false,
		'preloaderColor': '#000'
	};

	this.init = function(objects, options) {
		if (typeof(objects) !== 'object') throw('invalid data input');
		
		extendDefaults(this, options);

		for(var i in objects) {
			try {
				
				if (!(objects[i].type in lib)) { throw 'no such widget type'; }
				
				inherit(objects[i].type, objects[i].options);
				
				// construct
				widgets[objects[i].id] = new lib[objects[i].type].definition($);
				extendDefaults(widgets[objects[i].id], objects[i].options);
				
				// init if exist with data object
				if ('init' in widgets[objects[i].id]) {
					widgets[objects[i].id].init(objects[i].data);
					log(objects[i].id + '(' + objects[i].type + ') inited');
				}

			} catch(e) {
				console.error(objects[i].id + '(' + objects[i].type + ') ' + e);
			}
		}
		core.dispatcher.fire('theme-init');
	};
	
	this.getWidget = function(id) {
		return widgets[id];
	};
	
	this.addWidgetClass = function(obj) {
		lib[obj['class']] = obj;
	};
	
};

var core = new Core(jQuery);
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file 0.engine.js'); }

// file 0.engine.js end

// file 0.utils.js start

try { 
/* servise functions */

var log = function(q) {
	if (core.DEBUG && console) {
		console.log(q);

	}
};

function random(min, max, except) {
	var value = Math.floor(Math.random() * (max - min));
	return (except !== value) ? value : random(min, max, except);
}

/* utils */
Core.prototype.dispatcher = {
	events: [],
	addEventlistener: function(event, ctx, callback) {
		this.events[event] = this.events[event] || [];
		if ( this.events[event] ) {
			this.events[event].push([ctx, callback]);
		}
	},
	removeEventlistener: function(event,callback) {
		if ( this.events[event] ) {
			var listeners = this.events[event];
			for ( var i = listeners.length-1; i>=0; --i ){
				if ( listeners[i][1] === callback ) {
					listeners.splice( i, 1 );
					return true;
				}
			}
		}
		return false;
	},
	fire: function() {
		if ( this.events[arguments[0]] ) {
			var listeners = this.events[arguments[0]], len = listeners.length,
				args = Array.prototype.slice.call(arguments);
			args.splice(0,1);
			while ( len-- ) {
				var ctx = listeners[len][0],
					callback = listeners[len][1];

				try { callback.apply(ctx, args); } catch (e) { log(e); }//callback with self
			}
		}
	}
};

Core.prototype.server = {
	
	cache: [],

	get: function(url, data, callback, noCache){
		resp = {'status': 'error', 'data': {}};
		if (!noCache && cache[url]) {
			return cache[url];
		}
		jQuery.ajax({
			'url' : url,
			'data' : data,
			'success' : function(data) {
				resp.status = 'success';
				resp.data = data;
				cache[url] = resp;
				callback();
				return resp;
			},
			'error' : function(data){ callback(); return resp; }
		});
	},

	post: function(url, data, callback) {
		resp = {'status': 'error'};
		jQuery.ajax({
			'url' : url,
			'type' : 'post',
			'data' : data,
			'success' : function(data){
				resp.status = 'success';
				resp.data = data;
				callback();
				return resp;
			},
			'error' : function(data){ callback(); return resp; }
		});
	}
};

Core.prototype.animate = function($obj, cssObj, time, easing, callback) {
	if(core.isIE9orLower()){
		$obj.stop().animate(cssObj, time, easing, callback);
	} else {
		core.coolAnimate($obj, cssObj, time);
	}
};

Core.prototype.transition = function($obj, cssObj, time, easing, callback, cssClass) {
	if(core.isIE9orLower()) {
		$obj.stop().animate(cssObj, time, easing, callback);
	} else {
		$obj.addClass(cssClass || 'trans').css(cssObj);
	}
};

Core.prototype.coolAnimate = function($obj, cssObj, time) {
	var from = 'from{', to = 'to {';
	for (var key in cssObj) {
		from += key + ': ' + $obj.css(key) + '; ';
		to	 += key + ': ' + cssObj[key] + '; ';
	}
	from += '}';
	to	 += '}';
	jQuery('#scenario').text('$keyframes anim1{' + from + to + '}$-webkit-keyframes anim1{' + from + to + '}');
	$obj.css(jQuery.extend({
		"animation-name": 'anim1',
		"animation-duration": time + "s",
		"-webkit-animation-name": 'anim1',
		"-webkit-animation-duration": time + "s"
	}, cssObj));
};

/*
 * @todo look for better browser check 
 */
Core.prototype.isIE9orLower = function() {
	return (jQuery.browser.msie && jQuery.browser.version.indexOf('10') === -1);
};

Core.prototype.browser = {
	'isIE': function() { return jQuery.browser.msie; },
	'IEversion': function() { return parseFloat(navigator.appVersion.split("MSIE")[1]); }
}

Core.prototype.preload = function(arrayOfImages) {
	jQuery(arrayOfImages).each(function() {
		if(this.src){
			(new Image()).src = this.src;
		}
	});
};

Core.prototype.preloader = {
	'mobileDevice': false,
	'init': function(){
		if (core.browser.isIE() && core.browser.IEversion() < 9) return this;
		if( navigator.userAgent.match(/Android/i) ||
			navigator.userAgent.match(/webOS/i) ||
			navigator.userAgent.match(/iPhone/i) ||
			navigator.userAgent.match(/iPad/i) ||
			navigator.userAgent.match(/iPod/i)){
				this.mobileDevice = true;
			}
		var circleCanvas = document.getElementById('circleC'),
			circleCTX = circleCanvas.getContext('2d'),
			ca=0;
	
		var drawC = function() {
			circleCTX.clearRect (0,0,100,100);
			circleCTX.strokeStyle = core.preloaderColor;
			circleCTX.lineWidth = 4;
			circleCTX.beginPath();
			circleCTX.arc(50, 50, 24, (Math.PI*ca)-4, Math.PI*ca, true);
			circleCTX.stroke();
			ca+=0.15;
			ca = ca>2?0:ca;
		};
		core.dispatcher.addEventlistener('window_resize', this, function(responsive) {
			winW = jQuery(window).width();
			winH = jQuery(window).height();
		});
		var timerC = setInterval(drawC, 40);
		return this;
	},
	'show': function(){
		if (core.browser.isIE() && core.browser.IEversion() < 9) return this;
		if(jQuery('#circleC').is(':hidden')){
			jQuery('#circleC').show().css('opacity', '0');
			jQuery('#circleC').stop(true).animate({opacity:'1'}, 300);
			if(!this.mobileDevice){
				jQuery(document).bind('mousemove', this.loadingDraw);
			}else{
//				jQuery('#circleC').css({left:((winW-100)/2)+'px', top:((winH-100)/2)+'px'});
			}
		}
		return this;
	},
	'hide': function(){
		if (core.browser.isIE() && core.browser.IEversion() < 9) return this;
		if(!jQuery('#circleC').is(':hidden')){
			jQuery('#circleC').stop(true).animate({opacity:'0'}, 300, function(){
				jQuery('#circleC').hide(); 
			});
			jQuery(document).unbind('mousemove', this.loadingDraw);
		}
		return this;
	},
	'loadingDraw': function(evt){
		jQuery('#circleC').css({left:(evt.pageX-110)+'px', top:(evt.pageY-50)+'px'});
	}
};

Core.prototype.cookie = {
	'get': function(c_name) {
		var c_value = document.cookie;
		var c_start = c_value.indexOf(" " + c_name + "=");
		if (c_start == -1) {
			c_start = c_value.indexOf(c_name + "=");
		}
		if (c_start == -1) {
			c_value = null;
		} else {
			c_start = c_value.indexOf("=", c_start) + 1;
			var c_end = c_value.indexOf(";", c_start);
			if (c_end == -1) {
				c_end = c_value.length;
			}
			c_value = unescape(c_value.substring(c_start,c_end));
		}
		return c_value;
	},
	'set': function(c_name, value, exdays) {
		var exdate = new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value = escape(value) + ';';
		c_value += (exdays == null) ? "" : "expires="+exdate.toUTCString();
		c_value += 'path=/;';
		document.cookie = c_name + "=" + c_value;
	}
};

Core.prototype.swipe = function($obj, options){
	if(core.touch) {
		options.swipeMoving = options.swipeMoving || function(){};
		$obj.swipe(options);
	}
};

Core.prototype.sound = (core.cookie.get('sound') != 'off');

Core.prototype.touch = 'ontouchstart' in document.documentElement;

Core.prototype.retina = (!!window.devicePixelRatio ? window.devicePixelRatio : 1) > 1;

Core.prototype.isSafari = navigator.vendor.indexOf("Apple")==0 && /\sSafari\//.test(navigator.userAgent); 

} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file 0.utils.js'); }

// file 0.utils.js end

// file Base.js start

try { 
core.addWidgetClass({'class' : 'Base', 'definition' : function($) {
		
	this.defaults = {
		'selector': 'body',
		'ajaxUrl': ThemeData.AJAX_URL,
	};
	
	var that = this,
		myAudio,
		bgAudio,
		canPlay = true;
	
	this.removePreloader = function() {
		$('.preloader')
			.stop()
			.animate({'width': '100%'}, 100, function(){
				$(this).remove();
			});
			
	};
	
	this.startPreloader = function() {
		$('.preloader').animate({'width': '90%'}, 1000);
	};
	
	this.count = function(obj) {
		var count = 0;
		for(var i in obj) { if(obj.hasOwnProperty(i)) count++; }
		return count;
	};
	
	this.getDom = function() {
		return $(this.selector);
	};
	
	this.initParalax = function($this) {
		var ctx = this;
		core.dispatcher.addEventlistener('menu_open', ctx, function(speed, offset,content_offset) {
			$("#content").stop().animate({"margin-left":content_offset+"px"}, speed, 'easeOutCubic', function(){if (core.menu_opened){$(window).resize();}});
			$("header").css({"margin-left":"273px"});
			if (!core.menu_opened){$this.find('.slides').stop().animate({'left': offset + 'px'}, 0.2, 'easeOutCubic');}
		});
		core.dispatcher.addEventlistener('menu_close', ctx, function(speed) {
			$("#content").stop().animate({"margin-left":"0px"}, speed, 'easeOutCubic');
			$("header").css({"margin-left":"0px"});
			$this.find('.slides').stop().animate({'left': '0px'}, 0.2, 'easeOutCubic');
		});
	};
	
	this.play = function(filename) {
		if(core.disableSound || !core.sound || (core.browser.isIE() && core.browser.IEversion() < 9)) return;
		try {
			if(canPlay && filename && (filename.mp3 != '' || filename.ogg != '')) {
				myAudio = new Audio();

				myAudio.src = myAudio.canPlayType('audio/mp3') ? filename.mp3 : filename.ogg;

				canPlay = false;
				myAudio.play();

				myAudio.addEventListener('ended', audioAddEndedListener);
			}
		} catch (e) {
			console.error(e);
		}
	};
	
	this.playBGmusic = function(filename, time) {
		if(core.disableSound || !core.sound || (core.browser.isIE() && core.browser.IEversion() < 9)) return;
		try {
			if (!bgAudio) {
				if (filename && (filename.mp3 != '' || filename.ogg != '')) {
					time = time || core.cookie.get('timing');
					bgAudio = new Audio();
					bgAudio.src = bgAudio.canPlayType('audio/mp3') ? filename.mp3 : filename.ogg;

					bgAudio.addEventListener('ended', function() {
						that.playBGmusic(filename, 0);
					});
					bgAudio.addEventListener("loadeddata", function() {
						this.currentTime = time;
						bgAudio.play();
					},true);
				}
			} else {
				bgAudio.volume = 1;
				bgAudio.play();
			}
		} catch (e) {
			console.error('bg music error' + e);
		}
		window.addEventListener("beforeunload", function (e) {
			if (bgAudio) {core.cookie.set('timing', bgAudio.currentTime); }
		});
	};
	
	var audioAddEndedListener = function(){
		myAudio.removeEventListener('ended', arguments.callee, false);
		canPlay = true;
	};
	
	this.musicOff = function() {
		try {
			core.sound = false;
			if(myAudio) {
				myAudio.pause();
				myAudio.volume = 0;
			}
			if(bgAudio) {
				bgAudio.pause();
				bgAudio.volume = 0;
			}
			canPlay = true;
		} catch (e) { console.error(e); }
	};
	
	this.musicOn = function(filename) {
		core.sound = true;
		this.playBGmusic(filename);
	};
	
}});


} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file Base.js'); }

// file Base.js end

// file BgSlider.js start

try { 
core.addWidgetClass({'class': 'BgSlider', 'extends': 'Slider', 'definition': function ($) {

		var that = this,
				$timeline,
				$timelinewrap,
				$this;


		that.ytplayer = null;
		that.viplayer = null;

		this.defaults = {
			'zoomEffect': false,
			'slideHtmlCont': '.slideshow_banner',
			'timeline': '.timeline',
			'timelinePosition': 'bottom',
			'paralaxSpeed': 700,
			'preloader': true
		};

		this.init = function (data) {


			$this = $(this.selector);

			this.saveSlides(data);
			this.render(data, $this);
			addHandlers();
			this.initSlideshow(data, $this);
		};

		this.initSlideshow = function (data, $this) {

			if (jQuery.browser.mobile) {
				cleanupData(data);
			}

			if (!$.isEmptyObject(data)) {
				if (this.preloader) {
					core.preloader.init().show();
				}
			} else {
				$this.hide();
			}


			this.stoped = (!this.autoplay || !data.length || data.length < 2);

			var ctx = this;

			this.next();
			if (this.autoplay && data.length > 1) {

			} else {
				this.paused = true;
			}
			this.initParalax($this);

			core.dispatcher.addEventlistener('menu_open', ctx, function () {
				if (!core.menu_opened) {
					this.stop();
					this.timelineStop();
				}
			});
			core.dispatcher.addEventlistener('menu_close', ctx, function () {

				if (!this.stoped) {
					this.start();
					this.timelineRestart();
				}
			});
			core.dispatcher.addEventlistener('window_resize', that, function (responsive, w, h) {
				w = (core.menu_opened && !responsive) ? w - 283 : w; //menu offset static :(
				$this.find('div.active>div').width(w).parent().next().find('.img').width(w);
				if (!responsive) {
					$this.find('div.slide.active>div').height(h).parent().next().find('.img').height(h);
				} else {
					$this.find('div.slide.active>div').height('100%').parent().next().find('.img').height('100%');
				}
			});
		};

		this.beforeSlideChange = function ($currentSlide, $nextSlide) {
			if (that.zoomEffect) {
				$nextSlide.find('.img').addClass('zoomed');
				$currentSlide.find('.img').removeClass('zoomed');
			}

		};

		this.afterSlideChange = function ($currentSlide, $nextSlide) {

			if (!that.paused) {
				that.timelineRestart();
			}
			if ($nextSlide.hasClass('youtube')) {
				YouTubeEvents($('.slide.youtube.active iframe').attr('id'));
			}
			if ($nextSlide.hasClass('vimeo')) {
				VimeoEvents($('.slide.vimeo.active iframe').attr('id'));
			}

		};

		this.render = function (slides, $this) {
			var cont = (that.timelinePosition === 'top')
					? 'header'
					: (that.timelinePosition === 'bottom') ? 'footer' : '';
			if (that.timelinePosition === 'bottom' && $('body').hasClass('page-template-template-slideshow-php')) {
				cont = '#slider_box';
			}
			$timeline = $('<div>', {'class': 'p_abs timeline'});
			$timelinewrap = $('<div>', {'class': 'timeline_wrap'}).append($timeline).appendTo($(cont));


			core.dispatcher.addEventlistener('window_resize', that, function (responsive, w, h, init_theme) {
				if (that.timelinePosition === 'bottom') {
					if (responsive && !$('body').hasClass('template-carousel')) {
						if ($('.timeline_wrap').parent().is('footer')) {
							$('.timeline_wrap').remove();
							$('#slider_box').append($timelinewrap);
						}
					} else {
						if ($('.timeline_wrap').parent().is('#slider_box')) {
							$('.timeline_wrap').remove();
							$('footer').append($timelinewrap);
						}
					}
					var bottom = (!responsive || $('body').hasClass('template-carousel')) ? $("footer").height() : 0;
					$timeline.parent().css({'bottom': bottom + "px"});
				}
				if ($('.slide.youtube').hasClass('active') && !init_theme) {
					YouTubeResize($(that.ytplayer.getIframe()).data('videoW'), $(that.ytplayer.getIframe()).data('videoH'));

				}
				if ($('.slide.vimeo').hasClass('active') && !init_theme) {
					VimeoResize($(that.viplayer).data('videoW'), $(that.viplayer).data('videoH'));

				}
			});

			var $slides = $('<div>', {'class': 'slides'});
			for (var i = 0, l = slides.length; i < l; i++) {

				$slides.append(getSlideHtml(slides[i], i));
			}
			$this.append($slides);
		};

		this.timelineRestart = function () {
			$timeline.stop().width(0).animate({'width': '100%'}, that.slideTime);
		};

		this.timelineStop = function () {
			$timeline.stop().width(0);
		};

		var getSlideHtml = function (slide, id, classStr) {
			classStr = classStr || '';
			var html = '';
			switch (slide.type) {
				case 'youtube':
					if (!jQuery.browser.mobile) {
						html = '<div class="slide video' + classStr + ' ' + slide.type + '"  data-id="' + id + '" id="slide_' + id + '"><iframe id="video_' + id + '" frameborder="0" allowfullscreen="1" title="YouTube video player" width="100%" height="100%" data-loop="' + slide.loop + '" data-yid="' + slide.src + '" src="https://www.youtube.com/embed/' + slide.src + '?autoplay=1&controls=0&showinfo=0&modestbranding=1&wmode=opaque&enablejsapi=1&rel=0&autohide=1&vq=hd720&origin=' + core.origin + '"></iframe></div>';
					} else if ((slide.poster === 'custom' && slide.custom !== '') || slide.poster === 'poster') {
						var img = '';
						if (slide.poster === 'custom') {
							img = slide.custom;
						} else if (slide.poster === 'poster') {
							// get youtube cover
							img = 'http://img.youtube.com/vi/'+slide.src+'/0.jpg';
						}
						html = '<div class="slide video' + classStr + '"  data-id="' + id + '" id="slide_' + id + '" style="background-size:cover;background-position: 50% 50%;background-image:url(' + img + ');"></div>';
					}
					break;
				case 'vimeo':
					if (!jQuery.browser.mobile) {
						var loop = 0;
						if (slide.loop) {
							loop = 1;
						}
						html = '<div class="slide video' + classStr + ' ' + slide.type + '"  data-id="' + id + '" id="slide_' + id + '"><iframe id="video_' + id + '" frameborder="0" allowfullscreen="1" title="Vimeo video player" width="100%" height="100%"  data-vid="' + slide.src + '" src="http://player.vimeo.com/video/' + slide.src + '?api=1&title=0&byline=0&portrait=0&autoplay=1&loop=' + loop + '&controls=0&player_id=video_' + id + '&badge=0"></iframe></div>';
					} else if ((slide.poster === 'custom' && slide.custom !== '') || slide.poster === 'poster') {
						var img = '';
						if (slide.poster === 'custom') {
							img = slide.custom;
						} else if (slide.poster === 'poster') {
							// get Vimeo cover
							var url = '//vimeo.com/api/v2/video/'+slide.src+'.json?callback=?'
							$.getJSON(url, function (data) {
								if (data[0]) {									
										img = data[0].thumbnail_large;	
									jQuery('#slide_'+id).css({'background-image':'url('+img+')'});										
								}								
							});
						}
						
						html = '<div class="slide video' + classStr + '"  data-id="' + id + '" id="slide_' + id + '" style="background-size:cover;background-position: 50% 50%;background-image:url(' + img + ');"></div>';
					}
					break;
				case 'intro':
					html = '<div class="intro" data-id="' + id + '" id="intro_' + id + '"><div class="title">' + slide.title + '</div></div>';
					html += '<div class="slide ' + classStr + '" data-id="' + id + '" id="slide_' + id + '">' +
							(slide.src ? '<div class="img" style="background-image: url(' + slide.src + ');" data-src="' + slide.src + '"></div>' : '') +
							'</div>';
					break;
				default :
					html = '<div class="slide ' + classStr + '" data-id="' + id + '" id="slide_' + id + '">' +
							(slide.src ? '<div class="img" style="background-image: url(' + slide.src + ');" data-src="' + slide.src + '"></div>' : '') +
							'</div>';
					break;
			}
			return html;
		};

		var addHandlers = function () {

		};

		var YouTubeEvents = function (player_id) {

			var videocont = jQuery('#' + player_id);
			var video_id = videocont.data("yid");
			var csound = null;
			if (core.isSafari) {
				YouTubeSize(video_id);
				if (that.preloader) {
					core.preloader.hide();
				}
			}
			that.ytplayer = new YT.Player(player_id, {
				events:
						{
							'onStateChange': function (event)
							{

								if (event.data == YT.PlayerState.PLAYING)
								{
									if (core.sound) {
										core.dispatcher.fire('play-content-media');
										$('.sound_icon').removeClass('music_on');
										csound = true;
									}
								}
								if (event.data == YT.PlayerState.ENDED)
								{
									if (videocont.data('loop')) {
										that.ytplayer.loadVideoById(video_id);
									} else {
										if (csound) {
											core.dispatcher.fire('pause-content-media');
											$('.sound_icon').addClass('music_on');
										}
									}

								}

							},
							'onReady': function (event)
							{
								YouTubeSize(video_id);
								if (that.preloader) {
									core.preloader.hide();
								}
							}

						}
			});





		};


		var YouTubeSize = function (video_id) {

			var videoW = null;
			var videoH = null;
			$.ajax({
				url: 'http://query.yahooapis.com/v1/public/yql',
				data: {
					q: "select * from json where url ='http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=" + video_id + "&format=json'",
					format: "json"
				},
				dataType: "json",
				success: function (data) {
					videoW = data.query.results.json.width;
					videoH = data.query.results.json.height;
					YouTubeResize(videoW, videoH);
				},
				error: function () {
					videoW = 480;
					videoH = 270;
					YouTubeResize(videoW, videoH);
				}
			});


		};

		var YouTubeResize = function (videoW, videoH) {
			$(that.ytplayer.getIframe()).data('videoW', videoW);
			$(that.ytplayer.getIframe()).data('videoH', videoH);
			var videosize = FullScreenVideo(videoW, videoH);
			that.ytplayer.setSize(videosize.videoW, videosize.videoH);
			$(that.ytplayer.getIframe()).css({left: videosize.videoLeft + 'px', top: videosize.videoTop + 'px', position: 'absolute', opacity: 1});

		};

		var VimeoEvents = function (player_id) {

			var videocont = jQuery('#' + player_id);
			var video_id = videocont.data("vid");
			var csound = null;
			that.viplayer = jQuery('#' + player_id)[0];

			$f(that.viplayer).addEvent('ready', function () {


				if (core.sound) {
					core.dispatcher.fire('play-content-media');
					$('.sound_icon').removeClass('music_on');
					csound = true;
				}

				VimeoSize(video_id);
				if (that.preloader) {
					core.preloader.hide();
				}

				$f(that.viplayer).addEvent('finish', function (id)
				{
					if (csound) {
						core.dispatcher.fire('pause-content-media');
						$('.sound_icon').addClass('music_on');
					}
				});

			});
		};


		var VimeoSize = function (video_id) {

			var videoW = null;
			var videoH = null;
			$.ajax({
				url: '//vimeo.com/api/v2/video/' + video_id + '.json',
				data: {
					format: "json"
				},
				dataType: "json",
				success: function (data) {
					videoW = data[0].width;
					videoH = data[0].height;
					VimeoResize(videoW, videoH);
				},
				error: function () {
					videoW = 480;
					videoH = 270;
					VimeoResize(videoW, videoH);
				}
			});
		};

		var VimeoResize = function (videoW, videoH) {
			$(that.viplayer).data('videoW', videoW);
			$(that.viplayer).data('videoH', videoH);
			var videosize = FullScreenVideo(videoW, videoH);
			$(that.viplayer).css({width: videosize.videoW + 'px', height: videosize.videoH + 'px'});
			$(that.viplayer).css({left: videosize.videoLeft + 'px', top: videosize.videoTop + 'px', position: 'absolute', opacity: 1});
		};


		var FullScreenVideo = function (videoW, videoH) {

			winW = $this.find('.slides').width();
			winH = $this.find('.slides').height();

			var videoRatio = videoW / videoH;
			var winRatio = winW / winH;
			if ((winRatio > videoRatio))
			{
				var videoW = parseInt(winW);
				var videoH = parseInt(videoW / videoRatio);
				var videoTop = parseInt((winH - videoH) / 2);
				var videoLeft = 0;

			} else {
				var videoH = winH;
				var videoW = parseInt(videoH * videoRatio);
				var videoTop = 0;
				var videoLeft = parseInt((winW - videoW) / 2);
			}
			var sizes = {videoH: videoH, videoW: videoW, videoTop: videoTop, videoLeft: videoLeft};

			return sizes;

		};

		var cleanupData = function (array) {
			for (var i = 0; i < array.length; i++) {
				if ((array[i]['type'] === 'youtube' || array[i]['type'] === 'vimeo') && (array[i]['poster'] !== 'poster' && array[i]['poster'] !== 'custom' )) {
					delete array[i];
				}
			}
		};


	}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file BgSlider.js'); }

// file BgSlider.js end

// file CenterMenu.js start

try { 
core.addWidgetClass({'class' : 'CenterMenu', 'extends' : 'Menu', 'definition' : function($) {
	
	var that = this,
		$this, $pool, $area, $items,
		width = 0, areaW, areaH;
		
	this.defaults = {
		'pool' : '.nav_box',
		'mousemovearea' : '.nav_wrap',
		'pool_zone' : 70,
		'animate_speed' : 500,
		'sound' : '',
		'soundOgg': ''
	};
	
	this.init = function() {
		core.menu_opened = false;
		$pool = $(this.pool);
		$this = $pool.find(this.selector);
		$area = $(this.mousemovearea);
		$items = $this.find('li');

		$(".middle_menu>li, .sf-menu2>li").append("<em class='hov_bg'></em>");
		$(".main_menu").append("<span class='open_arrow bg_color2'></span>");
	
		$items.each(function() {		
			width += $(this).width();
		});
		//hack for ie9
		if(core.browser.isIE() && core.browser.IEversion() == 9){ width++; }

		addHendlers();
		
	};
	
	var preparePool = function(windowW) {
		if(windowW > 1024){
			$pool.closest('.nav_wrap').removeClass('vertical');
			$pool
				.css({
					'width': (width + that.pool_zone * 2 > windowW) ? windowW - that.pool_zone * 2 : width,
					'height': $this.height()
				})
				.css({'padding': that.pool_zone + 'px'})
				.css({
					'width': $pool.outerWidth(),
					'height': $pool.outerHeight(),
					'padding': 0
				});
			$this
				.width((width + that.pool_zone * 2 > windowW) ? windowW - that.pool_zone * 2 : width)
				.css({
					'position': 'absolute',
					'top' : that.pool_zone + 'px',
					'left' : that.pool_zone + 'px'
				});
			areaW = $area.width();
			areaH = $area.height();
		} else {
			$pool.closest('.nav_wrap').addClass('vertical');
		}
	};
	
	var addHendlers = function() {
		core.dispatcher.addEventlistener('window_resize', that, function(responsive, w, h) {
			if (h - $("header").height() - $("footer").height() <= $this.height()){
				$this.closest('.nav_wrap').css({'position':'relative'});
			} else{
				$this.closest('.nav_wrap').css({'position':'fixed'});
			}
			if(responsive) {
				$pool
					.css({
						'width': "auto",
						'height': "auto",
						'padding': 0
					});
			} else {
				preparePool(w);	
			}
		});

		var getClosestButton = function(x) {
			var closest, distance = false, curDist;
			$items.each(function(i) {
				curDist = Math.abs($(this).position().left + $(this).width() / 2 + $this.position().left - x);
				if(!distance || curDist < distance) {
					distance = curDist;
					closest = $(this);
				}
			});
			return closest;
		};
		
		var inPool = false, inMenu = false,
			x, y, cssO, cord, $closest;
		
		$items.on('mouseenter', function() {
			that.play({'mp3': that.sound, 'ogg': that.soundOgg});
		});
		
		$area.mousemove(function(e) {

			if(!inMenu) {
				$this.stop().animate({
					'left' : 2 * that.pool_zone * e.clientX / areaW,
					'top' : 2 * that.pool_zone * e.clientY / areaH
				}, 3000, 'easeOutExpo');
			}
		});
		

		$this
			.mousemove(function(e) {
				if (core.isSmallScreen) { return; }
				$this.stop();
				inMenu = true;
			})
			.mouseleave(function(e) {
				if (core.isSmallScreen) { return; }
				inMenu = false;

			});
	};
}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file CenterMenu.js'); }

// file CenterMenu.js end

// file ContactForm.js start

try { 
core.addWidgetClass({'class' : 'ContactForm', 'definition' : function($) {
	
	var that = this,
		sendingProgress = false,
		$this;

	this.defaults = {
		'rules': {
			'comments': "required",
			'email': "required email",
			'name': "required"
		},
		'messages': {
			'success': 'Your message has been successfully sent to us!',
			'mailError': 'Something going wrong with sending mail...',
			'connecionError': 'Something going wrong with connection...'
		}
	};
		
	this.init = function() {
		$this = $(this.selector);
		
		addHendlers();
	};

	var addHendlers = function() {
		$this.validate({
			'submitHandler': function(form) {
				sendForm(form);
				return false;
			},
			'rules': that.rules
		});
	};
	
	function sendForm(form) {
		if(sendingProgress) return;
		sendingProgress = true;
		var name, el, label, html,
			$form = $(form);
			form_data = {};

		$('input, select, textarea', $form).each(function(n, element) {
			el =  $(element);
			name = el.attr('name');

			switch(el.attr('type')) {
				case 'radio':
					if(el.prop('checked')) {
						label = $('label:first', el.parent('div'));
					}
					break;
				case 'checkbox':
					label = $("label[for='"+name+"']:not(.error)", $form);
					break;
				default:
					label = $("label[for='"+name+"']", $form);
			}

			if( !($form.hasClass('contactformWidget')) && label && label.length) {
				html = label.html();
				html = html.replace(/<span>.*<\/span>/,'');
				html = html.replace(/<br>/,'');
				if(el.attr('type') === 'checkbox') {
					form_data[html] = el.prop('checked') ? 'yes' : 'no';
				} else {
					form_data[html] = el.val().replace(/\n/g, '<br/>');
				}
			} else {
				/**
				 * to, subject .....
				 */
				if(name != undefined && name != 'send_button' && name != '_wp_http_referer' && name != '_wpnonce' && name !='contact-form-id' && name != 'validate_rules') {
					if(el.attr('type') !== 'radio') {
						/**
						 * email reply to:
						 */
						if(name === 'th-email-from' || name == 'th-name-from') {
							if( form_data[name] == undefined) {
								/**
								 * first of reply
								 */
								var email_id = null,
									email_from = null;
								$('[name="'+name+'"]').each(function() {
									email_id = $(this).val();
									email_from = $('#'+email_id, $form).val();
									if(email_from && email_from.length) {
										return false;
									}
								});

								if(email_from && email_from.length) {
									form_data[name] = email_from ;
								}
							}
						} else {
							form_data[name] = el.val().replace(/\n/g, '<br/>');
						}
					}
				}
			}
			name = label = html= null;
			el = null;
		});

		form_data.action = 'send_contact_form';

		$.ajax({
			type: "POST",
			url: that.ajaxUrl,
			dataType: 'json',
			data: form_data,
			success: function(response) {
				$form.find('div').fadeOut(500);
				setTimeout(function() {
					$form.append('<p class="note">' + that.messages[response.code] + '</p>').slideDown('fast');
				},500);
				setTimeout(function() {
					$form.find('.note').html('').slideUp('fast');
					$form.find("button, .lf_button").removeAttr('disabled');
					$form.find("input[type=text], textarea").val('');
					$form.find('div').fadeIn(500);
					sendingProgress = false;
				},3000);
			},
			error: function() {
				$form.find('div').fadeOut(500);
				setTimeout(function() {
					$form.append('<p class="note">' + that.messages.connecionError + '</p>').fadeIn(500); //error text when ajax didn't send data to php processor
				},500);
				setTimeout(function() {
					$form.find('.note').html('').slideUp('fast');
					$form.find("button, .qd_button").removeAttr('disabled');
					$form.find("input[type=text], textarea").val('');
					$form.find('div').fadeIn(500);
					sendingProgress = false;
				},3000);
			}
		});
		return false;
	}
	
	
}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file ContactForm.js'); }

// file ContactForm.js end

// file Gmaps.js start

try { 
core.addWidgetClass({'class': 'Gmap', 'definition': function($) {

		var that = this,
				map,
				$map,
				markerImg,
				markerWidth,
				markerHeight,
				$this;

		this.defaults = {
			'mapType': 'ROADMAP',
			'zoomWithScroll': false,
			'zoom': 2,
			'markerImage': '',
			'retina': false,
			'controlsPosition': 'RIGHT_CENTER'
		};


		this.init = function(data) {

			$this = $(this.selector);

			$map = $('<div>', {'class': 'map', 'id': 'gmap', 'style': 'height: 100%;'}).appendTo($this);

			drawMap(data);

			this.initParalax($this);
		};

		var drawMap = function(data) {
			var zoom = (data.zoom) ? data.zoom : 2;
			var lat = (data.lat) ? data.lat : 0;
			var lng = (data.lng) ? data.lng : 0;
			var markers = (data.markers) ? data.markers : data;
			
			google.maps.event.addDomListener(window, 'load', function() {
				var mapOptions = {
					panControlOptions: {
						position: google.maps.ControlPosition[that.controlsPosition]
					},
					zoomControlOptions: {
						position: google.maps.ControlPosition[that.controlsPosition]
					},
					mapTypeControlOptions: {
						position: google.maps.ControlPosition['RIGHT_BOTTOM']
					},
					zoom: parseInt(zoom),
					scrollwheel: that.zoomWithScroll,
					center: new google.maps.LatLng(parseFloat(lat), parseFloat(lng)),
					mapTypeId: google.maps.MapTypeId[that.mapType],
					draggable: !core.touch
				};
				map = new google.maps.Map($map[0], mapOptions);
				that.removePreloader($this);

				markerImg = new Image();
				markerImg.src = (core.retina && that.retina && that.retina != '') ? that.retina : that.markerImage;

				$(markerImg).load(function() {
					if (markers) {
						markerWidth = markerImg.width;
						markerHeight = markerImg.height;
						if (core.retina && that.retina && that.retina != '') {
							markerWidth = markerWidth / 2;
							markerHeight = markerHeight / 2;
						}
						drawMarkers(markers);
					}
				}).attr('src');

				google.maps.event.addListenerOnce(map, 'idle', function() {
					$('.gmnoprint').last().addClass('mapTypeControl');
				});

				google.maps.event.addDomListener(window, "resize", function() {
					var center = map.getCenter();
					google.maps.event.trigger(map, "resize");
					map.setCenter(center);

					if (core.touch) {
						map.setOptions({
							draggable: false
						});
					} else {
						map.setOptions({
							draggable: true
						});
					}
				});


			});
		};

		var drawMarkers = function(markers) {

			for (var i in markers) {
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(markers[i].latitude, markers[i].longitude),
					map: map,
					icon: {
						'url': markerImg.src,
						'scaledSize': new google.maps.Size(markerWidth, markerHeight)
					}

				});
				marker.id = i;

				google.maps.event.addListener(marker, 'dblclick', function(e) {
					var iw = new google.maps.InfoWindow();
					iw.setContent(markers[this.id].title + '<br>' + markers[this.id].description);
					iw.setPosition(this.position);
					iw.open(map);
				});
			}

		};

	}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file Gmaps.js'); }

// file Gmaps.js end

// file Grid.js start

try { 
core.addWidgetClass({'class': 'Grid', 'definition': function($) {

		var that = this,
				$this,
				$ul;

		this.defaults = {
			'ajaxLoadImages': false,
			'filterable': false,
			'maxWidth': 400,
			'columns': 5
		};

		this.init = function(data) {
			$this = $(this.selector);
			$('body').addClass('grid-portfolio');

			render(data);

			fitColumns();

			addHendlers();

			activeClass();
		};

		var addHendlers = function() {



			if (that.filterable) {
				$('.portfolio_categories a').click(function(e) {
					e.preventDefault();
					$(this).parent().removeClass("cat-item");
					var filter = $(this).parent().attr('class');

					$this.find('ul#carousel_list').isotope({filter: function() {
							var itemcat = jQuery(this).attr('class');
							return itemcat.match(filter);
						}});
				});

			}

			core.dispatcher.addEventlistener('theme-init', that, function() {
				$this.find('ul#carousel_list').isotope({layoutMode: 'fitRows',
					masonry: {
						columnWidth: $this.find('ul#carousel_list').find('article')[0]
					}});
			});

			core.dispatcher.addEventlistener('window_resize', that, fitColumns);

		};

		var fitColumns = function() {
			$this.find('a').css({'width': '100%'});
			setTimeout(function() {
				var w = Math.floor(100 / that.columns),
						g = Math.ceil(parseInt($this.find('ul#carousel_list li').css('margin-left')) / $this.width() * 100);


				fontSize = $this.width() * w / 100 / 12;
				fontSize = fontSize > 25 ? 25 : fontSize;
				$this.find('.title6').css({'font-size': fontSize + 'px'});

				$this.find('img').each(function() {
					var iw = $(this).width();
					$(this).parent().parent().find('.title6').css({'width': iw - 66 + 'px'});
					$(this).parent().parent().width(iw);

				});


				$this.find('ul#carousel_list li').css({'width': w - g + '%'});

				$this.find('ul#carousel_list').isotope();

			}, 500);
		};

		var activeClass = function() {
			$(".portfolio_categories").find("a").click(function() {
				$(".portfolio_categories .active").removeClass("active");
				$(this).addClass("active");
			});
		};

		var render = function(list) {
			$ul = $('<ul>', {'class': 'carousel_list2', 'id': 'carousel_list'});

			for (var i in list) {
				$('<li>', {'html': getHtml(list[i]), 'class': list[i].categories}).appendTo($ul);
			}
			$this.append($ul);
		};

		var resizeImage = function(post_id, page_id) {
			$.ajax({
				'url': that.ajaxUrl,
				'data': {
					'post_id': post_id,
					'page_id': page_id,
					'action': 'portfolio_thumbnail',
					'retina': core.retina,
					'width': that.maxWidth,
					'height': Math.floor(that.maxWidth / 1.53)
				},
				'success': function(data) {
					$this.find('#thumb_' + post_id).find('figure').append($(data));
					fitColumns();
				}
			});
		};

		var getHtml = function(elem) {
			if (that.ajaxLoadImages) {
				resizeImage(elem.post_id, elem.page_id);
			}
			return '<article class="p_rel portfolio2" id="thumb_' + elem.post_id + '">' +
					'<a href="' + elem.url + '" data-original="' + elem.original + '"' + (elem.blank ? 'target="_blank"' : '') + '>' +
					'<figure>' + (!that.ajaxLoadImages ? ((elem.retina && core.retina) ? elem.retina : elem.thumbnail) : '') + '</figure>' +
					'<div class="p_abs title6 port_title">' + elem.title + '</div>' +
					'</a>' +
					'</article>';
		};

	}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file Grid.js'); }

// file Grid.js end

// file GridSlider.js start

try { 
core.addWidgetClass({'class' : 'GridSlider', 'definition' : function($) {
	
	var that = this,
		$this,
		$viewport,
		$ul,
		smallScreen;
	
	this.defaults = {
		'ajaxLoadImages': false,
		'thumbWidth': 316,
		'thumbHeight': 400,
		'space': 14,
		'sound' : '',
		'soundOgg': ''
	};
	
	this.init = function(data) {
		$this = $(this.selector);
		$('body').addClass('template-carousel');		
		render(data);

		addHendlers();
		$(window).resize();
	};
	
	var controlsCheck = function(l) {
		var delta = 20,
			$prev = $this.find('.nav_btn.prev'),
			$next = $this.find('.nav_btn.next');
	
		if (0 - l  < delta) { $prev.addClass('inActive'); } else { $prev.removeClass('inActive'); }
		if ($ul.width() - $viewport.width() + l  < delta) { $next.addClass('inActive'); } else { $next.removeClass('inActive'); }
	};
	
	var addHendlers = function() {
		var mooving = false;
	
		$this.find('.nav_btn').on('click', function(e) {
			e.preventDefault();
			if(mooving || $(this).hasClass('inActive')) return;
			var right = $(this).hasClass('prev'),

				outerW = $this.find('li').first().outerWidth(true),
				offset = right ? outerW : -outerW,
				l = $ul.position().left + offset;

			if (l > 0 || l  < ($viewport.width() - $ul.width())) return;

			mooving = true;
			$ul.animate({'left': l}, 300, function() {
				controlsCheck(l);
				mooving = false;
			});
			
			if(right) {
				$this.find('.vis').first().prev().addClass('vis');
				$this.find('.vis').last().removeClass('vis');
			} else {
				$this.find('.vis').last().next().addClass('vis');
				$this.find('.vis').first().removeClass('vis');
			}
		});
		
		core.dispatcher.addEventlistener('window_resize', that, function(responsive, w) {
			smallScreen = (w<=479);
			$viewport.css({'padding': '0'});
			$this.find('li').width( (this.thumbWidth > w) ? $viewport.width() : this.thumbWidth);
			if(!responsive){
				$(".carousel_list .title_rollover").each(function(){
					$(this).find(">.inner").width($(this).closest('li').width() - 30);
				});
			}else{
				$(".carousel_list .title_rollover>.inner").width("auto");
			}
		});
		
		rollovers();
		
		core.swipe($this, {
			'swipeLeft': function(){$this.find('.next').click();},
			'swipeRight': function(){$this.find('.prev').click();}
		});
		
		// uglehack for fixed footer
		if($('footer').css('position') === 'fixed'){
			$('#content').css({'margin-bottom': $('footer').height() + 'px'});
		}
		
	};
	
	var render = function(list) {

		var count = that.count(list);

		// render list
		$ul = $('<ul>', {'class': 'carousel_list', 'id': 'carousel_list', 'style': 'position: relative;'}).width((that.thumbWidth + that.space) * count);
		$viewport = $('<div>', {'class': 'inner d_in-block', 'style': 'padding: 20px 10px;'}).append($ul);

		for (var i in list) {
			$('<li>', {'class': 'd_in-block p_rel', 'id': 'elem_' + i, 'html': getHtml(list[i])})
				.css({'width': that.thumbWidth+'px', 'height': that.thumbHeight+'px'})
				.appendTo($ul);
		}

		$this.append($viewport);

		$ul.wrap('<div style="position: relative;"/>');
		
		// render controls
		$viewport.append('<a href="#" class="nav_btn d_block p_abs prev"></a><a href="#" class="nav_btn d_block p_abs next"></a>');
		
		// scale viewport on win resize
		core.dispatcher.addEventlistener('window_resize', that, function(responsive, w, h, theme_init) {
			

			$ul.width((that.thumbWidth + (smallScreen ? 0 : this.space)) * count);
			var outerWidth = this.thumbWidth + (smallScreen ? 0 : this.space),
				middleScreen  = (w<=930),
				openedMenu = (core.menu_opened ? core.getWidget('left_menu').opened_value : 0),
				initWidth = (theme_init ? openedMenu : 0),
				spaseForControls = responsive ? 0 : (core.menu_opened ? 50 : 250),
				visibleCount = Math.floor(($this.width()- openedMenu - initWidth - spaseForControls) / outerWidth);
				
			if (count > visibleCount) {
				$this.find('.nav_btn').show();
			} else {
				$this.find('.nav_btn').hide();
				visibleCount = count;
			}
			if (middleScreen) {
				visibleCount = 1;
			}

			if(responsive) {
				visibleCount = 1;

			}
			
			$viewport.width(visibleCount * outerWidth);
			$ul.css({'left': 0}).find('li').each(function(i) {
				(i >= visibleCount) ? $(this).removeClass('vis') : $(this).addClass('vis');
			});
			
			controlsCheck(0);
		});
	};
	
	var resizeImage = function(post_id, page_id) {
		$.ajax({
			'url': that.ajaxUrl,
			'data': {
				'post_id': post_id,
				'page_id': page_id,
				'action': 'portfolio_thumbnail'
			},
			'success': function(data) {
				$this.find('#thumb_' + post_id).append($(data));
			}
		});
	};
	
	var getHtml = function(elem) {
		if(that.ajaxLoadImages) {
			resizeImage(elem.post_id, elem.page_id);
		}
		return '<a id="thumb_' + elem.post_id + '" href="'+elem.url+'" class="d_block p_abs" data-original="' + elem.original + '" '+(elem.blank ? 'target="_blank"' : '')+'>'+
					(!that.ajaxLoadImages ? elem.thumbnail || '' : '') +
					'<span class="p_abs d_block title title1">'+
						(elem.day ? '<div class="postmetadata p_abs"><div class="inner"><strong>' + elem.day + '</strong><span>' + elem.month + '</span></div></div>' : '')+
						'<span class="inner d_block">'+elem.title+'</span>'+
					'</span>'+
					'<span class="p_abs d_block title_rollover">'+
						(elem.day ? '<div class="postmetadata p_abs"><div class="inner"><strong>' + elem.day + '</strong><span>' + elem.month + '</span></div></div>' : '')+
						'<span class="inner d_block">'
						+'<span class="rollover_title">'+elem.title+'</span>'+
						(elem.excerpt ? '<span class="description">' + elem.excerpt + '</span>' : '')+'</span>'+
						'</span>'+
						'</a>';
	};

	var rollovers = function(){
		
    	$(".carousel_list li").live({
		    mouseenter: function () {
				that.play({'mp3': that.sound, 'ogg': that.soundOgg});
				var ctx = this;
				setTimeout(function(){
					$(ctx).find(".title_rollover").addClass("show_contain");
				}, 250);
		    },
		    mouseleave: function () {
		    	setTimeout(function(){
					$(".carousel_list li .title_rollover").removeClass("show_contain");
				}, 100);
		    }
		});
    };

}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file GridSlider.js'); }

// file GridSlider.js end

// file LightBox.js start

try { 
core.addWidgetClass({'class' : 'LightBox', 'definition' : function($) {
	
	
	var that = this,
		$fade,
		$this;
		
	this.defaults = {
		'clickObj': 'a'
	};
	
	this.init = function(data) {
		
		render(data);
		addHendlers();
		
	};
	
	var render = function() {

		$this = $('<div>', {
			'class': core.prefix + '-lightbox',
			'style': 'position: absolute;  background: #fff; top: 0; z-index: 11; display: none; top:50%; left: 50%',
			'html': getLightboxHtml()
		}).appendTo('body');
		
		$fade = $('<div>', {
			'class': core.prefix + '-fade',
			'style': 'position: fixed; opacity: 0.7; cursor: pointer; background: #000; width: 100%; height: 100%; display: none; top: 0; z-index: 10;'
		}).appendTo('body');
		
	};
	
	var addHendlers = function() {
		$(that.clickObj).on('click', function(e) {
			e.preventDefault();
			that.open($(this).data('original'));
		});
		$this.find('.closeBtn').on('click', that.close);
		$fade.on('click', that.close);
	};
	
	this.open = function(imgUrl) {
		$fade.show();
		$this.show();
		$('<img>', {'src': imgUrl}).load(function() {
			$this.find('.lightbox-container').empty().append(this);
		});
		
	};
	
	this.close = function() {
		$fade.hide();
		$this.hide();
	};
	
	var getLightboxHtml = function() {
		return '<div class="wrapper" style="margin: -50px 0 0 -50px;"><div class="lightbox-container"></div></div>';
	};
	
}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file LightBox.js'); }

// file LightBox.js end

// file Menu.js start

try { 
core.addWidgetClass({'class': 'Menu', 'definition': function ($) {

		var that = this, isSmallScreen, iOpen, viewportHeight,
				$this, $icon;

		this.defaults = {
			'slider_box': '#slider_box',
			'speed': '0.7',
			'slider_box_offset': 50,
			'paralax_value': 50,
			'closed_value': 7,
			'opened_value': 283,
			'iconClass': 'open_arrow',
			'sound': '',
			'soundOgg': '',
			'elementSound': '',
			'elementSoundOgg': '',
			'content_offset': 223
		};

		this.init = function () {
			$("body").addClass(core.menu_opened ? "menu_opened" : "");
			$this = $(this.selector);
			$icon = $('<span>', {
				'class': this.iconClass + ' bg_color2',
				'html': '<span>MENU</span>'
			});
			$this.append($icon);

			activeItem();

			addHendlers();

			if (!core.menu_opened) {
				$this.after('<span class="bg_color2 open_arrow1"></span>');
			}

		};



		var addHendlers = function () {
			$(window).scroll(function (event) {

				asyncScrollInit();
			});

			$this
					.mouseenter(function () {
						if (!core.touch && !core.menu_opened) {
							openMenu(true);
						}
					})
					.mouseleave(function () {
						if (!core.menu_opened) {
							closeMenu(true);
						}
					})
					.find(".sf-sub-indicator").click(function (event) {
				event.preventDefault();
				var isOpen = $(this).closest('li').is('.open');
				$(this).closest('ul').find('li.open').removeClass('open').find('>.sub-menu').slideUp("middle", asyncScrollInit);
				if (!isOpen) {
					$(this).closest('li').toggleClass("open")
							.find('>.sub-menu').slideToggle("middle", asyncScrollInit);
				}

			});
			$this.find('li.menu-item').mouseenter(function () {
				that.play({'mp3': that.elementSound, 'ogg': that.elementSoundOgg});
			});
			$icon.click(function () {
				if (isSmallScreen) {
					$(".sf-menu2").css({top: $(this).closest('nav').height()}).slideToggle();
					$icon.toggleClass("active");
				} else if (core.touch) {
					iOpen ? closeMenu() : openMenu();
				}
			});
			var opened;

			that.initParalax();

			core.dispatcher.addEventlistener('window_resize', that, function (responsive, w, h, theme_init) {
				isSmallScreen = responsive;
				if (responsive) {
					$this.find('.sf-menu2').hide();
					$(this.slider_box).css({'left': '0px'});

				} else {
					$this.find('.sf-menu2').show().css({top: 0});
					if (core.menu_opened) {
						$(this.slider_box).css({'left': '283px'});
					}
					if (core.menu_opened && !opened) {
						openMenu(true);
						opened = true;
					}
				}

				if (theme_init && core.cookie.get('menu_inited') != '1' && !core.menu_opened) {
					openMenu();
					setTimeout(closeMenu, 1000);
					core.cookie.set('menu_inited', '1');
				}

			});
			core.dispatcher.addEventlistener('content_set_height', that, asyncScrollInit);
		};

		var originalCoord = {x: 0, y: 0};
		var finalCoord = {x: 0, y: 0};

		var swipeMenu = function (dy) {

			var menuStartPos;

			$this[0]
					.addEventListener('touchstart', function (event) {
						this.isScrolling = undefined;
						originalCoord.x = event.targetTouches[0].pageX;
						originalCoord.y = event.targetTouches[0].pageY;
						finalCoord.x = originalCoord.x;
						finalCoord.y = originalCoord.y;
						menuStartPos = $this.find('.sf-menu2').offset().top;
					}, false);
			$this[0]
					.addEventListener('touchmove', function (event) {
						if (event.touches.length > 1 || event.scale && event.scale !== 1) {
							return;
						}
						finalCoord.x = event.targetTouches[0].pageX; // Updated X,Y coordinates
						finalCoord.y = event.targetTouches[0].pageY;
						var changeX = originalCoord.x - finalCoord.x;
						var changeY = originalCoord.y - finalCoord.y;

						if (typeof this.isScrolling === 'undefined') {
							this.isScrolling = !!(this.isScrolling || Math.abs(changeX) > Math.abs(changeY));
						}
						if (!this.isScrolling) {
							event.preventDefault();
							moveMenu(-changeY);
						}
					}, false);

			var moveMenu = function (changeY) {
				if (menuStartPos + changeY > 0 || menuStartPos + changeY < -dy)
					return;
				$this.find('.sf-menu2').css({'top': changeY + menuStartPos});
			};
		};

		var asyncScrollInit = function (responsive, w, h) {
			responsive = responsive || isSmallScreen;

			if (!responsive) {


				$this.unbind('mousemove').find('.sf-menu2').css({'top': 0});
				$this.find('.logo').css({'top': 0});




				viewportHeight = $('footer').offset().top - $this.offset().top - $this.find('.logo').outerHeight();
				viewportHeight = viewportHeight > $(window).height() ? $(window).height() - $this.find('.logo').outerHeight() : viewportHeight;

				$this.removeClass('fidget');
				$this.height(viewportHeight + $this.find('.logo').outerHeight());

				var $obj = $this.find('.sf-menu2'),
						$logo = $this.find('.logo'),
						dy = $obj.outerHeight() - viewportHeight;

				if (dy > 0) {
					if (core.touch) {
						swipeMenu(dy);
					} else {
						$this.mousemove(function (e) {
							$obj.css({
								'top': -e.clientY / viewportHeight * dy
							});
							$logo.css({
								'top': -e.clientY / viewportHeight * dy
							});

						}).addClass('fidget');
					}
				}




			} else {
				$this.css({'height': 'auto'});
				$this.find('.logo').css({'top': 0});
				$this.unbind('mousemove');
			}
		};

		var openMenu = function (sound) {
			if (isSmallScreen)
				return;
			if (sound) {
				that.play({'mp3': that.sound, 'ogg': that.soundOgg});
			}
			$this.css({'width': that.opened_value + 'px'});
			$this.addClass('ihover');
			core.dispatcher.fire('menu_open', that.speed, that.slider_box_offset, that.content_offset);
			iOpen = true;
		};

		var closeMenu = function (sound) {
			if (isSmallScreen)
				return;
			if (sound) {
				that.play({'mp3': that.sound, 'ogg': that.soundOgg});
			}
			$this.css({'width': that.closed_value + 'px'});
			$this.removeClass('ihover');
			core.dispatcher.fire('menu_close', that.speed);
			iOpen = false;
		};

		var activeItem = function () {
			$this.find(".current-menu-item").closest(".current-menu-parent").addClass("open");
		};
	}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file Menu.js'); }

// file Menu.js end

// file SinglePost.js start

try { 
core.addWidgetClass({'class' : 'SinglePost', 'definition' : function($) {
	
	var that = this, isOpen = false, isSmallScreen, content_height, animation = false,
		$this, $click_area, $close_btn, $widgets;
	
	this.defaults = {
		'click_area' : '.post_box',
		'close_btn' : ".close_btn",
		'width' : 'auto',
		'sidebar' : false,
		'sidebarSound' : '',
		'sidebarSoundOgg' : '',
		'hoverSound': '',
		'hoverSoundOgg': '',
		'location': 'post',
		'retina': false,
		'keepOpen': false
	};
	
	this.init = function() {
		var delta = 0;
		$this = $(this.selector);
		$click_area = $this.find(this.click_area);
		$close_btn = $this.find(this.close_btn);
		$widgets = $this.find(".widget");

		addHendlers();

		if(that.retina) {
			setRetinaImage(that.retina);
		}
		
		if(this.keepOpen) {
			this.open($this, $click_area, $close_btn);
		}
		$this.width(that.width);
			
				if(this.sidebar && that.width == '87%') {
					delta = 256;
				}
			
				$this.width($this.width() - delta);
	};
	
	var addHendlers = function() {
		$click_area.find('.more-link').click(function(e){ e.preventDefault(); });
		$click_area
			.click(function () { that.open($this, $click_area, $close_btn); })
			.on('mouseenter', function() { if ($(this).hasClass('preview')) { that.play({'mp3': that.hoverSound, 'ogg': that.hoverSoundOgg}); } });

		$close_btn.click(function() {
			that.close($this, $click_area, $close_btn);
		});
		if (that.location === 'th_portfolio') {
			$('.show_thumb').on('click', function(e){
				e.preventDefault();
				try {
					history.back();
				} catch(e) {
					path = '/';
				}
			});
		}

		core.dispatcher.addEventlistener('content_set_height', that, function(responsive, contentHeight) {
			if(!responsive) {
				if($this.height() > contentHeight) {
					$this.addClass('big-content');
				} else {
					$this.removeClass('big-content');
				}
			}
		});
		
		
		core.dispatcher.addEventlistener('window_resize', that, function(responsive, w, h) {
			var delta = 0;		
			if(!responsive) {
			
				$this.width(that.width);
			
				if(this.sidebar && that.width == '87%') {
					delta = 256;
				}
				$this.width($this.width() - delta);
				core.dispatcher.fire('solid-box_resize');
			} else{
				$this.width('auto');
				core.swipe($('#content'), {
					'swipeRight': function(){if($('.navigation a[rel=prev]').attr('href')) document.location.href = $('.navigation a[rel=prev]').attr('href');},
					'swipeLeft': function(){if($('.navigation a[rel=next]').attr('href')) document.location.href = $('.navigation a[rel=next]').attr('href');}
				});
			}
		});
		
		if($(".post_box .more_info, .post_box .more-link").length) {
		  $(".post_track").addClass('with_more_link');
		}
		
	};
	
	var setRetinaImage = function(src) {
		var $fImageCont = $('.feat_image_resp');
		if($fImageCont.find('img').length>0) {
			$fImageCont.find('img').data('retina', src).addClass('retina');
		} else {
			$fImageCont.append($('<img>', {'class': 'attachment-portfolio_thumbnail wp-post-image retina', 'data-retina': src, 'src': '123'}));
		}
	};
	
	this.open = function($this, $click_area, $close_btn) {
		if (animation || isOpen) return;
		animation = true;
		isOpen = true;
		$click_area.removeClass("preview");
		$(".navigation").hide();
		$this.offset({"top":$this.offset().top});
		content_height = $this.height();
		$this.addClass("open");
		$this.animate({"top":"0"}, 1000, 'myEaseInOutBack', function(){
			if(that.sidebar){
				openSidebar($this);
			} else {
				$close_btn.addClass("btn_show");
				setTimeout(function(){
					animation = false;
				},600);
			}
			$this.addClass('open_content');
			core.dispatcher.fire('post_open');
		});
	};
	
	this.close = function($this, $click_area, $close_btn) {
		if (animation || isSmallScreen || !isOpen) return;
		animation = true;
		isOpen = false;
		$close_btn.removeClass("btn_show");
		if(this.sidebar){
			closeSidebar($this, $close_btn, function() {
				closePost($this, $click_area);
			});
		} else {
			
			closePost($this, $click_area);
		}
	};
	
	var closePost = function($this, $click_area) {
		$this.removeClass("open");
		$this.removeClass('open_content');
		$this.css({
			"bottom" : $("#content").height() - $this.position().top - content_height,
			"top" : "auto"
		});
		$(window).resize();
		$this.animate({"bottom":"0px"},1000, 'myEaseInOutBack', function() {
			$click_area.addClass("preview");
			$(".navigation").show();
			animation = false;
		});
	};
	
	var openSidebar = function($this) {
		$this.find(".widget-area").height("auto");
		that.play({'mp3': that.sidebarSound, 'ogg': that.sidebarSoundOgg});
		var time = 0;
		var counter = 0;
		var delta = 50;
		$this.find(".widget-area").addClass("open").removeClass("close");
		setTimeout(function(){
			$close_btn.addClass("btn_show");
		}, 1000);
		$widgets.each(function(i) {
			var $widget = $(this);
			setTimeout(function() {
				setTimeout(function() {
					setTimeout(function(){
						animation = false;
					}, 600);
					core.dispatcher.fire('sidebar_open');
				}, 900 );
				$widget.addClass("open");
				counter ++;
			}, time += delta );
		});
		$this.addClass("open_sidebar");
		$this.find(".widget-area").addClass("open");
	};

	var closeSidebar = function($this, $close_btn, callback) {
		setTimeout(function() {
			that.play({'mp3': that.sidebarSound, 'ogg': that.sidebarSoundOgg});
    		$this.find(".widget-area").addClass("close").removeClass("open");
    		$this.removeClass("open_sidebar");
    		setTimeout(function() {
    			$this.find(".widget").removeClass("open");
    			$this.find(".widget-area").height(0);
				callback();
			}, 300);
    	}, 350);
    };

}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file SinglePost.js'); }

// file SinglePost.js end

// file Slider.js start

try { 
core.addWidgetClass({'class' : 'Slider', 'definition' : function($) {
	
	var that = this,
		$this,
		timeoutID,
		queue = [],
		effectProgress = false;
	
	this.defaults = {
		'effect' : 'fade',
		'direction' : 'left',
		'nextBtn' : '.next',
		'prevBtn' : '.prev',
		'pauseBtn' : '.play_pause',
		'autoplay' : false,
		'random' : false,
		'slideTime' : 10000,
		'dinamicHeight' : false,
		'effectTime' : 500
	};
		
	this.slides = [];
	this.currentSlide = 0;
	this.paused = false;
	this.stoped = false;
	
	this.init = function(data) {
		$this = $(this.selector);
		this.saveSlides(data);
		this.render(data);
		
		if(data.length > 1) {
			this.controls($this);
		}

		this.next();
		
		if(this.autoplay && data.length > 1){
		
		}
		
	};
	
	this.saveSlides = function(data) {
		this.slides = data;
	};
	
	/*
	 * @todo: reserch html templates
	 */
	this.render = function(slides) {
		var $slides = $('<div>', {'class': 'slides', 'style': 'overflow: hidden;'});
			
		for (var i=0, l=slides.length; i<l; i++){
			$slides.append($('<div>', {'class': 'slide', 'id': 'slide_' + i, 'data-id': i, 'style': 'display:none; position:absolute', 'html': slides[i]}));
		}
		$this.append($slides);
	};
	
	this.controls = function($this) {
		$this.find(this.prevBtn).click(function(e) {
			e.preventDefault();
			that.prev();
		});
		$this.find(this.nextBtn).click(function(e) {
			e.preventDefault();
			that.next();
		});
	};
	
	this.changeSlide = function(to) {
		if(to == this.currentSlide) return;
		
		to = to || this.currentSlide + 1;

		if (typeof(to) === 'string'){
			to = (to === 'prev') ? (this.currentSlide - 1) : (this.currentSlide + 1);
		}
		
		//looping
		to = (to > this.slides.length) 
					? (to - this.slides.length) 
					: (to < 1) ? (to + this.slides.length) : to;
		
		if(effectProgress) {

			return;
		}
		
		this.currentSlide = to;

		this.fireEffect(this.getDom(), this.currentSlide);
	};
	
	this.next = function() {
		(this.random && this.slides.length > 1) 
			? this.goTo(random(0, this.slides.length, this.currentSlide))
			: this.changeSlide('next');
	};
	
	this.prev = function() {
		this.changeSlide('prev');
	};
	
	this.goTo = function(id) {
		this.changeSlide(id);
	};
	
	this.start = function() {
		this.paused = false;
		this.startSlide();
	};
	
	this.stop = function() {
		this.paused = true;
		clearTimeout(timeoutID);
	};
	
	/*
	 * this is recursion thru method next and changeSlide
	 */
	this.startSlide = function() {
		clearTimeout(timeoutID);
		var ctx = this;
		if(queue.length > 0) {
			ctx.goTo(queue.pop());
		} else {
			timeoutID = setTimeout(function() {
				if (!ctx.paused) {
					ctx.next();
				}
			}, this.slideTime);
		}
	};
	
	this.beforeSlideChange = function() {};
	this.afterSlideChange = function() {};
	
	this.fireEffect = function($container, current){
		$container.find('.intro.active').removeClass('active');

		var $currentSlide = $container.find('.slide.active').removeClass('active'),
			$nextSlide = $container.find('.slide#slide_' + (current - 1)).addClass('active'),
			$intro = $container.find('#intro_' + (current - 1)).addClass('active'),
			ctx = this;
	
		var onload = function(ctx) {
			ctx.beforeSlideChange($currentSlide, $nextSlide);
			effectsLib[ctx.effect]({
				'callback': function($currentSlide, $nextSlide){
					effectProgress = false;
					ctx.afterSlideChange($currentSlide, $nextSlide);
					if (ctx.slides.length <= 1) return;
					ctx.startSlide();
				},
				'currentSlide': $currentSlide,
				'nextSlide': $nextSlide,
				'intro': $intro,
				'direction': ctx.direction
			});
		};
	
		effectProgress = true;
		if($nextSlide.find('.img').length > 0 && $nextSlide.find('.img').data('load') != 1 // preload image
				&& !(core.browser.isIE() && core.browser.IEversion() < 9)) {			

			var src = $nextSlide.find('.img').first().data('src');
			if(src.length > 0) {
				core.preloader.show();
				$('<img>', {'src': src}).one('load', function() {
					$nextSlide.find('.img').first().data('load', 1);
					core.preloader.hide();
					onload(ctx);
				}).error(function() {
					core.preloader.hide();
				})
				.attr('src', src);
			} else {
				core.preloader.hide();
			}
		} else {
			onload(ctx);
		}
	};
	
	this.addEffect = function(effextName, effectFunc) {
		effectsLib[effextName] = effectFunc;
	};
	
	var effectsLib = {
		'fade' : function(options) {
			options.currentSlide.fadeOut(that.effectTime);
			if(that.dinamicHeight) {

				options.nextSlide.parent().animate({'height': options.nextSlide.height() + 'px'}, 200);
			}
			options.nextSlide.css({'display': 'none'}).fadeIn(that.effectTime, function() {
				options.callback(options.currentSlide, options.nextSlide);
			});
		},
		'slide' : function(options) {
			var cssStartObj = {},
				cssFinishObj = {},
				param = (options.direction === 'left' || options.direction === 'right') ? 'width' : 'height',
				opositParam = (param === 'width') ? 'height' : 'width';
		
			cssStartObj[options.direction] = 0;
			cssStartObj[param] = 0;
			cssStartObj[opositParam] = '100%';
			cssFinishObj[param] = '100%';
			
			var w = options.nextSlide.width(),
				h = options.nextSlide.height();

			options.nextSlide
				.css(cssStartObj)
				.find('.img')
					.css(cssStartObj).height(h).width(w).parent()
				.show()
				.animate(cssFinishObj, that.effectTime, 'easeInOutExpo', function() {
					options.currentSlide.hide();
					options.callback(options.currentSlide, options.nextSlide);
				});
		},

		'slide with intro' : function(options) {
			var cssStartObj = {},
				cssFinishObj = {},
				param = (options.direction === 'left' || options.direction === 'right') ? 'width' : 'height',
				opositParam = (param === 'width') ? 'height' : 'width';
		
			cssStartObj[options.direction] = 0;
			cssStartObj[param] = 0;
			cssStartObj[opositParam] = '100%';
			cssFinishObj[param] = '100%';
			
			var w = options.nextSlide.width(),
				h = options.nextSlide.height(),
				$title = options.intro.find('.title').width(w).removeClass('move-title');

			setTimeout(function() { 
				if(core.browser.isIE() && core.browser.IEversion() < 10) {
					$title.css({'bottom': '45%'}).animate({'bottom': '50%'}, 2000);
				} else {
					$title.addClass('move-title'); 
				}
			}, that.effectTime/3 + 250 );
			options.intro.css(cssStartObj).animate(cssFinishObj, that.effectTime, 'easeInOutExpo', function(){
				setTimeout(function() {
					options.nextSlide
						.css(cssStartObj)
						.find('.img')
							.css(cssStartObj).height(h).width(w).parent()
						//.width(0)
						.show()
						.animate(cssFinishObj, that.effectTime, 'easeInOutExpo', function() {
							options.intro.css(cssStartObj);
							options.currentSlide.hide();
							options.callback(options.currentSlide, options.nextSlide);
						});
				}, 1000);
			});
		},
		'fly' : function(options) {
			options.nextSlide
				.css({'left': options.nextSlide.width()})
				.show()
				.animate({'left': '0'}, that.effectTime, function() {
					options.currentSlide.css({'left': options.currentSlide.width()});
					options.callback(options.currentSlide, options.nextSlide);
				});
		}
	};
	
	this.getDOMSlide = function(id) {
		return $(this.selector).find('#slide_' + id);
	};
	
}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file Slider.js'); }

// file Slider.js end

// file Slideshow.js start

try { 
core.addWidgetClass({'class' : 'Slideshow', 'extends': 'BgSlider', 'definition' : function($) {
		
	var that = this,
		$this,
		$showThumbBtn,
		$slideshow_settings,
		$viewport,
		$thumbList,
		$thumbControls,
		effect,
		smallScreen,
		animateProgress = false,
		thumbnailsOpen = false;
	
	this.defaults = {
		'slideshow_settings' : '.slideshow_settings',
		'thumbWidth' : 125,
		'hideThumbnails' : false,
		'sound' : '',
		'soundOgg': '',
		'openedThumbnails':false
	};
	
	this.init = function(data) {
		if (data.length == 0) {
			throw 'no slides';
		}
		$this = $(this.selector);
		$slideshow_settings = $(this.slideshow_settings);
		
		effect = that.effect;
		
		this.saveSlides(data);
		this.render(data, $this);
		if(!this.hideThumbnails) {
			renderThumb(data);
		}
		$(".play_pause").addClass((this.autoplay) ? 'play' : 'pause');
		addHendlers();

		this.initSlideshow(data, $this);
	};
	
	this.togglePlay = function($button) {
		if(this.stoped) {
			$button.removeClass('pause');
			$button.addClass('play');
			this.start();
			this.stoped = false;
			that.timelineRestart();
		} else {
			$button.addClass('pause');
			$button.removeClass('play');
			this.stop();
			that.timelineStop();
			this.stoped = true;
		}
	};
	
	var renderThumb = function(slides){
		$thumbList = $('<ul>', {'class': 'thumb_list'});
		for (var i=0, l=slides.length; i<l; i++){
			$('<li>', {'id': 'slideshow_thumb_' + (i+1), 'html': '<a href="" style="width:120px;height:100px" data-id="' + (i+1) + '">' + slides[i].thumbnail + '<span class="d_block p_abs loop"><i></i><em></em></span></a>'}).appendTo($thumbList);
		}
		$showThumbBtn = $('<a>', {'class': 'p_abs d_block nav_btn show_thumb'});
		$viewport = $('<div>', {'class': 'viewport', 'html': $thumbList});
		$slideshow_settings
			.append($showThumbBtn)
			.append($viewport)
			.css({"bottom": $("footer>.inner").outerHeight()-1});
		
		$viewport.wrap("<div class='view_wrap'/>");
		$(".view_wrap").append($('<a>', {'class': 'prev nav_btn'})).append($('<a>', {'class': 'next nav_btn'}));

		core.dispatcher.addEventlistener('window_resize', that, function(responsive, w, h) {
			$viewport.width(Math.floor($slideshow_settings.width() / this.thumbWidth) * this.thumbWidth);
			$thumbList.css({'left': '0'});
		
			if( responsive ) {
				$this.height( (h > 750) ? 370 : 262 );
				$slideshow_settings.hide();
			} else {
				$this.height('100%');
				$slideshow_settings.show();
			}
		});
		$thumbList.width(slides.length * that.thumbWidth);
	};
	
	this.beforeSlideChange = function($currentSlide, $nextSlide) {

		if(this.slides[this.currentSlide - 1].type == 'intro')
			this.effect = 'slide with intro';
		else 
			this.effect = effect;
		this.timelineStop();
		$('body')
			.removeClass('slide__' + $('body').data('slide'))
			.addClass('slide__' + (this.currentSlide - 1))
			.data('slide', this.currentSlide - 1);
		if (that.zoomEffect) {
			if(this.slides[this.currentSlide - 1].type == 'intro') {
				setTimeout(function(){
					$nextSlide.find('.img').addClass('zoomed');
					$currentSlide.find('.img').removeClass('zoomed');
				}, 500);
			} else {
				$nextSlide.find('.img').addClass('zoomed');
				$currentSlide.find('.img').removeClass('zoomed');
			}
			
		}
		$('.slideshow_banner').empty();
		if(smallScreen){
			var $html = $(that.slides[that.currentSlide - 1].html);
			if (that.introSlide) {
				$html.find('.title2').remove();
			}
			$('.slideshow_banner').html($html);
			$html.fadeIn();
		} else {
			$('.slideshow_banner').hide();
		}
		var $activeThumb = $('#slideshow_thumb_' + (that.currentSlide));
		$activeThumb.parent().find('li').removeClass('active');
		$activeThumb.addClass('active');
	};
	
	this.afterSlideChange = function($currentSlide, $nextSlide) {
		if(!that.paused){ that.timelineRestart(); }
		if(!smallScreen){
			
			var $html = $(that.slides[that.currentSlide - 1].html).hide();
			if (that.introSlide) {
				$html.find('.title2').remove();
			}
			$html.show();
			$('.slideshow_banner').html($html);
			
			setContentPosition(smallScreen, $("#content").height());
			
			$('.slideshow_banner').fadeIn(1000).width($html.width());
		}
	};
	
	this.controls = function() {
		var $controls = $('#content').find('.slideshow_nav');
		$controls.find(this.prevBtn).click(function(e) {
			e.preventDefault();
			that.prev();
		});
		$controls.find(this.nextBtn).click(function(e) {
			e.preventDefault();
			that.next();
		});
		$controls.find(this.pauseBtn).click(function(e) {
			e.preventDefault();
			that.togglePlay($(this));
		});
		if($viewport){
			$viewport.parent().find('a.nav_btn').click(function(){
				moveThumbs($(this).hasClass('prev') ? 'left' : 'right');
			});
		}
	};
	
	var moveThumbs = function(direction) {
		if(animateProgress) return;
		var offset = (direction == 'left') ? that.thumbWidth : -that.thumbWidth,
			l = $thumbList.position().left + offset;
		if (l > 0 || l < ($viewport.width() - $thumbList.width())) return;
		animateProgress = true;
		$thumbList.animate({'left': l}, function(){
			animateProgress = false;
		});
	};
	
	var setContentPosition = function(responsive, contentHeight) {
		if(!responsive) {
			if($('.slideshow_banner').height() > contentHeight) {
				$('.slideshow_banner').addClass('big-content');
			} else {
				$('.slideshow_banner').removeClass('big-content');
			}
		}
	};
	
	var addHendlers = function() {
		core.dispatcher.addEventlistener('window_resize', that, function(responsive, w, h) {
			smallScreen = responsive;
			if( responsive ) {
				$this.height( (h > 750) ? 370 : 262 );
				
			} else {
				$this.height('100%');
				
			}
		});
		
		core.dispatcher.addEventlistener('content_set_height', that, setContentPosition);
		
		var $paralaxObjects = $('#content').find('.slideshow_banner, .slideshow_nav');
		if(!that.hideThumbnails) {
			$showThumbBtn.click(function(e) {
				that.play({'mp3': that.sound, 'ogg': that.soundOgg});
				e.preventDefault();
				
				var newPos = thumbnailsOpen ? 0 : 70;
				
				thumbnailsOpen = !thumbnailsOpen;
				$thumbList.slideToggle(800, 'easeInOutExpo');
				
				$showThumbBtn.toggleClass('closeIcon');
				if(!smallScreen){
					// core.transition($this.find('.slides'), {'bottom': newPos + 'px'}, that.paralaxSpeed);
					$this.find('.slides').animate({
						'bottom': newPos + 'px'
					}, 800, 'easeInOutExpo');
					core.transition($paralaxObjects, {"margin-bottom": newPos-1 + "px"}, that.paralaxSpeed);
					var thumbHeight = (thumbnailsOpen) ? 138 : 0;
					$("footer .timeline_wrap").stop().animate({"bottom": $("footer").height() + thumbHeight + "px"}, 800, "easeInOutExpo");
				}
			});
			
			core.dispatcher.addEventlistener('window_resize', that, function(responsive, w, h) {
				if(!smallScreen){
					$slideshow_settings.css({'bottom': $("footer>.inner").outerHeight()-1})
					var thumbHeight = (thumbnailsOpen) ? 138 : 0;
					$("footer .timeline_wrap").stop().animate({"bottom": $("footer").height() + thumbHeight + "px"}, 800, "easeInOutExpo");
				}
			});
			
			
			 if (that.openedThumbnails) {
				 $showThumbBtn.trigger('click');
			 }
		}
		$slideshow_settings
			.mouseover(function() {
				if($viewport.width() < $thumbList.width()){
					$viewport.parent().addClass("show");
				}
			})
			.mouseleave(function() {
				$viewport.parent().removeClass("show");
			})
			.find('li a').click(function(e) {
				e.preventDefault();
				that.goTo($(this).data('id'));
			});
			
		core.swipe($('#content, #slider_box'), {
			'swipeRight': function(){that.prev();},
			'swipeLeft': function(){that.next();}
		});
		
		core.swipe($('footer').find('.view_wrap'), {
			'swipeRight': function(){moveThumbs('left');},
			'swipeLeft': function(){moveThumbs('right');}
		});
	
		that.controls($this);

		$(".non_touch_device ul.thumb_list li a").live({
		    mouseenter: function () {
		    	$(this).removeClass("roll_out");
				$(this).addClass("roll_in");
		    },
		    mouseleave: function () {
		    	$(this).addClass("roll_out");
				$(this).removeClass("roll_in");
		    }
		});
	};
}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file Slideshow.js'); }

// file Slideshow.js end

// file easing.effects.js start

try { 
jQuery.extend(jQuery.easing,
{
    def: 'easeOutQuad',
    swing: function (x, t, b, c, d) {

        return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
    },
    easeInQuad: function (x, t, b, c, d) {
        return c*(t/=d)*t + b;
    },
    easeOutQuad: function (x, t, b, c, d) {
        return -c *(t/=d)*(t-2) + b;
    },
    easeInOutQuad: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t + b;
        return -c/2 * ((--t)*(t-2) - 1) + b;
    },
    easeInCubic: function (x, t, b, c, d) {
        return c*(t/=d)*t*t + b;
    },
    easeOutCubic: function (x, t, b, c, d) {
        return c*((t=t/d-1)*t*t + 1) + b;
    },
    easeInOutCubic: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t + b;
        return c/2*((t-=2)*t*t + 2) + b;
    },
    easeInQuart: function (x, t, b, c, d) {
        return c*(t/=d)*t*t*t + b;
    },
    easeOutQuart: function (x, t, b, c, d) {
        return -c * ((t=t/d-1)*t*t*t - 1) + b;
    },
    easeInOutQuart: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
        return -c/2 * ((t-=2)*t*t*t - 2) + b;
    },
    easeInQuint: function (x, t, b, c, d) {
        return c*(t/=d)*t*t*t*t + b;
    },
    easeOutQuint: function (x, t, b, c, d) {
        return c*((t=t/d-1)*t*t*t*t + 1) + b;
    },
    easeInOutQuint: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
        return c/2*((t-=2)*t*t*t*t + 2) + b;
    },
    easeInSine: function (x, t, b, c, d) {
        return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
    },
    easeOutSine: function (x, t, b, c, d) {
        return c * Math.sin(t/d * (Math.PI/2)) + b;
    },
    easeInOutSine: function (x, t, b, c, d) {
        return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
    },
    easeInExpo: function (x, t, b, c, d) {
        return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
    },
    easeOutExpo: function (x, t, b, c, d) {
        return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
    },
    easeInOutExpo: function (x, t, b, c, d) {
        if (t==0) return b;
        if (t==d) return b+c;
        if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
        return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
    },
    easeInCirc: function (x, t, b, c, d) {
        return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
    },
    easeOutCirc: function (x, t, b, c, d) {
        return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
    },
    easeInOutCirc: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
        return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
    },
    easeInElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
    },
    easeOutElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
    },
    easeInOutElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
        return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
    },
    easeInBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c*(t/=d)*t*((s+1)*t - s) + b;
    },
    easeOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
    },
    easeInOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
        return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
    },
	myEaseInOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 0.70158;
        if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
        return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
    },
    easeInBounce: function (x, t, b, c, d) {
        return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
    },
    easeOutBounce: function (x, t, b, c, d) {
        if ((t/=d) < (1/2.75)) {
            return c*(7.5625*t*t) + b;
        } else if (t < (2/2.75)) {
            return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
        } else if (t < (2.5/2.75)) {
            return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
        } else {
            return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
        }
    },
    easeInOutBounce: function (x, t, b, c, d) {
        if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
        return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
    }
});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file easing.effects.js'); }

// file easing.effects.js end

// file froogaloop.min.js start

try { 
var Froogaloop=function(){function e(a){return new e.fn.init(a)}function h(a,c,b){if(!b.contentWindow.postMessage)return!1;var f=b.getAttribute("src").split("?")[0],a=JSON.stringify({method:a,value:c});"//"===f.substr(0,2)&&(f=window.location.protocol+f);b.contentWindow.postMessage(a,f)}function j(a){var c,b;try{c=JSON.parse(a.data),b=c.event||c.method}catch(f){}"ready"==b&&!i&&(i=!0);if(a.origin!=k)return!1;var a=c.value,e=c.data,g=""===g?null:c.player_id;c=g?d[g][b]:d[b];b=[];if(!c)return!1;void 0!==
a&&b.push(a);e&&b.push(e);g&&b.push(g);return 0<b.length?c.apply(null,b):c.call()}function l(a,c,b){b?(d[b]||(d[b]={}),d[b][a]=c):d[a]=c}var d={},i=!1,k="";e.fn=e.prototype={element:null,init:function(a){"string"===typeof a&&(a=document.getElementById(a));this.element=a;a=this.element.getAttribute("src");"//"===a.substr(0,2)&&(a=window.location.protocol+a);for(var a=a.split("/"),c="",b=0,f=a.length;b<f;b++){if(3>b)c+=a[b];else break;2>b&&(c+="/")}k=c;return this},api:function(a,c){if(!this.element||
!a)return!1;var b=this.element,f=""!==b.id?b.id:null,d=!c||!c.constructor||!c.call||!c.apply?c:null,e=c&&c.constructor&&c.call&&c.apply?c:null;e&&l(a,e,f);h(a,d,b);return this},addEvent:function(a,c){if(!this.element)return!1;var b=this.element,d=""!==b.id?b.id:null;l(a,c,d);"ready"!=a?h("addEventListener",a,b):"ready"==a&&i&&c.call(null,d);return this},removeEvent:function(a){if(!this.element)return!1;var c=this.element,b;a:{if((b=""!==c.id?c.id:null)&&d[b]){if(!d[b][a]){b=!1;break a}d[b][a]=null}else{if(!d[a]){b=
!1;break a}d[a]=null}b=!0}"ready"!=a&&b&&h("removeEventListener",a,c)}};e.fn.init.prototype=e.fn;window.addEventListener?window.addEventListener("message",j,!1):window.attachEvent("onmessage",j);return window.Froogaloop=window.$f=e}();
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file froogaloop.min.js'); }

// file froogaloop.min.js end

// file jquery.browsermobile.min.js start

try { 
(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file jquery.browsermobile.min.js'); }

// file jquery.browsermobile.min.js end

// file jquery.isotope.min.js start

try { 
/*!
 * Isotope PACKAGED v2.1.0
 * Filter & sort magical layouts
 * http://isotope.metafizzy.co
 */

(function(t){function e(){}function i(t){function i(e){e.prototype.option||(e.prototype.option=function(e){t.isPlainObject(e)&&(this.options=t.extend(!0,this.options,e))})}function n(e,i){t.fn[e]=function(n){if("string"==typeof n){for(var s=o.call(arguments,1),a=0,u=this.length;u>a;a++){var p=this[a],h=t.data(p,e);if(h)if(t.isFunction(h[n])&&"_"!==n.charAt(0)){var f=h[n].apply(h,s);if(void 0!==f)return f}else r("no such method '"+n+"' for "+e+" instance");else r("cannot call methods on "+e+" prior to initialization; "+"attempted to call '"+n+"'")}return this}return this.each(function(){var o=t.data(this,e);o?(o.option(n),o._init()):(o=new i(this,n),t.data(this,e,o))})}}if(t){var r="undefined"==typeof console?e:function(t){console.error(t)};return t.bridget=function(t,e){i(e),n(t,e)},t.bridget}}var o=Array.prototype.slice;"function"==typeof define&&define.amd?define("jquery-bridget/jquery.bridget",["jquery"],i):"object"==typeof exports?i(require("jquery")):i(t.jQuery)})(window),function(t){function e(e){var i=t.event;return i.target=i.target||i.srcElement||e,i}var i=document.documentElement,o=function(){};i.addEventListener?o=function(t,e,i){t.addEventListener(e,i,!1)}:i.attachEvent&&(o=function(t,i,o){t[i+o]=o.handleEvent?function(){var i=e(t);o.handleEvent.call(o,i)}:function(){var i=e(t);o.call(t,i)},t.attachEvent("on"+i,t[i+o])});var n=function(){};i.removeEventListener?n=function(t,e,i){t.removeEventListener(e,i,!1)}:i.detachEvent&&(n=function(t,e,i){t.detachEvent("on"+e,t[e+i]);try{delete t[e+i]}catch(o){t[e+i]=void 0}});var r={bind:o,unbind:n};"function"==typeof define&&define.amd?define("eventie/eventie",r):"object"==typeof exports?module.exports=r:t.eventie=r}(this),function(t){function e(t){"function"==typeof t&&(e.isReady?t():s.push(t))}function i(t){var i="readystatechange"===t.type&&"complete"!==r.readyState;e.isReady||i||o()}function o(){e.isReady=!0;for(var t=0,i=s.length;i>t;t++){var o=s[t];o()}}function n(n){return"complete"===r.readyState?o():(n.bind(r,"DOMContentLoaded",i),n.bind(r,"readystatechange",i),n.bind(t,"load",i)),e}var r=t.document,s=[];e.isReady=!1,"function"==typeof define&&define.amd?define("doc-ready/doc-ready",["eventie/eventie"],n):"object"==typeof exports?module.exports=n(require("eventie")):t.docReady=n(t.eventie)}(window),function(){function t(){}function e(t,e){for(var i=t.length;i--;)if(t[i].listener===e)return i;return-1}function i(t){return function(){return this[t].apply(this,arguments)}}var o=t.prototype,n=this,r=n.EventEmitter;o.getListeners=function(t){var e,i,o=this._getEvents();if(t instanceof RegExp){e={};for(i in o)o.hasOwnProperty(i)&&t.test(i)&&(e[i]=o[i])}else e=o[t]||(o[t]=[]);return e},o.flattenListeners=function(t){var e,i=[];for(e=0;t.length>e;e+=1)i.push(t[e].listener);return i},o.getListenersAsObject=function(t){var e,i=this.getListeners(t);return i instanceof Array&&(e={},e[t]=i),e||i},o.addListener=function(t,i){var o,n=this.getListenersAsObject(t),r="object"==typeof i;for(o in n)n.hasOwnProperty(o)&&-1===e(n[o],i)&&n[o].push(r?i:{listener:i,once:!1});return this},o.on=i("addListener"),o.addOnceListener=function(t,e){return this.addListener(t,{listener:e,once:!0})},o.once=i("addOnceListener"),o.defineEvent=function(t){return this.getListeners(t),this},o.defineEvents=function(t){for(var e=0;t.length>e;e+=1)this.defineEvent(t[e]);return this},o.removeListener=function(t,i){var o,n,r=this.getListenersAsObject(t);for(n in r)r.hasOwnProperty(n)&&(o=e(r[n],i),-1!==o&&r[n].splice(o,1));return this},o.off=i("removeListener"),o.addListeners=function(t,e){return this.manipulateListeners(!1,t,e)},o.removeListeners=function(t,e){return this.manipulateListeners(!0,t,e)},o.manipulateListeners=function(t,e,i){var o,n,r=t?this.removeListener:this.addListener,s=t?this.removeListeners:this.addListeners;if("object"!=typeof e||e instanceof RegExp)for(o=i.length;o--;)r.call(this,e,i[o]);else for(o in e)e.hasOwnProperty(o)&&(n=e[o])&&("function"==typeof n?r.call(this,o,n):s.call(this,o,n));return this},o.removeEvent=function(t){var e,i=typeof t,o=this._getEvents();if("string"===i)delete o[t];else if(t instanceof RegExp)for(e in o)o.hasOwnProperty(e)&&t.test(e)&&delete o[e];else delete this._events;return this},o.removeAllListeners=i("removeEvent"),o.emitEvent=function(t,e){var i,o,n,r,s=this.getListenersAsObject(t);for(n in s)if(s.hasOwnProperty(n))for(o=s[n].length;o--;)i=s[n][o],i.once===!0&&this.removeListener(t,i.listener),r=i.listener.apply(this,e||[]),r===this._getOnceReturnValue()&&this.removeListener(t,i.listener);return this},o.trigger=i("emitEvent"),o.emit=function(t){var e=Array.prototype.slice.call(arguments,1);return this.emitEvent(t,e)},o.setOnceReturnValue=function(t){return this._onceReturnValue=t,this},o._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},o._getEvents=function(){return this._events||(this._events={})},t.noConflict=function(){return n.EventEmitter=r,t},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return t}):"object"==typeof module&&module.exports?module.exports=t:n.EventEmitter=t}.call(this),function(t){function e(t){if(t){if("string"==typeof o[t])return t;t=t.charAt(0).toUpperCase()+t.slice(1);for(var e,n=0,r=i.length;r>n;n++)if(e=i[n]+t,"string"==typeof o[e])return e}}var i="Webkit Moz ms Ms O".split(" "),o=document.documentElement.style;"function"==typeof define&&define.amd?define("get-style-property/get-style-property",[],function(){return e}):"object"==typeof exports?module.exports=e:t.getStyleProperty=e}(window),function(t){function e(t){var e=parseFloat(t),i=-1===t.indexOf("%")&&!isNaN(e);return i&&e}function i(){}function o(){for(var t={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},e=0,i=s.length;i>e;e++){var o=s[e];t[o]=0}return t}function n(i){function n(){if(!d){d=!0;var o=t.getComputedStyle;if(p=function(){var t=o?function(t){return o(t,null)}:function(t){return t.currentStyle};return function(e){var i=t(e);return i||r("Style returned "+i+". Are you running this code in a hidden iframe on Firefox? "+"See http://bit.ly/getsizebug1"),i}}(),h=i("boxSizing")){var n=document.createElement("div");n.style.width="200px",n.style.padding="1px 2px 3px 4px",n.style.borderStyle="solid",n.style.borderWidth="1px 2px 3px 4px",n.style[h]="border-box";var s=document.body||document.documentElement;s.appendChild(n);var a=p(n);f=200===e(a.width),s.removeChild(n)}}}function a(t){if(n(),"string"==typeof t&&(t=document.querySelector(t)),t&&"object"==typeof t&&t.nodeType){var i=p(t);if("none"===i.display)return o();var r={};r.width=t.offsetWidth,r.height=t.offsetHeight;for(var a=r.isBorderBox=!(!h||!i[h]||"border-box"!==i[h]),d=0,l=s.length;l>d;d++){var c=s[d],y=i[c];y=u(t,y);var m=parseFloat(y);r[c]=isNaN(m)?0:m}var g=r.paddingLeft+r.paddingRight,v=r.paddingTop+r.paddingBottom,_=r.marginLeft+r.marginRight,I=r.marginTop+r.marginBottom,L=r.borderLeftWidth+r.borderRightWidth,z=r.borderTopWidth+r.borderBottomWidth,b=a&&f,x=e(i.width);x!==!1&&(r.width=x+(b?0:g+L));var S=e(i.height);return S!==!1&&(r.height=S+(b?0:v+z)),r.innerWidth=r.width-(g+L),r.innerHeight=r.height-(v+z),r.outerWidth=r.width+_,r.outerHeight=r.height+I,r}}function u(e,i){if(t.getComputedStyle||-1===i.indexOf("%"))return i;var o=e.style,n=o.left,r=e.runtimeStyle,s=r&&r.left;return s&&(r.left=e.currentStyle.left),o.left=i,i=o.pixelLeft,o.left=n,s&&(r.left=s),i}var p,h,f,d=!1;return a}var r="undefined"==typeof console?i:function(t){console.error(t)},s=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"];"function"==typeof define&&define.amd?define("get-size/get-size",["get-style-property/get-style-property"],n):"object"==typeof exports?module.exports=n(require("desandro-get-style-property")):t.getSize=n(t.getStyleProperty)}(window),function(t){function e(t,e){return t[s](e)}function i(t){if(!t.parentNode){var e=document.createDocumentFragment();e.appendChild(t)}}function o(t,e){i(t);for(var o=t.parentNode.querySelectorAll(e),n=0,r=o.length;r>n;n++)if(o[n]===t)return!0;return!1}function n(t,o){return i(t),e(t,o)}var r,s=function(){if(t.matchesSelector)return"matchesSelector";for(var e=["webkit","moz","ms","o"],i=0,o=e.length;o>i;i++){var n=e[i],r=n+"MatchesSelector";if(t[r])return r}}();if(s){var a=document.createElement("div"),u=e(a,"div");r=u?e:n}else r=o;"function"==typeof define&&define.amd?define("matches-selector/matches-selector",[],function(){return r}):"object"==typeof exports?module.exports=r:window.matchesSelector=r}(Element.prototype),function(t){function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t){for(var e in t)return!1;return e=null,!0}function o(t){return t.replace(/([A-Z])/g,function(t){return"-"+t.toLowerCase()})}function n(t,n,r){function a(t,e){t&&(this.element=t,this.layout=e,this.position={x:0,y:0},this._create())}var u=r("transition"),p=r("transform"),h=u&&p,f=!!r("perspective"),d={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"otransitionend",transition:"transitionend"}[u],l=["transform","transition","transitionDuration","transitionProperty"],c=function(){for(var t={},e=0,i=l.length;i>e;e++){var o=l[e],n=r(o);n&&n!==o&&(t[o]=n)}return t}();e(a.prototype,t.prototype),a.prototype._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},a.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},a.prototype.getSize=function(){this.size=n(this.element)},a.prototype.css=function(t){var e=this.element.style;for(var i in t){var o=c[i]||i;e[o]=t[i]}},a.prototype.getPosition=function(){var t=s(this.element),e=this.layout.options,i=e.isOriginLeft,o=e.isOriginTop,n=parseInt(t[i?"left":"right"],10),r=parseInt(t[o?"top":"bottom"],10);n=isNaN(n)?0:n,r=isNaN(r)?0:r;var a=this.layout.size;n-=i?a.paddingLeft:a.paddingRight,r-=o?a.paddingTop:a.paddingBottom,this.position.x=n,this.position.y=r},a.prototype.layoutPosition=function(){var t=this.layout.size,e=this.layout.options,i={};e.isOriginLeft?(i.left=this.position.x+t.paddingLeft+"px",i.right=""):(i.right=this.position.x+t.paddingRight+"px",i.left=""),e.isOriginTop?(i.top=this.position.y+t.paddingTop+"px",i.bottom=""):(i.bottom=this.position.y+t.paddingBottom+"px",i.top=""),this.css(i),this.emitEvent("layout",[this])};var y=f?function(t,e){return"translate3d("+t+"px, "+e+"px, 0)"}:function(t,e){return"translate("+t+"px, "+e+"px)"};a.prototype._transitionTo=function(t,e){this.getPosition();var i=this.position.x,o=this.position.y,n=parseInt(t,10),r=parseInt(e,10),s=n===this.position.x&&r===this.position.y;if(this.setPosition(t,e),s&&!this.isTransitioning)return this.layoutPosition(),void 0;var a=t-i,u=e-o,p={},h=this.layout.options;a=h.isOriginLeft?a:-a,u=h.isOriginTop?u:-u,p.transform=y(a,u),this.transition({to:p,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})},a.prototype.goTo=function(t,e){this.setPosition(t,e),this.layoutPosition()},a.prototype.moveTo=h?a.prototype._transitionTo:a.prototype.goTo,a.prototype.setPosition=function(t,e){this.position.x=parseInt(t,10),this.position.y=parseInt(e,10)},a.prototype._nonTransition=function(t){this.css(t.to),t.isCleaning&&this._removeStyles(t.to);for(var e in t.onTransitionEnd)t.onTransitionEnd[e].call(this)},a.prototype._transition=function(t){if(!parseFloat(this.layout.options.transitionDuration))return this._nonTransition(t),void 0;var e=this._transn;for(var i in t.onTransitionEnd)e.onEnd[i]=t.onTransitionEnd[i];for(i in t.to)e.ingProperties[i]=!0,t.isCleaning&&(e.clean[i]=!0);if(t.from){this.css(t.from);var o=this.element.offsetHeight;o=null}this.enableTransition(t.to),this.css(t.to),this.isTransitioning=!0};var m=p&&o(p)+",opacity";a.prototype.enableTransition=function(){this.isTransitioning||(this.css({transitionProperty:m,transitionDuration:this.layout.options.transitionDuration}),this.element.addEventListener(d,this,!1))},a.prototype.transition=a.prototype[u?"_transition":"_nonTransition"],a.prototype.onwebkitTransitionEnd=function(t){this.ontransitionend(t)},a.prototype.onotransitionend=function(t){this.ontransitionend(t)};var g={"-webkit-transform":"transform","-moz-transform":"transform","-o-transform":"transform"};a.prototype.ontransitionend=function(t){if(t.target===this.element){var e=this._transn,o=g[t.propertyName]||t.propertyName;if(delete e.ingProperties[o],i(e.ingProperties)&&this.disableTransition(),o in e.clean&&(this.element.style[t.propertyName]="",delete e.clean[o]),o in e.onEnd){var n=e.onEnd[o];n.call(this),delete e.onEnd[o]}this.emitEvent("transitionEnd",[this])}},a.prototype.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(d,this,!1),this.isTransitioning=!1},a.prototype._removeStyles=function(t){var e={};for(var i in t)e[i]="";this.css(e)};var v={transitionProperty:"",transitionDuration:""};return a.prototype.removeTransitionStyles=function(){this.css(v)},a.prototype.removeElem=function(){this.element.parentNode.removeChild(this.element),this.emitEvent("remove",[this])},a.prototype.remove=function(){if(!u||!parseFloat(this.layout.options.transitionDuration))return this.removeElem(),void 0;var t=this;this.on("transitionEnd",function(){return t.removeElem(),!0}),this.hide()},a.prototype.reveal=function(){delete this.isHidden,this.css({display:""});var t=this.layout.options;this.transition({from:t.hiddenStyle,to:t.visibleStyle,isCleaning:!0})},a.prototype.hide=function(){this.isHidden=!0,this.css({display:""});var t=this.layout.options;this.transition({from:t.visibleStyle,to:t.hiddenStyle,isCleaning:!0,onTransitionEnd:{opacity:function(){this.isHidden&&this.css({display:"none"})}}})},a.prototype.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},a}var r=t.getComputedStyle,s=r?function(t){return r(t,null)}:function(t){return t.currentStyle};"function"==typeof define&&define.amd?define("outlayer/item",["eventEmitter/EventEmitter","get-size/get-size","get-style-property/get-style-property"],n):"object"==typeof exports?module.exports=n(require("wolfy87-eventemitter"),require("get-size"),require("desandro-get-style-property")):(t.Outlayer={},t.Outlayer.Item=n(t.EventEmitter,t.getSize,t.getStyleProperty))}(window),function(t){function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t){return"[object Array]"===f.call(t)}function o(t){var e=[];if(i(t))e=t;else if(t&&"number"==typeof t.length)for(var o=0,n=t.length;n>o;o++)e.push(t[o]);else e.push(t);return e}function n(t,e){var i=l(e,t);-1!==i&&e.splice(i,1)}function r(t){return t.replace(/(.)([A-Z])/g,function(t,e,i){return e+"-"+i}).toLowerCase()}function s(i,s,f,l,c,y){function m(t,i){if("string"==typeof t&&(t=a.querySelector(t)),!t||!d(t))return u&&u.error("Bad "+this.constructor.namespace+" element: "+t),void 0;this.element=t,this.options=e({},this.constructor.defaults),this.option(i);var o=++g;this.element.outlayerGUID=o,v[o]=this,this._create(),this.options.isInitLayout&&this.layout()}var g=0,v={};return m.namespace="outlayer",m.Item=y,m.defaults={containerStyle:{position:"relative"},isInitLayout:!0,isOriginLeft:!0,isOriginTop:!0,isResizeBound:!0,isResizingContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}},e(m.prototype,f.prototype),m.prototype.option=function(t){e(this.options,t)},m.prototype._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),e(this.element.style,this.options.containerStyle),this.options.isResizeBound&&this.bindResize()},m.prototype.reloadItems=function(){this.items=this._itemize(this.element.children)},m.prototype._itemize=function(t){for(var e=this._filterFindItemElements(t),i=this.constructor.Item,o=[],n=0,r=e.length;r>n;n++){var s=e[n],a=new i(s,this);o.push(a)}return o},m.prototype._filterFindItemElements=function(t){t=o(t);for(var e=this.options.itemSelector,i=[],n=0,r=t.length;r>n;n++){var s=t[n];if(d(s))if(e){c(s,e)&&i.push(s);for(var a=s.querySelectorAll(e),u=0,p=a.length;p>u;u++)i.push(a[u])}else i.push(s)}return i},m.prototype.getItemElements=function(){for(var t=[],e=0,i=this.items.length;i>e;e++)t.push(this.items[e].element);return t},m.prototype.layout=function(){this._resetLayout(),this._manageStamps();var t=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;this.layoutItems(this.items,t),this._isLayoutInited=!0},m.prototype._init=m.prototype.layout,m.prototype._resetLayout=function(){this.getSize()},m.prototype.getSize=function(){this.size=l(this.element)},m.prototype._getMeasurement=function(t,e){var i,o=this.options[t];o?("string"==typeof o?i=this.element.querySelector(o):d(o)&&(i=o),this[t]=i?l(i)[e]:o):this[t]=0},m.prototype.layoutItems=function(t,e){t=this._getItemsForLayout(t),this._layoutItems(t,e),this._postLayout()},m.prototype._getItemsForLayout=function(t){for(var e=[],i=0,o=t.length;o>i;i++){var n=t[i];n.isIgnored||e.push(n)}return e},m.prototype._layoutItems=function(t,e){function i(){o.emitEvent("layoutComplete",[o,t])}var o=this;if(!t||!t.length)return i(),void 0;this._itemsOn(t,"layout",i);for(var n=[],r=0,s=t.length;s>r;r++){var a=t[r],u=this._getItemLayoutPosition(a);u.item=a,u.isInstant=e||a.isLayoutInstant,n.push(u)}this._processLayoutQueue(n)},m.prototype._getItemLayoutPosition=function(){return{x:0,y:0}},m.prototype._processLayoutQueue=function(t){for(var e=0,i=t.length;i>e;e++){var o=t[e];this._positionItem(o.item,o.x,o.y,o.isInstant)}},m.prototype._positionItem=function(t,e,i,o){o?t.goTo(e,i):t.moveTo(e,i)},m.prototype._postLayout=function(){this.resizeContainer()},m.prototype.resizeContainer=function(){if(this.options.isResizingContainer){var t=this._getContainerSize();t&&(this._setContainerMeasure(t.width,!0),this._setContainerMeasure(t.height,!1))}},m.prototype._getContainerSize=h,m.prototype._setContainerMeasure=function(t,e){if(void 0!==t){var i=this.size;i.isBorderBox&&(t+=e?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),t=Math.max(t,0),this.element.style[e?"width":"height"]=t+"px"}},m.prototype._itemsOn=function(t,e,i){function o(){return n++,n===r&&i.call(s),!0}for(var n=0,r=t.length,s=this,a=0,u=t.length;u>a;a++){var p=t[a];p.on(e,o)}},m.prototype.ignore=function(t){var e=this.getItem(t);e&&(e.isIgnored=!0)},m.prototype.unignore=function(t){var e=this.getItem(t);e&&delete e.isIgnored},m.prototype.stamp=function(t){if(t=this._find(t)){this.stamps=this.stamps.concat(t);for(var e=0,i=t.length;i>e;e++){var o=t[e];this.ignore(o)}}},m.prototype.unstamp=function(t){if(t=this._find(t))for(var e=0,i=t.length;i>e;e++){var o=t[e];n(o,this.stamps),this.unignore(o)}},m.prototype._find=function(t){return t?("string"==typeof t&&(t=this.element.querySelectorAll(t)),t=o(t)):void 0},m.prototype._manageStamps=function(){if(this.stamps&&this.stamps.length){this._getBoundingRect();for(var t=0,e=this.stamps.length;e>t;t++){var i=this.stamps[t];this._manageStamp(i)}}},m.prototype._getBoundingRect=function(){var t=this.element.getBoundingClientRect(),e=this.size;this._boundingRect={left:t.left+e.paddingLeft+e.borderLeftWidth,top:t.top+e.paddingTop+e.borderTopWidth,right:t.right-(e.paddingRight+e.borderRightWidth),bottom:t.bottom-(e.paddingBottom+e.borderBottomWidth)}},m.prototype._manageStamp=h,m.prototype._getElementOffset=function(t){var e=t.getBoundingClientRect(),i=this._boundingRect,o=l(t),n={left:e.left-i.left-o.marginLeft,top:e.top-i.top-o.marginTop,right:i.right-e.right-o.marginRight,bottom:i.bottom-e.bottom-o.marginBottom};return n},m.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},m.prototype.bindResize=function(){this.isResizeBound||(i.bind(t,"resize",this),this.isResizeBound=!0)},m.prototype.unbindResize=function(){this.isResizeBound&&i.unbind(t,"resize",this),this.isResizeBound=!1},m.prototype.onresize=function(){function t(){e.resize(),delete e.resizeTimeout}this.resizeTimeout&&clearTimeout(this.resizeTimeout);var e=this;this.resizeTimeout=setTimeout(t,100)},m.prototype.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},m.prototype.needsResizeLayout=function(){var t=l(this.element),e=this.size&&t;return e&&t.innerWidth!==this.size.innerWidth},m.prototype.addItems=function(t){var e=this._itemize(t);return e.length&&(this.items=this.items.concat(e)),e},m.prototype.appended=function(t){var e=this.addItems(t);e.length&&(this.layoutItems(e,!0),this.reveal(e))},m.prototype.prepended=function(t){var e=this._itemize(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this._manageStamps(),this.layoutItems(e,!0),this.reveal(e),this.layoutItems(i)}},m.prototype.reveal=function(t){var e=t&&t.length;if(e)for(var i=0;e>i;i++){var o=t[i];o.reveal()}},m.prototype.hide=function(t){var e=t&&t.length;if(e)for(var i=0;e>i;i++){var o=t[i];o.hide()}},m.prototype.getItem=function(t){for(var e=0,i=this.items.length;i>e;e++){var o=this.items[e];if(o.element===t)return o}},m.prototype.getItems=function(t){if(t&&t.length){for(var e=[],i=0,o=t.length;o>i;i++){var n=t[i],r=this.getItem(n);r&&e.push(r)}return e}},m.prototype.remove=function(t){t=o(t);var e=this.getItems(t);if(e&&e.length){this._itemsOn(e,"remove",function(){this.emitEvent("removeComplete",[this,e])});for(var i=0,r=e.length;r>i;i++){var s=e[i];s.remove(),n(s,this.items)}}},m.prototype.destroy=function(){var t=this.element.style;t.height="",t.position="",t.width="";for(var e=0,i=this.items.length;i>e;e++){var o=this.items[e];o.destroy()}this.unbindResize();var n=this.element.outlayerGUID;delete v[n],delete this.element.outlayerGUID,p&&p.removeData(this.element,this.constructor.namespace)},m.data=function(t){var e=t&&t.outlayerGUID;return e&&v[e]},m.create=function(t,i){function o(){m.apply(this,arguments)}return Object.create?o.prototype=Object.create(m.prototype):e(o.prototype,m.prototype),o.prototype.constructor=o,o.defaults=e({},m.defaults),e(o.defaults,i),o.prototype.settings={},o.namespace=t,o.data=m.data,o.Item=function(){y.apply(this,arguments)},o.Item.prototype=new y,s(function(){for(var e=r(t),i=a.querySelectorAll(".js-"+e),n="data-"+e+"-options",s=0,h=i.length;h>s;s++){var f,d=i[s],l=d.getAttribute(n);try{f=l&&JSON.parse(l)}catch(c){u&&u.error("Error parsing "+n+" on "+d.nodeName.toLowerCase()+(d.id?"#"+d.id:"")+": "+c);continue}var y=new o(d,f);p&&p.data(d,t,y)}}),p&&p.bridget&&p.bridget(t,o),o},m.Item=y,m}var a=t.document,u=t.console,p=t.jQuery,h=function(){},f=Object.prototype.toString,d="function"==typeof HTMLElement||"object"==typeof HTMLElement?function(t){return t instanceof HTMLElement}:function(t){return t&&"object"==typeof t&&1===t.nodeType&&"string"==typeof t.nodeName},l=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,o=t.length;o>i;i++)if(t[i]===e)return i;return-1};"function"==typeof define&&define.amd?define("outlayer/outlayer",["eventie/eventie","doc-ready/doc-ready","eventEmitter/EventEmitter","get-size/get-size","matches-selector/matches-selector","./item"],s):"object"==typeof exports?module.exports=s(require("eventie"),require("doc-ready"),require("wolfy87-eventemitter"),require("get-size"),require("desandro-matches-selector"),require("./item")):t.Outlayer=s(t.eventie,t.docReady,t.EventEmitter,t.getSize,t.matchesSelector,t.Outlayer.Item)}(window),function(t){function e(t){function e(){t.Item.apply(this,arguments)}e.prototype=new t.Item,e.prototype._create=function(){this.id=this.layout.itemGUID++,t.Item.prototype._create.call(this),this.sortData={}},e.prototype.updateSortData=function(){if(!this.isIgnored){this.sortData.id=this.id,this.sortData["original-order"]=this.id,this.sortData.random=Math.random();var t=this.layout.options.getSortData,e=this.layout._sorters;for(var i in t){var o=e[i];this.sortData[i]=o(this.element,this)}}};var i=e.prototype.destroy;return e.prototype.destroy=function(){i.apply(this,arguments),this.css({display:""})},e}"function"==typeof define&&define.amd?define("isotope/js/item",["outlayer/outlayer"],e):"object"==typeof exports?module.exports=e(require("outlayer")):(t.Isotope=t.Isotope||{},t.Isotope.Item=e(t.Outlayer))}(window),function(t){function e(t,e){function i(t){this.isotope=t,t&&(this.options=t.options[this.namespace],this.element=t.element,this.items=t.filteredItems,this.size=t.size)}return function(){function t(t){return function(){return e.prototype[t].apply(this.isotope,arguments)}}for(var o=["_resetLayout","_getItemLayoutPosition","_manageStamp","_getContainerSize","_getElementOffset","needsResizeLayout"],n=0,r=o.length;r>n;n++){var s=o[n];i.prototype[s]=t(s)}}(),i.prototype.needsVerticalResizeLayout=function(){var e=t(this.isotope.element),i=this.isotope.size&&e;return i&&e.innerHeight!==this.isotope.size.innerHeight},i.prototype._getMeasurement=function(){this.isotope._getMeasurement.apply(this,arguments)},i.prototype.getColumnWidth=function(){this.getSegmentSize("column","Width")},i.prototype.getRowHeight=function(){this.getSegmentSize("row","Height")},i.prototype.getSegmentSize=function(t,e){var i=t+e,o="outer"+e;if(this._getMeasurement(i,o),!this[i]){var n=this.getFirstItemSize();this[i]=n&&n[o]||this.isotope.size["inner"+e]}},i.prototype.getFirstItemSize=function(){var e=this.isotope.filteredItems[0];return e&&e.element&&t(e.element)},i.prototype.layout=function(){this.isotope.layout.apply(this.isotope,arguments)},i.prototype.getSize=function(){this.isotope.getSize(),this.size=this.isotope.size},i.modes={},i.create=function(t,e){function o(){i.apply(this,arguments)}return o.prototype=new i,e&&(o.options=e),o.prototype.namespace=t,i.modes[t]=o,o},i}"function"==typeof define&&define.amd?define("isotope/js/layout-mode",["get-size/get-size","outlayer/outlayer"],e):"object"==typeof exports?module.exports=e(require("get-size"),require("outlayer")):(t.Isotope=t.Isotope||{},t.Isotope.LayoutMode=e(t.getSize,t.Outlayer))}(window),function(t){function e(t,e){var o=t.create("masonry");return o.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns();var t=this.cols;for(this.colYs=[];t--;)this.colYs.push(0);this.maxY=0},o.prototype.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var t=this.items[0],i=t&&t.element;this.columnWidth=i&&e(i).outerWidth||this.containerWidth}this.columnWidth+=this.gutter,this.cols=Math.floor((this.containerWidth+this.gutter)/this.columnWidth),this.cols=Math.max(this.cols,1)},o.prototype.getContainerWidth=function(){var t=this.options.isFitWidth?this.element.parentNode:this.element,i=e(t);this.containerWidth=i&&i.innerWidth},o.prototype._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth%this.columnWidth,o=e&&1>e?"round":"ceil",n=Math[o](t.size.outerWidth/this.columnWidth);n=Math.min(n,this.cols);for(var r=this._getColGroup(n),s=Math.min.apply(Math,r),a=i(r,s),u={x:this.columnWidth*a,y:s},p=s+t.size.outerHeight,h=this.cols+1-r.length,f=0;h>f;f++)this.colYs[a+f]=p;return u},o.prototype._getColGroup=function(t){if(2>t)return this.colYs;for(var e=[],i=this.cols+1-t,o=0;i>o;o++){var n=this.colYs.slice(o,o+t);e[o]=Math.max.apply(Math,n)}return e},o.prototype._manageStamp=function(t){var i=e(t),o=this._getElementOffset(t),n=this.options.isOriginLeft?o.left:o.right,r=n+i.outerWidth,s=Math.floor(n/this.columnWidth);s=Math.max(0,s);var a=Math.floor(r/this.columnWidth);a-=r%this.columnWidth?0:1,a=Math.min(this.cols-1,a);for(var u=(this.options.isOriginTop?o.top:o.bottom)+i.outerHeight,p=s;a>=p;p++)this.colYs[p]=Math.max(u,this.colYs[p])},o.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this.options.isFitWidth&&(t.width=this._getContainerFitWidth()),t},o.prototype._getContainerFitWidth=function(){for(var t=0,e=this.cols;--e&&0===this.colYs[e];)t++;return(this.cols-t)*this.columnWidth-this.gutter},o.prototype.needsResizeLayout=function(){var t=this.containerWidth;return this.getContainerWidth(),t!==this.containerWidth},o}var i=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,o=t.length;o>i;i++){var n=t[i];if(n===e)return i}return-1};"function"==typeof define&&define.amd?define("masonry/masonry",["outlayer/outlayer","get-size/get-size"],e):"object"==typeof exports?module.exports=e(require("outlayer"),require("get-size")):t.Masonry=e(t.Outlayer,t.getSize)}(window),function(t){function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t,i){var o=t.create("masonry"),n=o.prototype._getElementOffset,r=o.prototype.layout,s=o.prototype._getMeasurement;e(o.prototype,i.prototype),o.prototype._getElementOffset=n,o.prototype.layout=r,o.prototype._getMeasurement=s;var a=o.prototype.measureColumns;o.prototype.measureColumns=function(){this.items=this.isotope.filteredItems,a.call(this)};var u=o.prototype._manageStamp;return o.prototype._manageStamp=function(){this.options.isOriginLeft=this.isotope.options.isOriginLeft,this.options.isOriginTop=this.isotope.options.isOriginTop,u.apply(this,arguments)},o}"function"==typeof define&&define.amd?define("isotope/js/layout-modes/masonry",["../layout-mode","masonry/masonry"],i):"object"==typeof exports?module.exports=i(require("../layout-mode"),require("masonry-layout")):i(t.Isotope.LayoutMode,t.Masonry)}(window),function(t){function e(t){var e=t.create("fitRows");return e.prototype._resetLayout=function(){this.x=0,this.y=0,this.maxY=0,this._getMeasurement("gutter","outerWidth")},e.prototype._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth+this.gutter,i=this.isotope.size.innerWidth+this.gutter;0!==this.x&&e+this.x>i&&(this.x=0,this.y=this.maxY);var o={x:this.x,y:this.y};return this.maxY=Math.max(this.maxY,this.y+t.size.outerHeight),this.x+=e,o},e.prototype._getContainerSize=function(){return{height:this.maxY}},e}"function"==typeof define&&define.amd?define("isotope/js/layout-modes/fit-rows",["../layout-mode"],e):"object"==typeof exports?module.exports=e(require("../layout-mode")):e(t.Isotope.LayoutMode)}(window),function(t){function e(t){var e=t.create("vertical",{horizontalAlignment:0});return e.prototype._resetLayout=function(){this.y=0},e.prototype._getItemLayoutPosition=function(t){t.getSize();var e=(this.isotope.size.innerWidth-t.size.outerWidth)*this.options.horizontalAlignment,i=this.y;return this.y+=t.size.outerHeight,{x:e,y:i}},e.prototype._getContainerSize=function(){return{height:this.y}},e}"function"==typeof define&&define.amd?define("isotope/js/layout-modes/vertical",["../layout-mode"],e):"object"==typeof exports?module.exports=e(require("../layout-mode")):e(t.Isotope.LayoutMode)}(window),function(t){function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t){return"[object Array]"===h.call(t)}function o(t){var e=[];if(i(t))e=t;else if(t&&"number"==typeof t.length)for(var o=0,n=t.length;n>o;o++)e.push(t[o]);else e.push(t);return e}function n(t,e){var i=f(e,t);-1!==i&&e.splice(i,1)}function r(t,i,r,u,h){function f(t,e){return function(i,o){for(var n=0,r=t.length;r>n;n++){var s=t[n],a=i.sortData[s],u=o.sortData[s];if(a>u||u>a){var p=void 0!==e[s]?e[s]:e,h=p?1:-1;return(a>u?1:-1)*h}}return 0}}var d=t.create("isotope",{layoutMode:"masonry",isJQueryFiltering:!0,sortAscending:!0});d.Item=u,d.LayoutMode=h,d.prototype._create=function(){this.itemGUID=0,this._sorters={},this._getSorters(),t.prototype._create.call(this),this.modes={},this.filteredItems=this.items,this.sortHistory=["original-order"];for(var e in h.modes)this._initLayoutMode(e)},d.prototype.reloadItems=function(){this.itemGUID=0,t.prototype.reloadItems.call(this)},d.prototype._itemize=function(){for(var e=t.prototype._itemize.apply(this,arguments),i=0,o=e.length;o>i;i++){var n=e[i];n.id=this.itemGUID++}return this._updateItemsSortData(e),e
},d.prototype._initLayoutMode=function(t){var i=h.modes[t],o=this.options[t]||{};this.options[t]=i.options?e(i.options,o):o,this.modes[t]=new i(this)},d.prototype.layout=function(){return!this._isLayoutInited&&this.options.isInitLayout?(this.arrange(),void 0):(this._layout(),void 0)},d.prototype._layout=function(){var t=this._getIsInstant();this._resetLayout(),this._manageStamps(),this.layoutItems(this.filteredItems,t),this._isLayoutInited=!0},d.prototype.arrange=function(t){this.option(t),this._getIsInstant(),this.filteredItems=this._filter(this.items),this._sort(),this._layout()},d.prototype._init=d.prototype.arrange,d.prototype._getIsInstant=function(){var t=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;return this._isInstant=t,t},d.prototype._filter=function(t){function e(){f.reveal(n),f.hide(r)}var i=this.options.filter;i=i||"*";for(var o=[],n=[],r=[],s=this._getFilterTest(i),a=0,u=t.length;u>a;a++){var p=t[a];if(!p.isIgnored){var h=s(p);h&&o.push(p),h&&p.isHidden?n.push(p):h||p.isHidden||r.push(p)}}var f=this;return this._isInstant?this._noTransition(e):e(),o},d.prototype._getFilterTest=function(t){return s&&this.options.isJQueryFiltering?function(e){return s(e.element).is(t)}:"function"==typeof t?function(e){return t(e.element)}:function(e){return r(e.element,t)}},d.prototype.updateSortData=function(t){var e;t?(t=o(t),e=this.getItems(t)):e=this.items,this._getSorters(),this._updateItemsSortData(e)},d.prototype._getSorters=function(){var t=this.options.getSortData;for(var e in t){var i=t[e];this._sorters[e]=l(i)}},d.prototype._updateItemsSortData=function(t){for(var e=t&&t.length,i=0;e&&e>i;i++){var o=t[i];o.updateSortData()}};var l=function(){function t(t){if("string"!=typeof t)return t;var i=a(t).split(" "),o=i[0],n=o.match(/^\[(.+)\]$/),r=n&&n[1],s=e(r,o),u=d.sortDataParsers[i[1]];return t=u?function(t){return t&&u(s(t))}:function(t){return t&&s(t)}}function e(t,e){var i;return i=t?function(e){return e.getAttribute(t)}:function(t){var i=t.querySelector(e);return i&&p(i)}}return t}();d.sortDataParsers={parseInt:function(t){return parseInt(t,10)},parseFloat:function(t){return parseFloat(t)}},d.prototype._sort=function(){var t=this.options.sortBy;if(t){var e=[].concat.apply(t,this.sortHistory),i=f(e,this.options.sortAscending);this.filteredItems.sort(i),t!==this.sortHistory[0]&&this.sortHistory.unshift(t)}},d.prototype._mode=function(){var t=this.options.layoutMode,e=this.modes[t];if(!e)throw Error("No layout mode: "+t);return e.options=this.options[t],e},d.prototype._resetLayout=function(){t.prototype._resetLayout.call(this),this._mode()._resetLayout()},d.prototype._getItemLayoutPosition=function(t){return this._mode()._getItemLayoutPosition(t)},d.prototype._manageStamp=function(t){this._mode()._manageStamp(t)},d.prototype._getContainerSize=function(){return this._mode()._getContainerSize()},d.prototype.needsResizeLayout=function(){return this._mode().needsResizeLayout()},d.prototype.appended=function(t){var e=this.addItems(t);if(e.length){var i=this._filterRevealAdded(e);this.filteredItems=this.filteredItems.concat(i)}},d.prototype.prepended=function(t){var e=this._itemize(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this._manageStamps();var o=this._filterRevealAdded(e);this.layoutItems(i),this.filteredItems=o.concat(this.filteredItems)}},d.prototype._filterRevealAdded=function(t){var e=this._noTransition(function(){return this._filter(t)});return this.layoutItems(e,!0),this.reveal(e),t},d.prototype.insert=function(t){var e=this.addItems(t);if(e.length){var i,o,n=e.length;for(i=0;n>i;i++)o=e[i],this.element.appendChild(o.element);var r=this._filter(e);for(this._noTransition(function(){this.hide(r)}),i=0;n>i;i++)e[i].isLayoutInstant=!0;for(this.arrange(),i=0;n>i;i++)delete e[i].isLayoutInstant;this.reveal(r)}};var c=d.prototype.remove;return d.prototype.remove=function(t){t=o(t);var e=this.getItems(t);if(c.call(this,t),e&&e.length)for(var i=0,r=e.length;r>i;i++){var s=e[i];n(s,this.filteredItems)}},d.prototype.shuffle=function(){for(var t=0,e=this.items.length;e>t;t++){var i=this.items[t];i.sortData.random=Math.random()}this.options.sortBy="random",this._sort(),this._layout()},d.prototype._noTransition=function(t){var e=this.options.transitionDuration;this.options.transitionDuration=0;var i=t.call(this);return this.options.transitionDuration=e,i},d.prototype.getFilteredItemElements=function(){for(var t=[],e=0,i=this.filteredItems.length;i>e;e++)t.push(this.filteredItems[e].element);return t},d}var s=t.jQuery,a=String.prototype.trim?function(t){return t.trim()}:function(t){return t.replace(/^\s+|\s+$/g,"")},u=document.documentElement,p=u.textContent?function(t){return t.textContent}:function(t){return t.innerText},h=Object.prototype.toString,f=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,o=t.length;o>i;i++)if(t[i]===e)return i;return-1};"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size","matches-selector/matches-selector","isotope/js/item","isotope/js/layout-mode","isotope/js/layout-modes/masonry","isotope/js/layout-modes/fit-rows","isotope/js/layout-modes/vertical"],r):"object"==typeof exports?module.exports=r(require("outlayer"),require("get-size"),require("desandro-matches-selector"),require("./item"),require("./layout-mode"),require("./layout-modes/masonry"),require("./layout-modes/fit-rows"),require("./layout-modes/vertical")):t.Isotope=r(t.Outlayer,t.getSize,t.matchesSelector,t.Isotope.Item,t.Isotope.LayoutMode)}(window);
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file jquery.isotope.min.js'); }

// file jquery.isotope.min.js end

// file jquery.jplayer.min.js start

try { 
/*! jPlayer 2.9.2 for jQuery ~ (c) 2009-2014 Happyworm Ltd ~ MIT License */
!function(a,b){"function"==typeof define&&define.amd?define(["jquery"],b):b("object"==typeof exports?require("jquery"):a.jQuery?a.jQuery:a.Zepto)}(this,function(a,b){a.fn.jPlayer=function(c){var d="jPlayer",e="string"==typeof c,f=Array.prototype.slice.call(arguments,1),g=this;return c=!e&&f.length?a.extend.apply(null,[!0,c].concat(f)):c,e&&"_"===c.charAt(0)?g:(this.each(e?function(){var e=a(this).data(d),h=e&&a.isFunction(e[c])?e[c].apply(e,f):e;return h!==e&&h!==b?(g=h,!1):void 0}:function(){var b=a(this).data(d);b?b.option(c||{}):a(this).data(d,new a.jPlayer(c,this))}),g)},a.jPlayer=function(b,c){if(arguments.length){this.element=a(c),this.options=a.extend(!0,{},this.options,b);var d=this;this.element.bind("remove.jPlayer",function(){d.destroy()}),this._init()}},"function"!=typeof a.fn.stop&&(a.fn.stop=function(){}),a.jPlayer.emulateMethods="load play pause",a.jPlayer.emulateStatus="src readyState networkState currentTime duration paused ended playbackRate",a.jPlayer.emulateOptions="muted volume",a.jPlayer.reservedEvent="ready flashreset resize repeat error warning",a.jPlayer.event={},a.each(["ready","setmedia","flashreset","resize","repeat","click","error","warning","loadstart","progress","suspend","abort","emptied","stalled","play","pause","loadedmetadata","loadeddata","waiting","playing","canplay","canplaythrough","seeking","seeked","timeupdate","ended","ratechange","durationchange","volumechange"],function(){a.jPlayer.event[this]="jPlayer_"+this}),a.jPlayer.htmlEvent=["loadstart","abort","emptied","stalled","loadedmetadata","canplay","canplaythrough"],a.jPlayer.pause=function(){a.jPlayer.prototype.destroyRemoved(),a.each(a.jPlayer.prototype.instances,function(a,b){b.data("jPlayer").status.srcSet&&b.jPlayer("pause")})},a.jPlayer.timeFormat={showHour:!1,showMin:!0,showSec:!0,padHour:!1,padMin:!0,padSec:!0,sepHour:":",sepMin:":",sepSec:""};var c=function(){this.init()};c.prototype={init:function(){this.options={timeFormat:a.jPlayer.timeFormat}},time:function(a){a=a&&"number"==typeof a?a:0;var b=new Date(1e3*a),c=b.getUTCHours(),d=this.options.timeFormat.showHour?b.getUTCMinutes():b.getUTCMinutes()+60*c,e=this.options.timeFormat.showMin?b.getUTCSeconds():b.getUTCSeconds()+60*d,f=this.options.timeFormat.padHour&&10>c?"0"+c:c,g=this.options.timeFormat.padMin&&10>d?"0"+d:d,h=this.options.timeFormat.padSec&&10>e?"0"+e:e,i="";return i+=this.options.timeFormat.showHour?f+this.options.timeFormat.sepHour:"",i+=this.options.timeFormat.showMin?g+this.options.timeFormat.sepMin:"",i+=this.options.timeFormat.showSec?h+this.options.timeFormat.sepSec:""}};var d=new c;a.jPlayer.convertTime=function(a){return d.time(a)},a.jPlayer.uaBrowser=function(a){var b=a.toLowerCase(),c=/(webkit)[ \/]([\w.]+)/,d=/(opera)(?:.*version)?[ \/]([\w.]+)/,e=/(msie) ([\w.]+)/,f=/(mozilla)(?:.*? rv:([\w.]+))?/,g=c.exec(b)||d.exec(b)||e.exec(b)||b.indexOf("compatible")<0&&f.exec(b)||[];return{browser:g[1]||"",version:g[2]||"0"}},a.jPlayer.uaPlatform=function(a){var b=a.toLowerCase(),c=/(ipad|iphone|ipod|android|blackberry|playbook|windows ce|webos)/,d=/(ipad|playbook)/,e=/(android)/,f=/(mobile)/,g=c.exec(b)||[],h=d.exec(b)||!f.exec(b)&&e.exec(b)||[];return g[1]&&(g[1]=g[1].replace(/\s/g,"_")),{platform:g[1]||"",tablet:h[1]||""}},a.jPlayer.browser={},a.jPlayer.platform={};var e=a.jPlayer.uaBrowser(navigator.userAgent);e.browser&&(a.jPlayer.browser[e.browser]=!0,a.jPlayer.browser.version=e.version);var f=a.jPlayer.uaPlatform(navigator.userAgent);f.platform&&(a.jPlayer.platform[f.platform]=!0,a.jPlayer.platform.mobile=!f.tablet,a.jPlayer.platform.tablet=!!f.tablet),a.jPlayer.getDocMode=function(){var b;return a.jPlayer.browser.msie&&(document.documentMode?b=document.documentMode:(b=5,document.compatMode&&"CSS1Compat"===document.compatMode&&(b=7))),b},a.jPlayer.browser.documentMode=a.jPlayer.getDocMode(),a.jPlayer.nativeFeatures={init:function(){var a,b,c,d=document,e=d.createElement("video"),f={w3c:["fullscreenEnabled","fullscreenElement","requestFullscreen","exitFullscreen","fullscreenchange","fullscreenerror"],moz:["mozFullScreenEnabled","mozFullScreenElement","mozRequestFullScreen","mozCancelFullScreen","mozfullscreenchange","mozfullscreenerror"],webkit:["","webkitCurrentFullScreenElement","webkitRequestFullScreen","webkitCancelFullScreen","webkitfullscreenchange",""],webkitVideo:["webkitSupportsFullscreen","webkitDisplayingFullscreen","webkitEnterFullscreen","webkitExitFullscreen","",""],ms:["","msFullscreenElement","msRequestFullscreen","msExitFullscreen","MSFullscreenChange","MSFullscreenError"]},g=["w3c","moz","webkit","webkitVideo","ms"];for(this.fullscreen=a={support:{w3c:!!d[f.w3c[0]],moz:!!d[f.moz[0]],webkit:"function"==typeof d[f.webkit[3]],webkitVideo:"function"==typeof e[f.webkitVideo[2]],ms:"function"==typeof e[f.ms[2]]},used:{}},b=0,c=g.length;c>b;b++){var h=g[b];if(a.support[h]){a.spec=h,a.used[h]=!0;break}}if(a.spec){var i=f[a.spec];a.api={fullscreenEnabled:!0,fullscreenElement:function(a){return a=a?a:d,a[i[1]]},requestFullscreen:function(a){return a[i[2]]()},exitFullscreen:function(a){return a=a?a:d,a[i[3]]()}},a.event={fullscreenchange:i[4],fullscreenerror:i[5]}}else a.api={fullscreenEnabled:!1,fullscreenElement:function(){return null},requestFullscreen:function(){},exitFullscreen:function(){}},a.event={}}},a.jPlayer.nativeFeatures.init(),a.jPlayer.focus=null,a.jPlayer.keyIgnoreElementNames="A INPUT TEXTAREA SELECT BUTTON";var g=function(b){var c,d=a.jPlayer.focus;d&&(a.each(a.jPlayer.keyIgnoreElementNames.split(/\s+/g),function(a,d){return b.target.nodeName.toUpperCase()===d.toUpperCase()?(c=!0,!1):void 0}),c||a.each(d.options.keyBindings,function(c,e){return e&&a.isFunction(e.fn)&&("number"==typeof e.key&&b.which===e.key||"string"==typeof e.key&&b.key===e.key)?(b.preventDefault(),e.fn(d),!1):void 0}))};a.jPlayer.keys=function(b){var c="keydown.jPlayer";a(document.documentElement).unbind(c),b&&a(document.documentElement).bind(c,g)},a.jPlayer.keys(!0),a.jPlayer.prototype={count:0,version:{script:"2.9.2",needFlash:"2.9.0",flash:"unknown"},options:{swfPath:"js",solution:"html, flash",supplied:"mp3",auroraFormats:"wav",preload:"metadata",volume:.8,muted:!1,remainingDuration:!1,toggleDuration:!1,captureDuration:!0,playbackRate:1,defaultPlaybackRate:1,minPlaybackRate:.5,maxPlaybackRate:4,wmode:"opaque",backgroundColor:"#000000",cssSelectorAncestor:"#jp_container_1",cssSelector:{videoPlay:".jp-video-play",play:".jp-play",pause:".jp-pause",stop:".jp-stop",seekBar:".jp-seek-bar",playBar:".jp-play-bar",mute:".jp-mute",unmute:".jp-unmute",volumeBar:".jp-volume-bar",volumeBarValue:".jp-volume-bar-value",volumeMax:".jp-volume-max",playbackRateBar:".jp-playback-rate-bar",playbackRateBarValue:".jp-playback-rate-bar-value",currentTime:".jp-current-time",duration:".jp-duration",title:".jp-title",fullScreen:".jp-full-screen",restoreScreen:".jp-restore-screen",repeat:".jp-repeat",repeatOff:".jp-repeat-off",gui:".jp-gui",noSolution:".jp-no-solution"},stateClass:{playing:"jp-state-playing",seeking:"jp-state-seeking",muted:"jp-state-muted",looped:"jp-state-looped",fullScreen:"jp-state-full-screen",noVolume:"jp-state-no-volume"},useStateClassSkin:!1,autoBlur:!0,smoothPlayBar:!1,fullScreen:!1,fullWindow:!1,autohide:{restored:!1,full:!0,fadeIn:200,fadeOut:600,hold:1e3},loop:!1,repeat:function(b){b.jPlayer.options.loop?a(this).unbind(".jPlayerRepeat").bind(a.jPlayer.event.ended+".jPlayer.jPlayerRepeat",function(){a(this).jPlayer("play")}):a(this).unbind(".jPlayerRepeat")},nativeVideoControls:{},noFullWindow:{msie:/msie [0-6]\./,ipad:/ipad.*?os [0-4]\./,iphone:/iphone/,ipod:/ipod/,android_pad:/android [0-3]\.(?!.*?mobile)/,android_phone:/(?=.*android)(?!.*chrome)(?=.*mobile)/,blackberry:/blackberry/,windows_ce:/windows ce/,iemobile:/iemobile/,webos:/webos/},noVolume:{ipad:/ipad/,iphone:/iphone/,ipod:/ipod/,android_pad:/android(?!.*?mobile)/,android_phone:/android.*?mobile/,blackberry:/blackberry/,windows_ce:/windows ce/,iemobile:/iemobile/,webos:/webos/,playbook:/playbook/},timeFormat:{},keyEnabled:!1,audioFullScreen:!1,keyBindings:{play:{key:80,fn:function(a){a.status.paused?a.play():a.pause()}},fullScreen:{key:70,fn:function(a){(a.status.video||a.options.audioFullScreen)&&a._setOption("fullScreen",!a.options.fullScreen)}},muted:{key:77,fn:function(a){a._muted(!a.options.muted)}},volumeUp:{key:190,fn:function(a){a.volume(a.options.volume+.1)}},volumeDown:{key:188,fn:function(a){a.volume(a.options.volume-.1)}},loop:{key:76,fn:function(a){a._loop(!a.options.loop)}}},verticalVolume:!1,verticalPlaybackRate:!1,globalVolume:!1,idPrefix:"jp",noConflict:"jQuery",emulateHtml:!1,consoleAlerts:!0,errorAlerts:!1,warningAlerts:!1},optionsAudio:{size:{width:"0px",height:"0px",cssClass:""},sizeFull:{width:"0px",height:"0px",cssClass:""}},optionsVideo:{size:{width:"480px",height:"270px",cssClass:"jp-video-270p"},sizeFull:{width:"100%",height:"100%",cssClass:"jp-video-full"}},instances:{},status:{src:"",media:{},paused:!0,format:{},formatType:"",waitForPlay:!0,waitForLoad:!0,srcSet:!1,video:!1,seekPercent:0,currentPercentRelative:0,currentPercentAbsolute:0,currentTime:0,duration:0,remaining:0,videoWidth:0,videoHeight:0,readyState:0,networkState:0,playbackRate:1,ended:0},internal:{ready:!1},solution:{html:!0,aurora:!0,flash:!0},format:{mp3:{codec:"audio/mpeg",flashCanPlay:!0,media:"audio"},m4a:{codec:'audio/mp4; codecs="mp4a.40.2"',flashCanPlay:!0,media:"audio"},m3u8a:{codec:'application/vnd.apple.mpegurl; codecs="mp4a.40.2"',flashCanPlay:!1,media:"audio"},m3ua:{codec:"audio/mpegurl",flashCanPlay:!1,media:"audio"},oga:{codec:'audio/ogg; codecs="vorbis, opus"',flashCanPlay:!1,media:"audio"},flac:{codec:"audio/x-flac",flashCanPlay:!1,media:"audio"},wav:{codec:'audio/wav; codecs="1"',flashCanPlay:!1,media:"audio"},webma:{codec:'audio/webm; codecs="vorbis"',flashCanPlay:!1,media:"audio"},fla:{codec:"audio/x-flv",flashCanPlay:!0,media:"audio"},rtmpa:{codec:'audio/rtmp; codecs="rtmp"',flashCanPlay:!0,media:"audio"},m4v:{codec:'video/mp4; codecs="avc1.42E01E, mp4a.40.2"',flashCanPlay:!0,media:"video"},m3u8v:{codec:'application/vnd.apple.mpegurl; codecs="avc1.42E01E, mp4a.40.2"',flashCanPlay:!1,media:"video"},m3uv:{codec:"audio/mpegurl",flashCanPlay:!1,media:"video"},ogv:{codec:'video/ogg; codecs="theora, vorbis"',flashCanPlay:!1,media:"video"},webmv:{codec:'video/webm; codecs="vorbis, vp8"',flashCanPlay:!1,media:"video"},flv:{codec:"video/x-flv",flashCanPlay:!0,media:"video"},rtmpv:{codec:'video/rtmp; codecs="rtmp"',flashCanPlay:!0,media:"video"}},_init:function(){var c=this;if(this.element.empty(),this.status=a.extend({},this.status),this.internal=a.extend({},this.internal),this.options.timeFormat=a.extend({},a.jPlayer.timeFormat,this.options.timeFormat),this.internal.cmdsIgnored=a.jPlayer.platform.ipad||a.jPlayer.platform.iphone||a.jPlayer.platform.ipod,this.internal.domNode=this.element.get(0),this.options.keyEnabled&&!a.jPlayer.focus&&(a.jPlayer.focus=this),this.androidFix={setMedia:!1,play:!1,pause:!1,time:0/0},a.jPlayer.platform.android&&(this.options.preload="auto"!==this.options.preload?"metadata":"auto"),this.formats=[],this.solutions=[],this.require={},this.htmlElement={},this.html={},this.html.audio={},this.html.video={},this.aurora={},this.aurora.formats=[],this.aurora.properties=[],this.flash={},this.css={},this.css.cs={},this.css.jq={},this.ancestorJq=[],this.options.volume=this._limitValue(this.options.volume,0,1),a.each(this.options.supplied.toLowerCase().split(","),function(b,d){var e=d.replace(/^\s+|\s+$/g,"");if(c.format[e]){var f=!1;a.each(c.formats,function(a,b){return e===b?(f=!0,!1):void 0}),f||c.formats.push(e)}}),a.each(this.options.solution.toLowerCase().split(","),function(b,d){var e=d.replace(/^\s+|\s+$/g,"");if(c.solution[e]){var f=!1;a.each(c.solutions,function(a,b){return e===b?(f=!0,!1):void 0}),f||c.solutions.push(e)}}),a.each(this.options.auroraFormats.toLowerCase().split(","),function(b,d){var e=d.replace(/^\s+|\s+$/g,"");if(c.format[e]){var f=!1;a.each(c.aurora.formats,function(a,b){return e===b?(f=!0,!1):void 0}),f||c.aurora.formats.push(e)}}),this.internal.instance="jp_"+this.count,this.instances[this.internal.instance]=this.element,this.element.attr("id")||this.element.attr("id",this.options.idPrefix+"_jplayer_"+this.count),this.internal.self=a.extend({},{id:this.element.attr("id"),jq:this.element}),this.internal.audio=a.extend({},{id:this.options.idPrefix+"_audio_"+this.count,jq:b}),this.internal.video=a.extend({},{id:this.options.idPrefix+"_video_"+this.count,jq:b}),this.internal.flash=a.extend({},{id:this.options.idPrefix+"_flash_"+this.count,jq:b,swf:this.options.swfPath+(".swf"!==this.options.swfPath.toLowerCase().slice(-4)?(this.options.swfPath&&"/"!==this.options.swfPath.slice(-1)?"/":"")+"jquery.jplayer.swf":"")}),this.internal.poster=a.extend({},{id:this.options.idPrefix+"_poster_"+this.count,jq:b}),a.each(a.jPlayer.event,function(a,d){c.options[a]!==b&&(c.element.bind(d+".jPlayer",c.options[a]),c.options[a]=b)}),this.require.audio=!1,this.require.video=!1,a.each(this.formats,function(a,b){c.require[c.format[b].media]=!0}),this.options=this.require.video?a.extend(!0,{},this.optionsVideo,this.options):a.extend(!0,{},this.optionsAudio,this.options),this._setSize(),this.status.nativeVideoControls=this._uaBlocklist(this.options.nativeVideoControls),this.status.noFullWindow=this._uaBlocklist(this.options.noFullWindow),this.status.noVolume=this._uaBlocklist(this.options.noVolume),a.jPlayer.nativeFeatures.fullscreen.api.fullscreenEnabled&&this._fullscreenAddEventListeners(),this._restrictNativeVideoControls(),this.htmlElement.poster=document.createElement("img"),this.htmlElement.poster.id=this.internal.poster.id,this.htmlElement.poster.onload=function(){(!c.status.video||c.status.waitForPlay)&&c.internal.poster.jq.show()},this.element.append(this.htmlElement.poster),this.internal.poster.jq=a("#"+this.internal.poster.id),this.internal.poster.jq.css({width:this.status.width,height:this.status.height}),this.internal.poster.jq.hide(),this.internal.poster.jq.bind("click.jPlayer",function(){c._trigger(a.jPlayer.event.click)}),this.html.audio.available=!1,this.require.audio&&(this.htmlElement.audio=document.createElement("audio"),this.htmlElement.audio.id=this.internal.audio.id,this.html.audio.available=!!this.htmlElement.audio.canPlayType&&this._testCanPlayType(this.htmlElement.audio)),this.html.video.available=!1,this.require.video&&(this.htmlElement.video=document.createElement("video"),this.htmlElement.video.id=this.internal.video.id,this.html.video.available=!!this.htmlElement.video.canPlayType&&this._testCanPlayType(this.htmlElement.video)),this.flash.available=this._checkForFlash(10.1),this.html.canPlay={},this.aurora.canPlay={},this.flash.canPlay={},a.each(this.formats,function(b,d){c.html.canPlay[d]=c.html[c.format[d].media].available&&""!==c.htmlElement[c.format[d].media].canPlayType(c.format[d].codec),c.aurora.canPlay[d]=a.inArray(d,c.aurora.formats)>-1,c.flash.canPlay[d]=c.format[d].flashCanPlay&&c.flash.available}),this.html.desired=!1,this.aurora.desired=!1,this.flash.desired=!1,a.each(this.solutions,function(b,d){if(0===b)c[d].desired=!0;else{var e=!1,f=!1;a.each(c.formats,function(a,b){c[c.solutions[0]].canPlay[b]&&("video"===c.format[b].media?f=!0:e=!0)}),c[d].desired=c.require.audio&&!e||c.require.video&&!f}}),this.html.support={},this.aurora.support={},this.flash.support={},a.each(this.formats,function(a,b){c.html.support[b]=c.html.canPlay[b]&&c.html.desired,c.aurora.support[b]=c.aurora.canPlay[b]&&c.aurora.desired,c.flash.support[b]=c.flash.canPlay[b]&&c.flash.desired}),this.html.used=!1,this.aurora.used=!1,this.flash.used=!1,a.each(this.solutions,function(b,d){a.each(c.formats,function(a,b){return c[d].support[b]?(c[d].used=!0,!1):void 0})}),this._resetActive(),this._resetGate(),this._cssSelectorAncestor(this.options.cssSelectorAncestor),this.html.used||this.aurora.used||this.flash.used?this.css.jq.noSolution.length&&this.css.jq.noSolution.hide():(this._error({type:a.jPlayer.error.NO_SOLUTION,context:"{solution:'"+this.options.solution+"', supplied:'"+this.options.supplied+"'}",message:a.jPlayer.errorMsg.NO_SOLUTION,hint:a.jPlayer.errorHint.NO_SOLUTION}),this.css.jq.noSolution.length&&this.css.jq.noSolution.show()),this.flash.used){var d,e="jQuery="+encodeURI(this.options.noConflict)+"&id="+encodeURI(this.internal.self.id)+"&vol="+this.options.volume+"&muted="+this.options.muted;if(a.jPlayer.browser.msie&&(Number(a.jPlayer.browser.version)<9||a.jPlayer.browser.documentMode<9)){var f='<object id="'+this.internal.flash.id+'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="0" height="0" tabindex="-1"></object>',g=['<param name="movie" value="'+this.internal.flash.swf+'" />','<param name="FlashVars" value="'+e+'" />','<param name="allowScriptAccess" value="always" />','<param name="bgcolor" value="'+this.options.backgroundColor+'" />','<param name="wmode" value="'+this.options.wmode+'" />'];d=document.createElement(f);for(var h=0;h<g.length;h++)d.appendChild(document.createElement(g[h]))}else{var i=function(a,b,c){var d=document.createElement("param");d.setAttribute("name",b),d.setAttribute("value",c),a.appendChild(d)};d=document.createElement("object"),d.setAttribute("id",this.internal.flash.id),d.setAttribute("name",this.internal.flash.id),d.setAttribute("data",this.internal.flash.swf),d.setAttribute("type","application/x-shockwave-flash"),d.setAttribute("width","1"),d.setAttribute("height","1"),d.setAttribute("tabindex","-1"),i(d,"flashvars",e),i(d,"allowscriptaccess","always"),i(d,"bgcolor",this.options.backgroundColor),i(d,"wmode",this.options.wmode)}this.element.append(d),this.internal.flash.jq=a(d)}this.status.playbackRateEnabled=this.html.used&&!this.flash.used?this._testPlaybackRate("audio"):!1,this._updatePlaybackRate(),this.html.used&&(this.html.audio.available&&(this._addHtmlEventListeners(this.htmlElement.audio,this.html.audio),this.element.append(this.htmlElement.audio),this.internal.audio.jq=a("#"+this.internal.audio.id)),this.html.video.available&&(this._addHtmlEventListeners(this.htmlElement.video,this.html.video),this.element.append(this.htmlElement.video),this.internal.video.jq=a("#"+this.internal.video.id),this.internal.video.jq.css(this.status.nativeVideoControls?{width:this.status.width,height:this.status.height}:{width:"0px",height:"0px"}),this.internal.video.jq.bind("click.jPlayer",function(){c._trigger(a.jPlayer.event.click)}))),this.aurora.used,this.options.emulateHtml&&this._emulateHtmlBridge(),!this.html.used&&!this.aurora.used||this.flash.used||setTimeout(function(){c.internal.ready=!0,c.version.flash="n/a",c._trigger(a.jPlayer.event.repeat),c._trigger(a.jPlayer.event.ready)},100),this._updateNativeVideoControls(),this.css.jq.videoPlay.length&&this.css.jq.videoPlay.hide(),a.jPlayer.prototype.count++},destroy:function(){this.clearMedia(),this._removeUiClass(),this.css.jq.currentTime.length&&this.css.jq.currentTime.text(""),this.css.jq.duration.length&&this.css.jq.duration.text(""),a.each(this.css.jq,function(a,b){b.length&&b.unbind(".jPlayer")}),this.internal.poster.jq.unbind(".jPlayer"),this.internal.video.jq&&this.internal.video.jq.unbind(".jPlayer"),this._fullscreenRemoveEventListeners(),this===a.jPlayer.focus&&(a.jPlayer.focus=null),this.options.emulateHtml&&this._destroyHtmlBridge(),this.element.removeData("jPlayer"),this.element.unbind(".jPlayer"),this.element.empty(),delete this.instances[this.internal.instance]},destroyRemoved:function(){var b=this;a.each(this.instances,function(a,c){b.element!==c&&(c.data("jPlayer")||(c.jPlayer("destroy"),delete b.instances[a]))})},enable:function(){},disable:function(){},_testCanPlayType:function(a){try{return a.canPlayType(this.format.mp3.codec),!0}catch(b){return!1}},_testPlaybackRate:function(a){var b,c=.5;a="string"==typeof a?a:"audio",b=document.createElement(a);try{return"playbackRate"in b?(b.playbackRate=c,b.playbackRate===c):!1}catch(d){return!1}},_uaBlocklist:function(b){var c=navigator.userAgent.toLowerCase(),d=!1;return a.each(b,function(a,b){return b&&b.test(c)?(d=!0,!1):void 0}),d},_restrictNativeVideoControls:function(){this.require.audio&&this.status.nativeVideoControls&&(this.status.nativeVideoControls=!1,this.status.noFullWindow=!0)},_updateNativeVideoControls:function(){this.html.video.available&&this.html.used&&(this.htmlElement.video.controls=this.status.nativeVideoControls,this._updateAutohide(),this.status.nativeVideoControls&&this.require.video?(this.internal.poster.jq.hide(),this.internal.video.jq.css({width:this.status.width,height:this.status.height})):this.status.waitForPlay&&this.status.video&&(this.internal.poster.jq.show(),this.internal.video.jq.css({width:"0px",height:"0px"})))},_addHtmlEventListeners:function(b,c){var d=this;b.preload=this.options.preload,b.muted=this.options.muted,b.volume=this.options.volume,this.status.playbackRateEnabled&&(b.defaultPlaybackRate=this.options.defaultPlaybackRate,b.playbackRate=this.options.playbackRate),b.addEventListener("progress",function(){c.gate&&(d.internal.cmdsIgnored&&this.readyState>0&&(d.internal.cmdsIgnored=!1),d._getHtmlStatus(b),d._updateInterface(),d._trigger(a.jPlayer.event.progress))},!1),b.addEventListener("loadeddata",function(){c.gate&&(d.androidFix.setMedia=!1,d.androidFix.play&&(d.androidFix.play=!1,d.play(d.androidFix.time)),d.androidFix.pause&&(d.androidFix.pause=!1,d.pause(d.androidFix.time)),d._trigger(a.jPlayer.event.loadeddata))},!1),b.addEventListener("timeupdate",function(){c.gate&&(d._getHtmlStatus(b),d._updateInterface(),d._trigger(a.jPlayer.event.timeupdate))},!1),b.addEventListener("durationchange",function(){c.gate&&(d._getHtmlStatus(b),d._updateInterface(),d._trigger(a.jPlayer.event.durationchange))},!1),b.addEventListener("play",function(){c.gate&&(d._updateButtons(!0),d._html_checkWaitForPlay(),d._trigger(a.jPlayer.event.play))},!1),b.addEventListener("playing",function(){c.gate&&(d._updateButtons(!0),d._seeked(),d._trigger(a.jPlayer.event.playing))},!1),b.addEventListener("pause",function(){c.gate&&(d._updateButtons(!1),d._trigger(a.jPlayer.event.pause))},!1),b.addEventListener("waiting",function(){c.gate&&(d._seeking(),d._trigger(a.jPlayer.event.waiting))},!1),b.addEventListener("seeking",function(){c.gate&&(d._seeking(),d._trigger(a.jPlayer.event.seeking))},!1),b.addEventListener("seeked",function(){c.gate&&(d._seeked(),d._trigger(a.jPlayer.event.seeked))},!1),b.addEventListener("volumechange",function(){c.gate&&(d.options.volume=b.volume,d.options.muted=b.muted,d._updateMute(),d._updateVolume(),d._trigger(a.jPlayer.event.volumechange))},!1),b.addEventListener("ratechange",function(){c.gate&&(d.options.defaultPlaybackRate=b.defaultPlaybackRate,d.options.playbackRate=b.playbackRate,d._updatePlaybackRate(),d._trigger(a.jPlayer.event.ratechange))},!1),b.addEventListener("suspend",function(){c.gate&&(d._seeked(),d._trigger(a.jPlayer.event.suspend))},!1),b.addEventListener("ended",function(){c.gate&&(a.jPlayer.browser.webkit||(d.htmlElement.media.currentTime=0),d.htmlElement.media.pause(),d._updateButtons(!1),d._getHtmlStatus(b,!0),d._updateInterface(),d._trigger(a.jPlayer.event.ended))},!1),b.addEventListener("error",function(){c.gate&&(d._updateButtons(!1),d._seeked(),d.status.srcSet&&(clearTimeout(d.internal.htmlDlyCmdId),d.status.waitForLoad=!0,d.status.waitForPlay=!0,d.status.video&&!d.status.nativeVideoControls&&d.internal.video.jq.css({width:"0px",height:"0px"}),d._validString(d.status.media.poster)&&!d.status.nativeVideoControls&&d.internal.poster.jq.show(),d.css.jq.videoPlay.length&&d.css.jq.videoPlay.show(),d._error({type:a.jPlayer.error.URL,context:d.status.src,message:a.jPlayer.errorMsg.URL,hint:a.jPlayer.errorHint.URL})))},!1),a.each(a.jPlayer.htmlEvent,function(e,f){b.addEventListener(this,function(){c.gate&&d._trigger(a.jPlayer.event[f])},!1)})},_addAuroraEventListeners:function(b,c){var d=this;b.volume=100*this.options.volume,b.on("progress",function(){c.gate&&(d.internal.cmdsIgnored&&this.readyState>0&&(d.internal.cmdsIgnored=!1),d._getAuroraStatus(b),d._updateInterface(),d._trigger(a.jPlayer.event.progress),b.duration>0&&d._trigger(a.jPlayer.event.timeupdate))},!1),b.on("ready",function(){c.gate&&d._trigger(a.jPlayer.event.loadeddata)},!1),b.on("duration",function(){c.gate&&(d._getAuroraStatus(b),d._updateInterface(),d._trigger(a.jPlayer.event.durationchange))},!1),b.on("end",function(){c.gate&&(d._updateButtons(!1),d._getAuroraStatus(b,!0),d._updateInterface(),d._trigger(a.jPlayer.event.ended))},!1),b.on("error",function(){c.gate&&(d._updateButtons(!1),d._seeked(),d.status.srcSet&&(d.status.waitForLoad=!0,d.status.waitForPlay=!0,d.status.video&&!d.status.nativeVideoControls&&d.internal.video.jq.css({width:"0px",height:"0px"}),d._validString(d.status.media.poster)&&!d.status.nativeVideoControls&&d.internal.poster.jq.show(),d.css.jq.videoPlay.length&&d.css.jq.videoPlay.show(),d._error({type:a.jPlayer.error.URL,context:d.status.src,message:a.jPlayer.errorMsg.URL,hint:a.jPlayer.errorHint.URL})))},!1)},_getHtmlStatus:function(a,b){var c=0,d=0,e=0,f=0;isFinite(a.duration)&&(this.status.duration=a.duration),c=a.currentTime,d=this.status.duration>0?100*c/this.status.duration:0,"object"==typeof a.seekable&&a.seekable.length>0?(e=this.status.duration>0?100*a.seekable.end(a.seekable.length-1)/this.status.duration:100,f=this.status.duration>0?100*a.currentTime/a.seekable.end(a.seekable.length-1):0):(e=100,f=d),b&&(c=0,f=0,d=0),this.status.seekPercent=e,this.status.currentPercentRelative=f,this.status.currentPercentAbsolute=d,this.status.currentTime=c,this.status.remaining=this.status.duration-this.status.currentTime,this.status.videoWidth=a.videoWidth,this.status.videoHeight=a.videoHeight,this.status.readyState=a.readyState,this.status.networkState=a.networkState,this.status.playbackRate=a.playbackRate,this.status.ended=a.ended},_getAuroraStatus:function(a,b){var c=0,d=0,e=0,f=0;this.status.duration=a.duration/1e3,c=a.currentTime/1e3,d=this.status.duration>0?100*c/this.status.duration:0,a.buffered>0?(e=this.status.duration>0?a.buffered*this.status.duration/this.status.duration:100,f=this.status.duration>0?c/(a.buffered*this.status.duration):0):(e=100,f=d),b&&(c=0,f=0,d=0),this.status.seekPercent=e,this.status.currentPercentRelative=f,this.status.currentPercentAbsolute=d,this.status.currentTime=c,this.status.remaining=this.status.duration-this.status.currentTime,this.status.readyState=4,this.status.networkState=0,this.status.playbackRate=1,this.status.ended=!1},_resetStatus:function(){this.status=a.extend({},this.status,a.jPlayer.prototype.status)},_trigger:function(b,c,d){var e=a.Event(b);e.jPlayer={},e.jPlayer.version=a.extend({},this.version),e.jPlayer.options=a.extend(!0,{},this.options),e.jPlayer.status=a.extend(!0,{},this.status),e.jPlayer.html=a.extend(!0,{},this.html),e.jPlayer.aurora=a.extend(!0,{},this.aurora),e.jPlayer.flash=a.extend(!0,{},this.flash),c&&(e.jPlayer.error=a.extend({},c)),d&&(e.jPlayer.warning=a.extend({},d)),this.element.trigger(e)},jPlayerFlashEvent:function(b,c){if(b===a.jPlayer.event.ready)if(this.internal.ready){if(this.flash.gate){if(this.status.srcSet){var d=this.status.currentTime,e=this.status.paused;this.setMedia(this.status.media),this.volumeWorker(this.options.volume),d>0&&(e?this.pause(d):this.play(d))}this._trigger(a.jPlayer.event.flashreset)}}else this.internal.ready=!0,this.internal.flash.jq.css({width:"0px",height:"0px"}),this.version.flash=c.version,this.version.needFlash!==this.version.flash&&this._error({type:a.jPlayer.error.VERSION,context:this.version.flash,message:a.jPlayer.errorMsg.VERSION+this.version.flash,hint:a.jPlayer.errorHint.VERSION}),this._trigger(a.jPlayer.event.repeat),this._trigger(b);if(this.flash.gate)switch(b){case a.jPlayer.event.progress:this._getFlashStatus(c),this._updateInterface(),this._trigger(b);break;case a.jPlayer.event.timeupdate:this._getFlashStatus(c),this._updateInterface(),this._trigger(b);break;case a.jPlayer.event.play:this._seeked(),this._updateButtons(!0),this._trigger(b);break;case a.jPlayer.event.pause:this._updateButtons(!1),this._trigger(b);break;case a.jPlayer.event.ended:this._updateButtons(!1),this._trigger(b);break;case a.jPlayer.event.click:this._trigger(b);break;case a.jPlayer.event.error:this.status.waitForLoad=!0,this.status.waitForPlay=!0,this.status.video&&this.internal.flash.jq.css({width:"0px",height:"0px"}),this._validString(this.status.media.poster)&&this.internal.poster.jq.show(),this.css.jq.videoPlay.length&&this.status.video&&this.css.jq.videoPlay.show(),this.status.video?this._flash_setVideo(this.status.media):this._flash_setAudio(this.status.media),this._updateButtons(!1),this._error({type:a.jPlayer.error.URL,context:c.src,message:a.jPlayer.errorMsg.URL,hint:a.jPlayer.errorHint.URL});break;case a.jPlayer.event.seeking:this._seeking(),this._trigger(b);break;case a.jPlayer.event.seeked:this._seeked(),this._trigger(b);break;case a.jPlayer.event.ready:break;default:this._trigger(b)}return!1},_getFlashStatus:function(a){this.status.seekPercent=a.seekPercent,this.status.currentPercentRelative=a.currentPercentRelative,this.status.currentPercentAbsolute=a.currentPercentAbsolute,this.status.currentTime=a.currentTime,this.status.duration=a.duration,this.status.remaining=a.duration-a.currentTime,this.status.videoWidth=a.videoWidth,this.status.videoHeight=a.videoHeight,this.status.readyState=4,this.status.networkState=0,this.status.playbackRate=1,this.status.ended=!1},_updateButtons:function(a){a===b?a=!this.status.paused:this.status.paused=!a,a?this.addStateClass("playing"):this.removeStateClass("playing"),!this.status.noFullWindow&&this.options.fullWindow?this.addStateClass("fullScreen"):this.removeStateClass("fullScreen"),this.options.loop?this.addStateClass("looped"):this.removeStateClass("looped"),this.css.jq.play.length&&this.css.jq.pause.length&&(a?(this.css.jq.play.hide(),this.css.jq.pause.show()):(this.css.jq.play.show(),this.css.jq.pause.hide())),this.css.jq.restoreScreen.length&&this.css.jq.fullScreen.length&&(this.status.noFullWindow?(this.css.jq.fullScreen.hide(),this.css.jq.restoreScreen.hide()):this.options.fullWindow?(this.css.jq.fullScreen.hide(),this.css.jq.restoreScreen.show()):(this.css.jq.fullScreen.show(),this.css.jq.restoreScreen.hide())),this.css.jq.repeat.length&&this.css.jq.repeatOff.length&&(this.options.loop?(this.css.jq.repeat.hide(),this.css.jq.repeatOff.show()):(this.css.jq.repeat.show(),this.css.jq.repeatOff.hide()))},_updateInterface:function(){this.css.jq.seekBar.length&&this.css.jq.seekBar.width(this.status.seekPercent+"%"),this.css.jq.playBar.length&&(this.options.smoothPlayBar?this.css.jq.playBar.stop().animate({width:this.status.currentPercentAbsolute+"%"},250,"linear"):this.css.jq.playBar.width(this.status.currentPercentRelative+"%"));var a="";this.css.jq.currentTime.length&&(a=this._convertTime(this.status.currentTime),a!==this.css.jq.currentTime.text()&&this.css.jq.currentTime.text(this._convertTime(this.status.currentTime)));var b="",c=this.status.duration,d=this.status.remaining;this.css.jq.duration.length&&("string"==typeof this.status.media.duration?b=this.status.media.duration:("number"==typeof this.status.media.duration&&(c=this.status.media.duration,d=c-this.status.currentTime),b=this.options.remainingDuration?(d>0?"-":"")+this._convertTime(d):this._convertTime(c)),b!==this.css.jq.duration.text()&&this.css.jq.duration.text(b))},_convertTime:c.prototype.time,_seeking:function(){this.css.jq.seekBar.length&&this.css.jq.seekBar.addClass("jp-seeking-bg"),this.addStateClass("seeking")},_seeked:function(){this.css.jq.seekBar.length&&this.css.jq.seekBar.removeClass("jp-seeking-bg"),this.removeStateClass("seeking")},_resetGate:function(){this.html.audio.gate=!1,this.html.video.gate=!1,this.aurora.gate=!1,this.flash.gate=!1},_resetActive:function(){this.html.active=!1,this.aurora.active=!1,this.flash.active=!1},_escapeHtml:function(a){return a.split("&").join("&amp;").split("<").join("&lt;").split(">").join("&gt;").split('"').join("&quot;")},_qualifyURL:function(a){var b=document.createElement("div");
return b.innerHTML='<a href="'+this._escapeHtml(a)+'">x</a>',b.firstChild.href},_absoluteMediaUrls:function(b){var c=this;return a.each(b,function(a,d){d&&c.format[a]&&"data:"!==d.substr(0,5)&&(b[a]=c._qualifyURL(d))}),b},addStateClass:function(a){this.ancestorJq.length&&this.ancestorJq.addClass(this.options.stateClass[a])},removeStateClass:function(a){this.ancestorJq.length&&this.ancestorJq.removeClass(this.options.stateClass[a])},setMedia:function(b){var c=this,d=!1,e=this.status.media.poster!==b.poster;this._resetMedia(),this._resetGate(),this._resetActive(),this.androidFix.setMedia=!1,this.androidFix.play=!1,this.androidFix.pause=!1,b=this._absoluteMediaUrls(b),a.each(this.formats,function(e,f){var g="video"===c.format[f].media;return a.each(c.solutions,function(e,h){if(c[h].support[f]&&c._validString(b[f])){var i="html"===h,j="aurora"===h;return g?(i?(c.html.video.gate=!0,c._html_setVideo(b),c.html.active=!0):(c.flash.gate=!0,c._flash_setVideo(b),c.flash.active=!0),c.css.jq.videoPlay.length&&c.css.jq.videoPlay.show(),c.status.video=!0):(i?(c.html.audio.gate=!0,c._html_setAudio(b),c.html.active=!0,a.jPlayer.platform.android&&(c.androidFix.setMedia=!0)):j?(c.aurora.gate=!0,c._aurora_setAudio(b),c.aurora.active=!0):(c.flash.gate=!0,c._flash_setAudio(b),c.flash.active=!0),c.css.jq.videoPlay.length&&c.css.jq.videoPlay.hide(),c.status.video=!1),d=!0,!1}}),d?!1:void 0}),d?(this.status.nativeVideoControls&&this.html.video.gate||this._validString(b.poster)&&(e?this.htmlElement.poster.src=b.poster:this.internal.poster.jq.show()),"string"==typeof b.title&&(this.css.jq.title.length&&this.css.jq.title.html(b.title),this.htmlElement.audio&&this.htmlElement.audio.setAttribute("title",b.title),this.htmlElement.video&&this.htmlElement.video.setAttribute("title",b.title)),this.status.srcSet=!0,this.status.media=a.extend({},b),this._updateButtons(!1),this._updateInterface(),this._trigger(a.jPlayer.event.setmedia)):this._error({type:a.jPlayer.error.NO_SUPPORT,context:"{supplied:'"+this.options.supplied+"'}",message:a.jPlayer.errorMsg.NO_SUPPORT,hint:a.jPlayer.errorHint.NO_SUPPORT})},_resetMedia:function(){this._resetStatus(),this._updateButtons(!1),this._updateInterface(),this._seeked(),this.internal.poster.jq.hide(),clearTimeout(this.internal.htmlDlyCmdId),this.html.active?this._html_resetMedia():this.aurora.active?this._aurora_resetMedia():this.flash.active&&this._flash_resetMedia()},clearMedia:function(){this._resetMedia(),this.html.active?this._html_clearMedia():this.aurora.active?this._aurora_clearMedia():this.flash.active&&this._flash_clearMedia(),this._resetGate(),this._resetActive()},load:function(){this.status.srcSet?this.html.active?this._html_load():this.aurora.active?this._aurora_load():this.flash.active&&this._flash_load():this._urlNotSetError("load")},focus:function(){this.options.keyEnabled&&(a.jPlayer.focus=this)},play:function(a){var b="object"==typeof a;b&&this.options.useStateClassSkin&&!this.status.paused?this.pause(a):(a="number"==typeof a?a:0/0,this.status.srcSet?(this.focus(),this.html.active?this._html_play(a):this.aurora.active?this._aurora_play(a):this.flash.active&&this._flash_play(a)):this._urlNotSetError("play"))},videoPlay:function(){this.play()},pause:function(a){a="number"==typeof a?a:0/0,this.status.srcSet?this.html.active?this._html_pause(a):this.aurora.active?this._aurora_pause(a):this.flash.active&&this._flash_pause(a):this._urlNotSetError("pause")},tellOthers:function(b,c){var d=this,e="function"==typeof c,f=Array.prototype.slice.call(arguments);"string"==typeof b&&(e&&f.splice(1,1),a.jPlayer.prototype.destroyRemoved(),a.each(this.instances,function(){d.element!==this&&(!e||c.call(this.data("jPlayer"),d))&&this.jPlayer.apply(this,f)}))},pauseOthers:function(a){this.tellOthers("pause",function(){return this.status.srcSet},a)},stop:function(){this.status.srcSet?this.html.active?this._html_pause(0):this.aurora.active?this._aurora_pause(0):this.flash.active&&this._flash_pause(0):this._urlNotSetError("stop")},playHead:function(a){a=this._limitValue(a,0,100),this.status.srcSet?this.html.active?this._html_playHead(a):this.aurora.active?this._aurora_playHead(a):this.flash.active&&this._flash_playHead(a):this._urlNotSetError("playHead")},_muted:function(a){this.mutedWorker(a),this.options.globalVolume&&this.tellOthers("mutedWorker",function(){return this.options.globalVolume},a)},mutedWorker:function(b){this.options.muted=b,this.html.used&&this._html_setProperty("muted",b),this.aurora.used&&this._aurora_mute(b),this.flash.used&&this._flash_mute(b),this.html.video.gate||this.html.audio.gate||(this._updateMute(b),this._updateVolume(this.options.volume),this._trigger(a.jPlayer.event.volumechange))},mute:function(a){var c="object"==typeof a;c&&this.options.useStateClassSkin&&this.options.muted?this._muted(!1):(a=a===b?!0:!!a,this._muted(a))},unmute:function(a){a=a===b?!0:!!a,this._muted(!a)},_updateMute:function(a){a===b&&(a=this.options.muted),a?this.addStateClass("muted"):this.removeStateClass("muted"),this.css.jq.mute.length&&this.css.jq.unmute.length&&(this.status.noVolume?(this.css.jq.mute.hide(),this.css.jq.unmute.hide()):a?(this.css.jq.mute.hide(),this.css.jq.unmute.show()):(this.css.jq.mute.show(),this.css.jq.unmute.hide()))},volume:function(a){this.volumeWorker(a),this.options.globalVolume&&this.tellOthers("volumeWorker",function(){return this.options.globalVolume},a)},volumeWorker:function(b){b=this._limitValue(b,0,1),this.options.volume=b,this.html.used&&this._html_setProperty("volume",b),this.aurora.used&&this._aurora_volume(b),this.flash.used&&this._flash_volume(b),this.html.video.gate||this.html.audio.gate||(this._updateVolume(b),this._trigger(a.jPlayer.event.volumechange))},volumeBar:function(b){if(this.css.jq.volumeBar.length){var c=a(b.currentTarget),d=c.offset(),e=b.pageX-d.left,f=c.width(),g=c.height()-b.pageY+d.top,h=c.height();this.volume(this.options.verticalVolume?g/h:e/f)}this.options.muted&&this._muted(!1)},_updateVolume:function(a){a===b&&(a=this.options.volume),a=this.options.muted?0:a,this.status.noVolume?(this.addStateClass("noVolume"),this.css.jq.volumeBar.length&&this.css.jq.volumeBar.hide(),this.css.jq.volumeBarValue.length&&this.css.jq.volumeBarValue.hide(),this.css.jq.volumeMax.length&&this.css.jq.volumeMax.hide()):(this.removeStateClass("noVolume"),this.css.jq.volumeBar.length&&this.css.jq.volumeBar.show(),this.css.jq.volumeBarValue.length&&(this.css.jq.volumeBarValue.show(),this.css.jq.volumeBarValue[this.options.verticalVolume?"height":"width"](100*a+"%")),this.css.jq.volumeMax.length&&this.css.jq.volumeMax.show())},volumeMax:function(){this.volume(1),this.options.muted&&this._muted(!1)},_cssSelectorAncestor:function(b){var c=this;this.options.cssSelectorAncestor=b,this._removeUiClass(),this.ancestorJq=b?a(b):[],b&&1!==this.ancestorJq.length&&this._warning({type:a.jPlayer.warning.CSS_SELECTOR_COUNT,context:b,message:a.jPlayer.warningMsg.CSS_SELECTOR_COUNT+this.ancestorJq.length+" found for cssSelectorAncestor.",hint:a.jPlayer.warningHint.CSS_SELECTOR_COUNT}),this._addUiClass(),a.each(this.options.cssSelector,function(a,b){c._cssSelector(a,b)}),this._updateInterface(),this._updateButtons(),this._updateAutohide(),this._updateVolume(),this._updateMute()},_cssSelector:function(b,c){var d=this;if("string"==typeof c)if(a.jPlayer.prototype.options.cssSelector[b]){if(this.css.jq[b]&&this.css.jq[b].length&&this.css.jq[b].unbind(".jPlayer"),this.options.cssSelector[b]=c,this.css.cs[b]=this.options.cssSelectorAncestor+" "+c,this.css.jq[b]=c?a(this.css.cs[b]):[],this.css.jq[b].length&&this[b]){var e=function(c){c.preventDefault(),d[b](c),d.options.autoBlur?a(this).blur():a(this).focus()};this.css.jq[b].bind("click.jPlayer",e)}c&&1!==this.css.jq[b].length&&this._warning({type:a.jPlayer.warning.CSS_SELECTOR_COUNT,context:this.css.cs[b],message:a.jPlayer.warningMsg.CSS_SELECTOR_COUNT+this.css.jq[b].length+" found for "+b+" method.",hint:a.jPlayer.warningHint.CSS_SELECTOR_COUNT})}else this._warning({type:a.jPlayer.warning.CSS_SELECTOR_METHOD,context:b,message:a.jPlayer.warningMsg.CSS_SELECTOR_METHOD,hint:a.jPlayer.warningHint.CSS_SELECTOR_METHOD});else this._warning({type:a.jPlayer.warning.CSS_SELECTOR_STRING,context:c,message:a.jPlayer.warningMsg.CSS_SELECTOR_STRING,hint:a.jPlayer.warningHint.CSS_SELECTOR_STRING})},duration:function(a){this.options.toggleDuration&&(this.options.captureDuration&&a.stopPropagation(),this._setOption("remainingDuration",!this.options.remainingDuration))},seekBar:function(b){if(this.css.jq.seekBar.length){var c=a(b.currentTarget),d=c.offset(),e=b.pageX-d.left,f=c.width(),g=100*e/f;this.playHead(g)}},playbackRate:function(a){this._setOption("playbackRate",a)},playbackRateBar:function(b){if(this.css.jq.playbackRateBar.length){var c,d,e=a(b.currentTarget),f=e.offset(),g=b.pageX-f.left,h=e.width(),i=e.height()-b.pageY+f.top,j=e.height();c=this.options.verticalPlaybackRate?i/j:g/h,d=c*(this.options.maxPlaybackRate-this.options.minPlaybackRate)+this.options.minPlaybackRate,this.playbackRate(d)}},_updatePlaybackRate:function(){var a=this.options.playbackRate,b=(a-this.options.minPlaybackRate)/(this.options.maxPlaybackRate-this.options.minPlaybackRate);this.status.playbackRateEnabled?(this.css.jq.playbackRateBar.length&&this.css.jq.playbackRateBar.show(),this.css.jq.playbackRateBarValue.length&&(this.css.jq.playbackRateBarValue.show(),this.css.jq.playbackRateBarValue[this.options.verticalPlaybackRate?"height":"width"](100*b+"%"))):(this.css.jq.playbackRateBar.length&&this.css.jq.playbackRateBar.hide(),this.css.jq.playbackRateBarValue.length&&this.css.jq.playbackRateBarValue.hide())},repeat:function(a){var b="object"==typeof a;this._loop(b&&this.options.useStateClassSkin&&this.options.loop?!1:!0)},repeatOff:function(){this._loop(!1)},_loop:function(b){this.options.loop!==b&&(this.options.loop=b,this._updateButtons(),this._trigger(a.jPlayer.event.repeat))},option:function(c,d){var e=c;if(0===arguments.length)return a.extend(!0,{},this.options);if("string"==typeof c){var f=c.split(".");if(d===b){for(var g=a.extend(!0,{},this.options),h=0;h<f.length;h++){if(g[f[h]]===b)return this._warning({type:a.jPlayer.warning.OPTION_KEY,context:c,message:a.jPlayer.warningMsg.OPTION_KEY,hint:a.jPlayer.warningHint.OPTION_KEY}),b;g=g[f[h]]}return g}e={};for(var i=e,j=0;j<f.length;j++)j<f.length-1?(i[f[j]]={},i=i[f[j]]):i[f[j]]=d}return this._setOptions(e),this},_setOptions:function(b){var c=this;return a.each(b,function(a,b){c._setOption(a,b)}),this},_setOption:function(b,c){var d=this;switch(b){case"volume":this.volume(c);break;case"muted":this._muted(c);break;case"globalVolume":this.options[b]=c;break;case"cssSelectorAncestor":this._cssSelectorAncestor(c);break;case"cssSelector":a.each(c,function(a,b){d._cssSelector(a,b)});break;case"playbackRate":this.options[b]=c=this._limitValue(c,this.options.minPlaybackRate,this.options.maxPlaybackRate),this.html.used&&this._html_setProperty("playbackRate",c),this._updatePlaybackRate();break;case"defaultPlaybackRate":this.options[b]=c=this._limitValue(c,this.options.minPlaybackRate,this.options.maxPlaybackRate),this.html.used&&this._html_setProperty("defaultPlaybackRate",c),this._updatePlaybackRate();break;case"minPlaybackRate":this.options[b]=c=this._limitValue(c,.1,this.options.maxPlaybackRate-.1),this._updatePlaybackRate();break;case"maxPlaybackRate":this.options[b]=c=this._limitValue(c,this.options.minPlaybackRate+.1,16),this._updatePlaybackRate();break;case"fullScreen":if(this.options[b]!==c){var e=a.jPlayer.nativeFeatures.fullscreen.used.webkitVideo;(!e||e&&!this.status.waitForPlay)&&(e||(this.options[b]=c),c?this._requestFullscreen():this._exitFullscreen(),e||this._setOption("fullWindow",c))}break;case"fullWindow":this.options[b]!==c&&(this._removeUiClass(),this.options[b]=c,this._refreshSize());break;case"size":this.options.fullWindow||this.options[b].cssClass===c.cssClass||this._removeUiClass(),this.options[b]=a.extend({},this.options[b],c),this._refreshSize();break;case"sizeFull":this.options.fullWindow&&this.options[b].cssClass!==c.cssClass&&this._removeUiClass(),this.options[b]=a.extend({},this.options[b],c),this._refreshSize();break;case"autohide":this.options[b]=a.extend({},this.options[b],c),this._updateAutohide();break;case"loop":this._loop(c);break;case"remainingDuration":this.options[b]=c,this._updateInterface();break;case"toggleDuration":this.options[b]=c;break;case"nativeVideoControls":this.options[b]=a.extend({},this.options[b],c),this.status.nativeVideoControls=this._uaBlocklist(this.options.nativeVideoControls),this._restrictNativeVideoControls(),this._updateNativeVideoControls();break;case"noFullWindow":this.options[b]=a.extend({},this.options[b],c),this.status.nativeVideoControls=this._uaBlocklist(this.options.nativeVideoControls),this.status.noFullWindow=this._uaBlocklist(this.options.noFullWindow),this._restrictNativeVideoControls(),this._updateButtons();break;case"noVolume":this.options[b]=a.extend({},this.options[b],c),this.status.noVolume=this._uaBlocklist(this.options.noVolume),this._updateVolume(),this._updateMute();break;case"emulateHtml":this.options[b]!==c&&(this.options[b]=c,c?this._emulateHtmlBridge():this._destroyHtmlBridge());break;case"timeFormat":this.options[b]=a.extend({},this.options[b],c);break;case"keyEnabled":this.options[b]=c,c||this!==a.jPlayer.focus||(a.jPlayer.focus=null);break;case"keyBindings":this.options[b]=a.extend(!0,{},this.options[b],c);break;case"audioFullScreen":this.options[b]=c;break;case"autoBlur":this.options[b]=c}return this},_refreshSize:function(){this._setSize(),this._addUiClass(),this._updateSize(),this._updateButtons(),this._updateAutohide(),this._trigger(a.jPlayer.event.resize)},_setSize:function(){this.options.fullWindow?(this.status.width=this.options.sizeFull.width,this.status.height=this.options.sizeFull.height,this.status.cssClass=this.options.sizeFull.cssClass):(this.status.width=this.options.size.width,this.status.height=this.options.size.height,this.status.cssClass=this.options.size.cssClass),this.element.css({width:this.status.width,height:this.status.height})},_addUiClass:function(){this.ancestorJq.length&&this.ancestorJq.addClass(this.status.cssClass)},_removeUiClass:function(){this.ancestorJq.length&&this.ancestorJq.removeClass(this.status.cssClass)},_updateSize:function(){this.internal.poster.jq.css({width:this.status.width,height:this.status.height}),!this.status.waitForPlay&&this.html.active&&this.status.video||this.html.video.available&&this.html.used&&this.status.nativeVideoControls?this.internal.video.jq.css({width:this.status.width,height:this.status.height}):!this.status.waitForPlay&&this.flash.active&&this.status.video&&this.internal.flash.jq.css({width:this.status.width,height:this.status.height})},_updateAutohide:function(){var a=this,b="mousemove.jPlayer",c=".jPlayerAutohide",d=b+c,e=function(b){var c,d,e=!1;"undefined"!=typeof a.internal.mouse?(c=a.internal.mouse.x-b.pageX,d=a.internal.mouse.y-b.pageY,e=Math.floor(c)>0||Math.floor(d)>0):e=!0,a.internal.mouse={x:b.pageX,y:b.pageY},e&&a.css.jq.gui.fadeIn(a.options.autohide.fadeIn,function(){clearTimeout(a.internal.autohideId),a.internal.autohideId=setTimeout(function(){a.css.jq.gui.fadeOut(a.options.autohide.fadeOut)},a.options.autohide.hold)})};this.css.jq.gui.length&&(this.css.jq.gui.stop(!0,!0),clearTimeout(this.internal.autohideId),delete this.internal.mouse,this.element.unbind(c),this.css.jq.gui.unbind(c),this.status.nativeVideoControls?this.css.jq.gui.hide():this.options.fullWindow&&this.options.autohide.full||!this.options.fullWindow&&this.options.autohide.restored?(this.element.bind(d,e),this.css.jq.gui.bind(d,e),this.css.jq.gui.hide()):this.css.jq.gui.show())},fullScreen:function(a){var b="object"==typeof a;b&&this.options.useStateClassSkin&&this.options.fullScreen?this._setOption("fullScreen",!1):this._setOption("fullScreen",!0)},restoreScreen:function(){this._setOption("fullScreen",!1)},_fullscreenAddEventListeners:function(){var b=this,c=a.jPlayer.nativeFeatures.fullscreen;c.api.fullscreenEnabled&&c.event.fullscreenchange&&("function"!=typeof this.internal.fullscreenchangeHandler&&(this.internal.fullscreenchangeHandler=function(){b._fullscreenchange()}),document.addEventListener(c.event.fullscreenchange,this.internal.fullscreenchangeHandler,!1))},_fullscreenRemoveEventListeners:function(){var b=a.jPlayer.nativeFeatures.fullscreen;this.internal.fullscreenchangeHandler&&document.removeEventListener(b.event.fullscreenchange,this.internal.fullscreenchangeHandler,!1)},_fullscreenchange:function(){this.options.fullScreen&&!a.jPlayer.nativeFeatures.fullscreen.api.fullscreenElement()&&this._setOption("fullScreen",!1)},_requestFullscreen:function(){var b=this.ancestorJq.length?this.ancestorJq[0]:this.element[0],c=a.jPlayer.nativeFeatures.fullscreen;c.used.webkitVideo&&(b=this.htmlElement.video),c.api.fullscreenEnabled&&c.api.requestFullscreen(b)},_exitFullscreen:function(){var b,c=a.jPlayer.nativeFeatures.fullscreen;c.used.webkitVideo&&(b=this.htmlElement.video),c.api.fullscreenEnabled&&c.api.exitFullscreen(b)},_html_initMedia:function(b){var c=a(this.htmlElement.media).empty();a.each(b.track||[],function(a,b){var d=document.createElement("track");d.setAttribute("kind",b.kind?b.kind:""),d.setAttribute("src",b.src?b.src:""),d.setAttribute("srclang",b.srclang?b.srclang:""),d.setAttribute("label",b.label?b.label:""),b.def&&d.setAttribute("default",b.def),c.append(d)}),this.htmlElement.media.src=this.status.src,"none"!==this.options.preload&&this._html_load(),this._trigger(a.jPlayer.event.timeupdate)},_html_setFormat:function(b){var c=this;a.each(this.formats,function(a,d){return c.html.support[d]&&b[d]?(c.status.src=b[d],c.status.format[d]=!0,c.status.formatType=d,!1):void 0})},_html_setAudio:function(a){this._html_setFormat(a),this.htmlElement.media=this.htmlElement.audio,this._html_initMedia(a)},_html_setVideo:function(a){this._html_setFormat(a),this.status.nativeVideoControls&&(this.htmlElement.video.poster=this._validString(a.poster)?a.poster:""),this.htmlElement.media=this.htmlElement.video,this._html_initMedia(a)},_html_resetMedia:function(){this.htmlElement.media&&(this.htmlElement.media.id!==this.internal.video.id||this.status.nativeVideoControls||this.internal.video.jq.css({width:"0px",height:"0px"}),this.htmlElement.media.pause())},_html_clearMedia:function(){this.htmlElement.media&&(this.htmlElement.media.src="about:blank",this.htmlElement.media.load())},_html_load:function(){this.status.waitForLoad&&(this.status.waitForLoad=!1,this.htmlElement.media.load()),clearTimeout(this.internal.htmlDlyCmdId)},_html_play:function(a){var b=this,c=this.htmlElement.media;if(this.androidFix.pause=!1,this._html_load(),this.androidFix.setMedia)this.androidFix.play=!0,this.androidFix.time=a;else if(isNaN(a))c.play();else{this.internal.cmdsIgnored&&c.play();try{if(c.seekable&&!("object"==typeof c.seekable&&c.seekable.length>0))throw 1;c.currentTime=a,c.play()}catch(d){return void(this.internal.htmlDlyCmdId=setTimeout(function(){b.play(a)},250))}}this._html_checkWaitForPlay()},_html_pause:function(a){var b=this,c=this.htmlElement.media;if(this.androidFix.play=!1,a>0?this._html_load():clearTimeout(this.internal.htmlDlyCmdId),c.pause(),this.androidFix.setMedia)this.androidFix.pause=!0,this.androidFix.time=a;else if(!isNaN(a))try{if(c.seekable&&!("object"==typeof c.seekable&&c.seekable.length>0))throw 1;c.currentTime=a}catch(d){return void(this.internal.htmlDlyCmdId=setTimeout(function(){b.pause(a)},250))}a>0&&this._html_checkWaitForPlay()},_html_playHead:function(a){var b=this,c=this.htmlElement.media;this._html_load();try{if("object"==typeof c.seekable&&c.seekable.length>0)c.currentTime=a*c.seekable.end(c.seekable.length-1)/100;else{if(!(c.duration>0)||isNaN(c.duration))throw"e";c.currentTime=a*c.duration/100}}catch(d){return void(this.internal.htmlDlyCmdId=setTimeout(function(){b.playHead(a)},250))}this.status.waitForLoad||this._html_checkWaitForPlay()},_html_checkWaitForPlay:function(){this.status.waitForPlay&&(this.status.waitForPlay=!1,this.css.jq.videoPlay.length&&this.css.jq.videoPlay.hide(),this.status.video&&(this.internal.poster.jq.hide(),this.internal.video.jq.css({width:this.status.width,height:this.status.height})))},_html_setProperty:function(a,b){this.html.audio.available&&(this.htmlElement.audio[a]=b),this.html.video.available&&(this.htmlElement.video[a]=b)},_aurora_setAudio:function(b){var c=this;a.each(this.formats,function(a,d){return c.aurora.support[d]&&b[d]?(c.status.src=b[d],c.status.format[d]=!0,c.status.formatType=d,!1):void 0}),this.aurora.player=new AV.Player.fromURL(this.status.src),this._addAuroraEventListeners(this.aurora.player,this.aurora),"auto"===this.options.preload&&(this._aurora_load(),this.status.waitForLoad=!1)},_aurora_resetMedia:function(){this.aurora.player&&this.aurora.player.stop()},_aurora_clearMedia:function(){},_aurora_load:function(){this.status.waitForLoad&&(this.status.waitForLoad=!1,this.aurora.player.preload())},_aurora_play:function(b){this.status.waitForLoad||isNaN(b)||this.aurora.player.seek(b),this.aurora.player.playing||this.aurora.player.play(),this.status.waitForLoad=!1,this._aurora_checkWaitForPlay(),this._updateButtons(!0),this._trigger(a.jPlayer.event.play)},_aurora_pause:function(b){isNaN(b)||this.aurora.player.seek(1e3*b),this.aurora.player.pause(),b>0&&this._aurora_checkWaitForPlay(),this._updateButtons(!1),this._trigger(a.jPlayer.event.pause)},_aurora_playHead:function(a){this.aurora.player.duration>0&&this.aurora.player.seek(a*this.aurora.player.duration/100),this.status.waitForLoad||this._aurora_checkWaitForPlay()},_aurora_checkWaitForPlay:function(){this.status.waitForPlay&&(this.status.waitForPlay=!1)},_aurora_volume:function(a){this.aurora.player.volume=100*a},_aurora_mute:function(a){a?(this.aurora.properties.lastvolume=this.aurora.player.volume,this.aurora.player.volume=0):this.aurora.player.volume=this.aurora.properties.lastvolume,this.aurora.properties.muted=a},_flash_setAudio:function(b){var c=this;try{a.each(this.formats,function(a,d){if(c.flash.support[d]&&b[d]){switch(d){case"m4a":case"fla":c._getMovie().fl_setAudio_m4a(b[d]);break;case"mp3":c._getMovie().fl_setAudio_mp3(b[d]);break;case"rtmpa":c._getMovie().fl_setAudio_rtmp(b[d])}return c.status.src=b[d],c.status.format[d]=!0,c.status.formatType=d,!1}}),"auto"===this.options.preload&&(this._flash_load(),this.status.waitForLoad=!1)}catch(d){this._flashError(d)}},_flash_setVideo:function(b){var c=this;try{a.each(this.formats,function(a,d){if(c.flash.support[d]&&b[d]){switch(d){case"m4v":case"flv":c._getMovie().fl_setVideo_m4v(b[d]);break;case"rtmpv":c._getMovie().fl_setVideo_rtmp(b[d])}return c.status.src=b[d],c.status.format[d]=!0,c.status.formatType=d,!1}}),"auto"===this.options.preload&&(this._flash_load(),this.status.waitForLoad=!1)}catch(d){this._flashError(d)}},_flash_resetMedia:function(){this.internal.flash.jq.css({width:"0px",height:"0px"}),this._flash_pause(0/0)},_flash_clearMedia:function(){try{this._getMovie().fl_clearMedia()}catch(a){this._flashError(a)}},_flash_load:function(){try{this._getMovie().fl_load()}catch(a){this._flashError(a)}this.status.waitForLoad=!1},_flash_play:function(a){try{this._getMovie().fl_play(a)}catch(b){this._flashError(b)}this.status.waitForLoad=!1,this._flash_checkWaitForPlay()},_flash_pause:function(a){try{this._getMovie().fl_pause(a)}catch(b){this._flashError(b)}a>0&&(this.status.waitForLoad=!1,this._flash_checkWaitForPlay())},_flash_playHead:function(a){try{this._getMovie().fl_play_head(a)}catch(b){this._flashError(b)}this.status.waitForLoad||this._flash_checkWaitForPlay()},_flash_checkWaitForPlay:function(){this.status.waitForPlay&&(this.status.waitForPlay=!1,this.css.jq.videoPlay.length&&this.css.jq.videoPlay.hide(),this.status.video&&(this.internal.poster.jq.hide(),this.internal.flash.jq.css({width:this.status.width,height:this.status.height})))},_flash_volume:function(a){try{this._getMovie().fl_volume(a)}catch(b){this._flashError(b)}},_flash_mute:function(a){try{this._getMovie().fl_mute(a)}catch(b){this._flashError(b)}},_getMovie:function(){return document[this.internal.flash.id]},_getFlashPluginVersion:function(){var a,b=0;if(window.ActiveXObject)try{if(a=new ActiveXObject("ShockwaveFlash.ShockwaveFlash")){var c=a.GetVariable("$version");c&&(c=c.split(" ")[1].split(","),b=parseInt(c[0],10)+"."+parseInt(c[1],10))}}catch(d){}else navigator.plugins&&navigator.mimeTypes.length>0&&(a=navigator.plugins["Shockwave Flash"],a&&(b=navigator.plugins["Shockwave Flash"].description.replace(/.*\s(\d+\.\d+).*/,"$1")));return 1*b},_checkForFlash:function(a){var b=!1;return this._getFlashPluginVersion()>=a&&(b=!0),b},_validString:function(a){return a&&"string"==typeof a},_limitValue:function(a,b,c){return b>a?b:a>c?c:a},_urlNotSetError:function(b){this._error({type:a.jPlayer.error.URL_NOT_SET,context:b,message:a.jPlayer.errorMsg.URL_NOT_SET,hint:a.jPlayer.errorHint.URL_NOT_SET})},_flashError:function(b){var c;c=this.internal.ready?"FLASH_DISABLED":"FLASH",this._error({type:a.jPlayer.error[c],context:this.internal.flash.swf,message:a.jPlayer.errorMsg[c]+b.message,hint:a.jPlayer.errorHint[c]}),this.internal.flash.jq.css({width:"1px",height:"1px"})},_error:function(b){this._trigger(a.jPlayer.event.error,b),this.options.errorAlerts&&this._alert("Error!"+(b.message?"\n"+b.message:"")+(b.hint?"\n"+b.hint:"")+"\nContext: "+b.context)},_warning:function(c){this._trigger(a.jPlayer.event.warning,b,c),this.options.warningAlerts&&this._alert("Warning!"+(c.message?"\n"+c.message:"")+(c.hint?"\n"+c.hint:"")+"\nContext: "+c.context)},_alert:function(a){var b="jPlayer "+this.version.script+" : id='"+this.internal.self.id+"' : "+a;this.options.consoleAlerts?window.console&&window.console.log&&window.console.log(b):alert(b)},_emulateHtmlBridge:function(){var b=this;a.each(a.jPlayer.emulateMethods.split(/\s+/g),function(a,c){b.internal.domNode[c]=function(a){b[c](a)}}),a.each(a.jPlayer.event,function(c,d){var e=!0;a.each(a.jPlayer.reservedEvent.split(/\s+/g),function(a,b){return b===c?(e=!1,!1):void 0}),e&&b.element.bind(d+".jPlayer.jPlayerHtml",function(){b._emulateHtmlUpdate();var a=document.createEvent("Event");a.initEvent(c,!1,!0),b.internal.domNode.dispatchEvent(a)})})},_emulateHtmlUpdate:function(){var b=this;a.each(a.jPlayer.emulateStatus.split(/\s+/g),function(a,c){b.internal.domNode[c]=b.status[c]}),a.each(a.jPlayer.emulateOptions.split(/\s+/g),function(a,c){b.internal.domNode[c]=b.options[c]})},_destroyHtmlBridge:function(){var b=this;this.element.unbind(".jPlayerHtml");var c=a.jPlayer.emulateMethods+" "+a.jPlayer.emulateStatus+" "+a.jPlayer.emulateOptions;a.each(c.split(/\s+/g),function(a,c){delete b.internal.domNode[c]})}},a.jPlayer.error={FLASH:"e_flash",FLASH_DISABLED:"e_flash_disabled",NO_SOLUTION:"e_no_solution",NO_SUPPORT:"e_no_support",URL:"e_url",URL_NOT_SET:"e_url_not_set",VERSION:"e_version"},a.jPlayer.errorMsg={FLASH:"jPlayer's Flash fallback is not configured correctly, or a command was issued before the jPlayer Ready event. Details: ",FLASH_DISABLED:"jPlayer's Flash fallback has been disabled by the browser due to the CSS rules you have used. Details: ",NO_SOLUTION:"No solution can be found by jPlayer in this browser. Neither HTML nor Flash can be used.",NO_SUPPORT:"It is not possible to play any media format provided in setMedia() on this browser using your current options.",URL:"Media URL could not be loaded.",URL_NOT_SET:"Attempt to issue media playback commands, while no media url is set.",VERSION:"jPlayer "+a.jPlayer.prototype.version.script+" needs Jplayer.swf version "+a.jPlayer.prototype.version.needFlash+" but found "},a.jPlayer.errorHint={FLASH:"Check your swfPath option and that Jplayer.swf is there.",FLASH_DISABLED:"Check that you have not display:none; the jPlayer entity or any ancestor.",NO_SOLUTION:"Review the jPlayer options: support and supplied.",NO_SUPPORT:"Video or audio formats defined in the supplied option are missing.",URL:"Check media URL is valid.",URL_NOT_SET:"Use setMedia() to set the media URL.",VERSION:"Update jPlayer files."},a.jPlayer.warning={CSS_SELECTOR_COUNT:"e_css_selector_count",CSS_SELECTOR_METHOD:"e_css_selector_method",CSS_SELECTOR_STRING:"e_css_selector_string",OPTION_KEY:"e_option_key"},a.jPlayer.warningMsg={CSS_SELECTOR_COUNT:"The number of css selectors found did not equal one: ",CSS_SELECTOR_METHOD:"The methodName given in jPlayer('cssSelector') is not a valid jPlayer method.",CSS_SELECTOR_STRING:"The methodCssSelector given in jPlayer('cssSelector') is not a String or is empty.",OPTION_KEY:"The option requested in jPlayer('option') is undefined."},a.jPlayer.warningHint={CSS_SELECTOR_COUNT:"Check your css selector and the ancestor.",CSS_SELECTOR_METHOD:"Check your method name.",CSS_SELECTOR_STRING:"Check your css selector is a string.",OPTION_KEY:"Check your option name."}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file jquery.jplayer.min.js'); }

// file jquery.jplayer.min.js end

// file jquery.mjsLoadImg.js.js start

try { 
jQuery.fn.mjsLoadImg = function(callback) {
	var images = this.filter('img'),
	imagesLength = images.length,
	counter = 0;

	var ready = function() {
		counter++;
		if (counter === imagesLength) {
			callback(counter);
		}
	};

	return (typeof callback === 'function') ? images.each(function() {
		if (jQuery(this).is('img')) {
			if (this.complete) {
				ready();
			} else {
				jQuery(this).load(ready).error(ready);
				this.src = this.src; // hack for IE9. Loading from cache error - handler isn't called sometimes.
			}
		}
	}) : this;
};
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file jquery.mjsLoadImg.js.js'); }

// file jquery.mjsLoadImg.js.js end

// file jquery.swipe.js start

try { 
/*
 * jSwipe - jQuery Plugin
 * http://plugins.jquery.com/project/swipe
 * http://www.ryanscherf.com/demos/swipe/
 *
 * Copyright (c) 2009 Ryan Scherf (www.ryanscherf.com)
 * Licensed under the MIT license
 *
 * $Date: 2009-07-14 (Tue, 14 Jul 2009) $
 * $version: 0.1.2
 *
 * This jQuery plugin will only run on devices running Mobile Safari
 * on iPhone or iPod Touch devices running iPhone OS 2.0 or later.
 * http://developer.apple.com/iphone/library/documentation/AppleApplications/Reference/SafariWebContent/HandlingEvents/HandlingEvents.html#//apple_ref/doc/uid/TP40006511-SW5
 */
(function($) {
	$.fn.swipe = function(options) {

		// Default thresholds & swipe functions
		var defaults = {
			threshold: {
				x: 10,
				y: 30
			},
			swipeLeft: function() {},
			swipeRight: function() {},
			swipeMoving: function( value ){}
		};

		var options = $.extend(defaults, options);

		if (!this) return false;

		return this.each(function() {

			// Private variables for each element
			var originalCoord = {x: 0, y: 0};
			var finalCoord = {x: 0, y: 0};

			// Screen touched, store the original coordinate
			function touchStart(event) {
				
				originalCoord.x = event.targetTouches[0].pageX;
				originalCoord.y = event.targetTouches[0].pageY;
			}

			// Store coordinates as finger is swiping
			function touchMove(event) {

				if(event.touches.length > 1 || event.scale && event.scale !== 1){
					return;
				}

				finalCoord.x = event.targetTouches[0].pageX; // Updated X,Y coordinates
				finalCoord.y = event.targetTouches[0].pageY;
				changeX = originalCoord.x - finalCoord.x;
				changeY = originalCoord.y - finalCoord.y;

				if ( typeof this.isScrolling === 'undefined') {
					this.isScrolling = !!( this.isScrolling || Math.abs(changeX) < Math.abs(changeY) );
				}
				if( !this.isScrolling )
				{
					
					event.preventDefault();
					defaults.swipeMoving( changeX );
				}
			}

			// Done Swiping
			// Swipe should only be on X axis, ignore if swipe on Y axis
			// Calculate if the swipe was left or right
			function touchEnd(event) {
				
				var changeY = originalCoord.y - finalCoord.y;

				if (!this.isScrolling) {
					changeX = originalCoord.x - finalCoord.x;
					if(changeX > defaults.threshold.x) {
						defaults.swipeLeft()
					}
					if(changeX < (defaults.threshold.x*-1)) {
						defaults.swipeRight()
					}
				}
			}

			// Swipe was started
			function touchStart(event) {
				

				this.isScrolling = undefined;
				originalCoord.x = event.targetTouches[0].pageX
				originalCoord.y = event.targetTouches[0].pageY

				finalCoord.x = originalCoord.x
				finalCoord.y = originalCoord.y
			}

			// Swipe was canceled
			function touchCancel(event) {
			
			}

			// Add gestures to all swipable areas
			this.addEventListener("touchstart", touchStart, false);
			this.addEventListener("touchmove", touchMove, false);
			this.addEventListener("touchend", touchEnd, false);
			this.addEventListener("touchcancel", touchCancel, false);

		});
	};
})(jQuery);
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file jquery.swipe.js'); }

// file jquery.swipe.js end

// file jquery.validate.min.js start

try { 
/*! jQuery Validation Plugin - v1.13.1 - 10/14/2014
 * http://jqueryvalidation.org/
 * Copyright (c) 2014 JÃ¶rn Zaefferer; Licensed MIT */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a(jQuery)}(function(a){a.extend(a.fn,{validate:function(b){if(!this.length)return void(b&&b.debug&&window.console&&console.warn("Nothing selected, can't validate, returning nothing."));var c=a.data(this[0],"validator");return c?c:(this.attr("novalidate","novalidate"),c=new a.validator(b,this[0]),a.data(this[0],"validator",c),c.settings.onsubmit&&(this.validateDelegate(":submit","click",function(b){c.settings.submitHandler&&(c.submitButton=b.target),a(b.target).hasClass("cancel")&&(c.cancelSubmit=!0),void 0!==a(b.target).attr("formnovalidate")&&(c.cancelSubmit=!0)}),this.submit(function(b){function d(){var d,e;return c.settings.submitHandler?(c.submitButton&&(d=a("<input type='hidden'/>").attr("name",c.submitButton.name).val(a(c.submitButton).val()).appendTo(c.currentForm)),e=c.settings.submitHandler.call(c,c.currentForm,b),c.submitButton&&d.remove(),void 0!==e?e:!1):!0}return c.settings.debug&&b.preventDefault(),c.cancelSubmit?(c.cancelSubmit=!1,d()):c.form()?c.pendingRequest?(c.formSubmitted=!0,!1):d():(c.focusInvalid(),!1)})),c)},valid:function(){var b,c;return a(this[0]).is("form")?b=this.validate().form():(b=!0,c=a(this[0].form).validate(),this.each(function(){b=c.element(this)&&b})),b},removeAttrs:function(b){var c={},d=this;return a.each(b.split(/\s/),function(a,b){c[b]=d.attr(b),d.removeAttr(b)}),c},rules:function(b,c){var d,e,f,g,h,i,j=this[0];if(b)switch(d=a.data(j.form,"validator").settings,e=d.rules,f=a.validator.staticRules(j),b){case"add":a.extend(f,a.validator.normalizeRule(c)),delete f.messages,e[j.name]=f,c.messages&&(d.messages[j.name]=a.extend(d.messages[j.name],c.messages));break;case"remove":return c?(i={},a.each(c.split(/\s/),function(b,c){i[c]=f[c],delete f[c],"required"===c&&a(j).removeAttr("aria-required")}),i):(delete e[j.name],f)}return g=a.validator.normalizeRules(a.extend({},a.validator.classRules(j),a.validator.attributeRules(j),a.validator.dataRules(j),a.validator.staticRules(j)),j),g.required&&(h=g.required,delete g.required,g=a.extend({required:h},g),a(j).attr("aria-required","true")),g.remote&&(h=g.remote,delete g.remote,g=a.extend(g,{remote:h})),g}}),a.extend(a.expr[":"],{blank:function(b){return!a.trim(""+a(b).val())},filled:function(b){return!!a.trim(""+a(b).val())},unchecked:function(b){return!a(b).prop("checked")}}),a.validator=function(b,c){this.settings=a.extend(!0,{},a.validator.defaults,b),this.currentForm=c,this.init()},a.validator.format=function(b,c){return 1===arguments.length?function(){var c=a.makeArray(arguments);return c.unshift(b),a.validator.format.apply(this,c)}:(arguments.length>2&&c.constructor!==Array&&(c=a.makeArray(arguments).slice(1)),c.constructor!==Array&&(c=[c]),a.each(c,function(a,c){b=b.replace(new RegExp("\\{"+a+"\\}","g"),function(){return c})}),b)},a.extend(a.validator,{defaults:{messages:{},groups:{},rules:{},errorClass:"error",validClass:"valid",errorElement:"label",focusCleanup:!1,focusInvalid:!0,errorContainer:a([]),errorLabelContainer:a([]),onsubmit:!0,ignore:":hidden",ignoreTitle:!1,onfocusin:function(a){this.lastActive=a,this.settings.focusCleanup&&(this.settings.unhighlight&&this.settings.unhighlight.call(this,a,this.settings.errorClass,this.settings.validClass),this.hideThese(this.errorsFor(a)))},onfocusout:function(a){this.checkable(a)||!(a.name in this.submitted)&&this.optional(a)||this.element(a)},onkeyup:function(a,b){(9!==b.which||""!==this.elementValue(a))&&(a.name in this.submitted||a===this.lastElement)&&this.element(a)},onclick:function(a){a.name in this.submitted?this.element(a):a.parentNode.name in this.submitted&&this.element(a.parentNode)},highlight:function(b,c,d){"radio"===b.type?this.findByName(b.name).addClass(c).removeClass(d):a(b).addClass(c).removeClass(d)},unhighlight:function(b,c,d){"radio"===b.type?this.findByName(b.name).removeClass(c).addClass(d):a(b).removeClass(c).addClass(d)}},setDefaults:function(b){a.extend(a.validator.defaults,b)},messages:{required:"This field is required.",remote:"Please fix this field.",email:"Please enter a valid email address.",url:"Please enter a valid URL.",date:"Please enter a valid date.",dateISO:"Please enter a valid date ( ISO ).",number:"Please enter a valid number.",digits:"Please enter only digits.",creditcard:"Please enter a valid credit card number.",equalTo:"Please enter the same value again.",maxlength:a.validator.format("Please enter no more than {0} characters."),minlength:a.validator.format("Please enter at least {0} characters."),rangelength:a.validator.format("Please enter a value between {0} and {1} characters long."),range:a.validator.format("Please enter a value between {0} and {1}."),max:a.validator.format("Please enter a value less than or equal to {0}."),min:a.validator.format("Please enter a value greater than or equal to {0}.")},autoCreateRanges:!1,prototype:{init:function(){function b(b){var c=a.data(this[0].form,"validator"),d="on"+b.type.replace(/^validate/,""),e=c.settings;e[d]&&!this.is(e.ignore)&&e[d].call(c,this[0],b)}this.labelContainer=a(this.settings.errorLabelContainer),this.errorContext=this.labelContainer.length&&this.labelContainer||a(this.currentForm),this.containers=a(this.settings.errorContainer).add(this.settings.errorLabelContainer),this.submitted={},this.valueCache={},this.pendingRequest=0,this.pending={},this.invalid={},this.reset();var c,d=this.groups={};a.each(this.settings.groups,function(b,c){"string"==typeof c&&(c=c.split(/\s/)),a.each(c,function(a,c){d[c]=b})}),c=this.settings.rules,a.each(c,function(b,d){c[b]=a.validator.normalizeRule(d)}),a(this.currentForm).validateDelegate(":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'] ,[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'], [type='radio'], [type='checkbox']","focusin focusout keyup",b).validateDelegate("select, option, [type='radio'], [type='checkbox']","click",b),this.settings.invalidHandler&&a(this.currentForm).bind("invalid-form.validate",this.settings.invalidHandler),a(this.currentForm).find("[required], [data-rule-required], .required").attr("aria-required","true")},form:function(){return this.checkForm(),a.extend(this.submitted,this.errorMap),this.invalid=a.extend({},this.errorMap),this.valid()||a(this.currentForm).triggerHandler("invalid-form",[this]),this.showErrors(),this.valid()},checkForm:function(){this.prepareForm();for(var a=0,b=this.currentElements=this.elements();b[a];a++)this.check(b[a]);return this.valid()},element:function(b){var c=this.clean(b),d=this.validationTargetFor(c),e=!0;return this.lastElement=d,void 0===d?delete this.invalid[c.name]:(this.prepareElement(d),this.currentElements=a(d),e=this.check(d)!==!1,e?delete this.invalid[d.name]:this.invalid[d.name]=!0),a(b).attr("aria-invalid",!e),this.numberOfInvalids()||(this.toHide=this.toHide.add(this.containers)),this.showErrors(),e},showErrors:function(b){if(b){a.extend(this.errorMap,b),this.errorList=[];for(var c in b)this.errorList.push({message:b[c],element:this.findByName(c)[0]});this.successList=a.grep(this.successList,function(a){return!(a.name in b)})}this.settings.showErrors?this.settings.showErrors.call(this,this.errorMap,this.errorList):this.defaultShowErrors()},resetForm:function(){a.fn.resetForm&&a(this.currentForm).resetForm(),this.submitted={},this.lastElement=null,this.prepareForm(),this.hideErrors(),this.elements().removeClass(this.settings.errorClass).removeData("previousValue").removeAttr("aria-invalid")},numberOfInvalids:function(){return this.objectLength(this.invalid)},objectLength:function(a){var b,c=0;for(b in a)c++;return c},hideErrors:function(){this.hideThese(this.toHide)},hideThese:function(a){a.not(this.containers).text(""),this.addWrapper(a).hide()},valid:function(){return 0===this.size()},size:function(){return this.errorList.length},focusInvalid:function(){if(this.settings.focusInvalid)try{a(this.findLastActive()||this.errorList.length&&this.errorList[0].element||[]).filter(":visible").focus().trigger("focusin")}catch(b){}},findLastActive:function(){var b=this.lastActive;return b&&1===a.grep(this.errorList,function(a){return a.element.name===b.name}).length&&b},elements:function(){var b=this,c={};return a(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled], [readonly]").not(this.settings.ignore).filter(function(){return!this.name&&b.settings.debug&&window.console&&console.error("%o has no name assigned",this),this.name in c||!b.objectLength(a(this).rules())?!1:(c[this.name]=!0,!0)})},clean:function(b){return a(b)[0]},errors:function(){var b=this.settings.errorClass.split(" ").join(".");return a(this.settings.errorElement+"."+b,this.errorContext)},reset:function(){this.successList=[],this.errorList=[],this.errorMap={},this.toShow=a([]),this.toHide=a([]),this.currentElements=a([])},prepareForm:function(){this.reset(),this.toHide=this.errors().add(this.containers)},prepareElement:function(a){this.reset(),this.toHide=this.errorsFor(a)},elementValue:function(b){var c,d=a(b),e=b.type;return"radio"===e||"checkbox"===e?a("input[name='"+b.name+"']:checked").val():"number"===e&&"undefined"!=typeof b.validity?b.validity.badInput?!1:d.val():(c=d.val(),"string"==typeof c?c.replace(/\r/g,""):c)},check:function(b){b=this.validationTargetFor(this.clean(b));var c,d,e,f=a(b).rules(),g=a.map(f,function(a,b){return b}).length,h=!1,i=this.elementValue(b);for(d in f){e={method:d,parameters:f[d]};try{if(c=a.validator.methods[d].call(this,i,b,e.parameters),"dependency-mismatch"===c&&1===g){h=!0;continue}if(h=!1,"pending"===c)return void(this.toHide=this.toHide.not(this.errorsFor(b)));if(!c)return this.formatAndAdd(b,e),!1}catch(j){throw this.settings.debug&&window.console&&console.log("Exception occurred when checking element "+b.id+", check the '"+e.method+"' method.",j),j}}if(!h)return this.objectLength(f)&&this.successList.push(b),!0},customDataMessage:function(b,c){return a(b).data("msg"+c.charAt(0).toUpperCase()+c.substring(1).toLowerCase())||a(b).data("msg")},customMessage:function(a,b){var c=this.settings.messages[a];return c&&(c.constructor===String?c:c[b])},findDefined:function(){for(var a=0;a<arguments.length;a++)if(void 0!==arguments[a])return arguments[a];return void 0},defaultMessage:function(b,c){return this.findDefined(this.customMessage(b.name,c),this.customDataMessage(b,c),!this.settings.ignoreTitle&&b.title||void 0,a.validator.messages[c],"<strong>Warning: No message defined for "+b.name+"</strong>")},formatAndAdd:function(b,c){var d=this.defaultMessage(b,c.method),e=/\$?\{(\d+)\}/g;"function"==typeof d?d=d.call(this,c.parameters,b):e.test(d)&&(d=a.validator.format(d.replace(e,"{$1}"),c.parameters)),this.errorList.push({message:d,element:b,method:c.method}),this.errorMap[b.name]=d,this.submitted[b.name]=d},addWrapper:function(a){return this.settings.wrapper&&(a=a.add(a.parent(this.settings.wrapper))),a},defaultShowErrors:function(){var a,b,c;for(a=0;this.errorList[a];a++)c=this.errorList[a],this.settings.highlight&&this.settings.highlight.call(this,c.element,this.settings.errorClass,this.settings.validClass),this.showLabel(c.element,c.message);if(this.errorList.length&&(this.toShow=this.toShow.add(this.containers)),this.settings.success)for(a=0;this.successList[a];a++)this.showLabel(this.successList[a]);if(this.settings.unhighlight)for(a=0,b=this.validElements();b[a];a++)this.settings.unhighlight.call(this,b[a],this.settings.errorClass,this.settings.validClass);this.toHide=this.toHide.not(this.toShow),this.hideErrors(),this.addWrapper(this.toShow).show()},validElements:function(){return this.currentElements.not(this.invalidElements())},invalidElements:function(){return a(this.errorList).map(function(){return this.element})},showLabel:function(b,c){var d,e,f,g=this.errorsFor(b),h=this.idOrName(b),i=a(b).attr("aria-describedby");g.length?(g.removeClass(this.settings.validClass).addClass(this.settings.errorClass),g.html(c)):(g=a("<"+this.settings.errorElement+">").attr("id",h+"-error").addClass(this.settings.errorClass).html(c||""),d=g,this.settings.wrapper&&(d=g.hide().show().wrap("<"+this.settings.wrapper+"/>").parent()),this.labelContainer.length?this.labelContainer.append(d):this.settings.errorPlacement?this.settings.errorPlacement(d,a(b)):d.insertAfter(b),g.is("label")?g.attr("for",h):0===g.parents("label[for='"+h+"']").length&&(f=g.attr("id").replace(/(:|\.|\[|\])/g,"\\$1"),i?i.match(new RegExp("\\b"+f+"\\b"))||(i+=" "+f):i=f,a(b).attr("aria-describedby",i),e=this.groups[b.name],e&&a.each(this.groups,function(b,c){c===e&&a("[name='"+b+"']",this.currentForm).attr("aria-describedby",g.attr("id"))}))),!c&&this.settings.success&&(g.text(""),"string"==typeof this.settings.success?g.addClass(this.settings.success):this.settings.success(g,b)),this.toShow=this.toShow.add(g)},errorsFor:function(b){var c=this.idOrName(b),d=a(b).attr("aria-describedby"),e="label[for='"+c+"'], label[for='"+c+"'] *";return d&&(e=e+", #"+d.replace(/\s+/g,", #")),this.errors().filter(e)},idOrName:function(a){return this.groups[a.name]||(this.checkable(a)?a.name:a.id||a.name)},validationTargetFor:function(b){return this.checkable(b)&&(b=this.findByName(b.name)),a(b).not(this.settings.ignore)[0]},checkable:function(a){return/radio|checkbox/i.test(a.type)},findByName:function(b){return a(this.currentForm).find("[name='"+b+"']")},getLength:function(b,c){switch(c.nodeName.toLowerCase()){case"select":return a("option:selected",c).length;case"input":if(this.checkable(c))return this.findByName(c.name).filter(":checked").length}return b.length},depend:function(a,b){return this.dependTypes[typeof a]?this.dependTypes[typeof a](a,b):!0},dependTypes:{"boolean":function(a){return a},string:function(b,c){return!!a(b,c.form).length},"function":function(a,b){return a(b)}},optional:function(b){var c=this.elementValue(b);return!a.validator.methods.required.call(this,c,b)&&"dependency-mismatch"},startRequest:function(a){this.pending[a.name]||(this.pendingRequest++,this.pending[a.name]=!0)},stopRequest:function(b,c){this.pendingRequest--,this.pendingRequest<0&&(this.pendingRequest=0),delete this.pending[b.name],c&&0===this.pendingRequest&&this.formSubmitted&&this.form()?(a(this.currentForm).submit(),this.formSubmitted=!1):!c&&0===this.pendingRequest&&this.formSubmitted&&(a(this.currentForm).triggerHandler("invalid-form",[this]),this.formSubmitted=!1)},previousValue:function(b){return a.data(b,"previousValue")||a.data(b,"previousValue",{old:null,valid:!0,message:this.defaultMessage(b,"remote")})}},classRuleSettings:{required:{required:!0},email:{email:!0},url:{url:!0},date:{date:!0},dateISO:{dateISO:!0},number:{number:!0},digits:{digits:!0},creditcard:{creditcard:!0}},addClassRules:function(b,c){b.constructor===String?this.classRuleSettings[b]=c:a.extend(this.classRuleSettings,b)},classRules:function(b){var c={},d=a(b).attr("class");return d&&a.each(d.split(" "),function(){this in a.validator.classRuleSettings&&a.extend(c,a.validator.classRuleSettings[this])}),c},attributeRules:function(b){var c,d,e={},f=a(b),g=b.getAttribute("type");for(c in a.validator.methods)"required"===c?(d=b.getAttribute(c),""===d&&(d=!0),d=!!d):d=f.attr(c),/min|max/.test(c)&&(null===g||/number|range|text/.test(g))&&(d=Number(d)),d||0===d?e[c]=d:g===c&&"range"!==g&&(e[c]=!0);return e.maxlength&&/-1|2147483647|524288/.test(e.maxlength)&&delete e.maxlength,e},dataRules:function(b){var c,d,e={},f=a(b);for(c in a.validator.methods)d=f.data("rule"+c.charAt(0).toUpperCase()+c.substring(1).toLowerCase()),void 0!==d&&(e[c]=d);return e},staticRules:function(b){var c={},d=a.data(b.form,"validator");return d.settings.rules&&(c=a.validator.normalizeRule(d.settings.rules[b.name])||{}),c},normalizeRules:function(b,c){return a.each(b,function(d,e){if(e===!1)return void delete b[d];if(e.param||e.depends){var f=!0;switch(typeof e.depends){case"string":f=!!a(e.depends,c.form).length;break;case"function":f=e.depends.call(c,c)}f?b[d]=void 0!==e.param?e.param:!0:delete b[d]}}),a.each(b,function(d,e){b[d]=a.isFunction(e)?e(c):e}),a.each(["minlength","maxlength"],function(){b[this]&&(b[this]=Number(b[this]))}),a.each(["rangelength","range"],function(){var c;b[this]&&(a.isArray(b[this])?b[this]=[Number(b[this][0]),Number(b[this][1])]:"string"==typeof b[this]&&(c=b[this].replace(/[\[\]]/g,"").split(/[\s,]+/),b[this]=[Number(c[0]),Number(c[1])]))}),a.validator.autoCreateRanges&&(null!=b.min&&null!=b.max&&(b.range=[b.min,b.max],delete b.min,delete b.max),null!=b.minlength&&null!=b.maxlength&&(b.rangelength=[b.minlength,b.maxlength],delete b.minlength,delete b.maxlength)),b},normalizeRule:function(b){if("string"==typeof b){var c={};a.each(b.split(/\s/),function(){c[this]=!0}),b=c}return b},addMethod:function(b,c,d){a.validator.methods[b]=c,a.validator.messages[b]=void 0!==d?d:a.validator.messages[b],c.length<3&&a.validator.addClassRules(b,a.validator.normalizeRule(b))},methods:{required:function(b,c,d){if(!this.depend(d,c))return"dependency-mismatch";if("select"===c.nodeName.toLowerCase()){var e=a(c).val();return e&&e.length>0}return this.checkable(c)?this.getLength(b,c)>0:a.trim(b).length>0},email:function(a,b){return this.optional(b)||/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(a)},url:function(a,b){return this.optional(b)||/^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(a)},date:function(a,b){return this.optional(b)||!/Invalid|NaN/.test(new Date(a).toString())},dateISO:function(a,b){return this.optional(b)||/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(a)},number:function(a,b){return this.optional(b)||/^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(a)},digits:function(a,b){return this.optional(b)||/^\d+$/.test(a)},creditcard:function(a,b){if(this.optional(b))return"dependency-mismatch";if(/[^0-9 \-]+/.test(a))return!1;var c,d,e=0,f=0,g=!1;if(a=a.replace(/\D/g,""),a.length<13||a.length>19)return!1;for(c=a.length-1;c>=0;c--)d=a.charAt(c),f=parseInt(d,10),g&&(f*=2)>9&&(f-=9),e+=f,g=!g;return e%10===0},minlength:function(b,c,d){var e=a.isArray(b)?b.length:this.getLength(b,c);return this.optional(c)||e>=d},maxlength:function(b,c,d){var e=a.isArray(b)?b.length:this.getLength(b,c);return this.optional(c)||d>=e},rangelength:function(b,c,d){var e=a.isArray(b)?b.length:this.getLength(b,c);return this.optional(c)||e>=d[0]&&e<=d[1]},min:function(a,b,c){return this.optional(b)||a>=c},max:function(a,b,c){return this.optional(b)||c>=a},range:function(a,b,c){return this.optional(b)||a>=c[0]&&a<=c[1]},equalTo:function(b,c,d){var e=a(d);return this.settings.onfocusout&&e.unbind(".validate-equalTo").bind("blur.validate-equalTo",function(){a(c).valid()}),b===e.val()},remote:function(b,c,d){if(this.optional(c))return"dependency-mismatch";var e,f,g=this.previousValue(c);return this.settings.messages[c.name]||(this.settings.messages[c.name]={}),g.originalMessage=this.settings.messages[c.name].remote,this.settings.messages[c.name].remote=g.message,d="string"==typeof d&&{url:d}||d,g.old===b?g.valid:(g.old=b,e=this,this.startRequest(c),f={},f[c.name]=b,a.ajax(a.extend(!0,{url:d,mode:"abort",port:"validate"+c.name,dataType:"json",data:f,context:e.currentForm,success:function(d){var f,h,i,j=d===!0||"true"===d;e.settings.messages[c.name].remote=g.originalMessage,j?(i=e.formSubmitted,e.prepareElement(c),e.formSubmitted=i,e.successList.push(c),delete e.invalid[c.name],e.showErrors()):(f={},h=d||e.defaultMessage(c,"remote"),f[c.name]=g.message=a.isFunction(h)?h(b):h,e.invalid[c.name]=!0,e.showErrors(f)),g.valid=j,e.stopRequest(c,j)}},d)),"pending")}}}),a.format=function(){throw"$.format has been deprecated. Please use $.validator.format instead."};var b,c={};a.ajaxPrefilter?a.ajaxPrefilter(function(a,b,d){var e=a.port;"abort"===a.mode&&(c[e]&&c[e].abort(),c[e]=d)}):(b=a.ajax,a.ajax=function(d){var e=("mode"in d?d:a.ajaxSettings).mode,f=("port"in d?d:a.ajaxSettings).port;return"abort"===e?(c[f]&&c[f].abort(),c[f]=b.apply(this,arguments),c[f]):b.apply(this,arguments)}),a.extend(a.fn,{validateDelegate:function(b,c,d){return this.bind(c,function(c){var e=a(c.target);return e.is(b)?d.apply(e,arguments):void 0})}})});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file jquery.validate.min.js'); }

// file jquery.validate.min.js end

// file mailchimp-widget-min.js start

try { 
(function(a){a.fn.ns_mc_widget=function(b){var e,c,d;e={url:"/",cookie_id:false,cookie_value:""};d=jQuery.extend(e,b);c=a(this);c.submit(function(){var f;f=jQuery("<div></div>");f.css({"background-image":"url("+d.loader_graphic+")","background-position":"center center","background-repeat":"no-repeat",height:"100%",left:"0",position:"absolute",top:"0",width:"100%","z-index":"100"});c.css({height:"100%",position:"relative",width:"100%"});c.children().hide();c.append(f);a.getJSON(d.url,c.serialize(),function(h,k){var j,g,i;if("success"===k){if(true===h.success){i=jQuery("<p>"+h.success_message+"</p>");i.hide();c.fadeTo(400,0,function(){c.html(i);i.show();c.fadeTo(400,1)});if(false!==d.cookie_id){j=new Date();j.setTime(j.getTime()+"3153600000");document.cookie=d.cookie_id+"="+d.cookie_value+"; expires="+j.toGMTString()+";"}}else{g=jQuery(".error",c);if(0===g.length){f.remove();c.children().show();g=jQuery('<div class="error"></div>');g.prependTo(c)}else{f.remove();c.children().show()}g.html(h.error)}}return false});return false})}}(jQuery));
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file mailchimp-widget-min.js'); }

// file mailchimp-widget-min.js end

// file main.js start

try { 
core.addWidgetClass({'class' : 'Main', 'definition' : function($) {
		
	var that = this,
		scrollWidth;

	this.defaults = {
		'responsiveWidth' : 768,
		'padding'  : 121,
		'sound' : '',
		'soundOgg' : '',
		'accentSound' : '',
		'accentSoundOgg' : ''
	};
	
	this.init = function() {
		scrollWidth = getScrollbarWidth();
		$("body").addClass(core.touch ? "touch_device" : "non_touch_device");

		addHendlers();

		core.sound ? $('.sound_icon').addClass('music_on') : $('.sound_icon').removeClass('music_on');
		
		/*show_feedback();*/
		socialIcon();

		add_wrap();

		updateCatWidget();
		
		if(core.browser.isIE()){
			fixWidgetInputsIE();
		}
		
	};
	
	var addHendlers = function() {
		core.dispatcher.addEventlistener('window_resize', that, function(responsive) {
			fixHeight(responsive);
			$("header").find(".logo img").load(function() {
				fixHeight(responsive);
			});
		});
		core.dispatcher.addEventlistener('sidebar_open', that, function() {
			var testimonialsSidebar = core.getWidget('sidebar_testimonials');
			if(testimonialsSidebar) { testimonialsSidebar.next();testimonialsSidebar.next(); }
		});
		core.dispatcher.addEventlistener('post_open', that, function() {
			var testimonialsShortcode = core.getWidget('shortcode_testimonials');
			if(testimonialsShortcode) { testimonialsShortcode.next();testimonialsShortcode.next(); }
		});
		core.dispatcher.addEventlistener('theme-init', that, function() {
			setTimeout(function(){
				var testimonialsShortcode = core.getWidget('shortcode_testimonials');
				if(testimonialsShortcode) { testimonialsShortcode.next();testimonialsShortcode.next(); }
			}, 850);
			
		});
		// if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
		// 	$(".main_menu").bind('touchstart', function(){
		// 		$(this).addClass('ihover');
		// 	});
		// 	$(".main_menu").bind('touchend', function(){
		// 		$(this).removeClass('ihover');
		// 	});
		// }
		
		core.dispatcher.addEventlistener('theme-init', that, function() {
			btn_animation();
			this.playBGmusic({'mp3': that.sound, 'ogg': that.soundOgg});
			var w = $(window).width(),
				h = $(window).height();

			core.dispatcher.fire('window_resize', w <= that.responsiveWidth, w, h, true);
			
			/* Retina
			*******************************/
			jQuery(window).on("load", function() {
				if (core.retina) {
					jQuery('img.retina').each(function(){
						var file_ext = jQuery(this).attr('src').split('.').pop();
						jQuery(this)
							.width(jQuery(this).width())
							.height(jQuery(this).height())
							.attr('src',jQuery(this).attr('src').replace("."+file_ext,"_2x."+file_ext));
					});
					
						jQuery('img[data-retina^="http"]').each(function(){
							if(jQuery(this).data('retina') !='') {
								
									jQuery(this).css({"max-height":jQuery(this).height(),"max-width":jQuery(this).width()});
								
								jQuery(this).attr('src', jQuery(this).data('retina'));
							}
						});
					
				}
				
				jQuery(window).scroll();
			});
			
			$('.social_links, .nav_btn, .close_btn, .f_menu li, .show_thumb, #commentform input#submit, button[type="submit"], #searchsubmit, .navigation a, .thumb_list a').on('mouseenter', function() {
				that.play({'mp3': that.accentSound, 'ogg': that.accentSoundOgg});
			});
		});
		
		$(window).resize(function() {
			var h = $(window).height(),
				w = $(window).width() + ($(document).height() > h ? scrollWidth : 0);
			core.dispatcher.fire('window_resize', w <= that.responsiveWidth, w, h, false);
		});
		
		$('.sound_icon').click(function() {
			if(core.sound) {
				$(this).removeClass('music_on');
				that.musicOff();
			} else {
				$(this).addClass('music_on');
				that.musicOn({'mp3': that.sound, 'ogg': that.soundOgg});
			}
			core.cookie.set('sound', core.sound ? 'on' : 'off');
		});
		
		core.dispatcher.addEventlistener('play-content-media', that, function(){
			this.musicOff();
		});
		core.dispatcher.addEventlistener('pause-content-media', that, function(){
			this.musicOn();
		});
		
		
	};
	
	var fixHeight = function(responsive) {
		setTimeout(function(){
			var sliderH = $("#slider_box .map").outerHeight(true);
			sliderH = sliderH || $("#slider_box").is(':visible') ? $("#slider_box").outerHeight(true) : 0;
	
			var delta = 0;
			if(responsive){
				delta = $('.main_menu').outerHeight(true);
				if ($('body').hasClass('page-template-template-menu-php')) {
					delta = 0;
				} else if (!$('body').hasClass('template-carousel')) {
					delta = $('.main_menu').outerHeight(true) + sliderH;
				}
			} else {
				delta = that.padding;
			}
			var height = $(window).height() - $("header").outerHeight(true) - $("footer").outerHeight(true) - delta,
				carouselHeight = $(".carousel_list").height();
				if(carouselHeight){
					carouselHeight -= that.padding;
					height = (height >= carouselHeight) ? height : carouselHeight;
				}
			$("#content").css("min-height", height);
			$("body").addClass('show_blocks');
			core.dispatcher.fire('content_set_height', $(window).width() <= that.responsiveWidth, height);
		}, 700);
    };
	
	
	var fixWidgetInputsIE = function() {

		
		var $placeholder = $("input[placeholder], textarea[placeholder]"),
			count = $placeholder.length,
			e,
			f = "placeholder";

		while(count--) {
			$placeholder[count].value = $placeholder[count].value ? $placeholder[count].value : $placeholder.eq(count).addClass(f).attr("placeholder"),

			$placeholder.eq(count)
				.focus(function(){
					this.value==$(this).attr("placeholder")&&($(this).removeClass(f),this.value="")
				}).blur(function(){
					this.value==""&&($(this).addClass(f),this.value=$(this).attr("placeholder"))
				}),

			function(b){
				$(b.form).bind("submit",function(){
					b.value==$(b).attr("placeholder")&&(b.value="")
				})
			}($placeholder[count])
		}
	}

    /*var show_feedback = function() {
    	$(".feedback_show, .close_btn").click(function() {
    		$(".feedback").slideToggle("slow");
    		$(".close_btn").addClass("btn_show");
    		$(".feedback_show").toggleClass("hide");
    	})	;
    };*/
	
	var socialIcon = function() {
		$(".widget_social_links a").append("<span></span>");
	};

	var btn_animation = function(){
		var $buttons = $(".nav_btn, .navigation a, .close_btn, .sub_wrap, .btn_small, .btn_middle, .btn_large");
		if(core.touch) {
			$buttons.live({
			    touchstart: function(){startRolover(this);},
			    touchend: function(){endRolover(this);}
			});
		} else {
			$buttons.live({
			    mouseenter: function(){startRolover(this);},
			    mouseleave: function(){endRolover(this);}
			});
		}
		var startRolover = function(ctx) {
			$(ctx).removeClass("roll_out");
			$(ctx).addClass("roll_in");
		};
		var endRolover = function(ctx) {
			$(ctx).addClass("roll_out");
			$(ctx).removeClass("roll_in");
			setTimeout(function(){
				$buttons.removeClass("roll_out");
			}, 150);
		};
	};

	var	add_wrap = function(){
		$("input.button,#commentform #submit, .widget-area button, .content_btn").wrap('<div class="p_rel wrapper d_in-block sub_wrap"></div>');	
	};

	var updateCatWidget = function() {
		$('.widget_categories, .widget_archive').each(function(){
			$(this).find('li').each(function(){
				var $a = $(this).find('a');
				$(this).find('a').remove();
				var str = $(this).text();
				$(this).empty();
				$a.html($a.html() + str).appendTo($(this));
			});
		});
	};
	
	var getScrollbarWidth = function() {
	    var $inner = jQuery('<div style="width: 100%; height:200px;">test</div>'),
	        $outer = jQuery('<div style="width:200px;height:150px; position: absolute; top: 0; left: 0; visibility: hidden; overflow:hidden;"></div>').append($inner),
	        inner = $inner[0],
	        outer = $outer[0];
	     
	    jQuery('body').append(outer);
	    var width1 = inner.offsetWidth;
	    $outer.css('overflow', 'scroll');
	    var width2 = outer.clientWidth;
	    $outer.remove();
	    return (width1 - width2);
	};
	
	
	var playerCurrentlyPlaying = null;
function chain(){       
    $('.posts_list').each(function(){
        var player_id = $(this).children('iframe').attr("id");
        player = new YT.Player( player_id, { 
            events:
                {      
                'onStateChange': function (event) 
                    {

                    if (event.data == YT.PlayerState.PLAYING) 
                        { 
                          if(playerCurrentlyPlaying != null && 
                          playerCurrentlyPlaying != player_id)
                          callPlayer( playerCurrentlyPlaying , 'pauseVideo' );
                          playerCurrentlyPlaying = player_id;

                        }            

                    }
                }        
        });
    });
}


}});
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file main.js'); }

// file main.js end

// file makisu.js start

try { 

/**
 * Copyright (C) 2012 by Justin Windle
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

(function($) {

    // Global initialisation flag
    var initialized = false;

    // For detecting browser prefix and capabilities
    var el = document.createElement( 'div' );
    var re = /^(Moz|(w|W)ebkit|O|ms)(?=[A-Z])/;

    // Establish vendor prefix and CSS 3D support
    var vendor = (function() { for ( var p in el.style ) if( re.test(p) ) return p.match(re)[0]; })() || '';
    var canRun = vendor + 'Perspective' in el.style;
    var prefix = '-' + vendor.toLowerCase() + '-';

    var $this, $root, $base, $kids, $node, $item, $over, $back;
    var wait, anim, last;

    // Public API
    var api = {

        // Toggle open / closed
        toggle: function() {

            $this = $( this );
            $this.makisu( $this.hasClass( 'open' ) ? 'close' : 'open' );
        },

        // Trigger the unfold animation
        open: function( speed, overlap, easing ) {

            // Cache DOM references
            $this = $(this);
            $root = $this.find( '.root' );
            $kids = $this.find( '.node' ).not( $root );

            // Establish values or fallbacks
            speed = utils.resolve( $this, 'speed', speed );
            easing = utils.resolve( $this, 'easing', easing );
            overlap = utils.resolve( $this, 'overlap', overlap );

            $kids.each( function( index, el ) {

                // Establish settings for this iteration
                anim = 'unfold' + ( !index ? '-first' : '' );
                last = index === $kids.length - 1;
                time = speed * ( 1 - overlap );
                wait = index * time;

                // Cache DOM references
                $item = $( el );
                $over = $item.find( '.over' );

                // Element animation
                $item.css(utils.prefix({
                    'transform': 'rotateX(180deg)',
                    'animation': anim + ' ' + speed + 's ' + easing + ' ' + wait + 's 1 normal forwards'
                }));

                // Shading animation happens when the next item starts
                if ( !last ) wait = ( index + 1 ) * time;

                // Shading animation
                $over.css(utils.prefix({
                    'animation': 'unfold-over ' + (speed * 0.45) + 's ' + easing + ' ' + wait + 's 1 normal forwards'
                }));
            });

            // Add momentum to the container
            $root.css(utils.prefix({
                'animation': 'swing-out ' + ( $kids.length * time * 1.4 ) + 's ease-in-out 0s 1 normal forwards'
            }));

            $this.addClass( 'open' );
        },

        // Trigger the fold animation
        close: function( speed, overlap, easing ) {

            // Cache DOM references
            $this = $(this);
            $root = $this.find( '.root' );
            $kids = $this.find( '.node' ).not( $root );

            // Establish values or fallbacks
            speed = utils.resolve( $this, 'speed', speed ) * 0.66;
            easing = utils.resolve( $this, 'easing', easing );
            overlap = utils.resolve( $this, 'overlap', overlap );

            $kids.each( function( index, el ) {

                // Establish settings for this iteration
                anim = 'fold' + ( !index ? '-first' : '' );
                last = index === 0;
                time = speed * ( 1 - overlap );
                wait = ( $kids.length - index - 1 ) * time;

                // Cache DOM references
                $item = $( el );
                $over = $item.find( '.over' );

                // Element animation
                $item.css(utils.prefix({
                    'transform': 'rotateX(0deg)',
                    'animation': anim + ' ' + speed + 's ' + easing + ' ' + wait + 's 1 normal forwards'
                }));

                // Adjust delay for shading
                if ( !last ) wait = ( ( $kids.length - index - 2 ) * time ) + ( speed * 0.35 );

                // Shading animation
                $over.css(utils.prefix({
                    'animation': 'fold-over ' + (speed * 0.45) + 's ' + easing + ' ' + wait + 's 1 normal forwards'
                }));
            });

            // Add momentum to the container
            $root.css(utils.prefix({
                'animation': 'swing-in ' + ( $kids.length * time * 1.0 ) + 's ease-in-out 0s 1 normal forwards'
            }));

            $this.removeClass( 'open' );
        }
    };

    // Utils
    var utils = {

        // Resolves argument values to defaults
        resolve: function( $el, key, val ) {
            return typeof val === 'undefined' ? $el.data( key ) : val;
        },

        // Prefixes a hash of styles with the current vendor
        prefix: function( style ) {
            
            for ( var key in style ) {
                style[ prefix + key ] = style[ key ];
            }

            return style;
        },

        // Inserts rules into the document styles
        inject: function( rule ) {

            try {

                var style = document.createElement( 'style' );
                style.innerHTML = rule;
                document.getElementsByTagName( 'head' )[0].appendChild( style );

            } catch ( error ) {}
        }
    };

    // Element templates
    var markup = {
        node: '<span class="node"/>',
        back: '<span class="face back"/>',
        over: '<span class="face over"/>'
    };

    // Plugin definition
    $.fn.makisu = function( options ) {

        // Notify if 3D isn't available
        if ( !canRun ) {

            var message = 'Failed to detect CSS 3D support';

            if( console && console.warn ) {
                
                // Print warning to the console
                console.warn( message );

                // Trigger errors on elements
                this.each( function() {
                    $( this ).trigger( 'error', message );
                });
            }

            return;
        }

        // Fires only once
        if ( !initialized ) {

            initialized = true;

            // Unfold
            utils.inject( '@' + prefix + 'keyframes unfold        {' +

                '0%   {' + prefix + 'transform: rotateX(180deg);  }' +
                '50%  {' + prefix + 'transform: rotateX(-30deg);  }' +
                '100% {' + prefix + 'transform: rotateX(0deg);    }' +

                '}');

            // Unfold (first item)
            utils.inject( '@' + prefix + 'keyframes unfold-first  {' +

                '0%   {' + prefix + 'transform: rotateX(-90deg);  }' +
                '50%  {' + prefix + 'transform: rotateX(60deg);   }' +
                '100% {' + prefix + 'transform: rotateX(0deg);    }' +

                '}');

            // Fold
            utils.inject( '@' + prefix + 'keyframes fold          {' +

                '0%   {' + prefix + 'transform: rotateX(0deg);    }' +
                '100% {' + prefix + 'transform: rotateX(180deg);  }' +

                '}');

            // Fold (first item)
            utils.inject( '@' + prefix + 'keyframes fold-first    {' +

                '0%   {' + prefix + 'transform: rotateX(0deg);    }' +
                '100% {' + prefix + 'transform: rotateX(-180deg); }' +

                '}');

            // Swing out
            utils.inject( '@' + prefix + 'keyframes swing-out     {' +

                '0%   {' + prefix + 'transform: rotateX(0deg);    }' +
                '30%  {' + prefix + 'transform: rotateX(-30deg);  }' +
                '60%  {' + prefix + 'transform: rotateX(15deg);   }' +
                '100% {' + prefix + 'transform: rotateX(0deg);    }' +

                '}');

            // Swing in
            utils.inject( '@' + prefix + 'keyframes swing-in      {' +

                '0%   {' + prefix + 'transform: rotateX(0deg);    }' +
                '50%  {' + prefix + 'transform: rotateX(-10deg);  }' +
                '90%  {' + prefix + 'transform: rotateX(15deg);   }' +
                '100% {' + prefix + 'transform: rotateX(0deg);    }' +

                '}');

            // Shading (unfold)
            utils.inject( '@' + prefix + 'keyframes unfold-over   {' +
                '0%   { opacity: 1.0; }' +
                '100% { opacity: 0.0; }' +
                '}');

            // Shading (fold)
            utils.inject( '@' + prefix + 'keyframes fold-over     {' +
                '0%   { opacity: 0.0; }' +
                '100% { opacity: 1.0; }' +
                '}');

            // Node styles
            utils.inject( '.node {' +
                'position: relative;' +
                'display: block;' +
                '}');

            // Face styles
            utils.inject( '.face {' +
                'pointer-events: none;' +
                'position: absolute;' +
                'display: block;' +
                'height: 100%;' +
                'width: 100%;' +
                'left: 0;' +
                'top: 0;' +
                '}');
        }

        // Merge options & defaults
        var opts = $.extend( {}, $.fn.makisu.defaults, options );

        // Extract api method arguments
        var args = Array.prototype.slice.call( arguments, 1 );

        // Main plugin loop
        return this.each( function () {

            // If the user is calling a method...
            if ( api[ options ] ) {
                return api[ options ].apply( this, args );
            }

            // Store options in view
            $this = $( this ).data( opts );

            // Only proceed if the scene hierarchy isn't already built
            if ( !$this.data( 'initialized' ) ) {

                $this.data( 'initialized', true );

                // Select the first level of matching child elements
                $kids = $this.children( opts.selector );

                // Build a scene graph for elements
                $root = $( markup.node ).addClass( 'root' );
                $base = $root;
                
                // Process each element and insert into hierarchy
                $kids.each( function( index, el ) {

                    $item = $( el );

                    // Which animation should this node use?
                    anim = 'fold' + ( !index ? '-first' : '' );

                    // Since we're adding absolutely positioned children
                    $item.css( 'position', 'relative' );

                    // Give the item some depth to avoid clipping artefacts
                    $item.css(utils.prefix({
                        'transform-style': 'preserve-3d',
                        'transform': 'translateZ(-0.1px)'
                    }));

                    // Create back face
                    $back = $( markup.back );
                    $back.css( 'background', $item.css( 'background' ) );
                    $back.css(utils.prefix({ 'transform': 'translateZ(-0.1px)' }));

                    // Create shading
                    $over = $( markup.over );
                    $over.css(utils.prefix({ 'transform': 'translateZ(0.1px)' }));
                    $over.css({
                        'background': opts.shading,
                        'opacity': 0.0
                    });
                    
                    // Begin folded
                    $node = $( markup.node ).append( $item );
                    $node.css(utils.prefix({
                        'transform-origin': '50% 0%',
                        'transform-style': 'preserve-3d',
                        'animation': anim + ' 1ms linear 0s 1 normal forwards'
                    }));

                    // Build display list
                    $item.append( $over );
                    $item.append( $back );
                    $base.append( $node );

                    // Use as parent in next iteration
                    $base = $node;
                });

                // Set root transform settings
                $root.css(utils.prefix({
                    'transform-origin': '50% 0%',
                    'transform-style': 'preserve-3d'
                }));

                // Apply perspective
                $this.css(utils.prefix({
                    'transform': 'perspective(' + opts.perspective + 'px)'
                }));

                // Display the scene
                $this.append( $root );
            }
        });
    };

    // Default options
    $.fn.makisu.defaults = {

        // Perspective to apply to rotating elements
        perspective: 1200,

        // Default shading to apply (null => no shading)
        shading: 'rgba(0,0,0,0.12)',

        // Area of rotation (fraction or pixel value)
        selector: null,

        // Fraction of speed (0-1)
        overlap: 0.6,

        // Duration per element
        speed: 0.8,

        // Animation curve
        easing: 'ease-in-out'
    };

    $.fn.makisu.enabled = canRun;

})( jQuery );
} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file makisu.js'); }

// file makisu.js end

