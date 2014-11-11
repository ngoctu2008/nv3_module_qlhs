<?php
/**
 * @Project NUKEVIET 3.4
 * @Author Nguyễn Thanh Hoàng  (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2014 webvang.vn All rights reserved
 * @Createdate 08/10/2014
 */
if(!defined('NV_IS_FILE_ADMIN'))
{
	die('Stop!!!');
}
$page_title = $lang_module['qlhs'];

$xtpl=new XTemplate($op.".tpl",NV_ROOTDIR."/themes/".$global_config['module_theme']."/modules/".$module_file);
$xtpl->assign('LANG',$lang_module);
$xtpl->assign('GLANG',$lang_global);
$xtpl->assign('NV_BASE_SITEURL',NV_BASE_SITEURL);
$xtpl->assign('MODULE_URL',NV_BASE_ADMINURL."index.php?".NV_NAME_VARIABLE."=".$module_name."&".NV_OP_VARIABLE);
$xtpl->assign('OP',$op);
$xtpl->assign('PTITLE',sprintf($lang_module['quanly_nam'],$groupsList[$id]['title'],$users));

$xtpl->parse('main');
$contents=$xtpl->text('main');



echo $contents;


?>