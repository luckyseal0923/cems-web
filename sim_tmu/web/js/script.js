/*--滑鼠變換影像------------------------------------------------------------------------------------------*/
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
/*--另開視窗------------------------------------------------------------------------------------------*/
function MM_openBrWindow(theURL,winName,features) {
window.open(theURL,winName,features);
}
/*--跳出訊息------------------------------------------------------------------------------------------*/
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
/*--帶參數轉向用------------------------------------------------------------------------------------------*/
function chgLink(strLink,PKey){
    document.form1.PKey.value=PKey;
    document.form1.action= strLink;
    document.form1.submit();
}

function itemLink(strLink,Class1,Class2){
    document.form1.Class1.value=Class1;
    document.form1.Class2.value=Class2;
    document.form1.action= strLink;
    document.form1.submit();
}
function GotoPage(tPage,theForm,Keyword){
	theForm.Page.value=tPage;
	theForm.Keyword.value=Keyword;
	theForm.submit();
}
function bookmark()
{
	if ( document.all )
		window.external.AddFavorite(document.location, "ProLeda");
}

function bookmark() 
{ 
	if ( document.all ) 
		window.external.AddFavorite(document.location, "oec space"); 
} 
function bookmarksite(title, url){ 
	if (document.all) 
		window.external.AddFavorite(url, title); 
	else if (window.sidebar) 
		window.sidebar.addPanel(title, url, "") 
} 
/*--圖層顯示及隱藏-------------------------------------------------------------------------------------*/
function view_ans(num) { 
if(document.getElementById("ans" + num).style.display == "none") { 
document.getElementById("ans" + num).style.display = "block"; 
} else if(document.getElementById("ans" + num).style.display == "block") { 
document.getElementById("ans" + num).style.display = "none"; 
} 
} 


function close_ans(num) {
if(document.getElementById("ans" + num).style.display == "block")
{
document.getElementById("ans" + num).style.display = "none";
}
}
/*--圖片切換--------------------------------------------------------------------------------------*/
function swapImg(photo, title, slink, tmpImg, nw, nh){
	var myImg = document.getElementById("main");
	myImg.setAttribute("src",photo);
	myImg.setAttribute("title",title);
	
	/*var imglink = document.getElementById("imglink");
	imglink.setAttribute("href",slink);*/
	
	/*if (title.length > 0){
	var oLi = document.getElementById("tx1");
	oLi.innerHTML =title+"";}*/
	
	/*
	var oLi = document.getElementById("main");
	oLi.src="../DB/Upload/"+photo;
	oLi.alt=title;*/
	
	AlumbImg(tmpImg, nw, nh);
}
/*--縮圖----------------------------------------------------------------------------------------*/
function AlumbImg(tmpImg, sw, sh) {
	var boxWidth = sw; //縮圖寬度--大圖的高度
	var boxHeight = sh; //縮圖高度

	var screenImage = $("#" + tmpImg);
	var theImage = new Image();
	theImage.src = screenImage.attr("src");
	var imgWidth = theImage.width;
	var imgHeight = theImage.height;

	var t = "tmpImg = " + tmpImg + "\n";
	t += "範圍 w = " + boxWidth + " | h = " + boxHeight + "\n";
	t += "原圖 w = " + imgWidth + " | h = " + imgHeight + "\n";
	
	var NimgWidth = 0;
	var NimgHeight = 0;
	
	screenImage.removeAttr('width');
	screenImage.removeAttr('height');

	if (imgWidth > boxWidth || imgHeight > boxHeight)
	{
        if((boxWidth/boxHeight)>=(imgWidth/imgHeight))
        {
			NimgWidth = Math.ceil((boxHeight*imgWidth)/imgHeight);
			NimgHeight = boxHeight;
        }
        else
        {
			NimgWidth = boxWidth;
			NimgHeight = Math.ceil((boxWidth*imgHeight)/imgWidth);
        }
	}
	else
	{
		NimgWidth = imgWidth;
		NimgHeight = imgHeight;
	}
	
	screenImage.css({height:NimgHeight, width:NimgWidth});
	
	t += "新圖 w = " + NimgWidth + " | h = " + NimgHeight + "\n";
	//alert(t);
}


/*-------------------table tr td hover------------------------------*/
$(document).ready(function(){   
    $(".tables tr").mouseover(function(){    
      $(this).addClass("over");}).mouseout(function(){    
            $(this).removeClass("over");})   
  $(".tables tr:even").addClass("even");    
  });   

	
/*--------------gotop-----------------
$(document).ready(function(){
	$(window).scroll(function(){
		if ($(this).scrollTop() > 300) {
			$('#toTop').fadeIn();
		} else {
			$('#toTop').fadeOut();
		}
	});
	//Click event to scroll to top
	$('#toTop').click(function(){
		$('html, body').animate({scrollTop : 0},1000);
		return false;
	});
});--*/


/*--------------gotop-------------------*/
$(document).ready(function(){
	//Check to see if the window is top if not then display button
	$(window).scroll(function(){
		if ($(this).scrollTop() > 500) {
			$('#goTop').fadeIn();
		} else {
			$('#goTop').fadeOut();
		}
	});
	//Click event to scroll to top
	$('#goTop').click(function(){
		$('html, body').animate({scrollTop : 0},500);
		return false;
	});
});


