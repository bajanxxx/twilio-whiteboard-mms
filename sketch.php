<?php
	if( !defined('READY') ){
		die("Please do not call this file directly");
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en"> 
  <head> 
    <meta charset="utf-8"> 
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	
<!--
	<meta name="viewport" content="width=device-width, user-scalable=no" /> 
	<meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
	<meta name="viewport" content="width=device-width" />

-->
	<meta id="extViewportMeta" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>sketchpad</title> 
	<link href="<?= $siteurl ?>/assets/bootstrap.css" rel="stylesheet">
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	
	<script src="<?= $siteurl ?>/assets/sweet-alert.js"></script>
	<link rel="stylesheet" href="<?= $siteurl ?>/assets/sweet-alert.css">

	<!--[if IE]>
	<script src="<?= $siteurl ?>/assets/excanvas.js"></script>
	<![endif]-->
	<script src="<?= $siteurl ?>/assets/fa.js" type="text/javascript"></script>
	<script src="<?= $siteurl ?>/assets/base64.js" type="text/javascript"></script>
	<script src="<?= $siteurl ?>/assets/canvas2image.js" type="text/javascript"></script>
	<script src="<?= $siteurl ?>/assets/app.js" type="text/javascript"></script>
	<link type="text/css" rel="stylesheet" href="<?= $siteurl ?>/assets/twilio.css"/>
	<link href="<?= $siteurl ?>/assets/app.css" rel="stylesheet">			
</head> 
<body  class="twilio" style="padding:5px;">
	<header id="topbar" style="padding-left:10px;">
		<a href="http://twilio.com" class="logo">twilio</a>
	</header>
	<table class="table-condensed" width=100%>
	<tr>
		<td valign="top" width="80%" id="canvastd" style="background:none #2b2627;">
			<canvas id="sketchpad" width="666" height="604" style="margin: 15px;border:1px solid #000;"> 
		        Sorry, your browser is not supported.
		      </canvas>		
		</td>
		<td valign="top" width="20%" style="padding:5px;padding-top:5px;" id="controlpad">
			<div id="textdownload" style="display:none;font-style:italic;">
				Now you can right click and download the image<br/>
				<button type="button" class="btn btn-default btn-large"  id="resetbtn" value="Reset">
			</div>
			<div id="buttoncontainer" style="display:block;">
				<button class="btn btn-sm btn-default" style="display:none;" type="button" id="savepngbtn">Save</button>
				<button class="btn btn-sm btn-default" style="display:none;" type="button" id="convertpngbtn">Convert to PNG</button>
			</div>
			<table class="table-condensed" width=80% cellpadding=0 cellspacing=0>
			<tr>
				<td id="size-select" class="subbar-group">
					<table width=100%>
					<tr>
						<td>
							<button type="button" id="small" class="sbbtn btn btn-default active" style="height:45px;width:50px;padding:5px;">
								<i class="fa fa-circle"></i>
							</button>
						</td>
						<td>
							<button type="button" id="normal" class="sbbtn btn btn-default" style="width:50px;height:45px;padding:5px;">
								<i class="fa fa-circle fa-lg"></i>
							</button>
						</td>
						<td>
							<button type="button" id="large" class="sbbtn btn btn-default" style="width:50px;height:45px;padding:5px;">
								<i class="fa fa-circle fa-2x"></i>
							</button>
						</td>
						<td>
							<button type="button" id="huge" class="sbbtn btn btn-default" style="width:50px;height:45px;padding:5px;">
								<i class="fa fa-circle fa-3x"></i>
							</button>
						</td>
					</tr>
					<tr>
						<td colspan=4>
							<br />
						</td>
					</tr>
					<tr>
						<td>
							<button type="button" id="428ace" class="clrbtn btn blue-select" style="padding:5px;background:#428ace;width:50px;"><div><label></label></div></button>
						</td>
						<td>
							<button type="button" id="5cb65c" class="clrbtn btn green-select" style="padding:5px;background:#5cb65c;width:50px;"><div><label></label></div></button>
						</td>
						<td>
							<button type="button" id="c60505" class="clrbtn btn red-select" style="padding:5px;background:#c60505;width:50px;"><div><label></label></div></button>
						</td>
						<td>
							<button type="button" id="111111" class="clrbtn btn btn-primary active" style="padding:5px;background:#111111;;width:50px;"><div><label></label></div></button>
						</td>
					</tr>
					<tr>
						<td colspan=4>
							<br />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<button type="button" id="ffffff" class="clrbtn btn btn-default"  style="padding:5px;">
								<div><label><i class="fa fa-eraser"></i></label></div>
							</button>
						</td>
						<td colspan="2" align=right>
							<button class="clear-canvas btn btn-default"  style="padding:5px;">
								<div><label>Clear</label></div>
							</button>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<div id="dialpad">
						<fieldset>
						<table class="table-condensed" width=100%>
						<tr>
							<td colspan=3 nowrap=true>
									<input type="tel" class="form-control input-md" id="PhoneNumber" placeholder="Number to message" style="width:98%;font-size:16px;" onfocus="blur()">
<!--
								<table>
								<td>
									<input type="tel" class="form-control input-md" id="PhoneNumber" placeholder="Number to message" style="width:88%;font-size:10px;">
								</td>
								<td>
									<button type="button" class="resbtn btn btn-default"><i class="fa fa-times"></i></button>
								</td>
								</table>
-->
							</td>
						</tr>
						<tr>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="1" id="button1" style="padding:5px;">
									<div><label>1</label></div>
								</button>
							</td>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="2" id="button2"  style="padding:5px;">
									<div><label>2</label></div>
								</button>
							</td>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="3" id="button3" style="padding:5px;">
									<div><label>3</label></div>
								</button>
							</td>
						</tr>
						<tr>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="4" id="button4" style="padding:5px;">
									<div><label>4</label></div>
								</button>
							</td>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="5" id="button5" style="padding:5px;">
									<div><label>5</label></div>
								</button>
							</td>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="6" id="button6" style="padding:5px;">
									<div><label>6</label></div>
								</button>
							</td>
						</tr>
						<tr>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="7" id="button7" style="padding:5px;">
									<div><label>7</label></div>
								</button>
							</td>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="8" id="button8" style="padding:5px;">
									<div><label>8</label></div>
								</button>
							</td>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="9" id="button9" style="padding:5px;">
									<div><label>9</label></div>
								</button>
							</td>
						</tr>
						<tr>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="*" id="buttonstar" style="padding:5px;">
									<div><label>*</label></div>
								</button>
							</td>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="0" id="button0" style="padding:5px;">
									<div><label>0</label></div>
								</button>
							</td>
							<td width="33%" align=center>
								<button type="button" class="numbtn btn btn-default btn-large"  value="#" id="buttonpound" style="padding:5px;">
									<div><label>#</label></div>
								</button>
							</td>
						</tr>
						<tr>
							<td colspan=2>
								<button type="button" class="btn btn-default bigbtn"  id="call" style="width:90%;padding:5px;">
									<div><label>Send</label></div>
								</button>
							</td>
							<td width="33%" align=center>
								<button type="button" class="btn btn-default mdbtn"  id="reset"  style="padding:5px;">
									<div><label>X</label></div>
								</button>
							</td>
						</tr>
						</table>
						</fieldset>
					</div>					
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	<section class="section-shade-3 container demo"  style="width:100%;height: 3px;padding: 2px;"></section>
	<section class="container call-to-action" style="width:100%;height:30px;padding: 5px;">
		<footer></footer>
	</section>
	<div class="container" id="footer"  style="width:100%;">
		<header>
			<div class="banner"></div>
			<div class="border"></div>
			<div class="stitching"></div>
		</header>
		<div class="row sitemap"></div>
		<div class="row">
			<footer>
				<span>
					© 2014 Twilio. All rights reserved. <aside>|</aside>
					<a href="http://twilio.com/legal/tos">Terms of Service</a><aside>|</aside>
					<a href="http://twilio.com/legal/privacy">Privacy Policy</a>
				</span>
			</footer>
		</div>
	</div>
</body> 
</html>