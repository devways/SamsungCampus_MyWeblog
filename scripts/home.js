url_array = ['./files/0.jpg', './files/1.jpg', './files/2.jpg', './files/3.jpg'];
var options = {
	'images' : url_array,
	'speed' : 800,
	'interval' : 2000,
	'auto' : true,
	'manual' : true,
	'arrowStyle' : 'thin',
	'arrowColor' : '#1e344c',
	'text' : 'Blah blah blah je suis un texte',
	'textX': 100,
	'textY' : 200,
	'textColor' : '#8b0000'
};
$('#slider').createSlider(options);