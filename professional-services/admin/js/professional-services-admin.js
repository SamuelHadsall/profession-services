(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function () {
		var plugin_path = wp_js.pluginsUrl;
		var $metaBox = $('.ps-meta-box');
		var $fileUpload = $('.file-upload');
		var $fileUploaded = $('.file-uploaded');
		var $locations = $('.js-locations');
		var $industries = $('.js-industries');
		var $addVideos = $('.js-videos');
		var $embedModal = $('.embed-modal');
		var $cloneDocument = ('.document-uploaded-clone');
		var $cloneVideo = $('.video-uploaded-clone');
		var $clients = $('.js-clients');
		var $postTitle = $('.js-post-title');
		var $keyListPointButton = $('.js-add-bullet-point');
		var $keyListPoint = $('.ps-list-bullet-point');
		var $bulletPointModal = $('.bullet-point-modal');
		var $bulletListClone = $('.ui.list .item-clone');
		var $articleDate = $('.js-article-date');
		var $awardsDate = $('.js-awards-date-input');
		var $selectOptions = $('.js-select');
		var $countries = $('.js-country');
		var $states = $('.js-state');
		var $cities = $('.js-city');
		var $removeButton;
		var $bulletAdded;
		var $bulletPoints = [];
		var $bullListContainer;
		var $videoUploaded;
		var $embedContainer;
		var ps_media = null;

		console.log(wp);

		function formatDate(date) {
			var year = date.getFullYear().toString();
			var month = (date.getMonth() + 101).toString().substring(1);
			var day = (date.getDate() + 100).toString().substring(1);
			return month + '/' + day + '/' + year;
		}

		function wp_media_uploader(e) {
			e.preventDefault();

			var self = this;
			// Extend the wp.media object
			ps_media = wp.media.frames.file_frame = wp.media({
				title: $(self).closest('.meta-options').find('> label').text(),
				button: {
					text: 'select ' + $(self).closest('.meta-options').find('> label').text()
				}, multiple: false
			});

			//console.log(ps_media);

			ps_media.off('select');
			// When a file is selected, grab the URL and set it as the text field's value
			ps_media.on('select', function () {
				wp_set_image(self)
			});
			// Open the upload dialog
			ps_media.open();
		}

		function wp_document_uploader(e) {
			e.preventDefault();

			var self = this;
			// Extend the wp.media object
			ps_media = wp.media.frames.file_frame = wp.media({
				title: $(self).text(),
				button: {
					text: $(self).text()
				}, multiple: false
			});

			console.log(ps_media);

			ps_media.off('select');
			// When a file is selected, grab the URL and set it as the text field's value
			ps_media.on('select', function () {
				var attachment = ps_media.state().get('selection').first().toJSON();
				var $uploaded = $(self).closest('.segment').nextAll('.ps-meta-slides');

				$uploaded.find($cloneDocument).clone().insertBefore($cloneDocument).removeClass('document-uploaded-clone hidden').addClass('document-uploaded');

				var $document = $(self).closest('.segment').next('.ps-meta-slides').find('> .document-uploaded-clone').prev();
				var $docCount = $(self).prev('.ui.header').find('span.doc-count');

				$('<input type="hidden" name="ps-document[]" value="' + attachment.url + '" class="icon-img" />').appendTo($document);

				var $imageVal = $document.find('.icon-img');

				switch(attachment.mime) {
					case 'image/jpeg':
					case 'image/png':
						$('<img src="' + plugin_path + 'includes/assets/imgs/file-image-solid.svg" class="img-fluid ps-image icon" />').insertBefore($imageVal);
					break;
					case 'image/bmp':
					case "image/gif" :
						$('<img src="' + plugin_path + 'includes/assets/imgs/file-image-solid.svg" class="img-fluid ps-image icon" />').insertBefore($imageVal);
					break;
					case 'pdf':
						$('<img src="' + plugin_path + 'includes/assets/imgs/file-pdf-solid.svg" class="img-fluid ps-image icon" />').insertBefore($imageVal);
					break;
					case 'doc':
					case 'docx':
						$('<img src="' + plugin_path + 'includes/assets/imgs/file-word-solid.svg" class="img-fluid ps-image icon" />').insertBefore($imageVal);
					break;
					default:
						$('<img src="' + plugin_path + 'includes/assets/imgs/file-alt-solid.svg" class="img-fluid ps-image icon" />').insertBefore($imageVal);
				}

				if ($docCount.length) {
					var Count = parseInt($docCount.text());

					$docCount.text(Count + 1);
				}
			});
			// Open the upload dialog
			ps_media.open();
		}

		function wp_set_image(file) {
			var attachment = ps_media.state().get('selection').first().toJSON();
			var $uploaded = $(file).closest($fileUpload).prev('.file-uploaded');
			var $img = $(file).closest($fileUpload).prev('.file-uploaded').find('.ps-image');
			var $imageVal = $(file).closest($fileUpload).prev('.file-uploaded').find('.icon-img');
			var $imgAdded = $(file).closest($fileUpload);

			$imageVal.val(attachment.id);
			$img.attr("src", attachment.url);
			$uploaded.removeClass('hidden');
			$imgAdded.addClass('hidden');
		}

		function YouTubeGetID(url){
			url = url.split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
			return (url[2] !== undefined) ? url[2].split(/[^0-9a-z_\-]/i)[0] : url[0];
		}

		$fileUpload.on('click', '.add-file', wp_media_uploader);

		$fileUploaded.on('click', 'a', function () {
			var $this = $(this);

			$this.next('img').attr('src', '');
			$this.siblings('.icon-img').attr('value', '');
			$this.parent().addClass('hidden');
			$this.parent().next().removeClass('hidden');
		});

		$fileUpload.on('click', '.add-documents', wp_document_uploader);

		$('.ui.checkbox').checkbox({
			onChecked: function () {
				var $this = $(this);
				$this.closest('.meta-options').prev().addClass('hidden');
				$this.closest('.field').prev('.is-gravitar').removeClass('hidden');
			},
			onUnchecked: function () {
				var $this = $(this);
				$this.closest('.meta-options').prev().removeClass('hidden');
				$this.closest('.field').prev('.is-gravitar').addClass('hidden');
			}
		});

		$('.ui.menu .item').tab();

		$clients.select2();

		$('.js-first-name').keyup(function () {
			$postTitle.val($(this).val());
		});

		if ($.trim($('.js-first-name').val()).length !== 0) {
			$('.js-last-name').keyup(function () {
				$postTitle.val($('.js-first-name').val() + ' ' + $(this).val());
			});
		}

		$articleDate.datepicker({
			onSelect: function (dateStr) {
				var datePicked = $(this).datepicker('getDate');

				console.log(formatDate(new Date(datePicked)));
			}
		});

		$awardsDate.datepicker({
			onClose: function (dateStr) {
				var $this = $(this);
				var datePicked = $this.datepicker('getDate');

				console.log($this);

				$this.val(formatDate(new Date(datePicked))).attr('value', formatDate(new Date(datePicked)));
			}
		});

		if ($selectOptions.length) {	
			$selectOptions.select2({
				allowClear: true,
				width: 'resolve',
				theme: "classic"
			});

			var $clear = $selectOptions.next('.select2-container').find('.select2-selection__clear');

			$clear.each(function() {
				var $this = $(this);

				$this.on('click', function() {
					$selectOptions = $this.closest('.select2-container').prev('.js-select');

					$selectOptions.val(null).trigger('change');
				});
			});
		}

		if ($countries) {
			var is_country_saved = $countries.next('span').text();
			var is_state_saved = $states.next('span').text();
			var is_city_saved = $cities.next('span').text();

			$.ajax({            
				type: 'GET',
				dataType: 'json',
				url: 'https://api.countrystatecity.in/v1/countries',
				headers: { 'X-CSCAPI-KEY': '' },
				success: function (response) {
					$.each(response, function(index, item) {
						var country_code = item.iso2;
						var country_name = item.name;

						$('<option ' + ( is_country_saved === country_code ? 'selected' : '' ) + ' id="' + index + '" value="' + country_code + '">' + country_name + '</option>').appendTo($countries);
						
					});
				}
			});		
			
			$.ajax({            
				type: 'GET',
				dataType: 'json',
				url: 'https://api.countrystatecity.in/v1/states',
				headers: { 'X-CSCAPI-KEY': 'Sm5WN1F6eGl5MkVZT1BuTjFtODNncGdUelFGdlZ4OUNPVmY2QTVPag==' },
				success: function (response) {
					$.each(response, function(index, item) {
						var state_code = item.iso2;							
						var state_name = item.name;

						if (is_country_saved == item.country_code) {
							$('<option ' + ( is_state_saved === state_code ? 'selected' : '' ) + '  id="' + index + '" value="' + state_code + '">' + state_name + '</option>').appendTo($states);
						}

						if (is_state_saved == state_code) {
							$states.prop('disabled', false);
						}
					});
				}
			});

			if (is_country_saved.length && is_state_saved.length > 0) {
				$.ajax({            
					type: 'GET',
					dataType: 'json',
					url: 'https://api.countrystatecity.in/v1/countries/'+is_country_saved+'/states/'+is_state_saved+'/cities',
					headers: { 'X-CSCAPI-KEY': 'Sm5WN1F6eGl5MkVZT1BuTjFtODNncGdUelFGdlZ4OUNPVmY2QTVPag==' },
					success: function (response) {
						$.each(response, function(index, item) {												
							var city_name = item.name;	
							
							if (is_city_saved == city_name) {
								$('<option ' + ( is_city_saved === city_name ? 'selected' : '' ) + ' id="' + index + '" value="' + city_name + '">' + city_name + '</option>').appendTo($cities);
								$cities.prop('disabled', false);
							}
						});
					}
				});
			}			

			$countries.on('change', function() {
				var $this = $(this);

				$states.find('option:not(:first-child)').remove();

				$.ajax({            
					type: 'GET',
					dataType: 'json',
					url: 'https://api.countrystatecity.in/v1/states',
					headers: { 'X-CSCAPI-KEY': 'Sm5WN1F6eGl5MkVZT1BuTjFtODNncGdUelFGdlZ4OUNPVmY2QTVPag==' },
					success: function (response) {
						$.each(response, function(index, item) {
							var state_code = item.iso2;							
							var state_name = item.name;
	
							if ($this.val() == item.country_code) {
								$states.prop('disabled', false);
	
								$('<option id="' + index + '" value="' + state_code + '">' + state_name + '</option>').appendTo($states);
							}
						});
					}
				});
			});	
			
			$states.on('change', function() {
				var $this = $(this);
				var $country_selected = $countries.val();

				$cities.find('option:not(:first-child)').remove();

				$.ajax({            
					type: 'GET',
					dataType: 'json',
					url: 'https://api.countrystatecity.in/v1/countries/'+$country_selected+'/states/'+$this.val()+'/cities',
					headers: { 'X-CSCAPI-KEY': 'Sm5WN1F6eGl5MkVZT1BuTjFtODNncGdUelFGdlZ4OUNPVmY2QTVPag==' },
					success: function (response) {
						$.each(response, function(index, item) {												
							var city_name = item.name;	

							$('<option id="' + index + '" value="' + city_name + '">' + city_name + '</option>').appendTo($cities);

							$cities.prop('disabled', false);
						});
					}
				});
			});			
			
		}

		if ($bulletPointModal.length) {
			var $bulletPoint = '';
			var $bulletPointText = $bulletPointModal.find('.content:not(.floated) input').val();
			var count = 0;

			$keyListPointButton.next().find($bulletPointModal).modal('attach events', $keyListPointButton, 'toggle');
			$bulletPointModal.modal({
				onHide: function () {
					if (!$.trim($bulletPointText)) {
						count++
						$bulletListClone.clone().insertBefore($bulletListClone).removeClass('item-clone hidden').addClass('item bulletpoint-added bulletpoint-' + count);
						$bulletAdded = $bulletListClone.prev('.bulletpoint-added');
						$bullListContainer = $bulletAdded.find('.content:not(.floated)');
						$bulletPoint = $($bulletPointModal.find('.content:not(.floated) input'));
						$bullListContainer.attr('data-text', $.trim($bulletPoint.val()));
						$bullListContainer.text($.trim($bulletPoint.val()));

						$('<input type="hidden" class="js-bulletpoint" id="ps-list-bullet-point-' + count + '" name="ps-list-bullet-points[]" value="' + $.trim($bulletPoint.val()) + '" />').appendTo($bulletAdded);

						$bulletPointModal.find('.content:not(.floated) input').val('');
						$bulletPoint = '';
					}
				}
			});
		}

		$bulletAdded = $bulletListClone.prevAll('.bulletpoint-added');

		if ($bulletAdded.length) {
			$bulletAdded.each(function () {
				var $this = $(this);
				var $revmoveButton = $this.find('.button.js-remove');

				console.log($this);

				$this.on('click', $revmoveButton, function () {
					var $this = $(this);

					$this.closest('.bulletpoint-added').remove();
				});
			});
		}

		if ($embedModal.length) {
			$addVideos.closest('.segment.tab').find($embedModal).modal('attach events', $addVideos, 'toggle');
			var $embed = '';
			var $embedCode = $embedModal.find('.content input').val();
			var count = 0;

			$embedModal.modal({
				onHide: function () {
					if (!$.trim($embedCode)) {
						count++

						$embed = $embedModal.find('.content input').val();

						console.log($embedModal.find('.content input').val());

						if ($embed !== '') {
							$cloneVideo.clone().insertBefore($cloneVideo).removeClass('video-uploaded-clone hidden').addClass('video-uploaded video-' + count);

							$videoUploaded = $cloneVideo.prev('.video-uploaded');
							$embedContainer = $videoUploaded.find('.ui.embed');
							

							$embedContainer.attr('data-url', 'https://www.youtube.com/embed/' + $embed);
							$embedContainer.attr('data-placeholder', 'http://i3.ytimg.com/vi/' + $embed + '/hqdefault.jpg');
							$('<input type="hidden" class="js-video-embed-upload" id="ps-videos-' + count + '" name="ps-videos[]" value="' + $embed + '" />').appendTo($videoUploaded);
							$embedContainer.embed();

							var $vidCount = $addVideos.prev('.ui.header').find('span.doc-count');

							if ($vidCount.length) {
								var Count = parseInt($vidCount.text());

								$vidCount.text(Count + 1);
							}
						}

						$embedModal.find('.content input').val('');
						$embed = '';
					}
				}
			});

		}

		var $embed = $('.video-uploaded');
		$videoUploaded = $cloneVideo.prevAll('.video-uploaded');

		if ($videoUploaded.length > 1) {
			$videoUploaded.each(function () {
				var $this = $(this);

				$embedContainer = $this.find('.ui.embed');

				$embedContainer.embed();

				$this.on('click', 'a', function () {
					var $this = $(this);
					var $vidCount = $addVideos.prev('.ui.header').find('span.doc-count');

					$this.siblings('input').remove();

					$this.closest($embed).addClass('hidden');

					if ($vidCount.length) {
						var Count = parseInt($vidCount.text());

						$vidCount.text(Count - 1);
					}
				});

			});
		} else {
			$embedContainer = $videoUploaded.find('.ui.embed');
			$embedContainer.embed();

			if ($embed) {
				$embed.on('click', 'a', function () {
					var $this = $(this);
					var $vidCount = $addVideos.prev('.ui.header').find('span.doc-count');

					$this.siblings('input').removeAttr('value');
					$this.closest($embed).addClass('hidden');

					if ($vidCount.length) {
						var Count = parseInt($vidCount.text());

						$vidCount.text(Count - 1);
					}
				})
			}
		}

	});

})( jQuery );
