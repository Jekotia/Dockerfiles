package main

import (
	"github.com/mholt/caddy/caddy/caddymain"
	// plug in plugins here, for example:
	// _ "import/path/here"
	_ "github.com/lucaslorentz/caddy-docker-proxy/plugin"
//	_ "github.com/caddyserver/dnsproviders/cloudflare"
)

func main() {
	// optional: disable telemetry
	// caddymain.EnableTelemetry = false
	caddymain.Run()
}

