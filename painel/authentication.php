<?php

require('lib/DBMySql.php');
require 'classe/bo/CRUDMySQL.php';

function getADM($login){
	$db = new DBMySQL;
	$qry  = "SELECT * FROM `users` WHERE `login` = '$login'";
	$db->do_query($qry);

	while ($row = $db->getRow()) {
		$dadosADM["DS_ID"] = $row["idusuario"];
		$dadosADM["DS_LOGIN"] = $row["login"];
		$dadosADM["DS_NOME"] = $row["nome"];
		$dadosADM["DS_SENHA"] = $row["senha"];
	}
	$db->close();

	return $dadosADM;
}
function anti_injection($sql){
	// remove palavras que contenham sintaxe sql
	$sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
	$sql = trim($sql);
	$sql = strip_tags($sql);
	$sql = addslashes($sql);
	return $sql;
}

if($_GET['act'] == 'out'){
	session_start();
	$_SESSION["autenticado_painel"] = NULL;
	$_SESSION["autenticado_id"] = NULL;
	$_SESSION["autenticado_login"] = NULL;
	$_SESSION["autenticado_nome"] = NULL;
	session_destroy();
	header("Location: index.php");
} else {
	if (isset($_POST["enviar"]) == "Entrar"){
		$login = anti_injection($_POST["usuario"]);
		$senha = anti_injection($_POST["senha"]);
		$senha_u = sha1($senha);
		$dadosADM = getADM($login);
		$senha_b = $dadosADM["DS_SENHA"];
		if(strtoupper($dadosADM["DS_LOGIN"]) == strtoupper($login)){
			if($senha_b == $senha_u){
				session_start();
				$_SESSION["autenticado_painel"] = "SIM";
				$_SESSION["autenticado_id"] = $dadosADM["DS_ID"];
				$_SESSION["autenticado_login"] = $dadosADM["DS_LOGIN"];
				$_SESSION["autenticado_nome"] = $dadosADM["DS_NOME"];
				
				header("Location: home.php");
			}else{
				$msg = "Oops, senha incorreta!";
			}
		}else{
			$msg = "Oops, esse email não existe!";
		}
	}else{
		$msg = "";
	}
	header("Location: index.php?msg=$msg");
}



if (isset($_POST["cadastro"]) == "Cadastrar"){
	
		
		$CRUDMySQL = new CRUDMySQL();
		//$CRUDMySQL->newUser($_POST["usuario"],$_POST["senha"])

		if($CRUDMySQL->newUser($_POST["usuario"],$_POST["senha"],$_POST["nome"],$_POST["cpf"])){
		
			$msg = "Cadastrado!";

				$login = anti_injection($_POST["usuario"]);
				$senha = anti_injection($_POST["senha"]);
				$senha_u = sha1($senha);
				$dadosADM = getADM($login);
				$senha_b = $dadosADM["DS_SENHA"];
				if(strtoupper($dadosADM["DS_LOGIN"]) == strtoupper($login)){
					if($senha_b == $senha_u){
						session_start();
						$_SESSION["autenticado_painel"] = "SIM";
						$_SESSION["autenticado_id"] = $dadosADM["DS_ID"];
						$_SESSION["autenticado_login"] = $dadosADM["DS_LOGIN"];
						$_SESSION["autenticado_nome"] = $dadosADM["DS_NOME"];
						header("Location: perfil.php");
					}else{
						$msg = "Oops, tente logar mais tarde.";
					}
				}else{
					$msg = "Oops, tente logar mais tarde.";
				}
			


		}else{
			$msg = "Oops, erro no cadastro! Esse email já existe.";
		}
	header("Location: cadastro.php?msg=$msg");		
	}

?>