<?php
class Create
{
	public function execute()
	{
		mt_srand(123 + 20150903);
		$rotation_list = array();
		$speech_pool = $this->getSpeechPool();

		foreach(define::$staff as $num => $name){
			$rotation_list['moderator'][] = $name;
			if(count($speech_pool) == 0){
				$speech_pool = $this->getSpeechPool();
			}

			$moderator_key = array_search($num, $speech_pool);
			if($moderator_key !== false){
				unset($speech_pool[$moderator_key]);
				$speech_pool = array_merge($speech_pool);
			}

			$speech_count = define::SPEECH_COUNT;

			$next_moderator_key = false;
			if(count($speech_pool) == define::SPEECH_COUNT * 2){
				$next_moderator_key = array_search($num + 1, $speech_pool);
				if($next_moderator_key !== false){
					$rotation_list['speech'][$num][] = $speech_pool[$next_moderator_key];
					$speech_count--;
					unset($speech_pool[$next_moderator_key]);
					$speech_pool = array_merge($speech_pool);
				}
			}

			for($i = 0; $i<$speech_count; $i++){
				$rand_length = count($speech_pool) - 1;
				$speech_num = mt_rand(0, $rand_length);
				$rotation_list['speech'][$num][] = $speech_pool[$speech_num];
				unset($speech_pool[$speech_num]);
				$speech_pool = array_merge($speech_pool);
			}

			if($moderator_key !== false){
				$speech_pool[] = $num;
				$speech_pool = array_merge($speech_pool);
			}
			if($next_moderator_key !== false){
				$speech_pool[] = $num + 1;
				$speech_pool = array_merge($speech_pool);
			}
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