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
require_once 'classe/vo/respostas.php';

$respostas = new respostas();

$respostas->idResposta = $_GET['i'];
$resposta = $respostas->get();



//$categoria = $categorias->get();

$areaAdmin = 'respostas';

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
                        <li><a href="respostas.php?id=<?=$_GET['ci']?>&token=<?=$_GET['ctoken']?>">Ver respostas </a></li>
                    </ul>
                </div>
                <div id="conteudo">
                	<h2><a href="principal.php">Dashboard</a> &raquo; <a href="respostas.php?<?=$_SERVER['QUERY_STRING']?>">respostas</a> &raquo; <a href="#" class="active">Editar resposta</a></h2>
                    <div id="main">
                        <div id="errorMsg"></div>
                        <h3>Ver resposta (Ref.:<?=urldecode($resposta['idResposta'])?>)</h3>
                        <form action="respostas.php?id=<?=$_GET['ci']?>&token=<?=$_GET['ctoken']?>" method="post" enctype="multipart/form-data">
                            <fieldset>
                             <p><label>User : <?=urldecode($resposta['userIdResposta'])?></label></p>
                                <p><label>Título : <?=urldecode($resposta['nomeResposta'])?></label></p>
                               
                                <p><label>Descrição : <?=urldecode($resposta['descricaoResposta'])?></label></p>

                                <p><label>Link : <?=urldecode($resposta['linkResposta'])?></label></p>
                               
                                <p><label>Anexo : </label><img src="../upload/<?=$resposta['imagemResposta']?>" width="150" /> <br><br><a href="../upload/<?=$resposta['imagemResposta']?>">Baixar anexo</a></p>

                            
                            </fieldset>
                  
                        </form>
                    </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</body>
</html>
