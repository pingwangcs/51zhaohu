#!/bin/bash
# HOW TO USE:
#   bash deploy.sh stage|prod [full]

# deploy to staging server: 91zhaohu.com or prod server: 51zhaohu.com
# you will need to manually flush the cache from http://[server]/admin

if [ "$1" == "stage" ]; then
	server="91zhaohu.com"
	user="zhaohuco"
elif [ "$1" == "prod" ]; then
	server="51zhaohu.com"
	user="zhadmin"
fi

# do a full deployment
if [ "$2" == "full" ]; then
	scp -r -P 7822 engine/start.php "$user"@"$server":/home/"$user"/public_html/engine/start.php
 
	# deploy folders under elgg root
	for folder in languages actions views pages mod
	do
		echo "<=== deploy $folder now ===>"
		zip -r "$folder".zip "$folder"/ > /dev/null
		scp -r -P 7822 "$folder".zip "$user"@"$server":/home/"$user"/public_html/"$folder".zip
		ssh -t -p 7822 "$user"@"$server" rm -rf /home/"$user"/public_html/"$folder"
		ssh -t -p 7822 "$user"@"$server" unzip -o /home/"$user"/public_html/"$folder".zip -d /home/"$user"/public_html/ > /dev/null
		rm "$folder".zip
	done

	# deploy folders under elgg engine
	for folder in lib classes
	do
		echo "<=== deploy $folder now ===>"
		zip -r "$folder".zip ./engine/"$folder"/ > /dev/null
		scp -r -P 7822 "$folder".zip "$user"@"$server":/home/"$user"/public_html/"$folder".zip
		ssh -t -p 7822 "$user"@"$server" rm -rf /home/"$user"/public_html/engine/"$folder"
		ssh -t -p 7822 "$user"@"$server" unzip -o /home/"$user"/public_html/"$folder".zip -d /home/"$user"/public_html/ > /dev/null
		rm "$folder".zip
	done
else
	# only deploy folders under mod
	for folder in zhaohu_manager zhaohu_theme zhgroups myicon zhnotifications slogin html_email_handler likes tidypics groups
	do
		echo "<=== deploy $folder now ===>"
		zip -r "$folder".zip ./mod/"$folder"/ > /dev/null
		scp -r -P 7822 "$folder".zip "$user"@"$server":/home/"$user"/public_html/"$folder".zip
		ssh -t -p 7822 "$user"@"$server" rm -rf /home/"$user"/public_html/mod/"$folder"
		ssh -t -p 7822 "$user"@"$server" unzip -o /home/"$user"/public_html/"$folder".zip -d /home/"$user"/public_html/ > /dev/null
		rm "$folder".zip
		if [ "$folder" == "slogin" ]; then
	  	ssh -t -p 7822 "$user"@"$server" cp /home/"$user"/public_html/bbs/Settings.php /home/"$user"/public_html/mod/slogin/vendors/smf/
	  	ssh -t -p 7822 "$user"@"$server" rm /home/"$user"/public_html/mod/slogin/vendors/smf/smfapi_settings.txt 
		fi
	done
fi

# clean up zip files under mod
ssh -t -p 7822 "$user"@"$server" rm /home/"$user"/public_html/*.zip

# copy over error_log monitor script
scp -P 7822 scripts/log_checker.sh "$user"@"$server":/home/"$user"/scripts/log_checker.sh
