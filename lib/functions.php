<?php
	function form_create_dropdown($records, $value = '', $params = array())
	{
		$code = '';
		if (count($records) > 0)
		{
			$code .= '<select>';
			$code .= '<option value="">Select One...</option>';
			foreach ($records as $key => $record)
			{
				$code .= '
						<option value="' . $record['id'] . '"';
				if ($record['name'] == $value)
					$code .= ' selected';
				$code .= '>' . $record['name'] . '</option>
						';
			}
			$code .= '</select>';
		}
		return $code;
	}



	function object_get_list($scenario_id = null, $event_id = null, $region_id = null, $params = array())
	{
		global $cfg;
		global $db;

		$sql = "SELECT *
				FROM " . $cfg['dbprefix'] . "objects
				ORDER BY name";
		$records = $db->GetAll($sql);

		return $records;
	}



	function character_get_list($scenario_id = null, $event_id = null, $region_id = null, $params = array())
	{
		global $cfg;
		global $db;

		$sql = "SELECT *
				FROM " . $cfg['dbprefix'] . "characters
				ORDER BY name";
		$records = $db->GetAll($sql);

		return $records;
	}

	

	function animation_get_list($scenario_id = null, $event_id = null, $region_id = null, $params = array())
	{
		global $cfg;
		global $db;

		$sql = "SELECT *
				FROM " . $cfg['dbprefix'] . "animations
				ORDER BY name";
		$records = $db->GetAll($sql);

		return $records;
	}



	function verb_get_list($scenario_id = null, $event_id = null, $region_id = null, $params = array())
	{
		global $cfg;
		global $db;

		if ($params['filter'] == 'condition')
		{
			$sql = "SELECT id, shortname, longname name, type, subsequent_option_type
					FROM " . $cfg['dbprefix'] . "verbs
					WHERE type = 'condition'
					ORDER BY longname";
			$records = $db->GetAll($sql);
			return $records;
		}
		else if ($params['filter'] == 'outcome')
		{
			$sql = "SELECT id, shortname, longname name, type, subsequent_option_type
					FROM " . $cfg['dbprefix'] . "verbs
					WHERE type = 'outcome'
					ORDER BY longname";
			$records = $db->GetAll($sql);
			return $records;
		}
		else
			return null;
	}



	function event_get_list($scenario_id = null, $event_id = null, $region_id = null, $params = array())
	{
		global $db;

		if ($scenario_id != null)
		{
			$sql = "SELECT id, scenario_id, title, description, created_date, sequence, concat('Event ', sequence, ': ', title) AS name
					FROM " . $cfg['dbprefix'] . "events
					WHERE scenario_id = '" . $scenario_id . "'
					ORDER BY sequence, title";
			$records = $db->GetAll($sql);
			return $records;
		}
		else
			return null;
	}



	function subject_type_get_list($scenario_id = null, $event_id = null, $region_id = null, $params = array())
	{
		global $db;

		$sql = "SELECT id, name
				FROM " . $cfg['dbprefix'] . "subject_types
				ORDER BY name";
		$records = $db->GetAll($sql);

		return $records;
	}



	function textbox_get_content($value = null)
	{
		$code = '<textarea class="textbox">';
		if ($value)
			$code .= $value;
		$code .= '</textarea>';

		return $code;
	}



	function coordinates_get_content($value = null)
	{
		$coordinates = array();
		if ($value)
			$coordinates = explode(',', $value);

		$code = '
				<input type="text" class="coordinates coordinates_x" placeholder="X" value="' . $coordinates[0] . '" />
				,
				<input type="text" class="coordinates coordinates_y" placeholder="Y" value="' . $coordinates[1] . '" />
		';

		return $code;
	}
	


	function inputbox_get_content($value = null)
	{
		$code = '<input type="text" class="inputbox" value="' . $value . '" />';
		return $code;
	}



	function get_objects($filter = null)
	{
		global $cfg;
		global $db;

		$sql = "SELECT *
				FROM " . $cfg['dbprefix'] . "objects
				ORDER BY name";
		if ($items = $db->GetAll($sql))
			return $items;
		else
			return null;
	}

	function get_characters($filter = null)
	{
		global $cfg;
		global $db;

		$sql = "SELECT *
				FROM " . $cfg['dbprefix'] . "characters
				ORDER BY name";
		if ($items = $db->GetAll($sql))
			return $items;
		else
			return null;
	}

	function get_animations($filter = null)
	{
		global $cfg;
		global $db;

		$sql = "SELECT *
				FROM " . $cfg['dbprefix'] . "animations
				ORDER BY name";
		if ($items = $db->GetAll($sql))
			return $items;
		else
			return null;
	}
?>