<?php
//Try to fetch database settings from external configuration file
require_once ('config/database.php');

@session_start();
class conectar
{
    public function conecta($host, $user, $pass, $db) {
        if (mysql_connect($host, $user, $pass)
            && mysql_select_db($db)) {
        } else {
            die('The database produced the following error: ' . mysql_error() . '<br>Please check your settings.');
        }
    }

}// FIN CLASE CONECTA

$conectar = new conectar();

$conectar->conecta(
    $db_settings['host'],
    $db_settings['user'],
    $db_settings['password'],
    $db_settings['database']
);
//INGRESAMOS LOS DATOS
class usuario
{
    public function login($usuario, $password) {
        $usuario = addslashes(trim($usuario));
        $password = sha1($password);
        $consulta = "SELECT * FROM usuario WHERE nombre='$usuario' AND pass = '$password'";
        mysql_real_escape_string($consulta);
        $sql = mysql_query($consulta);
        $encontrar = mysql_num_rows($sql);
        if ($encontrar) {
            $_SESSION['ses_usuario'] = $usuario;
            $_SESSION['ses_password'] = $password;
            $_SESSION['error_login'] = '';
            $consulta1 = "SELECT id FROM usuario WHERE nombre='" . $_SESSION['ses_usuario'] . "' AND pass='" . $_SESSION['ses_password'] . "'";
            $dosql = mysql_query($consulta1);
            if ($row = mysql_fetch_array($dosql)) {
                $_SESSION['ses_id_user'] = $row['id'];
            }
            header('Location: home.php');
        } else {
            $_SESSION['error_login'] = true;
            header('Location: index.php');
        }
    }

    public function if_login_index() {
        /*
         metodo que se carga al entrar al sitio
         para verificar si esta logeado

         */
        if (@$_SESSION['ses_usuario'] != '' AND $_SESSION['ses_password'] != '') {
            header('Location: home.php');
        }
    }

    public function if_login() {
        if ($_SESSION['ses_usuario'] != '' AND $_SESSION['ses_password'] != '') {
            // permanesco en la pagina

        } else {
            // si no se logeo redirecciono al index
            header('Location: index.php');
        }
    }

}// fin clase usuario

class comprobaciones
{
    function comp_add_rem($value) {
        $patron = "/[a-z|\{\}|\[\]|A-Z|\'\"|\(\)|\+|\<\>|\-|\_]/";
        if (preg_match($patron, $value)) {
            echo "Esta prohibido colocar caracteres que no sean numeros o puntos";
            exit();
        } else {
            //echo "Seguridad Fase 2 aprobada";

        }
    }

}

class modelos
{
    public $capital_actual;
    function __construct() {

    }

    public function registro($usuario, $password) {
        require_once ('captcha/recaptchalib.php');
        $privatekey = "6Leyl9QSAAAAAOIkjxdAsdyXGV7NiMN3XTOV5wx-";
        $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid) :
            echo "Captcha incorrecto";
            echo "<br><a href='javascript:history.back(1)' >Volver a ingresar</a>";
            $_SESSION['error_login2'] = true;
            return false;
        else :

            if (preg_match('/^[a-z\d_]{4,28}$/i', $usuario)) {

            } else {
                echo "Has ingresado caracteres no permitidos por favor elija otro nombre de usuario";
                echo "<br><a href='javascript:history.back(1)' >Volver a ingresar</a>";
                return false;
            }

            $usuario = addslashes(trim($usuario));
            $pass_cript = sha1(addslashes($password));
            //encriptamos la password
            $comprobar = "SELECT * FROM usuario WHERE nombre='$usuario'";
            $sqldo = mysql_query($comprobar);
            $localizo = mysql_num_rows($sqldo);
            if ($localizo > 0) {
                echo "El nombre de usuario seleccionado ya esta registrado, piensa otro";
                echo "<br><a href='javascript:history.back(1)' >Volver a ingresar</a>";
            } else {
                $consulta = "INSERT INTO usuario(nombre,pass) VALUES ('$usuario','$pass_cript')";
                $sql = mysql_query($consulta);
                if ($sql) {
                    echo "El registro se ha completado correctamente.<br> Ya puedes iniciar sesi&oacute;n, Bienvenido a &iquest;En qu&eacute; lo gast&eacute;?";
                    echo "<h1><a href='javascript:void(0)' onclick='LoginDialogo();'>Ingresar</a></h1>";
                } else {
                    echo "Hubo un problema al procesar el registro";
                    //. mysql_error();
                }
            }
        endif;//fin del else del captcha
    }

    public function averiguar_dinero() {
        $consulta = "SELECT dinero FROM capital WHERE id_user =" . $_SESSION['ses_id_user'] . "";
        $sql = mysql_query($consulta);
        //echo (mysql_num_rows($sql) >0) ? "hay" : "no hayy";
        if ($row2 = mysql_fetch_array($sql)) {
            $this->capital_actual = $row2['dinero'];
            //echo '<script type=text/javascript>var capital_actual='.$this->capital_actual.';</script>';
            return $this->capital_actual;
        } else {
            echo mysql_error();
        }
    }

    public function historial_entradas($ingreso) {
        $ingreso = htmlentities(addslashes(trim($ingreso)));
        $consulta = "INSERT INTO historial_entradas(id_user,entro) VALUES (" . $_SESSION['ses_id_user'] . ",$ingreso)";
        $sql = mysql_query($consulta);
        if ($sql) {
        } else {
            echo "Hubo un problema al actualizar el historial de entradas: ";
            //. mysql_error();
        }
    }

    public function historial_salidas($salida, $causa) {

        $salida = addslashes(trim($salida));

        $causa = htmlentities(addslashes($causa));
        $consulta = "INSERT INTO historial_salidas(id_user,salio,causa) VALUES (" . $_SESSION['ses_id_user'] . ",$salida,'$causa')";
        $sql = mysql_query($consulta);
        if ($sql) {
        } else {
            echo "Hubo un problema al actualizar el historial de salidas: ";
            //. mysql_error();
        }
    }

    public function add_money($plata) {
        $nuevo_monto = htmlentities(addslashes(trim($plata)));
        $explo = explode(".", $nuevo_monto);
        if (count($explo) > 2) {
            echo "Solo puedes ingresar un punto como m&aacuteximo";
            exit();
        }
        if (preg_match('/[[:alnum:]]/', $nuevo_monto)) {

        } else {
            echo "Has ingresado caracteres no permitidos, solo se aceptan caracteres numericos";
            exit();
        }
        $consulta = "SELECT * FROM capital where id_user='" . $_SESSION['ses_id_user'] . "'";
        $sql = mysql_query($consulta);
        if (mysql_num_rows($sql) > 0) {
            $row = mysql_fetch_array($sql);
            $dinero_viejo = $row['dinero'];
            $new_mount = $dinero_viejo + $nuevo_monto;
            $update = "UPDATE capital  SET dinero =$new_mount where id_user='" . $_SESSION['ses_id_user'] . "'";
            $sql = mysql_query($update);
            if ($sql) {
                $this->historial_entradas($nuevo_monto);
                $this->averiguar_dinero();
                echo "Se ha procesado tu ingreso ahora cuentas con  " . $this->capital_actual . " pesos";
            } else {
                echo "Hubo un problema al guardar tu ingreso";
                //. mysql_error();
            }
        } else {
            $insert = "INSERT INTO capital(id_user,dinero) VALUES(" . $_SESSION['ses_id_user'] . ",$nuevo_monto)";
            //echo $insert;
            $sql = mysql_query($insert);
            if ($sql) {
                $this->historial_entradas($nuevo_monto);
                $this->averiguar_dinero();
                echo "Se ha procesado tu ingreso ahora cuentas con " . $this->capital_actual . " pesos";
            } else {
                echo "Hubo un problema al guardar tu ingreso :";
                // . mysql_error();
            }
        }
    }

    public function remove_money($plata_saca, $razon) {
        $se_saca = addslashes(htmlentities(trim($plata_saca)));
        $explo = explode(".", $se_saca);
        if (count($explo) > 2) {
            echo "Solo puedes ingresar un punto como m&aacuteximo";
            exit();
        }
        if (preg_match('/[[:alnum:]]/', $se_saca)) {

        } else {
            echo "Has ingresado caracteres no permitidos, solo se aceptan caracteres numericos";
            exit();

        }
        $causa = htmlentities(addslashes($razon));
        $consulta = "SELECT * FROM capital where id_user='" . $_SESSION['ses_id_user'] . "'";
        $sql = mysql_query($consulta);
        if (mysql_num_rows($sql) > 0) {
            $row = mysql_fetch_array($sql);
            $dinero_viejo = $row['dinero'];
            if ($dinero_viejo < $se_saca) {
                echo "No puedes sacar dinero que no tienes";
                exit();
            } else {

                $new_mount = $dinero_viejo - $se_saca;

                $update = "UPDATE capital  SET dinero =$new_mount where id_user='" . $_SESSION['ses_id_user'] . "'";
                $sql = mysql_query($update);
                if ($sql) {
                    $this->historial_salidas($se_saca, $causa);
                    $this->averiguar_dinero();
                    echo "Se ha procesado tu salida ahora cuentas con " . $this->capital_actual . " pesos";

                } else {
                    echo "Hubo un problema al sacar dinero ";
                    // . mysql_error();
                }
            }
        } else {
            echo "No puedes sacar dinero si nunca has hecho un ingreso";
        }

    }

    public function traer_hist_ent($start = 0) {
        $res = array();
        $consulta = "SELECT * FROM historial_entradas  where id_user =" . $_SESSION['ses_id_user'] . " ORDER BY id DESC limit " . $start . ",5 ";
        $sql = mysql_query($consulta);
        if (mysql_num_rows($sql) > 0) :
            $acum = 0;
            while ($row = mysql_fetch_array($sql)) {
                $res[$acum]['causa'] = $row['causa'];
                $res[$acum]['ingreso'] = $row['entro'];
                $res[$acum]['fecha'] = $row['fecha'];
                $acum++;
            }
            return $res;
        else :
            $consulta = "SELECT * FROM historial_entradas  where id_user =" . $_SESSION['ses_id_user'];
            $sql = mysql_query($consulta);
            if (mysql_num_rows($sql) > 0) {
                return "<h2>No hay mas ingresos</h2><br><h3><a href='javascript:void(0);' onclick='historial_entrada_ajax(-5);' id='atras'>Atr&aacute;s</a></h3>";
            } else {
                return "<h2>No se han registrado ingresos todav&iacute;a</h2>";
            }
        endif;
        mysql_free_result($sql);

    }

    public function traer_hist_sal($start = 0) {
        $res = array();
        $consulta = "SELECT * FROM historial_salidas  where id_user =" . $_SESSION['ses_id_user'] . " ORDER BY fecha DESC limit " . $start . ",5 ";
        $sql = mysql_query($consulta);
        if (mysql_num_rows($sql) > 0) :
            $acum = 0;
            while ($row = mysql_fetch_array($sql)) {
                $fechaVieja = $row['fecha'];
                $res[$acum]['salio'] = $row['salio'];
                $res[$acum]['causa'] = $row['causa'];
                $res[$acum]['fecha'] = $fechaVieja;
                $acum++;
            }
            return $res;
        else :
            $consulta = "SELECT * FROM historial_salidas  where id_user =" . $_SESSION['ses_id_user'];
            $sql = mysql_query($consulta);
            if (mysql_num_rows($sql) > 0) {
                return "<h2>No hay mas salidas</h2><br><h3><a href='javascript:void(0);' onclick='historial_salida_ajax(-5);' id='atras'>Atr&aacute;s</a></h3>";
            } else {
                return "<h2>No se han registrado salidas todav&iacute;a</h2>";
            }
        endif;

    }

} // fin clase model
?>
