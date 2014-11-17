$(function() {
	FastClick.attach(document.body);
});
window.addEventListener('load',function(){
	var bMouseIsDown = false;
	// get the canvas element and its context
	var canvas = document.getElementById('sketchpad');
	var context = canvas.getContext('2d');

	resizeCanvas();
	
	$(window).resize(function() {
    	resizeCanvas();
	});

	document.body.addEventListener('touchmove',function(event){
		event.preventDefault();
	},false);	// end body:touchmove

	var iWidth = canvas.width;
	var iHeight = canvas.height;
	
	context.fillStyle = "rgb(255,255,255)";
	context.fillRect(0,0,iWidth,iHeight);
/*
	context.fillStyle = "rgb(255,0,0)";
	context.fillRect(20,20,30,30);

	context.fillStyle = "rgb(0,255,0)";
	context.fillRect(60,60,30,30);

	context.fillStyle = "rgb(0,0,255)";
	context.fillRect(100,100,30,30);

	context.beginPath();
	context.strokeStyle = "rgb(255,0,255)";
	context.strokeWidth = "4px";
*/

	// create a drawer which tracks touch movements
	var drawer = {
		isDrawing: false,
		touchstart: function(coors){
			var canvasOffset = $('#sketchpad').offset();
			context.beginPath();
			context.moveTo(coors.x, coors.y - canvasOffset.top);
			this.isDrawing = true;
		},
		touchmove: function(coors){
			if (this.isDrawing) {
				var canvasOffset = $('#sketchpad').offset();
				context.lineTo(coors.x, coors.y - canvasOffset.top);
		        context.stroke();
			}
		},
		touchend: function(coors){
			if (this.isDrawing) {
		        this.touchmove(coors);
		        this.isDrawing = false;
			}
		}
	};



	// create a function to pass touch events and coordinates to drawer
	function draw(event){
		// get the touch coordinates
		var coors = {
			x: event.targetTouches[0].pageX,
			y: event.targetTouches[0].pageY
		};
		// pass the coordinates to the appropriate handler
		drawer[event.type](coors);
	}
	
	// attach the touchstart, touchmove, touchend event listeners.
    canvas.addEventListener('touchstart',draw, false);
    canvas.addEventListener('touchmove',draw, false);
    canvas.addEventListener('touchend',draw, false);
//	mouse support
	canvas.onmousedown = function(e) {
		bMouseIsDown = true;
		iLastX = e.clientX - canvas.offsetLeft + (window.pageXOffset||document.body.scrollLeft||document.documentElement.scrollLeft);
		iLastY = e.clientY - canvas.offsetTop + (window.pageYOffset||document.body.scrollTop||document.documentElement.scrollTop);
	}
	canvas.onmouseup = function() {
		bMouseIsDown = false;
		iLastX = -1;
		iLastY = -1;
	}
	canvas.onmousemove = function(e) {
		if (bMouseIsDown) {
			var iX = e.clientX - canvas.offsetLeft + (window.pageXOffset||document.body.scrollLeft||document.documentElement.scrollLeft);
			var iY = e.clientY - canvas.offsetTop + (window.pageYOffset||document.body.scrollTop||document.documentElement.scrollTop);
			context.moveTo(iLastX, iLastY);
			context.lineTo(iX, iY);
			context.stroke();
			iLastX = iX;
			iLastY = iY;
		}
	}

	
	function resizeCanvas() {
		var holder = $('#canvastd');
		tdWidth = holder.width();
		tdHeight = holder.height();
		canvas.setAttribute('width', tdWidth);
		canvas.setAttribute('height', tdHeight);
		
		iHeight = canvas.height;
		tdHeight = tdHeight - 10;
		
		iWidth = canvas.width;
		tdWidth = tdWidth - 10;
		$("#sketchpad").attr("style", "width: "+tdWidth+"px;height: "+tdHeight+"px;")

		var iWidth = canvas.width;
		var iHeight = canvas.height;
	
		context.fillStyle = "rgb(255,255,255)";
		context.fillRect(0,0,iWidth,iHeight);

//					context.scale(2, 2);

/*
		canvas.setAttribute('width', window.innerWidth*2);
		canvas.setAttribute('height', window.innerHeight*2);
		iWidth = canvas.width;
		iHeight = canvas.height;
		
		$("#sketchpad").attr("style", "height: "+window.innerHeight+"px; width: "+window.innerWidth+"px;")
		context.scale(2, 2);
*/
	}
	
	// prevent elastic scrolling
	document.body.addEventListener('touchmove',function(event){
		event.preventDefault();
	},false);	// end body.onTouchMove

	function showDownloadText() {
		document.getElementById("buttoncontainer").style.display = "none";
		document.getElementById("textdownload").style.display = "block";
	}

	function hideDownloadText() {
		document.getElementById("buttoncontainer").style.display = "block";
		document.getElementById("textdownload").style.display = "none";
	}

	function convertCanvas(strType) {
		if (strType == "PNG")
			var oImg = Canvas2Image.saveAsPNG(canvas, true);
		if (strType == "BMP")
			var oImg = Canvas2Image.saveAsBMP(canvas, true);
		if (strType == "JPEG")
			var oImg = Canvas2Image.saveAsJPEG(canvas, true);

		if (!oImg) {
			alert("Sorry, this browser is not capable of saving " + strType + " files!");
			return false;
		}

		oImg.id = "canvasimage";

		oImg.style.border = canvas.style.border;
		canvas.parentNode.replaceChild(oImg, canvas);

		showDownloadText();
	}

	function saveCanvas(pCanvas, strType) {
		var bRes = false;
		if (strType == "PNG")
			bRes = Canvas2Image.saveAsPNG(canvas);
		if (strType == "BMP")
			bRes = Canvas2Image.saveAsBMP(canvas);
		if (strType == "JPEG")
			bRes = Canvas2Image.saveAsJPEG(canvas);

		if (!bRes) {
			alert("Sorry, this browser is not capable of saving " + strType + " files!");
			return false;
		}
	}

	function send(){

		var image = Canvas2Image.saveAsJPEG(canvas, true);

		if (!image) {
			alert("Sorry, this browser is not capable of saving JPEG files!");
			return false;
		}
		data = image.src;
		
		ph = $("#PhoneNumber").val();

		swal( 'Sending your drawing now to ' + ph );

		var url = '/wb/index.php';
		$.post( url, {	
			img : data,
			PhoneNumber: ph
		}, function( data ) {
//						alert( data );
//						alert( 'Your masterpiece has been sent' );
			swal("Way to go", "Your drawing has been sent!", "success");
		});
/*
		$.post(
			url,
			{	img : data	}
			{
			type: "POST", 
			url: url,
			dataType: 'text',
			data: {
				img : data
			}
		});
*/
	}				

	document.getElementById("savepngbtn").onclick = function() {
		saveCanvas(canvas, "PNG");
	}
	document.getElementById("convertpngbtn").onclick = function() {
		convertCanvas("PNG");
	}
/*
	document.getElementById("savebmpbtn").onclick = function() {
		saveCanvas(canvas, "BMP");
	}
	document.getElementById("savejpegbtn").onclick = function() {
		saveCanvas(canvas, "JPEG");
	}
	document.getElementById("convertbmpbtn").onclick = function() {
		convertCanvas("BMP");
	}
	document.getElementById("convertjpegbtn").onclick = function() {
		convertCanvas("JPEG");
	}
*/
	document.getElementById("resetbtn").onclick = function() {
		var oImg = document.getElementById("canvasimage");
		oImg.parentNode.replaceChild(canvas, oImg);
		hideDownloadText();
	}


	$('.sbbtn').click(function(e) {
		var targetSize = $(this).attr('id');

//				alert( targetSize );
	
		$('.sbbtn').removeClass("active"); 
		$(this).addClass('active');
		

		context.closePath();
		context.beginPath();

		if(targetSize == 'small') {
			context.lineWidth = 2;
		} else if(targetSize == 'normal') {
			context.lineWidth = 5;
		} else if(targetSize == 'large') {
			context.lineWidth = 10;
		} else if(targetSize == 'huge') {
			context.lineWidth = 20;
		}

	});
	
	$('.clear-canvas').click(function(e) {
		context.clearRect(0, 0, canvas.width, canvas.height);
		context.beginPath();
		context.fillStyle = "rgb(255,255,255)";
		context.fillRect(0,0,iWidth,iHeight);
	});	
	
	$("#call").click(function(e){
		send();
	});
	
	$('.clrbtn').click(function(e) {
		var targetColor = $(this).attr('id');

//				alert( targetColor );
	
		$('.clrbtn').removeClass("active"); 
		$(this).addClass('active');
		
		context.closePath();
		context.beginPath();
		context.strokeStyle = "#"+targetColor;
/*
		var sheet_height = $(this).parent().height();
		$('.action-sheet:visible').animate({
			bottom: - sheet_height
		}, (200), function() {
			$('.overlay-bg').fadeOut(200);
			$('.action-sheet:visible').css('visibility', 'hidden');
		});
*/
	});		
/*
	$.each(['0','1','2','3','4','5','6','7','8','9','star','pound'], function(index, value) { 
			numpad( value );
	});
*/				
	$('.numbtn').click(function(e) {
		var value = $(this).val();
		numpad( value );
	});
	$(".resbtn").click(function(e) {
		var ph = $('#PhoneNumber');
		var n = ph.val();
		var n = n.slice(0,-1);
//					alert( n );
		ph.val( n );
	});
	
	$("#reset").click(function(e){
		$('#PhoneNumber').val("");
	});
	
	function numpad( str ){
		var ph = $('#PhoneNumber');
		var n = ph.val();
		ph.val( n+str );
	}
/*
	var tdWidthLimit = 100;
	$('#canvastd').each(function() {
		resizeCanvas();

		if (tdWidth >= tdWidthLimit){    
//						alert('hightlighted td width is ' + tdWidth);
//						$(this).css({'background-color' : '#f00'});
		}
	});
*/
},false);	// end window.onLoad