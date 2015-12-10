<?php

$roop_count = 0;
$kaibun_count = 0;

// 1桁は回文に含めないので２桁から指定桁までループする
for ($keta=2; $keta <= $argv[1] ; $keta++) {
	$roop_count++;

	for ($i =1; $i <= 9 ; $i++){
		$roop_count++;

		// 指定桁の基準の数字（$i）で最小値を作成する
		// 最小値は１桁目と最後の桁に基準値を設定して残りの桁は０
		$num = str_pad($i, $keta, 0);
		$num = substr_replace($num, $i, $keta-1, 1);
		echo $num . PHP_EOL;
		$kaibun_count++;

		// ２桁以上の場合は回文を維持したまま内部の桁をインクリメントしていく
		if($keta > 2){
			display(1, $keta-2, $num);
		}
	}
}

echo '回文個数：' . $kaibun_count . PHP_EOL;
echo 'ループ回数：' . $roop_count . PHP_EOL;

function display($first, $second, $num){
	global $roop_count;
	global $kaibun_count;

	$display_num = $num;
	for($j = 1; $j <= 9; $j++){
		$roop_count++;

		if($second - $first > 1){
			display($first + 1, $second -1, $display_num);
		}

		$first_num = str_pad(1, strlen($display_num) - $first, 0);
		$second_num = 0;
		if($first != $second){
			$second_num = str_pad(1, strlen($display_num) - $second, 0);
		}
		
		$display_num = $display_num + $first_num + $second_num;
		echo $display_num . PHP_EOL;
		$kaibun_count++;

		if($j==9 && $second - $first > 1){
			display($first + 1, $second -1, $display_num);
		}
	}
}