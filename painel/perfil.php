<?php 
session_start();
include('meta.php');

require('lib/DBMySql.php');
require('classe/bo/utilidadesBO.php');
require_once 'classe/vo/orcamentos.php';


$utilidadesBO = new utilidadesBO();


if(!empty($_POST['alterar'])){
  $senhaAt = $_POST['senhaAt'];
  $senhaNv = $_POST['senhaNv'];
  $senhaCf = $_POST['senhaCf'];
  
  if(!empty($senhaAt) && !empty($senhaNv) && !empty($senhaCf)) {

    $vetRes = $utilidadesBO->executaSQL("SELECT `senha` FROM `users` WHERE `idusuario` = ".$_SESSION['autenticado_id'].";");
    if($vetRes[0]['senha'] == sha1($senhaAt)){
      if(sha1($senhaNv) == sha1($senhaCf)){
        $senhaBD = sha1($senhaNv);
        @$vetAtu = $utilidadesBO->executaSQL("UPDATE `users` SET `senha`='".$senhaBD."' WHERE `idusuario` = ".$_SESSION['autenticado_id'].";");
        $msgA = "Senha alterada com sucesso!";
      } else {
      $msgE = "A nova senha e a confirmação não coincidem.";
      }
    } else {
      $msgE = "Senha atual incorreta.";
    }
    
  } else {
    
    $msgE = "Por favor, digite todos os dados corretamente.";
    
  }
}



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



  <div class="container" id="banner-default" style="margin: 0 auto;
  width: 100%;background-image: url('img/grafism-topo.png');margin-top:88px;background-size:cover;background-repeat:no-repeat;">   
    

    <div class="container" style="max-width:800px;padding:10px;">
        <div id="banner-box">
         <h5 class="texto-pt" id="banner-default-texto">SPEEDFIX</h5>
          <h1 class="titulo-russo" id="banner-default-title">DADOS PERFIL</h1>
         
          
        </div>
    </div>
</div>

<div class="container" style="max-width:800px;padding:10px;">
 


<h1 class="titulo-russo" id="orcamento-title" style="text-transform:capitalize;">Olá, <?=$_SESSION['autenticado_login']?></h1>
<h5 class="texto-pt" id="orcamento-text">Esse é seu perfil e contém todas as suas informações. Mantenha seus dados atualizados.</h5>
<br>
<form action="home.php" method="post" enctype="multipart/form-data">
<fieldset>
<div class="row" id="row-orcamento" style="padding:5px 0 5px 0;margin-right:0px !important;margin-left:0px !important;">
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">NOME</span>
            <input  class="form-control input-login2" value="Nome" type="text" name="nome" id="nome" maxlength="255" required>
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">CIDADE</span>
            <input  class="form-control input-login2" value="Cidade" type="text" name="nome" id="nome" maxlength="255" required>
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">ENDEREÇO</span>
            <input name="link" class="form-control input-login2" name="usuario" value="Endereço" aria-describedby="basic-addon1" required>
          </div>
  </div>
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">CEP</span>
            <input  class="form-control input-login2" value="CEP" type="text" name="nome" id="nome" maxlength="255" required>
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">TELEFONE</span>
            <input name="link" class="form-control input-login2" name="usuario" value="Telefone" aria-describedby="basic-addon1" required>
          </div>
          <br>
         
        
   <div class="btn-group btn-group-justified" role="group" style="width:85%;">
            <div class="btn-group" role="group">
             <input id="btn-grey-full" type="submit" name="cadastrar" value="SALVAR"  class="btn btn-grey" />
            </div>
  </div>
          </div>


</fieldset>

</form>
<BR><BR>



<h1 class="titulo-russo" id="orcamento-title" style="text-transform:capitalize;">Senha</h1>
<h5 class="texto-pt" id="orcamento-text">Você pode utilizar esse campo para criar uma nova senha.</h5>
<br>
<?php if($msgE != "") { ?><h5 style="color:red !important;" class="texto-pt" id="orcamento-text">Oops. <?=$msgE?></h5><br><?php } ?>
  <?php if($msgA != "") { ?><h5 style="color:green !important;" class="texto-pt" id="orcamento-text"><?=$msgA?></h5><br><?php } ?>

<form  method="post">
<fieldset>
<div class="row" id="row-orcamento" style="padding:5px 0 5px 0;margin-right:0px !important;margin-left:0px !important;">
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">NOVA SENHA</span>
            <input type="password" name="senhaNv" class="form-control input-login2" placeholder="Digite uma nova senha"  id="nome" maxlength="255" required>
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">CONFIRME</span>
            <input  type="password" name="senhaCf" class="form-control input-login2" placeholder="Digite novamente nova senha" type="text" name="nome" id="nome" maxlength="255" required>
          </div>
       
  </div>
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">SENHA ANTIGA</span>
            <input type="password" name="senhaAt" class="form-control input-login2" placeholder="Digite a senha antiga" type="text" name="nome" id="nome" maxlength="255" required>
          </div>
          <br>
    
   <div class="btn-group btn-group-justified" role="group" style="width:85%;">
            <div class="btn-group" role="group">
             <input id="btn-grey-full" type="submit"  name="alterar"  value="ALTERAR"  class="btn btn-grey" />
            </div>
  </div>
          </div>


</fieldset>

</form>
</div>
   

 
     <?php include('footer.php'); ?>
   </body>
   </html>
