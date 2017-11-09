#!/bin/bash
# Transfer file from remote
echo -e "Enter filename: "
read filename
rsync -chavzP --stats server@3dprint.clients.soton.ac.uk:/home/server/$filename $filename
