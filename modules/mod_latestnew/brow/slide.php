<script type="text/javascript">
var vtemslideshow = jQuery.noConflict();
(function($) {
	$(document).ready(function(){
		$('#slideshow1').jqFancyTransitions({ 
		width:735, 
		height: 455,
		strips: 10,
		delay: 5000,
		stripDelay: 50,
		titleOpacity: 0.7,
		titleSpeed: 1000,
		position: 'bottom',
		direction: 'fountainAlternate',
		effect: '',
		navigation: true,
		links : 0});
	});
})(jQuery);
</script>

<style type="text/css">
.vtem_wapper{
	position:relative;
        width:735px;
	border:0px solid #F5F5F5;
	overflow:hidden;
        margin-left: 2px;
}

.slidemain .ft-title{
	display:none;
}

.item_photo,.slidemain{
	width:713px;
	height:455px;
}
.ft-prev,.ft-next{
	color:#333 !important;
	font-weight:bold !important;
	padding:4px;
	text-indent:-999999px;
	width:30px;
	display:none;
	visibility:hidden
}

.ft-prev{
	background:url(images/go_style4.png) right top no-repeat;
	_background:#f5f5f5;
	left:8px !important;
}

.ft-prev:hover{
	background-position:right bottom;
}

.ft-next{
	background:url(images/go_style4.png) left top no-repeat;
	_background:#f5f5f5;
	right:8px !important;
}

.ft-next:hover{
	background-position:left bottom;
}

.vtem_button{
	position:absolute;
	left:0;
	bottom:0;
	margin:10px;
}

.vtem_button div{
	height:30px; line-height:27px; margin:0; padding:0;
}

.vtem_button div a{
	background:url(images/style4.png) center 0 no-repeat;
	padding:5px 9px;
	margin:2px;
	font-weight:bold;
	text-decoration:none !important;
}

.ft-button-slideshow1-active{
	color:#cc0000 !important;
         
}
</style>

<div class="vtem_wapper nav_style4" style="clear:both;">
	<div id="slideshow1" class="slidemain">
		<img src='images/slider/1.jpg' alt='VTEM Slideshow' />
		<img src='images/slider/2.jpg' alt='VTEM Slideshow' />
		<img src='images/slider/3.jpg' alt='VTEM Slideshow' />
		<img src='images/slider/4.jpg' alt='VTEM Slideshow' />
                <img src='images/slider/5.jpg' alt='VTEM Slideshow' />
		<img src='images/slider/6.jpg' alt='VTEM Slideshow' />
		<img src='images/slider/7.jpg' alt='VTEM Slideshow' />
		<img src='images/slider/8.jpg' alt='VTEM Slideshow' />
                <img src='images/slider/9.jpg' alt='VTEM Slideshow' />
	</div>
</div>