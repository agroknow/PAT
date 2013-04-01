$().ready(function() {
	
	function findValueCallback(event, data, formatted) {
		$("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
	}
	
	function formatItem(row) {
                var title=row[0];
                return title;
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	
	$("#search_item").autocomplete('include/search_exhibits_autocomplete.php', {
		width: 450,
		multiple: true,
		matchContains: true,
		formatItem: formatItem,
		formatResult: formatResult
	});
	$("#search_item").result(function(event, data, formatted) {
		//var hidden = $(this).parent().next().find(">:input");
		//hidden.val( (hidden.val() ? hidden.val() + ";" : hidden.val()) + data[1]);		
		
		$("#select_item").selectOptions(data[1]);
		document.forms[0].search_item.value="";
		document.forms[0].item_title_hid.value=data[0];
	});	
});

