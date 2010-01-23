<?

/*****************************************************
 *****************************************************
 *
 * This is seriously bad code. Don't use it!
 *
 *****************************************************
 *****************************************************/

ECHO "

  <P><a href='logout.php'>Logout</a><BR>
  <a href='account.php'>Your Account</a><BR>
  <a href='showStadium.php'>Show Stadium</a><BR>
  <a href='checkout.php'>Checkout</a><BR>
  <a href='checkout.php'>View Cart</a><BR>

  <MAP NAME='SeatingMap'>
  <AREA SHAPE=RECT COORDS='104,8,189,168' HREF='general.php'>
  <AREA SHAPE=RECT COORDS='192,8,277,78' HREF='seatSelector.php?XLEFT=0&XRIGHT=22&YTOP=40&YBOTTOM=18&YEAR=2005&TITLE=Upper-Left Reserve Seats'>
  <AREA SHAPE=RECT COORDS='192,79,278,134' HREF='seatSelector.php?XLEFT=0&XRIGHT=22&YTOP=18&YBOTTOM=4&YEAR=2005&TITLE=Lower-Left Reserve Seats'>
  <AREA SHAPE=RECT COORDS='280,8,364,78' HREF='seatSelector.php?XLEFT=17&XRIGHT=49&YTOP=40&YBOTTOM=18&YEAR=2005&TITLE=Upper Premium Seats'>
  <AREA SHAPE=RECT COORDS='280,79,364,134' HREF='seatSelector.php?XLEFT=17&XRIGHT=49&YTOP=18&YBOTTOM=4&YEAR=2005&TITLE=Lower Premium Seats'>
  <AREA SHAPE=RECT COORDS='368,8,453,78' HREF='seatSelector.php?XLEFT=44&XRIGHT=66&YTOP=40&YBOTTOM=18&YEAR=2005&TITLE=Upper-Right Reserve Seats'>
  <AREA SHAPE=RECT COORDS='368,79,454,134' HREF='seatSelector.php?XLEFT=44&XRIGHT=66&YTOP=18&YBOTTOM=4&YEAR=2005&TITLE=Lower-Right Reserve Seats'>
  <AREA SHAPE=RECT COORDS='456,8,541,168' HREF='general.php'>
  <AREA SHAPE=RECT COORDS='192,138,279,168' HREF='seatSelector.php?XLEFT=0&XRIGHT=28&YTOP=8&YBOTTOM=0&YEAR=2005&TITLE=Left Blast Zone Seats'>
  <AREA SHAPE=RECT COORDS='280,138,366,168' HREF='seatSelector.php?XLEFT=22&XRIGHT=44&YTOP=8&YBOTTOM=0&YEAR=2005&TITLE=Center Blast Zone Seats'>
  <AREA SHAPE=RECT COORDS='367,138,453,168' HREF='seatSelector.php?XLEFT=38&XRIGHT=66&YTOP=8&YBOTTOM=0&YEAR=2005&TITLE=Right Blast Zone Seats'>
  </MAP>
  <P><IMG SRC='http://www.drumsofsummer.com/img/seating.gif' WIDTH=648 HEIGHT=300 USEMAP='#SeatingMap' ALT='Seating Map'BORDER=1>

  <P><a href='seatSelector.php?XLEFT=17&XRIGHT=49&YTOP=40&YBOTTOM=18&YEAR=2005'>Buy Premium Seats [Upper]<BR>
  <a href='seatSelector.php?XLEFT=17&XRIGHT=49&YTOP=18&YBOTTOM=4&YEAR=2005'>Buy Premium Seats [Lower]<BR>
  <a href='seatSelector.php?XLEFT=0&XRIGHT=22&YTOP=40&YBOTTOM=18&YEAR=2005'>Buy Reserve Seats [Left Upper]<BR>
  <a href='seatSelector.php?XLEFT=0&XRIGHT=22&YTOP=18&YBOTTOM=4&YEAR=2005'>Buy Reserve Seats [Left Lower]<BR>
  <a href='seatSelector.php?XLEFT=44&XRIGHT=66&YTOP=40&YBOTTOM=18&YEAR=2005'>Buy Reserve Seats [Right Upper]<BR>
  <a href='seatSelector.php?XLEFT=44&XRIGHT=66&YTOP=18&YBOTTOM=4&YEAR=2005'>Buy Reserve Seats [Right Lower]<BR>
  <a href='seatSelector.php?XLEFT=0&XRIGHT=28&YTOP=8&YBOTTOM=0&YEAR=2005'>Buy 'Blast' Zone Seats [Left]<BR>
  <a href='seatSelector.php?XLEFT=22&XRIGHT=44&YTOP=8&YBOTTOM=0&YEAR=2005'>Buy 'Blast' Zone Seats [Center]<BR>
  <a href='seatSelector.php?XLEFT=38&XRIGHT=66&YTOP=8&YBOTTOM=0&YEAR=2005'>Buy 'Blast' Zone Seats [Right]</a><BR>
  <a href='general.php'>Buy General Admission Seats</a><BR>

";

?>