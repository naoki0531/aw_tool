<?php
class Create
{
	public function execute($seed, $date)
	{
		mt_srand($seed + $date);
		$rotation_list = array();
		$speech_pool = $this->getSpeechPool();

		foreach(define::$staff as $num => $name){
			mt_srand($seed + $date);

			$rotation_list['moderator'][$date] = $name;
			if(count($speech_pool) == 0){
				$speech_pool = $this->getSpeechPool();
			}
			$speech_count = define::SPEECH_COUNT;

			$next_moderator_key = false;
			if(count($speech_pool) == define::SPEECH_COUNT * 2){
				$next_moderator_key = array_search($num + 1, $speech_pool);
				if($next_moderator_key !== false){
					$rotation_list['speech'][$date][] = $speech_pool[$next_moderator_key];
					$speech_count--;
					unset($speech_pool[$next_moderator_key]);
					$speech_pool = array_merge($speech_pool);
				}
			}

			for($i = 0; $i<$speech_count; $i++){
				$rand_length = count($speech_pool) - 1;
				$speech_num = mt_rand(0, $rand_length);
				
				if($speech_pool[$speech_num] == $num){
					$i--;
					continue;
				}

				$rotation_list['speech'][$date][] = $speech_pool[$speech_num];
				unset($speech_pool[$speech_num]);
				$speech_pool = array_merge($speech_pool);
			}

			if($next_moderator_key !== false){
				$speech_pool[] = $num + 1;
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