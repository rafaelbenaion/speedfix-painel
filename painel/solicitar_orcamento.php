<?php 
session_start();
include('meta.php');

require('lib/DBMySql.php');

require('classe/bo/utilidadesBO.php');

require_once 'classe/vo/orcamentos.php';



$orcamentos = new orcamentos();
$all = $orcamentos->getAlluser($_SESSION['autenticado_id']); 
?>  
<script type="text/javascript">
$(document).ready(function() {
$("#tipo").val("1");
      $('#btn-tipo1').on({
        'click': function(){
            $('#btn-tipo2-img').attr('src','img/venda-white.png');
            $('#btn-tipo1-img').attr('src','img/assis-orange2.png');
            $("#tipo").val("1");
        }
    });
});

$(document).ready(function() {
      $('#btn-tipo2').on({
        'click': function(){
            $('#btn-tipo2-img').attr('src','img/venda-orange.png');
            $('#btn-tipo1-img').attr('src','img/assis-white.png');
            $("#tipo").val("2");
        }
    });
});
</script>


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
          <h1 style="padding-left:10px;margin:0px;font-size:24px !important;" id="banner-default-title">Orçamento SPEEDFIX</h1>
    </div>
</div>

<div class="container" style="max-width:800px;padding:10px;">
 

<h1 class="titulo-russo" id="orcamento-title">Escolha o serviço</h1>

<br>
<div><a id="btn-tipo1" style="max-width:50%;" href="#"><img id="btn-tipo1-img" style="max-width:50%;" src="img/assis-orange2.png"></a><a id="btn-tipo2" style="max-width:50%;" href="#"><img id="btn-tipo2-img" style="max-width:50%"; src="img/venda-white.png"></a></div>
<br><br><br>
<h1 class="titulo-russo" id="orcamento-title">Dados do aparelho</h1>
<h5 class="texto-pt" id="orcamento-text">Preencha com maior riqueza de detalhes possível.</h5>
<br>
<form action="home.php" method="post" enctype="multipart/form-data">
<fieldset>
<div class="row" id="row-orcamento" style="padding:5px 0 5px 0;margin-right:0px !important;margin-left:0px !important;">
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">MARCA</span>
            <input  class="form-control input-login2" placeholder="Qual a marca do seu produto?" type="text" name="nome" id="nome" maxlength="255" required>
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">MODELO</span>
            <input name="link" class="form-control input-login2" name="usuario" placeholder="Qual o modelo do seu produto?" aria-describedby="basic-addon1" required>
          </div>
  </div>
  <div class="col-sm-6" style="padding-right:0px;padding-left:0px;">

  <input type="file" name="imagem" id="arquivo-orcamento" maxlength="255" />
  <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">MENSAGEM</span>
            <textarea class="form-control input-login2" name="descricao" id="descricao" placeholder="Descreva o defeito do seu aparelho" required></textarea>  
          </div>
          

          <input type="hidden" name="status" id="status" value="1" />
          <input type="hidden" name="tipo" id="tipo"/>
          <input type="hidden" name="userIdBanner" value="<?= $_SESSION['autenticado_id']?>" />

              
          <div class="btn-group btn-group-justified" role="group" style="width:85%;">
            <div class="btn-group" role="group">
             <input id="btn-orange-full" type="submit" name="cadastrar" value="ENVIAR"  class="btn btn-grey" />
            </div>

          </div>
          </div>

</div>


</fieldset>

</form>
</div>
   

 
     <?php include('footer.php'); ?>
   </body>
   </html>
