<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Temperatura y Humedad</title>

    <!-- Bootstrap -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <style>
        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: 100%;
            margin: auto;
        }
    </style>
  
</head>
  <body>
    
    <!-- Barra de Navegación -->
    
    <nav class="navbar navbar-default">
		<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">Inicio</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon  glyphicon-search"></span> Consulta TyH <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="consultaT.php"><span class="glyphicon glyphicon-fire"></span> Consultar Temperatura</a></li>
							<li><a href="consultaH.php"><span class="glyphicon glyphicon-tint"></span> Consultar Humedad</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="consulta.php"><span class="glyphicon  glyphicon-search"></span> Consultar Ambas</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-warning-sign"></span> Alertas <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="alertaT.php"><span class="glyphicon glyphicon-fire"></span> Alertas Temperatura</a></li>
							<li><a href="alertaH.php"><span class="glyphicon glyphicon-tint"></span> Alertas Humedad</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="alertas.php"><span class="glyphicon glyphicon-warning-sign"></span> Ambas Alertas</a></li>
						</ul>
					</li>
					<li><a href="config.php"><span class="glyphicon glyphicon-wrench"></span> Configuraci&oacute;n</a></li>
				</ul>      
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

      
      
    <!-- Contenido -->
      
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
			<li data-target="#myCarousel" data-slide-to="3"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="img/1.jpg" alt="Inicio" >
			</div>
		
			<div class="item">
				<img src="img/2.jpg" alt="Registro" >
			</div>
	
			<div class="item">
				<img src="img/3.jpg" alt="Alertas" >
			</div>

			<div class="item">
				<img src="img/4.jpg" alt="Configuracion" >
			</div>
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Anterior</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Siguiente</span>
		</a>
	</div>
			
			
  </body>
</html>