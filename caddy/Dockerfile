ARG     buildpath=/build
ARG     caddypath=/caddy
ARG	caddyver=v1.0.0

# BEGIN BUILD ENVIRONMENT #
#-------------------------#
FROM	golang:1.12 as build

ARG	buildpath
ARG	caddypath
ARG	caddyver

ENV	BUILDPATH=$buildpath \
	CADDYPATH=$caddypath \
	CADDYVER=$caddyver

#-#	Import build file that includes plugins
COPY	copy/caddycustom.go $BUILDPATH/caddycustom.go

WORKDIR	$BUILDPATH

RUN	\
	#-# Set the transitional environment variable for Go modules \
	export GO111MODULE=on \
	#-# Initialise the go mod file for the project??? Not entirely certain what this does. \
	&& go mod init caddy \
	#-# Specify that we want version ${CADDYVER} of the source \
	&& go mod edit -require github.com/mholt/caddy@${CADDYVER} \
	#-# Get the caddy source. \
	&& go get github.com/mholt/caddy \
	#-# Build caddy binary into current directory \
	&& go build \
	#-# Ensure plugins are present \
	&& ./caddy -plugins | grep "docker" \
	#-# Ensure ca-certificates are present, to be copied later \
	&& apt-get install ca-certificates

#-----------------------#
# END BUILD ENVIRONMENT #


# Use phusion/baseimage as base image. To make your builds reproducible, make
# sure you lock down to a specific version, not to `latest`!
# See https://github.com/phusion/baseimage-docker/blob/master/Changelog.md for
# a list of version numbers.
FROM	phusion/baseimage:0.11

ARG	buildpath
ARG	caddypath
ARG	caddyver

ENV	BUILDPATH=$buildpath \
	CADDYPATH=$caddypath

# Use baseimage-docker's init system.
CMD	["/sbin/my_init"]

#-#	Copy ca-certificates
COPY	--from=build /etc/ssl/certs/ca-certificates.crt /etc/ssl/certs/

#-#	Copy the caddy binary
COPY	--from=build $BUILDPATH/caddy /bin/

#-#	Create the $CADDYPATH directory
RUN	mkdir $CADDYPATH

WORKDIR	$CADDYPATH

VOLUME	$CADDYPATH

EXPOSE	80 443

ENTRYPOINT	["/bin/caddy"]

# Clean up APT when done.
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
