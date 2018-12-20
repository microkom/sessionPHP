<?php
// Se inicia la sesión o se recupera la anterior sesión existente
session_start();

//control de la sesión que expira despues de 600 segundos
if(isset($_SESSION['ultimaVez']) && (time() - $_SESSION['ultimaVez'] > 600)){
	$expirado = true;
	session_unset();
	session_destroy();
}

$minutosSesion = 10;
$tiempo = new DateTime(date('Y-m-d H:i'));
$tiempo->add(new DateInterval('PT' . $minutosSesion . 'M'));
$mostrarHora = $tiempo->format('Y-m-d H:i');

?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Carrito compra</title>
		<style>
			@import url(style.css);
		</style>
	</head>
	<body>
		<section class="main">

			<header>Tienda Online</header> 
			<div class="expira">
				<?php 
				if(isset($expirado)){
					if($expirado){
						print "La sesión ha expirado";
					}
				}else{
					print "Se sesión expirará a las ".$mostrarHora;
				}
				?>
			</div>
			<section>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

					<?php
	$dwes = new PDO('mysql:host=localhost;dbname=badulaque', 'root', '' );
						
						$resultado = $dwes->query('SELECT * FROM productos;');


						print "<div class=\"table\"> ";

						$i = 0; //indice de sesiones

						while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {

							//variables de los datos de cada producto
							$codigo = $registro['codigo'];
							$nombre = $registro['nombre'];
							$precio = $registro['precio'];
							$unidad = $registro['unidad'];
							$stock = $registro['stock'];
							$imagen = $registro['imagen'];

							//crear la sesión en caso de que no exista
							if (!isset($_SESSION["cod".$codigo]))
								$_SESSION["cod".$codigo] = 0;

							//tomar valores del formulario para sumar, restar o vaciar el carrito
							if(isset($_POST["cod".$codigo])){
								if ($_POST["cod".$codigo] =='-'){
									if($_SESSION["cod".$codigo] >0){
										$_SESSION["cod".$codigo] -= 1;
									}
								}else if($_POST["cod".$codigo] =='+'){
									if(isset($_SESSION["cod".$codigo.'stock'])){
										if($_SESSION["cod".$codigo] < $_SESSION["cod".$codigo.'stock']){
											$_SESSION["cod".$codigo] += 1;
										}}
								}else
									$_SESSION["cod".$codigo] = 0;
							}

							//Mostrar la imagen y los botones en pantalla
							print "
                  <div>
                     <div>
                        <div><img class=\"img\" src=\"$imagen\" ></div><hr>
                        <div>".$_SESSION["cod".$codigo]." </div>
								<div> 
									<input type=\"submit\" name=\"cod".$codigo."\" value=\"-\"> 
									<input type=\"submit\" name=\"cod".$codigo."\" value=\"+\">
									<input type=\"submit\" name=\"cod".$codigo."\" value=\"Bin\">
								</div><hr>
                        <div>Precio: $precio € x $unidad </div>
                        <div>Stock : $stock</div>

                     </div>
						</div>
					";

							//variable de sesión por producto
							$_SESSION["cod".$codigo.'stock'] = $stock;

							//almacenamiento de las variables de sesión por producto para cargarlas en otra página dinámicamente
							$_SESSION["se[$i]"] = $_SESSION["cod".$codigo.'stock'];
							$i++;
						}

						print "</div>";
						$dwes =null;

						//definición del tiempo de la sesión
						$_SESSION['ultimaVez'] = time();
						$expirado = false;
					?>



				</form></section><div class="footer"><br><br>
			<a href="carrito.php">Ver carrito</a>            
			</div>
		</section>
	</body>
</html>