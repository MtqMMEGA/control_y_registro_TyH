<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración de Alertas</title>

    <!-- Bootstrap -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-checkbox.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <script type="text/javascript">
	    $(document).ready(function() {
			$.post("jsonConfigLeer.php", function(datosjson){
				datos = JSON.parse(datosjson);			
				$("#email_alerta").val(datos.email);
				$("#TMax").val(datos.TMax);
				$("#HMax").val(datos.HMax);
				$("#intervalo").val(datos.intervalo);
				if(datos.alarma == 1)
					$("#alarma").prop("checked", true);
				else
					$("#alarma").prop("checked", false);
			});
			$('form').submit(function(e) {
				e.preventDefault();
				$("#exito").delay(500).fadeOut("slow");
				$("#fracaso").delay(500).fadeOut("slow");
				$.get('jsonConfigGrabar.php?'+$(this).serialize(),function(result){
                    if(result == 1){
                        $("#exito").delay(500).fadeIn("slow");      // Si hemos tenido éxito, hacemos aparecer el div "exito" con un efecto fadeIn lento tras un delay de 0,5 segundos.
                    } else {
                        $("#fracaso").delay(500).fadeIn("slow");    // Si no, lo mismo, pero haremos aparecer el div "fracaso"
                    }
                });
		    });
	    });
	</script>
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
					<li class="active"><a href="config.php"><span class="glyphicon glyphicon-wrench"></span> Configuraci&oacute;n</a></li>
				</ul>      
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

      
      
    <!-- Contenido -->
      
    <div class="container">
		<div class="page-header">	
			<h1>Configuración de Alertas</h1>
		</div>

		<form role="form" action="jsonC.php" method="get">
			<div class="form-group">
              	<div class="row">
                  	<div class="col-xs-6">
						<label for="email_alerta">Email</label>
						<input type="email" class="form-control" name="email_alerta" id="email_alerta" placeholder="Introduce el email de aviso de alertas" required="required">
                  </div>
              </div>
			</div>
			
			<div class="row">
				<div class="col-xs-3">
					<div class="form-group">
						<label for="TMax">Temperatura M&aacute;xima</label>
						<input type="number" name="TMax" id="TMax" class="form-control" min="0" max="50" required="required">
					</div>
				</div>		
				<div class="col-xs-3">
					<div class="form-group">
						<label for="HMax">Humedad M&aacute;xima</label>
						<input type="number" name="HMax" id="HMax" class="form-control" min="1" max="100" required="required">
					</div>
				</div>		
			</div>
				
			<div class="row">
				<div class="col-xs-2">
					<div class="form-group">
						<label for="intervalo">Intervalo (minutos)</label>
						<input type="number" name="intervalo" id="intervalo" class="form-control" min="1" max="1440" required="required">
					</div>
				</div>			
			</div>
			
			<div class="row">
              	<div class="col-xs-6">
                  	<div class="form-group">
			    		<div class="checkbox">
				    		<label for="alarma">Habilitar alarma?</label>
							<input type="checkbox"  name="alarma" id="alarma" data-reverse value="1">
				    		<script type="text/javascript">$(':checkbox').checkboxpicker({onLabel:"SI",offLabel:"NO"});</script>
 			    		</div>
                  </div>
              </div>
			</div>
			
			<div class="row">
            	<div class="col-xs-2">
                  	<div class="input-group">
			    		<button type="submit" class="btn btn-default">Enviar</button>
                	</div>
           		</div>
			</div>
		</form>	
			
		<div class="row">
			<div class="input-group">
		    	<div id="exito" style="display:none; margin-top: 10px;" class="alert alert-success">
					Sus datos han sido grabados correctamente.
				</div>
               
               
				<div id="fracaso" style="display:none;margin-top: 10px;" class="alert alert-danger">
					Se ha producido un error durante el env&iacute;o de datos.
				</div>
			</div>
		</div>	
		
	</div>
  </body>
</html>