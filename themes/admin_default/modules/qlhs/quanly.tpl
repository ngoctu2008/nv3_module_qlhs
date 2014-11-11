<!-- BEGIN: add -->

<!-- END: add -->
<!-- BEGIN: list -->

<!-- END: list -->
<!-- BEGIN: main -->
<script type="text/javascript" src="/js/admin_tabs_old.js"></script>
  <div id="tabContainer">
    <div id="tabs">
      <ul>
        <li id="tabHeader_1">Năm học</li>
        <li id="tabHeader_2">Lớp học</li>
        <li id="tabHeader_3">Môn học</li>
		<li id="tabHeader_4">Danh sách học sinh</li>
		<li id="tabHeader_5">Bảng điểm</li>
		<li id="tabHeader_6">Xếp loại</li>
      </ul>
    </div>
    <div id="tabscontent">
		<div class="tabpage" id="tabpage_1">
			<div id="namhoc" >	
			</div>
		
      </div>
      <div class="tabpage" id="tabpage_2">
 			<div id="lophoc">	
			</div>
      </div>
      <div class="tabpage" id="tabpage_3">
			<div id="monhoc">	
			</div>
      </div>
	  <div class="tabpage" id="tabpage_4">
 			<div id="hocsinh">	
			</div>
      </div>
	  <div class="tabpage" id="tabpage_5">
			<div id="bangdiem">	
			</div>
      </div>
	  <div class="tabpage" id="tabpage_6">
 			<div id="xeploai">	
			</div>
      </div>
    </div>
  </div>
	<script type="text/javascript">
		//<![CDATA[
		$(function() {
		  $('#namhoc').load('/admin/index.php?nv=qlhs&op=quanly_nam');
		  $('#namhoc').show();
		  $('#lophoc').load('/admin/index.php?nv=qlhs&op=quanly_lop');
		  $('#lophoc').show();
		});
		//]]>
	</script> 
	<style tupe="text/css">
		#namhoc{display:block !important;}
		#lophoc{display:block !important;}
	</style>	
	<div id='contentedit'></div><input id='hasfocus' style='width:0px;height:0px;display:none' />
	
	
	
<!-- END: main -->
<!-- BEGIN: listUsers -->
<!-- END: listUsers -->
<!-- BEGIN: userlist -->
<!-- END: userlist -->