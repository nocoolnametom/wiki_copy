#!/bin/sh
## ./dump_wiki.sh en.fairmormon.org

epochTime=`date +%s`;

mkdir -p dumps/$epochTime;
cd dumps/$epochTime;

urlhost=$1;

php ../../get_titles.php -h "$urlhost" | while read line
do
  curl -d "&action=submit&limit=1000&pages=$line" "http://$urlhost/index.php?title=Special:Export" --compressed -H 'Accept-Encoding: gzip,deflate' -o "$line.xml";
done;

php ../../get_titles.php -h "$urlhost" --namespace=10 | while read line
do
  curl -d "&action=submit&limit=1000&pages=$line" "http://$urlhost/index.php?title=Special:Export" --compressed -H 'Accept-Encoding: gzip,deflate' -o "$line.xml";
done;

cd -;
