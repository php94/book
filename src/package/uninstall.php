<?php
// 卸载脚本文件

use PHP94\Package;

$sql = <<<'str'
DROP TABLE IF EXISTS `prefix_php94_book_book`;
DROP TABLE IF EXISTS `prefix_php94_book_page`;
str;
Package::execSql($sql);
