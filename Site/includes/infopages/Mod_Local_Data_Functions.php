<p>In some circumstances it is useful for a mod to record information about its state independent of the savegame. For instance, a mod which uses NVSE commands to modify objects or settings may want to reset those changes when a different savegame is loaded. NVSE provides each loaded mod with the ability to define data which persists for the duration of the game session. Data is defined as key-value pairs, where the key is a string and the value is a number, object, or string. A script has access only to the data defined for the mod to which it belongs. In the example below, a quest script is used to make sure that modifications to the player's movement speed are recorded in the savegame and reset when a new savegame is loaded</p>

<?php
$source = "scriptName pcSpeedQuestScript
short moddedAmt		; the amount by which player's movement speed has been modified (stored in the savegame as a script variable)
short prevModAmt
begin gamemode
    if getGameLoaded				; a game has been loaded
    	if getGameRestarted == 0					; reset the player's movement speed
	    	let prevModAmt := GetModLocalData \"speedMod\"
	    	ModPCMovementSpeed -prevModAmt
	    endif

	    ; record the value from the savegame
	    SetModLocalData \"speedMod\" moddedAmt
    endif
end";
include "includes/geshiencoder.php";
?>
					
<p>A script attached to an activator in the gameworld modifies the player's movement speed by 10 each time it is activated and updates the local data</p>

<?php
$source = "begin OnActivate player
	let pcSpeedQuest.moddedAmt += 10
	SetModLocalData \"speedMod\" pcSpeedQuest.moddedAmt
	ModPCMovementSpeed 10
end";
include "includes/geshiencoder.php";
?>