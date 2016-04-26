<div class="func_type_def">
	<p><code>Syntax Example: <i>reference.</i><strong>FunctionName</strong> someParameters</code><br />
		Examples:</p>
<?php
$source = "; get the base object of a given reference
ref baseObject
set baseObject to reference.GetBaseObject";
include "includes/geshiencoder.php";
?>

	<p>or</p>

<?php
$source = "; get the current health of the player's equipped weapon
float weaponHealth
set weaponHealth to player.GetEquippedCurrentHealth 5";
include "includes/geshiencoder.php";
?>

	<p>Functions with this calling convention use the reference to collect important information. All scripts running on an object or an actor reference have an implicit reference to that actor which will be used if another reference is not specified.</p>
</div>