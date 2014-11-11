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
	$lopid = filter_text_input ( 'lopid', 'post', '', 1 );
	$tenlop = filter_text_input ( 'tenlop', 'post','', 1);
	$gvid = $nv_Request->get_int ( 'gvid', 'post', 0 );
	$namid = $nv_Request->get_int ( 'namid', 'post', 0 );
	if (! empty ( $id )) {
		$result = $db->sql_query ( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_lop` SET `tenlop`=" . $db->dbescape ( $tenlop ). ",`gvid`=" . $db->dbescape ( $gvid ). ",`namid`=" . $db->dbescape ( $namid ). "  WHERE lopid=" . $id . "" );
		if ($result) {
			echo $lang_module ['addlop_update_success'];
		} else {
			print_r ( $db->sql_error () );
		}
	} else {
		$alreadylopid = $db->sql_numrows ( $db->sql_query ( "SELECT lopid FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop` WHERE lopid = " . $db->dbescape ( $lopid ) . "" ) );
		if (! $alreadylopid) {
			$result = $db->sql_query ( "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_lop` (`lopid`, `tenlop`,`namid`,`gvid`) VALUES (" . $db->dbescape ( $lopid ) . ", " . $db->dbescape ( $tenlop ) .", " . $db->dbescape ( $namid ). ", " . $db->dbescape ( $gvid ) . ")" );
			if ($result) {
				echo $lang_module ['addlop_success'];
			} else {
				print_r ( $db->sql_error () );
			}
		} else {
			echo '
	<script type="text/javascript">
		alert("' . $lang_module ['addlop_error_code_exist'] . '");
	</script>
		';
		}
	}
} else {
	if (! empty ( $id )) {
		$row = $db->sql_fetchrow ( $db->sql_query ( "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop` WHERE lopid='$id'" ) );
		$dis = ! empty ( $id )?'disabled':'';
	} else {
		$row ['lopid'] = $row ['tenlop'] ='';
	}
	$contents .= "<table class=\"tab1\" style='width:400px'>\n";
	$contents .= "<thead>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan=\"2\">" . $lang_module ['addlop_title'] . "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</thead>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['lopid'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['lopid'] . "' name='lopid' style='width:150px' ".$dis.">";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['tenlop'] . "</td>\n";
	$contents .= "<td>";
	$contents .= "<input type='text' value='" . $row ['tenlop'] . "' name='tenlop' style='width:250px'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" .  $lang_module ['manam'] . "</td>\n";
	$contents .= "<td><select name='namid' id = 'namid'>";
	// Loc danh sach giao vien
	$sqlnh = "SELECT `manamhoc`,`tennamhoc` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc`  ORDER BY `manamhoc` ASC";
	$resultnh = $db->sql_query( $sqlnh);
    $contents .= "<option value=\"0\" size = \"30\">&nbsp;Chọn niên khóa</option>";
		while ( $dsnh = $db->sql_fetchrow ( $resultnh ) ) {
	       	$selkh =(($dsnh[0] == $row['namid'])?'selected':'');
			$contents .= "<option value = \"$dsnh[0]\" ". $selkh .">&nbsp;". $dsnh[1] ."&nbsp;</option>";
		}
	$contents .= "</select></td>\n";
	$contents .= "</tr>\n";
	$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td style='width:150px'>" . $lang_module ['gvcn'] . "</td>\n";
	$contents .= "<td><select name='gvid' id = 'gvid'>";
	// Loc danh sach giao vien
	$sqlgv = "SELECT `gvid`,`tengv` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` WHERE `chunhiem`=1 ORDER BY `gvid` ASC";
	$resultgv = $db->sql_query( $sqlgv);
    $contents .= "<option value=\"0\" size = \"30\">&nbsp;Chọn giáo viên chủ nhiệm</option>";
		while ( $dsgv = $db->sql_fetchrow ( $resultgv ) ) {
	       	$selkh =(($dsgv[0] == $row['gvid'])?'selected':'');
			$contents .= "<option value = \"$dsgv[0]\" ". $selkh .">&nbsp;". $dsgv[1] ."&nbsp;</option>";
		}
	$contents .= "</select></td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	
	//$contents .= "<tbody class='second'>\n";
	$contents .= "<tr>\n";
	$contents .= "<td colspan='2' style='padding-left:100px'>";
	$contents .= "<span name='notice' style='float:right;padding-right:50px;color:red;font-weight:bold'></span>";
	$contents .= "<input type='button' name='confirm' value='" . $lang_module ['thuchien'] . "'>";
	$contents .= "</td>\n";
	$contents .= "</tr>\n";
	//$contents .= "</tbody>\n";
	
	$contents .= "</table>\n";
	$contents .= "
<script type='text/javascript'>
$(function(){
$('input[name=\"confirm\"]').click(function(){
	var lopid = $('input[name=\"lopid\"]').val();
	if (lopid==''){
		alert('" . $lang_module ['addlop_error_code'] . "');
		$('input[name=\"lopid\"]').focus();
		return false;
	}
	var namid = $('#namid').val();
	if (namid==''){
		alert('Vui lòng chọn niên khóa');
		$('input[name=\"lopid\"]').focus();
		return false;
	}
	var tenlop = $('input[name=\"tenlop\"]').val();
	if (tenlop==''){
		alert('" . $lang_module ['addlop_error_name'] . "');
		$('input[name=\"tenlop\"]').focus();
		return false;
	}
	var gvid = $('#gvid').val();

	$('span[name=\"notice\"]').html('<img src=\"../images/load.gif\"> please wait...');
	$.ajax({	
		type: 'POST',
		url: 'index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=addlop',
		data: 'lopid='+ lopid + '&tenlop='+tenlop + '&namid='+namid + '&gvid='+gvid+ '&save=1" . (! empty ( $id ) ? '&id=' . $id . '' : '') . "',
		success: function(data){				
			$('input[name=\"confirm\"]').removeAttr('disabled');
			$('span[name=\"notice\"]').html(data);
			window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_lop';
		}
	});
});
});
</script>
";
}
echo $contents;
?>