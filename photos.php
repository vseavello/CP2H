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

	<link rel="stylesheet" type="text/css" href="css/styles.css" />
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/layout_small.css" media="only screen and (min-width:50px) and (max-width:500px)" />
	<link rel="stylesheet" type="text/css" href="css/layout_medium.css" media="only screen and (min-width:501px) and (max-width:800px)" />

	<!--[if lt ID 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</HEAD>
<BODY>

<style>
.album_container {
	text-align: center;
	width: 250px;
	height: 250px;
	margin: 15px 15px 50px 15px;
	display: block;
	float: left;
	border: 1px solid cyan;
}
.albumcover {
	position: relative;
	width: 250px;
	height: 250px;
	overflow: hidden;
	border: 1px none cyan;
}
.albumcover img {
	position: absolute;
	right: 0;
}
.albuminfo {
}
.albumphoto_container {
	text-align: center;
	width: 250px;
	height: 250px;
	margin: 15px 15px 50px 15px;
	display: block;
	float: left;
	border: 1px solid cyan;
}
.albumphoto {
	position: relative;
	width: 250px;
	height: 250px;
	overflow: hidden;
	border: 1px none cyan;
}
.albumphotoimg img {
	position: absolute;
	right: 0;
}
.clear-fix {
	clear: both;
}

.photoframe h3 { font-size: 1.1em; margin: 0; }
.photoframe p { line-height: 1.3em; font-size: 1.0em; margin-bottom: .5em;}

.photoframe_container {margin: 15px 0 0 15px;}
.photoframe_container .photoframe .content {margin: 0 30px 0 70px;}
</style>

<myscreen>this is a crumb to help determine screen media layout style</myscreen>
<div class=page>
	<header>
		<a class="logo" href="#"></a>
	</header>

	<article>
		<h1 id='albumTitle'></h1>

		<div id="pics"></div>
	</article>
	<nav>
		<a href="index.html">home</a>
		<a href="ourstory.html">about us</a>
		<a href="news.html">news</a>
		<a href="services.html">services</a>
		<a href="donate.html">donate</a>
		<a href="photos.html">photos</a>
	</nav>
	<footer>
		&copy; A Child's Passport To Health
	</footer>
</div>

<script>
var albums;
var albumphotos = new Object;
var albumphotosinfo = new Object;
var albumidx = -1;
var albumphotoidx = -1;

// generated 2016-09-20 - expires in 60 days
var pageid = "1687150331514073";
var accesstoken = "EAAIlZAx7c9gkBAOEWqnT6hVRrURKiChvl88OFCzVoaTHUk7CmU9LoKWXDf8USW6cFDfsf1qZCRs2MH8ZBrEtfCZAU6prCoXuVD7HK862dZBcLslFFByYkno0woYBbFgfdHzuiqYCVKZAaGnZCJJzPbNSnXZBczhJGFQZD";
var expires = "5184000";

var phototagfields = "id,name,created_time";
var photofields = "id,album,name,name_tags,place,backdated_time,created_time,event";
var photoinfofields = "album,height,width,name,images,page_story_id,picture";
var albumphotofields ="id,album,name,updated_time,height,width,images,page_story_id,picture,source";
// set the limit to 50 for now. It's a kludge!
var albumfields = "name,cover_photo,count,description,type,picture,photos.limit(50){place,"+albumphotofields+",tags.limit(50){"+phototagfields+"}}";
var fql = "SELECT status_id, time, source, message FROM status where uid = " + pageid;

function calculateAspectRatioFit(srcWidth, srcHeight, maxWidth, maxHeight) {
    var width = srcWidth;
    var height = srcHeight;
    var ratioW = maxWidth / width;  // Width ratio
    var ratioH = maxHeight / height;  // Height ratio
    
    /*
     * adjusted height = <user-chosen width> * original height / original width
     * adjusted width = <user-chosen height> * original width / original height
     */
    if(width > height) {
    	width = maxWidth;
    	height = width * srcHeight/srcWidth;
    }
    else {
    	height = maxHeight;
    	width = height * srcWidth/srcHeight;
    }
    return {width: width, height: height};
}

function format_albumphoto_page()
{

	//alert("format_albumphoto_page");
	html  = "<a href='javascript:void(0);' onclick='display_albumphotos();'>Go Back To Photos</a><BR>\n";
	html += "<div class='photoframe_container'>\n";
	html += "<div class='photoframe'>\n";
	html += "<div class='content'>\n";
	html += "<H1 class='title'></H1>\n";
	html += "<p></p>\n";
	html += "</div>\n";
	html += "</div>\n";
	html += "</div>\n";
	$("#pics").html(html);
}

function display_albumphoto(pidx)
{
	$("#albumTitle").html(albums[albumidx].name);
	//window.scrollTo(0,0);
	var photoframe_content = "";

	if (pidx >= 0 && pidx < albumphotos.length)
		albumphotoidx = pidx;
	else if (pidx == -2)
	{
		albumphotoidx--;
		if (albumphotoidx < 0)
			albumphotoidx = (albumphotos.length - 1);
	}
	else
	{
		albumphotoidx++;
		if (albumphotoidx >= albumphotos.length)
			albumphotoidx = 0;
	}
	
	if (!$("#photoframe_container").length)
	{
		format_albumphoto_page();
	}

	if (albumphotos[albumphotoidx])
	{
		// get the original picture dimensions
		var picwidth = albumphotos[albumphotoidx].width;
		var picheight = albumphotos[albumphotoidx].height;

		photoframe_content += "<button id='prev-btn' onclick='display_albumphoto(-2);'>previous</button>&nbsp;<button id='next-btn' onclick='display_albumphoto(-1);'>next</button><BR>\n";
		if (albums[albumidx].count) photoframe_content += "<p>Image: " + (albumphotoidx + 1) + " of " + albums[albumidx].count + "</p>\n";
		if (albums[albumidx].description) photoframe_content += "<p>" + albums[albumidx].description.replace(/\n/g, "<BR><BR>") + "</p>\n";
		if (albumphotos[albumphotoidx].place) photoframe_content += "<p>Place: " + albumphotos[albumphotoidx].place.name + "</p>\n";
		if (albumphotos[albumphotoidx].tags &&
		    albumphotos[albumphotoidx].tags.data &&
		    albumphotos[albumphotoidx].tags.data.length > 0)
		{
			photoframe_content += "<p>Includes: ";
			$(albumphotos[albumphotoidx].tags.data).each(function(tidx, tag) {
				if (tidx > 0)
					photoframe_content += ", ";
				photoframe_content += tag.name;
			});
			photoframe_content += "</p>\n";
		}
		if (albumphotos[albumphotoidx].name)
		{
			photoframe_content += "Photo name: " + albumphotos[albumphotoidx].name.replace(/\n/g, "<BR><BR>");
		}

		var thisimg = "";
		var thiswidth = 0;
		var thisheight = 0;
		var thisidx = 0;
		var maxwidth = 0;
		if ($("myscreen").width() == 3)
			maxwidth = 300;
		else if ($("myscreen").width() == 2)
			maxwidth = 400;
		else
			maxwidth = 500;
		$(albumphotos[albumphotoidx].images).each(function(iidx, iobj) {

			if (thiswidth < iobj.width && iobj.width < maxwidth)
			{
				thiswidth = iobj.width;
				thisheight = iobj.height;
				thisimg = iobj.source;
				thisidx = iidx;
			}
		});

		// add the original picture
		$(".photoframe").css('background-image', 'url(' + thisimg + ')');
		$(".photoframe_container .photoframe .content").css('margin', "0 0 0 "+(thiswidth + 15)+"px");
		$(".photoframe").width(thiswidth);
		$(".photoframe").height(thisheight);
		$(".photoframe .content").css("width", "335px");
		$(".photoframe .content").css("right", "10px");
		$(".photoframe .content").css("position", "absolute");
		$(".photoframe .content p").html(photoframe_content);
	}
	else
	{
		$("#albumphoto_desc").append("<PRE>No Photo Info Available.</PRE>");
		$("#albumphoto_desc").append("<PRE>"+$.dump(albumphotos[albumphotoidx].place)+"</PRE>");
	}

}

function display_albumphotos()
{
	$("#albumTitle").html("Photos for " + albums[albumidx].name);
	$("#pics").html("");
	//window.scrollTo(0,0);
	html = "<a href='javascript:void(0);' onclick='display_albums();'>Go Back To Albums</a><BR>\n";
	html += "<div class='albumphotos_container'>\n";
	$(albumphotos).each(function(pidx, pobj) {

		var albumphotoid = pobj.id;
		var thiswidth = 0;
		var thisheight = 0;
		var thisimg = "";
		var thisidx = -1;
		for (img in pobj.images)
		{
			if (pobj.images[img].height > 250 &&
			    pobj.images[img].width > 250)
			{
			    if (thiswidth > pobj.images[img].width ||
				thisheight > pobj.images[img].height ||
				thisimg.length == 0)
				{
					thiswidth = pobj.images[img].width;
					thisheight = pobj.images[img].height;
					thisimg = pobj.images[img].source;
					thisidx = img;
				}
			}
		}
		if (thisidx < 0)
		{
			thisimg = pobj.images[0].source;
			thiswidth = pobj.images[0].width;
			thisheight = pobj.images[0].height;
		}

		var albumphotoid = pobj.id;

		html += "<div class='albumphoto_container'>\n";
		if (pobj.source)
		{
			html += "<div class='albumphoto'>\n";
			html += "<a href='javascript:void(0);' onclick='display_albumphoto("+pidx+");'><img class='albumphotoimg' id='ap_"+albumphotoid+"' src='"+thisimg+"'></a>\n";
			html += "</div>\n";
		}
		html += "<div class='albumphotoinfo'>\n";
		html += "</div>\n";
		html += "</div>\n";
	});
	html += "<div class='clear-fix'></div>\n";
	html += "</div>\n";
	html += "<a href='javascript:void(0);' onclick='display_albums();'>Go Back To Albums</a>\n";
	$("#pics").append(html);
}

function display_albums()
{
	$("#albumTitle").html("Photo Albums");
	$("#pics").html("");
	//window.scrollTo(0,0);
	html = "<div class='albums_container'>\n";
	$(albums).each(function(aidx, aobj) {
		var albumid = aobj.id;
		if (aobj.cover_photo)
			var coverphotoid = aobj.cover_photo.id;
		var count = aobj.count;
		var name = aobj.name;
		if (count > 0)
		{
			html += "<div class='album_container'>\n";
			if (aobj.cover_photo)
			{
				var thisimg = '';
				var coverphotoid = aobj.cover_photo.id;
				$(aobj.photos.data).each(function(pidx, pobj) {
					if (pobj.id == coverphotoid)
					{
						var images = pobj.images;
						var thiswidth = 0;
						var thisheight = 0;
						var thisidx = -1;
						for (img in pobj.images)
						{
							if (pobj.images[img].height > 250 &&
							    pobj.images[img].width > 250)
							{
							    if (thiswidth > pobj.images[img].width ||
								thisheight > pobj.images[img].height ||
								thisimg.length == 0)
								{
									thiswidth = pobj.images[img].width;
									thisheight = pobj.images[img].height;
									thisimg = pobj.images[img].source;
									thisidx = img;
								}
							}
						}
						if (thisidx < 0)
						{
							thisimg = pobj.images[(pobj.images.length - 1)].source;
						}
					}
				});

				html += "<div class='albumcover'>\n";
				html += "<a href='javascript:void(0);' onclick='getAlbumPhotos("+aidx+");'><img class='coverphoto' id='"+coverphotoid+"' src='"+thisimg+"'></a>\n";
				html += "</div>\n";
			}
			html += "<div class='albuminfo'>\n";
			html += name + "<BR>\n";
			html += count + " photos\n";
			html += "</div>\n";
			html += "</div>\n";
		}
	});
	html += "<div class='clear-fix'></div>\n";
	html += "</div>\n";
	$("#pics").append(html);
}

// query facebook for list of photos for the specified album id
function getAlbumPhotos(aidx)
{
	albumphotos = albums[aidx].photos.data;
	albumidx = aidx;
	albumphotoidx = -1;

	display_albumphotos();
	return false;
}


// query facebook for the list of albums
function getAlbums()
{

	var opts = {fields: albumfields, expires: expires, access_token: accesstoken};
	var url = "https://graph.facebook.com/"+pageid+"/albums";
	var optstr = "";
	for(opt in opts)
	{
		if (optstr.length > 0)
			optstr += "&";
		optstr += opt + "=" + opts[opt];
	}

	$.ajax({
		url: url,
		data: opts,
                type: "GET",
		crossDomain: true,
		async: false,
                dataType: "jsonp"
         })
        .done(function( data ) {
		if (data.data) {
			albums = data.data;

			display_albums();
			return true;
		}
		else if (data.error) alert("getAlbums: error message: " + data.error.message);
		else alert("getAlbums: error message: Unknown error.");
        })
        .error(function(jqXHR, msg, err) {
                alert("getAlbums: msg: " + msg + ", err: " + err);
        });
	return false;
}

$(document).ready(function() {
	$.support.cors = true;
	getAlbums();
});
</script>
</BODY>
</HTML>
