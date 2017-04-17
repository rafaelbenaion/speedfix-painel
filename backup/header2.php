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
             <a style="color:#F47C2B !important;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if(empty($_SESSION["autenticado_painel"])){?><b style="color:#F47C2B !important;">MENU</b><?php }else{ ?><b style="color:#F47C2B !important;text-transform: capitalize;"><?=$_SESSION['autenticado_login']?></b><?php } ?><span class="caret"></span></a>
              <ul class="dropdown-menu">
             <!--   <li><a href="#">Home</a></li>
                <li><a href="#">Contato</a></li>
                <li role="separator" class="divider"></li>-->
     
                <li><a style="font-size:12px;" href="/">HOME</a></li>
                <li style="background-color:#F47C2B;color:white;" class="dropdown-header">PAINEL</li>
                <?php if(!empty($_SESSION["autenticado_painel"])){?>
           
                
                <li style="font-size:11px;" ><a href="perfil.php">> Perfil</a></li>
                <li style="font-size:11px;" ><a href="authentication.php?act=out">> Sair</a></li>
            
                <?php } ?>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>