FROM	golang as build

## Get the necessary go sources to get started
RUN	go get github.com/mholt/caddy/caddy \
	&& go get github.com/caddyserver/builds \
	&& go get github.com/lucaslorentz/caddy-docker-proxy/plugin \
	&& go get github.com/caddyserver/dnsproviders/cloudflare

WORKDIR	$GOPATH/src/github.com/mholt/caddy/caddy
## Bring in the plugins list
COPY	copy/plugins plugins
## Insert the plugins list into caddy's source
RUN	sed -i -e "/\/\/\sThis\sis\swhere\sother\splugins\sget\splugged\sin\s.imported./ r plugins" caddymain/run.go
## Ensure the insertion worked
RUN	grep -f ./plugins caddymain/run.go

## Compile
RUN	go run build.go
## Ensure plugins are available
RUN	./caddy -plugins | grep "tls.dns.cloudflare"
RUN	./caddy -plugins | grep "docker"
## Ensure ca-certificates are present, to be copied later
RUN	apt-get install ca-certificates
## Make the /caddy dir to be copied in next stage
RUN	mkdir /caddy

FROM	scratch
ENV	CADDYPATH=/caddy

COPY	--from=build /etc/ssl/certs/ca-certificates.crt /etc/ssl/certs/
COPY	--from=build /go/src/github.com/mholt/caddy/caddy/caddy /bin/
COPY	--from=build /caddy /

WORKDIR	/caddy

VOLUME	/caddy

EXPOSE	80 443

ENTRYPOINT	["/bin/caddy"]
