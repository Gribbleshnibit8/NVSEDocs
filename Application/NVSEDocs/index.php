<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from http://NVSE.silverlock.org/NVSE_command_doc.html -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="generator" content="HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org" />
    <meta http-equiv="Content-Type" content="text/html; charset=us-ascii" />

    <title>NVSE Command Docs</title>

    <script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>

    <link rel="stylesheet" type="text/css" href="styles/modal.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="styles/scrollbars.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="styles/prettify.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="styles/SECommandDocsDefault.css" media="screen" />
    <link rel="alternate stylesheet" type="text/css" title="Dark" href="styles/SECommandDocsNV.css"   media="screen" />

    <link rel="stylesheet" type="text/css" href="https://code.google.com/p/google-code-prettify/source/browse/loader/prettify.css" media="screen" />
    <script type="text/javascript" src="https://google-code-prettify.googlecode.com/svn/loader/prettify.js"></script>
    <script type="text/javascript" src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>


    <script type="text/javascript" src="javascript/modal.js" ></script>
    <script type="text/javascript" src="javascript/themeswitcher.js" ></script>
    <script type="text/javascript" src="javascript/NVSEFunctionsPage.js" ></script>
    <script type="text/javascript" src="javascript/list.min.js" ></script>

    <link rel="stylesheet" type="text/css" href="styles/wiky.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="styles/wiky.geck.css" media="screen" />
    <script type="text/javascript" src="javascript/wiky.js"></script>
    <script type="text/javascript" src="javascript/wiky.geck.js"></script>


    <?php
    include_once "globals.php";
    include_once 'includes/geshi/geshi.php';
    ?>
</head>

<body>
<div id="maincontainer">

    <div id="topsection"><div class="innertube"><h1><span class="se_type">NVSE</span> Functions Guide</h1>
			<span style="float:right;margin-top:-20px;">Select theme:
				<a href="#" onclick="setCurrentStyleSheet('Default'); return false;">Default</a>
				<a href="#" onclick="setCurrentStyleSheet('Dark'); return false;">Dark</a>
			</span>
        </div></div>

    <div id="contentwrapper">
        <div id="contentcolumn" class="columns">
            <div class="innertube">
                <div style="position:relative; float:right; font-size:.8em;" id="form_link">
                    <a href="#Improve_This">Improve This</a>
                </div>
                <div id="plugin_name">
                </div>

                <div id="home_content">
                    <h2>Welcome to the New Vegas Script Extender documentation page.</h2>

                    <p>To get started, have a look at the list to the left. That list contains all functions (that I've documented fully) from the most recent versions of NVSE.</p>

                    <p>You can scroll down the list to find what you're looking for, or you can start typing in the filter box. Functions will be filtered by name, but you can also search for some functions by type.</p>

                    <p>For example, if you want to search for all math related functions, you could type "math" into the filter box and you'd be shown all math functions. Want to see UI functions? Filter by "interface".</p>

                    <p>Some things might not be quite so obvious. For example, while they aren't shown, you <em>can</em> filter by the alias name of functions that have them, or even the version number.</p>

                    <!--<p>View all of this in a single page <a href="list.php">here</a>.</p>-->
                </div>

                <div id="function_container"></div>

            </div>
        </div>
    </div>

    <div id="leftcolumn" class="columns">
        <div class="innertube">

            <div  id="function_quick_search">
                <input id="search" type="text" class="search" placeholder="Search" autofocus/>

                <span id="function_count">Total Functions: <span id="funcCount"></span></span>
                <span id="nvse_version">Version: <span id="NVSEVers"></span></span>

                <ul id="function_list" class="mono list" ></ul>

            </div>
            <div id="info_table">
                <div id="info_table_top">
                    <div><strong>More Information</strong></div>
                    <ul class="more_info_list">
                        <?php
                        /* gets the list of files in infopages, and generates a ul based on the file names */
                        buildUnorderedListFromDirectory('includes/infopages/*');
                        ?>
                    </ul>
                </div>
                <div id="info_table_bottom">
                    <!--<div style="width:400px;"><a href="#Type_Codes">Type Codes</a></div>-->
                    <div><strong>Type Codes</strong></div>
                    <ul class="more_info_list">
                        <?php
                        /* gets the list of files in type_codes, and generates a ul based on the file names */
                        buildUnorderedListFromDirectory('includes/type_codes/*');
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php
    /* gets the list of files in infopages and generates modal content sections for each file */
    buildModalContentFromDirectory('includes/infopages/*');
    /* gets the list of files in infopages/subpages and generates modal content sections for each file */
    buildModalContentFromDirectory('includes/infopages/subpages/*');
    /* gets the list of files in type_codes and generates modal content sections for each file */
    buildModalContentFromDirectory('includes/type_codes/*');
    buildModalContentFromFile('includes/Improve_This.php', 200);
    ?>

    <?php include "includes/footer.php"; ?>
</body>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-35071723-2']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
</html>