<?php
session_start();
if($_SESSION["autenticado_painel"] != "SIM") {
	header("Location: index.php");
}

//if($_SESSION['autenticado_login'] != 'admin') {
//	header("Location: principal.php");
//}


require('lib/DBMySql.php');

require('classe/bo/utilidadesBO.php');

require_once 'classe/vo/orcamentos.php';


$orcamentos = new orcamentos();

$orcamentos->idBanner = $_GET['i'];


$banner = $orcamentos->get();

//$categoria = $categorias->get();

$areaAdmin = 'orcamentos';

include('meta.php');

?>
<script type="text/javascript" src="style/js/jquery-1.5.min.js"></script>
<script type="text/javascript" src="style/js/jquery.validate.min.js"></script>
</head>

<body>
	<div id="wrapper">    	
    	<?php include('header.php') ?>        
        <div id="containerHolder">
			<div id="container">
                <div id="sidebar">
                	<ul class="sideNav">
                        <li><a href="orcamentos.php?id=<?=$_GET['ci']?>&token=<?=$_GET['ctoken']?>">Ver orcamentos </a></li>
                    </ul>
                </div>
                <div id="conteudo">
                	<h2><a href="principal.php">Dashboard</a> &raquo; <a href="orcamentos.php?<?=$_SERVER['QUERY_STRING']?>">orcamentos</a> &raquo; <a href="#" class="active">Editar banner</a></h2>
                    <div id="main">
                    	<div id="errorMsg"></div>
                    	<h3>Ver banner (Ref.:<?=urldecode($banner['idBanner'])?>)</h3>
                    	<form action="orcamentos.php?id=<?=$_GET['ci']?>&token=<?=$_GET['ctoken']?>" method="post" enctype="multipart/form-data">
                    		<fieldset>
                             <p><label>User : <?=urldecode($banner['userIdBanner'])?></label></p>
                                <p><label>Título : <?=urldecode($banner['nomeBanner'])?></label></p>
                               
                                <p><label>Descrição : <?=urldecode($banner['descricaoBanner'])?></label></p>

                                <p><label>Link : <?=urldecode($banner['linkBanner'])?></label></p>
                               
                                <p><label>Anexo : </label><img src="../upload/<?=$banner['imagemBanner']?>" width="150" /> <br><br><a href="../upload/<?=$banner['imagemBanner']?>">Baixar anexo</a></p>

                            
                            </fieldset>
                  
                    	</form>
                    </div>
                </div>
                <div id="conteudo">
                   
                    <div id="main">
                        <div id="errorMsg"></div>
                        <h3>Cadastrar resposta</h3>
                        <form action="respostas.php?<?=$_SERVER['QUERY_STRING']?>" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <p><label>Título : </label><input type="text" class="text-long" name="nome" id="nome" maxlength="255" /></p>
                                
                                <p><label>Descrição : </label><textarea name="descricao" id="descricao"></textarea></p>
                                <p><label>Link (Se precisar Ex.: http://www.google.com) : </label><textarea name="link" id="link"></textarea></p>
                                <p><label>Imagem para o resposta : </label><input type="file" name="imagem" id="imagem" maxlength="255" /></p>
                                <p><label>Status : </label>
                                    <select name="status">
                                        <option value="1" selected="selected">Publicado</option>
                                        <option value="2">Não publicado</option>
                                    </select>
                                </p>
                               
                                <input type="hidden" name="bannerIdResposta" value="<?=$banner['idBanner']?>" />
                                <input type="hidden" name="userIdResposta" value="<?= $_SESSION['autenticado_id']?>" />
                                <input type="submit" name="cadastrar" value="Cadastrar" />
                            </fieldset>
                             <script>
                CKEDITOR.replace('descricao', {
                    filebrowserBrowseUrl : ' uploadEditor.php?action=browse',
                    filebrowserUploadUrl : ' uploadEditor.php?action=upload',
                    height: 450 }
                );
                </script>
                        </form>
                    </div>
                </div>

                <div class="clear"></div>
            </div>
        </div>
      </div>
</body>
</html>
