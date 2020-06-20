function init() {
	autocomplete(".auto", all_users);
}


/// Autocomplete Code
function split( val ) {return val.split( /[\,\+]\s*/ );}
function extractLast( term ) {return split( term ).pop();}

function autocomplete(id, list, splitter) {
	if(!splitter) splitter = '';
	$(id)
		// don't navigate away from the field on tab when selecting an item
		.bind( "keydown", function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB &&
			$( this ).data( "ui-autocomplete" ).menu.active ) {
				event.preventDefault();
			}
		})
		.autocomplete({
			minLength: 3,
			autoFocus: true,
			source: function( request, response ) {
				var current_input = extractLast( request.term );
				
				var final_list = list.filter(function(ele) {
					var regexp = new RegExp("^" + current_input,"i"); // The typed text should match the beginning of the name - not anywhere. And Case insensitive.
					if(ele.name.match(regexp)) return ele.name;
					if(ele.email.match(regexp)) return ele.email;
					if(ele.phone.match(regexp)) return ele.phone;
				});

				var autocomplete_list = final_list.map(function(val, index) {
					return val.name + ' / ' + val.email + ' / ' + val.phone + ' / ' + val.id;
				});

				response(autocomplete_list);
			},
			focus: function() {	// prevent value inserted on focus
				return false;
			},
			select: function( event, ui ) {
				var parts = ui.item.value.split(" / ");
				var name = parts[0];
				var user_id = parts.pop();

				var user_id_ele = $(this).parent().find(".user_id");
				user_id_ele.val(user_id);

				this.value = name;

				return false;
			}
		});
}
