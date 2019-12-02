
<script type="text/javascript">
      function appearMed(input){
        var num = input.value;

        $.post("modules/medicines_transaction/medicines.php", {
          dataidobat: num,
        }, function(response) {      
          $('#stok').html(response)

          document.getElementById('inputNumber').focus();
        });
      }

      function checkearValido(){
          //document.getElementById('formInMed').submit();
          var num = document.getElementById('total_stok').value;
          if(num>=0){
              document.getElementById('formInMed').submit();
          }
          else{
              alert("No se puede reducir el stock a menos de 0");
          }
      }
    
      function checkInputNumber(input) {
        jml = document.formInMed.inputNumber.value;
        var jumlah = eval(jml);
        if(jumlah < 1){
          alert('Cantidad de entrada no permitida.');
          input.value = input.value.substring(0,input.value.length-1);
        }
      }

      function countTotalStock() {
        bil1 = document.formInMed.stok.value;
        bil2 = document.formInMed.inputNumber.value;
        tt = document.formInMed.transaccion.value;

        if (bil2 == "") {
          var hasil = "";
        }
        else {
          var salida = eval(bil1) - eval(bil2);
          var hasil = eval(bil1) + eval(bil2);
        }

        if (tt=="Salida"){
            document.formInMed.total_stok.value = (salida);
        }	else {
            document.formInMed.total_stok.value = (hasil);
        } 

      }
</script>

<?php  

if ($_GET['form']=='add') { ?> 

  <section class="content-header">
    <h1>
      <i class="fa fa-edit icon-title"></i> Datos entradas / salidas de Medicamentos
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=start"><i class="fa fa-home"></i> Inicio </a></li>
      <li><a href="?module=medicines_transaction"> Entrada </a></li>
      <li class="active"> Agregar </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" action="modules/medicines_transaction/process.php?act=insert" method="POST" id = "formInMed" name="formInMed">
            <div class="box-body">
              <?php  
            
              $query_id = mysqli_query($mysqli, "SELECT RIGHT(codigo_transaccion,7) as codigo FROM transaccion_medicamentos
                                                ORDER BY codigo_transaccion DESC LIMIT 1")
                                                or die('Error : '.mysqli_error($mysqli));

              $count = mysqli_num_rows($query_id);

              if ($count <> 0) {
                 
                  $data_id = mysqli_fetch_assoc($query_id);
                  $codigo    = $data_id['codigo']+1;
              } else {
                  $codigo = 1;
              }

             
              $tahun          = date("Y");
              $crear_id        = str_pad($codigo, 7, "0", STR_PAD_LEFT);
              $codigo_transaccion = "TM-$tahun-$crear_id";
              ?>

              <div class="form-group">
                <label class="col-sm-2 control-label">Codigo de Transacción </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="codigo_transaccion" value="<?php echo $codigo_transaccion; ?>" readonly required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Fecha</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="fecha_a" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                </div>
              </div>

              <hr>

              <div class="form-group">  
                <label class="col-sm-2 control-label">Medicamento</label>
                <div class="col-sm-5">
                  <select class="chosen-select" name="codigo" data-placeholder="-- Seleccionar Medicamento --" onchange="appearMed(this)" autocomplete="off" required>
                    <option value=""></option>
                    <?php
                      $query_obat = mysqli_query($mysqli, "SELECT codigo, nombre FROM Medicamentos ORDER BY nombre ASC")
                                                            or die('error '.mysqli_error($mysqli));
                      while ($data_obat = mysqli_fetch_assoc($query_obat)) {
                        echo"<option value=\"$data_obat[codigo]\"> $data_obat[codigo] | $data_obat[nombre] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
              
              <span id='stok'>
              <div class="form-group">
                <label class="col-sm-2 control-label">Stock</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="stok" name="stock" readonly required>
                </div>
              </div>
              </span>

              <div class="form-group">
                <label class="col-sm-2 control-label">Cantidad</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" id="inputNumber" name="num" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" onkeyup="countTotalStock(this)&checkInputNumber(this)" required>
                </div>
              </div>
			  
			  <div class="form-group">
                <label class="col-sm-2 control-label">Transacción</label>
                <div class="col-sm-5">
                  <select name="transaccion" id="transaccion" required class='form-control' onchange="countTotalStock();">
					<option value="Salida">Salida</option>
					<option value="Entrada">Entrada</option>
				  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Total Stock</label>
                <div class="col-sm-5">
                  <input type="number" class="form-control" id="total_stok" name="total_stock" min="0" step="0.5" readonly required>
                </div>
              </div>

            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="button" class="btn btn-primary btn-submit" id="Guardar" name="Guardar" value="Guardar" onclick="checkearValido()">
                  <a href="?module=medicines_transaction" class="btn btn-default btn-reset">Cancelar</a>
                </div>
              </div>
            </div><!-- /.box footer -->
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}
?>