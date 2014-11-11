<?php
/**
 * @Project NUKEVIET 3.4
 * @Author Nguyễn Thanh Hoàng  (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2014 webvang.vn All rights reserved
 * @Createdate 08/10/2014
 */
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$page_title = $lang_module['quanli_ds'];
	$lopid = $nv_Request->get_int ( 'lopid', 'post,get' );
	$manamhoc = $nv_Request->get_int ( 'manamhoc', 'post,get' );
	
	// Hien thi hop lua chon
	$contents .= "<div>";
    $contents .= "<form name=\"deltkb\" action=\"\" method=\"post\">";
    $contents .= "<table summary=\"\" class=\"tab1\">\n";
    $contents .= "<td>";
    $contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['quanli_td'] . "</font></b></center>";
    $contents .= "</td>\n";
    $contents .= "</table>";
	$contents .= "</form>";
    $contents .= "</div>";
		// Chon lop
		$contents .= "<form name=\"chon_ds\" action=\"index.php?".NV_NAME_VARIABLE . "=" . $module_name."\" method=\"post\">";
		$contents .= "<table summary=\"\" class=\"tab1\">\n";
		$contents .= "<td align = \"center\">";
		$contents .= "<select name = \"lopid\">";
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn lớp</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_lop`";
		$result = $db->sql_query( $sql);
		$dslh=array();
		while ($dslop = $db->sql_fetchrow($result))
		{
			if ($lopid == $dslop[0]){
				$tenlop = $dslop[1];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= "<option value=\"$dslop[0]\" ". $sel .">&nbsp;$dslop[1]</option>";
			$dslh[$dslop[0]] = array($dslop[0],$dslop[1]);
		}
		$contents .= "</select>&nbsp;&nbsp;";
		// Chon nam hoc
		$contents .= "<select name = \"manamhoc\">";
		$contents .= "<option value=\"0\" size = \"50\">&nbsp;Chọn năm học</option>";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_namhoc`";
		$result = $db->sql_query( $sql);
		$dsnh=array();
		while ($namhoc = $db->sql_fetchrow($result))
		{
			if ($manamhoc == $namhoc[0]){
				$tennamhoc = $namhoc[1];
				$sel = "selected";
			} else {
				$sel = "";
			}
			$contents .= "<option value=\"$namhoc[0]\" ".$sel.">&nbsp;$namhoc[1]</option>";
			$dsnh[$namhoc[0]] = array($namhoc[0],$namhoc[1]);
		}
		$contents .= "</select>";
		
		$contents .= "&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value = \"" . $lang_module['thuchien'] . "\" /></center>";
		$contents .= "</td>\n";
		$contents .= "</table>";
		$contents .= "</form>";
		// Het hop lua chon
		$contents .= "<div>";
	    $contents .= "<form>";
	    $contents .= "<table summary=\"\" class=\"tab1\">\n";
	    $contents .= "<td>";
		if($lopid <> 0 AND $manamhoc <> 0 ) {
			$contents .= "<center><b><font color=blue size=\"3\">" . $lang_module['dshs_td'] . "".$tenlop." <br />" . $lang_module['namhoc_td'] ."".$tennamhoc."</font></b></center>";
		} else {
			$contents .= "<center><b><font color=blue size=\"3\">Danh sách học sinh toàn trường</font></b></center>";
		}
	    $contents .= "</td>\n";
	    $contents .= "</table>";
		$contents .= "</form>";
	    $contents .= "</div>";
		$query = "id > 0";
		if ($lopid <> 0) {$query .= " AND `lopid`=".$lopid;}
		if ($manamhoc <> 0) {$query .= " AND `manamhoc`=".$manamhoc;}
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_dshs` WHERE ".$query." ORDER BY `manamhoc` ASC, `lopid` ASC, `name` ASC";
		
		$result = $db->sql_query( $sql);
		$contents .= "<table class=\"tab1\">\n";
		$contents .= "<thead>\n";
		$contents .= "<tr>\n";
		$contents .= "<td align='center'>" . $lang_module ['stt'] . "</td>\n";
		$contents .= "<td align='center'> Niên khóa</td>\n";
		$contents .= "<td align='center'>Lớp</td>\n";
		$contents .= "<td align='center'>" . $lang_module ['mahs'] . "</td>\n";
		$contents .= "<td align='center'>Mã số HS (Sở giáo dục)</td>\n";
		$contents .= "<td align='center' colspan='2'>" . $lang_module ['hoten'] . "</td>\n";
		$contents .= "<td align='center'>" . $lang_module ['gtinh'] . "</td>\n";
		$contents .= "<td align='center'>" . $lang_module ['ngsinh'] . "</td>\n";
		$contents .= "<td align='center'>" . $lang_module ['noisinh'] . "</td>\n";
		
		$contents .= "<td align='center'>" . $lang_module ['quanli'] . "</td>\n";
		
		$contents .= "</tr>\n";
		$contents .= "</thead>\n";
		$gtinh = array('F' => 'Nữ', 'M' => 'Nam');
		$a = 0;
		while ($dshs = $db->sql_fetchrow($result))
		{
			$class = ($a % 2) ? " class=\"second\"" : "";
			$contents .= "<tbody" . $class . ">\n";
			$contents .= "<tr>\n";
			$contents .= "<td align=\"center\">" . ++$a . "</td>\n";
			$contents .= "<td align=\"left\">" . $dsnh[$dshs ['manamhoc']][1] . "</td>\n";
			$contents .= "<td align=\"left\">" . $dslh[$dshs ['lopid']][1] . "</td>\n";
			$contents .= "<td align=\"center\">" .$dshs ['mahs']." </td>\n";
			$contents .= "<td align=\"center\">" .$dshs ['mshsgd']." </td>\n";
			$contents .= "<td align=\"left\">" . $dshs ['ho']."</td>\n";
			$contents .= "<td align=\"left\">" . $dshs ['name']."</td>\n";
			$contents .= "<td align=\"center\">" . $gtinh[$dshs ['phai']]."</td>\n";
			$contents .= "<td align=\"center\">" . date('d/m/Y',$dshs ['ngaysinh'])."</td>\n";
			$contents .= "<td align=\"left\">" . $dshs ['noisinh']."</td>\n";
			$contents .= "<td align=\"center\">";
			
				$contents .= "<span class=\"edit_icon\"><a class='edit' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addhs&amp;id=" . $dshs ['id'] . "\">" . $lang_global ['edit'] . "</a></span>\n";
			
			$contents .= "&nbsp;-&nbsp;<span class=\"delete_icon\"><a class='del' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=delhs&amp;id=" . $dshs ['id'] . "\">" . $lang_global ['delete'] . "</a></span></td>\n";
			$contents .= "</tr>\n";
			$contents .= "</tbody>\n";
		}
		if ($lopid <> 0 AND  $manamhoc <> 0 ) {
			$contents .= "<tfoot><tr><td colspan='10'><span class=\"add_icon\"><a class='add' href=\"index.php?" . NV_NAME_VARIABLE . "=" . $module_data . "&" . NV_OP_VARIABLE . "=addhs&amp;lopid=" . $lopid . "&amp;manamhoc=" . $manamhoc . "\">" . $lang_global ['add'] . "</a></span></td></tr></tfoot>";
		}
	$contents .= "</table>\n";
	$my_head = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/popcalendar/popcalendar.js\"></script>\n";
	// Het hien thi danh sach
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
		if (confirm('".$lang_module['delhs_del_confirm']."')){
			$.ajax({	
				type: 'POST',
				url: href,
				data: '',
				success: function(data){				
					alert(data);
					window.location='index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "';
				}
			});
		}
	});
	});
	</script>
	";

	
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>