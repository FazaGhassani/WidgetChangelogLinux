<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
    $q = $_REQUEST["q"];
    $command = escapeshellcmd('python3.6 tc.py --mode getKeyList --entity_type DEVICE --entity_id '.$q.' --isTelemetry 1');
    $output = shell_exec($command);

    $arr = explode(",",substr($output, 1, -2));
    echo'<label for="Values">Values: (ctrl+click for multiple value)</label><br/>';
    echo '<select name="telemetry[ ]" multiple>';
    foreach($arr as $item){
        #replace $items with #item if the system linux
        $items = str_replace("'",'', $item);
        echo '<option value="'.$item.'">';
        echo $items;
        echo '</option>';
    }
?>


</body>
</html>
