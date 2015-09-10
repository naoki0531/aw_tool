<?php
class Create
{
	public function validation()
	{
		$result = array();
		if(isset($_GET['seed']) === true && is_numeric($_GET['seed']) === true){
			$result['seed'] = true;
		} else {
			$result['seed'] = false;
		}

		if(isset($_GET['date']) === true && $_GET['date'] === date('Ymd', strtotime($_GET['date']))){
			$result['date'] = true;
		} else {
			$result['date'] = false;
		}

		return $result;
	}

	public function getBaesDate($date)
	{
		// 1順する開始日付と終了日付を取得
		$count = count(define::$staff);
		$count = $count*7;
		$default_base_date = define::BASE_DATE;
		$default_end_date = date('Ymd', strtotime('+'.($count -7).' day', strtotime($default_base_date)));

		// 基準日が含まれている期間を探す
		while ($default_end_date <= $date) {
			$default_base_date = $default_end_date + 7;
			$default_end_date = date('Ymd', strtotime('+'.$count.' day', strtotime($default_base_date)));
		}

		return $default_base_date;
	}

	public function execute($seed, $date)
	{
		// 定例配列を作成
		$speech_pool = $this->getSpeechPool();
		$rotation_list = array();
		foreach(define::$staff as $num => $name){
			// シード値を設定
			mt_srand($seed + $date);

			// 司会を設定
			$rotation_list['moderator'][$date] = $name;

			// スピーチ人数を設定
			$speech_count = define::SPEECH_COUNT;
			for($i = 0; $i<$speech_count; $i++){
				// スピーチする人がいなくなったら再度格納する
				if(count($speech_pool) == 0){
					$speech_pool = $this->getSpeechPool();
				}

				// 表示終了の2回前、または司会の2倍の人数が格納できる最後の配列の時、次の司会者を優先的に格納する
				$next_moderator_key = false;
				if(count($speech_pool) == define::SPEECH_COUNT * 2){
					$next_moderator_key = array_search($num + 1, $speech_pool);
				}

				// 次の司会者またはランダムでスピーチする人を格納する
				if($next_moderator_key !== false){
					$speech_num = $next_moderator_key;
					$next_moderator_key = false;
				}else{
					//　今回の司会者以外が選ばれるまでループする
					while(true){
						$rand_length = count($speech_pool) - 1;
						$speech_num = mt_rand(0, $rand_length);

						// ランダムで選ばれた人が司会者でなければ決定
						if($speech_pool[$speech_num] != $num){
							break;
						}
					}
				}

				$rotation_list['speech'][$date][] = $speech_pool[$speech_num];
				unset($speech_pool[$speech_num]);
				$speech_pool = array_merge($speech_pool);
			}
			$date = date('Ymd', strtotime('+7 day', strtotime($date)));
		}

		$speech_name = array();
		foreach ($rotation_list['speech'] as $key => $speech_list) {
			foreach ($speech_list as $speech_num => $staff_num) {
				$speech_name[$key][$speech_num] = define::$staff[$staff_num];
			}
		}
		$rotation_list['speech'] = $speech_name;

		return $rotation_list;
	}

	public function getSpeechPool()
	{
		$speech_pool = array();
		foreach(define::$staff as $num => $name){
			$speech_pool[] = $num;
		}
		return $speech_pool;
	}
}