#!/bin/bash
echo 'Content-Type: text/plain; charset=UTF-8
'
svn diff -r PREV .
