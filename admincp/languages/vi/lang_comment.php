<?php
class LANG_COMM{
	var $pro=array(
				   "SYSTEM"=>"Hệ thống",
				   "ADMIN_MANAGER"=>"Quản lý thành viên",
				   "SITE_CONFIG"=>"Cấu hình website",
				   "LOGOUT"=>"Thoát",
				   
				   "DATA"=>"Dữ liệu",
				   "LOCATIONS"=>"Địa danh",
				   "DOCUMENT_MANAGER"=>"Quản lý tài liệu",
				   
				   "COMMS"=>"COMMs",
				   "COMMS_MANAGER"=>"Quản lý bình luận",
				   "COMM_MANAGER"=>"Quản lý bình luận",
				   "COMM_MANAGER_EDIT"=>"Sửa bình luận",
				   "COMM_MANAGER_ADD"=>"Thêm mới bình luận",	
				   
				   "COMM_A01"=>"Thêm mới bình luận thành công",
				   "COMM_A02"=>"Lỗi. Thêm mới không thành công",
				   "COMM_U01"=>"Cập nhật bình luận thành công",
				   "COMM_U02"=>"Lỗi. Thông tin chưa được cập nhật",
				   "COMM_U03"=>"Lỗi. Không tìm thấy thông tin cần lưu trữ trong CSDL.",		
				   "COMM_D01"=>"Xóa bình luận thành công",
				   "COMM_D02"=>"Lỗi. Xóa bình luận không thành công",
				   "COMM_D03"=>"Lỗi. Không tìm thấy bình luận cần xóa.",	
				   
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