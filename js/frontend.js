// JavaScript Document
function Be_Mch_Tpnf() {}

Be_Mch_Tpnf.HasFooter = false;

(function($) {
	Be_Mch_Tpnf.Excecute = function(data) {
		if (data == null || data.length == 0) {
			return;
		}
		
		var EOrder = {
			Top: 0
			, Normal: 1
			, Bottom: 2
		};
		
		var regPriority = /^((?:b(?:ottom)?)|(?:t(?:op)?))?\s*((?:\+|-|(?:^\s*))\s*(?:1000|[0-9]{1,3}))?$/i;
		
		var defaultValue = 0;
		for(var i = data.length - 1; i >= 0; --i) {
			var entry = data[i];
			var jElt = null;
			
			switch(entry.Type) {
				case 'js':
					jElt = $('HEAD SCRIPT[src^="http://0.0.0.0/' + entry.Ref + '/"]');
					break;
				case 'css':
					jElt = $('#' + entry.Ref + '-css');
					break;
			}
			entry['jElt'] = jElt; 
			
			// Element not found
			if (jElt == null || jElt.length == 0) {
				console.log(entry.Ref);
				
				data.splice(i, 1);
				
				continue;
			} 
			
			var matches = regPriority.exec(entry.Priority);
			
			entry['Order'] = {
				Level: EOrder.Normal
				, Value: 0
				, SubValue: ++defaultValue // Allows to assert initial ordering on Value equality
			};
			if (matches != null && matches.length == 3) {
				if (typeof(matches[1]) !== 'undefined') {
					switch(matches[1].toLowerCase()) {
						case 'b':
						case 'bottom':
							entry.Order.Level = EOrder.Bottom;
							break;
						case 't':
						case 'top':
							entry.Order.Level = EOrder.Top;
							break;
					}
				}
				
				if (typeof(matches[2]) !== 'undefined') {
					entry.Order.Value = parseInt(matches[2].replace(/\s/g, ''));
				}
			} else {
				console.log(entry.Priority);
			}
		};
		
		data.sort(function(a, b) {
			var diff;
			
/*
			console.log('b');
			console.log(b);
*/

			diff = a.Order.Level - b.Order.Level;
			if (diff != 0) {
				return diff; 
			}

			// Top element are prepended, thus their order should be reversed
			if (a.Order.Level == EOrder.Top) {
				var c = a;
				a = b;
				b = c;
			}
			
			diff = a.Order.Value - b.Order.Value;
			if (diff != 0) {
				return diff; 
			}
			diff = a.Order.SubValue - b.Order.SubValue;
			return diff; 
		});
		
		var jHead = $('HEAD');
		for(var i = 0; i < data.length; ++i) {
			var entry = data[i];
			
			if (entry.jElt == null) {
				continue;
			}
			
			entry.jElt.remove();
			
			if (entry.Type == 'js') {
				// script must be recreated
				entry.jElt = $('<script/>')
					.prop('async', false)
					.prop('defer', true)
					.prop('src', entry.jElt.prop('src').replace(/^[^#]*#/, ''))
				;
			}
			
			if (entry.ID.length > 0) {
				entry.jElt.prop('id', entry.ID);
			}
			
			switch(entry.Order.Level) {
				case EOrder.Top:
					jHead.prepend(entry.jElt);
					break;
				default:
					jHead.append(entry.jElt);
					break;
			}
		}
	}
	
	Be_Mch_Tpnf.HasFooter = false;
	
	$(document).ready(function() {
		if (!Be_Mch_Tpnf.HasFooter) {
			alert('"This page needs files" error:\r\n\
It seems "wp_footer" has not been fired properly by your theme.\r\n\
The plugin requires it to work properly.'
			);
		}
	});
})(jQuery);	