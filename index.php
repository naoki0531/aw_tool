<?php
require_once('aw_tool/create_rotation/create.php');
require_once('aw_tool/create_rotation/define.php');

$tool = new Create();
$result = $tool->validation();

if($result['date'] === true){
	$date = $_GET['date'];
} else {
	$date = define::BASE_DATE;
}

if($result['seed'] === true){
	$seed = $_GET['seed'];
} else {
	$seed = define::BASE_SEED;
}

$base_date = $tool->getBaesDate($date);
$rotation_list = $tool->execute($seed, $base_date);
?>
<link rel="stylesheet" href="./css/mdl/material.min.css">
<script src="./css/mdl/material.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
日付<input class="mdl-input"type="text" name="date" value="<?php echo $date;?>">
<br>
<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit">変更</button>
</form>
