<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta de Humedad</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/moment-with-locales.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>
	<script src="js/canvasjs.min.js"></script>
	<script type="text/javascript">
	function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    
    var CSV = '';    
    //Set Report title in first row or line
    
    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";
        
        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
            
            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);
        
        //append Label row with line break
        CSV += row + '\r\n';
    }
    
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        
        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);
        
        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var fileName = "Exportar_";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");   
    
    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    }
    
	$(document).ready(function() {
		$('form').submit(function(e) {
			e.preventDefault();
			$.getJSON('jsonH.php?' + $(this).serialize(), function(result) {
				var chart = new CanvasJS.Chart("chartContainer", {
						animationEnabled: true,
						theme: "theme2",
						title:
						{
							text: "Registro de Humedad"      
						},
						axisX:
						{
							labelAngle: 90,
							interlacedColor: "#F0F8FF" 
						},
						axisY:
						{
                             title: "% hum"
                        },
						data: [
							{
								type: "line",
								dataPoints: result
							}
						],
						legend: {
							cursor: "pointer",
							itemclick: function (e) {
								if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
									e.dataSeries.visible = false;
								} else {
									e.dataSeries.visible = true;
								}
								chart.render();
							}
						}
				});
				chart.render();
				JSONToCSVConvertor(result, "ConsultaH", true);
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
							<li class="active"><a href="consultaH.php"><span class="glyphicon glyphicon-tint"></span> Consultar Humedad</a></li>
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


<div class="container">
		<div class="page-header">	
			<h1>Consulta de Humedad</h1>
		</div>

		<form role="form" id="form1" name="form1">
			<div class="row">
        		<div class='col-sm-4'>
            		<div class="form-group">
                      	<label for="datetimepicker1">Desde</label>
                		<div class='input-group date' id='datetimepicker1'>
                          	<input type='text' class="form-control" name="fecha1" />
                    		<span class="input-group-addon">
                        		<span class="glyphicon glyphicon-calendar"></span>
                   			</span>
                		</div>
            		</div>
        		</div>
        		<script type="text/javascript">
            		$(function () {
                		$('#datetimepicker1').datetimepicker({
                    		locale: 'es'
                		});
            		});
        		</script>
              
              <div class='col-sm-4'>
            		<div class="form-group">
                      	<label for="datetimepicker2">Hasta</label>
                		<div class='input-group date' id='datetimepicker2'>
                        	<input type='text' class="form-control" name="fecha2"/>
                    		<span class="input-group-addon">
                        	<span class="glyphicon glyphicon-calendar"></span>
                   			</span>
                		</div>
            		</div>
        		</div>
        		<script type="text/javascript">
            		$(function () {
                		$('#datetimepicker2').datetimepicker({
                    		locale: 'es'
                		});
            		});
        		</script>
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
			<div id="chartContainer"> </div>
		</div>
		
		
</div>

 </body>
</html>

