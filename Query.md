## 13-01-2026

ALTER TABLE `company_documents` ADD CONSTRAINT `company_documents_company_profile_id_foreign_key` FOREIGN KEY (`company_profile_id`) REFERENCES `company_profiles`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

## 16-01-2026

INSERT INTO `permissions` (`id`, `pname`, `created_at`, `updated_at`) VALUES (NULL, 'Company Profile', NULL, NULL), (NULL, 'Company Employee', NULL, NULL);

ALTER TABLE `company_emp_documents` DROP FOREIGN KEY `company_emp_documents_company_profile_id_foreign_key`; ALTER TABLE `company_emp_documents` ADD CONSTRAINT `company_emp_documents_company_profile_id_foreign_key` FOREIGN KEY (`eid`) REFERENCES `company_employees`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

## 09-02-2026

ALTER TABLE `subservices` ADD `subservice_code` VARCHAR(255) NULL DEFAULT NULL AFTER `page_url`;
