<?php
/**
 * @Project NUKEVIET 3.4
 * @Author Nguyễn Thanh Hoàng  (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2014 webvang.vn All rights reserved
 * @Createdate 08/10/2014
 */

if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );
include (NV_ROOTDIR . "/includes/class/geturl.class.php");
$data = file_get_contents ( NV_ROOTDIR . '/modules/checkpoint/config.txt' );
$ex = explode ( '|', $data );
$id = $nv_Request->get_int ( 'id', 'get,post' );
if ($nv_Request->get_int ( 'save', 'post' )) {
	$gvid = filter_text_input ( 'gvid', 'post', '', 1 );
	// Loc danh sach giao vien
	$sqlgv = "SELECT `userid`, `username`, `full_name` FROM `" .NV_USERS_GLOBALTABLE. "` WHERE `userid` = ".$gvid." ORDER BY `userid` ASC";
	$resultgv = $db->sql_query( $sqlgv);
	while ( $dsgv = $db->sql_fetchrow ( $resultgv ) ) {
		$tengv = $dsgv[2];
		$user = $dsgv[0];	
	}


	$chunhiem = $nv_Request->get_int( 'chunhiem', 'post', 0 );
	$active = $nv_Request->get_int( 'active', 'post', 0 );
	
	if (! empty ( $id )) {
		$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` SET `tengv`=" . $db->dbescape ( $tengv ). ",`user`=" . $db->dbescape ( $user ). ",`chunhiem`=" . $db->dbescape ( $chunhiem ). ",`active`=" . $db->dbescape ( $active ). " WHERE gvid=" . $id . "" );
		//$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` SET `tengv`=" . $db->dbescape ( $tengv ). ",`user`=" . $db->dbescape ( $user ). ",`chunhiem`=" . $db->dbescape ( $chunhiem ) . ",`active`=" . $db->dbescape ( $active ) . " WHERE gvid=" . $id . "" );
		if ($result) {
			echo $lang_module ['addgv_update_success'];
		} else {
			
			print_r ( $db->sql_error () );
		}
	} else {
		$alreadygvid = $db->sql_numrows ( $db->sql_query ( "SELECT gvid FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` WHERE gvid = " . $db->dbescape ( $gvid ) . "" ) );
		if (! $alreadygvid) {
			$result = $db->sql_query ( "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` (`gvid`,`tengv`,`user`,`chunhiem`,`active`)VALUES (" . $db->dbescape ( $gvid ) . ", " . $db->dbescape ( $tengv ) . ", " . $db->dbescape ( $user ) . ", " . $db->dbescape ( $chunhiem ) . ", " . $db->dbescape ( $active ) . ")" );
			//$result = $db->sql_query ( "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` (`gvid`,`tengv`,`user`,`chunhiem`,`active`)VALUES (" . $db->dbescape ( $gvid ) . ", " . $db->dbescape ( $tengv ) . ", " . $db->dbescape ( $user ) . ", " . $db->dbescape ( $chunhiem ) . ", " . $db->dbescape ( $active ) . ")" );
			
			if ($result) {
				echo $lang_module ['addgv_success'];
			} else {
				print_r ( $db->sql_error () );
			}
		} else {
			echo '
	<script type="text/javascript">
		alert("' . $lang_module ['addgv_error_code_exist'] . '");
	</script>
		';
		}
	}
} else {
	if (! empty ( $id )) {
		$row = $db->sql_fetchrow ( $db->sql_query ( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` WHERE gvid='$id'" ) );
		$dis = ! empty ( $id )?'disabled':'';
	} else {
		$row ['gvid'] = $row ['tengv'] ='';
	}
	$ch_cn = ($row['chunhiem'] == 1?'checked':'');
	if(empty($id)){
		$ch_kh = 'checked';
	}else{
		$ch_kh = ($row['active'] == 1?'checked':'');
	}
	$contents .= "<table class=\"tab1\" style='width:400px'>\n";
	$contents .= "<thead>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan=\"2\">" . $lang_module ['addgv_title'] . "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</thead>\n";
	/*
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['magv'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['gvid'] . "' name='gvid' style='width:150px' ".$dis.">";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	*/
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'> Tài khoản của giáo viên </td>\n";
	$contents .= "<td>";
	$contents .= "<select name='gvid' id = 'gvid'>";
	if (! empty ( $id )) {
		$sqlgv = "SELECT `userid`, `username`, `full_name` FROM `" .NV_USERS_GLOBALTABLE. "` WHERE `in_groups` LIKE  '%".$ex [2]."%' ORDER BY `userid` ASC";
	} else {
	//danh sach gv da add
	$sql = "SELECT gvid FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` ORDER BY `gvid` ASC";

	$resultgv = $db->sql_query( $sql);
	$listgv = '0,';
	while ( $lgv = $db->sql_fetchrow ( $resultgv ) ) {
		$listgv .=$lgv[0].',';
	}
	$listgv = substr($listgv,0,-1);
	// Loc danh sach giao vien
	$sqlgv = "SELECT `userid`, `username`, `full_name` FROM `" .NV_USERS_GLOBALTABLE. "` WHERE `userid` NOT 
IN ( ".$listgv." ) AND `in_groups` LIKE  '%".$ex [2]."%' ORDER BY `userid` ASC";
	}
	
	$resultgv = $db->sql_query( $sqlgv);
    $contents .= "<option value=\"0\" size = \"30\">&nbsp;Chọn tài khoản của giáo viên </option>";
		while ( $dsgv = $db->sql_fetchrow ( $resultgv ) ) {
	       	$selkh =(($dsgv[0] == $row ['user'])?'selected':'');
			$contents .= "<option value = \"$dsgv[0]\" ". $selkh .">&nbsp;". $dsgv[1]." - ".$dsgv[2] ."&nbsp;</option>";
		}
	$contents .= "</select>";
	/*$contents .= "<input type='text' value='" . $row ['tengv'] . "' name='tengv' style='width:250px'>";*/
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	/*
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['user'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['user'] . "' name='user' style='width:250px'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	*/
	$contents .= "</tbody>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['cn'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type=\"checkbox\" name=\"chunhiem\" id=\"chunhiem\" value=\"1\" ". $ch_cn ."/>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['active'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type=\"checkbox\" name=\"active\" id=\"active\" value=\"1\" ". $ch_kh ."/>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan='2' style='padding-left:100px'>";
	$contents .= "<span name='notice' style='float:right;padding-right:50px;color:red;font-weight:bold'></span>";
	$contents .= "<input type='button' name='confirm' value='" . $lang_module ['thuchien'] . "'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "</table>\n";
	$contents .= "
<script type='text/javascript'>
$(function(){
$('input[name=\"confirm\"]').click(function(){
	var gvid = $('#gvid').val();
	var chunhiem = $('#chunhiem:checked').val();
	var active = $('#active:checked').val();
	$('span[name=\"notice\"]').html('<img src=\"../images/load.gif\"> Xin đợi một lát ...');
	$.ajax({	
		type: 'POST',
		url: 'index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=addgv',
		data: 'gvid='+ gvid  +'&chunhiem='+ chunhiem + '&active='+ active +'&save=1" . (! empty ( $id ) ? '&id=' . $id . '' : '') . "',
		success: function(data){
			$('input[name=\"confirm\"]').removeAttr('disabled');
			$('span[name=\"notice\"]').html(data);
			window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_dsgv';
		}
	});
});
});
</script>
";
}

//window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_dsgv';
echo $contents;
?>