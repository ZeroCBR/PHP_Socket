#!/bin/sh

git filter-branch --env-filter '

am="$GIT_AUTHOR_EMAIL"
cm="$GIT_COMMITTER_EMAIL"

if [ "$GIT_COMMITTER_EMAIL" = "cbr@ubuntu.(none)" ]
then
    cm="xraycbr@gmail.com"
fi
if [ "$GIT_AUTHOR_EMAIL" = "cbr@ubuntu.(none)" ]
then
    am="xraycbr@gmail.com"
fi

export GIT_AUTHOR_EMAIL="$am"
export GIT_COMMITTER_EMAIL="$cm"
'