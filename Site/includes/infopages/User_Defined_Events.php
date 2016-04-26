<p>In addition to the events supplied by OBSE, mods can also register event handlers for events dispatched by other mods. These types of events are referred to as "user-defined events". The event handler for a user-defined event always takes one argument: a Stringmap. The stringmap argument always includes the following two key-value pairs:</p>

<p class="mono">"eventName": a string indicating the event which occurred
	"eventSender": a string indicating the origin of the event. By default this is the filename of the mod which dispatched the event, unless that mod supplied an alternate sender name.</p>
	
<p>The stringmap argument will also contain any additional data supplied by the sender of the event.</p>

<p>To register an event handler for a user-defined event, use <a href="#SetEventHandler">SetEventHandler</a>. To dispatch an event to any registered listeners, use <a href="#DispatchEvent">DispatchEvent</a> Example:</p>

<?php
$source = "scriptname EventHandler
array_var args
begin Function {args}
	print \"Event \" + args->eventName + \" received from \" + args->eventSender
	print \$arg->activator + \" was activated by \" + \$arg->activatedBy
end";
include "includes/geshiencoder.php";
?>
<p></p>
<?php
$source = "scriptname EventSender
begin onActivate
	DispatchEvent \"Activated\" (ar_Map \"activator\"::GetSelf \"activatedBy\"::GetActionRef)
end";
include "includes/geshiencoder.php";
?>