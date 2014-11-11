<?php
/**
 * @Project NUKEVIET 3.4
 * @Author Nguyễn Thanh Hoàng  (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2014 webvang.vn All rights reserved
 * @Createdate 08/10/2014
 */
 
if (! defined ( 'NV_IS_FILE_ADMIN' ))
	die ( 'Stop!!!' );
$page_title = $lang_module ['config_title'];

if ($nv_Request->isset_request ( 'do', 'post' )) {
	$contents .= "<div class=\"quote\" style=\"width:780px;\">\n";
    $contents .= "<blockquote class=\"error\"><span>" . $lang_module['add_cf_success'] . "</span></blockquote>\n";
    $contents .= "</div>\n";
    $contents .= "<div class=\"clear\"></div>\n";
}else{
$error='';

$xtpl=new XTemplate("config.tpl",NV_ROOTDIR."/themes/".$global_config['module_theme']."/modules/".$module_file);
$xtpl->assign('LANG',$lang_module);
$xtpl->assign('GLANG',$lang_global);
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
if(empty($alias))$xtpl->parse('main.get_alias');
if($error){
$xtpl->assign('ERROR',$error);
$xtpl->parse('main.error');
}
$xtpl->parse('main');
$contents=$xtpl->text('main');
}
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme ( $contents );
include (NV_ROOTDIR . "/includes/footer.php");
?>
