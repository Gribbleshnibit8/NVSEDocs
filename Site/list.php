<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from http://NVSE.silverlock.org/NVSE_command_doc.html -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="generator" content="HTML Tidy for Linux/x86 (vers 25 March 2009), see www.w3.org" />
	<meta http-equiv="Content-Type" content="text/html; charset=us-ascii" />

	<title>NVSE Command Docs</title>

	<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	
	<script type="text/javascript" src="https://google-code-prettify.googlecode.com/svn/loader/prettify.js"></script>
	<script type="text/javascript" src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
	<link rel="stylesheet" type="text/css" href="https://code.google.com/p/google-code-prettify/source/browse/loader/prettify.css" media="screen" />
	
	<script type="text/javascript" src="javascript/fastLiveFilter.js"></script>
	
	<script type="text/javascript" src="javascript/NVSEListPage.js"></script>
	
	
	
	<!--headings-->
	<style type="text/css">
		body {
			min-width: 1000px;
		}
		.Section_Head {
			font-weight: bold;
			font-size: 25px;
		}

		.Sub_Head {
			font-size: 18px;
			padding-left: .5em;
			padding-top: 1.2em;
		}

		.block {
			padding-left: 1em;
			padding-bottom: 1em;
			padding-top: 1em;
			position: relative;
		}
	</style>

	<!--generic-->
	<style type="text/css">
		a, a:link, a:visited, a:hover, a:active {color:#0000FF;}

		.type_code_columns {
			column-width: 25em;
			-webkit-column-width: 30em;
		}

		.hor_line {
			border-style: solid;
			margin-bottom: 1em;
			margin-top: 1em;
		}

		.list {
			list-style-type: none;
			padding-left: 1em;
		}

		.type_code_list_content {
			padding-left: 2em;
		}

		.mono {
			font-family: monospace;
		}

		.mono_list {
			font-family: monospace;
			list-style-type: none;
			padding-left: 3em;
		}

		.mono_list li {
			padding-bottom: .3em;
			padding-top: .3em;
		}

		@media screen {
			p, li {
				max-width: 75%;
				word-wrap:break-word;
			}
		}
		@media handheld {
			p, li {
				width: 100%;
				word-wrap:break-word;
			}
		}
		
		textarea {
			resize: none;
			outline: none;
		}
		
		.mono_list li span:first-child {
			display: inline-block;
			text-align: right;
			width: 50px;
			float:left;
		}
		.mono_list li span:last-child {
			display: inline-block;
			width: 65%;
		}

	</style>

	<!--date-->
	<style type="text/css">
		#modifiedDate {
			float: right;
			position: absolute;
			display: block;
			top: 96px;
			left: 600px;
		}
	</style>
	
	<!--alt page link-->
	<style type="text/css">
		#altPage {
			float: right;
			position: absolute;
			display: block;
			top: 96px;
			left: 600px;
			width:100%;
		}
	</style>
	
	<!--function calling conventions-->
	<style type="text/css">
		.func_type_def {
			padding-bottom: 1em;
		}

		.func_type_def p{
			padding-left: 1em;
		}
	</style>

	<!--function quick reference-->
	<style type="text/css">
		#Function_Count {
			float: right;
			position: absolute;
			display: block;
			top: 37px;
			right: 25%;
		}

		#function_list_quick li {
			padding: .18em .1em;
		}

		#function_list_quick li:nth-child(odd) {
			background: #E3DAC9;
		}

		#function_quick_search {
			float: right;
			position: absolute;
			display: block;
			top: 37px;
			left: 330px;
		}
	</style>
	
	<!--functions in detail-->
	<style type="text/css">
		#funcs_detail {
		}
		#funcs_detail li{
			border: 1px solid black;
			padding: 8px 0px 8px 8px;
			margin-bottom: 5px;
		}
		#funcs_detail p{
			margin: 5px 0 0 10px;
		}
		#funcs_detail li:nth-child(odd) {
			background: #E3DAC9;
		}
		#function_detail_search {
			float: right;
			position: absolute;
			display: block;
			top: 37px;
			left: 330px;
		}
		.parameters {
			padding: 0 0 0 1.5em;
		}
		.function_name {
			font-size: 1.3em;
			font-weight: bold;
		}
		.funcs_detail_p, .example_entry {
			margin-left: 2em !important;
		}
	</style>

	<!--tables-->
	<style type="text/css">
		.table-plain {
			border-collapse: collapse;
			border-spacing: 0;
			font-family: monospace;
			font-size: 100%;
			padding: 0;
			table-layout: fixed;
		}

		.table-plain td {
			border: 1px #555 solid;
			min-width: 50px;
			max-width: 50px;
			padding: 0px;
			text-align: center;
			vertical-align: top;
		}
	</style>

	<!--quick menu-->
	<style type="text/css">
		#quick_menu {
			bottom: 5px;
			float: right;
			position: fixed;
			right: 5px;
			padding: 0px 5px 0px 0px;
			z-index: 999;
		}
		#quick_menu ul {
			text-align: right;
		}
		#quick_menu li {
			min-width: 50px;
			max-width: 100%;
		}
		#quick_menu li:not(:last-child) {
			display: none;
		}
		#quick_menu:hover li:not(:last-child) {
			display: block;
		}
		@media (max-width: 1000px) {
			#quick_menu {
				background: rgba(0, 0, 0, 0.8);
			}
			#quick_menu a, #quick_menu a:link, #quick_menu a:visited, #quick_menu a:hover, #quick_menu a:active {color:#fff;}
		}
	</style>

	<!--tootip-->
	<style type="text/css">
		/*tooltip class for information about a certain element. Information will be held off screen until the link is hovered over*/
		.tooltip {
			border-bottom: 1px dotted #000000; color: #000000; outline: none;
			color: black !important;
			cursor: help; text-decoration: none;
			position: relative;
			margin-left: 1em;
		}
		.tooltip span {
			margin-left: -999em;
			position: absolute;
		}
		.tooltip:hover span {
			background: #9FDAEE;
			border: 1px solid #2BB0D7;
			border-radius: 5px 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;
			box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); -moz-box-shadow: 5px 5px rgba(0, 0, 0, 0.1);
			font-family: Calibri, Tahoma, Geneva, sans-serif;
			position: absolute; left: -7em; top: 2em; z-index: 99;
			margin-left: 0; width: 275px;
			padding: 0.5em 0.8em 0.8em 2em;
		}
	</style>

</head>

<body>
	<div id="quick_menu" >
		<ul class="list">
			<li><a href="#Function_Quick_Reference" title="">Function Quick Reference</a></li>
			<li><a href="#Function_Syntax_Format">Function Syntax Format</a></li>
			<li><a href="#Function_Calling_Conventions">Function Calling Conventions</a></li>
			<li><a href="#Bit_Value_Notation">Bit Value Notation</a></li>
			<li><a href="#FormatSpecifiers">Format Specifiers</a></li>
			<li><a href="#Array_Variables">Array Variables</a></li>
			<li><a href="#String_Variables">String Variables</a></li>
			<li><a href="#Flow_Control_Functions">Flow Control Functions</a></li>
			<li><a href="#Mod_Local_Data_Functions">Mod Local Data Functions</a></li>
			<li><a href="#NVSE_Expressions">NVSE Expressions</a></li>
			<li><a href="#User_Defined_Functions">User-Defined Functions</a></li>
			<li><a href="#Functions_In_Detail">Functions in Detail</a></li>
			<li><a href="#Type_Codes">Type Codes</a></li>
			<li><a href="#top" title="Click to go to top">To Top</a></li>
		</ul>
	</div>

	<a name="top" href="#top"></a>

	<div class="block"><!--Table of Contents-->
		<h1>Fallout: New Vegas Script Extender Command Documentation</h1>
		<strong>Table of Contents</strong>
		<ul class="table_of_contents">
			<li><a href="#Function_Quick_Reference">Function Quick Reference</a></li>
			<li><a href="#Function_Syntax_Format">Function Syntax Format</a></li>
			<li><a href="#Function_Calling_Conventions">Function Calling Conventions</a></li>
			<li><a href="#Bit_Value_Notation">Bit Value Notation</a></li>
			<li><a href="#FormatSpecifiers">Format Specifiers</a></li>
			<li><a href="#Array_Variables">Array Variables</a></li>
			<li><a href="#String_Variables">String Variables</a></li>
			<li><a href="#Flow_Control_Functions">Flow Control Functions</a></li>
			<li><a href="#Mod_Local_Data_Functions">Mod Local Data Functions</a></li>
			<li><a href="#NVSE_Expressions">NVSE Expressions</a></li>
			<li><a href="#User_Defined_Functions">User-Defined Functions</a></li>
			<li><a href="#Functions_In_Detail">Functions in Detail</a></li>
			<li><a href="#Type_Codes">Type Codes</a></li>
			<ul class="table_of_contents">
				<li><a href="#Actor_Flags_High">Actor Flags High</a></li>
				<li><a href="#Actor_Flags_Low">Actor Flags Low</a></li>
				<li><a href="#Actor_Value_Codes">Actor Value Codes</a></li>
				<li><a href="#Attack_Animations">Attack Animations</a></li>
				<li><a href="#Control_Codes">Control Codes</a></li>
				<li><a href="#DirectX_Scancodes">DirectX Scancodes</a></li>
				<li><a href="#Equip_Type">Equip Type</a></li>
				<li><a href="#Equipment_Slot_IDs">Equipment Slot IDs</a></li>
				<li><a href="#Form_Type_IDs">Form Type IDs</a></li>
				<li><a href="#Reload_Animations">Reload Animations</a></li>
				<li><a href="#Weapon_Flags_1">Weapon Flags 1</a></li>
				<li><a href="#Weapon_Flags_2">Weapon Flags 2</a></li>
				<li><a href="#Weapon_Hand_Grips">Weapon Hand Grips</a></li>
				<li><a href="#Weapon_Mod_Effect">Weapon Mod Effect</a></li>
				<li><a href="#Weapon_Mod_Flags">Weapon Mod Flags</a></li>
				<li><a href="#Weapon_Mod_Index">Weapon Mod Index</a></li>
				<li><a href="#Weapon_Type">Weapon Type</a></li>
			</ul>
			<li><a href="#Additional_Resources">Additional Resources</a></li>
		</ul>
		<div id="modifiedDate"></div>
		<div id="altPage">
			<p>View this in single page format <a href="index.php">here</a>.
		</div>
	</div>

	<hr class="hor_line" />

	<div class="block"><!--Function Quick Reference-->
		<p><span class="Section_Head"><a name="Function_Quick_Reference" id="Function_Quick_Reference"></a>Function Quick Reference</span></p>
		
		<span id="Function_Count">Total Functions: <span id="myResults"></span></span>
		
		<div id="quick-reference-list">
			<div  id="function_quick_search">
				<input id="search_input_quick" placeholder="Filter" />
				<a class="tooltip" href="#" onclick="return false">Information<span class="critical">You can use this search field to filter the functions by their name. Type the name or part of the name of a function to filter.</span></a>
			</div>
			<ul id="function_list_quick" class="mono list"></ul>
		</div>
	</div>

	<hr class="hor_line" />
	<div class="block"><!--Function Syntax Format-->
		<p><span class="Section_Head"><a name="Function_Syntax_Format" id="Function_Syntax_Format"></a>Function Syntax Format</span></p>
		<?php include 'infopages/function_syntax_format.php'; ?>
	</div>

	<hr class="hor_line" />
	<div class="block"><!--Function Calling Conventions-->
		<p><span class="Section_Head"><a name="Function_Calling_Conventions" id="Function_Calling_Conventions"></a>Function Calling Conventions</span></p>
		<?php include 'infopages/function_calling_convention.php'; ?>
	</div>

	<hr class="hor_line" />
	<div class="block"><!--Bit Value Notation-->
		<p><span class="Section_Head"><a name="Bit_Value_Notation" id="Bit_Value_Notation"></a>Bit Value Notation</span></p>
		<?php include 'infopages/bit_value_notation.php'; ?>
	</div>
	
	<hr class="hor_line" />
	<div class="block"><!--Format Specifiers-->
		<p><span class="Section_Head"><a name="FormatSpecifiers" id="FormatSpecifiers"></a>Format Specifiers</span></p>
		<?php include 'infopages/format_specifiers.php'; ?>
	</div>
	
	<hr class="hor_line" />
	<div class="block"><!--Array Variables-->
		<p><span class="Section_Head"><a name="Array_Variables" id="Array_Variables"></a>Array Variables</span></p>
		<?php include 'infopages/array_variables.php'; ?>
	</div>
	
	<hr class="hor_line" />
	<div class="block"><!--String Variables-->
		<p><span class="Section_Head"><a name="String_Variables" id="String_Variables"></a>String Variables</span></p>
		<?php include 'infopages/string_variables.php'; ?>
	</div>
	
	<hr class="hor_line" />
	<div class="block"><!--Flow Control Functions-->
		<p><span class="Section_Head"><a name="Flow_Control_Functions" id="Flow_Control_Functions"></a>Flow Control Functions</span></p>
		<?php include 'infopages/flow_control.php'; ?>
	</div>
	
	<hr class="hor_line" />
	<div class="block"><!--Mod Local Data Functions-->
		<p><span class="Section_Head"><a name="Mod_Local_Data_Functions" id="Mod_Local_Data_Functions"></a>Mod Local Data Functions</span></p>
		<?php include 'infopages/mod_local_data_functions.php'; ?>
	</div>
	
	<hr class="hor_line" />
	<div class="block"><!--NVSE Expressions-->
		<p><span class="Section_Head"><a name="NVSE_Expressions" id="NVSE_Expressions"></a>NVSE Expressions</span></p>
		<?php include 'infopages/nvse_expressions.php'; ?>
	</div>
	
	<hr class="hor_line" />
	<div class="block"><!--Mod Local Data Functions-->
		<p><span class="Section_Head"><a name="User_Defined_Functions" id="User_Defined_Functions"></a>User-Defined Functions</span></p>
		<?php include 'infopages/user_defined_functions.php'; ?>
	</div>

	<hr class="hor_line" />
	<div class="block"><!--Functions In Detail-->
		<p><span class="Section_Head"><a name="Functions_In_Detail" id="Functions_In_Detail"></a>Functions In Detail</span></p>

		<div id="funcs_detail">
			<div  id="function_detail_search">
				<input id="search_input_detail" class="search" id="searchBox" placeholder="Filter" /><a class="tooltip" href="#" onclick="return false">Information<span class="critical">You can use this search field to filter the functions by their name or version. Type the name or part of the name of a function to filter.</span></a>
				<!--<input type="button" value="List functions" onclick=""document.forms['search'].search.value = 'list'; return false;"">-->
			</div>
			<ul id="function_list_detail" class="list"></ul>
		</div>
	</div>

	<hr class="hor_line" />
	<div class="block">
		<p><span class="Section_Head"><a name="Type_Codes" id="Type_Codes"></a>Type Codes</span></p>
		
		<p><!--Actor_Flags_High-->
			<div class="Sub_Head"><a name="Actor_Flags_High" id="Actor_Flags_High"></a>Actor Flags High</div>
			<?php include 'infopages/type_codes/type_codes_actor_flags_high.php'; ?>
		</p>
		
		<p><!--Actor_Flags_Low-->
			<div class="Sub_Head"><a name="Actor_Flags_Low" id="Actor_Flags_Low"></a>Actor Flags Low</div>

		</p>

		<p><!--Actor_Value_Codes-->
			<div class="Sub_Head"><a name="Actor_Value_Codes" id="Actor_Value_Codes"></a>Actor Value Codes</div>
			<?php include 'infopages/type_codes/type_codes_actor_value_codes.php'; ?>
		</p>

		<p><!--Attack_Animations-->
			<div class="Sub_Head"><a name="Attack_Animations" id="Attack_Animations"></a>Attack Animations</div>
			<?php include 'infopages/type_codes/type_codes_attack_animations.php'; ?>
		</p>

		<p><!--Biped_Path_Codes-->
			<div class="Sub_Head"><a name="Biped_Path_Codes" id="Control_Codes"></a>Biped Path Codes</div>
			<?php include 'infopages/type_codes/type_codes_biped_path_codes.php'; ?>
		</p>
		
		<p><!--Control_Codes-->
			<div class="Sub_Head"><a name="Control_Codes" id="Control_Codes"></a>Control Codes</div>
			<?php include 'infopages/type_codes/type_codes_control_codes.php'; ?>
		</p>

		<p><!--DirectX_Scancodes-->
			<div class="Sub_Head"><a name="DirectX_Scancodes" id="DirectX_Scancodes"></a>DirectX Scancodes</div>
			<?php include 'infopages/type_codes/type_codes_scancodes.php'; ?>
		</p>
	
		<p><!--Equip_Type-->
			<div class="Sub_Head"><a name="Equip_Type" id="Equip_Type"></a>Equip Type</div>
			<?php include 'infopages/type_codes/type_codes_equip_type.php'; ?>
		</p>

		<p><!--Equipment_Slot_IDs-->
			<div class="Sub_Head"><a name="Equipment_Slot_IDs" id="Equipment_Slot_IDs"></a>Equipment Slot IDs</div>
			<?php include 'infopages/type_codes/type_codes_equip_slots.php'; ?>
		</p>

		<p><!--Form_Type_IDs-->
			<div class="Sub_Head"><a name="Form_Type_IDs" id="Form_Type_IDs"></a>Form Type IDs</div>
			<?php include 'infopages/type_codes/type_codes_formtypeID.php'; ?>
		</p>

		<p><!--Reload_Animations-->
			<div class="Sub_Head"><a name="Reload_Animations" id="Reload_Animations"></a>Reload Animations</div>
			<?php include 'infopages/type_codes/type_codes_reload_animations.php'; ?>
		</p>

		<p><!--Weapon_Flags_1-->
			<div class="Sub_Head"><a name="Weapon_Flags_1" id="Weapon_Flags_1"></a>Weapon Flags 1</div>
			<?php include 'infopages/type_codes/type_codes_weapon_flags_1.php'; ?>
		</p>

		<p><!--Weapon_Flags_2-->
			<div class="Sub_Head"><a name="Weapon_Flags_2" id="Weapon_Flags_2"></a>Weapon Flags 2</div>
			<?php include 'infopages/type_codes/type_codes_weapon_flags_2.php'; ?>
		</p>

		<p><!--Weapon_Hand_Grips-->
			<div class="Sub_Head"><a name="Weapon_Hand_Grips" id="Weapon_Hand_Grips"></a>Weapon Hand Grips</div>
			<?php include 'infopages/type_codes/type_codes_weapon_hand_grips.php'; ?>
		</p>

		<p><!--Weapon_Mod_Effect-->
			<div class="Sub_Head"><a name="Weapon_Mod_Effect" id="Weapon_Mod_Effect"></a>Weapon Mod Effect</div>
			<?php include 'infopages/type_codes/type_codes_weapon_mod_effect.php'; ?>
		</p>
		
		<p><!--Weapon_Mod_Flags-->
			<div class="Sub_Head"><a name="Weapon_Mod_Flags" id="Weapon_Mod_Flags"></a>Weapon Mod Flags</div>
			<?php include 'infopages/type_codes/type_codes_weapon_mod_flags.php'; ?>
		</p>

		<p><!--Weapon_Mod_Index-->
			<div class="Sub_Head"><a name="Weapon_Mod_Index" id="Weapon_Mod_Index"></a>Weapon Mod Index</div>
			<?php include 'infopages/type_codes/type_codes_weapon_mod_index.php'; ?>
		</p>

		<p><!--Weapon_Type-->
			<div class="Sub_Head"><a name="Weapon_Type" id="Weapon_Type"></a>Weapon Type</div>
			<?php include 'infopages/type_codes/type_codes_weapon_type.php'; ?>
		</p>
	</div>

	<div class="block"><!--Additional_Resources-->
		<p><span class="Section_Head"><a name="Additional_Resources" id="Additional_Resources"></a>Additional Resources</span></p>
		<?php include 'infopages/additional_resources.php'; ?>
	</div>
</body>

	<!--date modified-->
	<script type="text/javascript">
		function date_ddmmmyy(c){var e=c.getDate();var a=c.getMonth()+1;var f=c.getYear();if(f>=2000){f-=2000}if(f>=100){f-=100}var b=(1==a)?"Jan":(2==a)?"Feb":(3==a)?"Mar":(4==a)?"Apr":(5==a)?"May":(6==a)?"Jun":(7==a)?"Jul":(8==a)?"Aug":(9==a)?"Sep":(10==a)?"Oct":(11==a)?"Nov":"Dec";return""+(e<10?"0"+e:e)+"-"+b+"-"+(f<10?"0"+f:f)}function date_lastmodified(){var a=document.lastModified;var b="Unknown";var c;if(0!=(c=Date.parse(a))){b=""+date_ddmmmyy(new Date(c))}return b}
		$("#modifiedDate").html("This page was last modified on "+date_lastmodified());
	</script>
</html>
