var url = 'edit.php'; // The file on the server, which saves the edited text 

var idName1 = 'r1c1'; // This ID should be same as $idName1 in example.php
var idName2 = 'r1c2'; // This ID should be same as $idName2 in example.php
var idName3 = 'r2c1'; // This ID should be same as $idName3 in example.php
var idName4 = 'r2c2'; // This ID should be same as $idName4 in example.php

var updateDelay = 1000; // in microseconds; it specifies the delay in which the grid id updated
var spanId = idName1;

Event.observe(window, 'load', init, false);

function init(){
	makeEditable(idName1);
	makeEditable(idName2);
	makeEditable(idName3);
	makeEditable(idName4);
}

function makeEditable(id){
	Event.observe(id, 'click', function(){edit($(id))}, false);
	Event.observe(id, 'mouseover', function(){showAsEditable($(id))}, false);
	Event.observe(id, 'mouseout', function(){showAsEditable($(id), true)}, false);
}

function edit(obj){
	Element.hide(obj);
	
	var textarea = '<div id="'+obj.id+'_editor"><textarea id="'+obj.id+'_edit" name="'+obj.id+'" rows="4" cols="33">'+trim(obj.innerHTML)+'</textarea>';
	var button	 = '<div style="align:center;"><input id="'+obj.id+'_save" type="button" value="SAVE" /> OR <input id="'+obj.id+'_cancel" type="button" value="CANCEL" /></div></div>';
	
	new Insertion.After(obj, textarea+button);	
		
	Event.observe(obj.id+'_save', 'click', function(){saveChanges(obj)}, false);
	Event.observe(obj.id+'_cancel', 'click', function(){cleanUp(obj)}, false);
	
}

function showAsEditable(obj, clear){
	if (!clear){
		Element.addClassName(obj, 'editable');
	}else{
		Element.removeClassName(obj, 'editable');
	}
}

function saveChanges(obj){
	
	var new_content	=  escape($F(obj.id+'_edit'));

	obj.innerHTML	= "Saving...";
	cleanUp(obj, true);

	var success	= function(t){editComplete(t, obj);}
	var failure	= function(t){editFailed(t, obj);}


	var pars = 'id='+obj.id+'&content='+new_content;
	var myAjax = new Ajax.Request(url, {method:'post', postBody:pars, onSuccess:success, onFailure:failure});

}

function cleanUp(obj, keepEditable){
	Element.remove(obj.id+'_editor');
	Element.show(obj);
	if (!keepEditable) showAsEditable(obj, true);
}

function editComplete(t, obj){
	obj.innerHTML	= t.responseText;
	showAsEditable(obj, true);
}

function editFailed(t, obj){
	obj.innerHTML	= 'Sorry, the update failed.';
	cleanUp(obj);
}


function trim(inputString) {

   if (typeof inputString != "string") { return inputString; }
   var retValue = inputString;
   var ch = retValue.substring(0, 1);
   
   while (ch == " ") {
      retValue = retValue.substring(1, retValue.length);
      ch = retValue.substring(0, 1);
   }
   ch = retValue.substring(retValue.length-1, retValue.length);
   
   while (ch == " ") {
      retValue = retValue.substring(0, retValue.length-1);
      ch = retValue.substring(retValue.length-1, retValue.length);
   }
   
   while (retValue.indexOf("  ") != -1) {
      retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length); 
   }
   return retValue;
}

// Code to Update Grid After
var http = createRequestObject();

function createRequestObject() {
    var ro;
    var browser = navigator.appName;
    
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else{
        ro = new XMLHttpRequest();
    }
    return ro;    
}

// functions to upgrade grids
function updateGridRow1Col1() {
	http.open('get', 'grid.php?spanId='+escape(idName1));
    http.onreadystatechange = handleResponse11;
    http.send(null);
    setTimeout('updateGridRow1Col1()', updateDelay+100);
}

function updateGridRow1Col2() {
	http.open('get', 'grid.php?spanId='+escape(idName2));
    http.onreadystatechange = handleResponse12;
    http.send(null);
    setTimeout('updateGridRow1Col2()', updateDelay+200);
}
function updateGridRow2Col1() {
	http.open('get', 'grid.php?spanId='+escape(idName3));
    http.onreadystatechange = handleResponse21;
    http.send(null);
    setTimeout('updateGridRow2Col1()', updateDelay+300);
}

function updateGridRow2Col2() {
	http.open('get', 'grid.php?spanId='+escape(idName4));
    http.onreadystatechange = handleResponse22;
    http.send(null);
    setTimeout('updateGridRow2Col2()', updateDelay+400);
}

// Functions to handle function response


function handleResponse11() {
	if(http.readyState == 4){
        var response = http.responseText;
        document.getElementById(idName1).innerHTML = response;
    }
}

function handleResponse12() {
	if(http.readyState == 4){
        var response = http.responseText;
        document.getElementById(idName2).innerHTML = response;
    }
}

function handleResponse21() {
	if(http.readyState == 4){
        var response = http.responseText;
        document.getElementById(idName3).innerHTML = response;
    }
}

function handleResponse22() {
	if(http.readyState == 4){
        var response = http.responseText;
        document.getElementById(idName4).innerHTML = response;
    }
}



// initiate updation of grids
function startUpdatingGrids() {
	setTimeout('updateGridRow1Col1()', updateDelay+100);
	setTimeout('updateGridRow1Col2()', updateDelay+200);
	setTimeout('updateGridRow2Col1()', updateDelay+300);
	setTimeout('updateGridRow2Col2()', updateDelay+400);	
}

startUpdatingGrids();