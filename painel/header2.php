<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container" id="nav-correct">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img id="logo-nav" src="img/logo2.png"/></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        
          <ul class="nav navbar-nav navbar-right">
          
            <li class="dropdown">
             <a style="color:white !important;background-color: #F47C2B !important;padding:0px;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

             <?php if(empty($_SESSION["autenticado_painel"])){?>
              
              <b style="color:white !important;padding: 10px;">MENU</b>

              <?php }else{ ?>

                <b style="color:white !important;text-transform: capitalize;padding: 15px 30px;"><?=urldecode($_SESSION['autenticado_nome'])?></b>

                <?php } ?>

              <img src="img/engine.png"></a>
              <ul class="dropdown-menu">
             <!--   <li><a href="#">Home</a></li>
                <li><a href="#">Contato</a></li>
                <li role="separator" class="divider"></li>-->
     
     
                <?php if(!empty($_SESSION["autenticado_painel"])){?>
           
                
                <li><a class="menu-item" href="perfil.php"><b>Configurações</b></a></li>
                <li><a class="menu-item" href="authentication.php?act=out"><b>Sair</b></a></li>
            
                <?php }else{ ?>

                  <li><a class="menu-item" href="../"><b>HOME</b></a></li>

                <?php  } ?>
                <style type="text/css">
                  .menu-item{
                    color:white !important  ;
                  }
                  .menu-item:hover{
                    color:#F47C2B  !important  ;
                    background-color: #373738 !important;
                  }
                  .dropdown-menu {
                      background-color: #373738;
                      border-radius: 0px;
                      padding: 10px;
                      margin-top: -1px !important;
                      text-align: center;
                  }
                </style>
                <script type="text/javascript">
                  var tamanho = $('.dropdown-toggle').width();
                  $(".dropdown-menu").width(tamanho);
                </script>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>