<?php
class DBController {

	private $conn = "";
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "taskforce";

	function __construct() {
		$this->connectDB();
	}

	function connectDB() {

		try
		{
 			$this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
		}
		catch(PDOException $e)
 		{
			echo  "<br>" . $e->getMessage();
		}
		 
	}

	function execute($query, $data) {
		try
		{
        	$stmt = $this->conn->prepare($query);
        	$stmt->execute($data);
			return  $stmt->rowCount();
        }
        catch(PDOException $e)
 		{
    		echo  "<br>" . $e->getMessage();
 		}

	}


	function query($query, $data) {
		try
		{
        	$stmt = $this->conn->prepare($query);
        	$stmt->execute($data);
			return  $stmt;
        }
        catch(PDOException $e)
 		{
    		echo  "<br>" . $e->getMessage();
 		}
	}

	function query_simple($query) {
		try
		{
        	$stmt = $this->conn->prepare($query);
        	$stmt->execute();
			return  $stmt;
        }
        catch(PDOException $e)
 		{
    		echo  "<br>" . $e->getMessage();
 		}
	}

	function query_fetchAll ( $query, $data )
	{
		try
		{
        	$stmt = $this->conn->prepare($query);
        	$stmt->execute($data);
			return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
 		{
    		echo  "<br>" . $e->getMessage();
 		}
	}

	function query_fetchAll_simple ( $query )
	{
		try
		{
        	$stmt = $this->conn->prepare($query);
        	$stmt->execute();
			return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
 		{
    		echo  "<br>" . $e->getMessage();
 		}
	}

}
?>
