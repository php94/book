<?php
// 更新脚本文件

use PHP94\Package;

$updates = [
    '1.0.3' => function () {
        Package::execSql('ALTER TABLE prefix_php94_book_book ADD COLUMN `editor` varchar(255) DEFAULT \'summernote\';');
    }
];
foreach ($updates as $version => $fn) {
    if (version_compare($oldversion, $version, '<')) {
        $fn();
    }
}
