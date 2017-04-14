<?php 
session_start();
include('meta.php');

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
  width: 100%;background-color: #595959;padding:12px;margin-top:65px;">   
    

    <div class="container" style="max-width:800px;padding:0px;">

          <h1 style="padding-left:10px;margin:0px;font-size:25px !important;" id="banner-default-title">Orçamento SPEEDFIX</h1>


    </div>
</div>

  <?php }else{ ?>


<div class="container" id="banner-home" style="margin: 0 auto;
  width: 100%;background-image: url('img/bg-home.png');margin-top:88px;background-size:cover;background-repeat:no-repeat;">   
    <br><br>

    <div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">
        <div id="banner-box">
          <h1 class="titulo-russo2" id="home-titulo">Olá <?=urldecode($_SESSION['autenticado_nome'])?>,</h1>
          <h5 class="texto-pt" id="home-texto">Bem vindo(a)! Esse é o painel de controle SpeedFix.</h5>
          <a href="solicitar_orcamento.php" type="button" id="home-btn-banner" class="btn btn-grey">SOLICITE O SEU ORÇAMENTO</a>
        </div>
    </div>
</div>


  <div class="container" id="banner-default" style="margin: 0 auto;
  width: 100%;background-color: #595959;padding:12px;">   
    

    <div class="container" style="max-width:800px;padding:0px;">

          <h1 style="padding-left:10px;margin:0px;font-size:25px !important;" id="banner-default-title">Orçamento SPEEDFIX</h1>


    </div>
</div>


  <?php } ?> 



<div class="container" style="max-width:800px;padding:15px;">
 

                  <div>
                        
                        <?php 
                        $CRUDMySQL = new CRUDMySQL();
              
                        $userP = $CRUDMySQL->getUserId($orcamento['userIdBanner']);

                        ?>
          
                            <fieldset id="ver-orcamento-div" style="background-color:#595959;">
                            


                                <div style="padding:20px;padding-left:0px;">

                                <h1 class="titulo-russo" id="orcamento-title" style="text-transform: capitalize;color:white !important;"><?=urldecode($userP['nome'])?></h1>  
                                <br>
                                <p style="margin-bottom:0px;"><b>Email:</b> <?=urldecode($userP['login'])?></p>
                                <p style="margin-bottom:0px;"><b>Telefone:</b> <?=urldecode($userP['telefone'])?></p>
                                <p style="margin-bottom:0px;"><b>CPF:</b> <?=urldecode($userP['cpf'])?></p>
                                <br>
                                
                                
                                <p style="margin-bottom:0px;"><b>Endereço:</b> <?=urldecode($userP['rua'])?>, <?=urldecode($userP['bairro'])?>. <?=urldecode($userP['cidade'])?> - <?=urldecode($userP['estado'])?></p>
                                <p style="margin-bottom:0px;"><b>CEP:</b> <?=urldecode($userP['cep'])?></p>
                                <p style="margin-bottom:0px;"><b>Complemento:</b> <?=urldecode($userP['complemento'])?></p>

                                </div>

                                <div style="padding:20px;border:1px solid white;">
                                
                                <p><b>MARCA: </b> <?=urldecode($orcamento['nomeBanner'])?></p>
                                <p><b>MODELO: </b> <?=urldecode($orcamento['linkBanner'])?></p>
                                <p><b>MENSAGEM: </b><?=urldecode($orcamento['descricaoBanner'])?></p>
                                <?php if($orcamento['imagemBanner']){?>
                                <p><b>ANEXO: </b><a style="color:orange;" href="../upload/<?=$orcamento['imagemBanner']?>">Baixar anexo</a></p>
                                <?php }?>
                                </div>
                                <span style="font-size:11px !important;"><b>Data:</b>  <?=$orcamento['dataBanner']?><br><b>Ref.:</b> <?=urldecode($orcamento['idBanner'])?></span>
                            
                            </fieldset>
                  
                    </div>
                    

                    <div id="main">
                        <div id="errorMsg"></div>
                         <?php

                                $rn = 0;
                                
                                while(@$all[$rn]) {
                                       $rn++;
                            
                                }
                            
                        ?>
                        <br><h1 class="titulo-russo" id="orcamento-title" style="text-transform: capitalize;padding-top:15px;padding-bottom:15px;font-size:17px !important;">RESPOSTAS (<?=$rn?>)</h1>

                        
                           
                        <?php

                                $r = 0;
                                
                                while(@$all[$r]) {
                            
                        ?>
                       
                            <fieldset style="border-color:#0e3f84;">
                            <?php 
                              $CRUDMySQL2 = new CRUDMySQL();
                    
                              $userP2 = $CRUDMySQL2->getUserId($all[$r]['userIdResposta']);

                              ?>
                              <h1 class="titulo-russo" id="orcamento-title" style="text-transform: capitalize;padding-top:15px;padding-bottom:15px;color:#0e3f84 !important;"><?=urldecode($all[$r]['nomeResposta'])?></h1>
                              
                                <p><?=urldecode($all[$r]['descricaoResposta'])?></p> 
                                <?php if($all[$r]['imagemResposta']){?>           
                                <p><b>ANEXO: </b><a href="../upload/<?=$all[$r]['imagemResposta']?>">Baixar anexo</a></p>
                                <?php } ?>
                                <br>
                                <p style="font-size:12px;"><b>Enviado por: </b><?=$userP2['login']?><br><b>Data: </b><?=urldecode($all[$r]['dataResposta'])?></p>
                            </fieldset>
                  
                        <?php
                            
                                    $r++;
                            
                                }
                            
                        ?>
                    </div>
                </div>

</div>

 
     <?php include('footer.php'); ?>
   </body>
   </html>
