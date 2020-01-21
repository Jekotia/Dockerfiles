package main

import (
	"github.com/caddyserver/caddy/caddy/caddymain"
	// plug in plugins here, for example:
	// _ "import/path/here"
	_ "github.com/lucaslorentz/caddy-docker-proxy/plugin" //@0.3.2
	_ "github.com/caddyserver/dnsproviders/cloudflare"
)

func main() {
	// optional: disable telemetry
	caddymain.EnableTelemetry = false
	caddymain.Run()
}
