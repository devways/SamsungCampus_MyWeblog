window.onload = function () {
	var input = $('#input')[0];
	var output = $('#output')[0];
	$('#output')[0].style.display = 'none';
}

function escapeHtml(text) {
	return text
	.replace(/&/g, "&amp;")
	.replace(/</g, "&lt;")
	.replace(/>/g, "&gt;")
	.replace(/"/g, "&quot;")
	.replace(/'/g, "&#039;");
}

function getInput(){
	$('#output')[0].style.display = 'block';
	var str = input.value;
	var strout = escapeHtml(str);
	strout = strout.replace(/\[B\]/g,"<b>");
	strout = strout.replace(/\[\/B\]/g,"</b>");
	strout = strout.replace(/\[S\]/g,"<del>");
	strout = strout.replace(/\[\/S\]/g,"</del>");
	strout = strout.replace(/\[U\]/g,"<u>");
	strout = strout.replace(/\[\/U\]/g,"</u>");
	strout = strout.replace(/\[\/COLOR\]/g,"</span>");
	strout = strout.replace(/\[\/LINK\]/g,"</a>");
	strout = strout.replace(/\n/g,"<br/>");
	strout = strout.replace(/\[\/VIDEO\]/g,'</iframe>');
	var strout_res = [];
	var strout_tmp = strout.split("");
	var k = 0;
	for (i = 0; i < strout_tmp.length; i++) {
		var video = str[i] + str[i+1] + str[i+2] + str[i+3] + str[i+4] + str[i+5] + str[i+6] + str[i+7];
		if (video == "[VIDEO=<"){
			var strout_tab = strout.split("[VIDEO=&lt;");
			var video = strout_tab[1].split("&gt;/]")[0];
			strout = strout.replace("[VIDEO=&lt;" + video + "&gt;/]", '<iframe class="text-center" width="420" height="315" src="https://www.youtube.com/embed/' + video + '"></iframe>');
		}
		if (strout_tmp[i] == "[" && strout_tmp[i+1] == "C" && strout_tmp[i+2] == "O" && strout_tmp[i+3] == "L"
			&& strout_tmp[i+4] == "O" && strout_tmp[i+5] == "R" && strout_tmp[i+6] == "=" && strout_tmp[i+7] == "&" && strout_tmp[i+8] == "l" && strout_tmp[i+9] == "t" && strout_tmp[i+10] == ";") {

			strout_res[i] = "["; strout_res[i+1] = "C"; strout_res[i+2] = "O"; strout_res[i+3] = "L";
		strout_res[i+4] = "O"; strout_res[i+5] = "R"; strout_res[i+6] = "="; strout_res[i+7] = "<"; 
		for (j = i+10; j < strout_tmp.length && !(strout_tmp[j+1] == "&" && strout_tmp[j+2] == "g" && strout_tmp[j+3] == "t" && strout_tmp[j+4] == ";" && strout_tmp[j+5] == "]"); j++) {
			strout_res[j-2] = strout_tmp[j+1];
		}
		if (j < strout_tmp.length && (strout_tmp[j+1] == "&" && strout_tmp[j+2] == "g" && strout_tmp[j+3] == "t" && strout_tmp[j+4] == ";" && strout_tmp[j+5] == "]")) {
			strout_res[j+1] = ">";
			strout_res[j+2] = "]";
			strout_res = strout_res.join("");
			var value = strout_res.slice(8, strout_res.length - 2);
			strout = strout.replace("[COLOR=&lt;" + value + "&gt;]", "<span style=color:" + value + ">");
			strout_res = strout_res.split("");
			strout_res = [];
			k = 0;
			j=0;
		}
		else {
			strout_res = [];
			k = 0;
			i=0;
			j=0;
		}
	}
	else if (strout_tmp[i] == "[" && strout_tmp[i+1] == "L" && strout_tmp[i+2] == "I" && strout_tmp[i+3] == "N"
		&& strout_tmp[i+4] == "K" && strout_tmp[i+5] == "=" && strout_tmp[i+6] == "&" && strout_tmp[i+7] == "l" && strout_tmp[i+8] == "t" && strout_tmp[i+9] == ";") {
		strout_res[i] = "["; strout_res[i+1] = "L"; strout_res[i+2] = "I"; strout_res[i+3] = "N";
		strout_res[i+4] = "K"; strout_res[i+5] = "="; strout_res[i+6] = "<"; 
		for (j = i+9; j < strout_tmp.length && !(strout_tmp[j+1] == "&" && strout_tmp[j+2] == "g" && strout_tmp[j+3] == "t" && strout_tmp[j+4] == ";" && strout_tmp[j+5] == "]"); j++) {
			strout_res[j-2] = strout_tmp[j+1];
		}
		if (j < strout_tmp.length && (strout_tmp[j+1] == "&" && strout_tmp[j+2] == "g" && strout_tmp[j+3] == "t" && strout_tmp[j+4] == ";" && strout_tmp[j+5] == "]")) {
			strout_res[j+1] = ">";
			strout_res[j+2] = "]";
			strout_res = strout_res.join("");
			var value = strout_res.slice(7, strout_res.length - 2);
			strout = strout.replace("[LINK=&lt;" + value + "&gt;]", "<a href=\"" + value + "\">");
			strout_res = strout_res.split("");
			strout_res = [];
			k = 0;
			j = 0;
		}
		else {
			strout_res = [];
			k = 0;
			j = 0;
		}
	}
}
console.log($('#newTitle').val());
output.innerHTML = '<a href="index.php?article=' + $('#newTitle').val() + '">' + '<h2 class="text-center">'+$('#newTitle').val()+'</h2></a>';
output.innerHTML += '<h3 class="text-center">'+$('#newChapo').val()+'</h3>';
output.innerHTML += '<p class="text-center	">' + strout + '</p>';
}

function goBold(){
	var ta = $('textarea').get(0);
	var selection = ta.value.substring(ta.selectionStart, ta.selectionEnd);
	var str = ta.value;
	var str = str.slice(0, ta.selectionStart) + '[B]' + str.slice(ta.selectionStart, ta.selectionEnd) + '[/B]' + str.slice(ta.selectionEnd);
	ta.value = str;
}

function goDel(){
	var ta = $('textarea').get(0);
	var selection = ta.value.substring(ta.selectionStart, ta.selectionEnd);
	var str = ta.value;
	var str = str.slice(0, ta.selectionStart) + '[S]' + str.slice(ta.selectionStart, ta.selectionEnd) + '[/S]' + str.slice(ta.selectionEnd);
	ta.value = str;
}

function goUnderline(){
	var ta = $('textarea').get(0);
	var selection = ta.value.substring(ta.selectionStart, ta.selectionEnd);
	var str = ta.value;
	var str = str.slice(0, ta.selectionStart) + '[U]' + str.slice(ta.selectionStart, ta.selectionEnd) + '[/U]' + str.slice(ta.selectionEnd);
	ta.value = str;
}

function goUnderline(){
	var ta = $('textarea').get(0);
	var selection = ta.value.substring(ta.selectionStart, ta.selectionEnd);
	var str = ta.value;
	var str = str.slice(0, ta.selectionStart) + '[U]' + str.slice(ta.selectionStart, ta.selectionEnd) + '[/U]' + str.slice(ta.selectionEnd);
	ta.value = str;
}

function goLink(){
	var ta = $('textarea').get(0);
	var selection = ta.value.substring(ta.selectionStart, ta.selectionEnd);
	var str = ta.value;
	var str = str.slice(0, ta.selectionStart) + '[LINK=<>]' + str.slice(ta.selectionStart, ta.selectionEnd) + '[/LINK]' + str.slice(ta.selectionEnd);
	ta.value = str;
}

function goColor(){
	var ta = $('textarea').get(0);
	var selection = ta.value.substring(ta.selectionStart, ta.selectionEnd);
	var str = ta.value;
	var str = str.slice(0, ta.selectionStart) + '[COLOR=<>]' + str.slice(ta.selectionStart, ta.selectionEnd) + '[/COLOR]' + str.slice(ta.selectionEnd);
	ta.value = str;
}

function goVideo(){
	var ta = $('textarea').get(0);
	ta.value += '[VIDEO=<>/]';
}

function checkPost(event){
	getInput();
	var corps = $('#output')[0].innerHTML;
	$('#input').val(corps);
}