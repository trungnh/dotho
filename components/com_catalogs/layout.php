<?php 
$objpro=new CLS_PRODUCTS();
if(isset($_GET["ItemID"]))
{
	$cata=$_GET["ItemID"];
	if(!isset($objcata))
	$objcata=new CLS_CATALOG();
	$objcata->getCatalogByID($cata);
	$parid=$objcata->ParID;
	$name=$objcata->Name;
?>
<div id="catdown">
<?php $this->loadModule("top"); ?>
</div>
<div class="breadcrumbs">
	<div class="bread-left"></div>
    <ul>
			<?php 
			if($parid==0)
			{
			?>
			<li class="category126 item-cat-1">
				<a class="item-link-cat-1" href="<?php echo WEBSITE."danhmuc/".$objcata->ID."-".stripUnicode($objcata->Name); ?>.html" title="<?php echo $objcata->Name; ?>"><?php echo $objcata->Name; ?></a>
			</li
			><?php 
			}
			else
			{
				$item='<li class="category126">
						<a class="item-cat-1" href="'.WEBSITE.'danhmuc/'.$objcata->ID.'-'.stripUnicode($objcata->Name).'.html" title="'.$objcata->Name.'">'.$objcata->Name.'</a>
					</li';
				$objcata->getCatalogByID($parid);
				//$rows = $objcata->Fecth_Array();
				echo '<li class="category126">
					<a class="item-link-cat-1" href="'.WEBSITE.'danhmuc/'.$objcata->ID.'-'.stripUnicode($objcata->Name).'.html" title="'.$objcata->Name.'">'.$objcata->Name.'</a>
				</li>';
				echo $item;
			}
		?>
	</ul>
    <div class="bread-right"></div>
</div>
<div class="container-banner-home clearfix">
	<div class="banner-home clearfix">
		<?php 
    		$objcata->getList(" and par_id= '$cata' ");
    		if($objcata->Numrows()>0)
    		{
	    ?>
            <div class="block block-layered-nav">
                <div class="block-content">
                    <dl id="narrow-by-list2">
                        <dt class="title-sub-category last odd">Danh mục sản phẩm</dt>
                        <dd class="last odd">
                            <ol>
                                <?php  
                                    while ($rows = $objcata->Fecth_Array()) {
                                        echo '<li>
                                                <a href="'.WEBSITE.'danhmuc/'.$rows["cata_id"].'-'.stripUnicode($rows["name"]).'.html" title="'.$rows["name"].'">'.$rows["name"].'</a>
                                            </li>';
                                    }
                                ?>
                            </ol>
                        </dd>
                    </dl>
                </div>
            </div>
        <?php } else { ?>
            <div class="block block-search block-layered-nav">
        	    <div class="block-content">
    		   <?php $this->loadModule("user9"); ?>
                </div>
            </div>
        <?php } ?>
        <div id="slider" class="nivoSlider">
        	<?php $this->loadModule("navitor");?>
        </div>
  </div>
</div>
<div id="right">
   <?php $this->loadModule('right');?>
</div>
	<div id="main-content" class="main">
	<?php
        $objcata->getList(" and par_id= '$cata' ");
        if($objcata->Numrows()>0)
        {
            echo '<div class="featured-cat-block"><div class="featured-cat-content">';
            $idcata=$objcata->getChildID($cata);
            //echo $idcata;
            $dem=explode("','",$idcata);
            for($j=0; $j<count($dem)-1; $j++)
            {
                $objpro->showCatalogsParid(" ",$dem[$j],4);
            }
            echo '</div></div>';
        }
        else
        {
            echo '<div class="featured-cat-block"><div class="featured-cat-content">';
			$total_rows="0";
			if(!isset($_SESSION["CUR_PAGE_MNU"]))
				$_SESSION["CUR_PAGE_MNU"]=1;	
			if(isset($_POST["cur_page"])){	$_SESSION["CUR_PAGE_MNU"]=$_POST["cur_page"];	}
		
			$cur_page=$_SESSION["CUR_PAGE_MNU"];	
			if(isset($_POST["txtCurnpage"])) $cur_page=$_POST["txtCurnpage"];
			$objpro->getList(" and `cata_id`= '$cata'");
			$total_rows=$objpro->Numrows();
			echo '<div class="featured-cat list_product">';
							echo '<div class="cat-title"><a href="#" title="'.$name.'">'.$name.'</a><span class="count-pro">'.$total_rows.' Sản phẩm</span></div>';
								
			$objpro->showProPage(" and `cata_id`= '$cata'",$cur_page);
            echo '</div></div></div>';
			?>
				<div id="paging_index" class="clearfix">
					<?php 
						paging_index($total_rows,20,$cur_page);
					?>
				</div>
            <?php
				}
			?>
    </div>
<?php 
}
else
{
?>
<div id="catdown">
<?php $this->loadModule("top"); ?>
</div>
<div class="container-banner-home clearfix">
	<div class="banner-home clearfix">
		<div class="block block-search block-layered-nav">
			<?php $this->loadModule("user9");?>
			<div class="quangcao">
				<?php //$this->loadModule("user6");?>
			</div>
		</div>
		<div id="slider" class="nivoSlider">
			<?php $this->loadModule("navitor");?>
		</div>
    </div>
</div>
<div id="right">
	<?php $this->loadModule('right');?>
</div>
<div id="main-content" class="main">
	<?php
	if(isset($_POST["txtsearchpro"]))
	{
    	$name=$_POST["txtsearchpro"];
    	$str=" and 	`name` like '%$name%' ";
	}
    else
    {
    	if(isset($_POST["cbo_price"]))
    	{
    		if($_POST["cbo_price"]=="all")
    		echo "<script language=\"javascript\">window.location='index.php</script>";
    		else
    		{
    			$_SESSION["PRICE_PRO"]=$_POST["cbo_price"];
    			$gia=explode("-",$_SESSION["PRICE_PRO"]);
    			$gia1=$gia[0];
    			$gia2=$gia[1];
    			$str=" and `cur_price` >'$gia1' and `cur_price` <'$gia2' ";
    		}
    	}
    	if(isset($_SESSION["PRICE_PRO"]))
    	{
    			$gia=explode("-",$_SESSION["PRICE_PRO"]);
    			$gia1=$gia[0];
    			$gia2=$gia[1];
    			$str=" and `cur_price` >'$gia1' and `cur_price` <'$gia2' ";
    	}
     }
	$title="Kết quả tìm kiếm";
	//if(isset($_GET["ItemIDS"]))
	//{
	    //$proids=$_GET["ItemIDS"];
		//$title="Sản phẩm đã xem";
		//$str=" and 	`pro_id` in ($proids) ";
	//}
	$total_rows="0";
	if(!isset($_SESSION["CUR_PAGE_MNU"]))
		$_SESSION["CUR_PAGE_MNU"]=1;	
	if(isset($_POST["cur_page"])){	$_SESSION["CUR_PAGE_MNU"]=$_POST["cur_page"];	}

	$cur_page=$_SESSION["CUR_PAGE_MNU"];	
	if(isset($_POST["txtCurnpage"])) $cur_page=$_POST["txtCurnpage"];
	$objpro->getList($str);
	$total_rows=$objpro->Numrows();
	echo '<div class="featured-cat-block"><div class="featured-cat-content">
								<div class="featured-cat list_product">';
					echo '<div class="cat-title"><a href="#" title="'.$title.'">'.$title.'</a><span class="count-pro">'.$total_rows.' Sản phẩm</span></div>';
						
	$objpro->showProPage($str,$cur_page);
	?>
    </div></div></div>
	<div id="paging_index" class="clearfix">
		<?php 
			paging_index($total_rows,20,$cur_page);
		?>
	</div>
</div>
<?php } ?>