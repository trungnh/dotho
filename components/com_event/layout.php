<?php
$datetime=date("Y-m-d");
if(!isset($objevent))
$objevent= new CLS_EVENT_DETAIL();
if(!isset($objorder))
$objorder = new CLS_ORDER(); 
if(!isset($objpro))
$objproduct=new CLS_PRODUCTS();
if(isset($_GET["itemID"]))
{
	$cata=$_GET["itemID"];
	$proids=$objevent->getProEvent($cata," and `end_date` >= '$datetime'");
	$cataids=$objevent->getProID($proids,"");
	if(!isset($objcata))
	$objcata=new CLS_CATALOG();
?>
<div id="catdown">
<?php $this->loadModule("top"); ?>
</div>
<div>
    <div class="block block-layered-nav">
        <?php if($cataids!=""){ ?>
        <div class="block-content">
            <dl id="narrow-by-list2">
                <dt class="title-sub-category last odd">Danh mục sản phẩm</dt>
                <dd class="last odd">
                    <ol>
                        <?php  
                           $objcata->listCataName("",$cataids,$proids,$cata);
                        ?>
                    </ol>
                </dd>
            </dl>
        </div>
        <?php } ?>
        <div class="quangcao">
            <?php $this->loadModule("user6");?>
        </div>
    </div>
    <div id="col-event" class="clearfix">
		<?php
		if(isset($_GET["item"]))
		{
		$itemids=$_GET["item"];
		$objevent->getProEventID(" and `end_date` >= '$datetime' and `pro_id` in(select pro_id from tbl_products where `cata_id`=$itemids and `isactive`=1 ) ",$cata);
		}
		else
		$objevent->getProEventID(" and `end_date` >= '$datetime'  ",$cata);
		if($objevent->Numrows()>0)
		{
			while($rows = $objevent->Fecth_Array())
			{
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
				$cur_price=number_format($rows["cur_price"]);
				$old_price=number_format($rows["old_price"]);
				if($rows["cur_price"] < $rows["old_price"] && $rows["old_price"]!=0)
					$giamtru=$rows["sales"];	
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
						<a style="overflow: hidden; display: block;" class="link_block_img" href="'.WEBSITE.$idpro.'/'.stripUnicode($objproduct->Name).'.html" title="'.$objproduct->Name.'"><img width="210" src="'.WEBSITE.$imagethumb.'"  alt="'.$objproduct->Name.'">
						</a>';
                    if($cata==5)
                        echo '<p class="price-gold">Giá bán: </span> '.$old_price.' VNĐ</p>
                        <div class="box-glod">
                            <p class="old-glod"><span>Giá giờ vàng:</span> '.$cur_price.' VNĐ</p>
                            <p><span>Số lượng: </span> '.$sl.'</p>
                            <p><span>Mô tả:</span>'.uncodeHTML(stripslashes($rows["intro"])).'</p>
                        </div>
                        <p class="buy-now">
                           <a onclick="openBoxAddPro(\''.WEBSITE.'components/com_cart/tem/add2cart.php?ItemID='.$idpro.'&amp;Title='.$objproduct->Name.'\')" href="#"><span>Đặt mua</span></a>
                        </p>';
                        
                    else    
    					echo	'<div class="intro">'.uncodeHTML(stripslashes($objproduct->Fulltext)).'</div>
                            <div class=clearfix>
    							<div class="fl">
    								<p><span class="pric">'.$cur_price.'</span> VNĐ</p>
    								<span class="lab">Giá gốc: </span><span class="pricegoc"> '.$old_price.'VNĐ</span>
    							</div>
    							<div class="fr"><a href="'.WEBSITE.$idpro.'/'.stripUnicode($objproduct->Name).'.html">XEM</a></div>
    						</div>
    						<div class="clearfix box-bottom">
    							<span class="hotdown">Tiết kiệm<span>'.$giamtru.'%</span></span>
    							<div class="buyed">Số người đã mua <span>'.$sl.'</span></div>
    							<div class="disly">Thời gian còn <div diff="'.$time3.'" curtime="1331295833" id="deal-timeleft-'.$idpro.'" class="deal-timeleft1">
    							 <div id="counterlist-'.$idpro.'"></div>
    								</div>
    							 </div>
    						</div>';
                echo '</div>';
			}
		}
		else
			echo "Sản phẩm đang cập nhật";
		?>	
	</div>
</div>
<?php 
}
?>
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
				setRemainTimeSite1(i,sec[i]);
			}
	   }
	  function setRemainTimeSite1(theid,SysSecond){
		
		  if (SysSecond > 0) {
			   SysSecond = SysSecond - 1;
			   var second = Math.floor(SysSecond % 60).toString();
			   var minite = Math.floor((SysSecond / 60) % 60).toString();
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