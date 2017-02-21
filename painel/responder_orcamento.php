
<?php 
session_start();

require('lib/DBMySql.php');

require('classe/bo/utilidadesBO.php');
require_once 'classe/vo/orcamentos.php';
require_once 'classe/vo/respostas.php';
require 'classe/bo/CRUDMySQL.php';

$orcamentos = new orcamentos();
$respostas = new respostas();

$orcamentos->idBanner = $_GET['i'];
$orcamento = $orcamentos->get();
$all = $respostas->getAlluser($_GET['i']);

include('meta.php');

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

  <?php if($_SESSION['autenticado_id'] == 1){  ?>


    <div class="container" id="banner-default" style="margin: 0 auto;
  width: 100%;background-image: url('img/grafism-topo3.png');margin-top:88px;background-size:cover;background-repeat:no-repeat;">   
    

    <div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">
        <div id="banner-box">
         <h5 class="texto-pt" id="banner-default-texto">SPEEDFIX</h5>
          <h1 class="titulo-russo" id="banner-default-title">RESPONDER</h1>
         
          
        </div>
    </div>
</div>

  <?php }else{ ?>


  <div class="container" id="banner-default" style="margin: 0 auto;
  width: 100%;background-image: url('img/grafism-topo.png');margin-top:88px;background-size:cover;background-repeat:no-repeat;">   
    

    <div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">
        <div id="banner-box">
         <h5 class="texto-pt" id="banner-default-texto">SPEEDFIX</h5>
          <h1 class="titulo-russo" id="banner-default-title">SEU ORÇAMENTO</h1>
         
          
        </div>
    </div>
</div>

  <?php } ?> 



<div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">

<h1 class="titulo-russo" id="orcamento-title">Entrar em contato</h1>
<h5 class="texto-pt" id="orcamento-text">Responda o orçamento solicitado pelo usuário,<br> detalhe as infomações necessárias no campo de mensagem.</h5><br>
                <form action="home-admin.php" method="post" enctype="multipart/form-data">
<fieldset>
<div class="row" id="row-orcamento" style="padding:5px 0 5px 0;margin-right:0px !important;margin-left:0px !important;">
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">TÍTULO</span>
            <input  class="form-control input-login2" placeholder="Digite um título" type="text" name="nome" id="nome" maxlength="255" required>
          </div>
          <br>
         <input style="padding-top:14px;padding-bottom:14px;" type="file" name="imagem" id="arquivo-orcamento" maxlength="255" />
  </div>
  <div class="col-sm-6" style="padding-right:0px;padding-left:0px;">

  
  <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">MENSAGEM</span>
            <textarea class="form-control input-login2" name="descricao" id="descricao" placeholder="Digite uma mensagem explicando a situação" required></textarea>  
          </div>
          

        <input type="hidden" name="bannerUserIdResposta" value="<?=$orcamento['userIdBanner']?>" />
        <input type="hidden" name="bannerIdResposta" value="<?=$orcamento['idBanner']?>" />
        <input type="hidden" name="userIdResposta" value="<?= $_SESSION['autenticado_id']?>" />

              
          <div class="btn-group btn-group-justified" role="group" style="width:85%;">
            <div class="btn-group" role="group">
             <input id="btn-grey-full" type="submit" name="cadastrar" value="ENVIAR"  class="btn btn-grey" />
            </div>

          </div>
          </div>

</div>


</fieldset>

</form>
<br><br>
<h1 class="titulo-russo" id="orcamento-title">Orçamento</h1>
<h5 class="texto-pt" id="orcamento-text">Você está enviando uma resposta para o orçamento abaixo.</h5><br>
 

                    <div id="main">
                        <div id="errorMsg"></div>
                        <?php 
                        $CRUDMySQL = new CRUDMySQL();
              
                        $userP = $CRUDMySQL->getUserId($orcamento['userIdBanner']);

                        ?>
                        <h3 style="text-transform: capitalize;"><?=$userP['login']?></h3>
                    
                            <fieldset style="background-color:transparent;border-color:#f18725;">
                          
                                <p><b>Marca: </b> <?=urldecode($orcamento['nomeBanner'])?></p>
                                <p><b>Modelo: </b> <?=urldecode($orcamento['linkBanner'])?></p>
                                <p><b>Mensagem: </b><?=urldecode($orcamento['descricaoBanner'])?></p>
                                <?php if($orcamento['imagemBanner']){?>
                                <p><b>Anexo: </b><a href="../upload/<?=$orcamento['imagemBanner']?>">Baixar anexo</a></p>
                                <?php }?>
                                <span style="font-size:12px !important;">-<br>Data:  <?=$orcamento['dataBanner']?> - (ref: <?=urldecode($orcamento['idBanner'])?>)</span>
                            
                            </fieldset>
                  
                    </div>
                    
                </div>




 
     <?php include('footer.php'); ?>
   </body>
   </html>
