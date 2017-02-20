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
require_once 'classe/vo/respostas.php';

$orcamentos = new orcamentos();
$respostas = new respostas();

$orcamentos->idBanner = $_GET['i'];
$banner = $orcamentos->get();
$all = $respostas->getAlluser($_GET['i']);


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
                    <div id="main">
                        <div id="errorMsg"></div>
                         <?php

                                $rn = 0;
                                
                                while(@$all[$rn]) {
                                       $rn++;
                            
                                }
                            
                        ?>
                        <h3>Respostas (<?=$rn?>)</h3>

                        
                           
                        <?php

                                $r = 0;
                                
                                while(@$all[$r]) {
                            
                        ?>
                        <form action="orcamentos.php?id=<?=$_GET['ci']?>&token=<?=$_GET['ctoken']?>" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <p><label><b>User : </b><?=urldecode($all[$r]['userIdResposta'])?></label></p>
                                <p><label><b>Título : </b><?=urldecode($all[$r]['nomeResposta'])?></label></p>
                                <a href="resposta.php?i=<?=$all[$r]['idResposta']?>&token=<?=md5($all[$r]['idResposta'])?>&ci=<?=$_GET['id']?>&ctoken=<?=$_GET['token']?>" class="see" title="Editar resposta">Ver</a>
                            </fieldset>
                  
                        </form>
                        <?php
                            
                                    $r++;
                            
                                }
                            
                        ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</body>
</html>
