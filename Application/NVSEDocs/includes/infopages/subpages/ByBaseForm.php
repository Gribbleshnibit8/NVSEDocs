<div class="func_type_def">
	<p><code>Syntax Example: <strong>FunctionName</strong> someParameters objectID:ref</code><br />
		Examples:</p>

<?php
$source = "; get the form at index 2 (3rd item) of the Alcholic Drinks form list
ref form
set form to ListGetNthForm AlchohlicDrinks 2";
include "includes/geshiencoder.php";
?>
	
	<p>Most Fallout scripting functions use	this calling convention, where all information is passed into the function as a parameter. These parameters can be base forms, integers, floats, form lists or references. Base forms can either be passed in using the Editor Name directly, or the base form could be put into a reference variable first. In some documentation you will see the term ObjectID rather than Base Form - these terms are mostly interchangeable.</p>
</div>