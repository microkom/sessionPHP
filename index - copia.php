<?php
// Se inicia la sesión o se recupera la anterior sesión existente
session_start();

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
            Tienda Online
         </header> 
         <section>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">

               <?php


   $dwes = new PDO('mysql:host=localhost;dbname=badulaque', 'root', '' );
                  $resultado = $dwes->query('SELECT * FROM productos;');


                  print "<div class=\"table\"> ";

                  $i = 0; //indice de sesiones

                  while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {

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
                           if($_SESSION["cod".$codigo] < $_SESSION["cod".$codigo.'stock']){
                              $_SESSION["cod".$codigo] += 1;
                           }
                        }else
                           $_SESSION["cod".$codigo] = 0;
                     }


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

                     $_SESSION["cod".$codigo.'stock'] = $stock;



                     $_SESSION["se[$i]"] = $_SESSION["cod".$codigo.'stock'];
                     $i++;
                  }

                  print "</div>";
                  $dwes =null;

               ?>



            </form></section><div class="footer"><br><br>
         <a href="carrito.php">Ver carrito</a>            
         </div>
      </section>
   </body>
</html>