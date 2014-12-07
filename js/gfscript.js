function bookmark_us(url,title){
    if(window.sidebar)
        window.sidebar.addPanel(title,url,"");
    else if(window.opera&&window.print){
        var elem=document.createElement('a');
        elem.setAttribute('href',url);
        elem.setAttribute('title',title);
        elem.setAttribute('rel','sidebar');
        elem.click();
    }
    else if(document.all)
        window.external.AddFavorite(url,title);
}
function OpenPopup(url){
    myWindow=window.open(url,'_blank','width=750,height=400');
}
function hidden_all(){
    var topmenu=document.getElementById("topmenu");
    var ctrli=topmenu.getElementsByTagName("li");
    for(var i=0;i<ctrli.length;i++){
        var ctrdiv=ctrli[i].getElementsByTagName("div");
        for(var j=0;j<ctrdiv.length;j++){
            if(ctrdiv[j].className=="box_submenu"){
                ctrdiv[j].style.display="none";
            }
        }
        }
    }
function show_submenu(ctr){
    var topmenu=document.getElementById("topmenu");
    var ctrli=topmenu.getElementsByTagName("li");
    hidden_all();
    div=ctr.getElementsByTagName("div");
    for(var j=0;j<div.length;j++){
        if(div[j].className=="box_submenu"){
            div[j].style.display="block";
        }
    }
    }
function hidden_submenu(ctr){
    hidden_all();
}
function docheckall(name,status){
    var objs=document.getElementsByName(name);
    for(i=0;i<objs.length;i++)
        objs[i].checked=status;
    getIDchecked(name);
}
function docheckonce(name){
    var objs=document.getElementsByName(name);
    var flag=true;
    for(i=0;i<objs.length;i++)
        if(objs[i].checked!=true)
        {
            flag=false;
            break;
        }
    document.getElementById("checkall").checked=flag;
    getIDchecked(name);
}
function getIDchecked(name){
    var objs=document.getElementsByName(name);
    var strids="";
    for(i=0;i<objs.length;i++)
        if(objs[i].checked==true)
        {
            strids+=objs[i].value+",";
        }
    document.getElementById("txtids").value=strids;
    activeTr();
}
function do_order(){
    var objids=document.getElementsByName("checkid");
    var strids="";
    for(i=0;i<objids.length;i++)
        strids+=objids[i].value+",";
    document.getElementById("txtids").value=strids;
    var objods=document.getElementsByName("txtorder");
    var strids="";
    for(i=0;i<objods.length;i++)
        strids+=objods[i].value+",";
    document.getElementById("txtorders").value=strids;
    dosubmitAction('frm_menu','order');
}
function activeTr(){
    var Trs=document.getElementsByName("trow");
    for(i=0;i<Trs.length;i++)

    {
        var check=Trs[i].getElementsByTagName("input");
        if(check[0].checked==true)
            Trs[i].className="active";else
            Trs[i].className="";
    }
    }
function dosubmitAction(frmID,action){
    if(document.getElementById("txtaction"))
        document.getElementById("txtaction").value=action;
    if(checkinput()==true)

    {
        if(frmID=="frm_action")
            document.getElementById("cmdsave").click();else
            document.frm_menu.submit();
    }
}
function doSave(frmID,action){
    if(document.getElementById("txtaction"))
        document.getElementById("txtaction").value=action;
    if(checkinput()==true)

    {
        if(frmID=="frm_action")
            document.getElementById("cmdsave").click();
        else

        {
            document.frm_menu.submit();
        }
    }
}
function gotopage(page)
{
    document.getElementById("txtCurnpage").value=page;
    document.frmpaging.submit();
}
function openlink(url)
{
    window.location=url;
}
function onsearch(thisitem,type){
    var str=thisitem.value;
    if(type==0&&str=="")
        thisitem.value="Keyword";
    if(type==1)
        thisitem.value="";
}
function cbo_Selected(id,value)
{
    var obj=document.getElementById(id);
    for(i=0;i<obj.length;i++)
        if(obj[i].value==value)
            obj.selectedIndex=i;
    }
function confirmation(id){
    var answer=confirm("Bạn chắc chắn muốn xóa không?")
    if(answer){
        window.location="index.php?com=com_users&task=delete&memid="+id;
    }
}
function openBox(url)
{
    var xmlhttp;
    if(url.length==0)

    {
        document.getElementById("shopcart").innerHTML="";
        return;
    }
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4&&xmlhttp.status==200)

        {
            document.getElementById("shopcart").innerHTML=xmlhttp.responseText;
        }
    }
xmlhttp.open("GET",url,true);
xmlhttp.send();
}
function openBoxAddPro(url)
{
    var xmlhttp;
    if(url.length==0)

    {
        document.getElementById("shopcart").innerHTML="";
        return;
    }
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4&&xmlhttp.status==200)

        {
            document.getElementById("shopcart").innerHTML=xmlhttp.responseText;
            window.location="http://www.dothosondong.us/viewcart.html";
        }
    }
xmlhttp.open("GET",url,true);
xmlhttp.send();
}
function showdate(){
    var mydate=new Date()
    var year=mydate.getYear()
    if(year<1000)
        year+=1900
    var month=mydate.getMonth()+1
    if(month<10)
        month="0"+month
    var day=mydate.getDate()
    if(day<10)
        day="0"+day
    var dayw=mydate.getDay()
    var hour=mydate.getHours()
    if(hour<10)
        hour="0"+hour
    var minute=mydate.getMinutes()
    if(minute<10)
        minute="0"+minute
    var second=mydate.getSeconds()
    if(second<10)
        second="0"+second
    var dayarray=new Array("Chủ Nhật","Thứ Hai","Thứ Ba","Thứ Tư","Thứ Năm","Thứ Sáu","Thứ Bảy");
    var strtime="<span class=date>"+dayarray[dayw]+", "+day+"/"+month+"/"+year+" "+hour+":"+minute+":"+minute+"</span>"
    document.getElementById("gf-clock").innerHTML=strtime;
    id=setTimeout("showdate()",1000);
}
function clock(){
    var now=new Date();
    var year=now.getFullYear();
    var month=now.getMonth();
    var date=now.getDate();
    var day=now.getDay();
    var hour=now.getHours();
    var minute=now.getMinutes();
    var second=now.getSeconds();
    var montharray=new Array("01","02","03","04","05","06","07","08","09","10","11","12");
    var dayarray=new Array("Chủ Nhật","Thứ Hai","Thứ Ba","Thứ Tư","Thứ Năm","Thứ Sáu","Thứ Bảy");
    var disptime=dayarray[day]+", "+date+"/"+montharray[month]+"/"+year+" ";
    disptime+=((hour>12)?hour-12:hour)+((minute<10)?":0":":")+minute;
    disptime+=((second<10)?":0":":")+second+((hour>=12)?" PM":" AM");
    document.getElementById("datetime").innerHTML=disptime;
    id=setTimeout("clock()",1000);
}