;<?php /*
[production]
;router 二级域名
;resources.router.routes.video-domain.type = "Zend_Controller_Router_Route_Hostname"
;resources.router.routes.video-domain.route = "video.dh-dev.com"
;resources.router.routes.video-domain.defaults.module = "video"

;module router
resources.router.routes.video.route = "/video"
resources.router.routes.video.defaults.module = "video"
resources.router.routes.video.defaults.controller = "index"
resources.router.routes.video.defaults.action = "index"

resources.router.routes.video-index-view.route = "video/view/:id/:page"
resources.router.routes.video-index-view.defaults.module = "video"
resources.router.routes.video-index-view.defaults.controller = "index"
resources.router.routes.video-index-view.defaults.action = "view"
resources.router.routes.video-index-view.defaults.id = 0
resources.router.routes.video-index-view.reqs.id     = "(\d*)"
resources.router.routes.video-index-view.defaults.page = 1
resources.router.routes.video-index-view.reqs.page     = "(\d*)"
;*/