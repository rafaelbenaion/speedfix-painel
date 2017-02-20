<?php

	class CRUDMySQL {
		 
		public function tableName() {
			return "`teste`";
		}
		
		public function fillField() {
			$tableName = $this->tableName();
			$tableName = str_replace("_", " ", $tableName);
			$tableName = str_replace("`", "", $tableName);
			$tableName = ucwords($tableName);
			$tableName = str_replace(" ", "", $tableName);
			return $tableName;
		}

		public function newUser($login, $senha) {
			
			$db = new DBMySQL();
			
			$newUser = "INSERT INTO `users` (`idusuario`, `login`, `senha`) VALUES (NULL, '".$login."', SHA1('".$senha."'));";
			
			$db->do_query($newUser);
			
			$db->close();

			return true;
			
		}
		
		public function insert($fields) {
			
			$db = new DBMySQL();
			
			$fillField = $this->fillField();
			
			$lineInsertColumns = "INSERT INTO ".$this->tableName()." (";
			$lineInsertValues = " VALUES (";
			
			foreach($fields as $key => $value) {
				$lineInsertColumns .= "`" .$key. "`,";
				if(is_int($value)) {		
					$lineInsertValues .= "".$value.",";
				} else {
					$lineInsertValues .= "'".$value."',";
				}
			}
			
			$lineInsertColumns = substr($lineInsertColumns, 0, strlen($lineInsertColumns)-1);
			$lineInsertValues = substr($lineInsertValues, 0, strlen($lineInsertValues)-1);
			
			$lineInsertColumns .= ")";
			$lineInsertValues .= ")";
			
			$db->do_query($lineInsertColumns . $lineInsertValues);
			
			$db->close();
			
		}
		
		public function update($fields, $where = "", $whereCondition = false) {
			
			$db = new DBMySQL();
			
			$condition = ($whereCondition) ? "AND" : "OR";
			
			$fillField = $this->fillField();
			
			$updateQuery = "UPDATE ".$this->tableName()." SET";
			
			foreach($fields as $key => $value) {
				
				if(is_int($value)) {		
					$updateQuery .= " `".$key . $fillField."` = ".$value.",";
				} else {
					$updateQuery .= " `".$key . $fillField."` = '".$value."',";
				}
				
			}
			
			$updateQuery = substr($updateQuery, 0, strlen($updateQuery)-1);
			
			if(!empty($where)) {
				
				$updateQuery .= " WHERE";
				
				$i = 0;
				
				foreach($where as $key => $value) {
					$value = explode(",", $value);
					for($c = 0; $c < count($value); $c++) {
						if($c == 0) {
							$updateQuery .= "(";
						}
						if($i > 0) {
							$updateQuery .= " " . $condition;
						}
						if(is_int($value[$c])) {		
							$updateQuery .= " `".$key . $fillField."` = ".$value[$c]."";
						} else {
							$updateQuery .= " `".$key . $fillField."` = '".$value[$c]."'";
						}
						$i++;
					}
					$updateQuery .= ");";
				}
				
			} else {
				$updateQuery .= ";";
			}
			
			//echo $updateQuery;
			
			$db->do_query($updateQuery);
			
			$db->close();
			
		}
		
		public function delete($where = "", $whereCondition = false) {
			
			$db = new DBMySQL();
			
			$condition = ($whereCondition) ? "AND" : "OR";
			
			$fillField = $this->fillField();
			
			$updateQuery = "DELETE FROM ".$this->tableName()."";
			
			if(!empty($where)) {
				
				$updateQuery .= " WHERE";
				
				$i = 0;
				
				foreach($where as $key => $value) {
					$value = explode(",", $value);
					for($c = 0; $c < count($value); $c++) {
						if($c == 0) {
							$updateQuery .= "(";
						}
						if($i > 0) {
							$updateQuery .= " " . $condition;
						}
						if(is_int($value[$c])) {		
							$updateQuery .= " `".$key . $fillField."` = ".$value[$c]."";
						} else {
							$updateQuery .= " `".$key . $fillField."` = '".$value[$c]."'";
						}
						$i++;
					}
					$updateQuery .= ");";
				}
				
			}
			
			//echo $updateQuery;
			
			$db->do_query($updateQuery);
			
			$db->close();
			
		}
		
		function count() {
			
			$db = new DBMySQL();
			
			if(strtolower($this->tableName()) == '`usuario`' || strtolower($this->tableName()) == '`usuarios`') {
				$db->do_query("SELECT COUNT(*) AS 'total' FROM ".$this->tableName()." WHERE `id".$this->fillField()."` <> ".$_SESSION['autenticado_id'].";");
			} else {
				$db->do_query("SELECT COUNT(*) AS 'total' FROM ".$this->tableName().";");	
			}
			
			$result = $db->getRow();
			
			$db->close();
			
			return $result['total'];
			
		}
		
		function paginacao($inicio, $TAMANHO_PAGINA) {
			
			$db = new DBMySQL();
			
			if(strtolower($this->tableName()) == '`usuario`' || strtolower($this->tableName()) == '`usuarios`') {
				$db->do_query("SELECT * FROM ".$this->tableName()." WHERE `id".$this->fillField()."` <> ".$_SESSION['autenticado_id']." ORDER BY `id".$this->fillField()."` DESC LIMIT ".$inicio.",".$TAMANHO_PAGINA);
			} else {
				$db->do_query("SELECT * FROM ".$this->tableName()." ORDER BY `id".$this->fillField()."` DESC LIMIT ".$inicio.",".$TAMANHO_PAGINA);	
			}
			
			for($i = 0; $row = $db->getRow(); $i++) {
				$result[$i] = $row;
			}
			
			$db->close();
			
			return $result;
			
		}
		
	}