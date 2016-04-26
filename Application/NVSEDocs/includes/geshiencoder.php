<?php
    $path = __DIR__.'/geshi/geshi';
    $geshi = new GeSHi($source, "GeckScript", $path);
    $geshi->enable_classes();
    $geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS, 2);
    echo $geshi->parse_code();
    // echo "<p>".__DIR__.'\geshi\geshi'."</p>";
    // echo "<p>".getGeshiPath()."</p>";
?>