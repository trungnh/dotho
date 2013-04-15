<div class="module box-module module-support">                       
	<?php
		$datetime=date("Y-m-d");
		$url=WEBSITE;
		if(!isset($objorder))
		$objorder = new CLS_ORDER();
		if(!isset($objorderdetail))
		$objorderdetail = new CLS_ORDER_DETAIL();
		if(!isset($objproduct))
		$objproduct = new CLS_PRODUCTS();
		$objproduct->getProEventID(" and `end_date` >= '$datetime' ",3,0,1);
		if($objproduct->Numrows()>0)
		{
			$rows = $objproduct->Fecth_Array();
			date_default_timezone_set('asia/saigon');
                $ti=date('Y-m-d-H-i-s');
				$time1=explode("-",$ti);
				$time2=explode("-",$rows["end_date"]);
				$time11= mktime($time1[3],$time1[4],$time1[5],$time1[1],$time1[2],$time1[0]);
				$time12= mktime(0,0,0,$time2[1],$time2[2],$time2[0]);
				$time3=$time12 - $time11;
				if($time3<0)
				$time3=$time11 - $time12;
			$idpro=$rows["pro_id"];
			$objproduct->getProByID($idpro);
			//echo $idpro;
			$cur_price=number_format($rows["cur_price"]);
			$old_price=number_format($rows["old_price"]);
			if($rows["cur_price"] < $rows["old_price"] && $rows["old_price"]!=0)
				{
					$giamtru=$rows["sales"];
				}	
			else
					$giamtru="0";
			$imagethumb=$objproduct->showProImages($rows["pro_id"]);	
			$objorder->getListProduct(" where `status`='2' and `pro_id`='$idpro' ");
			$sl=0;
			while($rows1 = $objorder->Fecth_Array())
			{
				$sl+=$rows1["count"];
			}
			echo '
				<div class="productHotItem">
					<a class="link_block" href="'.WEBSITE.$idpro.'/'.stripUnicode($objproduct->Name).'.html" title="'.$objproduct->Name.'">'.$objproduct->Name.'</a>
						<a style="overflow: hidden; display: block;" class="link_block_img" href="'.WEBSITE.$idpro.'/'.stripUnicode($objproduct->Name).'.html"><img width="265" src="'.WEBSITE.$imagethumb.'" alt="'.$objproduct->Name.'">
						</a>
					<div class=clearfix>
						<div class="fl">
							<p><span class="pric">'.$cur_price.'</span> VNĐ</p>
							<span class="lab">Giá gốc: </span><span class="pricegoc"> '.$old_price.'VNĐ</span>
						</div>
						<div class="fr"><a href="'.WEBSITE.$idpro.'/'.stripUnicode($objproduct->Name).'.html" title="'.$objproduct->Name.'">XEM</a></div>
					</div>
					<div class="clearfix box-bottom">
						<span class="hotdown">Tiết kiệm<span>'.$giamtru.'%</span></span>
						<div class="buyed">Số người đã mua <span>'.$sl.'</span></div>
						<div class="disly">Thời gian còn <div diff="'.$time3.'" curtime="1331295833" id="deal-timeleft-'.$idpro.'" class="deal-timeleft1">
						 <div id="counterlist-'.$idpro.'"></div>
							</div>
						 </div>
					</div>
				</div>
			';
		}
		else
			echo "Sản phẩm đang cập nhật";
		?>	
</div>											  
<?php
unset($objpro);
unset($objmodule);
?>
<script type="text/javascript" src="<?php echo WEBSITE; ?>js/jquery.js"></script>
<script language="javascript">
	  var sec = {};
	  function getInitTime(){
	  jQuery.noConflict();
	(function($) { 
	  $(function() {
		  $('div.deal-timeleft1').each(function(){
			 var jobj = $(this);
			 var SysSecond = parseInt(jobj.attr('diff'));
			 var theid = parseInt((jobj.attr('id')).replace(/deal-timeleft-/,''));
			 sec[theid]= SysSecond;
		  });
		 });
})(jQuery);
	  }
	  getInitTime();
	  function SetRemainTime() {
			for(var i in sec){
				/*setRemainTimeSite(i,sec[i]);*/
				setRemainTimeSite1(i,sec[i]);
			}
	   }
	  function setRemainTimeSite1(theid,SysSecond){
		
		  if (SysSecond > 0) {
			   SysSecond = SysSecond - 1;
			   var second = Math.floor(SysSecond % 60).toString();
			   var minite = Math.floor((SysSecond / 60) % 60).toString();
			  /* var hour = Math.floor((SysSecond / 3600) % 24).toString();*/
			  var hour = Math.floor(SysSecond / 3600).toString();
			   var day = Math.floor((SysSecond / 3600) / 24).toString();
			   $("#counterlist-"+theid).html(""+hour+":"+minite+":"+second);
			   sec[theid]--;
		  }else{
			return;
		  }
		}		
	  window.setInterval(SetRemainTime,1000);  
</script>