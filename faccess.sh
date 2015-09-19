#! /bin/bash

chgrp www-data -R mod
find mod -type d -print0 | xargs -0 chmod 755 
find mod -type f -print0 | xargs -0 chmod 644

