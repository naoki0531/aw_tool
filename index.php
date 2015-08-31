<?php
try{

require_once('aw_tool/create_rotation/main.php');
$tool = new Rotation();
$tool->execute();
}catch(Exception $e){
	echo "tete";
	var_dump($e->getMessage());
};