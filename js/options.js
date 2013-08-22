function next_options(el, category)
{
	// If an action row doesn't have any "option" spans, create the first one (with parent id 0).
	var jel = $(el);
	var selected = $('option:selected', jel).val();
	var choice = selected.split('_');
	var url = 'api/getnextoptions.php?id=' + choice[1] + '&table=' + choice[0] + '&category=object';
	var spanparent = jel.parent().parent();
	var thisspan = jel.parent();
	$.get(url, function(data)
	{
		alert(data);

		// If no options were returned, we've reached the end of the possibilities for this node. If we're
		// in a conditional, we move on to the outcome. If we're in an outcome, we add an optional "and"
		// for the user to click, which will create another outcome.
		var dataelement = $(data);
		if (dataelement.html() == '')
		{
			var optionrow = spanparent.parent().parent();
			$('div.outcome', optionrow).show();
		}
		else
		{
			// Test to see if there's a next node. If there is, we need to replace it (and possibly all
			// its next siblings) with the new data. Otherwise, just append it to the parent.
			var nextspan = thisspan.next('span.option');
		
			// Test to see if there's a next node. If there is, we need to replace it (and possibly all
			// its next siblings) with the new data. Otherwise, just append it to the parent.
			if (nextspan.length == 0)
			{
				spanparent.append(data);
			}
		}
	});
}



$(document).ready(function()
{
});