#!/bin/bash

# 配置环境变量
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
export PATH=$PATH

# 安装redis服务端
if [ ! -e /usr/local/redis ]; then

	# 如果redis服务端安装包没有则下载
	if[ ! -e redis-2.8.3.tar.gz ]; then
		wget http://download.redis.io/releases/redis-2.8.3.tar.gz
	fi

	# 解压redis源码包，初始化设置
	if[ -e redis-2.8.3.tar.gz ]; then
		tar xzf redis-2.8.3.tar.gz
		mv redis-2.8.3 /usr/local/redis
		ln -s /usr/local/redis/src/redis-server /usr/local/bin/redis-server
		ln -s /usr/local/redis/src/redis-cli /usr/local/bin/redis-cli
	fi
fi
