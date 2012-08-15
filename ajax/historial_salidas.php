<?php
include '../clases.php';
$if_login = new usuario();// instancio la clase usuario
$if_login->if_login();
$start = $_POST['start'];
$procesar = new modelos();
$res = $procesar->traer_hist_sal($start);
if(is_array($res)):
    foreach($res as $key =>$row){
        echo "<div class='info'>";
        echo "Sacaste $".$row['salio']."";
        echo "<br>el ".$row['fecha'];
        echo "</div>";
    }
  ?>
<script type="text/javascript">
$(document).ready(function() {
    $('.info').hover(
        function(){
            $(this).css("opacity",0.7);
            $(this).css("border-color","yellow");

        },function(){

            $(this).css("opacity",100);
            $(this).css("border-color","grey");

        });
});

</script>
<?php
  
    if($start >= 5){   
    	echo "<a href='javascript:void(0);' id='atras' onclick='historial_salida_ajax(-5);'>Atr&aacute;s</a>";
    }
    echo "<a href='javascript:void(0)' id='siguiente' onclick='historial_salida_ajax(5);'>Siguiente</a>";
else:    
    echo $res;
endif;
?>
