
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
          <h1 class="titulo-russo" id="banner-default-title">VER ORÇAMENTO</h1>
         
          
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
 
 <div id="conteudo">
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
                    <div id="main">
                        <div id="errorMsg"></div>
                         <?php

                                $rn = 0;
                                
                                while(@$all[$rn]) {
                                       $rn++;
                            
                                }
                            
                        ?>
                        <br><h4>Respostas: (<?=$rn?>)</h4>

                        
                           
                        <?php

                                $r = 0;
                                
                                while(@$all[$r]) {
                            
                        ?>
                       
                            <fieldset style="border-color:#0e3f84;">
                            <?php 
                              $CRUDMySQL2 = new CRUDMySQL();
                    
                              $userP2 = $CRUDMySQL2->getUserId($all[$r]['userIdResposta']);

                              ?>
                                <p style="font-size:18px;"><b>Título: </b><?=urldecode($all[$r]['nomeResposta'])?></p>
                                <p><b>Mensagem:</b> <?=urldecode($all[$r]['descricaoResposta'])?></p> 
                                <?php if($all[$r]['imagemResposta']){?>           
                                <p><b>Anexo: </b><a href="../upload/<?=$all[$r]['imagemResposta']?>">Baixar anexo</a></p>
                                <?php } ?>
                                <br>
                                <p style="font-size:11px;"><b>Enviado por: </b><?=$userP2['login']?><br><b>Data: </b><?=urldecode($all[$r]['dataResposta'])?></p>
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
