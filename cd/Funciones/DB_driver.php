<?php

class DB_driver
{
	protected $_like_escape_chr = '!';

	public function insert($table, $data)
	{
		$fields = $values = array();

		foreach ($data as $key => $val) {
			$fields[] = $key;
			$values[] = $this->escape($val);
		}

		return $this->_insert($table, $fields, $values);
	}

	protected function _insert($table, $keys, $values)
	{
		return 'INSERT INTO ' . $table . ' (' . implode(', ', $keys) . ') VALUES (' . implode(', ', $values) . ')';
	}


	public function update($table, $data, $where)
	{

		$fields = array();
		foreach ($data as $key => $val) {
			$fields[$key] = $this->escape($val);
		}

		$sql = $this->_update($table, $fields,$where);
		return $sql;
	}

	protected function _update($table, $values,$where)
	{
		foreach ($values as $key => $val)
		{
			$valstr[] = $key.' = '.$val;
		}

		return 'UPDATE '.$table.' SET '.implode(', ', $valstr)
			.' WHERE '.$where;
	}




	public function escape($str)
	{
		if (is_array($str)) {
			$str = array_map(array(&$this, 'escape'), $str);
			return $str;
		} elseif (is_string($str) or (is_object($str) && method_exists($str, '__toString'))) {
			return "'" . $this->escape_str($str) . "'";
		} elseif (is_bool($str)) {
			return ($str === FALSE) ? 0 : 1;
		} elseif ($str === NULL) {
			return 'NULL';
		}

		return $str;
	}
	public function escape_str($str, $like = FALSE)
	{
		if (is_array($str)) {
			foreach ($str as $key => $val) {
				$str[$key] = $this->escape_str($val, $like);
			}

			return $str;
		}

		$str = $this->_escape_str($str);

		// escape LIKE condition wildcards
		if ($like === TRUE) {
			return str_replace(
				array($this->_like_escape_chr, '%', '_'),
				array($this->_like_escape_chr . $this->_like_escape_chr, $this->_like_escape_chr . '%', $this->_like_escape_chr . '_'),
				$str
			);
		}

		return $str;
	}
	protected function _escape_str($str)
	{
		return str_replace("'", "''", $this->remove_invisible_characters($str, FALSE));
	}




	protected function remove_invisible_characters($str, $url_encoded = TRUE)
	{
		$non_displayables = array();

		// every control character except newline (dec 10),
		// carriage return (dec 13) and horizontal tab (dec 09)
		if ($url_encoded) {
			$non_displayables[] = '/%0[0-8bcef]/i';	// url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%1[0-9a-f]/i';	// url encoded 16-31
			$non_displayables[] = '/%7f/i';	// url encoded 127
		}

		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

		do {
			$str = preg_replace($non_displayables, '', $str, -1, $count);
		} while ($count);

		return $str;
	}
}
