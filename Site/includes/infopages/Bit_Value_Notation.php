<p>Bit value notation is used by several new functions to pass multiple values to or from a single function, to act on a single form. It is an integer representaion of a binary number. A binary number uses the values of 0 and 1 (base 2) and therefore a value is either on or off.</p>

<p>Representing a number in bit value is very easy. To get any number you simply add each bit together until you get the value you need. Use the below table to help you figure this out. The first row is the integer value, the second row is the bit position of that integer. That is, the numbering system starts at 0 and progresses up.</p>

<p>
	<table  class="table_plain table_plain_fixed mono"><tr><td>32768</td><td>16384</td><td>8192</td><td>4096</td><td>2048</td><td>1024</td><td>512</td><td>256</td><td>128</td><td>64</td><td>32</td><td>16</td><td>8</td><td>4</td><td>2</td><td>1</td></tr>
	<tr><td>15</td><td>14</td><td>13</td><td>12</td><td>11</td><td>10</td><td>9</td><td>8</td><td>7</td><td>6</td><td>5</td><td>4</td><td>3</td><td>2</td><td>1</td><td>0</td></tr></table>
</p>

<p><strong>Example:</strong> If we want to set the weapon flags of a weapon to say that it is automatic, and has a scope, we would first check out the <a href="#Weapon_Flags_1">Weapon Flags</a> values to see what we need to set. Here we want to set flag 2 and flag 4. To do this we simply add 2 and 4 together, which is 6. So the function would look like:</p>
<?php
$source = "SetWeaponFlags1 6 objectID:ref";
include "includes/geshiencoder.php";
?>

<p>However, we must keep in mind that this Sets ALL of the flags. So if you don't preserve the original flags, they will be lost. To account for this we can use some other NVSE functions that were specifically designed to work on bit value integers. These are the <a href="#LogicalAnd">LogicalAnd</a>, <a href="#LogicalNot">LogicalNot</a>, <a href="#LogicalOr">LogicalOr</a>, <a href="#LogicalXor">LogicalXor</a>, <a href="#SetBit">SetBit</a>, and <a href="#ClearBit">ClearBit</a>.</p>

<p><strong>Example:</strong> So now if we want to set the weapon flags of a weapon we would first get the current flags on the weapon by using GetWeaponFlags1, then we use SetBit to set enable the bit we want in the value. As per our previous example, we want to set flags 2 and 4. We look at the chart above and see that that means we want to SET bits 1 and 2, which together is 3. So, in order to check the initial bits, set the new ones, and then set it back, we do the following:</p>

<?php
$source = "set iFlag to GetWeaponFlags1 objectID:ref
set iFlag to SetBit iFlag 3
SetWeaponFlags1 iFlag objectID:ref";
include "includes/geshiencoder.php";
?>