<?php
//..fungsi penghitung menit.begin
//..satuan w=minggu, d=hari, h=jam, m=menit, s=detik (default m=menit)
function get_menit($waktu_mt, $satuan = 'm'){
	//..reset isi.begin
	$i 	= 0;
	
	$s	= 0;
	$m	= 0;
	$h	= 0;
	$d	= 0;
	$w	= 0;
	
	$rs	= "";
	$rm	= "";
	$rh	= "";
	$rd	= "";
	$rw	= "";
	
	$awal = "";
	//..reset isi.end
	$result = 0;
	$awal = $waktu_mt;
	//..pisah waktu.begin
	$pow = strpos($awal, 'w');
	$pod = strpos($awal, 'd');
	$poh = strpos($awal, 'h');
	$pom = strpos($awal, 'm');
	$pos = strpos($awal, 's');

		//.ambil minggu
		if($pow > 0) {
			$aw = preg_match('/(.*?)w/', $awal, $row);
			$w	= $row[1];
			if($w == ""){
				$w = 0;
			}
		}
		
		//.ambil hari
		if($pod > 0) { 
			if($pow > 0) {
				$ad = preg_match('/w(.*?)d/', $awal, $row);
				$d = $row[1];
			} else {
				$ad = preg_match('/(.*?)d/', $awal, $row);
				$d = $row[1];
			}
		}
		
		//.ambil jam
		if($poh > 0) { 
			if($pod > 0) {
				$ah = preg_match('/d(.*?)h/', $awal, $row);
				$h = $row[1];
			} else if($pow > 0) {
				$ah = preg_match('/w(.*?)h/', $awal, $row);
				$h = $row[1];
			} else {
				$ah = preg_match('/(.*?)h/', $awal, $row);
				$h = $row[1];
			}
		}
		
		//.ambil menit
		if($pom > 0) { 
			if($poh > 0) {
				$am = preg_match('/h(.*?)m/', $awal, $row);
				$m = $row[1];
			} else if($pod > 0) {
				$am = preg_match('/d(.*?)m/', $awal, $row);
				$m = $row[1];
			} else if($pow > 0) {
				$am = preg_match('/w(.*?)m/', $awal, $row);
				$m = $row[1];
			} else {
				$am = preg_match('/(.*?)m/', $awal, $row);
				$m = $row[1];
			}
		}
		
		//.ambil detik
		if($pos > 0) { 
			if($pom > 0) {
				$as = preg_match('/m(.*?)s/', $awal, $row);
				$s = $row[1];
			} else if($poh > 0) {
				$as = preg_match('/h(.*?)s/', $awal, $row);
				$s = $row[1];
			} else if($pod > 0) {
				$as = preg_match('/d(.*?)s/', $awal, $row);
				$s = $row[1];
			} else if($pow > 0) {
				$as = preg_match('/w(.*?)s/', $awal, $row);
				$s = $row[1];
			} else {
				$as = preg_match('/(.*?)s/', $awal, $row);
				$s = $row[1];
			}
		}
		
		//..jadikan semuanya menit.begin
		$tw = 0;
		if($w > 0) {
			$tw = $w; //ambil minggu
		}
		
		$td = 0;
		if($tw > 0){
			$td = $d + ($tw * 7); //1 minggu 7 hari
		} else {
			$td = $d;
		}
		
		$th = 0;
		if($td > 0){
			$th = $h + ($td * 24); //1 hari 24 jam
		} else {
			$th = $h;
		}
		
		$tm = 0;
		if($th > 0){
			$tm = $m + ($th * 60); //1 jam 60 menit
		} else {
			$tm = $m;
		}
		
		$ts = 0;
		if($tm > 0){
			$ts = $s + ($tm * 60); //1 jam 60 menit
		} else {
			$ts = $s;
		}
		//..jadikan semuanya menit.end
		/*
		//.logika keterlibatan (show/hide).begin
			$rw = "";
			if($w > 0){
				$rw = $w."w";
			}
			
			$rd = "";
			if($d > 0){
				$rd = $d."d";
			}
			
			$rh = "";
			if($h > 0){
				$rh = $h."h";
			}
			
			$rm = "";
			if($m > 0){
				$rm = $m."m";
			}
			
			$rs = "";
			if($s > 0){
				$rs = $s."s";
			}
		//.logika keterlibatan (show/hide).end

		$result = $rw.$rd.$rh.$rm.$rs;
		$result .= "|";
		*/
		$result = $tm;
		if($satuan == 'w'){
			$result = $tw;
		} else if($satuan == 'd'){
			$result = $td;
		} else if($satuan == 'h'){
			$result = $th;
		} else if($satuan == 'm'){
			$result = $tm;
		} else if($satuan == 's'){
			$result = $ts;
		}
		return $result;
	//..pisah waktu.end
}

function set_waktu($detik){
	$menit = $detik / 60; //..1 menit = 60 detik
	$jam = $menit / 60; //..1 jam = 60 menit
	$hari = $jam / 24; //..1 hari = 24 jam
	$minggu = $hari / 7; //..1 minggu = 7 hari
	
	if($menit < 1){
		$menit = 0;
		$jam = 0;
		$hari = 0;
		$minggu = 0;
	}
	
	$result = $minggu."w".$hari."d".$jam."h".$menit."m".$detik."s";
	return $result;
}
//..fungsi penghitung menit.end


//.http://php.net/manual/en/function.time.php#108581
function time_elapsed_A($secs){
	$bit = array(
		'w' => floor($secs / 604800),
		'd' => $secs / 86400 % 7,
		'h' => $secs / 3600 % 24,
		'm' => $secs / 60 % 60,
		's' => $secs % 60
		);
	
	foreach($bit as $k => $v){
		if($v > 0){
			$ret[] = $v.$k;
		}
	}
	
	if(!isset($ret)) {
		$ret[] = "0s";
	}
		
	return join('', $ret);
}

//echo "HASIL : ".set_waktu(59);
//echo "HASIL : ".time_elapsed_A(get_menit('501w2d3h4m5s','s'));
?>