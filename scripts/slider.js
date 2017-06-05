var _id;
var _cpt = 0;
var _speed;
var _interval;
var _div_slider;
var _limit;
var _auto;
var _manual;
var _arrowStyle;
var _arrowColor;
var _effect;
var _text;
var _textColor;
var _textX;
var _textY;

(function($){
	$.fn.createSlider=function(options){
		$(this)[0].style.overflow = "hidden";
		if (options['auto']){
			if (options['interval']){
				_interval = options['interval'];
			}
			else {
				interval = 2000;
			}
		}
		if (options['speed']){
			_speed = options['speed'];
		}
		else {
			_speed = 800;
		}
		if(options['arrowStyle']){
			_arrowStyle = options['arrowStyle'];
		}
		else {
			_arrowStyle = 'blackTriangle';
		}
		if (options['arrowColor']){
			_arrowColor = options['arrowColor'];
		}
		else {
			_arrowColor = '#212523';
		}
		if (options['effect']){
			_effect = options['effect'];
		}
		else{
			_effect = 'none';
		}
		_manual = options['manual'];
		_div_slider = $(this)[0].id;
		_auto = options['auto'];
		createSliderDiv(url_array);
		if (options['text']){
			_text = options['text'];
			_textColor = options['textColor'];
			_textX = options['textX'];
			_textY = options['textY'];
			createText();
		}
		if (options['limit']){
			_limit = options['limit'];
		}
		else {
			_limit = $("#"+_div_slider+" ul")[0].children.length;
		}
		createBullets(_limit);
		if (_auto){
			slide(_speed, _interval, _limit);
		}
		thumbnail(_limit);
	}
})(jQuery);

function createSliderDiv(url_array){
	var widthUl = url_array.length * 100;
	jQuery('<ul/>', {
		css: {
			margin: '0',
			padding: '0',
			listStyle: 'none',
			width : widthUl+'%',
			height : $(''+_div_slider).height(),
		}
	}).appendTo('#'+_div_slider);
	for (i = 0; i < url_array.length; i++){
		jQuery('<li/>', {
			css: {
				width : $("#"+_div_slider).width(),
				height : $(''+_div_slider).height(),
				float: 'left',
			},
		}).appendTo($('#'+_div_slider)[0].children[0]);
	}
	for (i = 0; i < url_array.length; i++){
		console.log(url_array[i]);
		jQuery('<img/>', {
			src: url_array[i],
			css: {
				width : $("#"+_div_slider).width(),
				height : $('#'+_div_slider).height(),
				float: 'left',
			}
		}).appendTo($('#'+_div_slider)[0].children[0].children[i]);
	}
	jQuery('<div/>',{
		css:{
			clear: 'both'
		}
	}).appendTo('#'+_div_slider);
}

function slide(speed, interval, limit){
	_id = setInterval(function(){
		if (_effect == 'transparent' || $('#'+_div_slider+'select')[0].children[2].selected === true){
			$('#'+_div_slider).animate({opacity: 0.1}, _speed);
			$('#'+_div_slider).animate({opacity: 1}, _speed);
		}
		_cpt++;
		var width = $("#"+_div_slider).width();
		marginLeft = $("#"+_div_slider+" ul").css("marginLeft");
		marginLeft = marginLeft.substr(0, (marginLeft.length - 2));
		marginLeft = marginLeft - width;
		if (_cpt >= $("#"+_div_slider+" ul")[0].children.length || _cpt >= limit){
			$("#"+_div_slider+" ul").animate({marginLeft: 0},speed);
			_cpt = 0;
		}
		else {
			$("#"+_div_slider+" ul").animate({marginLeft: marginLeft},speed);
			if (_effect == 'bounce' || $('#'+_div_slider+'select')[0].children[1].selected === true){
				bounce();
			}
		}
	}, interval)
}	

function back(){
	if (_cpt == 0){
		return false;
	}
	var width = $("#"+_div_slider).width();
	marginLeft = $("#"+_div_slider+" ul").css("marginLeft");
	marginLeft = marginLeft.substr(0, (marginLeft.length - 2));
	marginLeft = parseInt(marginLeft) + width;
	clearInterval(_id);
	if (_auto){
		slide(_speed, _interval);
	}
	$("#"+_div_slider+" ul").animate({marginLeft: marginLeft}, width);
	_cpt--;
}

function forward(){
	if (_cpt == $("#"+_div_slider+" ul")[0].children.length - 1){
		return false;
	}
	var width = $("#"+_div_slider).width();
	marginLeft = $("#"+_div_slider+" ul").css("marginLeft");
	marginLeft = marginLeft.substr(0, (marginLeft.length - 2));
	marginLeft = parseInt(marginLeft) - width;
	$("#"+_div_slider+" ul").animate({marginLeft: marginLeft}, width);
	clearInterval(_id);
	if (_auto){
		slide(_speed, _interval);
	}
	_cpt++;
}

function bullet(div){
	var width = $("#"+_div_slider).width();
	marginLeft = div.id;
	marginLeft = marginLeft.replace(_div_slider, "");
	cpt = marginLeft;
	marginLeft = -(parseInt(marginLeft) * width);
	$("#"+_div_slider+" ul").animate({marginLeft: marginLeft}, width);
	clearInterval(_id);
	if (_auto){
		slide(_speed, _interval);
	}
	_cpt = cpt;
}


function thumbnail(limit){
	jQuery('<div/>',{
		id: _div_slider+'thumbnail' 
	}).insertAfter('#'+_div_slider);
	for (i = 0; i < limit; i++){
		image = $("#"+_div_slider+" ul")[0].children[i].children[0];
		var imageData = getBase64Image(image);
		var thumbnail = document.createElement('img');
		$("#"+_div_slider+"thumbnail")[0].append(thumbnail);
		thumbnail.src = imageData;
		$("#"+_div_slider+"thumbnail")[0].children[i].style.height = '40px';
		$("#"+_div_slider+"thumbnail")[0].children[i].style.width = '80px';
	}
	jQuery('<div/>',{
		id: 'clear_both',
		css: {
			clear: 'both',
		}
	}).appendTo('#'+_div_slider+'thumbnail');
}

function getBase64Image(img){
	var canvas = document.createElement('canvas');
	canvas.width = img.width;
	canvas.height = img.height;

	var ctx = canvas.getContext('2d');
	ctx.drawImage(img, 0, 0);

	var dataURL = canvas.toDataURL("image/jpg");

	return dataURL
}

function createBullets(limit){
	jQuery('<div/>',{
		id: _div_slider+'bullets'
	}).insertAfter('#'+_div_slider);
	for (i = 0; i < limit; i++){
		jQuery('<div/>',{
			class: 'bullet',
			id: _div_slider+i,
			onclick : 'bullet(this)',
			css: {
				borderRadius: '5px',
				height : '15px',
				width: '15px',
				backgroundColor: 'black',
				float: 'left',
				margin : '10px',
				marginTop: '27px',
			}
		}).appendTo('#'+_div_slider+'bullets');
	}
	jQuery('<canvas/>', {
		id: _div_slider+'forward',
		onclick: 'forward()',
		css: {
			width: '50px',
			height: '50px',
			float: 'left',
			margin: '10px',
		},
	}).appendTo('#'+_div_slider+'bullets');
	jQuery('<canvas/>', {
		id: _div_slider+'back',
		onclick: 'back()',
		css: {
			width: '50px',
			height: '50px',
			float: 'left',
			margin: '10px',
		},
	}).insertBefore('#'+_div_slider+'0');
	switch(_arrowStyle){
		case 'triangle':
		drawTriangle();
		break;

		case 'classic':
		drawClassic();
		break;

		case 'thin':
		drawThin();
		break;
	}
	jQuery('<div/>',{
		id: 'clear_both',
		css: {
			clear: 'both',
		}
	}).appendTo('#'+_div_slider+'bullets');
	jQuery('<select/>',{
		id: _div_slider+'select',
		onchange: 'switchEffect(this)'
	}).appendTo('#'+_div_slider+'bullets');
	jQuery('<option/>', {value: 'normal'}).appendTo('#'+_div_slider+'select');
	jQuery('<option/>').appendTo('#'+_div_slider+'select');
	jQuery('<option/>').appendTo('#'+_div_slider+'select');
	$('#'+_div_slider+'select')[0].children[0].innerHTML = 'normal';
	$('#'+_div_slider+'select')[0].children[1].innerHTML = 'bounce';
	$('#'+_div_slider+'select')[0].children[2].innerHTML = 'transparent';
}

function drawTriangle(){
	var canvas = document.getElementById(_div_slider+'forward');
	canvas.width = 50;
	canvas.height = 50;
	var ctx = canvas.getContext('2d');
	ctx.beginPath();
	ctx.fillStyle= _arrowColor;
	ctx.moveTo(15, 10);
	ctx.lineTo(15, 40);
	ctx.lineTo(45, 25);
	ctx.closePath();
	ctx.fill();

	var canvas = document.getElementById(_div_slider+'back');
	canvas.width = 50;
	canvas.height = 50;
	var ctx = canvas.getContext('2d');
	ctx.beginPath();
	ctx.fillStyle= _arrowColor;
	ctx.moveTo(45, 10);
	ctx.lineTo(45, 45);
	ctx.lineTo(15, 25);
	ctx.closePath();
	ctx.fill();
}

function drawClassic(){
	var canvas = document.getElementById(_div_slider+'forward');
	canvas.width = 50;
	canvas.height = 50;
	var ctx = canvas.getContext('2d');
	ctx.beginPath();
	ctx.fillStyle= _arrowColor;
	ctx.moveTo(10, 15);
	ctx.lineTo(10, 35);
	ctx.lineTo(23, 35);
	ctx.lineTo(23, 40);
	ctx.lineTo(40, 25);
	ctx.lineTo(23, 10);
	ctx.lineTo(23, 15);
	ctx.closePath();
	ctx.fill();

	var canvas = document.getElementById(_div_slider+'back');
	canvas.width = 50;
	canvas.height = 50;
	var ctx = canvas.getContext('2d');
	ctx.beginPath();
	ctx.fillStyle= _arrowColor;
	ctx.moveTo(39, 14);
	ctx.lineTo(39, 34);
	ctx.lineTo(26, 34);
	ctx.lineTo(26, 39);
	ctx.lineTo(9, 24);
	ctx.lineTo(26, 9);
	ctx.lineTo(26, 14);
	ctx.closePath();
	ctx.fill();
}

function drawThin(){
	var canvas = document.getElementById(_div_slider+'forward');
	canvas.width = 50;
	canvas.height = 50;
	var ctx = canvas.getContext('2d');
	ctx.beginPath();
	ctx.fillStyle= _arrowColor;
	ctx.moveTo(8, 49);
	ctx.lineTo(40, 25);
	ctx.lineTo(8, 0);
	ctx.stroke();

	var canvas = document.getElementById(_div_slider+'back');
	canvas.width = 50;
	canvas.height = 50;
	var ctx = canvas.getContext('2d');
	ctx.beginPath();
	ctx.fillStyle= _arrowColor;
	ctx.moveTo(40, 0);
	ctx.lineTo(9, 24);
	ctx.lineTo(40, 49);
	ctx.stroke();
}

function bounce(){
	width = $("#"+_div_slider).width();
	marginLeft = width * _cpt - 30;
	$('#'+_div_slider+' ul').animate({marginLeft: -marginLeft}, 100);
	$('#'+_div_slider+' ul').animate({marginLeft: -(width * _cpt)}, 100);
	marginLeft = marginLeft + 10;
	$('#'+_div_slider+' ul').animate({marginLeft: -marginLeft}, 80);
	$('#'+_div_slider+' ul').animate({marginLeft: -(width * _cpt)}, 80);
	marginLeft = marginLeft + 20;
	$('#'+_div_slider+' ul').animate({marginLeft: -marginLeft}, 60);
	$('#'+_div_slider+' ul').animate({marginLeft: -(width * _cpt)}, 80);
}

function createText(){
	jQuery('<canvas/>', {
		id: _div_slider+'text',
		width: $('#'+_div_slider).width(),
		height: $('#'+_div_slider).height(),
		position : 'absolute',
		css: {
			marginTop: -$('#'+_div_slider).height()+'px',
		}
	}).appendTo($('#'+_div_slider));
	var canvas = $('#'+_div_slider+'text')[0];
	var ctx = canvas.getContext('2d');
	ctx.fillStyle = _textColor;
	ctx.font = "10px Arial"
	ctx.fillText(_text, 100, 20);
	console.log(_text);
}