<p>NVSE 4.2 introduces support for evaluation of complex expressions involving a larger set of operators than that provided by Oblivions <code>set</code> and <code>if</code> statements, type-checking and type inference, and operations on strings and arrays. These expressions are supported within the context of new commands such as <code>let</code> (for assignment, analogous to <code>set</code>) and <code>eval</code> (to be used within <code>if</code> statements to test the value of a boolean expression).</p>

<table class="table_plain">
<caption style="font-size: 110%; background-color: #ffffff;">Operators</caption>
	<tbody>
		<tr>
			<th>Symbol</th>
			<th>Precedence</th>
			<th>Function</th>
			<th>Number of Operands</th>
			<th>Description</th>
		</tr>
		<tr>
			<td><code>:=</code></td>
			<td>0</td>
			<td>Assignment</td>
			<td>2</td>
			<td class="table_plain_left">Assigns the value of an expression on the right to the variable or array element on the left. <strong>Right-associative</strong>. The value of the assignment is the right-most operand. Supports multiple assignment i.e. <code>a := b := c := 0</code> sets all 3 variables to zero. Assignment of strings creates a <strong>copy</strong> of the string, whereas assignment of arrays creates a <strong>reference</strong> to the array.</td>
		</tr>
		<tr>
			<td><code>||</code></td>
			<td>1</td>
			<td>Logical Or</td>
			<td>2</td>
			<td class="table_plain_left">True if either expression is true.</td>
		</tr>
		<tr>      
			<td><code>&amp;&amp;</code></td>      
			<td>2</td>      
			<td>Logical And</td>      
			<td>2</td>      
			<td class="table_plain_left">True if both expressions are true.</td>    
		</tr>    
		<tr>      
			<td><code>+=</code></td>      
			<td>2</td>      
			<td>Add and Assign</td>      
			<td>2</td>      
			<td class="table_plain_left">Adds the expression on the right to the variable or array element on the left.</td>    
		</tr>	
		<tr>      
			<td><code>-=</code></td>      
			<td>2</td>      
			<td>Subtract and Assign</td>      
			<td>2</td>      
			<td class="table_plain_left">Subtracts the expression on the right from the variable or array element on the left.</td>    
		</tr>    
		<tr>      
			<td><code>*=</code></td>      
			<td>2</td>      
			<td>Multiply and Assign</td>      
			<td>2</td>      
			<td class="table_plain_left">Multiplies the variable or array element on the left by the expression on the right.</td>    
		</tr>    
		<tr>      
			<td><code>/=</code></td>      
			<td>2</td>      
			<td>Divide and Assign</td>      
			<td>2</td>      
			<td class="table_plain_left">Divides the variable or array element on the left by the expression on the right.</td>    
		</tr>    
		<tr>      
			<td><code>^=</code></td>      
			<td>2</td>      
			<td>Exponent and Assign</td>      
			<td>2</td>      
			<td class="table_plain_left">Raises the variable or array element on the left to the power of the expression on the right.</td>    
		</tr>    
		<tr>      
			<td><code>:</code></td>      
			<td>3</td>      
			<td>Slice/Range</td>      
			<td>2</td>      
			<td class="table_plain_left">Specifies a range of elements in a string or array. For strings, creates a substring. For arrays, creates a copy of the elements within the range. Range includes the upper element. For strings, negative indices start at the last element and count backwards.</td>    
		</tr>    
		<tr>      
		<td><code>::</code></td>      
			<td>3</td>      
			<td>Make Pair</td>      
			<td>2</td>      
			<td class="table_plain_left">Specifies a key-value pair. The lefthand operand defines the key as a numeric or string value, and the righthand operand defines the value (of any type).</td>    
		</tr>    
		<tr>      
			<td><code>==</code></td>      
			<td>4</td>      
			<td>Equality</td>      
			<td>2</td>      
			<td class="table_plain_left">True if the operands are equal. Operands must be comparable to each other.</td>    
		</tr>    
		<tr>      
			<td><code>!=</code></td>      
			<td>4</td>      
			<td>Inequality</td>      
			<td>2</td>      
			<td class="table_plain_left">True if the operands are not equal.</td>    
		</tr>    
		<tr>      
			<td><code>&gt;</code></td>      
			<td>5</td>      
			<td>Greater Than</td>      
			<td>2</td>      
			<td class="table_plain_left">Operands must be comparable and ordered. For strings, comparison is case-insensitive.</td>    
		</tr>    
		<tr>      
			<td><code>&lt;</code></td>      
			<td>5</td>      
			<td>Less Than</td>      
			<td>2</td>      
			<td class="table_plain_left">For strings, case-insensitive.</td>    
		</tr>    
		<tr>      
			<td><code>&gt;=</code></td>      
			<td>5</td>      
			<td>Greater or Equal</td>      
			<td>2</td>      
			<td class="table_plain_left">For strings, case-insensitive.</td>    
		</tr>    
		<tr>      
			<td><code>&lt;=</code></td>      
			<td>5</td>      
			<td>Less than or Equal</td>      
			<td>2</td>      
			<td class="table_plain_left">For strings, case-insensitive.</td>    
		</tr>    
		<tr>      
			<td><code>|</code></td>      
			<td>6</td>      
			<td>Bitwise Or</td>      
			<td>2</td>      
			<td class="table_plain_left">Performs a bitwise or, demoting the operands to integers.</td>    
		</tr>    
		<tr>      
			<td><code>&amp;</code></td>      
			<td>7</td>      
			<td>Bitwise And</td>      
			<td>2</td>      
			<td class="table_plain_left">Performs a bitwise and, demoting the operands to integers.</td>    
		</tr>    
		<tr>      
			<td><code>&lt;&lt;</code></td>      
			<td>8</td>      
			<td>Binary Left Shift</td>      
			<td>2</td>      
			<td class="table_plain_left">Shifts left operand left by specified number of bits, demoting both operands to integers.</td>    
		</tr>    
		<tr>      
			<td><code>&gt;&gt;</code></td>      
			<td>8</td>      
			<td>Binary Right Shift</td>      
			<td>2</td>      
			<td class="table_plain_left">Shifts left operand right by specified number of bits, demoting both operands to integers.</td>    
		</tr>    
		<tr>      
			<td><code>+</code></td>      
			<td>9</td>      
			<td>Addition/Concatentation</td>      
			<td>2</td>      
			<td class="table_plain_left">Adds two numbers or joins two strings.</td>    
		</tr>    
		<tr>      
			<td><code>-</code></td>      
			<td>9</td>      
			<td>Subtraction</td>      
			<td>2</td>      
			<td class="table_plain_left">Self-explanatory.</td>    
		</tr>    
		<tr>      
			<td><code>*</code></td>      
			<td>10</td>      
			<td>Multiplication</td>      
			<td>2</td>      
			<td class="table_plain_left">Self-explanatory.</td>    
		</tr>    
		<tr>      
			<td><code>/</code></td>      
			<td>10</td>      
			<td>Division</td>      
			<td>2</td>      
			<td class="table_plain_left">Self-explanatory.</td>    
		</tr>    
		<tr>      
			<td><code>%</code></td>      
			<td>10</td>      
			<td>Modulo</td>      
			<td>2</td>      
			<td class="table_plain_left">Returns the remainder of integer division.</td>    
		</tr>    
		<tr>      
			<td><code>^</code></td>      
			<td>11</td>      
			<td>Exponentiation</td>      
			<td>2</td>      
			<td class="table_plain_left">Raises left operand to the power of the right operand.</td>    
		</tr>    
		<tr>      
			<td><code>-</code></td>      
			<td>12</td>      
			<td>Negation</td>      
			<td>1</td>      
			<td class="table_plain_left">Returns the opposite of an expression.</td>    
		</tr>    
		<tr>      
			<td><code>$</code></td>      
			<td>12</td>      
			<td>Stringize</td>      
			<td>1</td>      
			<td class="table_plain_left">Returns a string representation of an expression. (Shorthand for <a href="#ToString">ToString</a>).</td>    
		</tr>    
		<tr> 
			<td><code>#</code></td>      
			<td>12</td>      
			<td>Numericize</td>      
			<td>1</td>      
			<td class="table_plain_left">Returns the numeric value of a string. (Shorthand for <a href="#ToNumber">ToNumber</a>).</td>    
		</tr>    
		<tr>      
			<td><code>*</code></td>      
			<td>12</td>      
			<td>Dereference/Unbox</td>      
			<td>1</td>      
			<td class="table_plain_left">Dereferences an array. If the array is a StringMap with a "value" key, returns the value associated with that key. Otherwise returns the value of the first element.</td>    
		</tr>    
		<tr>      
			<td><code>&amp;</code></td>      
			<td>12</td>      
			<td>Box</td>      
			<td>1</td>      
			<td class="table_plain_left">"Boxes" a value of any type, returning an Array containing that value as its only element. The value can be retrieved with the unary * (unbox) operator.</td>    
		</tr>    
		<tr>      
			<td><code>!</code></td>      
			<td>13</td>      
			<td>Logical Not</td>      
			<td>1</td>      
			<td class="table_plain_left">Returns the opposite of a boolean expression. i.e. <code>!(true)</code> evaluates to false.</td>    
		</tr>    
		<tr>      
			<td><code>( )</code></td>      
			<td>14</td>      
			<td>Parentheses</td>      
			<td>0</td>      
		<td class="table_plain_left">Enclose expressions within parentheses to override default precedence rules.</td>    
		</tr>    
		<tr>      
			<td><code>[ ]</code></td>      
			<td>15</td>      
			<td>Subscript</td>      
			<td>2</td>      
		<td class="table_plain_left">For arrays, accesses the element having the specified key. For strings, returns a string containing the single character at the specified position. The expression within the brackets is treated as if it were parenthesized (overrides precedence rules).</td>    
		</tr>	
		<tr>      
			<td><code>-&gt;</code></td>      
			<td>15</td>      
			<td>Member Access</td>      
			<td>2</td>      
		<td class="table_plain_left">The lefthand operand is a StringMap having a key specified by the righthand operand. Returns the value associated with that key. Example: 'dict-&gt;key' is equivalent to 'dict["key"]'</td>    
		</tr>
	</tbody>
</table>