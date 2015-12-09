<?php

$roop_count = 0;
$kaibun_count = 0;

// 1桁は回文に含めないので２桁から指定桁までループする
for ($keta=2; $keta <= $argv[1] ; $keta++) {
	$roop_count++;

	if($keta % 2 == 0){
		display(0, $keta - 1, sprintf("%0" . $keta . "d", "0"));
	} else {
		for ($kisu=0; $kisu <= 9; $kisu++) {
			$roop_count++;
			$base_num = sprintf("%0" . $keta . "d", "0");
			$base_num = substr_replace($base_num, $kisu, floor($keta / 2), 1);

			display(0, $keta - 1, $base_num);
		}
	}
}

echo '回文個数：' . $kaibun_count . PHP_EOL;
echo 'ループ回数：' . $roop_count . PHP_EOL;

function display($first, $second, $num){
	global $roop_count;
	global $kaibun_count;

	for($i = 1; $i <= 9; $i++){

		$second_num = '';
		if($first != $second){
			$second_num = $i;
			$second_num = str_pad($second_num, $second - $first, 0, STR_PAD_LEFT);
			$second_num = str_pad($second_num, $second - $first + (strlen($num) - 1 - $second), 0);
		}

		$display_num = $num + intval($i . $second_num);
		echo $display_num . PHP_EOL;

		if($second - $first > 2){
			display($first + 1, $second -1, $display_num);
		}


		$kaibun_count++;
		$roop_count++;
	}
}