// Funktionen zur Vorschau
function setSize() {
    
    var elementsWidth = new Array('chicken', 'chicken_contentDiv', 'chicken_FrameDecorationDiv_0', 'chicken_FrameDecorationDiv_2');
    var elementsHeight = new Array('chicken', 'chicken_contentDiv', 'chicken_FrameDecorationDiv_0', 'chicken_FrameDecorationDiv_1');
        
    var newContentSizeWidth = document.getElementById('inhalt').offsetWidth;
    var contentWidth = document.getElementById('chicken_contentDiv').style.width;
    var diffSizeWidth = (parseInt(contentWidth) - parseInt(newContentSizeWidth) - 20);
    
    var newContentSizeHeight = document.getElementById('inhalt').offsetHeight;
    var contentHeight = document.getElementById('chicken_contentDiv').style.height;
    var diffSizeHeight = (parseInt(contentHeight) - parseInt(newContentSizeHeight));
   
    for (var i = 0; i < elementsWidth.length; i++) {
        newSize = parseInt(document.getElementById(elementsWidth[i]).style.width) - diffSizeWidth;
        document.getElementById(elementsWidth[i]).style.width = newSize + 'px';
    }
    
    for (var i = 0; i < elementsHeight.length; i++) {
        newSize = parseInt(document.getElementById(elementsHeight[i]).style.height) - diffSizeHeight;
        document.getElementById(elementsHeight[i]).style.height = newSize + 'px';
    }

}

var http = null;
function showPreview(){
    http = new XMLHttpRequest();
    http.open("POST", "preview_wiki2html.php", true);
    http.onreadystatechange = popupWindow;
    http.setRequestHeader(
	"Content-Type",
	"application/x-www-form-urlencoded"
    );

    http.send(
	'preview_description=' + document.getElementById("description").value +
	'&preview_title=' + document.getElementById("title").value +
	'&entry_id=' + document.getElementById("entry_id").value);
    return false;
}

function popupWindow() {   
    if(http.readyState == 4) {
	var o = document.getElementById('inhalt');
	o.innerHTML = http.responseText;
    openWindow("preview");
	setSize();
    }
	return false;
}

function closePreview() {
    closeWindow("preview");
    return false;
}
