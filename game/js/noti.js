GetNotification(); 


function GetNotification() {
	$.ajax({
		url: notificationListLink,
		success: function(data) {
			var XMLid = $(data).find("id").text();
			var XMdate = $(data).find("date").text();
			var XMLtitle = $(data).find("title").text();
			var XMLtext = $(data).find("text").text();
			var XMLplopsAdd = $(data).find("plopsAdd").text();
			var XMLplopsSub = $(data).find("plopsSub").text();
			var XMLdelayTimeInt = $(data).find("delayTimeInt").text();
			var XMLdelayTimeString = $(data).find("delayTimeString").text();

			if(XMLid != "")
				notific(XMLid,XMdate,XMLtitle,XMLtext,XMLplopsAdd,XMLplopsSub,XMLdelayTimeInt,XMLdelayTimeString,true);
		}
	});
	window.setTimeout("GetNotification()", 2000);
}