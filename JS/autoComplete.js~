/*<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Ajax Auto Complete</title>
<style type="text/css">
.mouseOut {
background: #708090;
color: #FFFAFA;
}
.mouseOver {
background: #FFFAFA;
color: #000000;
}
</style>
<script type="text/javascript">-->*/
var xmlHttp;
var completeDiv;
var inputField;
var wordTable;
var wordTableBody;
var status;

//browser defined function
function createXMLHttpRequest() 
{
if (window.ActiveXObject) {
xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
}
else if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
}
}

function initVars() {
inputField = document.getElementById("txt1");
//wordTable = document.getElementById("word_table");
//completeDiv = document.getElementById("popup");
//wordTableBody = document.getElementById("word_table_body");
}
//function for focus the cursor in text fild
function setFocus(str)
{
 status=str;
 document.getElementById("txt1").focus();
}
function showHint() {
initVars();
if (inputField.value.length > 0) {
createXMLHttpRequest();
var url = "gethint.php" + escape(inputField.value);
url=url+"?q="+str+"&status="+status;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlHttp.open("GET", url, true);
//xmlHttp.onreadystatechange = callback;
xmlHttp.send(null);
} 
else 
{
clearWords();
}
}
//state change function
function stateChanged() {
if (xmlHttp.readyState == 4) {
if (xmlHttp.status == 200) {
var word =
xmlHttp.responseXML
.getElementsByTagName("word")[0].firstChild.data;
setWords(xmlHttp.responseXML.getElementsByTagName("word"));
} 
else if (xmlHttp.status == 204){
clearWords();
}
}
}
////************////
function setWords(the_words) {
clearWords();
var size = the_words.length;
setOffsets();
var row, cell, txtNode;
for (var i = 0; i < size; i++) {
var nextNode = the_words[i].firstChild.data;
row = document.createElement("tr");
cell = document.createElement("td");
//cell.onmouseout = function() {this.className='mouseOver';};
//cell.onmouseover = function() {this.className='mouseOut';};
//cell.setAttribute("bgcolor", "#FFFAFA");
//cell.setAttribute("border", "0");
cell.onclick = function() { populateWord(this); } ;
txtNode = document.createTextNode(nextNode);
cell.appendChild(txtNode);
row.appendChild(cell);
wordTableBody.appendChild(row);
}
}
//*********//
/*function setOffsets() {
var end = inputField.offsetWidth;
var left = calculateOffsetLeft(inputField);
var top = calculateOffsetTop(inputField) + inputField.offsetHeight;
completeDiv.style.border = "black 1px solid";
completeDiv.style.left = left + "px";
completeDiv.style.top = top + "px";
wordTable.style.width = end + "px";
}
function calculateOffsetLeft(field) {
return calculateOffset(field, "offsetLeft");
}
function calculateOffsetTop(field) {
return calculateOffset(field, "offsetTop");
}

function calculateOffset(field, attr) {
var offset = 0;
while(field) {
offset += field[attr];
field = field.offsetParent;
}
return offset;
}

function populateWord(cell) 
{
inputField.value = cell.firstChild.nodeValue;
//clearWords();
}
*/
/*function clearWords() {
var ind = wordTableBody.childNodes.length;
for (var i = ind - 1; i >= 0 ; i--) {
wordTableBody.removeChild(wordTableBody.childNodes[i]);
}
//completeDiv.style.border = "none";
}*/

/*</script>
</head>
<body>
<h1>Ajax Auto Complete Example</h1>
Words: <input type="text" size="20" id="words"
onkeyup="findWords();" style="height:20;"/>
<div style="position:absolute;" id="popup">
<table id="word_table" bgcolor="#FFFAFA" border="0"
cellspacing="0" cellpadding="0"/>
<tbody id="word_table_body"></tbody>
</table>
</div>
</body>
</html>
*/
