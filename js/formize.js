(function()
{
	jQuery.fn.formize = function()
	{
		// Convert objects, characters, verbs, animations, and subject_types to dropdowns.
		this.find('span').each(function(index, el)
		{
    		var current_type = $(this).attr('data-word');
    		if ($(this).parent().attr('class') != 'command_data')
    		{
	    		if (current_type)
	    		{
		    		var current_value = $(this).text();
		    		var url = 'api/option_getdropdown.php?type=' + current_type + '&value=' + current_value;
		    		$.get(url, function(data)
					{
		    			$(el).html(data).uniform();
					});
	    		}
    		}
		});
	}
/*
	jQuery.fn.deformize = function()
	{
		// Remove all input boxes, textareas, and dropdowns within <span>s.
		this.find('span').each(function(index, el)
		{
    		if ($(this).parent().attr('class') != 'command_data')
    		{
    			$(this).find('select, input, textarea').remove();
    		}
		});
	}
*/
})();