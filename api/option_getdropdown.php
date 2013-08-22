<?php
	session_start();
	ob_start();

	require_once('../config.php');
	require_once($cfg['dirroot'] . '/lib/functions.php');
	require_once('../header.php');

	global $list;

	$type = $_GET['type'];
	$value = $_GET['value'];

	if (!isset($_SESSION['scenario_id']) || !isset($_SESSION['event_id']))
	{
	}
	else
	{
		if (in_array($type, array('object', 'character', 'verb_condition', 'verb_outcome', 'animation', 'subject_type', 'textbox', 'coordinates', 'inputbox')))
		{
/*
			if (!$value)
			{
				// Create a new record.
				$scenario_id = $_SESSION['scenario_id'];
				$event_id = $_SESSION['event_id'];
				$date_created = $date_modified = date('Y-m-d H:i:s');
				$sql = "INSERT INTO commands (scenario_id, event_id, serialized_command, date_created, date_modified, created_by)
						VALUES ('" . mysql_real_escape_string($scenario_id) . "',
								'" . mysql_real_escape_string($event_id) . "',
								'',
								' . $date_created . ',
								' . $date_modified . ',
								0)";
				if ($db->Execute($sql))
				{
				}
			}
*/
			if ($type == 'object')
				$code = form_create_dropdown($list['object'], $value);
			else if ($type == 'character')
				$code = form_create_dropdown($list['character'], $value);
			else if ($type == 'animation')
				$code = form_create_dropdown($list['animation'], $value);
			else if ($type == 'verb_condition')
				$code = form_create_dropdown($list['verb_condition'], $value);
			else if ($type == 'verb_outcome')
				$code = form_create_dropdown($list['verb_outcome'], $value);
			else if ($type == 'subject_type')
				$code = form_create_dropdown($list['subject_type'], $value);

			else if ($type == 'textbox')
			{
				$code = textbox_get_content($value);
			}

			else if ($type == 'coordinates')
			{
				$code = coordinates_get_content($value);
			}

			else if ($type == 'inputbox')
			{
				$code = inputbox_get_content($value);
			}

			echo $code;
		}
	}
?>