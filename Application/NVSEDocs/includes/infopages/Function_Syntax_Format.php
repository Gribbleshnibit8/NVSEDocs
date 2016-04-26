<p><code>(ReturnType) reference.FunctionName requiredParameter1:Type <i>optionalParameter2:Type</i></code></p>

<p><strong>Return Type</strong>: the type of value the function Returns. Sometimes this will also have a descriptive name, if the return value is not obvious based on the function definition.</p>

<p><strong>reference</strong>: If in plain text a required reference the function must be called upon. In an object script the object the	script is attached to is considered the implicit reference for the function. If italicized, the reference is optional but can be used to identify the object for the function to use. Usually the optional reference is teamed with an optional last argument which takes the place of the optional reference if used.</p>

<p><strong>FunctionName:</strong> the main name of the function and a link to the function details.</p>

<p><strong>requiredParameter:Type:</strong> a parameter in plain text is a required parameter that must be provided. The Type is the type of parameter needed.</p>

<p><strong>optionalParameter:Type:</strong> a parameter in italics is an optional parameter which can be provided. If not provided, a default value is used in its place.</p>

<p><strong>Parameter and Return Types</strong></p>
<ul id="list">
	<li>Bool - an integer with a value of 0 (false) or 1 (true)</li>
	<li>Float - a positive or negative floating point number</li>
	<li>Integer - a positive integral number</li>
	<li>IntegerOrFloat - either an integer or a float</li>
	<li>BaseForm - a base form type whose values apply to all instances of that form</li>
	<li>ObjectRef - a specific instance of a base form type</li>
	<li>GenericObject - a base form object type. Frequently used when passing a form type which has no specific parameter type. As such the form identifier is first placed in a ref variable and that ref variable is used as the parameter.</li>
	<li>InventoryObject - a base form object type which can be placed in an Inventory (weapon, armor, aid, misc item)</li>
	<li>MagicItem - a base effect form.</li>
</ul>