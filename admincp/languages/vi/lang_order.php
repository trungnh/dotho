<?php
class LANG_ORDER{
	var $pro=array(
				   "SYSTEM"=>"Hệ thống",
				   "ADMIN_MANAGER"=>"Quản lý thành viên",
				   "SITE_CONFIG"=>"Cấu hình website",
				   "LOGOUT"=>"Thoát",
				   
				   "DATA"=>"Dữ liệu",
				   "LOCATIONS"=>"Địa danh",
				   "DOCUMENT_MANAGER"=>"Quản lý tài liệu",
				   "STATISTIC_ORDER"=>"Thống kê hoá đơn",
				   "STATISTIC_PRODUCT"=>"Thống kê sản phẩm",
				   "ORDER"=>"Hóa đơn",
				   "ORDER_MANAGER"=>"Quản lý hóa đơn",
				   "ORDER_MANAGER_EDIT"=>"Sửa hóa đơn",
				   "ORDER_MANAGER_ADD"=>"Thêm mới hóa đơn",	
				   
				   "ORDER_A01"=>"Thêm mới hóa đơn thành công",
				   "ORDER_A02"=>"Lỗi. Thêm mới không thành công",
				   "ORDER_U01"=>"Cập nhật hóa đơn thành công",
				   "ORDER_U02"=>"Lỗi. Thông tin chưa được cập nhật",
				   "ORDER_U03"=>"Lỗi. Không tìm thấy thông tin cần lưu trữ trong CSDL.",		
				   "ORDER_D01"=>"Xóa hóa đơn thành công",
				   "ORDER_D02"=>"Lỗi. Xóa hóa đơn không thành công",
				   "ORDER_D03"=>"Lỗi. Không tìm thấy hóa đơn cần xóa.",	
				   
				   "CONTENTS"=>"Nội dung",
				   "PRODUCTS"=>"Sản phẩm",
				   "PA_MANAGER"=>"Quản lý quảng cáo",
				   "EMAIL_MARKETING"=>"Email Marketing",
				   "EXTENSIONS"=>"Mở rộng",
				   "Help"=>"Trợ giúp"
				   );
	function __get($proname){
		if(isset($this->pro[$proname]))
			return $this->pro[$proname];
		else
			return "Không tìm thấy ngôn ngữ";
	}
}
?>