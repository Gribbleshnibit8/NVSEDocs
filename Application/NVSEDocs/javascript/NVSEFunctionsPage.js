// global vars
var FunctionsList = [];
var NVSEVersion = 0;
var currentHash = '';
var lastHash = '';
var descriptionLinks = [];
// filterable function list
var functionList;

jQuery(document).ready(function($) {
    onload = loadData();

	
	// on loading, if url has hash, update the window to show the info
	if (window.location.hash) {
		//console.log( "window has hash " + window.location.hash.substring(1) );
        document.getElementById('home_content').style.display = "none";
		updateWindow(window.location.hash.substring(1));
	}

    // set/reset even/odd line colors when typing in search box
    setInterval("setOddEven();", 500);

    // get list of links in the description every few milliseconds to keep up to date
    setInterval("getDescLinks();", 500);
	
	$.getJSON("https://googledrive.com/host/0B-rpBcVy8AL7Zm13WnFQZGQ5eXM/userlangsversion.txt", function(data) {
		$("#VersionNumber").html('<p>' + 'Current Version: ' + data.currentVersion.version + ' on ' + data.currentVersion.date + '</p>' + '<p>' + 'Previous Version: ' + data.previousVersion.version + ' on ' + data.previousVersion.date + '</p>');
	})

	// on click a function li, update the page
    $("#function_list").on( "click", "li", function(){
        document.getElementById('home_content').style.display = "none";
        updatePageInfo(this.id);
        return false; // prevent default click action from happening!
	});

});

function setupSearchOptions() {
    var options = {
        valueNames: [ 'name', 'plugin_Name', 'alias', 'tags', 'version' ],
        listClass: "list",
        page: 3000
    };
    functionList = new List('function_quick_search', options);
}

function loadData() {
    $.ajaxSetup({async:false});
    CreateFunctionsArray();
    BuildFunctionList();
    $("#funcCount").html(FunctionsList.length);	// get number of functions
    $('#NVSEVers').html(NVSEVersion);

    // sets up the search plugin to handle the function list
    setupSearchOptions();

    $.ajaxSetup({async:true});
}

// generates a list of links from the description block and when one is clicked will trigger the element refresh
function getDescLinks() {
    descriptionLinks = document.getElementsByClassName("dlink");
    for (var i = 0; i < descriptionLinks.length; i++) {
        descriptionLinks[i].onclick = function() {
            updatePageInfo($( this ).text());
            return false; // prevent default click action from happening!
        }
    }
}

function updatePageInfo(location) {
    document.getElementById('home_content').style.display = "none";
    lastHash = currentHash;
    currentHash = location;
    window.location.hash = currentHash;
    updateWindow(currentHash);
}


// when forward or back pressed, when modal window opened/closed
window.onpopstate = function(event) {
	updateWindow(currentHash);
	// restores the last hash on closing a modal window
	if (window.location.hash === '#!') {
		window.location.hash = currentHash;
	}
	//alert("popstate change");
};

function setOddEven() {
    $('#function_list li:visible:odd').removeClass('odd even').addClass('odd');
    $('#function_list li:visible:even').removeClass('odd even').addClass('even');
}

function updateWindow(name) {
    var func = $.grep(FunctionsList, function(e) { return e.Name === name });
    generateFunctionInfo(func);
}

function SortByName(a, b){
    var aName = a.Name.toLowerCase();
    var bName = b.Name.toLowerCase();
    return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
}

$(document).ready(function(){
    $("#search").bind("change",setOddEven);
});

function CreateFunctionsArray () {
	// the list of files is passed in
    $.getJSON("json/functions.json", function(data) {
        $.each(data, function(i, func) {
            FunctionsList.push(func);
        });
    });
	FunctionsList.sort(SortByName);
}

// generates the quick list of functions
function BuildFunctionList () {
	$.each(FunctionsList, function(i, func) {
		var outString = "";
	// open the list item, create the id and add the name
		outString += '<li id="' + func.Name + '" class=" ">';
        outString += '<span class="name">' + func.Name + '</span>';
	// if the function is from a plugin, append the plugin name
		if (func.hasOwnProperty("FromPlugin"))
			outString += '<span class="plugin_Name">' + func.FromPlugin + '</span>';
	// create tags field
        if (func.hasOwnProperty("Alias"))
            outString += '<span class="alias noshow">' + func.Alias + '</span>';
        if (func.hasOwnProperty("Tags"))
            outString += '<span class="tags noshow">' + func.Tags + '</span>';
		if (func.hasOwnProperty("Version"))
			outString +=  '<span class="version noshow">' + func.Version + '</span>';
	// close the list item
		outString += '</li>';
		$('#function_list').append(outString);
	});
	$.each(FunctionsList, function(i, func) {
		if ((func.Version > NVSEVersion) && (func.hasOwnProperty("FromPlugin") == 0)) {
			NVSEVersion = func.Version;
		}
	});
}

// generates the detail info of a function
function generateFunctionInfo(data) {
	$.each(data, function(i, func) {
		var outString = "";
	// Function name and Alias
		outString += '<div class="function_info"><p class="function_name">' + func.Name +
		'<a target="_blank" title="View on the GECK wiki" href="http://geck.bethsoft.com/index.php?title=' + func.Name +
		'"><img id="geck_link" src="images/Icon_geckuser.png"></a></p>';

    // Alias
        outString += '<p><strong>Alias:</strong> ';
        outString += func.hasOwnProperty("Alias") ? func.Alias : 'none';
        outString += '</p>';


	// generates the usage example
		outString += '<p><strong>Usage:</strong> <span class="mono ">';
		// Return Type
            outString += GetReturnType(func, false);

		// Calling Convention
            outString += GetConventionType(func, false);

		// Function name
			outString += func.Name + ' ';

		// Parameters in function use example
            outString += GetParameters(func, false);
            outString += '</span></p>';
		
	// Parameters expanded list
        outString += GetParameters(func, true);

	// Return Type
        outString += GetReturnType(func, true);

	// Is Condition function
        outString += '<p><strong>Condition Function:</strong> ';
        outString += func.hasOwnProperty("Condition") ? func.Condition + '' : 'No';
        outString += '</p>';

	// Version
		outString += '<p><strong>Introduced In:</strong> <span class="version">';
        outString += func.hasOwnProperty("Version") ? func.Version : "Unknown";
		outString += '</span></p>';

	// Calling Convention
        outString += GetConventionType(func, true);

	// Description
		outString += '<p><strong>Description:</strong></p><div id="description" class="description">';
		$.each(func.Description, function(j, lines) {
			outString += Wiky.toHtml(lines);
		});
		outString += '</div>';
	// Examples
		if (func.hasOwnProperty("Examples")){
			outString += '<p><strong>Examples:</strong></p>';
			$.each(func.Examples, function(j, examples) {
				var exampleNum = j+1;
				outString += '<div class="example"><span class="example_entry">Example ' + exampleNum + '</span>';
                var ex = '';
				$.each(examples.Example, function(k, line) {
                    ex += line + '\n';
                    
				});
                outString += Wiky.toHtml('[(geck)%' + ex + '%]');
				outString += '</div>';
			});
		}
		
	// If from mod
		$('#plugin_name').empty();
		if (func.hasOwnProperty("FromPlugin")){
			$('#plugin_name').append('From Plugin: ' + func.FromPlugin);
		}
		
		$("#function_container").empty();
		$('#function_container').append(outString);
	});
}

// Generates the markup for a function's return type
function GetReturnType(func, full) {
    var outString = '';

    if (func.hasOwnProperty("ReturnType")) {
        var r = func.ReturnType[0];

        // If return type has a url, then wrap it in an anchor, otherwise just output the type.
        outString += r.hasOwnProperty("url") ? '<a href="#' + r.url + '">' + r.type + '</a>' : r.type;

        // If the return type has a value, wrap it in parentheses and append it to the end.
        if (r.hasOwnProperty("value")) outString += ' (' + r.value + ')';

    }
    else outString += 'Nothing';

    // If this is for the full output, add the type line, otherwise wrap in parentheses and output.
    outString = full === true ? '<p><strong>Return Type:</strong> ' + outString + '</p>' : '(' + outString + ') ';

    return outString;
}

// Generates the markup for a function's calling convention
function GetConventionType(func, full) {
    var outString = '';
    var rt = func.hasOwnProperty("ReferenceType") ? func.ReferenceType + "." : 'reference.';

    if (func.hasOwnProperty("Convention")) {
        var c = func.Convention;

        if (full === true) {
            outString += '<p><strong>Calling Convention:</strong> ';
            switch (c) {
                case 'E':
                    outString += '<a href="#ByEither">By Either</a></p>';
                    break;

                case 'R':
                    outString += '<a href="#ByReference">By Reference</a></p>';
                    break;

                case 'B':
                    outString += '<a href="#ByBaseForm">By Base Form</a></p>';
                    break;

            } // end switch

        } else {
            switch (c) {
                case 'E':
                    outString += '<em>' + rt + '</em>'; break;

                case 'R':
                    outString += rt;  break;

                case 'B':
                    break;
            } // end switch
        }

    } else {

        if (full === true) {
            outString += '<p><strong>Calling Convention:</strong> <a href="#ByEither">Either</a></p>';
        } else {
            outString += '<em>' + rt + '</em>';
        }
    }

    return outString;
}

// Generates the markup for a function's parameter sets
function GetParameters(func, full) {
    var outString = '';

    if (full === true) {
        outString += '<p><strong>Parameters:</strong> ';
        outString += func.hasOwnProperty("Parameters") ? func.Parameters.length + '</p><div class="parameters mono">' : '0</p>';
    }

    if (func.hasOwnProperty("Parameters")) {
        $.each(func.Parameters, function (j, param) {

            if (param.hasOwnProperty("url"))
                outString += param.hasOwnProperty("optional") ? '<em><a href="#' + param.url + '">' + param.type + '</a></em> ' : '<a href="#' + param.url + '">' + param.type + '</a> ';

            else
                outString += param.hasOwnProperty("optional") ? '<em>' + param.type + '</em>' : param.type;

            if (full === true && param.hasOwnProperty("value"))
                outString += param.hasOwnProperty("optional") ? ' <em>' + param.value + '</em>' : param.value;

            outString += full === true ? '<br />' : ' ';

        });; // end each loop
        if (full === true) outString += '</div>';
    }

    return outString;
}