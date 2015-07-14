#!/bin/sh

epochTime=`date +%s`;

mkdir -p dumps/$epochTime;
cd dumps/$epochTime;

php ../../get_titles.php | while read line
do
  filetime=`date +%s`;
  curl -d "&action=submit&limit=1000&pages=$line" "http://en.fairmormon.org/index.php?title=Special:Export" --compressed -H 'Accept-Encoding: gzip,deflate' -o "$line.xml";
done;

cd -;