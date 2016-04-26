// global vars
var functionListing = "NVSEFunctions/functionsListing.json";
var FunctionsList = [];
var lastHash = '';

jQuery(document).ready(function($) {
	$.ajaxSetup({async:false});
	CreateFunctionsArray();
	BuildFunctionsQuickList();
	BuildFunctionsDetailList();
	$("#myResults").html(FunctionsList.length);	// get number of functions
	
	// on loading, if url has hash, update the window to show the info
	if (window.location.hash) {
		// console.log( "window has hash " + window.location.hash.substring(1) );
		updateWindow(window.location.hash.substring(1));
	}
	
	$('#search_input_quick').fastLiveFilter('#function_list_quick', {timeout: 0});
	// $('#search_input_detail').fastLiveFilter('#function_list_detail', {timeout: 0});
	
	// add stripes to the functions list
	// setOddEven();
	
	$(document.body).scrollTop($(location.hash).offset().top);
	
	$.ajaxSetup({async:true});
	
	$.getJSON("https://googledrive.com/host/0B-rpBcVy8AL7Zm13WnFQZGQ5eXM/userlangsversion.txt", function(data) {
		$("#VersionNumber").html('<p>' + 'Current Version: ' + data.currentVersion.version + ' on ' + data.currentVersion.date + '</p>' + '<p>' + 'Previous Version: ' + data.previousVersion.version + ' on ' + data.previousVersion.date + '</p>');
	})
	
	// when filtering the list, recalculate the stripes
	$("#function_list").resize(function(){
		setOddEven();
	});
});

function setOddEven() {
    $('#function_list li:visible:odd').removeClass('odd even').addClass('odd');
    $('#function_list li:visible:even').removeClass('odd even').addClass('even');
}

function CreateFunctionsArray () {
	// the list of files is passed in
	$.getJSON(functionListing, function(url) {
		// for each path in the list, break it down to a file and process that file
		$.each(url.paths, function(i, path) {	// path is the url to each individual functions file
			// process each file
			$.getJSON(path, function(data) {	// data is the function object
				// process each function and generate the html for it
				$.each(data, function(i, func) {
					FunctionsList.push(func);
				});
			});
		});
		// console.log("Functions array built");
		FunctionsList.sort(SortByName);
	});
}

function SortByName(a, b){
  var aName = a.Name.toLowerCase();
  var bName = b.Name.toLowerCase(); 
  return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
}

function BuildFunctionsQuickList () {
	$.each(FunctionsList, function(i, func) {
	// generates the quick list of functions
		var html = "";
		html += '<li>';
	// Return Type
		if(func.ReturnType[0] == undefined) {
			html += '(nothing) ';
		} else {
			if(func.ReturnType[0].url == '') {
				html += '(' + func.ReturnType[0].type + ') ';
			} else {
				html += '(<a href="#' + func.ReturnType[0].url + '">' + func.ReturnType[0].type + '</a>) ';
			}
		}
	// Calling Convention
		if (func.Convention == 'E') {
			html += '<em>reference</em>.';
		} else if(func.Convention == 'R') {
			html += 'reference.';
		} else if (func.Convention == 'B') {
			// nothing
		}
	// Function name
		html += '<span class="function"><a href="#' + func.Name + '">' + func.Name + '</a></span> ';
	// Parameters
		$.each(func.Parameters, function(j, param) {
			if (param.url == '') {
				if (param.optional == 'false') {
					html += param.type + ' ';
				} else{
					html += '<em>' + param.type + '</em> ';
				}
			} else {
				if (param.optional == 'false') {
					html += '<a href="#' + param.url + '">' + param.type + '</a> ';
				} else {
					html += '<em><a href="#' + param.url + '">' + param.type + '</a></em> ';
				}
			}
		});
		html += '</li>';
		html += '</span></p>';
		$('#function_list_quick').append(html);
	});
}
	
function BuildFunctionsDetailList () {
	$.each(FunctionsList, function(i, func) {
// generates the detail info of a function
		var html = '<li>';
	// Function name and Alias
		html += '<span class="type_code_list_number"><div><span class="function"><a name="' + func.Name + '" id="' + func.Name + '"></a><span class="function_name">' + func.Name + '</span></span><br />';
		html += '<p><strong>Alias:</strong> <span class="alias">';
		if(func.Alias == '') {
			html += 'none</span><br />';
		} else {
			html += func.Alias + '</span><br />';
		}
		
	// generates the usage example
		html += '<p><strong>Usage:</strong> <span class="mono ">';
		// Return Type
			if(func.ReturnType[0] == undefined) {
				html += '(nothing) ';
			} else {
				if(func.ReturnType[0].url == '') {
					html += '(' + func.ReturnType[0].type + ') ';
				} else {
					html += '(<a href="#' + func.ReturnType[0].url + '">' + func.ReturnType[0].type + '</a>) ';
				}
			}
		// Calling Convention
			if (func.Convention == 'E') {
				html += '<em>reference</em>.';
			} else if(func.Convention == 'R') {
				html += 'reference.';
			} else if (func.Convention == 'B') {
				// nothing
			}
		// Function name
			html += func.Name + ' ';
		// Parameters
			$.each(func.Parameters, function(j, param) {
				if (param.url == '') {
					if (param.optional == 'false') {
						html += param.type + ' ';
					} else{
						html += '<em>' + param.type + '</em> ';
					}
				} else {
					if (param.optional == 'false') {
						html += '<a href="#' + param.url + '">' + param.type + '</a> ';
					} else {
						html += '<em><a href="#' + param.url + '">' + param.type + '</a></em> ';
					}
				}
			});
			html += '</span></p>';
		
	// Parameters
		html += '<p><strong>Parameters:</strong> ' + func.Parameters.length + '</p>';
		html += '<div class="parameters mono">';
		$.each(func.Parameters, function(j, param) {
			if (param.url === '') {
				if (param.optional == 'false') {
					html += param.type + '<br />';
				} else{
					html += '<em>' + param.type + '</em><br />';
				}
			} else {
				if (param.optional == 'false') {
					html += '<a href="#' + param.url + '">' + param.type + '</a><br />';
				} else {
					html += '<em><a href="#' + param.url + '">' + param.type + '</a></em><br />';
				}
			}
		});
		html += '</div>';
	// Return Type
		html += '<p><strong>Return Type:</strong> ';
		if(func.ReturnType[0] == undefined) {
			html += 'Nothing' + '<br />';
		} else {
			if(func.ReturnType[0].url === '') {
				html += func.ReturnType[0].type + '<br />';
			} else {
				html += '<a href="#' + func.ReturnType[0].url + '">' + func.ReturnType[0].type + '</a></p>';
			}
		}
	// Is Condition function
		html += '<p><strong>Condition Function:</strong> ' + func.Condition + '</p>';
	// Version
		html += '<p><strong>Introduced In:</strong> <span class="version">' + func.Version + '</span></p>';
	// Calling Convention
		html += '<p><strong>Calling Convention:</strong> ';
		if (func.Convention == 'ByEither') {
			html += '<a href="#ByEither">E</a></p>';
		} else if(func.Convention == 'ByReference') {
			html += '<a href="#ByReference">R</a></p>';
		} else if (func.Convention == 'ByBaseForm') {
			html += '<a href="#ByBaseForm">B</a></p>';
		}
	// Description
		html += '<p><strong>Description:</strong></p><div class="description">';
		$.each(func.Description, function(j, lines) {
			html += '<p class="funcs_detail_p">' + lines + '</p>';
		});
		html += '</div>';
	// Examples
		html += '<p><strong>Examples:</strong></p>';
		$.each(func.Examples, function(j, examples) {
				var exampleNum = j+1;
				html += '<div class="example"><span class="example_entry">Example ' + exampleNum + '</span><pre class="prettyprint linenums">';
			$.each(examples.Example, function(k, line) {
				html += line + '\n';
			});
			html += '</pre></div>';
		});html += '</div></li>';
		$('#function_list_detail').append(html)
		prettyPrint();
	});
}

function updateWindow(name) {
	var func = $.grep(FunctionsList, function(e) { return e.Name === name });
	generateFunctionInfo(func);
}