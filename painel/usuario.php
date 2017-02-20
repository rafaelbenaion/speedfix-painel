<?php
session_start();
if($_SESSION["autenticado_painel"] != "SIM"){
	header("Location: index.php");
}

require('lib/DBMySql.php');
require('classe/bo/utilidadesBO.php');

$utilidadesBO = new utilidadesBO();


if(!empty($_POST['alterar'])){
	$senhaAt = $_POST['senhaAt'];
	$senhaNv = $_POST['senhaNv'];
	$senhaCf = $_POST['senhaCf'];
	
	if(!empty($senhaAt) && !empty($senhaNv) && !empty($senhaCf)) {

		$vetRes = $utilidadesBO->executaSQL("SELECT `senha` FROM `users` WHERE `idusuario` = ".$_SESSION['autenticado_id'].";");
		if($vetRes[0]['senha'] == sha1($senhaAt)){
			if(sha1($senhaNv) == sha1($senhaCf)){
				$senhaBD = sha1($senhaNv);
				@$vetAtu = $utilidadesBO->executaSQL("UPDATE `users` SET `senha`='".$senhaBD."' WHERE `idusuario` = ".$_SESSION['autenticado_id'].";");
				$msgE = "Senha alterada com sucesso";
			} else {
			$msgE = "A nova senha e a confirmação não coincidem";
			}
		} else {
			$msgE = "Senha atual incorreta";
		}
		
	} else {
		
		$msgE = "Por favor, digite todos os dados corretamente";
		
	}
}



$areaAdmin = 'usuario';
?>
<?php include('meta.php') ?>
</head>

<body>
	<div id="wrapper">    	
    	<?php include('header.php') ?>        
        <div id="containerHolder">
			<div id="container">
                <div id="conteudo">
                	<h2><a href="">Perfil</a> &raquo; <a href="#" class="active"><?=$_SESSION['autenticado_login']?> (<?=$_SESSION['autenticado_id']?>)</a></h2>
                    <div id="main">
                    	<?php if($msgE != "") { ?><div class="errMsg"><?=$msgE?></div><?php } ?>
                    	<h3>Alterar senha:</h3>
                        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" >
                            <fieldset>
                                <p><label>Senha antiga : </label><input type="password" class="text-long" name="senhaAt" /></p>
                                <p><label>Nova senha : </label><input type="password" class="text-long" name="senhaNv" /></p>
                                <p><label>Confirmação da nova senha : </label><input type="password" class="text-long" name="senhaCf" /></p>
                                <input type="submit" value="Alterar" name="alterar" />
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</body>
</html>
