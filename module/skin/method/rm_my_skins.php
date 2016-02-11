<?php

$ids = [];
$ids_raw = explode(',', IO::I('ids'));

foreach ($ids_raw as $id) {
	$id = intval($id);
	if($id > 0){
		$ids[] = $id;
	}else{
		IO::E('ID有误');
	}
}

if(count($ids) > 0){
	$ids = implode(',', $ids);
}else{
	IO::E('ID不能为空');
}

IO::O([
	'result' => Skin::remove_mine($ids)
]);