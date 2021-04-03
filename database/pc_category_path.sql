
-- ----------------------------
-- Table structure for pc_category_paths
-- ----------------------------
DROP TABLE IF EXISTS `pc_category_paths`;
CREATE TABLE `pc_category_paths` (
  `category_id` int(11) NOT NULL,
  `path_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`path_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
