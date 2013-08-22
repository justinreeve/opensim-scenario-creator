<?php
require_once('../config.php');
require_once($cfg['dirroot'] . '/lib/simplehtmldom.php');

$html_string = $_POST['html'];

if ($html_string)
{
	$html = str_get_html($html_string);

	// Retrieve the id.
	$id = 0;
	foreach ($html->find('div.command_data span') as $data)
	{
		if ($data->getAttribute('data-word') == 'id')
			$id = $data->getAttribute('data-id');
	}

	if ($id > 0)
	{
		// Retrieve the category.
		$class = $html->find('div.optionrow', 0)->class;
		$category = '';
		if (strpos($class, 'eventstarts') !== false)
			$category = 'eventstarts';
		if (strpos($class, 'objects') !== false)
			$category = 'objects';
		if (strpos($class, 'characters') !== false)
			$category = 'characters';

		if ($category != '')
		{
			$com = array();
			foreach ($html->find('div.condition') as $condition)
			{
				foreach ($condition->find('span') as $item)
				{
					$c = array();
					$data_word = $item->getAttribute('data-word');
					$data_text = $item->getAttribute('data-text');
					$data_id = $item->getAttribute('data-id');

					if ($data_word || $data_id)
					{
						if ($data_word)
							$c['word_type'] = $data_word;
						$c['text'] = $data_text;
						if ($data_id)
							$c['option_id'] = $data_id;
						$com[] = $c;
					}
				}
			}

			$condition = $com;

			$outcomes = array();
			foreach ($html->find('div.outcome') as $outcome)
			{
				$com = array();
				foreach ($outcome->find('span') as $item)
				{
					$c = array();
					$data_word = $item->getAttribute('data-word');
					$data_text = $item->getAttribute('data-text');
					$data_id = $item->getAttribute('data-id');

					if ($data_word || $data_id)
					{
						if ($data_word)
							$c['word_type'] = $data_word;
						$c['text'] = $data_text;
						if ($data_id)
							$c['option_id'] = $data_id;
						$com[] = $c;
					}
				}
				$outcomes[] = $com;
			}
		}

		$obj = new stdClass;
		$obj->category = $category;
		$obj->condition = $condition;
		$obj->outcomes = $outcomes;
//		echo '<pre>'; print_r($obj); echo '</pre>';

		$current_datetime = date('Y-m-d H:i:s');
		$sql = "UPDATE commands
				SET serialized_command = '" . mysql_real_escape_string(serialize($obj)) . "',
					date_modified = '" . $current_datetime . "'
				WHERE id = '" . mysql_real_escape_string($id) . "'";
		if (!$db->Execute($sql))
		{
			// TODO: Error-handle.
		}
	}
}
?>