
<?php 
session_start();

if($_SESSION["autenticado_painel"] == "SIM"){
  header("Location: home.php");
}
include('meta-index.php'); 
?>  
<script language="javascript" type="text/javascript">
$(document).ready(function(){
  $("#login").validate({
    errorLabelContainer: $("#errorMsg"),
    rules: {
      usuario: {
        required:true,
        minlength:5
      },
      senha: {
        required: true,
        minlength:3
      }
    },
    messages: {
      usuario: {
        required:"Preencha o campo usuário<br/>",
        minlength:"O usuário deve ter ao menos 5 caracteres<br/>"
      },
      senha: {
        required:"Você deve informar uma senha<br/>",
        minlength:"A senha deve ter ao menos 5 caracteres<br/>"
      }
    },
  });
  $('#login input:not(#enviar)').each(function(){
    var valor = $(this).val();
    $(this).focus(function(){
      if($(this).val() == valor){
        $(this).val("");
      }
    });
    $(this).blur(function(){
      if($(this).val() == ""){
        $(this).val(valor);
      }
    });
  });
})
</script>


<body>

  <?php include('header2.php'); ?>  


  <div class="container-fluid" style="background-color: blue;">

  </div>

  <div class="container" style="height:100vh;position: relative;">
    <div  id="container-login"></div>

    <div class="row">
      <div class="col-md-6"><h1 class="titulo-russo" id="login-titulo">Cadastro<br>SPEEDFIX</h1></div>
      <div class="col-md-6" id="coluna-login" style="max-width:350px;float:left;">
      <h1 class="titulo-russo" id="login-titulo-mobile">Cadastro<br>SPEEDFIX</h1>
      <h5 class="texto-pt" id="login-texto">A SPEEDFIX ajuda a consertar seus problemas. E você pode solicitar os seus pedidos aqui dentro.</h5>
        <form method="post">


          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral">E-MAIL</span>
            <input  class="form-control input-login" name="usuario" placeholder="Digite um e-mail" aria-describedby="basic-addon1" required>
          </div>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral">SENHA</span>
            <input type="password" name="senha" class="form-control input-login" placeholder="Digite uma senha" aria-describedby="basic-addon1" required>
          </div>
          <div class="btn-group btn-group-justified" role="group" aria-label="...">

            <div class="btn-group" role="group">
              <button type="submit" value="Cadastrar" name="cadastro" id="login-btn-entrar" class="btn btn-laranja">CADASTRAR</button>
              <a href="index.php" type="button" id="login-btn-cadastrar " class="btn btn-grey">JÁ TENHO UMA CONTA</a>
            </div>

          </div>
        </form>
      </div>
    </div>

    <div id="grafismo" style="position: absolute;bottom: 0;text-align:center;width:100%;z-index:-1;" class="row">
     <img style="max-width:80%;" src="img/grafismo.png">
     <div>

     </div> <!-- /container -->

     <?php include('footer.php'); ?>
   </body>
   </html>
