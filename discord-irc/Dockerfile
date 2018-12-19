FROM	jekotia/alpine-node:11.0.0
ENV	DISCORDIRC_VERSION=2.6.2
RUN	apk add --no-cache \
		git \
		python \
		make \
		g++

RUN	npm install -g npm \
	&& npm install -g node-gyp \
	&& chown -R node:node /home/node

WORKDIR $HOME

#RUN	chown -R node:node /home/node

RUN	npm install zlib-sync \
	&& npm install uws \
	&& npm install discordapp/erlpack \
	&& npm install discord.js \
	&& npm install -g discord-irc@${DISCORDIRC_VERSION}

VOLUME $DATA

CMD /usr/local/bin/discord-irc --config /data/discord-irc.json
