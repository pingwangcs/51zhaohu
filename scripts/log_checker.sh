# This is a script that will grep a log file and send an email when a specified patter is encountered.

errors=$(grep -i "fatal error" /etc/httpd/logs/error_log)
echo "$errors" > ~/tmp/current-errors.log

if [ -e "/home/zhadmin/tmp/prior-errors.log" ]; then
  echo "prior-errors.log Exists" > /dev/null
else
  echo "prior-erros.log does not exist"
  touch ~/tmp/prior-errors.log | echo "" > ~/tmp/prior-errors.log
fi

newentries=$(diff --suppress-common-lines -u ~/tmp/prior-errors.log ~/tmp/current-errors.log | grep '^\+')
if
   test "$newentries" == "" || test "$errors" == ""
   then echo "No New Errors"
elif
  test "$newentries" != ""
  then echo "$newentries" | mailx -s "WARNING: Error Messages Detected" e.shuaige@gmail.com
  echo "$errors" > ~/tmp/prior-errors.log
fi