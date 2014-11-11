<?php
/**
 * @Project NUKEVIET 3.4
 * @Author Nguyễn Thanh Hoàng  (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2014 webvang.vn All rights reserved
 * @Createdate 08/10/2014
 */

if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );
$page_title = $lang_module ['quanli_dsgv'];
// Hien thi tieu de
$contents .= "<div>";
$contents .= "<form name=\"deltkb\" action=\"\" method=\"post\">";
$contents .= "<table summary=\"\" class=\"tab1\">\n";
$contents .= "<td>";
$contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['quanli_dsgv_td'] . "</font></b></center>";
$contents .= "</td>\n";
$contents .= "</table>";
$contents .= "</form>";
$contents .= "</div>";

$contents .= "<table class=\"tab1\">\n";
$contents .= "<thead>\n";
$contents .= "<tr>\n";
$contents .= "<td align='center'>" . $lang_module ['stt'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['gvid'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['tengv'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['user'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['cn'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['active'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['quanli'] . "</td>\n";
$contents .= "</tr>\n";
$contents .= "</thead>\n";

$page = $nv_Request->get_int ( 'page', 'get', 0 );
$per_page = 20;
$base_url = NV_BASE_ADMINURL.'index.php?'.NV_NAME_VARIABLE.'='.$module_name.'&amp;'. NV_OP_VARIABLE .'=quanli_dsgv';
$all_page = $db->sql_numrows ( $db->sql_query ( "SELECT gvid FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv`" ) );
$a = 0;
$sql = "SELECT *  FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dsgv` ORDER BY `gvid` ASC LIMIT $page,$per_page";
$result = $db->sql_query ( $sql );

while ( $row = $db->sql_fetchrow ( $result ) ) {
	// Kiem tra trang thai lua chon
    $ch_cn = ($row['chunhiem'] == 1?'checked':'');
    $ch_kh = ($row['active'] == 1?'checked':'');

	$class = ($a % 2) ? " class=\"second\"" : "";
	$contents .= "<tbody" . $class . ">\n";
	$contents .= "<tr>\n";
	$contents .= "<td align=\"center\">" . ++$a . "</td>\n";
	$contents .= "<td align=\"center\">" . $row ['gvid']."</td>\n";
	$contents .= "<td align=\"left\">" . $row ['tengv']."</td>\n";
	// ten tai khoan giao vien
	$sqlgv = "SELECT `userid`, `username`, `full_name` FROM `" .NV_USERS_GLOBALTABLE. "` WHERE `userid` = ".$row ['user']." ORDER BY `userid` ASC";
	$resultgv = $db->sql_query( $sqlgv);
	while ( $dsgv = $db->sql_fetchrow ( $resultgv ) ) {
		$user = $dsgv[1];	
	}
	$contents .= "<td align=\"center\">" . $user."</td>\n";
	$contents .= "<td align=\"center\"><input type=\"checkbox\" name=\"chunhiem\" value=\"1\" ". $ch_cn ."  id=\"change_cn_" . $row['gvid'] . "\" onclick=\"nv_chang_cn(" . $row['gvid'] . ");\" /></td>\n";
	$contents .= "<td align=\"center\"><input type=\"checkbox\" name=\"active\" value=\"1\" ". $ch_kh ."  id=\"change_kh_" . $row['gvid'] . "\" onclick=\"nv_chang_kh(" . $row['gvid'] . ");\" /></td>\n";
	$contents .= "<td align=\"center\" width = \"20%\">";
	$contents .= "<span class=\"edit_icon\"><a class='edit' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addgv&amp;id=" . $row ['gvid'] . "\">" . $lang_global ['edit'] . "</a></span>\n";
	$contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a class='del' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=delgv&amp;id=" . $row ['gvid'] . "\">" . $lang_global ['delete'] . "</a></span></td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	//$a ++;
}
$contents .= "<tfoot><tr><td colspan='7'><span class=\"add_icon\"><a class='add' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addgv\">" . $lang_global ['add'] . "</a></span>&nbsp;&nbsp;</td></tr></tfoot>";
$contents .= "</table>\n";
//$my_head = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/popcalendar/popcalendar.js\"></script>\n";

$generate_page = nv_generate_page ( $base_url, $all_page, $per_page, $page );
if (! empty ( $generate_page ))
	$contents .= "<br><p align=\"center\">" . $generate_page . "</p>\n";
$contents .= "<div id='contentedit'></div><input id='hasfocus' style='width:0px;height:0px'/>";
$contents .= "
<script type='text/javascript'>
$(function(){
$('a[class=\"add\"]').click(function(event){
	event.preventDefault();
	var href= $(this).attr('href');
	$('#contentedit').load(href,function(){
		$('#hasfocus').focus();
	});

});
$('a[class=\"edit\"]').click(function(event){
	event.preventDefault();
	var href= $(this).attr('href');
	$('#contentedit').load(href,function(){
		$('#hasfocus').focus();
	});
});

$('a[class=\"del\"]').click(function(event){
	event.preventDefault();
	var href= $(this).attr('href');
	if (confirm('".$lang_module['delgv_del_confirm']."')){
		$.ajax({	
			type: 'POST',
			url: href,
			data: '',
			success: function(data){				
				alert(data);
				window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_dsgv';
			}
		});
	}
});
});
</script>
";
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents );
include (NV_ROOTDIR . "/includes/footer.php");
?>