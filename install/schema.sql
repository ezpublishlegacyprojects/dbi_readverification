CREATE TABLE `ezcontentobjectversion_readverification` (
  `contentobject_id` int(10) unsigned NOT NULL,
  `contentobject_version` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`contentobject_id`,`contentobject_version`,`user_id`)
);

CREATE TABLE `ezcontentobject_readverification` (
  `contentobject_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `verified` tinyint(1) NOT NULL,
  PRIMARY KEY  (`contentobject_id`,`user_id`)
);