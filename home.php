<?php include "includes/head_login.php"; ?>
<?php
$if_login = new usuario();// instancio la clase usuario
$if_login->if_login();
?>	
<script type="text/javascript">
$(function() {
		$( "#accordion" ).tabs(
		{
			
		}
		);
	});
$(document).ready(function() {
    $('.info').hover(
        function(){
            $(this).css("opacity",0.7);
            $(this).css("border-color","yellow");

        },function(){

            $(this).css("opacity",100);
            $(this).css("border-color","grey");

        });
     $('.fecha').hover(
        function(){
            $('.fecha').css("opacity",0.7);
        },function(){

            $('.fecha').css("opacity",100);
        });

    });
    window.contador = 0;    
    function historial_entrada_ajax(start){
        window.contador = window.contador+start;
        $.ajax(
           {
            url:'ajax/historial_entradas.php',
            type:'post',
            async:true,
            data:'start='+window.contador,
            success:respuesta,
            errror:respuesta
           }
        );
    }
    window.contador2=0;
    function historial_salida_ajax(start){
        window.contador2 = window.contador2+start;
        $.ajax(
           {
            url:'ajax/historial_salidas.php',
            type:'post',
            async:true,
            data:'start='+window.contador2,
            success:respuestaSal,
            errror:respuestaSal
           }
        );
    }    
    function respuesta(data){
       $("#respuesta").html(data);
    }
    function respuestaSal(data){
       $("#respuesta_salidas").html(data);
    }
    function add_money(){
        guita = $("#plata_nueva").val();
        $.ajax(
           {
            url:'ajax/add_money.php',
            type:'post',
            async:true,
            data:'cantidad='+guita,
            success:respuestaAdd,
            errror:respuestaAdd
           }
        );
    }
    function respuestaAdd(data){
        alert(data);
        location.href='home.php';
    }
    function remove_money(){
        guita = $("#saco_plata").val();
        razon = $("#razon").val();
        $.ajax(
           {
            url:'ajax/remove_money.php',
            type:'post',
            async:true,
            data:'cantidad='+guita+'&razon='+razon,
            success:respuestaAdd,
            errror:respuestaAdd
           }
        );
    }
        //VARIABLE GLOBAL
    var textoAnterior = '';

    //ESTA FUNCIÃ“N DEFINE LAS REGLAS DEL JUEGO
    function cumpleReglas(simpleTexto)
        {
            //la pasamos por una poderosa expresiÃ³n regular
            var expresion = new RegExp("^(|([0-9]{1,9}(\\.([0-9]{1,9})?)?))$");

            //si pasa la prueba, es vÃ¡lida
            if(expresion.test(simpleTexto))
                return true;
            return false;
        }//end function checaReglas

    //ESTA FUNCIÃ“N REVISA QUE TODO LO QUE SE ESCRIBA ESTÃ‰ EN ORDEN
    function revisaCadena(textItem)
        {
            //si comienza con un punto, le agregamos un cero
            if(textItem.value.substring(0,1) == '.') 
                textItem.value = '0' + textItem.value;

            //si no cumples las reglas, no te dejo escribir
            if(!cumpleReglas(textItem.value))
                textItem.value = textoAnterior;
            else //todo en orden
                textoAnterior = textItem.value;
        }//end function revisaCadena
   
</script>
	<div id="content">
		<section id="slid_pe">
			<div id="accordion">
                <ul>
    		      	<li><a href="#tab1">Fondo actual</a></h3></li>
                    <li><a href="#tab2">Ingresar plata</a></li>
                    <li><a href="#tab3">Retirar plata</a></li>
                    <li><a href="#tab4">Historial de ingresos</a></li>
                    <li><a href="#tab5">Historial de egresos</a></li>
                    <li><a href="#tab6">Estad&iacute;sticas</a></li>    
                </ul> 
                <div id="tab1">
                    <h1> Bienvenido <?php echo $_SESSION['ses_usuario']; ?></h1>
    			<?php
    				$dinero = new modelos();
					$res = $dinero->averiguar_dinero();
                    if($res == null or $res == 0 or empty($res)):
                        echo "No posees plata en tu cuenta, ve a la pesta&ntilde;a <b>ingresar plata</b> para agregar tus fondos";    
				    else:
                	   echo "Actualmente tienes $".$res." en tu capital ";
		            endif;
        		?>
				</div>
				
                <div id="tab2">
        			<h2>Centro de ingresos</h2>
                    <form method="post" name="add_plata" action="" >
                    <table summary="" >
                        <tr>
                            <td>
                                Ingresa el monto que quieres agregar a tu banco:
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="input" type="text" id="plata_nueva" onKeyUp="revisaCadena(this)" class="form-login"  >
                            </td>
                            <td>
                                <div id="ejemplo" align="justify">
                                    Los decimales son expresados con puntos, ejemplo 2 pesos con cincuenta ser&iacute;a 2.50
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Causa del ingreso:
                                <br>
                                <input type="text" name="causa_ingreso" class="input">
                            </td>
                            <td>
                                Sueldo, prestado por pepe, etc
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="button" onclick="add_money();" value="Guardar">
                            </td>
                        </tr>   
                    </table> 
                    </form>
                    <?php
                        $procesar = new modelos();
                        $res = $procesar->averiguar_dinero();
                        if($res == null or $res == 0 or empty($res)):
                               
                        else:
                            echo "Hasta ahora cuentas  en tu banco con $".$procesar->capital_actual." pesos";
                        endif;
                    ?>

                 </div><!-- fin tab 2 -->
    			<div id="tab3">
                                        <h2>Retiro de dinero</h2>
                    <form method="post" name="quit_plata" action="procesar_rem.php" >
                    <table summary="" >
                        <tr>
                            <td>
                                Ingrese el monto que retirar&aacute;s de t&uacute; banco:
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="input" type="text" id="saco_plata" onKeyUp="revisaCadena(this)" class="form-login">
                            </td>
                            <td>
                                <div id="ejemplo" align="justify">
                                    Los decimales son expresados con puntos, ejemplo 2 pesos con cincuenta ser&iacute;a 2.50
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Motivo del gasto:
                                <input class="input" type="text" id="razon"  class="form-login">
                            </td>
                            <td>
                                <div id="ejemplo" align="justify">
                                <br>
                                Retiro $15 para devolverle a pepito lo que me prest&oacute;                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="button" value="Guardar" onclick=" remove_money();">
                            </td>
                        </tr>   
                    </table> 
                    </form>
                    <?php
                        $res = $dinero->averiguar_dinero();
                        if($res == null or $res == 0 or empty($res)):
                            //echo "Todav&iacutea no has ingresado dinero a tu cuenta";    
                         else:
                            echo "Hasta ahora cuentas  en tu banco con $".$procesar->capital_actual." pesos";
                        endif;
                    ?>        

                </div><!-- fin tab3 -->
               <div id="tab4">
                    <div id="respuesta">
                    <?php
                        $res = $procesar->traer_hist_ent();
                        if(is_array($res)):
                            foreach($res as $key =>$row){
                                //echo "<tr><td class='ingreso' >
                                echo "<div class='info'>";
                                echo "Ingresaste $".$row['ingreso']."";
                                $viejo = $row['fecha'];
                                $exp = explode(" ",$viejo);
                                $fechaOld = $exp[0];
                                $explo = explode("-",$fechaOld);
                                $hora = $exp[1];
                                echo "<br>el ".$explo[2]."/".$explo[1]."/".$explo[0]." a las ".$hora;
                                echo "<br>Causa: ".$row['causa'];
                                echo "</div>";
                            }    
                             echo "<a href='javascript:void(0)' onclick='historial_entrada_ajax(5);' id='siguiente'>Siguiente</a>";
                        else:

                            echo $res;
                        endif;
                    ?>
                    </div><!-- fin respuesta -->
                    <br>
                </div>
    			<div id="tab5">
                     <div id="respuesta_salidas">
                    <?php
                        $res = $procesar->traer_hist_sal();
                        if(is_array($res)):
                            foreach($res as $key =>$row){
                                //echo "<tr><td class='ingreso' >
                                echo "<div class='info'>";
                                echo "Sacaste $".$row['salio']."";
                                $viejo = $row['fecha'];
                                $exp = explode(" ",$viejo);
                                $fechaOld = $exp[0];
                                $explo = explode("-",$fechaOld);
                                $hora = $exp[1];
                                echo "<br>el ".$explo[2]."/".$explo[1]."/".$explo[0]." a las ".$hora;
                                echo "<br>Causa: ";
                                if($row['causa'] == null ){    
                                    echo "Sin causa";
                                }else{
                                    echo $row['causa'];
                                }    
                                echo "</div>";
                            }    
                             echo "<a href='javascript:void(0)' onclick='historial_salida_ajax(5);' id='siguiente'>Siguiente</a>";
                        else:

                            echo $res;
                        endif;
                    ?>
                    </div><!-- fin respuesta -->
                </div><!-- fin tab 5 -->
                <div id="tab6">
                        <div id="chart_div"></div>

                   
                </div>  
    			
    		</div>
		</section>
		<section id="info_general">
			<br><br>
		</section>
	</div> <!-- fin content -->	
