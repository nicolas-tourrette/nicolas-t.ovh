<?php

$uptime = substr(shell_exec('uptime -p'), 3);
$uptime = str_replace(",", "", $uptime);
$uptime = str_replace("days", "jours", $uptime);
$uptime = str_replace("hours", "heures", $uptime);

echo $uptime.' (reboot le '.substr(shell_exec('uptime -s'), 0, -1).')';