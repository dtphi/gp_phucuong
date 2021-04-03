
-- ----------------------------
-- Table structure for pc_category_to_layouts
-- ----------------------------
DROP TABLE IF EXISTS `pc_category_to_layouts`;
CREATE TABLE `pc_category_to_layouts` (
  `category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
