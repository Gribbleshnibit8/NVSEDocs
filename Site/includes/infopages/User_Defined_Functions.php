<p>NVSE allows scripters to define their own functions, which can be called from other scripts. When a function is called, script execution passes to the function and resumes after the function call when a return statement is encountered or execution reaches the end of the function script. Factoring commonly-used code out into a function prevents repetitious code and shortens scripts. Encapsulating complicated routines into stand-alone functions results in simplified, more readable code.</p>
					
<p>Functions are defined as Object scripts but are treated as a distinct type with special limitations. A function script can contain only one block. The name of the script is the name of the function. Function scripts should never be attached to any object. All variables in a function script must be declared before the function body.</p>

<p>A simple function script might look like:</p>

<?php
$source = "ScriptName Multiply	; the name of this function
float arg1			; holds an argument passed to the function
float arg2			; second arg
float localVar		; a local variable
Begin Function {arg1, arg2}		; function body, with parameter list in {braces}
	Let localVar := arg1 * arg2
	SetFunctionValue localVar	; this is the value that will be returned
	Return						; optional, causes the function to return immediately
End";
include "includes/geshiencoder.php";
?>
					
<p>Parameters are stored in local variables and must be indicated within {braces} in the function definition; a set of empty braces indicates the function takes no arguments. Local variables and argument variables retain their values only until the function returns.</p>
					
<p>To call this function you would use:</p>
<?php
$source = "Call Multiply 10 5";
include "includes/geshiencoder.php";
?>

<p>To store the result (50, in this case):</p>
<?php
$source = "Let someVar := Call Multiply 10 5";
include "includes/geshiencoder.php";
?>

<p>When parsing a function call, the compiler will verify that the number and type of the arguments match those expected by the function's parameter list. If the called function is specified as a ref variable this validation cannot be performed; it is the scripter's responsibility to ensure the argument list is valid to avoid errors at run-time.</p>

<p>Functions have some useful properties. Because they are object scripts, you can call them on references using someRef.Call someFunc; any commands used inside the function will then operate implicitly on the calling reference. Because they are scripts, they can be stored in and called using ref variables, and even passed as arguments to other functions. Functions can call other functions, including themselves (i.e. recursively); for instance:</p>

<?php
$source = "ScriptName Pow ; calculates base to the exp power
float base
short exp
short val
begin Function {base, exp}
	if exp == 0
		let val := 1
	else
		let val := base * Call Pow base, exp - 1
	endif
	SetFunctionValue val
end";
include "includes/geshiencoder.php";
?>

<p>NSVE allows a maximum of 30 nested function calls. This means the above function will only work with exponents less than 30.</p>

<p>A note about local variables within functions: when the function terminates, all local variables are reset to zero. Local array variables are automatically cleaned up so there is no need to use ar_Null to reset them. String variables used to hold function arguments are also automatically destroyed. Local string variables, however, are not automatically cleaned up because they may refer to strings in use by other scripts. It is the scripter's responsibility to use sv_Destruct to destroy any local variables when appropriate. The following example code illustrates this idea:</p>

<?php
$source = "scn SomeFunction
string_var arg
string_var local0
string_var local1
string_var local2
Begin Function { arg }
	let local0 := \"some string\"
	set local1 to someQuest.someStringVar
	let local2 := someQuest.someStringVar
	sv_Destruct local0 local2
End";
include "includes/geshiencoder.php";
?>

<p>In the above script, the string variable arg will be automatically cleaned up by OBSE when the function terminates. local1 will not be, and should not be destroyed explicitly because doing so would invalidate the someStringVar variable in an external script. local0, however, must be explicitly destroyed as it is not referenced by any other script. local2 must also be destroyed as let, unlike set, creates a copy of the string with a new string ID.</p>