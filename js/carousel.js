;(function($){$.fn.carouselcus=function(params){var params=$.extend({direction:"horizontal",loop:false,dispItems:1,pagination:false,paginationPosition:"inside",nextBtn:'<input type="button" value="Next" />',prevBtn:'<input type="button" value="Previous" />',btnsPosition:"inside",nextBtnInsert:"insertAfter",prevBtnInsert:"insertBefore",nextBtnInsertFn:false,prevBtnInsertFn:false,autoSlide:false,autoSlideInterval:3000,delayAutoSlide:false,combinedClasses:false,effect:"fade",slideEasing:"swing",animSpeed:300,equalWidths:"true",verticalMargin:0,callback:function(){},useAddress:false,adressIdentifier:"carouselcus",tabLabel:function(tabNum){return tabNum;},showEmptyItems:true,ajaxMode:false,ajaxUrl:"",stopSlideBtn:false,stopSlideTextPause:"Pause",stopSlideTextPlay:"Play"},params);if(params.btnsPosition=="outside"){params.prevBtnInsert="insertBefore";params.nextBtnInsert="insertAfter";}
params.delayAutoSlide=0+params.delayAutoSlide;return this.each(function(){var env={$elts:{},params:params,launchOnLoad:[]};env.$elts.carouselcus=$(this).addClass("js");env.$elts.content=$(this).children().css({position:"absolute","top":0});env.$elts.wrap=env.$elts.content.wrap('<div class="carouselcus-wrap"></div>').parent().css({overflow:"hidden",position:"relative"});env.steps={first:0,count:env.$elts.content.children().length};env.$elts.loader=$('<div class="loader"></div>').css({'position':'absolute'});env.steps.last=env.steps.count-1;if(env.params.pagination){initPagination(env);}
if($.isFunction(env.params.prevBtnInsertFn)){env.$elts.prevBtn=env.params.prevBtnInsertFn(env.$elts);}else{if(params.btnsPosition=="outside"){env.$elts.prevBtn=$(params.prevBtn)[params.prevBtnInsert](env.$elts.carouselcus);}else{env.$elts.prevBtn=$(params.prevBtn)[params.prevBtnInsert](env.$elts.wrap);}}
if($.isFunction(env.params.nextBtnInsertFn)){env.$elts.nextBtn=env.params.nextBtnInsertFn(env.$elts);}else{if(params.btnsPosition=="outside"){env.$elts.nextBtn=$(params.nextBtn)[params.nextBtnInsert](env.$elts.carouselcus);}else{env.$elts.nextBtn=$(params.nextBtn)[params.nextBtnInsert](env.$elts.wrap);}}
env.$elts.nextBtn.addClass("carouselcus-control next carouselcus-next");env.$elts.prevBtn.addClass("carouselcus-control previous carouselcus-previous");env.lastItemsToLoad;initButtonsEvents(env);env.$elts.carouselcus.add(env.$elts.carouselcus.children()).bind({focus:function(e){$(document).bind('keypress',function(e){switch(e.keyCode){case 39:env.$elts.nextBtn.click();break;case 37:env.$elts.prevBtn.click();break;}
switch(e.charCode){case 110:env.$elts.nextBtn.click();break;case 112:env.$elts.prevBtn.click();break;}});},blur:function(){$(document).unbind('keypress');}});initAddress(env);$(function(){initCarouselcus(env);$.each(env.launchOnLoad,function(i,fn){fn();});if(env.params.autoSlide){initAutoSlide(env);}
if(params.stopSlideBtn==true){env.$elts.stopSlideBtn=$('<button type="button" class="slide-control play">'+params.stopSlideTextPause+'</button>');createBtnStopAutoslide(env);}});});};function initCarouselcus(env){var $items=env.$elts.content.children();var $maxHeight=0;$items.each(function(){$item=$(this);$itemHeight=$item.outerHeight();if($itemHeight>$maxHeight){$maxHeight=$itemHeight;}});if(env.params.verticalMargin>0){$maxHeight=$maxHeight+env.params.verticalMargin;}
$items.height($maxHeight);var $firstItem=env.$elts.content.children(":first");env.itemWidth=$firstItem.outerWidth();if(env.params.direction=="vertical"){env.contentWidth=env.itemWidth;}else{if(env.params.equalWidths){env.contentWidth=env.itemWidth*env.steps.count;}else{env.contentWidth=(function(){var totalWidth=0;env.$elts.content.children().each(function(){totalWidth+=$(this).outerWidth();});return totalWidth;})();}
env.contentWidth+=10;}
env.$elts.content.width(env.contentWidth);env.itemHeight=$maxHeight;if(env.params.direction=="vertical"){env.$elts.content.css({height:env.itemHeight*env.steps.count+"px"});env.$elts.content.parent().css({height:env.itemHeight*env.params.dispItems+"px"});}else{env.$elts.content.parent().css({height:env.itemHeight+"px"});}
updateButtonsState(env);}
function initButtonsEvents(env){env.$elts.nextBtn.add(env.$elts.prevBtn).bind("enable",function(){var $this=$(this).unbind("click").bind("click",function(){if(env.params.ajaxMode&&$this.is('.next')&&getActivePageIndex(env)==(getPageTotal(env)-1)&&!env.lastItemsToLoad){ajaxLoad(env);env.$elts.content.ajaxSuccess(function(){});}else{goToStep(env,getRelativeStep(env,($this.is(".next")?"next":"prev")));if(env.params.stopSlideBtn==true){env.$elts.stopSlideBtn.trigger('pause');}else{stopAutoSlide(env);}}}).removeClass("disabled").removeAttr('disabled');if(env.params.combinedClasses){$this.removeClass("next-disabled previous-disabled").removeAttr("disabled");}}).bind("disable",function(){var $this=$(this).unbind("click").addClass("disabled").attr("disabled","disabled");if(env.params.combinedClasses){if($this.is(".next")){$this.addClass("next-disabled");}else if($this.is(".previous")){$this.addClass("previous-disabled");}}}).hover(function(){$(this).toggleClass("hover");});};function initPagination(env){env.$elts.pagination=$('<div class="center-wrap"><div class="carouselcus-pagination"><p></p></div></div>')[((env.params.paginationPosition=="outside")?"insertAfter":"appendTo")](env.$elts.carouselcus).find("p");env.$elts.paginationBtns=$([]);env.$elts.content.find("li").each(function(i){if(i%env.params.dispItems==0){addPage(env,i);}});env.$elts.paginationBtns=env.$elts.paginationBtns.add('<span class="total-p"> / '+getPageTotal(env)+'</span>').appendTo(env.$elts.pagination);};function addPage(env,firststep){if(env.params.pagination){env.$elts.paginationBtns=env.$elts.paginationBtns.add($('<a role="button"><span>'+env.params.tabLabel(env.$elts.paginationBtns.length+1)+'</span></a>').data("firstStep",firststep)).appendTo(env.$elts.pagination);env.$elts.paginationBtns.slice(0,1).addClass("active");env.$elts.paginationBtns.click(function(e){goToStep(env,$(this).data("firstStep"));if(env.params.stopSlideBtn==true){env.$elts.stopSlideBtn.trigger('pause');}else{stopAutoSlide(env);}});}}
function initAddress(env){if(env.params.useAddress&&$.isFunction($.fn.address)){$.address.init(function(e){var pathNames=$.address.pathNames();if(pathNames[0]===env.params.adressIdentifier&&!!pathNames[1]){goToStep(env,pathNames[1]-1);}else{$.address.value('/'+env.params.adressIdentifier+'/1');}}).change(function(e){var pathNames=$.address.pathNames();if(pathNames[0]===env.params.adressIdentifier&&!!pathNames[1]){goToStep(env,pathNames[1]-1);}});}else{env.params.useAddress=false;}};function goToStep(env,step){env.params.callback(step);transition(env,step);env.steps.first=step;updateButtonsState(env);if(env.params.useAddress){$.address.value('/'+env.params.adressIdentifier+'/'+(step+1));}};function getRelativeStep(env,position){if(position=="prev"){if(!env.params.showEmptyItems){if(env.steps.first==0){return((env.params.loop)?((Math.ceil(env.steps.count/env.params.dispItems)-1)*env.params.dispItems):false);}else{return Math.max(0,env.steps.first-env.params.dispItems);}}else{if((env.steps.first-env.params.dispItems)>=0){return env.steps.first-env.params.dispItems;}else{return((env.params.loop)?((Math.ceil(env.steps.count/env.params.dispItems)-1)*env.params.dispItems):false);}}}else if(position=="next"){if((env.steps.first+env.params.dispItems)<env.steps.count){if(!env.params.showEmptyItems){return Math.min(env.steps.first+env.params.dispItems,env.steps.count-env.params.dispItems);}else{return env.steps.first+env.params.dispItems;}}else{return((env.params.loop)?0:false);}}};function transition(env,step){switch(env.params.effect){case"no":if(env.params.direction=="vertical"){env.$elts.content.css("top",-(env.itemHeight*step)+"px");}else{env.$elts.content.css("left",-(env.itemWidth*step)+"px");}
break;case"fade":if(env.params.direction=="vertical"){env.$elts.content.hide().css("top",-(env.itemHeight*step)+"px").fadeIn(env.params.animSpeed);}else{env.$elts.content.hide().css("left",-(env.itemWidth*step)+"px").fadeIn(env.params.animSpeed);}
break;default:if(env.params.direction=="vertical"){env.$elts.content.stop().animate({top:-(env.itemHeight*step)+"px"},env.params.animSpeed,env.params.slideEasing);}else{env.$elts.content.stop().animate({left:-(env.itemWidth*step)+"px"},env.params.animSpeed,env.params.slideEasing);}
break;}};function updateButtonsState(env){if(getRelativeStep(env,"prev")!==false){env.$elts.prevBtn.trigger("enable");}else{env.$elts.prevBtn.trigger("disable");}
if(getRelativeStep(env,"next")!==false){env.$elts.nextBtn.trigger("enable");}else{env.$elts.nextBtn.trigger("disable");}
if(env.params.pagination){var check=false;env.$elts.paginationBtns.removeClass("active").filter(function(){if($(this).data("firstStep")==env.steps.first){check=true;}
return($(this).data("firstStep")==env.steps.first)}).addClass("active");if(!check){env.$elts.paginationBtns.slice(0,1).addClass("active");}}};function initAutoSlide(env){env.delayAutoSlide=window.setTimeout(function(){env.autoSlideInterval=window.setInterval(function(){goToStep(env,getRelativeStep(env,"next"));},env.params.autoSlideInterval);},env.params.delayAutoSlide);};function stopAutoSlide(env){window.clearTimeout(env.delayAutoSlide);window.clearInterval(env.autoSlideInterval);env.params.delayAutoSlide=0;};function createBtnStopAutoslide(env){var jButton=env.$elts.stopSlideBtn;jButton.bind({'play':function(){initAutoSlide(env);jButton.removeClass('pause').addClass('play').html(env.params.stopSlideTextPause);},'pause':function(){stopAutoSlide(env);jButton.removeClass('play').addClass('pause').html(env.params.stopSlideTextPlay);}});jButton.click(function(e){if(jButton.is('.play')){jButton.trigger('pause');}else if(jButton.is('.pause')){jButton.trigger('play');}});jButton.prependTo(env.$elts.wrap);};function getPageTotal(env){return env.$elts.pagination.children().length;};function getActivePageIndex(env){return env.steps.first/env.params.dispItems;}
function ajaxLoad(env){env.$elts.carouselcus.prepend(env.$elts.loader);$.ajax({url:env.params.ajaxUrl,dataType:'json',success:function(data){env.lastItemsToLoad=data.bLastItemsToLoad;$(env.$elts.content).append(data.shtml);env.steps={first:env.steps.first+env.params.dispItems,count:env.$elts.content.children().length};env.steps.last=env.steps.count-1;initCarouselcus(env);addPage(env,env.steps.first);goToStep(env,env.steps.first);if(env.params.stopSlideBtn==true){env.$elts.stopSlideBtn.trigger('pause');}else{stopAutoSlide(env);}
env.$elts.loader.remove();}});}})(jQuery);