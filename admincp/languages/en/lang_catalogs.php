<?php
class LANG_CATALOGS{
	var $pro=array(
				   "CATA_MANAGER"=>"QUẢN LÝ NHÓM SẢN PHẨM",
				   "CATA_MANAGER_EDIT"=>"SỬA NHÓM SẢN PHẨM",
				   "CATA_MANAGER_ADD"=>"THÊM MỚI NHÓM SẢN PHẨM",	
				   
				   "CATA_A01"=>"Thêm mới nhóm sản phẩm thành công",
				   "CATA_A02"=>"Lỗi. Thêm mới không thành công",
				   "CATA_U01"=>"Cập nhật nhóm sản phẩm thành công",
				   "CATA_U02"=>"Lỗi. Thông tin chưa được cập nhật",
				   "CATA_U03"=>"Lỗi. Không tìm thấy thông tin cần lưu trữ trong CSDL.",		
				   "CATA_D01"=>"Xóa nhóm sản phẩm thành công",
				   "CATA_D02"=>"Lỗi. Xóa nhóm sản phẩm không thành công",
				   "CATA_D03"=>"Lỗi. Không tìm thấy nhóm sản phẩm cần xóa.",	
				   "CATA_D04"=>"Lỗi. Nhóm sản phẩm này đang có bài viết, nên bạn không thể xóa. Vui lòng xóa bài viết trước khi xóa nhóm sản phẩm",	
				   "CATA_D05"=>"Lỗi. Nhóm sản phẩm con của nhóm sản phẩm này đang có sản phẩm, nên bạn không thể xóa. Vui lòng xóa sản phẩm trước khi xóa nhóm sản phẩm",
				   "LANG_CODE"=>"Code",
				   "LANG_NAME"=>"Name",
				   "LANG_SITE"=>"Site",
				   "LANG_FLAG"=>"Flag"
				   );
	function __get($proname){
		if(isset($this->pro[$proname]))
			return $this->pro[$proname];
		else
			return "";
	}
}
?>