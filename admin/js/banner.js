// JavaScript Document
function check()
{
	var cond=true;
	if(document.banner.bannertitle.value.length==0)
	{
		alert("Please Enter Banner Title.");
		if(cond==true)
		{
			document.banner.bannertitle.focus();
		}
		cond=false;
		return false;
	}	
	if(document.banner.url.value.length==0)
	{
		alert("Please Enter URL.");
		if(cond==true)
		{
			document.banner.url.focus();
		}
		cond=false;
		return false;
	}
	//if(document.banner.parentId.value==0)
//	{
//		alert("Please Select Category.");
//		if(cond==true)
//		{
//			document.banner.parentId.focus();
//		}
//		cond=false;
//		return false;
//	}
	if(document.banner.exipiredate.value.length==0)
	{
		alert("Please Enter Exipire Date.");
		if(cond==true)
		{
			document.banner.exipiredate.focus();
		}
		cond=false;
		return false;
	}
}