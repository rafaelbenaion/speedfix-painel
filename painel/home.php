<?php 
session_start();
if($_SESSION['autenticado_id'] == 1){
header("Location: home-admin.php");
}
include('meta.php');

require('classe/bo/utilidadesBO.php');
require('classe/bo/uploadBO.php');
require('classe/vo/orcamentos.php');
require('classe/vo/respostas.php');
require('classe/bo/CRUDMySQL.php');
require('lib/DBMySql.php');

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
    
    $msg = "Orçamento solicitado com sucesso";


        $to = "speedfix@onda.com.br";
        $subject = "Novo orçamento - Speedfix Painel";

        $message = "
        <html>
          <head>
          <title>Novo orçamento - Speedfix Painel</title>
          </head>
          <body>
            <p>Um novo orçamento foi solicitado pelo Painel!</p>
            <table>
             
              <tr>
                <td><b>Nome:</b></td>
                <td>".urldecode($_SESSION['autenticado_nome'])."</td>
              </tr>
              <tr>
                <td><b>Marca:</b></td>
                <td>".$_POST['nome']."</td>
              </tr>
              <tr>
                <td><b>Modelo:</b></td>
                <td>".$_POST['link']."</td>
              </tr>
              <tr>
                <td><b>Mensagem:</b></td>
                <td>".$_POST['descricao']."</td>
              </tr>
              <tr>
                <td><b>Data:</b></td>
                <td>".date("d/m/Y")."</td>
              </tr>
 
            </table>
            <a href='http://speedfix.inf.br/painel/'><p>Ver mais informações -></p></a>
            <br>
            <p>(Mensagem automática)</p>
          </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // More headers
        $headers .= 'From: <speedfix@speedfix.inf.br>' . "\r\n";
        //$headers .= 'Cc: myboss@example.com' . "\r\n";

        mail($to,$subject,$message,$headers);
 
    
  } else {
    
    $msg = "Oops, ocorreu um erro.";
    
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
      
      $msg = "Orçamento editado com sucesso";
      
    } else {
      
      $msg = "Oops!";
      
    }
    
    
  } else {
    
    $msg = "Oops!";
    
  }
  
  
}

if(isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
  
  if(md5($_GET['pid']) == $_GET['ptoken']) {
    
    $orcamentos->idBanner = $_GET['pid'];
    
    $banner = $orcamentos->get();
    
    unlink('../upload/'.$banner['imagemBanner']);
    
    $orcamentos->deleteBanner();
    
    $msg = "Orçamento excluído com sucesso";
    
  } else {
    
    $msg = "Oops!";
    
  }
  
}

$all = $orcamentos->getAlluser($_SESSION['autenticado_id']); 

?>  


<body>

  <?php include('header2.php'); ?>  

<?php

$orcamentosNews = new orcamentos();
$allNews = $orcamentosNews->getAlluser($_SESSION['autenticado_id']); 

$news = 0;
$newsCount = 0;
while(@$allNews[$news]) {
    if($allNews[$news]['statusBanner']==2){
      $newsCount ++;
    }
    $news++;

}
?>

<div class="container" id="banner-home" style="margin: 0 auto;
  width: 100%;background-image: url('img/bg-home.png');margin-top:88px;background-size:cover;background-repeat:no-repeat;">   
    <br><br>

    <div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">
        <div id="banner-box">
          <h1 class="titulo-russo2" id="home-titulo">Olá <?=urldecode($_SESSION['autenticado_nome'])?>,</h1>
          <h5 class="texto-pt" id="home-texto">Você tem <?= $newsCount;?> mensagens não visualizadas.</h5>
          <a href="solicitar_orcamento.php" type="button" id="home-btn-banner" class="btn btn-grey">SOLICITE O SEU ORÇAMENTO</a>
        </div>
    </div>
</div>

  <div class="container" id="banner-default" style="margin: 0 auto;
  width: 100%;background-color: #595959;padding:12px;">   
    <div class="container" style="max-width:800px;padding:0px;">
          <h1 style="padding-left:10px;margin:0px;font-size:24px !important;" id="banner-default-title">Timeline</h1>
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

                            if($all[$r]['statusBanner'] == 2){
                              $novaMensagem = "background-color:#ffe3d7;";
                            }else{
                              $novaMensagem = "";
                            }
                          
                          ?>

<div class="row" id="row-orcamento" style="<?php echo $novaMensagem; ?>border-bottom:1px solid grey;padding:20px 0 20px 0;margin-right:0px !important;margin-left:0px !important;">
  <?php

$data = explode("/", $all[$r]['dataBanner']);
$mes = "";
switch ($data[1]) {
  case '01':
    $mes = "Jan";
    break;
  case '02':
    $mes = "Fev";
    break;
  case '03':
    $mes = "Mar";
    break;
  case '04':
    $mes = "Abr";
    break;
  case '05':
    $mes = "Maio";
    break;
  case '06':
    $mes = "Jun";
    break;
  case '07':
    $mes = "Jul";
    break;
  case '08':
    $mes = "Ago";
    break;
  case '09':
    $mes = "Set";
    break;
  case '10':
    $mes = "Out";
    break;
  case '11':
    $mes = "Nov";
    break;
  case '12':
    $mes = "Dez";
    break;
}
$data = $data[0]; // piece1
   ?>
  <div class="col-sm-2"> <h1 class="titulo-russo home-data" id="home-titulo" style="margin:0px;text-align:center;font-size:28px !important;"><?=$data?></h1><h1 class="titulo-russo home-data" id="home-titulo" style="font-size:18px !important;margin:0px;text-align:center;"><?=$mes?></h1></div>
  <div class="col-sm-2"><img id="img-tipo" src="<?php if($all[$r]['tipoBanner']==1){echo'img/tipo1.png';}else{echo'img/tipo2.png';}?>"></div>
  <div class="col-sm-4">
  <?php  if($rn == 0){ ?>
  <h1 class="texto-pt" id="home-texto-solicitou">Você fez uma solicitação de orçamento.</h1>
  <?php  }else{ ?>
     <h1 style="margin-top:0px !important;" class="texto-pt" id="home-texto-solicitou">Você fez uma solicitação de orçamento.</h1>
  <img style="max-width:90px;" src="img/confirmado.png">
  <?php } ?>
  </div>

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
