function getmap(addy, zip) {
	document.write('(<a href="');
	document.write('http://www.mapquest.com/maps/map.adp?country=US&countryid=250&addtohistory=&address=' + addy + '&city=Broken+Arrow&state=OK&zipcode=' + zip + '&submit=Get+Map');
	document.write('" target="_new">map</a>)');
};