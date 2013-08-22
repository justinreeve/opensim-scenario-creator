<?php
	$obj = new stdClass;
	$obj->category = 'eventstarts';
	$obj->outcomes = array();
/*
	$com = array();
	$com[0]['word_type'] = 'character';
	$com[0]['text'] = 'Roger';
	$com[0]['option_id'] = 2;

	$com[1]['word_type'] = 'verb_condition';
	$com[1]['text'] = 'is asked about';
	$com[1]['option_id'] = 24;

	$com[2]['word_type'] = 'inputbox';
	$com[2]['text'] = 'bakery';

	$obj->condition = $com;
*/
	$com = array();
	$com[0]['word_type'] = 'verb_outcome';
	$com[0]['text'] = 'create character';
	$com[0]['option_id'] = 7;

	$com[1]['word_type'] = 'character';
	$com[1]['text'] = 'Jeremiah';
	$com[1]['option_id'] = 3;

	$com[2]['word_type'] = 'coordinates';
	$com[2]['text'] = '50,100';

//	$obj->outcomes[] = $com;

	$com[0]['word_type'] = 'verb_outcome';
	$com[0]['text'] = 'move character';
	$com[0]['option_id'] = 8;

	$com[1]['word_type'] = 'character';
	$com[1]['text'] = 'Jeremiah';
	$com[1]['option_id'] = 3;

	$com[2]['word_type'] = 'coordinates';
	$com[2]['text'] = '150,100';

//	$obj->outcomes[] = $com;

	$com = array();
	$com[0]['word_type'] = 'verb_outcome';
	$com[0]['text'] = 'tell everyone';
	$com[0]['option_id'] = 12;

	$com[1]['word_type'] = 'textbox';
	$com[1]['text'] = 'Jeremiah has arrived!';

	$obj->outcomes[] = $com;

	echo '<pre>'; print_r($obj); echo '</pre>';

	echo serialize($obj);
?>