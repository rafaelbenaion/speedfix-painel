<?php 
session_start();
include('meta.php');

require('lib/DBMySql.php');
require('classe/bo/utilidadesBO.php');
require_once 'classe/vo/orcamentos.php';
require 'classe/bo/CRUDMySQL.php';

$utilidadesBO = new utilidadesBO();

$CRUDMySQL = new CRUDMySQL();
$userP = $CRUDMySQL->getUserId($_SESSION['autenticado_id']);


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

if(!empty($_POST['salvar2'])){

        $cep = urlencode($_POST['cep']);
        $rua = urlencode($_POST['rua']);
        $complemento = urlencode($_POST['complemento']);
        $cidade = urlencode($_POST['cidade']);
        $estado = urlencode($_POST['estado']);
        $bairro = urlencode($_POST['bairro']);

        $_SESSION["autenticado_nome"] = urlencode($_POST['nome']);

        $nome = urlencode($_POST['nome']);
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        //$email = $_POST['email'];
         
        @$vetAtu = $utilidadesBO->executaSQL("UPDATE `users` SET `nome`='".$nome."',`cpf`='".$cpf."',`telefone`='".$telefone."',`cep`='".$cep."',`rua`='".$rua."',`complemento`='".$complemento."',`cidade`='".$cidade."',`estado`='".$estado."',`bairro`='".$bairro."' WHERE `idusuario` = ".$_SESSION['autenticado_id'].";");
        

        header("Location: perfil.php");
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

<?php if($_SESSION['autenticado_id'] == 1){ ?>

<div class="container" id="banner-default" style="margin: 0 auto;
  width: 100%;background-color: #595959;padding:12px;margin-top:64px;">   
    <div class="container" style="max-width:800px;padding:0px;">
          <h1 style="padding-left:10px;margin:0px;font-size:25px !important;" id="banner-default-title">Configurações</h1>
    </div>
</div>



<?php }else{ ?>


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
          <h1 style="padding-left:10px;margin:0px;font-size:25px !important;" id="banner-default-title">Configurações</h1>
    </div>
</div>

<?php } ?>

<div class="container" style="max-width:800px;padding:10px;">
 

<?php if($_SESSION['autenticado_id'] != 1){ ?>

<form action="perfil.php" method="post" enctype="multipart/form-data">
<fieldset>
<h1 class="titulo-russo" id="orcamento-title">Dados Pessoais</h1>
<br>
<div class="row" id="row-orcamento" style="padding:5px 0 5px 0;margin-right:0px !important;margin-left:0px !important;">
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">NOME</span>
            <input  class="form-control input-login2" value="<?=urldecode($userP['nome'])?>" type="text" name="nome" id="nome" maxlength="255" required>
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">CPF</span>
            <input  class="form-control input-login2" value="<?=urldecode($userP['cpf'])?>" type="text" name="cpf" id="cpf" maxlength="255" required>
          </div>
        
  </div>
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">EMAIL</span>
            <input  class="form-control input-login2" value="<?=urldecode($userP['login'])?>" type="text" name="email" id="nome" maxlength="255" required>
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">TELEFONE</span>
            <input class="form-control input-login2" name="telefone" value="<?=urldecode($userP['telefone'])?>" aria-describedby="basic-addon1">
          </div>
          <br>
         
          </div>


</fieldset>
<fieldset>
<h1 class="titulo-russo" id="orcamento-title">Endereço para coleta</h1>
<h5 class="texto-pt" id="orcamento-text">(*) Campos obrigatórios.</h5>
<br>
<div class="row" id="row-orcamento" style="padding:5px 0 5px 0;margin-right:0px !important;margin-left:0px !important;">
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">RUA*</span>
            <input  class="form-control input-login2" value="<?=urldecode($userP['rua'])?>" type="text" name="rua" id="nome" maxlength="255" required>
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">COMPLEMENTO</span>
            <input  class="form-control input-login2" value="<?=urldecode($userP['complemento'])?>" type="text" name="complemento" id="cpf" maxlength="255">
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">CEP*</span>
            <input  class="form-control input-login2" value="<?=urldecode($userP['cep'])?>" type="text" name="cep" id="cpf" maxlength="255" required>
          </div>
        
  </div>
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">BAIRRO</span>
            <input  class="form-control input-login2" value="<?=urldecode($userP['bairro'])?>" type="text" name="bairro" id="nome" maxlength="255">
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">CIDADE</span>
            <input class="form-control input-login2" name="cidade" value="<?=urldecode($userP['cidade'])?>" aria-describedby="basic-addon1">
          </div>
          <br>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">ESTADO</span>
            <input class="form-control input-login2" name="estado" value="<?=urldecode($userP['estado'])?>" aria-describedby="basic-addon1">
          </div>
          <br>
         
        
   <div class="btn-group btn-group-justified" role="group" style="width:85%;">
            <div class="btn-group" role="group">
             <input id="btn-orange-full" type="submit" name="salvar2" value="SALVAR ALTERAÇÕES"  class="btn btn-grey" />
            </div>
  </div>
          </div>


</fieldset>

</form>
<BR><BR>

<?php } ?>

<h1 class="titulo-russo" id="orcamento-title" style="text-transform:capitalize;">Alterar senha</h1>
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
            <input  type="password" name="senhaCf" class="form-control input-login2" placeholder="Confirme nova senha" type="text" name="nome" id="nome" maxlength="255" required>
          </div>
       
  </div>
  <div class="col-sm-6" style="padding-left:0px;padding-right:0px;">
<div class="input-group login">
            <span class="input-group-addon" id="input-lateral2">SENHA ANTIGA</span>
            <input type="password" name="senhaAt" class="form-control input-login2" placeholder="Insira sua senha antiga" type="text" name="nome" id="nome" maxlength="255" required>
          </div>
          <br>
    
   <div class="btn-group btn-group-justified" role="group" style="width:85%;">
            <div class="btn-group" role="group">
             <input id="btn-orange-full" type="submit"  name="alterar"  value="ALTERAR"  class="btn btn-grey" />
            </div>
  </div>
          </div>


</fieldset>

</form>
</div>
   

 
     <?php include('footer.php'); ?>
   </body>
   </html>
