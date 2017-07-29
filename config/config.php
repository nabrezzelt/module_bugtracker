<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\Bugtracker\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'key' => 'bugtracker',
        'version' => '1.0',
        'icon_small' => 'fa-bug',
        'author' => 'Nabrezzelt',
        'link' => '',
        'languages' => [
            'de_DE' => [
                'name' => 'Bugtracker',
                'description' => 'Bugtracker for Legion',
            ],
            'en_EN' => [
                'name' => 'Bugtracker',
                'description' => 'Bugtrackerfor Legion',
            ],
        ],
        'ilchCore' => '2.0.0',
        'phpVersion' => '5.6'
    ];

    public function install()
    {
        //$query = "
        //        CREATE TABLE IF NOT EXISTS `[prefix]_bugtracker_status` (
        //            `id` INT(11) NOT NULL AUTO_INCREMENT,
        //            `name` VARCHAR(50) NOT NULL,
        //            `css_class` VARCHAR(50) NOT NULL DEFAULT '',
        //            PRIMARY KEY (`id`)
        //        ) ENGINE=InnoDB;

        //        CREATE TABLE IF NOT EXISTS `[prefix]_bugtracker_categories` (
        //            `id` INT(11) NOT NULL AUTO_INCREMENT,
        //            `name` VARCHAR(50) NOT NULL,
        //            PRIMARY KEY (`id`)
        //        ) ENGINE=InnoDB;

        //        CREATE TABLE IF NOT EXISTS `[prefix]_bugtracker_sub_categories` (
        //            `id` INT(11) NOT NULL AUTO_INCREMENT,
        //            `category_id` INT(11) NOT NULL,
        //            `name` VARCHAR(50) NOT NULL,
        //            PRIMARY KEY (`id`),
        //            INDEX `FK_bugtracker_sub_category_bugtracker_category` (`category_id`),
        //            CONSTRAINT `FK_bugtracker_sub_category_bugtracker_category` FOREIGN KEY (`category_id`) REFERENCES `[prefix]_bugtracker_categories` (`id`)
        //        ) ENGINE=InnoDB;

        //        CREATE TABLE IF NOT EXISTS `[prefix]_bugs` (
        //            `id` INT(11) NOT NULL AUTO_INCREMENT,
        //            `sub_category_id` INT(11) NOT NULL,
        //            `title` VARCHAR(250) NOT NULL,
        //            `description` LONGTEXT NOT NULL,
        //            `priority` INT(11) NULL DEFAULT NULL,
        //            `creator_id` INT(11) UNSIGNED NOT NULL,
        //            `assigned_user_id` INT(11) UNSIGNED NULL DEFAULT NULL,
        //            `progress` INT(11) NOT NULL DEFAULT '0',
        //            `status_id` INT(11) NOT NULL,
        //            `create_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //            PRIMARY KEY (`id`),
        //            INDEX `FK_bugs_bugtracker_sub_categories` (`sub_category_id`),
        //            INDEX `FK_bugs_users` (`creator_id`),
        //            INDEX `FK_bugs_users_2` (`assigned_user_id`),
        //            INDEX `FK_bugs_bugtracker_status` (`status_id`),
        //            CONSTRAINT `FK_bugs_bugtracker_status` FOREIGN KEY (`status_id`) REFERENCES `[prefix]_bugtracker_status` (`id`),
        //            CONSTRAINT `FK_bugs_bugtracker_sub_categories` FOREIGN KEY (`sub_category_id`) REFERENCES `[prefix]_bugtracker_sub_categories` (`id`),
        //            CONSTRAINT `FK_bugs_users` FOREIGN KEY (`creator_id`) REFERENCES `[prefix]_users` (`id`),
        //            CONSTRAINT `FK_bugs_users_2` FOREIGN KEY (`assigned_user_id`) REFERENCES `[prefix]_users` (`id`)
        //        ) ENGINE=InnoDB;

        //        CREATE TABLE IF NOT EXISTS `[prefix]_bugtracker_comments` (
        //            `id` INT(11) NOT NULL AUTO_INCREMENT,
        //            `bug_id` INT(11) NOT NULL,
        //            `content` LONGTEXT NOT NULL,
        //            `poster_id` INT(11) UNSIGNED NOT NULL,
        //            `create_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //            PRIMARY KEY (`id`),
        //            INDEX `FK_bugtracker_comments_bugs` (`bug_id`),
        //            INDEX `FK_bugtracker_comments_users` (`poster_id`),
        //            CONSTRAINT `FK_bugtracker_comments_bugs` FOREIGN KEY (`bug_id`) REFERENCES `[prefix]_bugs` (`id`),
        //            CONSTRAINT `FK_bugtracker_comments_users` FOREIGN KEY (`poster_id`) REFERENCES `[prefix]_users` (`id`)
        //        ) ENGINE=InnoDB;

        //        CREATE TABLE IF NOT EXISTS `[prefix]_bugtracker_attachments` (
        //            `id` INT(11) NOT NULL AUTO_INCREMENT,
        //            `bug_id` INT(11) NOT NULL,
        //            `filename` VARCHAR(255) NOT NULL,
        //            PRIMARY KEY (`id`),
        //            INDEX `FK_bugtracker_attachments_bugs` (`bug_id`),
        //            CONSTRAINT `FK_bugtracker_attachments_bugs` FOREIGN KEY (`bug_id`) REFERENCES `[prefix]_bugs` (`id`)
        //        ) ENGINE=InnoDB;";


    }

    public function uninstall()
    {

    }

    public function getUpdate($installedVersion)
    {
    }
}
