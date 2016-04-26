<p>NVSE 4.2 introduces the string_var datatype for representing strings of characters. String variables can be declared and used like normal variables and can hold the return values from OBSE commands defined as returning a string_var. Their contents are preserved with the savegame. String-related commands include commands to modify a string variable and commands to retrieve a game string and store it in a string variable. Additionally, many existing commands like <code>SetName</code> now have EX counterparts (i.e. <code>SetNameEX</code>) which can accept a format string and a variable number of arguments, including string variables.</p>

<p>A string variable should not be used until it has been initialized with a value, by using it on the left hand side of a call to <code>sv_Construct</code> or a command that returns a string. An uninitialized string variable has a value of zero, which can be tested for in scripts. The value of an initialized string, on the other hand, is undefined and should never be modified directly by statements such as <code>set someStringVar to 6</code> or using arithmetic operators. Similarly, string variables should <em>only</em> be used to store strings, and the result of a string-returning variable should <em>only</em> (and <em>always</em>) be assigned to a string variable. Note that direct assignment of one string variable to another causes both variables to refer to the same string. For instance, in the following code:</p>

<?php
$source = "string_var string1
string_var string2
set string1 to sv_Construct \"First string\"
set string2 to string1	set string1 to sv_Construct \"Second string\" ; modifies both string1 and string2";
include "includes/geshiencoder.php";
?>

<p>both string1 and string2 end up containing "Second string." If this is not desired behavior, use <code>sv_Construct</code> to copy the contents of one string to another, i.e.:</p>

<?php
$source = "set string2 to sv_Construct \"%z\" string1 ; copies string1's contents to string2
set string2 to player.GetName ; modifies only string2";
include "includes/geshiencoder.php";
?>

<p>String variables persist in the savegame until they are explicitly destroyed or until the mod from which they originate is removed from the user's mod list. In general, string variables should be destroyed after use unless it is necessary to save their values permanently. In the following example, the string variable is used each time the scripted object is activated:</p>

<?php
$source = "string_var refName
ref activatingRef
begin onActivate
    set activatingRef to GetActionRef
    set refName to activatingRef.GetName
    if (sv_Count \"e\" refName > 0)
        Message \"Your name contains the letter e\"
    endif
    set refName to sv_Destruct
end";
include "includes/geshiencoder.php";
?>

<p>Because the value of the string variable is only needed temporarily, <code>sv_Destruct</code> is used to prevent it from being saved.</p>

<p>string variables can be passed to any command expecting a string literal as an argument by prefacing the name of the variable with a dollar sign. This deprecates many of the Set...EX commands. The variable must be local to the calling script and its name must immediately follow the '$' without parentheses. Example:</p>

<?php
$source = "string_var msg
let msg := \"Greetings from Stonekeep, \" + player.GetName + \"!!!\"
MessageBox \$msg";
include "includes/geshiencoder.php";
?>

<p>Support for string operations has been integrated into the language via OBSE expressions, which leaves functions such as <code>sv_Construct</code>, <code>sv_Substring</code>, etc. mostly deprecated.</p>