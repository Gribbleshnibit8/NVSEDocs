<p>In Fallout, objects stored inside of the inventories of actors or containers are not references. However, it can be useful to treat them as references in order to modify them. OBSE provides this functionality through the use of "inventory references", which are specialized, temporary references representing a stack of one or more items inside of a container. Scripts can obtain an inventory reference in three ways: by iterating over the contents of a container, by requesting references to items in a container matching a particular base item using <a href="#GetInvRefsForItem">GetInvRefsForItem</a>, or by creating one directly using <a href="#CreateTempRef">CreateTempRef</a>.</p>

<p>Iteration is performed using a <a href="#ForEach">ForEach</a> loop. On each pass through the loop, the iterator variable is set to a temporary reference to a stack of identical items within the source container. Items are considered identical if they share the same health, soul level, ownership, and/or other values; if any one of these differ then the items are not considered identical and will be returned in different stacks. The order in which stacks are returned is arbitrary, but stacks of the same base object type are guaranteed to be returned consecutively. Note that the number and contents of the stacks returned may not correspond directly to those displayed in the inventory/container menu.</p>

<p>Within the loop, the temporary reference stored in the iterator variable can be treated almost exactly like a normal reference, allowing you to call functions like SetCurrentHealth, SetCurrentSoulLevel, etc on it. However, as soon as execution returns to the top of the loop the previous value of the iterator becomes invalid - the reference it held no longer exists, and has been replaced by a reference to the next stack of items in the container. When the loop ends, the final reference becomes invalid and the iterator variable is set to null. Therefore, you should never store a temporary reference and try to use it later on.</p>

<p>The temporary nature of inventory references require some extra care in their use. The contents of the source container should not be modified within the loop. In general:</p>

<ul>
	<li>If you move or remove the reference from within a loop using <a href="#RemoveMeIR">RemoveMeIR</a>, the reference becomes immediately invalid.</li>
	<li>Never use Remove/Add/Equip/UnequipItem/RemoveAllItems on the source container from within the loop. Using <a href="#EquipMe">EquipMe</a> and <a href="#UnequipMe">UnequipMe</a> to equip or unequip the current reference is fine.</li>
	<li>Don't use <a href="#SetRefCount">SetRefCount</a> to modify the quantity of an inventory reference.</li>
</ul>

<p>The following code illustrates inventory reference usage:</p>


<?php
$source = 
"scriptName ExampleInvRefSCR	; attached to a container/actor reference
ref iter
ref container
short count
begin onActivate
	let container := getSelf
	foreach iter <- container
		let count := iter.GetRefCount
		print \"Found \" + \$count + \" \" + iter.GetName + \"(s)\"
		if iter.GetOwner && iter.GetOwner != playerRef
			if iter.IsEquipped == 0		; can't remove equipped items
				; move stolen items to another container
				iter.RemoveMeIR someOtherContainerRef
			endif
		else
			; remove completely
			iter.RemoveMeIR
		endif
		; iter is now invalid because RemoveMeIR was used - so we won't attempt to continue using it
	loop	; now that loop has terminated, iter has been set to null (0)

	; create a temp ref to a weapon with a specific health value and quantity
	let iter := CreateTempRef weapSteelDagger
	iter.SetRefCount 5		; okay to use SetRefCount on a temp ref that is NOT in a container
	iter.SetCurrentHealth 10 	; damage the 5 daggers
	iter.CopyIR container		; container now contains 5 damaged daggers
	let iter := 0				; temp ref will be invalid next frame, set to null to be sure we don't try to re-use it
end";
include "includes/geshiencoder.php";
?>