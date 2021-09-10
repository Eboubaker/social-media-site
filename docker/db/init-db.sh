#!/bin/bash
mysql -u root -ppassword -e "GRANT ALL PRIVILEGES ON *.* TO 'sail';FLUSH PRIVILEGES;"