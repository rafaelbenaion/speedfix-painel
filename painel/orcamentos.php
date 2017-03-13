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
require('classe/vo/orcamentos.php');

$utilidadesBO = new utilidadesBO();
$uploadBO = new uploadBO();
$orcamentos = new orcamentos();


//$categoria = $categorias->get();

if(isset($_POST['cadastrar']) && $_POST['cadastrar'] == 'ENVIAR') {
	
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

		$orcamentos->userIdBanner = urlencode($_POST['userIdBanner']);
		
		$orcamentos->nomeBanner = urlencode($_POST['nome']);
		
		$orcamentos->descricaoBanner = urlencode($_POST['descricao']);
			
		$orcamentos->imagemBanner = $imagem;

		$orcamentos->linkBanner = $_POST['link'];
		
		$orcamentos->statusBanner = $_POST['status'];

		$orcamentos->tipoBanner = $_POST['tipo'];

		$orcamentos->dataBanner = date("d/m/Y");
		
		$orcamentos->newBanner();
		
		$msg = "Banner cadastrado com sucesso";
		
	} else {
		
		$msg = "Dados corrompidos VAZIO";
		
	}
	
}

if(isset($_POST['editar']) && $_POST['editar'] == 'Editar') {
	
	if(!empty($_POST['nome']) && !empty($_POST['descricao'])) {
		
		if($_POST['idhash'] == md5($_POST['id'])) {
			
			$orcamentos->idBanner = $_POST['id'];
			
			if($_FILES["imagem"]['error'] == 0 && $_FILES["imagem"]['size'] > 0){
		
			$uploadBO->pasta     = "../upload";
		
			$uploadBO->nome      = $_FILES["imagem"]['name'];
		
			$uploadBO->tmp_name  = $_FILES["imagem"]['tmp_name'];
		
			$uploadBO->img_marca = "";
		
			$imagem = $uploadBO->uploadArquivo(TRUE);
			
			$imagemAtual = $orcamentos->get();
			
			unlink('../upload/'.$imagemAtual['imagemBanner']);
				
			} else {
					
				$imagem = "";
					
			}
			
			$orcamentos->nomeBanner = urlencode($_POST['nome']);
					
			$orcamentos->descricaoBanner = urlencode($_POST['descricao']);
	
			$orcamentos->imagemBanner = $imagem;
			
			$orcamentos->linkBanner = $_POST['link'];

			$orcamentos->statusBanner = $_POST['status'];

			$orcamentos->tipoBanner = $_POST['tipo'];
			
			$orcamentos->editBanner();
			
			$msg = "Banner editado com sucesso";
			
		} else {
			
			$msg = "Dados corrompidos";
			
		}
		
		
	} else {
		
		$msg = "Dados corrompidos";
		
	}
	
	
}

if(isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
	
	if(md5($_GET['pid']) == $_GET['ptoken']) {
		
		$orcamentos->idBanner = $_GET['pid'];
		
		$banner = $orcamentos->get();
		
		unlink('../upload/'.$banner['imagemBanner']);
		
		$orcamentos->deleteBanner();
		
		$msg = "Banner excluído com sucesso";
		
	} else {
		
		$msg = "Dados corrompidos";
		
	}
	
}



$all = $orcamentos->getAlluser($_SESSION['autenticado_id']);

$areaAdmin = 'orcamentos';
?>
<?php include('meta.php') ?>
<script language="javascript">
	function exclui(pid,ptoken){
		if(confirm("Tem certeza que deseja excluir esse banner?")) {

			window.location.href = "orcamentos.php?acao=excluir&id=<?=$_GET['id']?>&token=<?=$_GET['token']?>&pid="+pid+"&ptoken="+ptoken;
			
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
                        <li><a href="orcamentos_ins.php?id=<?=$_GET['id']?>&token=<?=$_GET['token']?>">Cadastrar banner</a></li>
       
                    </ul>
                </div>                
                <div id="conteudo">
                	<h2><a href="principal.php">Dashboard</a> &raquo; <a href="#" class="active">orcamentos</a></h2>
                    <div id="main">
                    	<?php if($msg != "") { ?><div class="errMsg"><?=$msg?></div><?php } ?>
                    	<h3>orcamentos cadastrados</h3>
                    	<table cellpadding="0" cellspacing="0">
                        	<?php

                        		$r = 0;
                        		
                        		while(@$all[$r]) {
                        	
                        	?>
							<tr <?php if($r%2 == 0){echo 'class="odd"';}?>>
                            	<td><?=urldecode($all[$r]['nomeBanner'])?></td>
                                <td class="action">
                                	
   <a href="banner.php?i=<?=$all[$r]['idBanner']?>&token=<?=md5($all[$r]['idBanner'])?>&ci=<?=$_GET['id']?>&ctoken=<?=$_GET['token']?>class="see" title="Editar banner">Ver</a>
                                	<?php if($_SESSION['autenticado_id']==1){ ?>
                                	<a href="orcamentos_res.php?i=<?=$all[$r]['idBanner']?>&token=<?=md5($all[$r]['idBanner'])?>&ci=<?=$_GET['id']?>&ctoken=<?=$_GET['token']?>" class="edit" title="Editar banner">Responder</a>
                                	<?php } ?>
                                	<a href="javascript:void(0)" onclick="javascript: exclui('<?=$all[$r]['idBanner']?>','<?=md5($all[$r]['idBanner'])?>');" class="delete" title="Excluir">Delete</a>
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
