<p>NVSE supports several types of commands for altering the flow of execution within a script. The simplest are <code>Label</code> and <code>Goto</code>, which allow unconditional jumps from one location in a script to a previous location. <code>While</code> loops cause execution to remain within the loop until the specified expression becomes false. <code>ForEach</code> loops iterate over the elements of an array or string.</p>

<p><code>ForEach</code> and <code>While</code> loops both define structured blocks in the same way that <code>if</code> and <code>endif</code> or <code>begin</code> and <code>end</code> do. Every <code>While</code> or <code>ForEach</code> in a script must be matched by exactly one <code>Loop</code> command.</p>

<p>Examples of good and bad loops:</p>

<?php
$source = "while (expr)
    do stuff
loop		; good";
include "includes/geshiencoder.php";
?>

<?php
$source = "while (expr)
    if (something)
      loop  ; BAD, Loop must be on same level of indentation as While
    endif";
include "includes/geshiencoder.php";
?>

<p><code>Break</code> and <code>Continue</code> statements are only valid within a loop body. <code>Goto</code> should never be used within a loop body to jump to a label defined outside of the loop's body.</p>