#!/bin/bash
# HOW TO USE:
#   bash clean.sh # remove from production server
#   bash clean.sh git # remove from git

# clean our mods at 51zhaohu.com

mods=(blog bookmarks categories Contactform custom_index dashboard embed externalpages file group_tools invitefriends members messageboard messages notifications notused pages search suggested_friends_extended tagcloud thewire twitter_api widget_manager wmcustom_index zaudio)

if [ "$1" == "git" ]; then
  for folder in "${mods[@]}"
  do
    echo "<=== git remove $folder ===>"
    # do something on $var
    git rm mod/"$folder" -r
  done
else
  for folder in "${mods[@]}"
  do
    echo "<=== remove $folder now ===>"
    # do something on $var
    ssh -t -p 7822 zhaohuco@51zhaohu.com rm -rf /home/zhaohuco/public_html/mod/"$folder"
  done
fi


