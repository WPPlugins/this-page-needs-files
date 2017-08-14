(function($) {
	var pathReg = /(\\|\/)[^(\\|\/)]*$/;
	
	var relativeReg = '^\\w{3,5}:\\/\\/.*';
	var relativeError = "http://..., https://..., ftp://..., etc.";
	
	var fileExtension = /^(?:.*\/)?(?:\w+\.)+(\w+)[^\/]*$/;
	
	var indices = {};
	var index = 0;
	
	var indices = {};

	$(document).ready(function() {
		var tpnfIndices = document.getElementsByName('tpnf-indices');
		
		if (tpnfIndices.length == 0) {
			return;
		}
		
		var fSetIndices = function() {
			var ar = [];
			
			for (var i in indices) {
				ar.push(i);
			}
			
			tpnfIndices[0].value = ar.join(',');
		}
		
		// Add set/release listeners on rows
		$('#this-page-needs-files TBODY > TR')
			.on('tpnf-set', function(event) {
				var jElt = $(event.target);
				
				indices[++index] = true;
				
				jElt.data('index', index);
				
				// set name = <tpnf class>-<index>;
				jElt.find('[class^="tpnf-"]').each(function() {
					var elt = this;
					
					console.log(elt.className);
					
					elt.className.split(' ').map(function(className) {
						if (className.indexOf('tpnf-') == 0) {
							elt.name = className + '-' + index;
						}
					});
				});
				
				fSetIndices();
			})
			.on('tpnf-release', function(event) {
				var jElt = $(event.target);
				
				delete indices[jElt.data('index')];
				
				fSetIndices();
			})
			.trigger('tpnf-set')
		;
		
		var textboxes = $('#this-page-needs-files .tpnf-fileName');
		
		textboxes
			.last().addClass('lattest')
		;
		
		textboxes
			.on('focus', function(event) {
				var match = pathReg.exec(event.target.value);
				
				if (match != null) {
					event.target.setSelectionRange(0, match.index + 1);
				} else {
					event.target.select();
				}
			})
			.on('tpnf-new', function(event) {
				var jElt = $(event.target);
				
				var tr = jElt.closest('TR');
				var newTr = tr.clone(true);
				
				newTr.find('.tpnf-fileName').val('').next('SPAN').text('');
				newTr.find('.tpnf-id').val('');
				newTr.find('.tpnf-type').find('OPTION[value="auto"]').text('Auto');
				newTr.find('.tpnf-relative').val(tr.find('.tpnf-relative').val());
				
				newTr.trigger('tpnf-set');
				
				newTr.insertAfter(tr);
			})
			.on('tpnf-delete', function(event) {
				var jElt = $(event.target);
				
				if (jElt.is('.lattest')) {
					return;
				}
				
				jElt.closest('TR').trigger('tpnf-release').remove();
			})
			.on('keyup paste change tpnf-init', function(event) {
				var jElt = $(event.target);
				
				if (jElt.is('.lattest') && jElt.val() != '') {
					jElt.trigger('tpnf-new');
					
					jElt.removeClass('lattest');
				}
				
				var tr = jElt.closest('TR');
				var auto = tr.find('.tpnf-type > OPTION[value="auto"]');
				
				if (jElt.val() == '') {
					auto.text('Auto');
				} else {
					auto.text('Auto (?)');

					var match = fileExtension.exec(jElt.val());
					if (match != null) {
						switch(match[1].toLowerCase()) {
							case 'js':
								auto.text('Auto (JS)');
								break;
							case 'css':
								auto.text('Auto (CSS)');
								break;
						}
					}
				}
			})				
		;
		
		$('#this-page-needs-files .tpnf-delete').click(function(event) {
			var jElt = $(event.target);
			
			jElt.closest('TR').find('.tpnf-fileName').trigger('tpnf-delete');
		});
		
		textboxes.add($('#this-page-needs-files .tpnf-id')) 
			.on('keydown keyup paste change tpnf-init', function(event) {
				var jElt = $(event.target);
				
				jElt.next('SPAN').text(jElt.val());
			})
			.trigger('tpnf-init')
		;
		
		$('#this-page-needs-files .tpnf-relative')
			.on('change tpnf-init', function(event) {
				var jElt = $(event.target);
				
				var tpnfFileName = jElt.closest('TR').find('.tpnf-fileName');
				
				switch (jElt.val()) {
					case 'none':
						tpnfFileName.prop('pattern', relativeReg);
						tpnfFileName.prop('title', relativeError);
						break;
					default :
						tpnfFileName.prop('pattern', '.*');
						tpnfFileName.prop('title', '');
						break;							
				}
			})
			.trigger('tpnf-init')
		;
	});
	
	$(document).ready(function() {
		$('.tpnf-msg').find('[data-dismiss]').each(function() {
			var jElt = $(this);
			
			jElt.click(function() {
				setTimeout(
					function() {
						alert('"This page needs files"\r\n\
Thank you for your feedback.\r\n\
\r\n\
The message will now be dismissed.');
						window.location.href = jElt.attr('data-dismiss');
					}
					, 1
				);
			});
		});
	});
})(jQuery);