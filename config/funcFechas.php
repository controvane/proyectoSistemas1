<?php
	
	function fec_a_mes($fec) {
		$fecha	= explode('-',$fec);
		$kdbl		= $fecha[1];

		if ($kdbl == '01')	{
			$nbln = 'Enero';
		}
		else if ($kdbl == '02') {
			$nbln = 'Febreo';
		}
		else if ($kdbl == '03') {
			$nbln = 'Marzo';
		}
		else if ($kdbl == '04') {
			$nbln = 'Abril';
		}
		else if ($kdbl == '05') {
			$nbln = 'Meyo';
		}	
		else if ($kdbl == '06') {
			$nbln = 'Junio';
		}
		else if ($kdbl == '07') {
			$nbln = 'Julio';
		}
		else if ($kdbl == '08') {
			$nbln = 'Agosto';
		}
		else if ($kdbl == '09') {
			$nbln = 'Septiembre';
		}
		else if ($kdbl == '10') {
			$nbln = 'Oktober';
		}
		else if ($kdbl == '11') {
			$nbln = 'Noviembre';
		}
		else if ($kdbl == '12') {
			$nbln = 'Diciembre';
		}
		else {
			$nbln = '';
		}
		
		$fec_mes = $fecha[0]."  ".$nbln."  ".$tanggal[2];
		return $fec_mes;
	}
?>
