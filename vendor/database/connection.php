<?php
namespace connection;

use PDO;
use PDOException;

class connection
{
	/**
	 * PDO instance..
	 *
	 * @var object
	 */
	public $conn;

	public function __construct($config_path)
	{
		$config_data = $this->credentials($config_path);

		$this->pdoInstance($config_data);

		// if instance created set attribute
	    if ($this->conn instanceof PDO) {
	   		$this->setAttribute();
	    }
	}

	/**
	 * set PDO attribute..
	 *
	 * @param 	null
	 */
	private function setAttribute()
	{
		if (PDO::ATTR_ERRMODE !== PDO::ERRMODE_EXCEPTION) {
		    // set the PDO error mode to exception
		   $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}


	

	/**
	 * create new pdo instance using database credentials
	 *
	 * @param 	array 	$db
	 */
	private function pdoInstance(array $db)
	{
		try {

			if(!empty($db['host']) && !empty($db['user'])){
				
			   $this->conn = new PDO(
			   	"{$db['driver']}:host={$db['host']};port={$db['port']};dbname={$db['schema']}",
			   	$db['user'],
			   	$db['password']
			   );

		    }else{
		    	die("Error: database credentials are not set properly!! Please check our documentation.");
		    }
	    }
		catch(PDOException $e)
	    {
	    	die("Error Message: {$e->getMessage()}<br>Error Code: {$e->getCode()}");
	    }
			
	}


	/**
	 * return database credentials 
	 *
	 * @param 	object 	$initTx
	 * @return 	array 
	 */
	private function credentials($config_path)
	{
		try {

			if (file_exists($config_path)) {

				$dbConfigData = include $config_path;

				return $dbConfigData;

			}else{
				throw new \Exception("No such file or dir available in this path '{$config_path}' ");
			}

		} catch (\Exception $e) {
			die("Error Message: {$e->getMessage()}");
		}
	}
}