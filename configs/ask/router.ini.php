;<?php /*
[production]
;module router
resources.router.routes.ask-index-index.route = "ask/:t/:page"
resources.router.routes.ask-index-index.defaults.module = "ask"
resources.router.routes.ask-index-index.defaults.controller = "index"
resources.router.routes.ask-index-index.defaults.action = "index"
resources.router.routes.ask-index-index.defaults.t = "0"
resources.router.routes.ask-index-index.reqs.t    = "(\d*)"
resources.router.routes.ask-index-index.defaults.page = "1"
resources.router.routes.ask-index-index.reqs.page    = "(\d*)"

resources.router.routes.ask-index-view.route = "ask/view/:id/:page"
resources.router.routes.ask-index-view.defaults.module = "ask"
resources.router.routes.ask-index-view.defaults.controller = "index"
resources.router.routes.ask-index-view.defaults.action = "view"
resources.router.routes.ask-index-view.defaults.id = "1"
resources.router.routes.ask-index-view.reqs.id    = "(\d*)"
resources.router.routes.ask-index-view.defaults.page = "1"
resources.router.routes.ask-index-view.reqs.page    = "(\d*)"

resources.router.routes.ask-index-add.route = "ask/add"
resources.router.routes.ask-index-add.defaults.module = "ask"
resources.router.routes.ask-index-add.defaults.controller = "index"
resources.router.routes.ask-index-add.defaults.action = "add"

resources.router.routes.ask-index-edit.route = "ask/edit/:id"
resources.router.routes.ask-index-edit.defaults.module = "ask"
resources.router.routes.ask-index-edit.defaults.controller = "index"
resources.router.routes.ask-index-edit.defaults.action = "edit"
resources.router.routes.ask-index-edit.defaults.id = "1"
resources.router.routes.ask-index-edit.reqs.id    = "(\d*)"


resources.router.routes.ask-tag-index.route = "ask/tag/:t/:page"
resources.router.routes.ask-tag-index.defaults.module = "ask"
resources.router.routes.ask-tag-index.defaults.controller = "tag"
resources.router.routes.ask-tag-index.defaults.action = "index"
resources.router.routes.ask-tag-index.defaults.t = "0"
resources.router.routes.ask-tag-index.reqs.t    = "(\d*)"
resources.router.routes.ask-tag-index.defaults.page = "1"
resources.router.routes.ask-tag-index.reqs.page    = "(\d*)"
;*/