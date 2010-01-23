<!--


Xoffset = 1;
Yoffset = 5;

//KTB added 5/1 for nn6 compatibility*******
var dom = (document.getElementById) ? true:false;
//*******************************************
var nav,old,iex=(document.all),yyy=-1000;
var nav = (navigator.appName=="Netscape");
var old = (nav && !document.layers && !dom);



if(!old){
 var skn=(nav && !dom)?document.dek:document.getElementById("dek").style;
 if(nav){
		document.captureEvents(Event.MOUSEMOVE);
	}
	document.onmousemove=get_mouse;
}

function popupfor(msg1,msg2,msg3,msg4) {
	var content="<TABLE CELLPADDING=0 CELLSPACING=0 width='200' bgcolor='whitesmoke' style='border:solid 1 #808080'><tr>" +
					"<TD ALIGN=center>"+
					"<table  border=0 cellspacing=0 cellpadding=0>"+
					"<tr>"+
						"<td><font face=verdana,arial,helvetica size=1><strong>" + msg1 +"</strong></font></td>"+
					"</tr><tr>"+
						"<td><font face=verdana,arial,helvetica size=1>Tickets available: "+ msg3 +"</font></td>"+
					"</tr></table>"+
					"</TD>"+
				"</tr></TABLE>";

	if(old)return;
	
		 yyy=Yoffset;
		 if(nav && !dom){skn.document.write(content);skn.document.close();skn.visibility="visible"}
		 if(iex || dom){
		 	document.getElementById("dek").innerHTML=content;skn.visibility="visible"
		}
	 

}

function popupthree(msg1,msg2,msg3) {
	var content="<TABLE CELLPADDING=0 CELLSPACING=0><tr>"+
					"<TD ALIGN=center>"+
					"<table width=100% border=0 cellspacing=0 cellpadding=0>"+
					"<tr>"+
						"<td align=center colspan=3><font face=verdana,arial,helvetica><b><font>" + msg1 + "</font></b></font></td>"+
					"</tr><tr>"+
						"<td width=20%></td><td width=20% align=right><font face=verdana,arial,helvetica size=2>"+msg2+"</font></td>"+
						"<td width=60%><font face=verdana,arial,helvetica size=2>&nbsp;Seats</font></td>"+
					"</tr><tr>"+
						"<td width=25%></td>"+
						"<td width=25% align=right><font face=verdana,arial,helvetica size=2>"+msg3+"</font></td>"+
						"<td width=50%><font face=verdana,arial,helvetica>&nbsp;Tickets available</font></td>"+
					"</tr></TABLE>";

	if(old)return;
	
	yyy=Yoffset;
	if(nav && !dom){skn.document.write(content);skn.document.close();skn.visibility="visible"}
	if(iex || dom){document.getElementById("dek").innerHTML=content;skn.visibility="visible"}
	

}

function popupsingle(msg1) {
	var content=
		"<TABLE BORDER=0 CELLPADDING=7 CELLSPACING=0 width='150' bgcolor='whitesmoke' style='border:solid 1 #808080'><tr>" +
			"<TD ALIGN=left><font size=1 color=#000000 face=verdana,arial,helvetica>" + msg1 +"</font></TD>" + 
		"</tr></TABLE>";

	if(old)return;
	
		yyy=Yoffset;
		if(nav && !dom){skn.document.write(content);skn.document.close();skn.visibility="visible"}
		if(iex || dom){document.getElementById("dek").innerHTML=content;skn.visibility="visible"}
 

}

function get_mouse(e) {
 
 var x=(nav)?e.pageX:event.x+document.body.scrollLeft;
  skn.left=x+Xoffset;
 var y=(nav)?e.pageY:event.y+document.body.scrollTop;
  skn.top=y+yyy;

 

}

function kill(){
 if(!old){yyy=-1000;skn.visibility="hidden";}
}

//-->