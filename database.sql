-- Zimnat Policy Management System Database Setup
-- MySQL / MariaDB compatible

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

-- Table structure for table `users`
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','policy_officer','client') NOT NULL DEFAULT 'client',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `policies`
CREATE TABLE `policies` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `policy_number` varchar(255) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `insurance_type` varchar(255) NOT NULL,
  `premium_amount` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `renewal_date` date NOT NULL,
  `status` enum('Active','Expired','Pending Renewal') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `policies_policy_number_unique` (`policy_number`),
  KEY `policies_client_id_foreign` (`client_id`),
  CONSTRAINT `policies_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `documents`
CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `policy_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_policy_id_foreign` (`policy_id`),
  CONSTRAINT `documents_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `queries`
CREATE TABLE `queries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `response` text DEFAULT NULL,
  `status` enum('Open','In Progress','Resolved') NOT NULL DEFAULT 'Open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `queries_client_id_foreign` (`client_id`),
  CONSTRAINT `queries_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Initial Seed Data
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@zimnat.co.zw', '$2y$12$R.Sj9u7WjHqXNlS5.o.G..yR/u6pE2G7GvH0U7I0Y6e3Y1M9m.C3.', 'admin', NOW(), NOW()),
(2, 'Officer One', 'officer@zimnat.co.zw', '$2y$12$R.Sj9u7WjHqXNlS5.o.G..yR/u6pE2G7GvH0U7I0Y6e3Y1M9m.C3.', 'policy_officer', NOW(), NOW()),
(3, 'John Doe', 'client@example.com', '$2y$12$R.Sj9u7WjHqXNlS5.o.G..yR/u6pE2G7GvH0U7I0Y6e3Y1M9m.C3.', 'client', NOW(), NOW());

INSERT INTO `policies` (`id`, `policy_number`, `client_id`, `insurance_type`, `premium_amount`, `start_date`, `renewal_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ZIM-POL-001', 3, 'Life Insurance', 150.00, DATE_SUB(NOW(), INTERVAL 6 MONTH), DATE_ADD(NOW(), INTERVAL 6 MONTH), 'Active', NOW(), NOW());

COMMIT;
