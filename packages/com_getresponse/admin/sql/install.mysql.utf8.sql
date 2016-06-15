DROP TABLE IF EXISTS `#__getresponse`;

CREATE TABLE `#__getresponse` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `apikey` varchar(32) DEFAULT NULL,
 `webform_id` varchar(32) DEFAULT NULL,
 `campaign_id` varchar(32) DEFAULT NULL,
 `webform_generation` tinyint(1) NOT NULL DEFAULT '1',
 `webform_url` varchar(255) DEFAULT NULL,
 `active` tinyint(1) DEFAULT NULL,
 `active_on_registration` tinyint(1) DEFAULT NULL,
 `css_style` tinyint(1) DEFAULT NULL,
 PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
