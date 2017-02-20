<?
class DBMySQL {
    var $username="root";
    var $password="";
    var $host="localhost";
    var $database="px";

	var $link;
	var $result;
	var $last_query;
	var $current_table;
	var $numrows;
	var $numfields;
	var $fields;
	var $init_done;

        function DBMySQL () {
                $this->init_done = 0;
                $this->numrows = 0;
                $this->numfields = 0;
                $this->fields[0] = "";
        }

        function init () {
			$this->init_done = 1;
			$this->open();
        }

        function setHost () {
                $this->host = $host;

        }

        function setDatabase () {
                $this->database = $database ;
        }

        function setUser () {
                $this->username = $username;
        }

        function setPassword () {
			$this->password = $password;

        }

	function open () {
                if ($this->init_done == 1) {
                        $this->link = mysql_connect($this->host, $this->username, $this->password) or
                                die ("Could not connect.");
						mysql_select_db ($this->database) or
                                die (" DB: function open: Could not select database.");
                }
                else {
					$this->init();
//                        echo "<center><b>Class DB not initialized.
//                                Use 'init' function to do so.</b><br /></center>";
                }
	}
	function close () {
		mysql_close($this->link);
	}

	function setDB ($newDatabase) {
		$this->database = $newDatabase;
		mysql_select_db ($this->database)
			or die ("DB: function setDB: Could not re-select database to \'$newDatabase\'");
	}
	
	function do_query ($query) {
				// abre conex o com o banco
			    $this->open();

                $query = preg_replace ("/;.*/", "", $query); // Security... See function do_query_secure
//                $patterns = array("/DROP.*/i","/^DELETE/i"); // Security... See function do_query_secure
//		if ( !(preg_match ("/DROP.*/i", $query)) and // Security... See function do_query_secure
//		   !(preg_match ("/^DELETE/i", $query)) ) {   // Security... See function do_query_secure
                        $this->last_query = $query;
			//echo "$query";                //Debug Line
			$resultid = mysql_query ($query) or
                                die ("<b>Query failed (function do_query: $query)</b><br />".mysql_error());

			//echo "<b>$resultid</b>";      //Debug Line
                        //NOTE:  This is to make row count work in case a modifying SQL statement
                        // is called.
			if ( preg_match("/^SELECT/i", $query) ) {
	                        $rows = mysql_num_rows($resultid);
        	                $this->numfields = mysql_num_fields ($resultid);
							if ($rows!=0) {
				                $this->getFields($resultid);
							}

			}
			else {
	                        $rows = mysql_affected_rows($this->link);
                                // Assign -1 because mysql_num_fields won't work
                                // for modifying SQL commands.
        	                $this->numfields = -1;
			}

//		}
//		else { // Security... See function do_query_secure
//			echo "<b>QUERY CANNOT DO THAT!  See web Administrator if
//                        you need to drop or delete records, tables or databases.</b><br />";
//
//                        $resultid = "ERR_do_query()";
//		}

                $this->result = $resultid;
                $this->numrows = $rows;
         //      $this->numfields = $fields;
                //echo "Test for do_query: [rows: " . $this->numrows . " fields: "  //Debug Line
                //. $this->numfields . "] <br /><br />"; //Debug Line

                //return ($this->result);  //cool to add for linking functions
                                //together in future
        }

	function do_query_secure ($query, $user) {
                // For use when deleting records, coded OUT of use in the regular
                                //do_query function
                // Add a check to make sure the user is valid, and make sure the
                                //user var passed is secure also
                $query = preg_replace ("/;.*/", "", $query);
		$this->last_query = $query;
                $resultid = mysql_query ($query) or
                        die ("<b>Query failed (function do_query_secure: $query)</b>");
		//echo "<b>$resultid</b>";
                //NOTE:  This is to make row count work in case a modifying SQL statement
                // is called.
                if ( preg_match("/^SELECT/i", $query) ) {
	                $rows = mysql_num_rows($resultid);
                        $this->numfields = mysql_num_fields ($resultid);
                        $this->getFields($resultid);



                }
                else {
                	$rows = mysql_affected_rows($this->link);
                        // Assign -1 because mysql_num_fields won't work
                        // for modifying SQL commands.
                        $this->numfields = -1;
               }


                $this->result = $resultid;
                $rows = mysql_num_rows($resultid);
                //$fields = mysql_num_fields ($resultid);
                $this->numrows = $rows;

                //return ($this->result);  //cool to add for linking functions
                                                //together in future
	}

	function getResult () {
		return $this->result;
	}

	function getLastQuery () {
		return $this->last_query;
	}

	function getRow () {
		return (mysql_fetch_assoc($this->result));
	}

	function getRowNum () {
		return (mysql_fetch_row($this->result));
	}

	function getRowExtended () {
		return (mysql_fetch_array($this->result));
	}

	function displayResultTable () {
                if ($this->result != false) {
                        mysql_data_seek($this->result, 0);
                        //echo "Rows: " . $this->numrows . "<br />" ;     //Debug Line
                        //echo "Fields: " . $this->numfields . "<br />" ; //Debug Line
			echo "<table border=1>\n";
                        echo "<tr>";
                        foreach ($this->fields as $field) {
                                echo "<th>$field</th>";
                        }
                        echo "</tr>\n";
			while ($line = $this->getRow()) {
                                echo "<tr>";
				foreach ($line as $value) {
                                        echo "<td>$value</td>";
				}
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		else {
			echo "<b>No Records returned</b><br />\n";
		}
	}
        function getFields($result) {
                mysql_data_seek($result, 0);

                //echo "<b>Entered GetFields(numFields: " //Debug Line
                //. $this->numfields . ")</b><br />";     //Debug line
                $i = 0;
                while ($i < $this->numfields) {
                        //echo "<b>Entered While loop</b><br />";  //Debug line
                        $currField = mysql_fetch_field($result, $i);
                        $this->fields[$i] = $currField->name;
                        $i++;
                        //echo "<b>Finihed one pass (". $this->fields[$i] . " = " //Debug Line
                        // . $currField->name . ")</b><br />";                    //Debug line
                }
                mysql_data_seek($result, 0);
        }

	function clearResult () {
		mysql_free_result ($this->link);
		$this->result = false;
	}

	function getNumRows () {
		return ($this->numrows);
	}

        function getNumFields () {
		return ($this->numfields);
	}


}
//                END class DBMySQL
//------------------------------------------------------------------------------

?>
