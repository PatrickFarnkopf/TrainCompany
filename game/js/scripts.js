/**
* Markieren aller Checkboxen
**/
function check() {
	$('.CheckTrain').attr('checked', $('#mainCheck').is(':checked'));
}

/**
* Hover effekt für die Strecke
**/
function lineClick(text) {
	//*document.getElementById('pathInfo').innerHTML = text;
	//$('#pathInfo').fadeIn(200);
	var i =0;
	while(i<3) {
		document.getElementById('pathInfo').innerHTML = text;
		CenterScreen(document.getElementById('pathInfo'));
		i++;
	}

}

/**
* Springt ins nächste Feld
*/
function JumperInput(In) {
	if (In.value.length < In.getAttribute('maxlength')) return;

	var InputForms = In.form;
	var InputElements = InputForms.elements;

	for (var i=0, InputLength=InputElements.length; i<InputLength; i++) {
		var NextElement;
		var InputElement = InputElements[i];
		if (In == InputElement && (NextElement = InputElements[i+1])) {
			if (NextElement.focus) NextElement.focus();
		}
	}	
}


/**
* Erstellt mittig abhängig von der Browserfenstergröße das DIV
*/
function CenterScreen(div) {
	div.style.left = parseInt((window.innerWidth / 2)-120) + "px";

	div.style.top = parseInt((window.innerHeight / 2)-100) + window.document.documentElement.scrollTop + "px";
	$('#pathInfo').fadeIn(200);
}

/**
* Bahnhöfe auf der Karte beim Klicken Makieren
**/

function addClass(ele,cls) {
    if (!hasClass(ele,cls)) ele.setAttribute("class", ele.getAttribute("class")+" "+cls);
}

function removeClass(ele,cls) {
    if (hasClass(ele,cls)) {
        var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
        ele.setAttribute("class", ele.getAttribute("class").replace(reg,' '));
    }
}

function hasClass(ele,cls) {
    return ele.getAttribute("class").match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}

function marker(evt){
	if(!hasClass(evt.target,'StationSelected'))
	    addClass(evt.target,'StationSelected');
	else
		removeClass(evt.target,'StationSelected'); 
}

/**
* Beim Weiter Senden POST anwenden.
**/

function sendStations(preLink) {
    var station = "";
    var stationsFound = false;
    

    $(' circle').each(function(){

	    cass = $(this).context.getAttribute("class");
	    var isSelected = cass.search(/StationSelected/);
	   
	    if(isSelected != -1) {
	    	
		    i = $(this).context.id;  
		    station = i + "+" + station;
		    stationsFound = true;

		}     
	});   
	
	if(stationsFound) 
		window.document.location.href = preLink+station;
	else
		alert('Bitte wähle mindestens einen Bahnhof aus.');
}


/**
*Tooltip & Strecken Info
**/
$(document).ready(function(){

	/**
	*Tooltip Bahnhöfe
	**/
   $('circle[title]').tooltip({
	    effect: 'slide',
        tip: '#tooltip'
	});

   $('#pathInfo').click(function() {
  $('#pathInfo').fadeOut(200, function() {
   
  });
});




});

/**
* Benachrichtigungen
**/

function removeNotific(id) {
	$('#notificationID'+id).hide("slow");
	window.setTimeout("$('#notificationID"+id+"').remove()", 1000);
	
	var request = new XMLHttpRequest();
	request.open('post', notificationDeleteLink+id, true);
	request.send(null);
}


function notific(id,dateString,title,text,plopsAdd,plopsSub,delayTimeInt,delayTimeString,first) {
	divHTML = '<div id="notificationID'+id+'" class="Notification">'
			+'<div class="SubjectString">'+title
			+'<div>'+dateString+'</div>'
			+'</div>'
			+'<a href="javascript:removeNotific('+id+')" class="NotificationClose"><img src="img/close.png" alt="Schließen" title="Schließen"></a>'
			+'<div class="Clear"></div>'
			+text;
	if(plopsAdd != '0' || plopsSub != '0' || delayTimeInt != '0') {
		divHTML = divHTML
				+ '<p>';
		if (plopsAdd != '0') {
			divHTML = divHTML
					+ '<img src="img/icons/money_add.png" alt="Plops hinzugekommen" title="Plops hinzugekommen"> '
					+ '<span class="Green">'+plopsAdd+'</span>';
		}
		if (plopsSub != '0') {
			divHTML = divHTML
					+ ' <img src="img/icons/money_delete.png" alt="Plops abgezogen" title="Plops abgezogen"> '
					+ '<span class="Red">'+plopsSub+'</span>';
		}
		if(delayTimeInt != '0') {
			color = 'Green';
			if(delayTimeInt > 300)
				color = 'Red';
			
			divHTML = divHTML
					+ ' <img src="img/icons/clock_red.png" alt="Verspätung" title="Verspätung"> '
					+ '<span class="'+color+'">+'+delayTimeString+'</span>';
		}
		divHTML = divHTML
				+ '</p>';
	}			
	divHTML = divHTML
			+'</div>';
	if(first)		
		$(divHTML).appendTo('#topBlock').hide().fadeIn(1500);
	else
		$(divHTML).appendTo('#topBlock');
}
