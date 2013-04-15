<?php
class LANG_PRODUCTS{
	var $pro=array(
				   "PRODUCT_MANAGER"=>"Product Manager",
				   "PRODUCT_MANAGER_EDIT"=>"Edit PRODUCT",
				   "PRODUCT_MANAGER_ADD"=>"Add new PRODUCT",	
				   
				   "PRODUCT_A01"=>"Thêm mới sản phẩm thành công",
				   "PRODUCT_A02"=>"Lỗi. Thêm mới không thành công",
				   "PRODUCT_U01"=>"Cập nhật sản phẩm thành công",
				   "PRODUCT_U02"=>"Lỗi. Thông tin chưa được cập nhật",
				   "PRODUCT_U03"=>"Lỗi. Không tìm thấy thông tin cần lưu trữ trong CSDL.",		
				   "PRODUCT_D01"=>"Xóa sản phẩm thành công",
				   "PRODUCT_D02"=>"Lỗi. Xóa sản phẩm không thành công",
				   "PRODUCT_D03"=>"Lỗi. Không tìm thấy sản phẩm cần xóa.",
				   
				   "LANG_CODE"=>"Code",
				   "LANG_NAME"=>"Name",
				   "LANG_SITE"=>"Site",
				   "LANG_FLAG"=>"Flag"
				   );
	function __get($proname){
		if(isset($this->pro[$proname]))
			return $this->pro[$proname];
		else
			return "can't find this lang";
	}
}
?>