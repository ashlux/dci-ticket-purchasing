	document.write("<h3>");
	Stamp = new Date();
	if (Stamp.getMonth() == 5) {					// Month is June
		var daysleft = 30 - Stamp.getDate() + 7;
		document.write("<CENTER><B>:: " + daysleft + " Days Until Drums of Summer! ::</B><BR></CENTER>");
	} else if ((Stamp.getMonth() == 6) && (Stamp.getDate() < 7)) {	// Month is July 1-7
		var daysleft = 7 - Stamp.getDay();
		document.write("<CENTER><B>:: " + daysleft + " Days Until Drums of Summer! ::</B><BR></CENTER>");
	} else if ((Stamp.getMonth() == 6) && (Stamp.getDate() == 7)) {
		document.write("<CENTER><B>= It's Showtime! =</B><BR></CENTER>");
	}
