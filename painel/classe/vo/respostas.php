<?php
	
	class respostas {
		
		// Definições

		public $idResposta;
		public $userIdResposta;
		public $nomeResposta;
		public $descricaoResposta;
		public $imagemResposta;
		public $statusResposta;		
		
		// Metódos
		
		function newResposta() {
			
			$db = new DBMySQL();
			
			$query = "INSERT INTO `respostas` (`bannerIdResposta`,`userIdResposta`,`nomeResposta`,`descricaoResposta`,`imagemResposta`,`linkResposta`,`statusResposta`) VALUES ";
			
			$query .= "('".$this->bannerIdResposta."','".$this->userIdResposta."','".$this->nomeResposta."','".$this->descricaoResposta."','".$this->imagemResposta."','".$this->linkResposta."','".$this->statusResposta."');";
			
			$db->do_query($query);
			
			$db->close();			
			
		}
		
		function editResposta() {
			
			$db = new DBMySQL();
			
			$query = "UPDATE `respostas` SET";
			
			$query .= " `nomeResposta` = '".$this->nomeResposta."',";
			
			
			$query .= " `descricaoResposta` = '".$this->descricaoResposta."',";
			
			
			if($this->imagemResposta != "") {$query .= " `imagemResposta` = '".$this->imagemResposta."',";}
			
			$query .= " `linkResposta` = '".$this->linkResposta."',";

			$query .= " `statusResposta` = '".$this->statusResposta."'";
			
			$query .= " WHERE `idResposta` = '$this->idResposta'";
			
			$db->do_query($query);
			
			$db->close();
			
		}
		
		function deleteResposta() {
			
			$db = new DBMySQL();
			
			$query = "DELETE FROM `respostas` WHERE `idResposta` = '$this->idResposta'";
			
			$db->do_query($query);
			
			$db->close();		
			
		}
		
		function get() {
			
			$db = new DBMySQL();
			
			if($this->idResposta != "") {
				
				$query = "SELECT * FROM `respostas` WHERE `idResposta` = '$this->idResposta'";
				
				$db->do_query($query);
				
				$result = $db->getRow();
				
				
			} else {
				
				$query = "SELECT * FROM `respostas` ORDER BY `nomeResposta` ASC";
				
				$db->do_query($query);
				
				$r = 0;
				
				while($row = $db->getRow()) {
					
					$result[$r] = $row;
					
					$r++;
					
				}
				
			}
			
			return $result;
			
		}
		
		function getDescricao() {
			
			$db = new DBMySQL();
			
			$db->do_query("SELECT `descricaoResposta`,`nomeResposta` FROM `respostas` WHERE `idResposta` = $this->idResposta");
			
			return $db->getRow();
			
		}
		
		function getAll() {
			
			$db = new DBMySQL();
			
			$query = "SELECT * FROM `respostas` WHERE `statusResposta` = 1 ORDER BY `nomeResposta` ASC";
		
			$db->do_query($query);
		
			$r = 0;
		
			while($row = $db->getRow()) {
					
				$result[$r] = $row;
					
				$r++;
					
			}
			
			return $result;
			
		}

		function getAlluser($idBanner) {
			
			$db = new DBMySQL();
			
			$query = "SELECT * FROM `respostas` WHERE `bannerIdResposta` = $idBanner ORDER BY `idResposta` ASC";
		
			$db->do_query($query);
		
			$r = 0;
		
			while($row = $db->getRow()) {
					
				$result[$r] = $row;
					
				$r++;
					
			}
			
			return $result;
			
		}
		
		function countAll() {
			
			$db = new DBMySQL();
				
			$db->do_query("SELECT COUNT(`idResposta`) AS 'total' FROM `respostas` WHERE `statusResposta` = 1");
				
			return $db->getRow();
			
		}
		
		function count() {
			
			$db = new DBMySQL();
			
			$db->do_query("SELECT COUNT(`idResposta`) AS 'total' FROM `respostas`");
			
			$result = $db->getRow();
			
			return $result;
			
		}
		
		function paginacao($inicio,$TAMANHO_PAGINA) {
			
			$db = new DBMySQL();
			
			$db->do_query("SELECT * FROM `respostas` ORDER BY `nomeResposta` ASC LIMIT ".$inicio.",".$TAMANHO_PAGINA);
			
			$r = 0;
			
			while($row = $db->getRow()) {
				
				$result[$r] = $row;
				
				$r++;
				
			}
			
			return $result;
			
		}
		
		function paginacaoAll($inicio,$TAMANHO_PAGINA) {
				
			$db = new DBMySQL();
			
			$query = "SELECT * FROM `respostas` WHERE `statusResposta` = 1 ";
			
			
			
			$query .=  "ORDER BY `nomeResposta` ASC LIMIT ".$inicio.",".$TAMANHO_PAGINA;
				
			$db->do_query($query);
				
			$r = 0;
				
			while($row = $db->getRow()) {
		
				$result[$r] = $row;
		
				$r++;
		
			}
				
			return $result;
				
		}
		
	}


?>