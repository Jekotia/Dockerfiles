FROM	node:11-alpine
ENV     TERM=screen-256color \
        LANG=C.UTF-8 \
        DATA=/data \
        HOME=/home/node

RUN	apk -U upgrade \
	&& apk add tzdata --no-cache \
	&& npm i -g npm \
	&& cp /usr/share/zoneinfo/America/Toronto /etc/localtime \
	&& echo "America/Toronto" >  /etc/timezone \
	&& date \
	&& apk del tzdata
