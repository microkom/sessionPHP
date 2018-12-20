<?php
// Se inicia la sesión o se recupera la anterior sesión existente
session_start();


//lee las variables de sesión de los productos para reutilizarlas
foreach($_SESSION as $key => $value){
	$_SESSION[$key] = $value;
}

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

			<header>
				Carrito
			</header>
			<section class="secCarrito">

				<?php		
				$total=0;
				$totalArticulos=0;

				$dwes = new PDO('mysql:host=localhost;dbname=badulaque', 'root', '' );
				$resultado = $dwes->query('SELECT * FROM productos;');


				print "<div class=\"carrito\">
				<div>
							<div>Artículo</div><div>Cantidad</div><div>Precio</div><div>Subtotal</div></div>";

				while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {

					//asignacion de valores de base de datos en las variables
					$codigo = $registro['codigo'];
					$nombre = $registro['nombre'];
					$precio = $registro['precio'];
					$unidad = $registro['unidad'];
					$stock = $registro['stock'];
					$imagen = $registro['imagen'];


					//crear la sesión en caso de que no exista
					if (!isset($_SESSION["cod".$codigo]))
						$_SESSION["cod".$codigo] = 0;

					print "
							<div>
								<div>$nombre</div>
								<div>".$_SESSION["cod".$codigo]." </div>
								<div>$precio €</div>                        
								<div>".$precio*$_SESSION["cod".$codigo]."</div>
                     </div>
						";

				$total += ($precio * $_SESSION["cod".$codigo]); //suma de todos los precios
				$totalArticulos += $_SESSION["cod".$codigo]; // suma de todos los articulos

				}
				print "</div>";
				$dwes =null;

				?>

			</section>
			<div class="footer"><br><br>
				<?php print "Total articulos : ".$totalArticulos. "<br>Total  : ".$total."€" ;?>

			</div>
			<footer class="footer">
				<a href="index.php">Volver</a>
			</footer>
		</section>

	</body>
</html>