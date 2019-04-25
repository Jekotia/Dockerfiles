#!/bin/sh

usermod -o -u "$GID" $USER
groupmod -o -g "$UID" $GROUP

chown -R $USER:$GROUP $DATA
chown -R $USER:$GROUP $HOME

exec su-exec $USER /usr/bin/weechat-headless -d $DATA
