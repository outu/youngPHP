CREATE DATABASE IF NOT EXISTS `tool_db`;
SET NAMES utf8;
USE tool_db;

DROP TABLE IF EXISTS `tool_task`;
CREATE TABLE `tool_task` (
                             `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID值，主键自增',
                             `info` TEXT NULL COMMENT 'JSON方式存储的任务信息（界面选择需要传复制的文件以及复制目标目录）',
                             `state` CHAR(50) NOT NULL DEFAULT '' COMMENT '任务task当前的运行状态，如：TASK_WAITING(任务等待扫描)|TASK_SCANNING(任务处于扫描中)|TASK_SCANNED(任务扫描结束)|TASK_FINISHED(任务传输完成，结束)',
                             `process` INT(11) NOT NULL DEFAULT 0  COMMENT '进度',
                             `created_at` DATETIME NULL COMMENT '创建时间',
                             `updated_at` DATETIME NULL COMMENT '修改时间',
                             PRIMARY KEY (`id`)
)
    COLLATE='utf8_unicode_ci'
    ENGINE=InnoDB
    COMMENT '界面添加的需要复制的文件任务表'
;

DROP TABLE IF EXISTS `tool_good`;
CREATE TABLE `tool_good` (
                             `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID值，主键自增',
                             `name` CHAR(50) NOT NULL DEFAULT '' COMMENT '商品名',
                             `total` INT(11) NOT NULL DEFAULT 0 COMMENT '商品数量',
                             `size` INT(11) NOT NULL DEFAULT 0  COMMENT '商品价格'
                             PRIMARY KEY (`id`)
)
    COLLATE='utf8_unicode_ci'
    ENGINE=InnoDB
    COMMENT '商品列表'
;

DROP TABLE IF EXISTS `tool_order`;
CREATE TABLE `tool_order` (
                             `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID值，主键自增',
                             `good_id` CHAR(50) NOT NULL DEFAULT '' COMMENT '商品id',
                             `pay` INT(1) NOT NULL DEFAULT 0 COMMENT '是否付款',
                             `created_at` DATETIME NULL COMMENT '下单时间',
                                 PRIMARY KEY (`id`)
)
    COLLATE='utf8_unicode_ci'
    ENGINE=InnoDB
    COMMENT '订单'
;