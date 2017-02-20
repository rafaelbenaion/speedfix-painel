<?php
session_start();
if($_SESSION["autenticado_painel"] == "SIM"){
	header("Location: principal.php");
}
$msg = empty($_GET['msg'])? "Novo Cadastro" : $_GET['msg'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>Sistema administrativo</title>
<link href="style/css/reset.css" rel="stylesheet" type="text/css" media="screen" />
<link href="style/css/layout.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="style/js/jquery-1.5.min.js"></script>
<script type="text/javascript" src="style/js/jquery.validate.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$("#login").validate({
		errorLabelContainer: $("#errorMsg"),
		rules: {
			usuario: {
				required:true,
				minlength:5
			},
			senha: {
				required: true,
				minlength:3
			}
		},
		messages: {
			usuario: {
				required:"Preencha o campo usuário<br/>",
				minlength:"O usuário deve ter ao menos 5 caracteres<br/>"
			},
			senha: {
				required:"Você deve informar uma senha<br/>",
				minlength:"A senha deve ter ao menos 5 caracteres<br/>"
			}
		},
	});
	$('#login input:not(#enviar)').each(function(){
		var valor = $(this).val();
		$(this).focus(function(){
			if($(this).val() == valor){
				$(this).val("");
			}
		});
		$(this).blur(function(){
			if($(this).val() == ""){
				$(this).val(valor);
			}
		});
	});
})
</script>

</head>

<body>

  <div id="login">
    	<div class="body_login">
        	<div class="conteudo">
            	<h1>
                	<span><?=$msg?></span>
                	<span id="errorMsg"></span>
                </h1>
                <form action="processausuarios.php" method="post">
                	<div class="row">
                    	<label for="usuario">Usuário:</label>
                        <div class="usuario">
                        	<input type="text" value="Usuario" id="usuario" name="usuario" />
                        </div>                        
                    </div>
                    <div class="row">
                    	<label for="senha">Senha:</label>
                        <div class="senha">
                        	<input type="password" value="Senha" id="senha" name="senha" />
                        </div>                        
                    </div>
                    <div>
                    	<input type="submit" value="Cadastrar" id="enviar" name="cadastro" />
                        <div class="clear"></div>
                    </div>
                    <br>
                        <a href="index.php">Já tenho uma conta.</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>