CREATE TABLE IF NOT EXISTS `ask_arc` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `title` varchar(500) NOT NULL DEFAULT '0',  `uid` int(11) NOT NULL DEFAULT '0',  `follow_count` int(11) NOT NULL DEFAULT '0',  `answer_count` int(11) NOT NULL DEFAULT '0',  `is_publish` tinyint(1) NOT NULL DEFAULT '0',  `tag1` int(11) NOT NULL,  `tag2` int(11) NOT NULL,  `tag3` int(11) NOT NULL,  `created_at` datetime NOT NULL,  `last_action_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `tag_path` varchar(100) NOT NULL DEFAULT '0',  `tag_name_path` varchar(200) NOT NULL DEFAULT '0',  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('1','贝克汉姆退役了，刚发现他脖子比头粗… 足球运动员是怎么锻炼颈部的？','1','0','0','1','1','2','3','2013-07-06 08:18:31','2013-07-06 08:21:53',',1,2,3,','体育,运动,贝克汉姆','2013-07-06 08:18:31');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('2','为什么穿高跟鞋是危险驾驶？','1','0','0','1','4','5','0','2013-07-06 09:23:41','2013-07-06 09:23:41',',4,5,','交通,高跟鞋','2013-07-06 09:23:41');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('3','对蚊子有害，一定对人有害？或者有可能对人有害？','1','0','0','1','6','7','0','2013-07-06 09:27:57','2013-07-06 09:27:57',',6,7,','蚊子,杀虫剂','2013-07-06 09:27:57');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('4','程序猿该如何保护颈椎？','1','0','0','1','8','9','10','2013-07-06 09:36:42','2013-07-06 09:36:42',',8,9,10,','程序员,程序,颈椎','2013-07-06 09:36:42');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('5','本站“问答”这块提问，回答，金币是怎么奖励的? 删除提问呢？删除回答呢？','1','1','1','1','11','0','0','2013-07-06 10:48:23','2013-07-06 17:30:08',',11,','帮助中心','2013-07-06 10:48:23');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('6','问答详细指南','1','0','0','1','11','0','0','2013-07-06 15:18:00','2013-07-06 15:18:00',',11,','帮助中心','2013-07-06 15:18:00');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('7','雪花真实的形状？','2','1','1','1','12','13','14','2013-07-06 15:21:06','2013-07-06 15:22:35',',12,13,14,','雪花,科学,天气','2013-07-06 15:21:06');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('8','接吻会传染口臭吗？','3','0','0','1','15','16','0','2013-07-06 15:36:35','2013-07-06 15:36:35',',15,16,','接吻,口臭','2013-07-06 15:36:35');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('9','袋装人奶热卖：人奶的保质期真的有一年么？','3','0','0','1','17','18','19','2013-07-06 15:39:23','2013-07-06 15:39:23',',17,18,19,','生活,人奶,保质期','2013-07-06 15:39:23');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('10','半透明的身子，这个视觉错觉是如何造成的？','3','0','0','1','20','21','22','2013-07-06 15:45:01','2013-07-06 15:45:01',',20,21,22,','科技,错觉,视错觉','2013-07-06 15:45:01');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('11','古代的哪些科学技术，在今天还在影响着我们的生活？','3','0','0','1','13','20','23','2013-07-06 15:49:52','2013-07-06 15:49:52',',13,20,23,','科学,科技,古代','2013-07-06 15:49:52');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('12','孙武继续效力吴国，能否帮助吴国统一天下','3','0','0','1','24','25','26','2013-07-06 18:06:59','2013-07-06 18:06:59',',24,25,26,','孙武,吴国,历史','2013-07-06 18:06:59');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('13','蒙恬不死，能否带领秦军远征匈奴，摧毁匈奴主力？','3','0','0','1','27','28','29','2013-07-06 18:07:30','2013-07-06 18:07:30',',27,28,29,','蒙恬,秦,匈奴','2013-07-06 18:07:30');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('14','八国联军火烧圆明园是什么时候？','3','0','0','1','30','31','26','2013-07-06 18:08:18','2013-07-06 18:08:18',',30,31,26,','八国联军,圆明园,历史','2013-07-06 18:08:18');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('15','求穿越类历史军事小说','3','0','0','1','32','26','33','2013-07-06 18:09:08','2013-07-06 18:09:20',',32,26,33,','穿越,历史,军事','2013-07-06 18:09:08');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('16','为什么解放军的被子一定要叠成豆腐块儿？','3','0','0','1','34','33','35','2013-07-06 18:10:29','2013-07-06 18:10:29',',34,33,35,','解放军,军事,兵','2013-07-06 18:10:29');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('17','赵薇已经入了香港籍了？','3','0','0','1','36','37','38','2013-07-06 18:11:18','2013-07-06 18:11:18',',36,37,38,','赵薇,娱乐,香港','2013-07-06 18:11:18');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('18','俄罗斯的运载火箭为什么会爆炸？','3','0','0','1','39','40','33','2013-07-06 18:13:45','2013-07-06 18:13:45',',39,40,33,','俄罗斯,火箭,军事','2013-07-06 18:13:45');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('19','房价下半年还会涨吗','3','11','11','1','41','17','0','2013-07-06 18:14:28','2013-09-22 13:22:17',',41,17,','房价,生活','2013-07-06 18:14:28');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('20','dnf绝杀技在哪学?怎么学?','3','0','0','1','42','43','0','2013-07-06 18:26:46','2013-07-06 18:26:46',',42,43,','DNF,游戏','2013-07-06 18:26:46');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('21','星战里面可以占领几颗星球？','3','0','0','1','44','43','0','2013-07-06 18:27:21','2013-07-06 18:27:21',',44,43,','星战,游戏','2013-07-06 18:27:21');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('22','lol天启者怎么出装?','3','0','0','1','45','46','43','2013-07-06 18:28:42','2013-07-06 18:28:42',',45,46,43,','LOL,英雄联盟,游戏','2013-07-06 18:28:42');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('23','标签是什么?','2','0','0','1','47','11','0','2013-07-08 21:52:47','2013-07-08 21:54:08',',47,11,','标签,帮助中心','2013-07-08 21:52:47');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('24','测试测试测试','1','0','0','1','48','0','0','2013-09-22 13:35:05','2013-09-22 13:35:05',',48,','测试','2013-09-22 13:35:05');
INSERT INTO ask_arc(`id`,`title`,`uid`,`follow_count`,`answer_count`,`is_publish`,`tag1`,`tag2`,`tag3`,`created_at`,`last_action_at`,`tag_path`,`tag_name_path`,`updated_at`) VALUES ('25','sdasd','1','0','0','1','48','0','0','2013-09-22 17:00:33','2013-09-22 17:00:33',',48,','测试','2013-09-22 17:00:33');
CREATE TABLE IF NOT EXISTS `ask_follow_log` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL DEFAULT '0',  `arc_id` int(11) NOT NULL DEFAULT '0',  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('1','1','5','2013-07-06 11:05:34');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('2','2','5','2013-07-06 11:08:31');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('3','1','7','2013-07-06 15:22:35');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('4','1','19','2013-09-22 13:20:07');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('5','1','19','2013-09-22 13:20:13');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('6','1','19','2013-09-22 13:20:19');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('7','1','19','2013-09-22 13:20:36');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('8','1','19','2013-09-22 13:20:50');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('9','1','19','2013-09-22 13:21:09');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('10','1','19','2013-09-22 13:21:22');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('11','1','19','2013-09-22 13:21:42');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('12','1','19','2013-09-22 13:21:57');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('13','1','19','2013-09-22 13:22:11');
INSERT INTO ask_follow_log(`id`,`uid`,`arc_id`,`created_at`) VALUES ('14','1','19','2013-09-22 13:22:18');
CREATE TABLE IF NOT EXISTS `ask_reply_log` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL DEFAULT '0',  `reply_id` int(11) NOT NULL DEFAULT '0',  `reply_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0踩，1顶',  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ask_tag` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(100) NOT NULL,  `ask_count` int(11) NOT NULL DEFAULT '0',  `follow_count` int(11) NOT NULL DEFAULT '0',  `tree_id` int(11) NOT NULL DEFAULT '0',  `uid` int(11) NOT NULL DEFAULT '0',  `descr` varchar(400) NOT NULL,  `tag_sort` int(11) NOT NULL DEFAULT '0',  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  PRIMARY KEY (`id`),  UNIQUE KEY `name` (`name`)) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('1','体育','2','1','1','1','以身体活动为手段的教育，直译为身体的教育，简称为体育','0','2013-07-06 08:18:31');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('2','运动','2','1','7','1','一种涉及体力和技巧的由一套规则或习惯所约束的活动，通常具有竞争性。','0','2013-07-06 08:18:31');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('3','贝克汉姆','2','0','7','1','大卫·罗伯特·约瑟夫·贝克汉姆（David Robert Joseph Beckham，1975年5月2日—），前任英格兰国家队队长，曾效力于曼联、皇马、AC米兰、洛杉矶银河、巴黎圣日耳曼足球俱乐部等豪门俱乐部。','0','2013-07-06 08:18:31');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('4','交通','1','0','8','1','交通是指从事旅客和货物运输及语言和图文传递的行业，包括运输和邮电两个方面，在国民经济中属于第三产业。','0','2013-07-06 09:23:40');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('5','高跟鞋','1','1','8','1','高跟鞋是指鞋跟特别高的鞋，会使穿此鞋的人的脚跟明显比脚趾来得高。','0','2013-07-06 09:23:40');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('6','蚊子','1','1','1','1','属于昆虫纲双翅目蚊科，全球约有3000种。是一种具有刺吸式口器的纤小飞虫。','0','2013-07-06 09:27:57');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('7','杀虫剂','1','1','8','1','顾名思义','0','2013-07-06 09:27:57');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('8','程序员','1','0','1','1','从事程序开发、维护的专业人员','0','2013-07-06 09:36:42');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('9','程序','1','0','9','1','是为实现特定目标或解决特定问题而用计算机语言编写的命令序列的集合','0','2013-07-06 09:36:42');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('10','颈椎','1','0','1','1','指颈椎骨，英文名为：cervical vertebra。颈椎位于头以下、胸椎以上的部位','0','2013-07-06 09:36:42');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('11','帮助中心','6','2','6','1','有什么疑问，可以在添加问题的时候，打上标签"帮助中心"，以便通知我们，我们将尽快回答你的问题','0','2013-07-06 10:21:28');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('12','雪花','1','0','1','2','空中飘落的雪，多呈六角形，像花，所以叫雪花','0','2013-07-06 15:21:06');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('13','科学','2','0','9','2','反映自然、社会、思维等的客观规律的分科知识体系','0','2013-07-06 15:21:06');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('14','天气','1','0','1','2','某一个地方距离地表较近的大气层在短时间内的具体状态','0','2013-07-06 15:21:06');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('15','接吻','1','0','8','3','俗称亲嘴，打嘣儿，是指两人的嘴唇互相接触，表达亲爱、欢迎、尊敬等含义','0','2013-07-06 15:36:34');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('16','口臭','1','0','8','3','从口腔或其他充满空气的空腔中如鼻、鼻窦、咽，所散发出的臭气，它严重影响人们的社会交往和心理健康，WHO已将口臭作为一种疾病来进行报道。','0','2013-07-06 15:36:35');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('17','生活','2','0','8','3','指为生存发展而进行各种活动，也是人类这种生命的所有的日常活动和经历的总和。','0','2013-07-06 15:39:23');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('18','人奶','1','0','8','3','顾名思义','0','2013-07-06 15:39:23');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('19','保质期','1','0','8','3','指产品在正常条件下的质量保证期限。','0','2013-07-06 15:39:23');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('20','科技','2','1','9','3','利用“有关研究客观事物存在及其相关规律的学说”能为自己所用，为大家所用的知识。','0','2013-07-06 15:45:01');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('21','错觉','1','0','9','3','人们观察物体时，由于物体受到形、光、色的干扰，加上人们的生理、心理原因而误认物象，会产生与实际不符的判断性的视觉误差。','0','2013-07-06 15:45:01');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('22','视错觉','1','0','9','3','当人观察物体时，基于经验主义或不当的参照形成的错误的判断和感知','0','2013-07-06 15:45:01');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('23','古代','1','0','3','3','①过去距离现代较远的时代（区别于“近代和现代”）。在我国历史分期上多指19世纪中叶以前。1840是中国古代和近代的分界线。②特指奴隶社会时代（有的也包括原始公社时代）。','0','2013-07-06 15:49:52');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('24','孙武','1','0','3','3','孙武（约公元前535－？），字长卿，汉族，中国春秋时期齐国乐安（今山东惠民，一说博兴，或说广饶）人，是吴国将领','0','2013-07-06 18:06:59');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('25','吴国','1','0','3','3','吴国（前12世纪―前473年），存在于长江下游地区的姬姓诸侯国，也叫勾吴、工吴、攻吾、大吴、天吴、皇吴。','0','2013-07-06 18:06:59');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('26','历史','4','1','3','3','指过去事实','0','2013-07-06 18:06:59');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('27','蒙恬','1','0','3','3','蒙恬（？—前210年），姬姓，蒙氏，名恬。祖籍齐国(现山东省蒙阴县），秦始皇时期的著名将领，被誉为“中华第一勇士”。','0','2013-07-06 18:07:29');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('28','秦','1','0','3','3','战国七雄之一，在今甘肃天水、陕西宝鸡一带。公元前221年秦王政统一中国，建立秦朝','0','2013-07-06 18:07:30');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('29','匈奴','1','0','3','3','匈奴是个历史悠久的北方民族，祖居在欧亚大陆的游牧民族，他们披发左衽，由古北亚人种和原始印欧人种的混合。','0','2013-07-06 18:07:30');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('30','八国联军','1','0','3','3','指1900年（庚子年）以军事行动侵入中国的大英帝国、法兰西第三共和国、德意志帝国、俄罗斯帝国、美利坚合众国、日本帝国、意大利王国、奥匈帝国的八国联合军队。','0','2013-07-06 18:08:17');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('31','圆明园','1','0','1','3','坐落在北京西郊，与颐和园毗邻。','0','2013-07-06 18:08:18');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('32','穿越','2','0','6','3','穿越是穿越时间和空间的简称。','0','2013-07-06 18:09:08');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('33','军事','4','1','3','3','是军队事务的简称，中国古代称呼为军务，是与一个国家（或者政权、集体）生死存亡有关的重要事务以及法则。','0','2013-07-06 18:09:08');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('34','解放军','1','0','3','3','中国人民解放军（People's Liberation Army，PLA），是由中国共产党缔造和领导的人民军队，是中华人民共和国的主要军事力量','0','2013-07-06 18:10:29');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('35','兵','1','0','3','3','常见汉字。其含义是武器、战士、与军事或战争有关事物的统称。','0','2013-07-06 18:10:29');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('36','赵薇','1','0','8','3','赵薇（Vicki Zhao），中国知名度最高及最具影响力的影视女演员、流行音乐女歌手。','0','2013-07-06 18:11:18');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('37','娱乐','1','0','1','3','可被看作是一种通过表现喜怒哀乐或自己和他人(haobc)的技巧而与受者喜悦，并带有一定启发性的活动。','0','2013-07-06 18:11:18');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('38','香港','1','0','1','3','全称中华人民共和国香港特别行政区，是繁荣的国际大都市，是仅次于纽约和伦敦的全球第三大金融中心。','0','2013-07-06 18:11:18');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('39','俄罗斯','1','0','1','3','俄罗斯联邦（俄语：Российская Федерация 英语：Russian Federation），地跨欧亚两大洲','0','2013-07-06 18:13:44');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('40','火箭','1','0','9','3','指一种自身既带有燃料,又带有助燃用的氧化剂,用火箭发动机作动力装置,可在大气层内飞行,也可在没有空气的大气层外的太空飞行的飞行器。','0','2013-07-06 18:13:45');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('41','房价','1','0','8','3','在中国是个伤心的名词','0','2013-07-06 18:14:28');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('42','DNF','1','0','7','3','指地下城与勇士','0','2013-07-06 18:26:45');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('43','游戏','3','1','7','3','这个都懂的','0','2013-07-06 18:26:45');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('44','星战','1','0','7','3','一款战争策略微端网游','0','2013-07-06 18:27:21');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('45','LOL','1','0','7','3','《英雄联盟》是Riot Games开发的3D竞技场战网游戏','0','2013-07-06 18:28:42');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('46','英雄联盟','1','0','1','3','Riot Games开发的3D竞技场战网游戏','0','2013-07-06 18:28:42');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('47','标签','2','0','0','2','','0','2013-07-08 21:52:46');
INSERT INTO ask_tag(`id`,`name`,`ask_count`,`follow_count`,`tree_id`,`uid`,`descr`,`tag_sort`,`created_at`) VALUES ('48','测试','2','0','0','1','','0','2013-09-22 13:35:05');
CREATE TABLE IF NOT EXISTS `ask_tag_follow` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL DEFAULT '0',  `tag` varchar(100) NOT NULL DEFAULT '0',  `tag_id` int(11) NOT NULL DEFAULT '0',  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('1','1','帮助中心','11','2013-07-06 10:28:05');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('2','2','帮助中心','11','2013-07-06 11:08:28');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('3','3','孙武','24','2013-07-06 18:06:59');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('4','3','吴国','25','2013-07-06 18:06:59');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('5','3','历史','26','2013-07-06 18:06:59');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('6','3','蒙恬','27','2013-07-06 18:07:30');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('7','3','秦','28','2013-07-06 18:07:30');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('8','3','匈奴','29','2013-07-06 18:07:30');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('9','3','八国联军','30','2013-07-06 18:08:18');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('10','3','圆明园','31','2013-07-06 18:08:18');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('11','3','穿越','32','2013-07-06 18:09:08');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('12','3','军事','33','2013-07-06 18:09:08');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('13','3','解放军','34','2013-07-06 18:10:29');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('14','3','兵','35','2013-07-06 18:10:29');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('15','3','赵薇','36','2013-07-06 18:11:18');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('16','3','娱乐','37','2013-07-06 18:11:18');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('17','3','香港','38','2013-07-06 18:11:18');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('18','3','俄罗斯','39','2013-07-06 18:13:45');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('19','3','火箭','40','2013-07-06 18:13:45');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('20','3','房价','41','2013-07-06 18:14:28');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('21','3','DNF','42','2013-07-06 18:26:45');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('22','3','游戏','43','2013-07-06 18:26:45');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('23','3','星战','44','2013-07-06 18:27:21');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('24','3','LOL','45','2013-07-06 18:28:42');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('25','3','英雄联盟','46','2013-07-06 18:28:42');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('26','2','标签','47','2013-07-08 21:52:46');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('27','2','历史','26','2013-07-13 11:11:14');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('28','2','游戏','43','2013-07-13 11:11:16');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('29','2','军事','33','2013-07-13 11:11:18');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('30','2','体育','1','2013-07-13 11:11:19');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('31','2','运动','2','2013-07-13 11:11:21');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('32','2','科技','20','2013-07-13 11:11:24');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('33','2','高跟鞋','5','2013-07-13 11:11:26');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('34','2','杀虫剂','7','2013-07-13 11:11:27');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('35','2','蚊子','6','2013-07-13 11:11:28');
INSERT INTO ask_tag_follow(`id`,`uid`,`tag`,`tag_id`,`created_at`) VALUES ('36','1','测试','48','2013-09-22 13:35:05');
CREATE TABLE IF NOT EXISTS `ask_tree` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(100) NOT NULL DEFAULT '0',  `tag_count` int(11) NOT NULL DEFAULT '0',  `tree_sort` int(11) NOT NULL DEFAULT '0',  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
INSERT INTO ask_tree(`id`,`name`,`tag_count`,`tree_sort`,`created_at`) VALUES ('1','自然·人文·地理','5','1','2013-07-01 21:54:45');
INSERT INTO ask_tree(`id`,`name`,`tag_count`,`tree_sort`,`created_at`) VALUES ('3','历史·军事·政治','10','0','2013-07-01 21:55:07');
INSERT INTO ask_tree(`id`,`name`,`tag_count`,`tree_sort`,`created_at`) VALUES ('6','其他','1','999','2013-07-01 21:56:21');
INSERT INTO ask_tree(`id`,`name`,`tag_count`,`tree_sort`,`created_at`) VALUES ('7','体育·游戏','5','0','2013-07-06 09:21:16');
INSERT INTO ask_tree(`id`,`name`,`tag_count`,`tree_sort`,`created_at`) VALUES ('8','娱乐·生活','1','0','2013-07-06 09:24:02');
INSERT INTO ask_tree(`id`,`name`,`tag_count`,`tree_sort`,`created_at`) VALUES ('9','科技·技术','1','0','2013-07-06 09:33:09');
