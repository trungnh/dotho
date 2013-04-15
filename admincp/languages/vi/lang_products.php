<?php
class LANG_PRODUCTS{
	var $pro=array(
				   "PRODUCT_MANAGER"=>"Quản lý sản phẩm",
				   "PRODUCT_MANAGER_EDIT"=>"Sửa sản phẩm",
				   "PRODUCT_MANAGER_ADD"=>"Thêm mới sản phẩm",	
				   
				   "PRODUCT_A01"=>"Thêm mới sản phẩm thành công",
				   "PRODUCT_A02"=>"Lỗi. Thêm mới không thành công",
				   "PRODUCT_U01"=>"Cập nhật sản phẩm thành công",
				   "PRODUCT_U02"=>"Lỗi. Thông tin chưa được cập nhật",
				   "PRODUCT_U03"=>"Lỗi. Không tìm thấy thông tin cần lưu trữ trong CSDL.",		
				   "PRODUCT_D01"=>"Xóa sản phẩm thành công",
				   "PRODUCT_D02"=>"Lỗi. Xóa sản phẩm không thành công",
				   "PRODUCT_D03"=>"Lỗi. Không tìm thấy sản phẩm cần xóa.",
				   
				   "LANG_CODE"=>"Mã",
				   "LANG_NAME"=>"Tên",
				   "LANG_SITE"=>"Trang chính",
				   "LANG_FLAG"=>"Ngôn ngữ"
				   );
	function __get($proname){
		if(isset($this->pro[$proname]))
			return $this->pro[$proname];
		else
			return "Không tim thấy ngôn ngữ mặc định!";
	}
}
?>