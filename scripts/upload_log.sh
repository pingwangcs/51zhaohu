#!/bin/bash
# HOW TO USE:
#   bash upload_log.sh 
#   Please make sure the log file is in the baseDir
# Before use the script, you need to:
# 1. Get credentials for s3
# 2. install and configure AWS Command Line Interface according to http://docs.aws.amazon.com/cli/latest/userguide/cli-chap-getting-set-up.html

baseDir=~/log
logFile=51zhaohu.com
cd $baseDir
year=$(date +"%Y")
month=$(date +"%m")
now=$(date +"%Y_%m_%d")
aws s3 cp "$logFile" s3://51log/$year/$month/$logFile'_'$now


