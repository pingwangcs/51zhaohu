# deploy the given folder under mod

# execute this from the root foler of elgg. Example:
# 	bash simple_deploy.sh stage|prod zhaohu_manager

if [ "$1" == "stage" ]; then
	server="91zhaohu.com"
	user="zhaohuco"
elif [ "$1" == "prod" ]; then
	server="51zhaohu.com"
	user="zhadmin"
fi

if [ "$2" != "" ] && [ -d "./mod/$2" ]; then
	echo "<=== deploy $2 now ===>"
	zip -r "$2".zip ./mod/"$2"/ > /dev/null
	scp -r -P 7822 "$2".zip "$user"@"$server":/home/"$user"/public_html/"$2".zip
	ssh -t -p 7822 "$user"@"$server" rm -rf /home/"$user"/public_html/mod/"$2"
	ssh -t -p 7822 "$user"@"$server" unzip -o /home/"$user"/public_html/"$2".zip -d /home/"$user"/public_html/ > /dev/null
	rm "$2".zip
	ssh -t -p 7822 "$user"@"$server" rm /home/"$user"/public_html/"$2".zip
	if [ "$2" == "slogin" ]; then
	  ssh -t -p 7822 "$user"@"$server" cp /home/"$user"/public_html/bbs/Settings.php /home/"$user"/public_html/mod/slogin/vendors/smf/
	  ssh -t -p 7822 "$user"@"$server" rm /home/"$user"/public_html/mod/slogin/vendors/smf/smfapi_settings.txt 
	fi
else
	echo "deploy a single mod folder to prod. Example: bash simple_deploy.sh zhaohu_manager"
fi
