<?php 
require_once('../config.php');
require_once($cfg['dirroot'] . '/lib/functions.php');
require_once($cfg['dirroot'] . '/header.php');

$category = $_GET['category'];	// startblock/objectsblock/charactersblock
$current_word = $_GET['current_word'];
$current_id = $_GET['current_id'];
$prev_word = $_GET['prev_word'];
$prev_id = $_GET['prev_id'];
$rowtype = 'outcome';

// TODO: Retrieve scenario_id and event_id from the session.
$scenario_id = null;
$event_id = null;

$data_word = '';

$html = '';
if (is_numeric($current_id))
{
	if ($current_word == 'verb_condition' || $current_word == 'verb_outcome')
	{
		$sql = "SELECT *
				FROM verbs
				WHERE id = '" . mysql_real_escape_string($current_id) . "'";
		$verb = $db->GetRow($sql);
		if ($verb['subsequent_option_type'] == 'object')
		{
			$html .= form_create_dropdown(object_get_list($scenario_id, $event_id));
			$data_word = 'object';
		}
		else if ($verb['subsequent_option_type'] == 'character')
		{
			$html .= form_create_dropdown(character_get_list($scenario_id, $event_id));
			$data_word = 'character';
		}
		else if ($verb['subsequent_option_type'] == 'event')
		{
			$html .= form_create_dropdown(event_get_list($scenario_id, $event_id));
			$data_word = 'event';
		}
		else if ($verb['subsequent_option_type'] == 'inputbox')
		{
			$html .= inputbox_get_content();
			$data_word = 'inputbox';
		}
	/*
		else if ($verb['subsequent_option_type'] == 'sound')
		{
			$html .= form_create_dropdown(sound_get_list($scenario_id, $event_id));
			$data_word = 'sound';
		}
	*/

		if ($current_word == 'verb_condition')
		{
			$rowtype = 'condition';
		}
	}
	else if ($current_word == 'character')
	{
		// We need to use the previous word to determine if there's anything else to display.
		if (is_numeric($prev_id))
		{
			if ($prev_word == 'verb_outcome')
			{
				$sql = "SELECT *
						FROM verbs
						WHERE id = '" . mysql_real_escape_string($prev_id) . "'";
				$verb = $db->GetRow($sql);

				// Display coordinates.
				if ($verb['shortname'] == 'createcharacter' || $verb['shortname'] == 'movecharacter')
				{
					$html .= coordinates_get_content();
					$data_word = 'coordinates';
				}

				// Display animation list.
				if ($verb['shortname'] == 'animatecharacter')
				{
					$html .= form_create_dropdown(animation_get_list($scenario_id, $event_id));
					$data_word = 'animation';
				}
			}
		}
		// We're at the start of a conditional in the Characters block, so show a verb_condition.
		else
		{
			$html .= form_create_dropdown(verb_get_list($scenario_id, $event_id, null, array('filter' => 'condition')));
			$data_word = 'verb_condition';
		}
	}
	else if ($current_word == 'object')
	{
		// We need to use the previous word to determine if there's anything else to display.
		if (is_numeric($prev_id))
		{
			if ($prev_word == 'verb_condition' || $prev_word == 'verb_outcome')
			{
				$sql = "SELECT *
						FROM verbs
						WHERE id = '" . mysql_real_escape_string($prev_id) . "'";
				$verb = $db->GetRow($sql);

				// Display coordinates.
				if ($verb['shortname'] == 'createobject' || $verb['shortname'] == 'moveobject')
				{
					$html .= coordinates_get_content();
					$data_word = 'coordinates';
				}
			}
		}
	}
}

// If there's no HTML yet, determine if we should just go to the outcome.
// TODO: Properly test.
if ($html != '')
{
}

// Display the HTML.
if ($html != '')
{
	$html = '<span data-word="' . $data_word . '" data-text="" data-id="">' . $html . '</span>';

	
	echo $html;
}
?>