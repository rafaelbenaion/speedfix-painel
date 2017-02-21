
<?php 
ob_start();
session_start();
include('meta.php');

if($_SESSION['autenticado_id'] != 1){
header("Location: home.php");
}

require('classe/bo/utilidadesBO.php');
require('classe/bo/uploadBO.php');
require_once 'classe/vo/orcamentos.php';
require_once 'classe/vo/respostas.php';
require 'classe/bo/CRUDMySQL.php';

$utilidadesBO = new utilidadesBO();

$uploadBO = new uploadBO();


$respostas = new respostas();

$orcamentos = new orcamentos();

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


    $respostas->bannerIdResposta = urlencode($_POST['bannerIdResposta']);

    $respostas->userIdResposta = urlencode($_POST['userIdResposta']);

    $respostas->nomeResposta = urlencode($_POST['nome']);
    
    $respostas->descricaoResposta = urlencode($_POST['descricao']);
      
    $respostas->imagemResposta = $imagem;

    $respostas->linkResposta = $_POST['link'];
    
    $respostas->statusResposta = $_POST['status'];

    $respostas->bannerUserIdResposta = $_POST['bannerUserIdResposta'];

    $respostas->dataResposta = date("d/m/Y");

    $respostas->newResposta();
    
    $msg = "Resposta cadastrado com sucesso";
    
  } else {
    
    $msg = "Dados corrompidos";
    
  }
  
}

$all = $orcamentos->getAlluser($_SESSION['autenticado_id']); 

?>  


<body>

  <?php include('header2.php'); ?>  



 

  <div class="container" id="banner-default" style="margin: 0 auto;
  width: 100%;background-image: url('img/grafism-topo3.png');margin-top:88px;background-size:cover;background-repeat:no-repeat;">   
    

    <div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">
        <div id="banner-box">
          <h1 style="color:white !important;" class="titulo-russo" id="home-titulo">Olá <?=$_SESSION['autenticado_login']?>,</h1>
          <h5 class="texto-pt" id="home-texto">Bem vindo(a) ao painel administrativo do SpeedFix!</h5>

         
          
        </div>
    </div>
</div>

<div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">
 
<?php

                            $r = 0;
                            
                            while(@$all[$r]) {

                            $respostas = new respostas();
                            $allR = $respostas->getAlluser($all[$r]['idBanner']);
                            $rn = 0;                                
                            while(@$allR[$rn]) {$rn++;}
                            
                            if($rn == 0){
                              $naoRespondido = "background-color:#ffe3d7;";
                            }else{
                              $naoRespondido = "";
                            }
                   
                            $CRUDMySQL = new CRUDMySQL();
                  
                            $userP = $CRUDMySQL->getUserId($all[$r]['userIdBanner']);

                        ?>
<div class="row" id="row-orcamento" style="<?=$naoRespondido?>border-bottom:1px solid grey;padding:20px 0 20px 0;margin-right:0px !important;margin-left:0px !important;">
  <?php

$data = explode("/", $all[$r]['dataBanner']);
$data = $data[0]."/".$data[1]; // piece1


   ?>
  <div class="col-sm-2"> <h1 class="titulo-russo home-data" id="home-titulo" style="font-size:23px !important;"><?=$data?></h1></div>
  <div class="col-sm-2"><img id="img-tipo" src="<?php if($all[$r]['tipoBanner']==1){echo'img/tipo1.png';}else{echo'img/tipo2.png';}?>"></div>
  <div class="col-sm-2"> <h1 style="margin-top:12px !important;" class="texto-pt" id="home-texto-solicitou"><b>Solicitado por: </b><?= $userP['login']; ?></h1></div>

  <div class="col-sm-4">

  <a href="responder_orcamento.php?i=<?=$all[$r]['idBanner']?>&token=<?=md5($all[$r]['idBanner'])?>">
 <h1 class="texto-pt" id="home-texto-solicitou"><img id="icon-msg" src="img/icon-msg.png"> Responder orçamento</h1></a>

 </div>
 <div class="col-sm-2">

  <a href="ver_orcamento.php?i=<?=$all[$r]['idBanner']?>&token=<?=md5($all[$r]['idBanner'])?>">
 <h1 class="texto-pt" id="home-texto-solicitou"> Mais informações ></h1></a>

 </div>
</div>

  <?php
                            
                                $r++;
                            
                            }
                            
                            ?>

</div>
   

 
     <?php include('footer.php'); ?>
   </body>
   </html>
