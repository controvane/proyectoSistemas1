
<?php
session_start();


require_once "../../config/database.php";

if(isset($_POST['dataidobat'])) {
	$codigo = $_POST['dataidobat'];

 
  $query = mysqli_query($mysqli, "SELECT codigo,nombre,unidad FROM medicamentos WHERE codigo='$codigo'")
                                  or die('error '.mysqli_error($mysqli));
  
  $query2 = mysqli_query($mysqli, "SELECT SUM(stock) as suma FROM unidad_medicamentos WHERE codigo_medicamento='$codigo'")
                                  or die('error '.mysqli_error($mysqli));


  $data = mysqli_fetch_assoc($query);
  $data2 = mysqli_fetch_assoc($query2);

  $stock   = $data2['suma'];
  $unidad = $data['unidad'];

	if($stock != '') {
		echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Stock</label>
                <div class='col-sm-5'>
                  <div class='input-group'>
                    <input type='text' class='form-control' id='stok' name='stock' value='$stock' readonly>
                    <span class='input-group-addon'>$unidad</span>
                  </div>
                </div>
              </div>";
	} else {
		echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Stock</label>
                <div class='col-sm-5'>
                  <div class='input-group'>
                    <input type='text' class='form-control' id='stok' name='stock' value='' readonly>
                    <span class='input-group-addon'></span>
                  </div>
                </div>
              </div>";
	}		
}
?> 