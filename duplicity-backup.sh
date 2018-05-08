#!/bin/bash

source /srv/pgr/config/.env
export PASSPHRASE

duplicity --full-if-older-than=1M --progress --file-prefix-archive backup- /srv/pgr/storage s3://s3-eu-west-1.amazonaws.com/uol-pgr-backup


#duplicity --full-if-older-than=6M --allow-source-mismatch \
#     --progress --rsync-options='-e "ssh -oStrictHostKeyChecking=no -p 22 -i /srv/pgr/config/id_rsa"' \
#     /srv/pgr/storage rsync://mhanheide@159.89.249.38/backup
