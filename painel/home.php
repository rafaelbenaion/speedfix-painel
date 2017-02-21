
<?php 
ob_start();
session_start();
include('meta.php');

if($_SESSION['autenticado_id'] == 1){
header("Location: home-admin.php");
}

require('classe/bo/utilidadesBO.php');
require('classe/bo/uploadBO.php');
require_once 'classe/vo/orcamentos.php';
require_once 'classe/vo/respostas.php';
require 'classe/bo/CRUDMySQL.php';

$utilidadesBO = new utilidadesBO();
$uploadBO = new uploadBO();

$orcamentos = new orcamentos();

print_r(date("d/m/Y"));
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

?>  


<body>

  <?php include('header2.php'); ?>  



  <div class="container" id="banner-home" style="margin: 0 auto;
  width: 100%;background-image: url('img/bg-home.png');margin-top:88px;background-size:cover;background-repeat:no-repeat;">   
    <br><br>

    <div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">
        <div id="banner-box">
          <h1 class="titulo-russo" id="home-titulo">Olá <?=$_SESSION['autenticado_login']?>,</h1>
          <h5 class="texto-pt" id="home-texto">Bem vindo(a)! Esse é o painel de controle SpeedFix.</h5>
          <a href="solicitar_orcamento.php" type="button" id="home-btn-banner" class="btn btn-grey">SOLICITE O SEU ORÇAMENTO</a>
        </div>
    </div>
</div>

<div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">
  <div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <button style="background-color:#ffb62b;border-radius:none;font-size:20px;color:white;padding-top:2px;padding-bottom:3px;" type="button" class="btn btn-laranja"><img id="icon-btn" src="img/icon-home-white.png"></button>
  </div>
 
  <div class="btn-group" role="group">
     <button style="background-color:#f47c2b;border-radius:none;font-size:20px;color:white;padding-top:4px;padding-bottom:3px;" type="button" class="btn btn-laranja"><img id="icon-btn" src="img/icon-msg-white.png"></button>
  </div>
</div>

<?php

                            $r = 0;
                            
                            while(@$all[$r]) {

                            $respostas = new respostas();
                            $allR = $respostas->getAlluser($all[$r]['idBanner']);
                            $rn = 0;                                
                            while(@$allR[$rn]) {$rn++;}
                          
                          ?>

<div class="row" id="row-orcamento" style="border-bottom:1px solid grey;padding:20px 0 20px 0;margin-right:0px !important;margin-left:0px !important;">
  <?php

$data = explode("/", $all[$r]['dataBanner']);
$data = $data[0]."/".$data[1]; // piece1


   ?>
  <div class="col-sm-2"> <h1 class="titulo-russo home-data" id="home-titulo" style="font-size:23px !important;"><?=$data?></h1></div>
  <div class="col-sm-2"><img id="img-tipo" src="<?php if($all[$r]['tipoBanner']==1){echo'img/tipo1.png';}else{echo'img/tipo2.png';}?>"></div>
  <div class="col-sm-4"> <h1 class="texto-pt" id="home-texto-solicitou">Você fez uma solicitação de orçamento.</h1></div>

  <div class="col-sm-4"><a href="ver_orcamento.php?i=<?=$all[$r]['idBanner']?>&token=<?=md5($all[$r]['idBanner'])?>">


  <h1 class="texto-pt" id="home-texto-solicitou"><img id="icon-msg" src="img/icon-msg.png"><?= "(".$rn.")" ?> Clique para ler respostas</h1></a></div>
</div>

  <?php
                            
                                $r++;
                            
                            }
                            
                            ?>

</div>
   

 
     <?php include('footer.php'); ?>
   </body>
   </html>
