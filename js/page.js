// We'll need to override the addClass() and removeClass() jQuery functions to trigger the change from text to form elements.
// See http://stackoverflow.com/questions/1950038/jquery-fire-event-if-css-class-changed
(function()
{
    // Your base, I'm in it!
    var originalAddClassMethod = jQuery.fn.addClass;

    jQuery.fn.addClass = function()
    {
        // Execute the original method.
        var result = originalAddClassMethod.apply(this, arguments);

        // Check if the argument passed was "edit" and if so, trigger the change from text to form elements.
        if (arguments[0] == 'edit')
        {
        	this.formize();
        }

        // return the original result
        return result;
    }
/*
    jQuery.fn.removeClass = function()
    {
        // Execute the original method.
        var result = originalAddClassMethod.apply(this, arguments);

        // Check if the argument passed was "edit" and if so, trigger the change from form elements to text.
        if (arguments[0] == 'edit')
        {
        	this.deformize();
        }

        // return the original result
        return result;
    }
*/
})();

$(document).ready(function()
{
	$('select, input, button, textarea, a.button').uniform();
	$('#tabs').tabs();

	$('ul.optionlist a.openmenu').tooltipster(
	{
		content: 'Loading...',
		position: 'right',
		iconTouch: true,
		interactive: true,
		trigger: 'click',
		functionBefore: function(origin, continueTooltip)
		{
			var id = origin.data('id');
			var html = '<ul class="commandmenu" data-id="' + id + '"><li><a href="#">Edit</a></li><li><a class="save">Save</a></li><li><a href="#">Copy</a></li><li><a href="#">Persist</a></li><li><a href="#">Lock</a></li><li><a href="#">Delete</a></li></ul>';
			origin.tooltipster('update', html);
			continueTooltip();
		}
	});

	// Add a new row when an "Add" button is clicked.
	$('div.options div.buttons span.add').on('click', function()
	{
		var options_type = $(this).parent().parent().parent().attr('id');
		if (options_type == 'startblock')
		{
			var html = ' \
				<li> \
					<div class="icons"> \
						<a class="openmenu" data-id="" href="#"> \
							<img src="images/edit-command.png" alt="menu" /> \
						</a> \
					</div> \
					<div class="eventstarts optionrow" data-id=""> \
						<div class="command_data"> \
							<span data-word="id" data-id=""></span> \
						</div> \
						<div class="outcome"> \
							<span data-word="verb_outcome" data-text="" data-id=""></span> \
						</div> \
					</div> \
				</li>';
			var block_list = $('#startblock ul.optionlist');
			block_list.append(html);
			var last_node = block_list.find('li:last div.optionrow');
			last_node.addClass('edit');
		}
		else if (options_type == 'charactersblock')
		{
			var html = ' \
				<li> \
					<div class="icons"> \
						<a class="openmenu" data-id="" href="#"> \
							<img src="images/edit-command.png" alt="menu" /> \
						</a> \
					</div> \
					<div class="characters optionrow" data-id=""> \
						<div class="command_data"> \
							<span data-word="id" data-id=""></span> \
						</div> \
						<div class="condition"> \
							<span class="conjunction">If</span> \
							<span data-word="character" data-text="" data-id=""></span> \
						</div> \
					</div> \
				</li>';
			var block_list = $('#charactersblock ul.optionlist');
			block_list.append(html);
			var last_node = block_list.find('li:last div.optionrow');
			last_node.addClass('edit');
		}
	});
	
	// Update the <span>s when an option is selected in a command.
	$('div.optionrow select').live('change', function()
	{
		var id = $(this).val();
		var text = $(this).find('option:selected').text();
		var category = $(this).parent().parent().parent().parent().parent().parent().parent().attr('id');
		$(this).parent().attr('data-id', id);
		$(this).parent().attr('data-text', text);
		getNextOptions(category, $(this).parent(), $(this).parent().prev());
	});

	// Update the <span>s when an input box or textarea is changed in a command.
	$('div.optionrow input[type="text"][class="inputbox"], div.optionrow textarea').live('keyup', function()
	{
		var text = $(this).val();
		$(this).parent().attr('data-text', text);
		getNextOptions(category, $(this).parent(), $(this).parent().prev());
	});

	// Update the <span>s when coordinates are changed in a command.
	$('div.optionrow input.coordinates[type="text"]').live('keyup', function()
	{
		var x = $(this).parent().find('input.coordinates_x').val();
		var y = $(this).parent().find('input.coordinates_y').val();
		var text = x + ',' + y;
		$(this).parent().attr('data-text', text);
		getNextOptions(category, $(this).parent(), $(this).parent().prev());
	});

	// Save a command.
	$('ul.commandmenu a.save').live('click', function(event)
	{
		var id = $(this).parent().parent().data('id');
		var row = $('div.optionrow[data-id="' + id + '"]');
		var html_string = row.parent().html();
		$.ajax(
		{
			type: 'POST',
			url: './api/save_command.php',
			data: { html: html_string },
			success: function(data)
			{
			}
		});
	});

	$('div.optionrow').live('click', function(event)
	{
		if ($(this).hasClass('edit'))
		{
//			$(this).removeClass('edit');
		}
		else
		{
			$(this).addClass('edit');
		}
	});
/*
	$('div.optionrow div.action .add').live('click', function(event)
	{
		var optionid = $(this).parent().parent().parent().parent().parent().parent().attr('id');
		var optionclass = $(this).parent().parent().attr('class');
		var params = new Array();
		params['id'] = optionid;
		params['class'] = optionclass;
		getNextOptions(params);
	});
*/
});

function getNextOptions(category, currentSpan, previousSpan)
{
	$.ajax(
	{
		type: 'GET',
		url: './api/option_getnext.php',
		data: {
			category: category,
			current_word: currentSpan.attr('data-word'),
			current_id: currentSpan.attr('data-id'),
			prev_word: previousSpan.attr('data-word'),
			prev_id: previousSpan.attr('data-id')
		},
		success: function(data)
		{
			currentSpan.parent().append(data);
		}
	});
}

function createOptionHTML(type)
{
	var html = ' \
		<li> \
			<div class="icons"> \
				<a class="openmenu" data-id="" href="#"> \
					<img src="images/edit-command.png" alt="menu" /> \
				</a> \
			</div> \
			<div class="eventstarts optionrow" data-id=""> \
				<div class="command_data"> \
					<span data-word="id" data-id=""></span> \
				</div> \
				<div class="outcome"> \
					<span data-word="verb_outcome" data-text="" data-id=""></span> \
				</div> \
			</div> \
		</li>';
}