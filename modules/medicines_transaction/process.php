

<?php
session_start();

require_once "../../config/database.php";

echo "Usuario: ".$_SESSION['username']."<br>";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
    echo "Holiwis Kiwis todo se fue al cuerno";
}

else {
    if ($_GET['act']=='insert') {
            
            $codigo_transaccion = mysqli_real_escape_string($mysqli, trim($_POST['codigo_transaccion']));
            
			$fecha = mysqli_real_escape_string($mysqli, trim($_POST['fecha_a']));
            $exp = explode('-',$fecha);
            $fecha_a = $exp[2]."-".$exp[1]."-".$exp[0];
        
            $fecha = mysqli_real_escape_string($mysqli, trim($_POST['fecha_vec']));
            $exp = explode('-',$fecha);
            $fecha_vec = $exp[2]."-".$exp[1]."-".$exp[0];
            
            $codigo = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
            $num   = mysqli_real_escape_string($mysqli, trim($_POST['num']));
            $total_stock = mysqli_real_escape_string($mysqli, trim($_POST['total_stock']));
            $tipo_transaccion= mysqli_real_escape_string($mysqli, trim($_POST['transaccion']));
            $created_user = $_SESSION['id_user'];
        
            $query_id = mysqli_query($mysqli, "SELECT RIGHT(codigo,6) as codigo FROM unidad_medicamentos
                                                ORDER BY codigo DESC LIMIT 1")
                                                or die('error '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
            
                  $data_id = mysqli_fetch_assoc($query_id);
                  $codigo_unidad = $data_id['codigo']+1;
              } else {
                  $codigo_unidad = 1;
              }


              $crear_id   = str_pad($codigo_unidad, 6, "0", STR_PAD_LEFT);
              $codigo_unidad = "U$crear_id";
            
            
            $query1 = mysqli_query($mysqli, "INSERT INTO unidad_medicamentos(codigo,codigo_medicamento,fecha_vencimiento,stock,created_user,update_user) 
                                            VALUES('$codigo_unidad','$codigo','$fecha_vec','$num','$created_user','$created_user')")
                                            or die('Error: '.mysqli_error($mysqli));
        

            
            $query2 = mysqli_query($mysqli, "INSERT INTO transaccion_medicamentos(codigo_transaccion,fecha,codigo,numero,created_user,tipo_transaccion) 
                                            VALUES('$codigo_transaccion','$fecha_a','$codigo','$num','$created_user','$tipo_transaccion')")
                                            or die('Error: '.mysqli_error($mysqli));    

           
            if ($query2) {
                                     
                header("location: ../../main.php?module=medicines_transaction&alert=1");

            }    
    }
    elseif ($_GET['act']=='take') {
            
            $codigo_transaccion = mysqli_real_escape_string($mysqli, trim($_POST['codigo_transaccion']));
            
			$fecha = mysqli_real_escape_string($mysqli, trim($_POST['fecha_a']));
            $exp = explode('-',$fecha);
            $fecha_a = $exp[2]."-".$exp[1]."-".$exp[0];
            
            $codigo = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
            $num   = mysqli_real_escape_string($mysqli, trim($_POST['num']));
            $total_stock = mysqli_real_escape_string($mysqli, trim($_POST['total_stock']));
            $tipo_transaccion= mysqli_real_escape_string($mysqli, trim($_POST['transaccion']));
            $created_user = $_SESSION['id_user'];
            $updated_user = $_SESSION['id_user'];
            
            $query = mysqli_query($mysqli, "INSERT INTO transaccion_medicamentos(codigo_transaccion,fecha,codigo,numero,created_user,tipo_transaccion) 
                                            VALUES('$codigo_transaccion','$fecha_a','$codigo','$num','$created_user','$tipo_transaccion')")
                                            or die('Error: '.mysqli_error($mysqli));    

           
            if ($query) {
                
                do{
                    $query1 = mysqli_query($mysqli, "SELECT codigo,stock FROM unidad_medicamentos WHERE codigo_medicamento = '$codigo' ORDER BY fecha_vencimiento ASC")
                                            or die('Error: '.mysqli_error($mysqli));
                    
                    $data = mysqli_fetch_assoc($query1);
                    $codigo_unidad = $data['codigo'];
                    if($num>$data['stock']){
                        $num = $num - $data['stock'];
                        $query2 = mysqli_query($mysqli, "DELETE FROM unidad_medicamentos WHERE codigo = '$codigo_unidad'")
                                            or die('Error: '.mysqli_error($mysqli));
                    }
                    else{
                        $num = $data['stock'] - $num;
                        $query2 = mysqli_query($mysqli, "UPDATE unidad_medicamentos SET stock = '$num', update_user='$updated_user' WHERE codigo = '$codigo_unidad'")
                                            or die('Error: '.mysqli_error($mysqli));
                        $num = 0;
                    }
                    
                }while($num > 0);
                                     
                header("location: ../../main.php?module=medicines_transaction&alert=1");

            }    
    }
}       
?>