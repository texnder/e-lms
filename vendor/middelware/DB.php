<?php

use connection\queryBuilder;

class DB extends queryBuilder
{
	protected static $table;
	public $id;
	
	public static function table(string $tablename)
	{
		if (!empty($tablename)) {
			self::$table = $tablename;
			return new self;
		}else{
			throw new Exception("Too few arguments to function");
		}
	}
	
	public function select(...$cols)
	{
		return $this->selectQuery($cols);
	}

	public function query(string $sql,array $bindValues=[])
	{
		$this->query = $sql;
		$this->bindValues = $bindValues;
		return $this;
	}

	public function find_ById(int $id)
	{
		$this->query = "SELECT * FROM " .static::$table. " WHERE id= :id LIMIT 1";
		$this->bindValues['id'] = $id;
		$result = $this->get();
		$this->reset_query();
		return ($result) ? array_shift($result) : false;
	}

	public function find_all()
	{
		$this->query = "SELECT * FROM ".static::$table."";
		return $this->get();
	}

	public function update($data,$col=null)
	{
		$this->modify($data,$col);
		return $this->exec();
	}

	public function create($data)
	{
		$this->Insert($data);
		return $this->exec();
	}

	public function delete($id,string $col='')
	{
		$id = (!is_null($this->id)) ? $this->id : $id;
		$this->delete_row($id,$col);
		return $this->exec();
	}

	public function softdelete($col)
	{
		$this->modify(["deleted_at"=>date("Y-m-d H:i:s")],$col);
		return $this->exec();
	}

	public function restore($col)
	{
		$this->modify(["deleted_at"=>null],$col);
		return $this->exec();
	}
}