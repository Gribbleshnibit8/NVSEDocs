<p>NVSE 4.2 introduces the array_var datatype for storing a collection of values within a single variable. An array_var is a set of data elements each identified by a unique key. A key can be a number or a string, and the value associated with the key can be a string, number, game object, or another array. An element's value can be accessed using bracket notation, e.g. <code>array[key]</code>. In this documentation, "key" refers to the element's key, and "value" refers to the data associated with that key.</p>

<p>All elements within an array must have the same type of key - all strings or all numeric. However, an array can contain any mix of types for its values. Elements are sorted by key, in ascending order either alphabetically or numerically depending on the key type.</p>

<p>NVSE's array_var type actually represents three different kinds of associative containers:</p>

<dl>	<dt>1. Array:</dt>	<dd>An Array behaves like arrays in most programming languages: the key is an unsigned integer starting at zero, and there are no gaps between elements. (In other words, if an element exists at indexes 1 and 3 then an element necessarily exists at 0 and 2). Attempting to access an element using a key which is greater than the highest key in the array results in an error. The only exception to this rule is during assignment: it is okay to assign a value to the key which is one greater than the highest key in the array.</dd>	<dt>2. Map:</dt>	<dd>A Map associates numeric keys with values. Unlike an Array, a Map allows negative and floating point numbers to be used as keys and allows gaps to exist between elements.</dd>	<dt>3. StringMap:</dt>	<dd>Like a Map, except the keys are strings. Keys are case-insensitive, so <code>array[INDEX]</code> and <code>array[index]</code> both refer to the same value. There is no practical limit on the length of the strings used as keys. StringMaps can be used to simulate C-style structs by associating named properties with data values.</dd></dl>

<p>An array_var must be initialized before it can be used in expressions, either by explicitly initializing it using <code>ar_Construct</code>, assigning the value of another array_var to it, or assigning it the return value of a command returning an array such as <code>GetItems</code>. <strong>Most array operations should be performed within NVSE expressions</strong> such as <code>Let</code> or <code>Eval</code> statements. Array elements cannot be passed directly to most commands as arguments. Assigning one array to another as in <code>Let array_1 := array_2</code> causes both array_1 and array_2 to refer to the <strong>same</strong> array, as illustrated below:</p>

<?php
$source = "array_var a
array_var b
let a := ar_Construct Array
let a[0] := \"First elem\"
let b := a                  ; b now refers to the same array as a
let b[1] := \"Second elem\"   ; array now contains two elements";
include "includes/geshiencoder.php";
?>

<p>NVSE keeps track of the number of references to each array and destroys the array when no references to it remain. This makes it unnecessary for scripts to worry about destroying arrays explicitly. For example, continuing from the code above:</p>

<?php
$source = "; our array currently has 2 references: the variables a and b
let a := ar_Construct StringMap ; now a refers to a new array, and only b refers to ours
let b := ar_Null                ; b now refers to no array. No references to our array remain
; NVSE will delete the unreferenced array";
include "includes/geshiencoder.php";
?>

<h3>Array Operations</h3>

<p>NVSE supports a variety of operations on arrays within the context of <code>Let</code>, <code>Eval</code>, and similar statements.</p>

<h4>Examples:</h4>

<?php
$source = "array_var arr_1
array_var arr_2
let arr_1 := ar_Construct Array
let arr_1[0] :=\"a string\"
let arr_1[1] := 1.234
let arr_1[2] := Player.GetEquippedObject 16
; let arr_1[10] := 0 <- this is an error, index out of bounds
let arr_1[3] := Player.GetEquippedItems	; <- arr_1[3] is another array
let arr_1[4] := arr_1[3][0]		; <- access first item returned by GetEquippedItems
let arr_2 := arr_1[1:3]			; <- arr_2 contains elements 1, 2, and 3 from arr_1
let arr_2 := arr_1[1:-2]  ; <- arr_2 contains elements 1 through (size of arr_1 minus 2) of arr_1";
include "includes/geshiencoder.php";
?>

<h3>Array Functions</h3>

<p>Note: Unless otherwise indicated, an <code>array_var</code> parameter may be either a variable declared as array_var or an array element containing an array. Commands accepting this type of parameter must be called within the context of an NVSE expression such as <code>Let</code> or <code>Eval</code>.</p>