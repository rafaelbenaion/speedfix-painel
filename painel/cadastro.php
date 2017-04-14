<?php 
session_start();
if($_SESSION["autenticado_painel"] == "SIM"){
  header("Location: home.php");
}
include('meta-index.php'); 
?>  
<script language="javascript" type="text/javascript">

jQuery.validator.addMethod("cpf", function(value, element) {
   value = jQuery.trim(value);

    value = value.replace('.','');
    value = value.replace('.','');
    cpf = value.replace('-','');
    while(cpf.length < 11) cpf = "0"+ cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i=0; i<11; i++){
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
    b = 0;
    c = 11;
    for (y=0; y<10; y++) b += (a[y] * c--);
    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

    var retorno = true;
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

    return this.optional(element) || retorno;

}, "Informe um CPF válido");

$(document).ready(function(){
  $("#meuForm").validate({
    errorLabelContainer: $("#errorMsg"),
    rules: {
      usuario: {
        required:true,
        minlength:5
      },
      nome: {
        required:true,
        minlength:5
      },
      cpf: {
        cpf: true,
        required:true
      },
      senha: {
        required: true,
        minlength:3
      }
    },
    messages: {
      usuario: {
        required:"Preencha o campo email<br/>",
        minlength:"O email deve ser válido<br/>"
      },

      nome: {
        required:"Preencha o campo nome<br/>",
        minlength:"Seu nome deve ter ao menos 5 caracteres<br/>"
      },
     
      senha: {
        required:"Você deve informar uma senha<br/>",
        minlength:"A senha deve ter ao menos 5 caracteres<br/>"
      },

       cpf: { 
        cpf: 'CPF inválido'
        required:"Você deve informar seu CPF<br/>",
      },
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

    <div class="row" style="text-align:center;">
      <h1 class="titulo-russo">Quero um cadastro SPEEDFIX</h1>
      <h5 class="texto-pt" id="login-texto">Com ele, você acompanha todos os seus pedidos e tem acesso a todo o suporte oferecido.</h5>
      <div id="coluna-login" style="max-width:330px;float: none !important;display: block;margin: auto;">
     
       <?php if($_GET['msg']){ ?>
        <h4 style="color:red !important;" class="texto-pt" id="login-texto"><?php echo $_GET['msg'] ?></h4>
      <?php } ?>

      

        <form method="post" action="authentication.php" method="post" id="meuForm">
           <h5 style="border-top:2px solid orange;width:150px;padding-top:15px;display:block;margin:auto;margin-top:30px;margin-bottom:15px;" class="texto-pt" id="login-texto">Dados Pessoais</h5>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral">NOME</span>
            <input  class="form-control input-login" name="nome" aria-describedby="basic-addon1" required>
          </div>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral">CPF</span>
            <input  class="form-control input-login" name="cpf" aria-describedby="basic-addon1" required>
          </div>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral">E-MAIL</span>
            <input type="email"  class="form-control input-login" name="usuario" aria-describedby="basic-addon1" required>
          </div>
          <br>
           <h5 class="texto-pt" id="login-texto">Criar Senha</h5>
          <div class="input-group login">
            <span class="input-group-addon" id="input-lateral">SENHA</span>
            <input type="password" name="senha" class="form-control input-login" aria-describedby="basic-addon1" required>
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

   

     </div> <!-- /container -->

     <?php include('footer.php'); ?>
     <style type="text/css">
        .form-control.input-login {
          width: 250px;
      }
      #input-lateral {
          width: 80px;
      }
      </style>
   </body>
   </html>
