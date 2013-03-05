<?php
class Database{
	/* 
	 * Create variables for credentials to MySQL database
	 * The variables have been declared as private. This
	 * means that they will only be available with the 
	 * Database class
	 */
	private $db_host = "localhost";  // Change as required
	private $db_user = "rstandley_co_uk";  // Change as required
	private $db_pass = "******";  // Change as required
	private $db_name = "rstandley_co_uk";	// Change as required
	
	/*
	 * Extra variables that are required by other function such as boolean con variable
	 */
	private $con = false; // Check to see if the connection is active
	private $result = array(); // Any results from a query will be stored here
	
	// Function to make connection to database
	public function connect(){
		if(!$this->con){
			$myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);  // mysql_connect() with variables defined at the start of Database class
            if($myconn){
            	$seldb = @mysql_select_db($this->db_name,$myconn); // Credentials have been pass through mysql_connect() now select the database
                if($seldb){
                	$this->con = true;  
                    return true;  // Connection has been made return TRUE
                }else{  
                    return false;  // Problem selecting database return FALSE
                }  
            }else{  
                return false; // Problem connecting return FALSE
            }  
        }else{  
            return true; // Connection has already been made return TRUE 
        }  	
	}
	
	// Function to disconnect from the database
    public function disconnect(){
    	// If there is a connection to the database
    	if($this->con){
    		// We have found a connection, try to close it
    		if(@mysql_close()){
    			// We have successfully closed the connection, set the connection variable to false
    			$this->con = false;
				// Return true tjat we have closed the connection
				return true;
			}else{
				// We could not close the connection, return false
				return false;
			}
		}
    }
	
	// Function to SELECT from the database
    public function select($table, $rows = '*', $where = null, $order = null){
    	// Create query from the variables passed to the function
    	$q = 'SELECT '.$rows.' FROM '.$table;
		if($where != null){
        	$q .= ' WHERE '.$where;
		}
        if($order != null){
            $q .= ' ORDER BY '.$order;
		}
		// Check to see if the table exists
        if($this->tableExists($table)){
        	// The table exists, run the query
        	$query = @mysql_query($q);
			if($query){
				// If the query returns >= 1 assign the number of rows to numResults
				$this->numResults = mysql_num_rows($query);
				// Loop through the query results by the number of rows returned
				for($i = 0; $i < $this->numResults; $i++){
					$r = mysql_fetch_array($query);
                	$key = array_keys($r);
                	for($x = 0; $x < count($key); $x++){
                		// Sanitizes keys so only alphavalues are allowed
                    	if(!is_int($key[$x])){
                    		if(mysql_num_rows($query) > 1){
                    			$this->result[$i][$key[$x]] = $r[$key[$x]];
							}else if(mysql_num_rows($query) < 1){
								$this->result = null;
							}else{
								$this->result[$key[$x]] = $r[$key[$x]];
							}
						}
					}
				}
				return true; // Qury was successful
			}else{
				return false; // No rows where returned
			}
      	}else{
      		return false; // Table does not exist
    	}
    }
	
	// Function to insert into the database
    public function insert($table,$values,$rows = null){
    	// Check to see if the table exists
    	 if($this->tableExists($table)){
    	 	// The table does exist, carry on with the query creation
            $insert = 'INSERT INTO '.$table;
            if($rows != null){
                $insert .= ' ('.$rows.')';
            }
			// Loop through each value and add them to the query
            for($i = 0; $i < count($values); $i++){
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';
            $ins = @mysql_query($insert); // Make the query to insert to the database
            if($ins){
                return true; // The data has been inserted
            }else{
                return false; // The data has not been inserted
            }
        }
    }
	
	//Function to delete table or row(s) from database
    public function delete($table,$where = null){
    	// Check to see if table exists
    	 if($this->tableExists($table)){
    	 	// The table exists check to see if we are deleting rows or table
    	 	if($where == null){
                $delete = 'DELETE '.$table; // Create query to delete table
            }else{
                $delete = 'DELETE FROM '.$table.' WHERE '.$where; // Create query to delete rows
            }
            $del = @mysql_query($delete); // Submit query to database
            if($del){
                return true; // The query exectued correctly
            }else{
               return false; // The query did not execute correctly
            }
        }else{
            return false; // The table does not exist
        }
    }
	
	// Function to update row in database
    public function update($table,$rows,$where){
    	// Check to see if table exists
    	if($this->tableExists($table)){
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
            for($i = 0; $i < count($where); $i++){
                if($i%2 != 0){
                    if(is_string($where[$i])){
                        if(($i+1) != null){
                            $where[$i] = '"'.$where[$i].'" AND ';
                        }else{
                            $where[$i] = '"'.$where[$i].'"';
						}
                    }
                }
            }
            $where = implode('=',$where);
            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($rows);
            for($i = 0; $i < count($rows); $i++){
                if(is_string($rows[$keys[$i]])){
                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
                }else{
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }
                // Parse to add commas
                if($i != count($rows)-1){
                    $update .= ',';
                }
            }
            $update .= ' WHERE '.$where;
            $query = @mysql_query($update); // Make query to database
            if($query){
            	return true; // Update has been successful
            }else{
                return false; // Update has not been successful
            }
        }else{
            return false; // The table does not exist
        }
    }
	
	// Private function to check if table exists for use with queries
	private function tableExists($table){
		$tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb){
        	if(mysql_num_rows($tablesInDb)==1){
                return true; // The table exists
            }else{
                return false; // The table does not exist
            }
        }
    }
} 
