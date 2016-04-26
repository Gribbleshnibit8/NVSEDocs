<div class="func_type_def">
	<strong>Calling by Either Reference or Base Form (E):</strong><br />
	<p><code>Syntax Example: <i>reference.</i><strong>FunctionName</strong> someParameters <i>objectID:ref</i></code><br />
		Examples:</p>

<?php
$source = "int health
ref weaponBaseForm
set health to GetHealth weaponBaseForm";
include "includes/geshiencoder.php";
?>

	<p>or</p>

<?php
$source = "int health
ref droppedWeaponRef
set health to weaponRef.GetHealth";
include "includes/geshiencoder.php";
?>

	<p>Many NVSE functions can be called using either Reference or Base Form syntax. These functions will have an optional calling reference and the last argument will be an optional object or form parameter. These functions will use the last optional base form argument to identify the form to act upon if provided, but if not provided will act upon the base form of the calling reference (if any). This provides a single function which can be used either with a reference to an instance of an object, or on the base form itself.</p>
</div>