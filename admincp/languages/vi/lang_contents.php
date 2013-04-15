<?php
class LANG_CONTENTS{
	var $pro=array(
				   "CONTENT_MANAGER"=>"Quản lý bài viết",
				   "CONTENT_MANAGER_EDIT"=>"Sửa bài viết",
				   "CONTENT_MANAGER_ADD"=>"Thêm mới bài viết",	
				   
				   "CONTENT_A01"=>"Thêm mới bài viết thành công",
				   "CONTENT_A02"=>"Lỗi. Thêm mới không thành công",
				   "CONTENT_U01"=>"Cập nhật bài viết thành công",
				   "CONTENT_U02"=>"Lỗi. Thông tin chưa được cập nhật",
				   "CONTENT_U03"=>"Lỗi. Không tìm thấy thông tin cần lưu trữ trong CSDL.",		
				   "CONTENT_D01"=>"Xóa bài viết thành công",
				   "CONTENT_D02"=>"Lỗi. Xóa bài viết không thành công",
				   "CONTENT_D03"=>"Lỗi. Không tìm thấy bài viết cần xóa.",
				   
				   "CMS"=>"Sửa bình luận thành công",
				   "CMF"=>"Lỗi. Sửa bình luận không thành công",
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