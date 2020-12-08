<?php
//Con esto evitamos que un usuario entre si no esta logeado
if(!isset($_SESSION['uname'])){
	header('Location:' . BASE . 'index');
}

include 'header.tpl.php';
?>

<title>Home</title>
<!--Custom styles-->
<link rel="stylesheet" type="text/css" href="src/css/style.css">

<center>
	<h1>Start managing your tasks</h1>
	<img src="https://www.flaticon.es/svg/static/icons/svg/1935/1935389.svg">
</center>

<?php
include 'footer.tpl.php';
?>