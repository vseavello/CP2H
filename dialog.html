<!DOCTYPE html>
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0" />
	<title>Facebook Photos</title>

	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script src="http://www.google.com/jsapi"></script>

	<script src="scripts/jqdump.js"></script>
	<script src="scripts/dateFormat.js"></script>

	<!--[if lt ID 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</HEAD>
<BODY>

<style>
body {
	background-image: url(images/logo_large.png);
}
.pic-dialog {
  position: relative;
  background: rgba(0,0,0, 0.8);
  padding: 0;
  margin: 0;
}
.pic-dialog .ui-widget-header {
  border: none;
  background: transparent;
}
.pic {
  position: absolute;
  display: inline-block;
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  background-color: green;
  overflow: hidden;
}
#size-btn {
	position: absolute;
	top: 80px;
	right: 10px;
}
#change-btn {
	position: absolute;
	top: 45px;
	right: 10px;
}
#pic-btn {
	position: absolute;
	top: 10px;
	right: 10px;
}
#thepic {
  margin: 0;
  padding: 0;
  opacity: 1 !important
}
</style>

<div id="my-dialog">
	<div id='thepicdiv' class='pic'>
		<img id='thepic' src='images/steph_large.jpg'>
	</div>
	<button id='pic-btn' onclick="$('#thepic').toggle();">click</button>
	<button id='size-btn' onclick="showSizes();">sizes</button>
	<button id='change-btn' onclick="changePic();">change</button>
	<div id='notpicdiv'></div>
	<div id='notpicdiv2'></div>
</div>



<script>
var wwidth = $(window).width();
var wheight = $(window).height();
var divheight = 0;
var divwidth = 0;
var pdivheight = 0;
var pdivwidth = 0;
var picheight = 0;
var picwidth = 0;
function changePic()
{
	var src = $("#thepic").attr("src");
	if (src.substr(7) === "steph_large.jpg")
		$("#thepic").attr("src", "images/RebeccaSnyders_large.jpg");
	else if (src.substr(7) === "RebeccaSnyders_large.jpg")
		$("#thepic").attr("src", "images/board2_full.jpg");
	else
		$("#thepic").attr("src", "images/steph_large.jpg");
}
function showSizes()
{
	alert("window width: " + wwidth + ", height: " + wheight + "\ndiv width: " + divwidth + ", height: " + divheight + "\n3/4 div width: " + pdivwidth + ", full div height: " + pdivheight + "\npic width: " + picwidth + ", height: " + picheight);
}
$(document).ready(function() {
	$("#my-dialog").dialog({
	  modal: true,
	  dialogClass: "pic-dialog",
	  width: (Math.ceil($(window).width() * .9)),
	  height: (Math.ceil($(window).height()* .9))
	});

	divwidth = $("#thepicdiv").width();
	divheight = $("#thepicdiv").height();
	pdivheight = divheight;
	pdivwidth = Math.ceil((divwidth * .75));

	picwidth = $("#thepic").width();
	picheight = $("#thepic").height();

	// scale pic to div with aspect ratio
	// is landscape
	if (picwidth >= pdivheight)
	{
		// pic taller than div
		if (picheight > pdivheight)
		{
			// scale on height
			$("#thepic").css("height", pdivheight);
		}
		else
		{
			// scale on width
			$("#thepic").css("width", pdivwidth);
		}
	}
	else // portrait
	{
		// pic wider than div
		if (picwidth > pdivwidth)
		{
			// scale on width
			$("#thepic").css("width", pdivwidth);
		}
		else
		{
			// scale on height
			$("#thepic").css("height", pdivheight);
		}
	}

	picwidth = $("#thepic").width();
	picheight = $("#thepic").height();
});
</script>
</BODY>
</HTML>
