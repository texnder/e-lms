<?php
namespace connection;
use Exception;
use session;
use Aditex\src\Container;
use connection\connection;

/**
 * 
 */
class queryBuilder
{
	public $query;

	public $bindValues = [];

	public $queries = [];

	public function selectQuery(array $cols)
	{
		if (count($cols) > 0) {
			$col = implode(",", $cols);
			$this->query = "SELECT {$col} FROM ".static::$table." ";
		}else{
			throw new Exception("Too few arguments to function");
		}
		return $this;
	}

	public function where($col,string $val='')
	{
		if (!is_null($this->query)) {
			$this->prepare_where_statement($col,$val);
		}else{
			$this->query = "SELECT * FROM ".static::$table." ";
			$this->prepare_where_statement($col,$val);
		}
		return $this;
	}

	public function orwhere(string $col,string $val)
	{
		if (!is_null($this->query) && !empty($col) && !empty($val)) {
			$this->query = $this->query . " OR {$col} = :{$col} ";
			$this->bindValues[$col] = $val;
			return $this;
		}
		throw new Exception("Syntax Error");
		
	}

	public function update_query_stmt($data,$key_key_pair)
	{
		if ($this->is_column_exist("updated_at")) {
			$this->bindValues['updated_at'] = date("Y-m-d H:i:s");
		}
		$this->set_data($data);
		$this->query = "UPDATE " .static::$table. " SET ";
		$this->query .= implode(",", $key_key_pair);

	}

	public function modify(array $data,$col=null)
	{
		session::_token();
		if (is_null($this->query)) {
			if(is_int($col) || is_string($col)){
				if ($row = $this->find_ById($col)) {
					$key_key_pair = $this->key_key_pair((array)$row);
					$this->update_query_stmt($data,$key_key_pair);
					$this->where("id",$this->bindValues['id']);
				}
			}elseif (is_array($col)) {
				$result = $this->where($col)->get();
				$this->reset_query();
				if ($result) {
					foreach ($result as $key => $row) {
						$key_key_pair = $this->key_key_pair((array)$row);
						$this->update_query_stmt($data,$key_key_pair);
						$keys = array_keys($this->bindValues);
						$first_col = array_shift($keys);
						$this->where($first_col,$this->bindValues[$first_col]);
						$instant_array = [];
						$instant_array['query'] = $this->query;
						$instant_array['bindValues'] = $this->bindValues;
						array_push($this->queries, $instant_array);
					}
				}
			}else
				throw new Exception("Invaild id!!");
			return $this;
		}else
			throw new Exception("Syntax Error!! Please Check Our Documentation");
	}

	public function is_column_exist($col)
	{
		$this->query = "SHOW COLUMNS FROM ".static::$table."";
		$columns = $this->get();
		foreach ($columns as $obj) {
			if ($obj->Field === $col) {
				return true;
			}
		}
		return false;
	}

	public function Insert(array $data)
	{
		session::_token();
		if (is_null($this->query)) {
			if ($this->is_column_exist("created_at")) {
				$this->bindValues['created_at'] = date("Y-m-d H:i:s");
			}
			$this->set_data($data);
			$this->query = "INSERT INTO ".static::$table." (".implode(",",array_keys($this->bindValues)).")";
			$this->query .= " VALUES (:".implode(",:",array_keys($this->bindValues)).") ";
			return $this;
		}else
			throw new Exception("Syntax Error!! Please check Documentation First");
		
	}

	public function insertInto(string $table,array $cols1 = [],array $cols2 = [])
	{	
		if ($this->is_column_exist("created_at")) {
			$this->bindValues['created_at'] = date("Y-m-d H:i:s");
		}
		$cols1 = (count($cols1) > 0) ? "(".implode(",", $cols1).")" : "";
		$cols2 = (count($cols2) > 0) ? implode(",", $cols2) : "*";
		$this->query = "INSERT INTO ".static::$table." {$cols1} ";
		$this->query .= "SELECT {$cols2} FROM {$table}";
		return $this;
	}

	public function prepare_where_statement($col,$val='')
	{
		if (is_string($col) && $val !== '') {
			if (strtoupper($val) === "NULL" || strtoupper($val) === "NOT NULL") {
				$this->query = $this->query . " WHERE {$col} IS ".strtoupper($val)." ";
			}elseif (preg_match("/like/i", $val)) {
				$this->query = $this->query . " WHERE {$col} {$val} ";
			}else{
				$this->bindValues[$col] = $val;
				$this->query = $this->query . " WHERE {$col} = :{$col}";
			}
		}elseif (is_array($col)) {
			$key_key_pair = $this->key_key_pair($col);
			$glue = (strtoupper($val) === "OR") ? " OR " : " AND ";
			$glue = (strtoupper($val) === "NOT") ? " AND NOT " : " AND ";
			$key_pair = implode($glue, $key_key_pair);
			$this->query = $this->query . " WHERE {$key_pair}";
		}else{
			throw new Exception("Too few arguments to function");
		}
	}

	public function key_key_pair(array $key_value_pair)
	{
		$this->set_data($key_value_pair);
		$key_key_pair = [];
		foreach ($key_value_pair as $col => $value) {
			$key_key_pair[] = "{$col} = :{$col}";
		}
		return $key_key_pair;
	}

	public function set_data(array $data)
	{
		if (count($data) > 0 ) {
			foreach ($data as $col => $val) {
				$this->bindValues[$col] = $val;
			}
		}else
			throw new Exception("invalid data pass to database!!");
	}

	public function orderBy($cols,string $order='')
	{
		if (!is_null($this->query)) {
			if (is_string($cols)) {
				$this->query = $this->query. " ORDER BY {$cols} {$order} ";
				return $this;
			}elseif (is_array($cols)) {
				$this->query = $this->query. " ORDER BY ".implode(",", $cols)." {$order} ";
				return $this;
			}else
				throw new Exception("Syntax Error!! Please Check Our Documentation");
		}else
			throw new Exception("Syntax Error!! Please Check Our Documentation");
	}


	public function delete_row($id,string $col='')
	{
		session::_token();
		$col = ($col === '') ? "id" : $col;
		$this->query = "DELETE FROM ".static::$table." WHERE {$col} = :{$col} LIMIT 1";
		$this->bindValues[$col] = $id;
		return $this;
	}
	
	public function join(string $type,string $table, string $key)
	{
		$this->query = $this->query . " ".strtoupper($type)." JOIN {$table} ON ";
		$this->query .=	static::$table.".{$key} = {$table}.{$key} ";
		return $this;

	}

	public function groupBy(string $col)
	{
		if (is_string($cols)) {
			$this->query = $this->query. " GROUP BY {$col} ";
			return $this;
		}else
			throw new Exception("Syntax Error!! Please Check Our Documentation");
	}


	public function exec()
	{
		try {
			$database = $this->connect();
			if (count($this->queries) > 0) {
				foreach ($this->queries as $instant_array) {
					$stmt = $database->conn->prepare($instant_array['query']);
					$stmt->execute($instant_array['bindValues']);
				}
			}elseif ($this->query && count($this->bindValues) > 0){
				$stmt = $database->conn->prepare($this->query);
				$stmt->execute($this->bindValues);
			}elseif ($this->query && count($this->bindValues) === 0) {
				$stmt = $database->conn->prepare($this->query);
				$stmt->execute();
			}else{
				return false;
			}
			return true;
		} catch (\PDOException $e) {
			echo "Error Message: {$e->getMessage()} <br>Error Code: {$e->getCode()}";
			die();
		}
	}

	public function get()
	{
		try {
			$database = $this->connect();
			$stmt = $database->conn->prepare($this->query);
			if (count($this->bindValues) > 0) {
				$stmt->execute($this->bindValues);
			}else{
				$stmt->execute();
			}
			$the_object_array=[];
			while($row=$stmt->fetch(\PDO::FETCH_ASSOC))
			{
				$the_object_array[]= (object)$row;	
			}
			return count($the_object_array) == 0 ? null : $the_object_array;
		} catch (\PDOException $e) {
			echo "Error Message: {$e->getMessage()} <br>Error Code: {$e->getCode()}";
			die();
		}
	}

	public function reset_query($value='')
	{
		$this->query = '';
		$this->bindValues = [];
	}

	private function connect()
	{
		return Container::getInstance(connection::class);
	}
}