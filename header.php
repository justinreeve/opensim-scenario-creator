<?php
	require_once($cfg['dirroot'] . '/lib/functions.php');

	// TODO: Retrieve the scenario id.
	$scenario_id = 1;

	// TODO: Retrieve the event id.
	$event_id = 1;

	$_SESSION['scenario_id'] = $scenario_id;
	$_SESSION['event_id'] = $event_id;

	// Retrieve all the drop-down list data.
	$list = array();
	$list['object'] = object_get_list();
	$list['character'] = character_get_list();
	$list['animation'] = animation_get_list();
	$list['verb_condition'] = verb_get_list(null, null, null, array('filter' => 'condition'));
	$list['verb_outcome'] = verb_get_list(null, null, null, array('filter' => 'outcome'));
	$list['event'] = event_get_list($scenario_id);
	$list['subject_type'] = subject_type_get_list();
?>