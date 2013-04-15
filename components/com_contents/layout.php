<div id="catdown">
<?php $this->loadModule("top"); ?>
</div>
<div id="right">
	<?php $this->loadModule('right');?>
</div> 

<div id="main-content" class="main">
    <div class="col-arical">
    <?php
    // khi cai nay duoc goi, nno se dieu khien cac tem hien thi
    $viewtype="";
    if(isset($_GET["viewtype"])){
    	$viewtype=$_GET["viewtype"];
    }
    	switch($viewtype)
    	{
    		case "block":	include("tem/block.php"); break;
    		case "list":	include("tem/list.php"); break;
    		case "detail":	include("tem/detail.php"); break;
    		case "article": include("tem/article.php"); break;
    		case "search": include("tem/search.php"); break;
    	}
    ?>
    </div>
</div>