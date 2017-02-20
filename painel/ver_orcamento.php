
<?php 
session_start();

require('lib/DBMySql.php');

require('classe/bo/utilidadesBO.php');
require_once 'classe/vo/orcamentos.php';
require_once 'classe/vo/respostas.php';

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



  <div class="container" id="banner-default" style="margin: 0 auto;
  width: 100%;background-image: url('img/grafism-topo.png');margin-top:88px;background-size:cover;background-repeat:no-repeat;">   
    

    <div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">
        <div id="banner-box">
         <h5 class="texto-pt" id="banner-default-texto">SPEEDFIX</h5>
          <h1 class="titulo-russo" id="banner-default-title">SEU ORÇAMENTO</h1>
         
          
        </div>
    </div>
</div>

<div class="container" style="max-width:800px;padding-left:0px;padding-right:0px;">
 
 <div id="conteudo">
                    <div id="main">
                        <div id="errorMsg"></div>
                        <h4>Data: 00/00/0000 <br><span style="font-size:14px;">(ref: <?=urldecode($orcamento['idBanner'])?>)</span></h4>
                    
                            <fieldset style="background-color:">
                          
                                <p><label>Marca : <?=urldecode($orcamento['nomeBanner'])?></label></p>
                               
                                <p><label>Modelo : <?=urldecode($orcamento['linkBanner'])?></label></p>
                                
                                <p><label>Mensagem : <?=urldecode($orcamento['descricaoBanner'])?></label></p>

                                <?php if($orcamento['imagemBanner']){?>
                                <p><label>Anexo : </label><a href="../upload/<?=$orcamento['imagemBanner']?>">Baixar anexo</a></p>
                                <?php }?>

                            
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

</div>

 
     <?php include('footer.php'); ?>
   </body>
   </html>
