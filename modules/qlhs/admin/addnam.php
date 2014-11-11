<?php
/**
 * @Project NUKEVIET 3.4
 * @Author Nguyễn Thanh Hoàng  (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2014 webvang.vn All rights reserved
 * @Createdate 08/10/2014
 */

if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );

$id = $nv_Request->get_int ( 'id', 'get,post' );

if ($nv_Request->get_int ( 'save', 'post' )) {
	$code = filter_text_input ( 'code', 'post', '', 1 );
	$name = filter_text_input ( 'name', 'post', '', 1 );
	if (! empty ( $id )) {
		$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc` SET `tennamhoc`=" . $db->dbescape ( $name ) . " WHERE manamhoc=" . $id . "" );
		if ($result) {
			echo $lang_module ['addnam_update_success'];
		} else {
			print_r ( $db->sql_error () );
		}
	} else {
		$alreadycode = $db->sql_numrows ( $db->sql_query ( "SELECT manamhoc FROM `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc` WHERE manamhoc = " . $db->dbescape ( $code ) . "" ) );
		if (! $alreadycode) {
			$result = $db->sql_query ( "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc` VALUES (" . $db->dbescape ( $code ) . "," . $db->dbescape ( $name ) . ")" );
			if ($result) {
				echo $lang_module ['addnam_success'];
			} else {
				print_r ( $db->sql_error () );
			}
		} else {
			echo '
	<script type="text/javascript">
		alert("' . $lang_module ['addnam_error_code_exist'] . '");
	</script>
		';
		}
	}
} else {
	if (! empty ( $id )) {
		$row = $db->sql_fetchrow ( $db->sql_query ( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc` WHERE manamhoc='$id'" ) );
		$dis = ! empty ( $id )?'disabled':'';
	} else {
		$row ['code'] = $row ['tennamhoc'] ='';
	}
	$contents .= "<table class=\"tab1\" style='width:400px'>\n";
	$contents .= "<thead>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan=\"2\">" . $lang_module ['addnam_title'] . "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</thead>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['manam'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['manamhoc'] . "' name='code' style='width:150px' ".$dis.">";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['tennamhoc'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['tennamhoc'] . "' name='name' style='width:250px'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan='2' align = 'center'>";
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
	var code = $('input[name=\"code\"]').val();
	if (code==''){
		alert('" . $lang_module ['addname_error_code'] . "');
		$('input[name=\"code\"]').focus();
		return false;
	}
	var name = $('input[name=\"name\"]').val();
	if (name==''){
		alert('" . $lang_module ['addname_error_name'] . "');
		$('input[name=\"name\"]').focus();
		return false;
	}
	$('span[name=\"notice\"]').html('<img src=\"../images/load.gif\"> please wait...');
	$.ajax({	
		type: 'POST',
		url: 'index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=addnam',
		data: 'code='+ code + '&name='+name+'&save=1" . (! empty ( $id ) ? '&id=' . $id . '' : '') . "',
		success: function(data){				
			$('input[name=\"confirm\"]').removeAttr('disabled');
			$('span[name=\"notice\"]').html(data);
			window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=quanli_nam';
		}
	});
});
});
</script>
";
}
echo $contents;
?>