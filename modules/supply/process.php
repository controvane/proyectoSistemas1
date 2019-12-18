<?php
session_start();


require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}

else {
    if ($_GET['act']=='insert') {
        if (isset($_POST['Guardar'])) {
     
            $codigo  = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
            $nombre  = mysqli_real_escape_string($mysqli, trim($_POST['nombre']));
            $tel_proveedor  = mysqli_real_escape_string($mysqli, trim($_POST['tel_proveedor']));
            $nom_contact  = mysqli_real_escape_string($mysqli, trim($_POST['nom_contact']));

            $created_user = $_SESSION['id_user'];

  
            $query = mysqli_query($mysqli, "INSERT INTO proveedor(codigo_proveedor,nombre,telefono,nombre_contacto,created_user,updated_user) 
                                            VALUES('$codigo','$nombre','$tel_proveedor','$nom_contact','$created_user','$created_user')")
                                            or die('error '.mysqli_error($mysqli));    

        
            if ($query) {
         
                header("location: ../../main.php?module=supply&alert=1");
            }   
        }   
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['codigo'])) {
        
                $codigo  = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
                $nombre  = mysqli_real_escape_string($mysqli, trim($_POST['nombre']));
                $tel_proveedor  = mysqli_real_escape_string($mysqli, trim($_POST['tel_proveedor']));
                $nom_contact  = mysqli_real_escape_string($mysqli, trim($_POST['nom_contact']));

                $updated_user = $_SESSION['id_user'];

                $query = mysqli_query($mysqli, "UPDATE proveedor SET  nombre = '$nombre', telefono = '$tel_proveedor', nombre_contacto = '$nom_contact' WHERE codigo_proveedor = '$codigo'")
                                                or die('error: '.mysqli_error($mysqli));

    
                if ($query) {
                  
                    header("location: ../../main.php?module=supply&alert=2");
                }         
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $codigo = $_GET['id'];
      
            $query = mysqli_query($mysqli, "DELETE FROM proveedor WHERE codigo_proveedor ='$codigo'")
                                            or die('error '.mysqli_error($mysqli));


            if ($query) {
     
                header("location: ../../main.php?module=supply&alert=3");
            }
        }
    }       
}       
?>