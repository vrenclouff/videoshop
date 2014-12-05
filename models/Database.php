<?php 

require_once 'config.inc.php';

class Database
{
	// vlastni pripojeni k DB - tady to mam public, abych se k tomu rychle dostal. Neni to spravne.
	private static $connection;
	private static $instance;
	
	// ***********************************************************
	// START UNIVERZALNI METODY


    public static function getDatabase(){
        if(!isset(self::$instance)){
            self::$instance = new Database();
            self::$instance->Connect();
        }
        return self::$instance;
    }

	/**
	 * Nacist 1 zaznam z tabulky v DB.
	 *
	 * @param string $table_name - jméno tabulky
	 * @param string $select_columns_string - jména sloupců oddělené čárkami, nebo jiné příkazy SQL
	 * @param array $where_array - seznam podmínek<br/>
	 * 							[] - column = sloupec; value - int nebo string nebo value_mysql = now(); symbol
	 * @param string $limit_string - doplnit limit string
	 */
	public function DBSelectOne($table_name, $select_columns_string, $where_array, $limit_string = "")
	{
		// PDO - MySQL
		//printr($where_array);
			
		// vznik chyby v PDO
		$mysql_pdo_error = false;
			
		// slozit si podminku s otaznikama
		$where_pom = "";
			
		if ($where_array != null)
			foreach ($where_array as $index => $item)
			{
				// pridat AND
				if ($where_pom != "") $where_pom .= "AND ";
	
				$column = $item["column"];
				$symbol = $item["symbol"];

				if (key_exists("value", $item))
					$value_pom = "?"; 						// budu to navazovat
				else if (key_exists("value_mysql", $item))
					$value_pom = $item["value_mysql"]; 		// je to systemove, vlozit rovnou - POZOR na SQL injection, tady to muze projit
	
	
				$where_pom .= "$column $symbol  '$value_pom' ";
			}
	
			// doplnit slovo where
			if (trim($where_pom) != "") $where_pom = "where $where_pom";
	
			// 1) pripravit dotaz s dotaznikama
			$query = "select $select_columns_string from `".$table_name."` $where_pom $limit_string;";
			//echo "$query <br/>";
	
			// 2) pripravit si statement
			$statement = self::$connection->prepare($query);
	
			// 3) NAVAZAT HODNOTY k otaznikum dle poradi od 1
			$bind_param_number = 1;
	
			if ($where_array != null)
				foreach ($where_array as $index => $item)
				{
					if (key_exists("value", $item))
					{
						$value = $item["value"];
						//echo "navazuju value: $value jako number: $bind_param_number";
							
						$statement->bindValue($bind_param_number, $value);  // vzdy musim dat value, abych si nesparoval promennou (to nechci)
						$bind_param_number ++;
					}
				}
					
				// 4) provest dotaz
				$statement->execute();
	
				// 5) kontrola chyb
				$errors = $statement->errorInfo();
				//printr($errors);
					
				if ($errors[0] + 0 > 0)
				{
					// nalezena chyba
					$mysql_pdo_error = true;
				}
					
				// 6) nacist data a vratit
				if ($mysql_pdo_error == false)
				{
					$row = $statement->fetch(PDO::FETCH_ASSOC);
					return $row;
				}
				else
				{
					echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
			//		printr($errors);
					echo "SQL dotaz: $query";
				}
	}
	
	
	/**
	* Nacist vsechny zaznamy z tabulky.
	 * Poznamka: tato metoda je stejna jako DBSelectOne - lisi se to jen posledni casti Fetch vs FetchAll
	 *
	 * @param unknown_type $table_name
	 * @param unknown_type $select_columns_string
	 * @param unknown_type $where_array
	 * @param unknown_type $limit_string
	 * @param array			$order_by_array - pouze pole stringu: [0] => {[column] = "", [sort] => "DESC"}
	 * @return mixed
	 */
	 public function DBSelectAll($table_name, $select_columns_string, $where_array, $limit_string = "", $order_by_array = array())
	 {
	 	
	 	// vznik chyby v PDO
	 	$mysql_pdo_error = false;
	 		
	 	// slozit si podminku s otaznikama
	 	$where_pom = "";
	 		
	 	if ($where_array != null)
	 		foreach ($where_array as $index => $item)
	 		{
	 		// pridat AND
	 		if ($where_pom != "") $where_pom .= "AND ";
	
	 		// pokud neexistuje klic column, tak preskocit
	 		if (!key_exists("column", $item))
	 		{
	 				echo "asi chyba v metode DBSelectAll - chybi klic column <br/>";
					continue;
	 				}

	 				$column = $item["column"];					// pozor na column, mohlo by projit SQL injection
	 				$symbol = $item["symbol"];

	 				if (key_exists("value", $item))
	 				$value_pom = "?"; 						// budu to navazovat
	 				else if (key_exists("value_mysql", $item))
					$value_pom = $item["value_mysql"]; 		// je to systemove, vlozit rovnou - POZOR na SQL injection, tady to muze projit


	 				//echo "`$column` $symbol  $value_pom ";
	 				$where_pom .= "$column $symbol  $value_pom ";
	 	}

	 	// doplnit slovo where
	 	if (trim($where_pom) != "") $where_pom = "where $where_pom";
	
	 		
	 	// pridat si order by - musim to tam dat primo, nelze to dat do prepared statements
	 	$order_by_pom = "";
	
	 	if ($order_by_array != null)
	 		foreach ($order_by_array as $index => $item)
	 		{
	 		$column = $item["column"];
	 		$sort = $item["sort"];
	 			
	 		// carku pred
	 		if (trim($order_by_pom != null))
	 		$order_by_pom .= ", ";
	 			
	 		$order_by_pom .= "`$column` $sort";
	 	}
	
	 		// doplnit slovo order by
	 		if (trim($order_by_pom) != "") $order_by_pom = "order by $order_by_pom";
	 			
	
	 		// 1) pripravit dotaz s dotaznikama
	 		$query = "select $select_columns_string from $table_name $where_pom $order_by_pom $limit_string;";
//	 		echo $query;
	
	 		// 2) pripravit si statement
	 		$statement = self::$connection->prepare($query);
	
	 		// 3) NAVAZAT HODNOTY k otaznikum dle poradi od 1
	 		$bind_param_number = 1;
	
	 		if ($where_array != null)
	 			foreach ($where_array as $index => $item)
	 			{
	 		if (key_exists("value", $item))
	 		{
	 		$value = $item["value"];
	 		//echo "navazuju value: $value";
	 			
	 		$statement->bindValue($bind_param_number, $value);  // vzdy musim dat value, abych si nesparoval promennou (to nechci)
	 		$bind_param_number ++;
	 		}
	 		}
	
	 		// 4) provest dotaz
	 		$statement->execute();
	
	 		// 5) kontrola chyb
	 		$errors = $statement->errorInfo();
	 		//printr($errors);
	 			
	 		if ($errors[0] + 0 > 0)
	 		{
	 		// nalezena chyba
	 		$mysql_pdo_error = true;
	 		}
	 			
	 			// 6) nacist data a vratit
	 	if ($mysql_pdo_error == false)
	 	{
	 	$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
	 	return $rows;
	 	}
	 	else
	 	{
	 	echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
//					printr($errors);
					echo "SQL dotaz: $query";
	 	}
	 	}

	 public function ViaSQL($query){

     	 	// vznik chyby v PDO
     	 	$mysql_pdo_error = false;

//            $query = "select $sql ;";
// 	 		echo $query;

            // 2) pripravit si statement
            $statement = self::$connection->prepare($query);

            // 3) NAVAZAT HODNOTY k otaznikum dle poradi od 1
            $bind_param_number = 1;

            // 4) provest dotaz
            $statement->execute();

            // 5) kontrola chyb
            $errors = $statement->errorInfo();
            //printr($errors);

            if ($errors[0] + 0 > 0)
            {
                // nalezena chyba
                $mysql_pdo_error = true;
            }

     	    // 6) nacist data a vratit
     	 	if ($mysql_pdo_error == false)
     	 	{
                $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $rows;
     	 	}else
     	 	{
     	 	    echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
                echo "SQL dotaz: $query";
     	 	}
     }

     public function DBDelete($table_name, $where_array)
     {
        // MySql
        $mysql_pdo_error = false;

        // SLOZIT TEXT STATEMENTU s otaznikama
        $where_pom = "";

       if ($where_array != null)
            foreach ($where_array as $index => $item)
            {
            // pridat AND
            if ($where_pom != "") $where_pom .= "AND ";

            // pokud neexistuje klic column, tak preskocit
            if (!key_exists("column", $item))
            {
                    echo "asi chyba v metode DBDelete - chybi klic column <br/>";
                    continue;
                    }

                    $column = $item["column"];					// pozor na column, mohlo by projit SQL injection
                    $symbol = $item["symbol"];

                    if (key_exists("value", $item))
                    $value_pom = "?"; 						// budu to navazovat
                    else if (key_exists("value_mysql", $item))
                    $value_pom = $item["value_mysql"]; 		// je to systemove, vlozit rovnou - POZOR na SQL injection, tady to muze projit


                    //echo "`$column` $symbol  $value_pom ";
                    $where_pom .= "$column $symbol  $value_pom ";
        }

            // 1) pripravit dotaz s dotaznikama
            $query = "delete from `$table_name` where $where_pom ;";

            // 2) pripravit si statement
            $statement = self::$connection->prepare($query);

            // 3) NAVAZAT HODNOTY k otaznikum dle poradi od 1
            $bind_param_number = 1;

            if ($item != null)
                foreach ($item as $column => $value)
                {
                $statement->bindValue($bind_param_number, $value);  // vzdy musim dat value, abych si nesparoval promennou (to nechci)
            $bind_param_number ++;
            }

            // 4) provest dotaz
            $statement->execute();

            // 5) kontrola chyb
            $errors = $statement->errorInfo();
            //printr($errors);

            if ($errors[0] + 0 > 0)
            {
            // nalezena chyba
            $mysql_pdo_error = true;
            }

            // 6) nacist ID vlozeneho zaznamu a vratit
            if ($mysql_pdo_error == false)
            {
            $item_id = self::$connection->lastInsertId();
            return $item_id;
            }
            else
                {
                echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
//	 			printr($errors);
                echo "SQL dotaz: $query";
                }
     }
	
	/**
	 * 
	 * Pridat polozku do DB - zakladni verze bez mysl fci typu now().
	 * @param unknown_type $table_name
	 * @param array $item - musi byt ve stejne podobe jako DB.
	 * 
	 * */
	 public function DBInsert($table_name, $item)
	 {
	 	// MySql
	 	$mysql_pdo_error = false;
	
	 	// SLOZIT TEXT STATEMENTU s otaznikama
	 	$insert_columns = "";
	 	$insert_values  = "";
	 			
	 	if ($item != null)
	 	foreach ($item as $column => $value)
	 	{
	 		// pridat carky
	 		if ($insert_columns != "") $insert_columns .= ", ";
	 		if ($insert_columns != "") $insert_values .= ", ";
	
	 		$insert_columns .= "`$column`";
	 		$insert_values .= "?";
	 		}
	
	 		// 1) pripravit dotaz s dotaznikama
	 		$query = "insert into `$table_name` ($insert_columns) values ($insert_values);";
	
	 		// 2) pripravit si statement
	 		$statement = self::$connection->prepare($query);
	
	 		// 3) NAVAZAT HODNOTY k otaznikum dle poradi od 1
	 		$bind_param_number = 1;
	
	 		if ($item != null)
	 			foreach ($item as $column => $value)
	 			{
	 			$statement->bindValue($bind_param_number, $value);  // vzdy musim dat value, abych si nesparoval promennou (to nechci)
	 		$bind_param_number ++;
	 		}
	 			
	 		// 4) provest dotaz
	 		$statement->execute();
	
	 		// 5) kontrola chyb
	 		$errors = $statement->errorInfo();
	 		//printr($errors);
	
	 		if ($errors[0] + 0 > 0)
	 		{
	 		// nalezena chyba
	 		$mysql_pdo_error = true;
	 		}
	
	 		// 6) nacist ID vlozeneho zaznamu a vratit
	 		if ($mysql_pdo_error == false)
	 		{
	 		$item_id = self::$connection->lastInsertId();
	 		return $item_id;
	 		}
	 		else
	 			{
	 			echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
//	 			printr($errors);
	 			echo "SQL dotaz: $query";
				}
	}
	
	
	/**
	* Pridat polozku do DB - rozsirena verze.
	*
	* @param string $table_name
	* @param array $item - column = sloupec; value - int nebo string nebo value_mysql
	*/
	public function DBInsertExpanded($table_name, $item)
	{
	 			    // MySql

	 			    // SLOZIT TEXT STATEMENTU s otaznikama
	 			    $insert_columns = "";
	 			 	$insert_values  = "";
	
	 			 	if ($item != null)
	 			 	foreach ($item as $row)
	 			 	{
	 			 	// pridat carky
	 			 	if ($insert_columns != "") $insert_columns .= ", ";
	 			 		if ($insert_columns != "") $insert_values .= ", ";
	
	 			 		$column = $row["column"];
	
	 			 		if (key_exists("value", $row))
	 			 				$value_pom = "?"; 						// budu to navazovat
	 			 				else if (key_exists("value_mysql", $row))
	 			 				$value_pom = $row["value_mysql"]; 		// je to systemove, vlozit rovnou - POZOR na SQL injection, tady to muze projit
	
	
	 			 				$insert_columns .= "`$column`";
	 			 				$insert_values .= "$value_pom";
	 			 	}
	
	 			 	// 1) pripravit dotaz s dotaznikama
	 			 				$query = "insert into `$table_name` ($insert_columns) values ($insert_values);";
//	 			 				echo $query;
	
	 			 				// 2) pripravit si statement
	 			 				$statement = self::$connection->prepare($query);
	
	 			 				// 3) NAVAZAT HODNOTY k otaznikum dle poradi od 1
	 			 				$bind_param_number = 1;
	
	 			 				if ($item != null)
	 			 					foreach ($item as $row)
	 			 					{
	 			 						if (key_exists("value", $row))
	 			 						{
	 			 							$value = $row["value"];
	 			 							//echo "navazuju value: $value";
	 			 								
	 			 							$statement->bindValue($bind_param_number, $value);  // vzdy musim dat value, abych si nesparoval promennou (to nechci)
	 			 							$bind_param_number ++;
	 			 						}
	 			 					}
	
	 			 					// 4) provest dotaz
	 			 					$statement->execute();
	
	 			 					// 5) kontrola chyb
	 			 					$errors = $statement->errorInfo();
//	 			 					print_r($errors);
	 			 					$mysql_pdo_error = false;
	
	 			 					if ($errors[0] + 0 > 0)
	 			 					{
	 			 						// nalezena chyba
	 			 						$mysql_pdo_error = true;
	 			 					}
	
	 			 					// 6) nacist ID vlozeneho zaznamu a vratit
	 			 					if ($mysql_pdo_error == false)
	 			 					{
	 			 						$item_id = self::$connection->lastInsertId();
	 			 						return $item_id;
	 			 					}
	 			 					else
	 			 					{
	 			 						echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
//	 			 						printr($errors);
	 			 						echo "SQL dotaz: $query";
		 			}
	}

	public function DBUpdate($table_name, $item, $where_array)
	{

        // vznik chyby v PDO
        $mysql_pdo_error = false;

        $set_pom = "";

        if ($item != null){
            foreach ($item as $row){

                // pridat carky
                if ($set_pom != "") $set_pom .= ", ";

                $column = $row["column"];

                if (key_exists("value", $row)){
                    $value_pom = "?"; 						// budu to navazovat
                }else if (key_exists("value_mysql", $row)){
                    $value_pom = $row["value_mysql"]; 		// je to systemove, vlozit rovnou - POZOR na SQL injection, tady to muze projit
                }

                $set_pom .= "`$column` = $value_pom";
            }
        }

        if (trim($set_pom) != "") $set_pom = "set $set_pom";

        $where_pom = "";

        if ($where_array != null){
            foreach ($where_array as $index => $item){
                if ($where_pom != "") $where_pom .= " AND ";

                if (!key_exists("column", $item)){
                    echo "asi chyba v metode DBUpdate - chybi klic column <br/>";
                    continue;
                }

                $column = $item["column"];					// pozor na column, mohlo by projit SQL injection
                $symbol = $item["symbol"];

                if (key_exists("value", $item))
                $value_pom = "?"; 						// budu to navazovat
                else if (key_exists("value_mysql", $item))
                $value_pom = $item["value_mysql"]; 		// je to systemove, vlozit rovnou - POZOR na SQL injection, tady to muze projit


                $where_pom .= "$column $symbol  $value_pom ";
            }
        }

        if (trim($where_pom) != "") $where_pom = "where $where_pom";

        $query = "update $table_name $set_pom $where_pom ;";
//        echo $query;

        // 2) pripravit si statement
        $statement = self::$connection->prepare($query);

        // 3) NAVAZAT HODNOTY k otaznikum dle poradi od 1
        $bind_param_number = 1;

        // 4) provest dotaz
        $statement->execute();

        // 5) kontrola chyb
        $errors = $statement->errorInfo();
        //printr($errors);

        if ($errors[0] + 0 > 0)
        {
            // nalezena chyba
            $mysql_pdo_error = true;
        }

        // 6) nacist data a vratit
        if ($mysql_pdo_error == false)
        {
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }else
        {
            echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
            echo "SQL dotaz: $query";
        }
	}
	
	// KONEC UNIVERZALNI METODY
	// ***********************************************************
	
	/**
	 * Připojí k vybrané db.
	 */
	public static function Connect()
	{
		// PDO - MySQL
		try
		{
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
		    if (!isset(self::$connection)){
		        self::$connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE_NAME."", DB_USER_LOGIN, DB_USER_PASSWORD, $options);
            }

			// nastavit pripojeni na UTF-8 - pro$connection starsi verze PHP
			//self::$connection->exec("SET NAMES UTF8");
	
		} catch (PDOException $e)
		{
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	} // konec Connect
	
	
	/**
	 * Odpojí se od vybrané databáze.
	 */
	function Disconnect()
	{
		self::$connection = null;
	}
	
	/**
	 * Vratit pdo pripojeni
	 */
	public static function GetConnection()
	{
		return self::$connection;
	}
}



?>