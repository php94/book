<?php
// 安装脚本文件
use PHP94\Package;

$sql = <<<'str'
DROP TABLE IF EXISTS `prefix_php94_book_book`;
CREATE TABLE `prefix_php94_book_book` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `title` varchar(255) DEFAULT NULL,
    `keywords` varchar(255) DEFAULT NULL,
    `description` varchar(255) DEFAULT NULL,
    `name` varchar(255) DEFAULT '',
    `body` text,
    `password` varchar(255) DEFAULT NULL,
    `cover` varchar(255) DEFAULT NULL,
    `water` varchar(255) DEFAULT NULL,
    `editor` varchar(255) DEFAULT 'summernote',
    `copy` tinyint(3) unsigned DEFAULT '0',
    `ip` text,
    `theme` varchar(255) DEFAULT 'default',
    `published` tinyint(3) unsigned DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
DROP TABLE IF EXISTS `prefix_php94_book_page`;
CREATE TABLE `prefix_php94_book_page` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `book_id` int(10) unsigned DEFAULT '0',
    `pid` int(10) unsigned DEFAULT '0',
    `title` varchar(255) DEFAULT NULL,
    `keywords` varchar(255) DEFAULT NULL,
    `description` varchar(255) DEFAULT NULL,
    `rank` tinyint(3) unsigned DEFAULT '0',
    `body` text,
    `published` tinyint(3) unsigned DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
str;

Package::execSql($sql);
