<?php
/**
 * @Project NUKEVIET 3.4
 * @Author Nguyễn Thanh Hoàng  (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2014 webvang.vn All rights reserved
 * @Createdate 08/10/2014
 */

if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );
$page_title = $lang_module ['quanli_mon'];
// Hien thi tieu de
$contents .= "<div>";
$contents .= "<form name=\"deltkb\" action=\"\" method=\"post\">";
$contents .= "<table summary=\"\" class=\"tab1\">\n";
$contents .= "<td>";
$contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['quanli_mon_td'] . "</font></b></center>";
$contents .= "</td>\n";
$contents .= "</table>";
$contents .= "</form>";
$contents .= "</div>";

$contents .= "<table class=\"tab1\">\n";
$contents .= "<thead>\n";
$contents .= "<tr>\n";
$contents .= "<td align='center'>" . $lang_module ['stt'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['mamon'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['tenmonhoc'] . "</td>\n";
$contents .= "<td align='center'>" . $lang_module ['quanli'] . "</td>\n";
$contents .= "</tr>\n";
$contents .= "</thead>\n";

$page = $nv_Request->get_int ( 'page', 'get', 0 );
$per_page = 20;
$base_url = NV_BASE_ADMINURL.'index.php?'.NV_NAME_VARIABLE.'='.$module_name;
$all_page = $db->sql_numrows ( $db->sql_query ( "SELECT monid FROM `" . NV_PREFIXLANG . "_" . $module_data . "_monhoc`" ) );
$a = 0;
$sql = "SELECT *  FROM `" . NV_PREFIXLANG . "_" . $module_data . "_monhoc` ORDER BY `monid` ASC LIMIT $page,$per_page";
$result = $db->sql_query ( $sql );
while ( $row = $db->sql_fetchrow ( $result ) ) {
	$class = ($a % 2) ? " class=\"second\"" : "";
	$contents .= "<tbody" . $class . ">\n";
	$contents .= "<tr>\n";
	$contents .= "<td align=\"center\">" . ++$a . "</td>\n";
	$contents .= "<td align=\"center\">" . $row ['monid']."</td>\n";
	$contents .= "<td>" . $row ['tenmon']."</td>\n";
	$contents .= "<td align=\"center\">";
	$contents .= "<span class=\"edit_icon\"><a class='edit' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addmon&amp;id=" . $row ['monid'] . "\">" . $lang_global ['edit'] . "</a></span>\n";
	$contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a class='del' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=delmon&amp;id=" . $row ['monid'] . "\">" . $lang_global ['delete'] . "</a></span></td>\n";
	$contents .= "</tr>\n";
	$contents .= "</tbody>\n";
	//$a ++;
}
$contents .= "<tfoot><tr><td colspan='6'><span class=\"add_icon\"><a class='add' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addmon\">" . $lang_global ['add'] . "</a></span></td></tr></tfoot>";
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
	if (confirm('".$lang_module['delmon_del_confirm']."')){
		$.ajax({	
			type: 'POST',
			url: href,
			data: '',
			success: function(data){				
				alert(data);
				window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&".NV_OP_VARIABLE."=quanli_mon';
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