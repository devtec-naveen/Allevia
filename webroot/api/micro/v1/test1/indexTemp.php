<!DOCTYPE html>
<html>
<head>
	
	<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900" rel="stylesheet">
	<link href="bootstrap.min.css" rel="stylesheet" /> 
	<!-- <link rel="stylesheet" href="mdb.min.css" rel="stylesheet"/> -->
	<link href="fontawesome-all.css" rel="stylesheet"/>
	<link href="fontawesome.css" rel="stylesheet"/>
	<link href="style.css" rel="stylesheet"/>

	<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="bootstrap.min.js"></script>

</head>
<body>
<div id="wrapper">
	<div class="container">
	<!-- <h1>The iframe element</h1> -->
	<!--<iframe src="https://www.allevia.md/webroot/api/micro/v1/details.php" height="1000" width="1150">-->
	<form name="formForIframe" id="formForIframe" target="details" action="details.php" method="post"></form>
	<iframe name="details" height="1000" width="1150"> </iframe><!--src="details.php" -->
	<script type="text/javascript"> 
	document.getElementById("formForIframe").submit(); 
	</script>
	  <p>Your browser does not support iframes.</p>
	
</div>
</div>

</body>
</html>