FROM	jekotia/alpine:3.8.0 as build
ENV	WEECHAT_VERSION=2.4
RUN	BUILD_DEPS=" \
#-# WEECHAT \
	aspell aspell-libs aspell-dev \
	build-base \
	#-# REQUIRED \
	gcc \
	cmake \
	ncurses-dev \
	libcurl \
	curl-dev \
	zlib-dev \
	libgcrypt-dev \
	#-# OPTIONAL \
#	gnutls \
	gettext \
#	libintl \
	gnutls-dev \
#	ca-certificates \
#	jq \
	#-# FOR TESTS \
	g++ \
	cpputest \
#-# WEECHAT PLUGINS \
	#-# PYTHON \
	python-dev \
	#-# PERL \
	perl-dev \
	#-# RUBY \
	ruby \
	ruby-dev \
	#-# LUA \
	lua5.3-libs \
	#-# TCL \
	tcl-dev \
	#-# GUILE \
	guile-dev \
	#-# PHP \
	php7-dev \
	php7-embed \
	libxml2-dev \
	argon2-dev \
	libsodium-dev" \
	&& apk add --no-cache \
	${BUILD_DEPS} \
	tar \
	curl \
	python \
	&& update-ca-certificates

RUN	WEECHAT_TARBALL="https://api.github.com/repos/weechat/weechat/tarball/v${WEECHAT_VERSION}" \
	&& curl -sSL $WEECHAT_TARBALL -o /tmp/weechat.tar.gz \
	&& mkdir -p /tmp/weechat/build \
	&& tar xzf /tmp/weechat.tar.gz --strip 1 -C /tmp/weechat \
	&& cd /tmp/weechat/build \
	&& cmake .. \
	-DCMAKE_BUILD_TYPE=Release \
	-DCMAKE_INSTALL_PREFIX=/usr \
	-DWEECHAT_HOME=~/.weechat \
	-DENABLE_ALIAS=ON \
#	-DENABLE_BUFLIST=OFF \
	-DENABLE_CHARSET=ON \
	-DENABLE_MAN=OFF \
	-DENABLE_DOC=OFF \
	-DENABLE_ENCHANT=OFF \
	-DENABLE_EXEC=OFF \
	-DENABLE_FIFO=OFF \
	-DENABLE_FSET=ON \
	-DENABLE_GNUTLS=ON \
	-DENABLE_GUILE=ON \
	-DENABLE_IRC=ON \
	-DENABLE_JAVASCRIPT=ON \
	-DENABLE_LARGEFILE=ON \
	-DENABLE_LOGGER=ON \
	-DENABLE_LUA=ON \
	-DENABLE_NCURSES=OFF \
	-DENABLE_NLS=ON \
	-DENABLE_PERL=ON \
	-DENABLE_PHP=OFF \
	-DENABLE_PYTHON=ON \
	-DENABLE_PYTHON3=OFF \
	-DENABLE_RELAY=ON \
	-DENABLE_RUBY=ON \
	-DENABLE_SCRIPT=ON \
	-DENABLE_SCRIPTS=ON \
	-DENABLE_SPELL=OFF \
	-DENABLE_TCL=ON \
	-DENABLE_TRIGGER=ON \
	-DENABLE_XFER=ON \
#	-DENABLE_TESTS=ON \
	&& make \
#	&& ctest -V \
	&& make install

RUN	weechat-headless --version | grep "${WEECHAT_VERSION}"


FROM	jekotia/alpine:3.8.0
COPY	--from=build /usr/bin/weechat-headless /usr/bin/weechat-headless
COPY	--from=build /usr/lib/weechat /usr/lib/weechat

ENV	TERM=screen-256color \
	LANG=C.UTF-8 \
	UID=2811 \
	GID=2811 \
	USER=weechat \
	GROUP=weechat \
	HOME=/home/weechat \
	DATA=/data

COPY	copy/entrypoint.sh /

RUN	apk add --no-cache \
		libgcrypt \
		python \
		perl \
		curl \
		gnutls \
		tmux \
		curl \
		shadow

RUN	chmod +x /entrypoint.sh \
	&& mkdir -p $DATA \
	&& addgroup \
		-g $GID \
		-S $GROUP \
	&& adduser \
		-u $UID \
		-D \
		-S \
		-s /sbin/nologin \
		-G $GROUP \
		$USER

VOLUME $DATA

WORKDIR $DATA

EXPOSE 8443

ENTRYPOINT ["/entrypoint.sh"]
