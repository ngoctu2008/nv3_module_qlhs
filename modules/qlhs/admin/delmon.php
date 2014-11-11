<?php
/**
 * @Project NUKEVIET 3.4
 * @Author Nguyễn Thanh Hoàng  (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2014 webvang.vn All rights reserved
 * @Createdate 08/10/2014
 */
 
if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );

$id = $nv_Request->get_int ( 'id', 'get' );
// Kiem tra su ton tai cua monid tai cac table lien quan, neu co se khong xoa
$sql ="SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_diem` WHERE  `monid`='".$id."'";
$result = $db->sql_query( $sql);
$num = mysql_num_rows($result);
if ($num == 0){
	$db->sql_query ( "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_monhoc` WHERE monid=$id" );
	echo $lang_module ['delmonhoc_del_success'];
}else{
	echo $lang_module ['delmonhoc_del_unsuccess'];
}

?>