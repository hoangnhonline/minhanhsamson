(function($, undefined) {

	var Gmap = function() {

		var $contextMenu,
				$container = $('#mapAdmin'),
				$markers_container = $('#markers_container'),
				map,
				searchBox,
				iw,
				startData,
				markers = [],
				mapData;

		this.init = function() {
			google.maps.event.addDomListener(window, 'load', addHendlers);
		};

		var createMap = function() {

			mapData = {
				zoom: parseInt($markers_container.find('.map_zoom').val()),
				scrollwheel: true,
				center: new google.maps.LatLng(parseFloat($markers_container.find('.map_lat').val()),parseFloat($markers_container.find('.map_lng').val())),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			map = new google.maps.Map($container[0], mapData);
			google.maps.event.addListener(map, 'dblclick', function(e) {
				createMarker(e.latLng.lat(), e.latLng.lng());
			});
			startData = getDomMarkers();

			createContextMenu();
			createSearchBox();
			drawMarkers(startData);
			if (markers.length) {
//				centerMap(markers);
			}

			google.maps.event.addListener(map, 'center_changed', function(e) {
				var NewMapCenter = map.getCenter();
				$markers_container.find('.map_lat').val(NewMapCenter.lat());
				$markers_container.find('.map_lng').val(NewMapCenter.lng());
			});

			google.maps.event.addListener(map, 'zoom_changed', function(e) {
				$markers_container.find('.map_zoom').val(map.getZoom());
			});

		};

		var createSearchBox = function() {
			var input = document.getElementById('target');
			$(input).keydown(function(e) {
				if (e.keyCode === 13) {
					e.preventDefault();
					return false;
				}
			});
			searchBox = new google.maps.places.SearchBox(input);

			google.maps.event.addListener(searchBox, 'places_changed', function() {
				var places = this.getPlaces();
				var bounds = new google.maps.LatLngBounds();
				for (var i = 0, place; place = places[i]; i++) {
					createMarker(place.geometry.location.lat(), place.geometry.location.lng(), place.formatted_address);
					bounds.extend(place.geometry.location);
				}
				map.fitBounds(bounds);
			});
		};

//		var centerMap = function(markers) {
//			var bounds = new google.maps.LatLngBounds();
//			for(var i in markers){
//				bounds.extend(markers[i].getPosition());
//			}
//			map.fitBounds(bounds);
//			google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
//				if (this.getZoom() > 12 ){ this.setZoom(10); }
//			});
//		};

		var addHendlers = function() {

			$('.search_on_map').live('click', function() {
				log(searchBox.getPlaces());
				google.maps.event.trigger(searchBox, 'places_changed');
			});
			$('.updateInfo, .deleteMarker').live('click', function(e) {
				e.preventDefault();
				$contextMenu.hide();
				var m = markers[$(this).closest('.marker-data').data('markerid')];
				($(this).hasClass('deleteMarker'))
						? deleteMarker(m.id)
						: updateInfo(m.position.lat(), m.position.lng(), m.title, m.description, m.id);
			});
			$('.saveInfo').live('click', function(e) {
				var id = $(this).data('markerid'),
						title = $(this).parent().find('.marker_title').val(),
						description = $(this).parent().find('.marker_desc').val();
				markers[id].title = title;
				markers[id].description = description;
				$('#marker_' + id).find('.title').val(title);
				$('#marker_' + id).find('.description').val(description);
				iw.close();
			});
			$('#create_map').click(function() {
				$('.map_info').show();
				createMap();
			});

		};

		var getDomMarkers = function() {
			var res = {};
			$markers_container.find('.marker-data').each(function() {
				res[$(this).data('markerid')] = {
					'latitude': $(this).find('.latitude').val(),
					'longitude': $(this).find('.longitude').val(),
					'title': $(this).find('.title').val(),
					'description': $(this).find('.description').val()
				};
			});
			return res;
		};

		var createContextMenu = function() {
			$contextMenu = $('<ul>', {'id': 'gmapsContextMenu', 'class': 'marker-data', 'html': '<li><a href="#" class="deleteMarker">Delete</a></li><li><a href="#" class="updateInfo">Update Info</a></li>'});
			$contextMenu.bind('contextmenu', function() {
				return false;
			});
			$(map.getDiv()).append($contextMenu);
		};

		var drawMarkers = function(markers) {
			for (var i in markers) {
				createMarker(markers[i].latitude, markers[i].longitude, markers[i].title, markers[i].description, i);
			}
		};

		var createMarker = function(latitude, longitude, title, description, id) {

			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(latitude, longitude),
				map: map,
				draggable: true
			});
			
			var filedId = $('.map_info').attr('id');
			
			if (!id) {
				marker.id = Object.keys(markers).reverse()[0];
				if (isNaN(marker.id)) {
					marker.id = 0;
				}
				marker.id++;
				$markers_container.append(
						'<div class="marker-data" data-markerid="' + marker.id + '" id="marker_' + marker.id + '">' +
						'<input name="'+filedId+'[markers][' + marker.id + '][latitude]" type="hidden" value="' + latitude + '" class="latitude" />' +
						'<input name="'+filedId+'[markers][' + marker.id + '][longitude]" type="hidden" value="' + longitude + '" class="longitude" />' +
						'<input name="'+filedId+'[markers][' + marker.id + '][title]" type="text" value="' + (title || '') + '" class="title" readonly />' +
						'<input name="'+filedId+'[markers][' + marker.id + '][description]" type="hidden" value="' + (description || '') + '" class="description" />' +
						'<input type="button" value="edit" class="updateInfo" />' +
						'<input type="button" value="delete" class="deleteMarker" />' +
						'</div>'
						);
			} else {
				marker.id = id;
			}
			marker.title = title;
			marker.description = description;

			markers[marker.id] = marker;

			google.maps.event.addListener(marker, 'dblclick', function(e) {
				var m = markers[this.id];
				updateInfo(m.position.lat(), m.position.lng(), m.title, m.description, this.id);
			});
			google.maps.event.addListener(marker, 'dragend', function(e) {
				$('#marker_' + this.id).find('.latitude').val(e.latLng.lat());
				$('#marker_' + this.id).find('.longitude').val(e.latLng.lng());
			});
			google.maps.event.addListener(marker, 'rightclick', function(e) {

				var marker = this;
				$contextMenu.data('markerid', marker.id);
				var scale = Math.pow(2, map.getZoom());
				var nw = new google.maps.LatLng(
						map.getBounds().getNorthEast().lat(),
						map.getBounds().getSouthWest().lng()
						);
				var worldCoordinateNW = map.getProjection().fromLatLngToPoint(nw);
				var worldCoordinate = map.getProjection().fromLatLngToPoint(e.latLng);
				var position = new google.maps.Point(
						Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
						Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
						);

				var mapDiv = $(map.getDiv()),
						x = position.x,
						y = position.y;

				// adjust if clicked to close to the edge of the map
				if (x > mapDiv.width() - $contextMenu.width())
					x -= $contextMenu.width();
				if (y > mapDiv.height() - $contextMenu.height())
					y -= $contextMenu.height();

				$contextMenu.css({top: y, left: x}).fadeIn(100);



			});
		};

		var deleteMarker = function(id) {
			$('#marker_' + id).remove();
			markers[id].setMap(null);
			delete markers[id];
		};

		var updateInfo = function(latitude, longitude, title, description, id) {
			iw = new google.maps.InfoWindow();
			iw.setContent('title: <input value="' + (title || '') + '" class="marker_title"><br>' +
					'description: <textarea class="marker_desc">' + (description || '') + '</textarea><br>' +
					'<a class="saveInfo" data-markerid="' + id + '" >save</a>');
			iw.setPosition(new google.maps.LatLng(latitude, longitude));
			iw.open(map);
		};
	};

	var gmap = new Gmap();
	gmap.init();

})(jQuery);
