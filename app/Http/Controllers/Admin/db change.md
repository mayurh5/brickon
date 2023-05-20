ALTER TABLE `mst_role` CHANGE `role_type_term` `role_type_term` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;


ALTER TABLE `users` ADD `mobile_no` VARCHAR(15) NULL AFTER `password`;

ALTER TABLE `users` ADD `first_name` VARCHAR(50) NULL AFTER `association_type`, ADD `last_name` VARCHAR(50) NULL AFTER `first_name`, ADD `display_name` VARCHAR(50) NULL AFTER `last_name`;


ALTER TABLE `user_role` DROP `permission_detail`
ALTER TABLE `user_role` DROP `permission_name`


ALTER TABLE `users` ADD `is_active` TINYINT(4) NOT NULL DEFAULT '1' AFTER `branch_id`;
