function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function view_ans(num) {
	for(i=1;i<20;i++){
		if (document.getElementById("ans"+i)){
		document.getElementById("ans"+i).style.display = "none";}
	}
	$("#menuarea a").toggleClass("");
	document.getElementById("ans" + num).style.display = "block";
} 

function close_ans(num) {
	document.getElementById("ans" + num).style.display = "none";
}

function view_track(num) { 
	document.getElementById("div" + num).style.display = "block"; 
}

function close_track(num) {
	document.getElementById("div" + num).style.display = "none";
}

//檢查是否為日期格式
function checkDate(str) {
  var t = Date.parse(str);
  if(isNaN(t)) {
    return true ;
  }
}

//日期相差
Date.prototype.dateDiff = function(interval,objDate){
	var dtEnd = new Date(objDate);
	if(isNaN(dtEnd)) return undefined;
	switch (interval) {
	case "s":return parseInt((dtEnd - this) / 1000);
	case "n":return parseInt((dtEnd - this) / 60000);
	case "h":return parseInt((dtEnd - this) / 3600000);
	case "d":return parseInt((dtEnd - this) / 86400000);
	case "w":return parseInt((dtEnd - this) / (86400000 * 7));
	case "m":return (dtEnd.getMonth()+1)+((dtEnd.getFullYear()-this.getFullYear())*12) - (this.getMonth()+1);
	case "y":return dtEnd.getFullYear() - this.getFullYear();
	}
}

//帶參數轉向用
function Update(strLink,PKey){
    document.form1.PKey.value=PKey;
    document.form1.action= strLink;
    document.form1.submit();
 }
 
function GotoPage(tPage,theForm){
	theForm.Page.value=tPage;
	theForm.Send.value ="搜尋";
	theForm.submit();
}