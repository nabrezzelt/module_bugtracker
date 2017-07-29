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
        $query = "  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
                    /*!40101 SET NAMES utf8 */;
                    /*!50503 SET NAMES utf8mb4 */;
                    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
                    /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

                    CREATE TABLE IF NOT EXISTS `bugs` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `sub_category_id` int(11) NOT NULL,
                        `title` varchar(250) NOT NULL,
                        `description` longtext NOT NULL,
                        `priority` int(11) DEFAULT NULL,
                        `creator_id` int(11) unsigned NOT NULL,
                        `progress` int(11) NOT NULL DEFAULT '0',
                        `status_id` int(11) NOT NULL,
                        `intern_only` tinyint(4) NOT NULL DEFAULT '0',
                        `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`),
                        KEY `FK_bugs_bugtracker_sub_categories` (`sub_category_id`),
                        KEY `FK_bugs_users` (`creator_id`),
                        KEY `FK_bugs_bugtracker_status` (`status_id`),
                        CONSTRAINT `FK_bugs_bugtracker_status` FOREIGN KEY (`status_id`) REFERENCES `bugtracker_status` (`id`),
                        CONSTRAINT `FK_bugs_bugtracker_sub_categories` FOREIGN KEY (`sub_category_id`) REFERENCES `bugtracker_sub_categories` (`id`),
                        CONSTRAINT `FK_bugs_users` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                    CREATE TABLE IF NOT EXISTS `bugtracker_assigned_users` (
                        `bug_id` int(11) NOT NULL,
                        `user_id` int(11) unsigned NOT NULL,
                        PRIMARY KEY (`bug_id`,`user_id`),
                        KEY `FK_bugtracker_assigned_users_users` (`user_id`),
                        CONSTRAINT `FK_bugtracker_assigned_users_bugs` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`id`),
                        CONSTRAINT `FK_bugtracker_assigned_users_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                    CREATE TABLE IF NOT EXISTS `bugtracker_attachments` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `bug_id` int(11) NOT NULL,
                        `filename` varchar(255) NOT NULL,
                        `upload_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`),
                        KEY `FK_bugtracker_attachments_bugs` (`bug_id`),
                        CONSTRAINT `FK_bugtracker_attachments_bugs` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                    /*!40000 ALTER TABLE `bugtracker_attachments` DISABLE KEYS */;
                    /*!40000 ALTER TABLE `bugtracker_attachments` ENABLE KEYS */;

                    CREATE TABLE IF NOT EXISTS `bugtracker_categories` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `name` varchar(50) NOT NULL,
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


                    CREATE TABLE IF NOT EXISTS `bugtracker_comments` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `bug_id` int(11) NOT NULL,
                        `content` longtext NOT NULL,
                        `poster_id` int(11) unsigned NOT NULL,
                        `intern_only` tinyint(4) NOT NULL DEFAULT '0',
                        `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`),
                        KEY `FK_bugtracker_comments_bugs` (`bug_id`),
                        KEY `FK_bugtracker_comments_users` (`poster_id`),
                        CONSTRAINT `FK_bugtracker_comments_bugs` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`id`),
                        CONSTRAINT `FK_bugtracker_comments_users` FOREIGN KEY (`poster_id`) REFERENCES `users` (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                    CREATE TABLE IF NOT EXISTS `[prefix]_bugtracker_status` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `name` varchar(255) NOT NULL,
                        `css_class` varchar(50) NOT NULL DEFAULT '',
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                    /*!40000 ALTER TABLE `[prefix]_bugtracker_status` DISABLE KEYS */;
                    INSERT INTO `[prefix]_bugtracker_status` (`id`, `name`, `css_class`) VALUES
	                    (1, '<i class='fa fa-info-circle'></i> New Report', 'label label-success'),
	                    (2, 'Confirmed', 'label label-success'),
	                    (3, 'Assigned', 'label label-success'),
	                    (4, 'In Progress', 'label label-warning'),
	                    (5, 'Complete', 'label label-success'),
	                    (6, 'Ready for testing', 'label label-primary'),
	                    (7, 'Fixed', 'label label-success'),
	                    (8, '<i class='fa fa-times-circle'></i> Closed', 'label label-danger'),
	                    (9, 'No Bug', 'label label-default');
                    /*!40000 ALTER TABLE `[prefix]_bugtracker_status` ENABLE KEYS */;

                    CREATE TABLE IF NOT EXISTS `[prefix]_bugtracker_sub_categories` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `category_id` int(11) NOT NULL,
                        `name` varchar(50) NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `FK_bugtracker_sub_category_bugtracker_category` (`category_id`),
                        CONSTRAINT `FK_bugtracker_sub_category_bugtracker_category` FOREIGN KEY (`category_id`) REFERENCES `[prefix]_bugtracker_categories` (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


                    CREATE TABLE IF NOT EXISTS `[prefix]_bugtracker_votes` (
                        `bug_id` int(11) NOT NULL,
                        `user_id` int(11) unsigned NOT NULL,
                        `type` enum('like','dislike') NOT NULL,
                        PRIMARY KEY (`bug_id`,`user_id`),
                        KEY `FK_bugtracker_votes_users` (`user_id`),
                        CONSTRAINT `FK_bugtracker_votes_bugs` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`id`),
                        CONSTRAINT `FK_bugtracker_votes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                    /*!40000 ALTER TABLE `[prefix]_bugtracker_votes` DISABLE KEYS */;
                    /*!40000 ALTER TABLE `[prefix]_bugtracker_votes` ENABLE KEYS */;

                    /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
                    /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
                    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
";

        $this->db()->query($query);
    }

    public function uninstall()
    {

    }

    public function getUpdate($installedVersion)
    {
    }
}
