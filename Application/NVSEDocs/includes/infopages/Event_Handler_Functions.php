<p>An event handler is a user-defined function designed to respond to game events. Rather than calling the function directly, the scripter uses <a href="#SetEventHandler">SetEventHandler</a> to register it as a handler for a specific event. When the associated event occurs during gameplay, NSVE will invoke any handlers for that event, passing information about the event to the function through its arguments.</p>

<p>Events include block types such as "OnHit", "OnDeath", and so on, as well as other events involving loading, saving, and exiting the game. Each event expects its handlers to accept a specific set of arguments. The supported events, including any required arguments (listed in the order in which they should appear in the function definition) are listed below:</p>

<p>For events associated with block types, you may provide a specific value for any, all, or none of the arguments when registering an event handler. The first argument is referred to by the name "ref" and the second as "object", regardless of the names of the argument variables in your function script (exception: for OnHealthDamage, "object" refers to the damaged actor). Doing so allows you to filter out events you're not interested in. For instance, to handle events involving the player being hit by another actor, use SetEventHandler OnHit yourScript ref::playerRef. To handle events in which the player, and only the player, hits anyone else, use SetEventHandler OnHit yourScript object::playerRef. To handle the player being affected by a Restore Health magic effect, use SetEventHandler OnMagicEffectHit yourScript ref::playerRef object::"REHE".</p>

<p>It is recommended that you prefer to filter events as strictly as possible to allow NSVE to avoid calling your handler for events you're not interested in. Further, once an event handler becomes unneeded (for instance, if the target of the handler dies), use RemoveEventHandler to remove it; this prevents NSVE from having to check against the defunct handler when processing events. Be aware that event handler scripts are invoked at the moment the event is registered by the game. For example, an OnEquip handler is invoked when an actor decides to equip an item, but before the item is actually equipped, which means that trying to unequip the item from within the handler will fail. IMPORTANT: avoid using AddSpell to add an ability or disease to an actor from within an OnMagicEffectHit handler, as doing so may cause the game to become unstable.</p>

<p>This list is currently incomplete!</p>


<table class="table_plain">
<caption style="font-size: 110%; background-color: #ffffff;">Events</caption>   
	<tbody>
		<tr>
			<th width="15%">Name</th>
			<th width="25%">Parameters</th>
			<th width="60%">Notes</th></tr>
		<tr>
		
		<tr>
			<td>OnActivate</td>
			<td class="mono">ref:Activator\ed <br/> ref:ActionRef</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnAdd</td>
			<td class="mono">ref:AddedTo <br/> ref:Added</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnActorEquip</td>
			<td class="mono">ref:Equipper <br/> ref:Equipped</td>
			<td class="table_plain_left">Seen working. Depending of the source event, using Print/PrintC from the event handler can be purposely forbidden.
			Also seen fired in strange context, like an actor equipping another</td>
		</tr>
		<tr>
			<td>OnActorUnequip</td>
			<td class="mono">ref:Unequipper <br/> ref:Unequipped</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnClose</td>
			<td class="mono">ref:Closed <br/> ref:Closer</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnCombatEnd</td>
			<td class="mono">ref:Target <br/> ref:Ender</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnDeath</td>
			<td class="mono">ref:Killed <br/> ref:Killer</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnDrop</td>
			<td class="mono">ref:Dropper <br/> ref:Dropped</td>
			<td class="table_plain_left">DroppedItem is the new reference in the game world to the dropped item</td>
		</tr>
		
		<tr>
			<td>OnHit</td>
			<td class="mono">ref:Target <br/> ref:Attacker</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnHitWith</td>
			<td class="mono">ref:Target <br/> ref:Weapon</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnLoad</td>
			<td class="mono">ref:Loaded</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnMagicEffectHit</td>
			<td class="mono">ref:Target <br/> ref:BaseEffect</td>
			<td class="table_plain_left">Changed from OBSE. Passes the EffectSetting, not the effectCode, which doesn't exist.</td>
		</tr>
		<tr>
			<td>OnMurder</td>
			<td class="mono">ref:Killed <br/> ref:Killer</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnOpen</td>
			<td class="mono">ref:Opened <br/> ref:Opener</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnPackageChange</td>
			<td class="mono">ref:Actor <br/> ref:Package</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnPackageDone</td>
			<td class="mono">ref:Actor <br/> ref:Package</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnPackageStart</td>
			<td class="mono">ref:Actor <br/> ref:Package</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnReset</td>
			<td class="mono">ref:WhatsReset</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnSell</td>
			<td class="mono">ref:SoldItem <br/> ref:Seller</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnStartCombat</td>
			<td class="mono">ref:Target <br/> ref:Starter</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnTrigger</td>
			<td class="mono">ref:Trigger <br/> ref:ActionRef</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnTriggerEnter</td>
			<td class="mono">ref:Trigger <br/> ref:ActionRef</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnTriggerLeave</td>
			<td class="mono">ref:Trigger <br/> ref:ActionRef</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>SayToDone</td>
			<td class="mono">ref:Speaker <br/> ref:Info</td>
			<td class="table_plain_left"></td>
		</tr>

		<tr>
			<td>ExitGame</td>
			<td class="mono">NONE</td>
			<td class="table_plain_left">Exiting from main menu or in-game menu.</td>
		</tr>
		<tr>
			<td>ExitToMainMenu</td>
			<td class="mono">NONE</td>
			<td class="table_plain_left">exiting from in-game menu to main menu</td>
		</tr>
		<tr>
			<td>LoadGame</td>
			<td class="mono">filename:string <br/> length:int</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>SaveGame</td>
			<td class="mono">filename:string <br/> length:int</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>PostLoadGame</td>
			<td class="mono">gameLoadedSuccessfully:bool</td>
			<td class="table_plain_left">0 if error occurred during load (corrupt savegame?), 1 otherwise</td>
		</tr>
		<tr>
			<td>QQQ</td>
			<td class="mono">NONE</td>
			<td class="table_plain_left">exiting via QQQ/QuitGame console command</td>
		</tr>
		<tr>
			<td>OnNewGame</td>
			<td class="mono">NONE</td>
			<td class="table_plain_left">user starts a new game from the main menu</td>
		</tr>
		
		<tr>
			<td>RuntimeScriptError</td>
			<td class="mono">gameLoadedSuccessfully:bool</td>
			<td class="table_plain_left">0 if error occurred during load (corrupt savegame?), 1 otherwise</td>
		</tr>
		<tr>
			<td>DeleteGame</td>
			<td class="mono">NONE</td>
			<td class="table_plain_left">exiting via QQQ/QuitGame console command</td>
		</tr>
		<tr>
			<td>RenameGame</td>
			<td class="mono">NONE</td>
			<td class="table_plain_left">user starts a new game from the main menu</td>
		</tr>
		<tr>
			<td>NewGame</td>
			<td class="mono">gameLoadedSuccessfully:bool</td>
			<td class="table_plain_left">0 if error occurred during load (corrupt savegame?), 1 otherwise</td>
		</tr>
		<tr>
			<td>DeleteGameName</td>
			<td class="mono">NONE</td>
			<td class="table_plain_left">exiting via QQQ/QuitGame console command</td>
		</tr>
		<tr>
			<td>RenameGameName</td>
			<td class="mono">NONE</td>
			<td class="table_plain_left">user starts a new game from the main menu</td>
		</tr>
		<tr>
			<td>RenameNewGameName</td>
			<td class="mono">NONE</td>
			<td class="table_plain_left">user starts a new game from the main menu</td>
		</tr>
	</tbody>
</table>



		
		
		<!--<tr>
			<td>OnAlarm Steal</td>
			<td>alarmedActor:ref criminal:ref</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnAlarm Attack</td>
			<td>alarmedActor:ref criminal:ref</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnAlarm Pickpocket</td>
			<td>alarmedActor:ref criminal:ref</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnAlarm Murder</td>
			<td>alarmedActor:ref criminal:ref</td>
			<td class="table_plain_left"></td>
		</tr>
		<tr>
			<td>OnFallImpact</td>
			<td>faller:ref</td>
			<td class="table_plain_left">invoked when a falling actor hits the ground with sufficient velocity to be potentially damaging, before damage is applied</td>
		</tr>
		<tr>
			<td>OnMapMarkerAdd</td>
			<td>mapMarker:ref</td>
			<td class="table_plain_left"></td>
		</tr>	
		<tr>
			<td>OnHealthDamage</td>
			<td>damage:float attacker:ref</td>
			<td class="table_plain_left">Invoked <strong>on</strong> the actor taking damage (i.e. GetSelf will return the damaged actor) whenever damage is taken. "Attacker" may be zero e.g. when taking damage from falling. The handler is invoked just before the damage is applied, so it can be nullified by commands like ModActorValue. Use the <strong>object</strong> filter to specify the damaged actor to which your event handler should be attached, if any.</td>
		</tr>
		<tr>
			<td>OnAttack</td>
			<td>actor:ref</td>
			<td class="table_plain_left">Slightly misnamed. Invoked whenever <strong>actor</strong> begins the animation sequence for a melee or staff attack or a spell cast. Use commands like IsCasting to determine the current action.</td>
		</tr>
		<tr>
			<td>OnBowAttack</td>
			<td>actor:ref</td>
			<td class="table_plain_left">actor begins the animation of drawing his bowstring</td>
		</tr>
		<tr>
			<td>OnRelease</td>
			<td>actor:ref</td>
			<td class="table_plain_left">animation begun by OnAttack or OnBowAttack completes - e.g., actor releases an arrow shot, swings his weapon, or releases a spell projectile.</td>
		</tr>
		<tr>
			<td>OnBlock</td>
			<td>actor:ref</td>
			<td class="table_plain_left">actor begins block animation</td>
		</tr>
		<tr>
			<td>OnRecoil</td>
			<td>actor:ref</td>
			<td class="table_plain_left">actor begins recoil animation</td>
		</tr>
		<tr>
			<td>OnStagger</td>
			<td>actor:ref</td>
			<td class="table_plain_left">actor begins stagger animation</td>
		</tr>
		<tr>
			<td>OnDodge</td>
			<td>actor:ref</td>
			<td class="table_plain_left">actor begins dodge animation</td>
		</tr>-->