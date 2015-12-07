<?php

$roop_count = 1;

for ($keta=1; $keta <= $argv[1] ; $keta++) {
	echo '['.$roop_count++.']' . $keta . '桁' . PHP_EOL;

	if($keta == 1 || $keta % 2 == 0){
		display(0, $keta - 1, sprintf("%0" . $keta . "d", "0"));
	} else {
		for ($kisu=0; $kisu < 9; $kisu++) {
			$base_num = sprintf("%0" . $keta . "d", "0");
			$base_num = substr_replace($base_num, $kisu, floor($keta / 2) + 1, 1);
			echo $base_num; exit;
			display(0, $keta - 1, );
		}
	}
}


function display($first, $second, $num){
	global $roop_count;

	for($i = 1; $i <= 9; $i++){

		$second_num = '';
		if($first != $second){
			$second_num = $i;
			$second_num = str_pad($second_num, $second - $first, 0, STR_PAD_LEFT);
			$second_num = str_pad($second_num, $second - $first + (strlen($num) - 1 - $second), 0);
		}

		$display_num = $num + intval($i . $second_num);
		echo '[' . $roop_count . ']' . $display_num . PHP_EOL;
		$roop_count++;

		if($second - $first > 2){

			display($first + 1, $second -1, $display_num);
		}
	}
}