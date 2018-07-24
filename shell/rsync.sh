#!/bin/bash

# Setting the environment variable
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
export PATH=$PATH

# project name
var_project=(
	'newrunfast'
	)
# update joinroom server IP
var_join_ip='111.111.111.111'

# update admin server IP
var_admin_ip='111.111.111.111'

# update api server IP
var_api_ip='111.111.111.111'

if [ $# -lt 2 ]
then
	echo 'Please enter the project name and update type !'
	exit 1
fi

# check project name
flag=0
for i in ${var_project[@]}
do
	if [ $i == $1 ]
	then
		flag=1
		break
	fi
done
if [ $flag -ne 1 ]
then
	echo "No '$1' project !"
	exit 1
fi

# Execute rysnc 
case $2 in
	'join') rsync -avzrtopg -e 'ssh -p 35001' --exclude "data" --exclude "templates_c" --exclude ".svn" --exclude "code" --exclude "adminagents" --exclude "adminnew" --exclude "adminbiz" --exclude "api" --delete /home/lilongshen/online/${1}/* lilongsheng@${var_join_ip}:/usr/local/wwwroot/site_111/${1}
	;;
	'admin') rsync -avzrtopg -e 'ssh -p 35001' --exclude "data" --exclude "templates_c" --exclude ".svn" --exclude "code" --exclude "api" --exclude "joinroom" --exclude "joinclub" --delete /home/lilongshen/online/${1}/* lilongsheng@${var_admin_ip}:/usr/local/wwwroot/site_111/${1}
	;;
	'api') rsync -avzrtopg -e 'ssh -p 35001' --exclude "data" --exclude "templates_c" --exclude ".svn" --exclude "code" --exclude "adminagents" --exclude "adminbiz" --exclude "joinroom" --exclude "joinclub" --delete /home/lilongshen/online/${1}/* lilongsheng@${var_api_ip}:/usr/local/wwwroot/site_111/${1}
	;;
	*) echo "No '$2' update type !"
	;;
esac
