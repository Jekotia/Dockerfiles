FROM alpine:3.8

RUN	apk -U upgrade \
	&& apk add --no-cache \
		tzdata \
		su-exec \
	&& cp /usr/share/zoneinfo/America/Toronto /etc/localtime \
	&& echo "America/Toronto" >  /etc/timezone \
	&& date \
	&& apk del tzdata
