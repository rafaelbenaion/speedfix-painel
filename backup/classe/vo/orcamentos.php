<?php
	
	class orcamentos {
		
		// Definições

		public $idBanner;
		public $userIdBanner;
		public $nomeBanner;
		public $descricaoBanner;
		public $imagemBanner;
		public $statusBanner;
		public $tipoBanner;	
		public $dataBanner;		
		
		// Metódos
		
		function newBanner() {
			
			$db = new DBMySQL();
			
			$query = "INSERT INTO `orcamentos` (`userIdBanner`,`nomeBanner`,`descricaoBanner`,`imagemBanner`,`linkBanner`,`statusBanner`,`tipoBanner`,`dataBanner`) VALUES ";
			
			$query .= "('".$this->userIdBanner."','".$this->nomeBanner."','".$this->descricaoBanner."','".$this->imagemBanner."','".$this->linkBanner."','".$this->statusBanner."','".$this->tipoBanner."','".$this->dataBanner."');";
			
			$db->do_query($query);
			
			$db->close();			
			
		}
		
		function editBanner() {
			
			$db = new DBMySQL();
			
			$query = "UPDATE `orcamentos` SET";
			
			$query .= " `nomeBanner` = '".$this->nomeBanner."',";
			
			
			$query .= " `descricaoBanner` = '".$this->descricaoBanner."',";
			
			
			if($this->imagemBanner != "") {$query .= " `imagemBanner` = '".$this->imagemBanner."',";}
			
			$query .= " `linkBanner` = '".$this->linkBanner."',";

			$query .= " `statusBanner` = '".$this->statusBanner."'";

			$query .= " `tipoBanner` = '".$this->tipoBanner."'";
			
			$query .= " WHERE `idBanner` = '$this->idBanner'";
			
			$db->do_query($query);
			
			$db->close();
			
		}
		
		function deleteBanner() {
			
			$db = new DBMySQL();
			
			$query = "DELETE FROM `orcamentos` WHERE `idBanner` = '$this->idBanner'";
			
			$db->do_query($query);
			
			$db->close();		
			
		}
		
		function get() {
			
			$db = new DBMySQL();
			
			if($this->idBanner != "") {
				
				$query = "SELECT * FROM `orcamentos` WHERE `idBanner` = '$this->idBanner'";
				
				$db->do_query($query);
				
				$result = $db->getRow();
				
				
			} else {
				
				$query = "SELECT * FROM `orcamentos` ORDER BY `nomeBanner` ASC";
				
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
			
			$db->do_query("SELECT `descricaoBanner`,`nomeBanner` FROM `orcamentos` WHERE `idBanner` = $this->idBanner");
			
			return $db->getRow();
			
		}
		
		function getAll() {
			
			$db = new DBMySQL();
			
			$query = "SELECT * FROM `orcamentos` WHERE `statusBanner` = 1 ORDER BY `nomeBanner` ASC";
		
			$db->do_query($query);
		
			$r = 0;
		
			while($row = $db->getRow()) {
					
				$result[$r] = $row;
					
				$r++;
					
			}
			
			return $result;
			
		}

		function getAlluser($user) {
			
			$db = new DBMySQL();

			if($user == 1){

				$query = "SELECT * FROM `orcamentos` WHERE 1 ORDER BY `idBanner` DESC";

			}else{
				$query = "SELECT * FROM `orcamentos` WHERE `userIdBanner` = $user ORDER BY `idBanner` DESC";
			}
			
			
		
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
				
			$db->do_query("SELECT COUNT(`idBanner`) AS 'total' FROM `orcamentos` WHERE `statusBanner` = 1");
				
			return $db->getRow();
			
		}
		
		function count() {
			
			$db = new DBMySQL();
			
			$db->do_query("SELECT COUNT(`idBanner`) AS 'total' FROM `orcamentos`");
			
			$result = $db->getRow();
			
			return $result;
			
		}
		
		function paginacao($inicio,$TAMANHO_PAGINA) {
			
			$db = new DBMySQL();
			
			$db->do_query("SELECT * FROM `orcamentos` ORDER BY `nomeBanner` ASC LIMIT ".$inicio.",".$TAMANHO_PAGINA);
			
			$r = 0;
			
			while($row = $db->getRow()) {
				
				$result[$r] = $row;
				
				$r++;
				
			}
			
			return $result;
			
		}
		
		function paginacaoAll($inicio,$TAMANHO_PAGINA) {
				
			$db = new DBMySQL();
			
			$query = "SELECT * FROM `orcamentos` WHERE `statusBanner` = 1 ";
			
			
			
			$query .=  "ORDER BY `nomeBanner` ASC LIMIT ".$inicio.",".$TAMANHO_PAGINA;
				
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