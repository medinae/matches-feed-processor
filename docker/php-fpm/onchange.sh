#!/bin/bash

# Written by: Senko Rasic <senko.rasic@dobarkod.hr>
#

EVENTS="CREATE,CLOSE_WRITE,DELETE,MODIFY,MOVED_FROM,MOVED_TO"

if [ -z "$1" ]; then
    echo "Usage: $0 cmd ..."
    exit -1;
fi

inotifywait -e "$EVENTS" -m -r --format '%:e %f' . | (
    WAITING="";
    while true; do
        LINE="";
        read -t 1 LINE;
        if test -z "$LINE"; then
            if test ! -z "$WAITING"; then
                    echo "CHANGE";
                    WAITING="";
            fi;
        else
            WAITING=1;
        fi;
    done) | (
    while true; do
        read TMP;
        echo $@
        $@
    done
)
