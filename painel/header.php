		

    	<h1 style="margin: 20px 0px 20px 0px;"><a style="font-size: 40px;text-decoration: none;" href="index.php">PROJECT-X</a></h1>
        
        <div id="mainNav">
        	<div>
                <ul>
                    
                    <li><a <?php if(preg_match("/principal/i", $areaAdmin))	{ echo "class='active'" ;} ?> href="principal.php">In&iacute;cio</a></li>
                    <li><a <?php if(preg_match("/orcamentos/i", $areaAdmin))    { echo "class='active'" ;} ?> href="orcamentos.php">Orçamentos</a></li>
                
                    
                    <!--<li><a <?php if(preg_match("/destaques/i", $areaAdmin))    { echo "class='active'" ;} ?> href="destaques.php">Destaques</a></li>-->
					
                   
                    <li class="logout"><a href="authentication.php?operacao=sair">Sair</a></li>
                    <li class="logout"><a href="usuario.php">[<?=$_SESSION['autenticado_login']?>]</a></li>
                </ul>
            </div>
        </div>