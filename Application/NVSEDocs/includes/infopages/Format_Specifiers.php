<p>Some NVSE commands take a <span id="mono">format string</span> as a parameter. Format strings are actually a collection of arguments consisting of a string followed by zero to twenty variables and/or numbers. The string specifies how the command should use the rest of the arguments to construct a new string. Within the format string, percent signs are used to indicate special  characters.</p>

<p>The format specifiers recognized by NVSE commands include all of	those recognized by vanilla Fallout script commands like MessageBox as well as several extended specifiers:</p>

<p>
	<ul class="list" style="padding-left: 5em; text-indent: -3em;">
		<li>%.3e - Shows numbers in scientific notation. The number before the 'e' represents the number of of significant figures (123000 = 1.23E+005)</li>
		<li>%.2f - Shows numbers in floating point representation, with the number after the decimal being the number of places to show. A number before the decimal, as %5.0f specifies the minimum width of the number. In this case, there will always be enough space in front of the number for 5 digits.</li>
		<li>%a - replaced by the character matching the ASCII code passed as an integer.</li>
		<li>%c - replaced by the sub-names from an ammo form (0 = full name, 1 = short name, 2 = abbreviation)</li>
		<li>%e - replaced by nothing. Useful for passing an empty string as an argument, as the script compiler will not accept an empty string.</li>
		<li>%g - Works just like "%.0f", displaying 0 decimal places. When the number is 1,000,000 or larger, though, the game diplays it in scientific notation (1E+006)</li>
		<li>%i - replaced by the formID of a reference or object	passed in a ref variable</li>
		<li>%k - replaced by a string representing the key associated with a DirectInput scan code</li>
		<li>%n - replaced with the name of a reference or object passed in a ref variable</li>
		<li>%p - replaced with a pronoun based on the gender of the object parameter passed in a ref variable:</li>
			<ul class="list">
				<li>%po - objective (he, she, it)</li>
				<li>%pp - possessive (his, her, its)</li>
				<li>%ps - subjective (him, her, it)</li>
			</ul>
		<li>%q - replaced with a double quote character (takes no arguments)</li>
		<li>%r - replaced by a new-line character (takes no	arguments)</li>
		<li>%v - replaced by the name of an actor value passed as an integer <a href="#Actor_Value_Codes">actor value code</a></li>
		<li>%x - replaced with an integer in hexadecimal format. An optional digit from 0-9	immediately following this specifier indicates the minimum width of the displayed value. For example, <strong>MessageEx "%x4" 255</strong> will display <strong>"00FF".</strong></li>
		<li>%z - Prints the contents of a string variable.
		<li>%{ .. %} - Conditionally omits a portion of the format string based on a boolean value. The left bracket accepts a variable; if the value of the variable is zero, all text up to the right	bracket will be ignored, and any parameters supplied to format specifiers within the omitted substring will be skipped.</li>
	</ul>
</p>

<p>Additional format specifiers used by the C function printf() may work as well. Due to the fact that integer script variables are stored as floats, specifiers expecting integers may not display the expected output.</p>