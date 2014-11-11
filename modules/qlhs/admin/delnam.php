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
// Kiem tra su ton tai cua manamhoc tai cac table lien quan, neu co se khong xoa
$sql ="SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_diem` WHERE  `manamhoc`='".$id."'";
$result = $db->sql_query( $sql);
$num1 = mysql_num_rows($result);

$sql ="SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE  `manamhoc`='".$id."'";
$result = $db->sql_query( $sql);
$num2 = mysql_num_rows($result);

$sql ="SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_xeploai` WHERE  `manamhoc`='".$id."'";
$result = $db->sql_query( $sql);
$num3 = mysql_num_rows($result);

if ($num1 == 0 and $num3 == 0 and $num3 == 0){
$db->sql_query ( "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc` WHERE manamhoc=$id" );
echo $lang_module ['delnamhoc_del_success'];
}else{
echo $lang_module ['delnamhoc_del_unsuccess'];
}
?>