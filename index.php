<?php
require_once('aw_tool/create_rotation/create.php');
require_once('aw_tool/create_rotation/define.php');

$seed = isset($_GET['seed']) === true ? $_GET['seed'] : 123;
$date = isset($_GET['date']) === true ? $_GET['date'] : 20150903;

$tool = new Create();
$base_date = $tool->getBaesDate($date);

$rotation_list = $tool->execute($seed, $base_date);
?>

<style type="text/css">
table, td, th{border: solid 1px;border-collapse: collapse;}
</style>

<table>
<tablebody>
<tr>
<th>日付</th>
	<?php foreach($rotation_list['moderator'] as $key => $value):?>
		<td colspan="2"><?php echo $key;?></td>
	<?php endforeach;?>
</tr>
<tr>
<th>司会</th>
	<?php foreach($rotation_list['moderator'] as $value):?>
		<td colspan="2"><?php echo $value;?></td>
	<?php endforeach;?>
</tr>
<tr>
<th>スピーチ</th>
	<?php foreach($rotation_list['speech'] as $value):?>
		<?php foreach($value as $speecher):?>
			<td><?php echo $speecher;?></td>
		<?php endforeach;?>
	<?php endforeach;?>
</tr>
</tablebody>
</table>

<br>
<form action="" method="get" accept-charset="utf-8">
シード値<input type="text" name="seed" value="<?php echo $seed;?>">
日付<input type="text" name="date" value="<?php echo $date;?>">
<br>
<button type="submit">変更</button>
</form>
