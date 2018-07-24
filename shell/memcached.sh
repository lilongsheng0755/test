#!/bin/bash

# 配置环境变量
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
export PATH=$PATH

# 安装路径
INSTALL_PATH=/usr/local

# 是否为root用户执行
if [ $(id -u) != "0" ]; then
	echo '需要使用root用户！'
	exit
fi

if [ ! -e /usr/local/memcached ]; then
	# 安装gcc
	install_info=`yum install -y gcc`
	if [ $? != "0" ]; then
		echo $install_info
		exit
	fi
	echo $install_info

	# 安装autoconf
	install_info=`yum install -y autoconf`
	if [ $? != "0" ]; then
		echo $install_info
		exit
	fi
	echo $install_info

	# 安装libtool
	install_info=`yum install -y libtool`
	if [ $? != "0" ]; then
		echo $install_info
		exit
	fi
	echo $install_info
fi

# 安装memcached依赖库libevent
if [ ! -e ${INSTALL_PATH}/libevent ]; then
	echo '安装memcached依赖库libevent 开始......'
	if [ ! -e libevent-2.0.22-stable.tar.gz ]; then
		wget http://downloads.sourceforge.net/levent/libevent-2.0.22-stable.tar.gz
	fi

	# 文件下载成功后再执行编译安装
	if [ -e libevent-2.0.22-stable.tar.gz ]; then
		tar zxvf libevent-2.0.22-stable.tar.gz
		cd libevent-2.0.22-stable && ./configure --prefix=/usr/local/libevent
		cd libevent-2.0.22-stable && make && make install
	fi
fi

# 安装memcached服务端
if [ -e ${INSTALL_PATH}/libevent ]; then
	echo '安装libmemcached依赖库 开始......'
	if [ ! -e memcached-1.4.33.tar.gz ]; then
		wget http://www.memcached.org/files/memcached-1.4.33.tar.gz
	fi

	# 文件下载成功后再执行编译安装
	if [ -e memcached-1.4.33.tar.gz -a ! -e /usr/local/memcached ]; then
		tar zxvf memcached-1.4.33.tar.gz
		cd memcached-1.4.33 && ./configure --prefix=/usr/local/memcached --with-libevent=/usr/local/libevent
		cd memcached-1.4.33 && make && make install

		# 设置memcached服务端为开机启动
		if [ -e /usr/local/memcached -a -e memcached ]; then
			cp memcached /etc/init.d/memcached
			chmod 755 /etc/init.d/memcached
			chkconfig --add memcached
			chkconfig memcached on
		fi
	fi
fi

# 安装libmemcached依赖库
if [ -e /usr/local/memcached ]; then
	echo '安装libmemcached依赖库 开始......'
	if [ ! -e libmemcached-1.0.18.tar.gz ]; then
		wget https://launchpad.net/libmemcached/1.0/1.0.18/+download/libmemcached-1.0.18.tar.gz
	fi

	# 文件下载成功后再执行编译安装
	if [ -e libmemcached-1.0.18.tar.gz -a ! -e /usr/local/libmemcached ]; then
		tar zxvf libmemcached-1.0.18.tar.gz
		cd libmemcached-1.0.18 && ./configure --prefix=/usr/local/libmemcached
		cd libmemcached-1.0.18 && make && make install
	fi
fi

# 安装php-fpm的memcached扩展
if [ -e /usr/local/libmemcached ]; then
	echo '安装php memcached扩展 开始......'
	if [ ! -e memcached-2.2.0.tgz ]; then
		wget http://pecl.php.net/get/memcached-2.2.0.tgz
	fi

	# 文件下载成功后再执行编译安装
	if [ -e memcached-2.2.0.tgz -a ! -e /usr/local/php/lib/php/extensions/no-debug-non-zts-20131226/memcached.so ]; then
		tar zxvf memcached-2.2.0.tgz
		cd memcached-2.2.0 && /usr/local/php/bin/phpize --with-php-config=/usr/local/php/bin/php-config
		cd memcached-2.2.0 && ./configure --with-php-config=/usr/local/php/bin/php-config --with-libmemcached-dir=/usr/local/libmemcached --disable-memcached-sasl
		cd memcached-2.2.0 && make && make install

		# 更新php.ini文件
		if [ -e /usr/local/php/lib/php/extensions/no-debug-non-zts-20131226/memcached.so ]; then
			echo extension='"memcached.so"' >> /usr/local/php/etc/php.ini

			# 删除安装文件
			rm -rf libevent-2.0.22-stable
			rm -rf memcached-1.4.33
			rm -rf libmemcached-1.0.18
			rm -rf memcached-2.2.0
			service nginx restart && service php-fpm restart
		fi
	fi
fi



