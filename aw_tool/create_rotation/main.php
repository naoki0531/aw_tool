<?php
require_once('create.php');
require_once('define.php');
class Rotation
{
	public function execute()
	{
		$seed = 123;
		$date = 20150903;
		$create = new Create();
		$rotation_list = $create->execute($seed, $date);

		echo '<table style="border: solid 1px;border-collapse: collapse;"><tablebody>';
		echo '<tr>';
		echo '<th style="border: solid 1px;border-collapse: collapse;">日付</th>';
		foreach ($rotation_list['moderator'] as $key => $value) {
			echo '<th style="border: solid 1px;border-collapse: collapse;" colspan="2">' . date($key) . '</th>';
		}
		echo '</tr><tr>';
		echo '<td style="border: solid 1px;border-collapse: collapse;">司会</td>';
		foreach ($rotation_list['moderator'] as $key => $value) {
			echo '<td style="border: solid 1px;border-collapse: collapse;" colspan="2">' . $value . '</td>';
		} 
		echo '</tr><tr>';
		echo '<td style="border: solid 1px;border-collapse: collapse;">スピーチ</td>';
		foreach ($rotation_list['speech'] as $key => $value) {
			
			foreach ($value as $name) {
				echo '<td style="border: solid 1px;border-collapse: collapse;">';
				echo $name;
				echo '</td>';
			}
			
		} 
		echo '</tablebody></table>';

		echo '<h3>シード値：' . $seed . '</h3>';
	}
}