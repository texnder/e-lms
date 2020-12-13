<?php

use Aditex\src\Container;
use connection\connection;

class migrations
{
	
	private function Application()
	{
		return  "CREATE TABLE application (
			id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			customer_id varchar(16)  NOT NULL UNIQUE,
			name varchar(36)  NOT NULL,
			phone varchar(14)  NOT NULL UNIQUE,
			Address text  NOT NULL,
			dob date NOT NULL,
			loan_type varchar(128) NOT NULL,
			loan_amount int(8) NOT NULL,
			loan_term	int(2) NOT NULL,
			interest_rate float DEFAULT 18,
			user_img text NOT NULL,
			user_id_num	varchar(16) NOT NULL UNIQUE,
			user_id_img	text NOT NULL,
			agent_check	tinyint(1) DEFAULT 0,
			approved	int(15) DEFAULT 0,
			created_at	timestamp DEFAULT CURRENT_TIMESTAMP,
			updated_at	timestamp NULL,
			deleted_at	timestamp NULL
		)";
	}

	private function Administration()
	{
		return "CREATE TABLE administration (
			id int(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name varchar(36)  NOT NULL,
			phone varchar(14)  NOT NULL UNIQUE,
			username varchar(255) NOT NULL UNIQUE,
			password varchar(255) NOT NULL,
			role varchar(10) NULL,
			user_img text NULL,
			created_at	timestamp DEFAULT CURRENT_TIMESTAMP,
			updated_at	timestamp NULL,
			deleted_at	timestamp NULL
		)";
	}

	public function migrate()
	{
		$db = Container::getInstance(connection::class);
		try {
			$data = $this->checkIfExist($db,'application');
			if (!$data) {
				$stmt = $db->conn->prepare($this->Application());
				$stmt->execute();
			}
			print_r("<h3 style='padding:50px;text-align:center'>'application' table created successfully!!</h3>");
		} catch (\PDOException $e) {
			echo "Error Message: {$e->getMessage()} <br>Error Code: {$e->getCode()}";
			die();
		}
		try {
			$data = $this->checkIfExist($db,'administration');
			if (!$data) {
				$stmt = $db->conn->prepare($this->Administration());
				$stmt->execute();
			}
			print_r("<h3 style='padding:50px;text-align:center'>'administration' table created successfully!!</h3>");
		} catch (\PDOException $e) {
			echo "Error Message: {$e->getMessage()} <br>Error Code: {$e->getCode()}";
			die();
		}
		print_r("<h3 style='padding:50px;text-align:center'><b>migrations is done!! </b><a href='".url('/')."' style='color:red;'>click to redirect Home...</a></h3>");
	}

	public function checkIfExist($db,$table)
	{
		$sql = "SHOW TABLES LIKE '".$table."'";
		$stmt = $db->conn->prepare($sql);
		$stmt->execute();
		$the_object_array=[];
		while($row=$stmt->fetch(\PDO::FETCH_ASSOC))
		{
			$the_object_array[]= (object)$row;	
		}
		return $the_object_array;
	}


}