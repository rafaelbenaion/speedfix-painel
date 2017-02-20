<?php
session_start();
if($_SESSION["autenticado_painel"] != "SIM"){
	header("Location: index.php");
}

//if($_SESSION['autenticado_login'] != 'admin') {
//	header("Location: principal.php");
//}



require('lib/DBMySql.php'); 
require('classe/bo/utilidadesBO.php');
require('classe/bo/uploadBO.php');

require_once 'classe/vo/respostas.php';

$utilidadesBO = new utilidadesBO();

$uploadBO = new uploadBO();


$respostas = new respostas();




//$categoria = $categorias->get();

if(isset($_POST['cadastrar']) && $_POST['cadastrar'] == 'Cadastrar') {
	
	if(!empty($_POST['nome']) && !empty($_POST['descricao'])) {
		
		if($_FILES["imagem"]['error'] == 0 && $_FILES["imagem"]['size'] > 0){
		
			$uploadBO->pasta     = "../upload";
		
			$uploadBO->nome      = $_FILES["imagem"]['name'];
		
			$uploadBO->tmp_name  = $_FILES["imagem"]['tmp_name'];
		
			$uploadBO->img_marca = "";
		
			$imagem = $uploadBO->uploadArquivo(TRUE);
				
		} else {
				
			$imagem = "";
				
		}


		$respostas->bannerIdResposta = urlencode($_POST['bannerIdResposta']);

		$respostas->userIdResposta = urlencode($_POST['userIdResposta']);

		$respostas->nomeResposta = urlencode($_POST['nome']);
		
		$respostas->descricaoResposta = urlencode($_POST['descricao']);
			
		$respostas->imagemResposta = $imagem;

		$respostas->linkResposta = $_POST['link'];
		
		$respostas->statusResposta = $_POST['status'];
		
		$respostas->newResposta();
		
		$msg = "Resposta cadastrado com sucesso";
		
	} else {
		
		$msg = "Dados corrompidos";
		
	}
	
}

if(isset($_POST['editar']) && $_POST['editar'] == 'Editar') {
	
	if(!empty($_POST['nome']) && !empty($_POST['descricao'])) {
		
		if($_POST['idhash'] == md5($_POST['id'])) {
			
			$respostas->idResposta = $_POST['id'];
			
			if($_FILES["imagem"]['error'] == 0 && $_FILES["imagem"]['size'] > 0){
		
			$uploadBO->pasta     = "../upload";
		
			$uploadBO->nome      = $_FILES["imagem"]['name'];
		
			$uploadBO->tmp_name  = $_FILES["imagem"]['tmp_name'];
		
			$uploadBO->img_marca = "";
		
			$imagem = $uploadBO->uploadArquivo(TRUE);
			
			$imagemAtual = $respostas->get();
			
			unlink('../upload/'.$imagemAtual['imagemResposta']);
				
			} else {
					
				$imagem = "";
					
			}
			
			$respostas->nomeResposta = urlencode($_POST['nome']);
					
			$respostas->descricaoResposta = urlencode($_POST['descricao']);
	
			$respostas->imagemResposta = $imagem;
			
			$respostas->linkResposta = $_POST['link'];

			$respostas->statusResposta = $_POST['status'];
			
			$respostas->editResposta();
			
			$msg = "Resposta editado com sucesso";
			
		} else {
			
			$msg = "Dados corrompidos";
			
		}
		
		
	} else {
		
		$msg = "Dados corrompidos";
		
	}
	
	
}

if(isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
	
	if(md5($_GET['pid']) == $_GET['ptoken']) {
		
		$respostas->idResposta = $_GET['pid'];
		
		$resposta = $respostas->get();
		
		unlink('../upload/'.$resposta['imagemResposta']);
		
		$respostas->deleteResposta();
		
		$msg = "Resposta excluído com sucesso";
		
	} else {
		
		$msg = "Dados corrompidos";
		
	}
	
}



$all = $respostas->getAlluser($_SESSION['autenticado_id']);

$areaAdmin = 'respostas';
?>
<?php include('meta.php') ?>
<script language="javascript">
	function exclui(pid,ptoken){
		if(confirm("Tem certeza que deseja excluir esse resposta?")) {

			window.location.href = "respostas.php?acao=excluir&id=<?=$_GET['id']?>&token=<?=$_GET['token']?>&pid="+pid+"&ptoken="+ptoken;
			
		}
	}
</script>
</head>

<body>
	<div id="wrapper">    	
    	<?php include('header.php') ?>        
        <div id="containerHolder">
			<div id="container">            	
                <div id="sidebar">
                	<ul class="sideNav">
                        <li><a href="orcamentos.php?id=<?=$_GET['id']?>&token=<?=$_GET['token']?>">Orçamentos</a></li>
       
                    </ul>
                </div>                
                <div id="conteudo">
                	<h2><a href="principal.php">Dashboard</a> &raquo; <a href="#" class="active">Respostas</a></h2>
                    <div id="main">
                    	<?php if($msg != "") { ?><div class="errMsg"><?=$msg?></div><?php } ?>
                    	
                    	<table cellpadding="0" cellspacing="0">
                        	<?php

                        		$r = 0;
                        		
                        		while(@$all[$r]) {
                        	
                        	?>
							<tr <?php if($r%2 == 0){echo 'class="odd"';}?>>
                            	<td><?=urldecode($all[$r]['nomeResposta'])?></td>
                                <td class="action">
                                	
                                	<a href="respostas_edt.php?i=<?=$all[$r]['idResposta']?>&token=<?=md5($all[$r]['idResposta'])?>&ci=<?=$_GET['id']?>&ctoken=<?=$_GET['token']?>" class="see" title="Editar resposta">Ver</a>
                                	<a href="respostas_res.php?i=<?=$all[$r]['idResposta']?>&token=<?=md5($all[$r]['idResposta'])?>&ci=<?=$_GET['id']?>&ctoken=<?=$_GET['token']?>" class="edit" title="Editar resposta">Responder</a>
                                	<a href="javascript:void(0)" onclick="javascript: exclui('<?=$all[$r]['idResposta']?>','<?=md5($all[$r]['idResposta'])?>');" class="delete" title="Excluir">Delete</a>
                               	</td>
                           	</tr>
                           	<?php
                           	
                           			$r++;
                           	
                        		}
                           	
                           	?>
                    	</table>
                    </div>
                    
                </div>
                <div class="clear"></div>
            </div>
        </div>
     
    </div>
</body>
</html>
