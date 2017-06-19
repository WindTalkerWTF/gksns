;<?php /*
[production]
;module router
resources.router.routes.group-index-index.route = "group/list/*"
resources.router.routes.group-index-index.defaults.module = "group"
resources.router.routes.group-index-index.defaults.controller = "index"
resources.router.routes.group-index-index.defaults.action = "index"

resources.router.routes.group-index-all-view.route = "group/all-view/:page"
resources.router.routes.group-index-all-view.defaults.module                    = "group"
resources.router.routes.group-index-all-view.defaults.controller                = "index"
resources.router.routes.group-index-all-view.defaults.action                    = "all-view"
resources.router.routes.group-index-all-view.defaults.page = "1"
resources.router.routes.group-index-all-view.reqs.page                            = "(\d*)"

resources.router.routes.group-index-view.route = "group/view/:id/:page"
resources.router.routes.group-index-view.defaults.module                    = "group"
resources.router.routes.group-index-view.defaults.controller                = "index"
resources.router.routes.group-index-view.defaults.action                    = "view"
resources.router.routes.group-index-view.defaults.id = "0"
resources.router.routes.group-index-view.reqs.id                            = "(\d+)"
resources.router.routes.group-index-view.defaults.page = "1"
resources.router.routes.group-index-view.reqs.page                            = "(\d+)"

resources.router.routes.group-index-g.route = "group/:id/*"
resources.router.routes.group-index-g.defaults.module                    = "group"
resources.router.routes.group-index-g.defaults.controller                = "index"
resources.router.routes.group-index-g.defaults.action                    = "g"
resources.router.routes.group-index-g.defaults.id = "0"
resources.router.routes.group-index-g.reqs.id                            = "(\d*)"

resources.router.routes.group-index-my.route = "group/my/:t"
resources.router.routes.group-index-my.defaults.module = "group"
resources.router.routes.group-index-my.defaults.controller = "index"
resources.router.routes.group-index-my.defaults.action = "my"
resources.router.routes.group-index-my.defaults.t = 1
resources.router.routes.group-index-my.reqs.id     = ".*"
;*/