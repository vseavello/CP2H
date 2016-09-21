<!DOCTYPE html>
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0" />
	<title>A Childs Passport To Health</title>

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
<div class=page>
	<header>
		<a class="logo" href="#"></a>
	</header>

	<article>
	<h1>A Child's Passport To Health</h1>
	<h2>News</h2>

	<div>
	  <div>
		<div id="posts"></div>
	  </div>
	</div>

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
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

function getCP2HPosts()
{
	var pageid = "1687150331514073";
	var accesstoken = "EAAIlZAx7c9gkBAOEWqnT6hVRrURKiChvl88OFCzVoaTHUk7CmU9LoKWXDf8USW6cFDfsf1qZCRs2MH8ZBrEtfCZAU6prCoXuVD7HK862dZBcLslFFByYkno0woYBbFgfdHzuiqYCVKZAaGnZCJJzPbNSnXZBczhJGFQZD";
	var expires = "5184000";

	fields="id,name,message,story,updated_time,type,status_type,link,picture";

	url   = "https://graph.facebook.com/" + pageid + "/feed";
	url  += "?access_token=" + accesstoken;
	url  += "&expires=" + expires;
	url  += "&fields=" + fields;

	$.ajax({
                url: url,
                type: "GET",
                dataType: "json"
         })
        .done(function( data ) {
		var html = "no data.";
		if (data)
		{
			html = "<div class='news'>\n";
			$(data).each(function(idx, dobj) {
				{
					if (idx > 0)
						html += "<HR>\n";
					if (dobj.updated_time)
					{
						var mydt = dobj.updated_time.substr(0, dobj.updated_time.indexOf('+'));
						var dt = new Date(mydt);
						html += "<span class='postdate'>Posted: " + dt.toString() + "</span>\n";
					}
					else if (dobj.created_time)
					{
						var mydt = dobj.created_time.substr(0, dobj.created_time.indexOf('+'));
						var dt = new Date(mydt);
						html += "<span class='postdate'>Posted: " + dt.toString() + "</span>\n";
					}
					if (dobj.story)
						html += "<div apptype='story'><p class='newstitle'>" + dobj.story + "</p></div>\n";
					else
						html += "<BR>\n";
					if (dobj.link && (dobj.type == "photo" || dobj.type == "link"))
					{
						if (dobj.picture && dobj.status_type !== "shared_story")
							picture = "<img src='"+dobj.picture+"'>";
						else if (dobj.name)
							picture = dobj.name;
						else
							picture = "picture link";
						html += "<div apptype='photo'><a target='_blank' href='"+dobj.link+"'>" + picture + "</a></div>\n";
					}
					if (dobj.description)
					{
						var desc = dobj.description.replaceAll('\\n', '<BR>');
						html += "<div apptype='description'><p>" + desc + "</p></div>\n";
					}
					if (dobj.message)
					{
						var msg = dobj.message.replaceAll('\\n', '<BR>');
						html += "<div apptype='message'><p>" + msg + "</p></div>\n";
					}
					if (dobj.source)
						html += "<div apptype='source'><a href='"+dobj.source+"'>" + dobj.source + "</a></div>\n";
					html += "<BR>\n";
				}
			});
			html += "</div>\n";
		}
		else if (data.error)
		{
			html = "message: " + data.error.message + "<BR>\n";
		}
		else
		{
			html = "Unknown error. Can't access posts.<BR>\n";
		}
		$("#posts").append(html);
        })
        .error(function(jqXHR, msg, err) {
                $("#posts").append("getCP2HPosts: <PRE>" + $.dump(msg) + ", " + $.dump(err) + "</PRE>");
                return false;
        });
	return false;
}

$(document).ready(function() {
	getCP2HPosts();
});
</script>
</BODY>
</HTML>
