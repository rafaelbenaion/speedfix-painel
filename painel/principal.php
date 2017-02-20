<?php 
session_start();
if($_SESSION["autenticado_painel"] != "SIM"){
    header("Location: index.php");
}
?>
<?php include('meta.php');
$areaAdmin = 'principal';?>
</head>

<body>
	<div id="wrapper">    	
    	<?php include('header.php') ?>        
        <div id="containerHolder">
			<div id="container">            	
                <div id="sidebar">
                	<ul class="sideNav">
                        <li><a href="usuario.php">Usuário </a></li>
                    </ul>
                </div>                
                <div id="conteudo">
                	<h2><a href="principal.php">Dashboard</a> &raquo; <a href="#" class="active">Início</a></h2>
                    <div id="main">
	        
                        <p>Atenção! Este painel está em fase BETA de desenvolvimento!</p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>

    </div>
</body>
</html>
