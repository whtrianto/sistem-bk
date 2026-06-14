/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : bk_smk

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 14/06/2026 23:27:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for academic_years
-- ----------------------------
DROP TABLE IF EXISTS `academic_years`;
CREATE TABLE `academic_years`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `year` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` enum('ganjil','genap') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of academic_years
-- ----------------------------
INSERT INTO `academic_years` VALUES (1, '2025/2026', 'genap', 1, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `academic_years` VALUES (2, '2025/2026', 'genap', 1, '2026-06-03 11:17:41', '2026-06-03 11:17:41');

-- ----------------------------
-- Table structure for achievement_types
-- ----------------------------
DROP TABLE IF EXISTS `achievement_types`;
CREATE TABLE `achievement_types`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('akademik','non_akademik','karakter') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int NOT NULL DEFAULT 0,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of achievement_types
-- ----------------------------
INSERT INTO `achievement_types` VALUES (1, 'Juara kelas', 'akademik', 10, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `achievement_types` VALUES (2, 'Juara lomba tingkat kabupaten', 'akademik', 15, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `achievement_types` VALUES (3, 'Juara lomba tingkat provinsi', 'akademik', 20, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `achievement_types` VALUES (4, 'Juara lomba tingkat nasional', 'akademik', 30, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `achievement_types` VALUES (5, 'Aktif organisasi OSIS', 'non_akademik', 10, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `achievement_types` VALUES (6, 'Menjadi ketua kelas teladan', 'karakter', 10, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `achievement_types` VALUES (7, 'Membantu korban bencana', 'karakter', 15, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `achievement_types` VALUES (8, 'Juara kelas', 'akademik', 10, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `achievement_types` VALUES (9, 'Juara lomba tingkat kabupaten', 'akademik', 15, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `achievement_types` VALUES (10, 'Juara lomba tingkat provinsi', 'akademik', 20, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `achievement_types` VALUES (11, 'Juara lomba tingkat nasional', 'akademik', 30, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `achievement_types` VALUES (12, 'Aktif organisasi OSIS', 'non_akademik', 10, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `achievement_types` VALUES (13, 'Menjadi ketua kelas teladan', 'karakter', 10, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `achievement_types` VALUES (14, 'Membantu korban bencana', 'karakter', 15, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');

-- ----------------------------
-- Table structure for achievements
-- ----------------------------
DROP TABLE IF EXISTS `achievements`;
CREATE TABLE `achievements`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `achievement_type_id` bigint UNSIGNED NOT NULL,
  `recorded_by` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `points_added` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `achievements_student_id_foreign`(`student_id` ASC) USING BTREE,
  INDEX `achievements_achievement_type_id_foreign`(`achievement_type_id` ASC) USING BTREE,
  INDEX `achievements_recorded_by_foreign`(`recorded_by` ASC) USING BTREE,
  CONSTRAINT `achievements_achievement_type_id_foreign` FOREIGN KEY (`achievement_type_id`) REFERENCES `achievement_types` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `achievements_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `achievements_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of achievements
-- ----------------------------
INSERT INTO `achievements` VALUES (1, 4, 5, 3, '2026-05-10', 'Prestasi tercatat.', 10, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `achievements` VALUES (2, 5, 4, 3, '2026-05-14', 'Prestasi tercatat.', 30, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `achievements` VALUES (3, 6, 3, 3, '2026-05-15', 'Prestasi tercatat.', 20, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `achievements` VALUES (4, 11, 3, 4, '2026-06-13', 'mendapatkan piala juara 1', 20, '2026-06-13 08:59:13', '2026-06-13 08:59:13');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_locks_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for counseling_categories
-- ----------------------------
DROP TABLE IF EXISTS `counseling_categories`;
CREATE TABLE `counseling_categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#6366F1',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bi-chat-dots',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of counseling_categories
-- ----------------------------
INSERT INTO `counseling_categories` VALUES (1, 'Belajar', '#6366F1', 'bi-book', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `counseling_categories` VALUES (2, 'Pribadi', '#8B5CF6', 'bi-person', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `counseling_categories` VALUES (3, 'Sosial', '#EC4899', 'bi-people', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `counseling_categories` VALUES (4, 'Karier', '#F59E0B', 'bi-briefcase', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `counseling_categories` VALUES (5, 'Belajar', '#6366F1', 'bi-book', '2026-06-03 11:17:41', '2026-06-03 11:17:41');
INSERT INTO `counseling_categories` VALUES (6, 'Pribadi', '#8B5CF6', 'bi-person', '2026-06-03 11:17:41', '2026-06-03 11:17:41');
INSERT INTO `counseling_categories` VALUES (7, 'Sosial', '#EC4899', 'bi-people', '2026-06-03 11:17:41', '2026-06-03 11:17:41');
INSERT INTO `counseling_categories` VALUES (8, 'Karier', '#F59E0B', 'bi-briefcase', '2026-06-03 11:17:41', '2026-06-03 11:17:41');

-- ----------------------------
-- Table structure for counseling_schedules
-- ----------------------------
DROP TABLE IF EXISTS `counseling_schedules`;
CREATE TABLE `counseling_schedules`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `counselor_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `status` enum('pending','approved','rejected','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `requested_by` enum('student','counselor') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `counseling_schedules_student_id_foreign`(`student_id` ASC) USING BTREE,
  INDEX `counseling_schedules_counselor_id_foreign`(`counselor_id` ASC) USING BTREE,
  CONSTRAINT `counseling_schedules_counselor_id_foreign` FOREIGN KEY (`counselor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `counseling_schedules_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of counseling_schedules
-- ----------------------------
INSERT INTO `counseling_schedules` VALUES (2, 1, 3, '2026-06-15', '21:35:00', '22:35:00', 'completed', 'curhat', NULL, 'student', '2026-06-12 12:35:33', '2026-06-12 12:40:21');
INSERT INTO `counseling_schedules` VALUES (3, 1, 4, '2026-06-15', '09:00:00', '10:00:00', 'approved', 'ingin tau metode belajar dengan benar', NULL, 'student', '2026-06-13 01:53:25', '2026-06-13 01:55:55');
INSERT INTO `counseling_schedules` VALUES (4, 1, 4, '2026-06-13', '13:00:00', '14:00:00', 'approved', 'saya susah dalam belajar matematika', NULL, 'student', '2026-06-13 05:21:41', '2026-06-13 05:24:12');
INSERT INTO `counseling_schedules` VALUES (5, 1, 4, '2026-06-15', '13:00:00', '14:00:00', 'completed', 'ingin mendapatkan ilmu baru terkait matematika yg tidak dapat dipahami', NULL, 'student', '2026-06-13 08:52:04', '2026-06-13 08:57:08');

-- ----------------------------
-- Table structure for counselings
-- ----------------------------
DROP TABLE IF EXISTS `counselings`;
CREATE TABLE `counselings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `counselor_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `problem` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `solution` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `follow_up` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` enum('pending','ongoing','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_confidential` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `counselings_student_id_foreign`(`student_id` ASC) USING BTREE,
  INDEX `counselings_counselor_id_foreign`(`counselor_id` ASC) USING BTREE,
  INDEX `counselings_category_id_foreign`(`category_id` ASC) USING BTREE,
  CONSTRAINT `counselings_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `counseling_categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `counselings_counselor_id_foreign` FOREIGN KEY (`counselor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `counselings_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of counselings
-- ----------------------------
INSERT INTO `counselings` VALUES (1, 1, 3, 2, '2026-05-22', 'Siswa mengalami kesulitan dalam hal tertentu dan membutuhkan bimbingan.', 'Dilakukan pendekatan dan pemberian motivasi.', 'Monitoring dalam 2 minggu ke depan.', 'completed', 0, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `counselings` VALUES (2, 2, 3, 3, '2026-05-26', 'Siswa mengalami kesulitan dalam hal tertentu dan membutuhkan bimbingan.', 'Dilakukan pendekatan dan pemberian motivasi.', 'Monitoring dalam 2 minggu ke depan.', 'pending', 0, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `counselings` VALUES (3, 5, 3, 1, '2026-05-24', 'Siswa mengalami kesulitan dalam hal tertentu dan membutuhkan bimbingan.', 'Dilakukan pendekatan dan pemberian motivasi.', 'Monitoring dalam 2 minggu ke depan.', 'ongoing', 0, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `counselings` VALUES (4, 7, 3, 1, '2026-05-28', 'Siswa mengalami kesulitan dalam hal tertentu dan membutuhkan bimbingan.', 'Dilakukan pendekatan dan pemberian motivasi.', 'Monitoring dalam 2 minggu ke depan.', 'completed', 0, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `counselings` VALUES (5, 1, 4, 1, '2026-06-15', 'oh dia susah belajar', 'harus tidak pegang hp.', '-', 'completed', 0, '2026-06-13 01:57:36', '2026-06-13 05:26:56');
INSERT INTO `counselings` VALUES (6, 1, 4, 1, '2026-06-15', 'susah belajar matematika', 'harus jauhi mainan hp sebelum belajar supaya konsen', '-', 'completed', 1, '2026-06-13 05:26:00', '2026-06-13 05:26:17');
INSERT INTO `counselings` VALUES (7, 1, 4, 1, '2026-06-15', 'susah belajar matematika', 'hindari main hp saat belajar', '-', 'completed', 0, '2026-06-13 08:56:22', '2026-06-13 08:56:44');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE,
  INDEX `failed_jobs_connection_queue_failed_at_index`(`connection` ASC, `queue` ASC, `failed_at` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2025_01_01_000001_create_academic_years_table', 1);
INSERT INTO `migrations` VALUES (5, '2025_01_01_000002_create_teachers_table', 1);
INSERT INTO `migrations` VALUES (6, '2025_01_01_000003_create_school_classes_table', 1);
INSERT INTO `migrations` VALUES (7, '2025_01_01_000004_create_students_table', 1);
INSERT INTO `migrations` VALUES (8, '2025_01_01_000005_create_violation_types_table', 1);
INSERT INTO `migrations` VALUES (9, '2025_01_01_000006_create_achievement_types_table', 1);
INSERT INTO `migrations` VALUES (10, '2025_01_01_000007_create_violations_table', 1);
INSERT INTO `migrations` VALUES (11, '2025_01_01_000008_create_achievements_table', 1);
INSERT INTO `migrations` VALUES (12, '2025_01_01_000009_create_counseling_categories_table', 1);
INSERT INTO `migrations` VALUES (13, '2025_01_01_000010_create_counselings_table', 1);
INSERT INTO `migrations` VALUES (14, '2025_01_01_000011_create_counseling_schedules_table', 1);
INSERT INTO `migrations` VALUES (15, '2025_01_01_000012_create_point_histories_table', 1);
INSERT INTO `migrations` VALUES (16, '2025_01_01_000013_create_parent_letters_table', 1);
INSERT INTO `migrations` VALUES (17, '2025_01_01_000014_create_wa_logs_table', 1);
INSERT INTO `migrations` VALUES (18, '2025_01_01_000015_create_school_settings_table', 1);

-- ----------------------------
-- Table structure for parent_letters
-- ----------------------------
DROP TABLE IF EXISTS `parent_letters`;
CREATE TABLE `parent_letters`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `generated_by` bigint UNSIGNED NOT NULL,
  `letter_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meeting_date` date NOT NULL,
  `meeting_time` time NOT NULL,
  `status` enum('generated','sent','confirmed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'generated',
  `pdf_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `parent_letters_letter_number_unique`(`letter_number` ASC) USING BTREE,
  INDEX `parent_letters_student_id_foreign`(`student_id` ASC) USING BTREE,
  INDEX `parent_letters_generated_by_foreign`(`generated_by` ASC) USING BTREE,
  CONSTRAINT `parent_letters_generated_by_foreign` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `parent_letters_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of parent_letters
-- ----------------------------
INSERT INTO `parent_letters` VALUES (1, 11, 4, 'SP/2026/06/0001', 'gak berangkat sekolah', '2026-06-15', '09:00:00', 'sent', NULL, '2026-06-13 09:00:06', '2026-06-13 09:00:06');

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for point_histories
-- ----------------------------
DROP TABLE IF EXISTS `point_histories`;
CREATE TABLE `point_histories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `type` enum('violation','achievement') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint UNSIGNED NOT NULL,
  `points` int NOT NULL,
  `balance_after` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `point_histories_student_id_foreign`(`student_id` ASC) USING BTREE,
  CONSTRAINT `point_histories_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of point_histories
-- ----------------------------
INSERT INTO `point_histories` VALUES (1, 1, 'violation', 1, -20, 80, 'Pelanggaran: Membully teman', '2026-05-24', '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `point_histories` VALUES (2, 2, 'violation', 2, -5, 95, 'Pelanggaran: Tidak memakai seragam lengkap', '2026-05-30', '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `point_histories` VALUES (3, 3, 'violation', 3, -10, 90, 'Pelanggaran: Membawa HP saat pelajaran', '2026-05-10', '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `point_histories` VALUES (4, 4, 'achievement', 1, 10, 110, 'Prestasi: Aktif organisasi OSIS', '2026-05-10', '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `point_histories` VALUES (5, 5, 'achievement', 2, 30, 130, 'Prestasi: Juara lomba tingkat nasional', '2026-05-14', '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `point_histories` VALUES (6, 6, 'achievement', 3, 20, 120, 'Prestasi: Juara lomba tingkat provinsi', '2026-05-15', '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `point_histories` VALUES (7, 11, 'violation', 4, -20, 80, 'Pelanggaran: Merusak fasilitas sekolah', '2026-06-03', '2026-06-03 13:33:24', '2026-06-03 13:33:24');
INSERT INTO `point_histories` VALUES (8, 11, 'violation', 5, -5, 75, 'Pelanggaran: Tidak memakai seragam lengkap', '2026-06-03', '2026-06-03 14:05:27', '2026-06-03 14:05:27');
INSERT INTO `point_histories` VALUES (9, 1, 'violation', 6, -5, 75, 'Pelanggaran: Terlambat masuk sekolah', '2026-06-12', '2026-06-12 12:41:55', '2026-06-12 12:41:55');
INSERT INTO `point_histories` VALUES (10, 11, 'violation', 7, -5, 70, 'Pelanggaran: Terlambat masuk sekolah', '2026-06-13', '2026-06-13 01:06:06', '2026-06-13 01:06:06');
INSERT INTO `point_histories` VALUES (11, 11, 'violation', 8, -5, 65, 'Pelanggaran: Tidak mengerjakan tugas', '2026-06-13', '2026-06-13 05:27:59', '2026-06-13 05:27:59');
INSERT INTO `point_histories` VALUES (12, 11, 'violation', 9, -5, 60, 'Pelanggaran: Tidak memakai seragam lengkap', '2026-06-12', '2026-06-13 08:58:16', '2026-06-13 08:58:16');
INSERT INTO `point_histories` VALUES (13, 11, 'achievement', 4, 20, 80, 'Prestasi: Juara lomba tingkat provinsi', '2026-06-13', '2026-06-13 08:59:13', '2026-06-13 08:59:13');

-- ----------------------------
-- Table structure for school_classes
-- ----------------------------
DROP TABLE IF EXISTS `school_classes`;
CREATE TABLE `school_classes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('X','XI','XII') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `major` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `academic_year_id` bigint UNSIGNED NOT NULL,
  `wali_kelas_id` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `school_classes_academic_year_id_foreign`(`academic_year_id` ASC) USING BTREE,
  INDEX `school_classes_wali_kelas_id_foreign`(`wali_kelas_id` ASC) USING BTREE,
  CONSTRAINT `school_classes_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `school_classes_wali_kelas_id_foreign` FOREIGN KEY (`wali_kelas_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of school_classes
-- ----------------------------
INSERT INTO `school_classes` VALUES (1, 'RPL 1', 'X', 'Rekayasa Perangkat Lunak', 1, 5, '2026-06-03 11:12:21', '2026-06-03 11:12:21');
INSERT INTO `school_classes` VALUES (2, 'TKJ 1', 'X', 'Teknik Komputer & Jaringan', 1, 6, '2026-06-03 11:12:21', '2026-06-03 11:12:21');
INSERT INTO `school_classes` VALUES (3, 'RPL 1', 'XI', 'Rekayasa Perangkat Lunak', 1, NULL, '2026-06-03 11:12:21', '2026-06-03 11:12:21');
INSERT INTO `school_classes` VALUES (4, 'TKJ 1', 'XI', 'Teknik Komputer & Jaringan', 1, NULL, '2026-06-03 11:12:21', '2026-06-03 11:12:21');

-- ----------------------------
-- Table structure for school_settings
-- ----------------------------
DROP TABLE IF EXISTS `school_settings`;
CREATE TABLE `school_settings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `school_settings_key_unique`(`key` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of school_settings
-- ----------------------------
INSERT INTO `school_settings` VALUES (1, 'school_name', 'SMK Negeri 1 Nusantara', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `school_settings` VALUES (2, 'school_address', 'Jl. Pendidikan No. 1, Kota Nusantara', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `school_settings` VALUES (3, 'school_phone', '(021) 1234567', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `school_settings` VALUES (4, 'school_email', 'info@smkn1nusantara.sch.id', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `school_settings` VALUES (5, 'school_logo', 'uploads/logo_1781453875.png', '2026-06-03 11:12:19', '2026-06-14 16:17:55');
INSERT INTO `school_settings` VALUES (6, 'principal_name', 'Drs. Budi Santoso, M.Pd', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `school_settings` VALUES (7, 'principal_nip', '196501011990031001', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `school_settings` VALUES (8, 'wa_api_token', '8jJA18aNeCBNQEmchYDi', '2026-06-03 11:12:19', '2026-06-03 14:04:04');
INSERT INTO `school_settings` VALUES (9, 'wa_api_url', 'https://api.fonnte.com/send', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `school_settings` VALUES (10, 'initial_student_points', '100', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `school_settings` VALUES (11, 'warning_point_threshold', '50', '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `school_settings` VALUES (12, 'critical_point_threshold', '25', '2026-06-03 11:12:19', '2026-06-03 11:12:19');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('qKzH26mZRgWr3IIAhUMXzYhszN8ITT4N5TofZJi9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJhSHhDZXQzQ0dKdktUelhHVlBnaVJHQ1A2Z0NOSkZ4MGF0S2NKY3dkIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==', 1781453945);

-- ----------------------------
-- Table structure for students
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED NULL DEFAULT NULL,
  `nis` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nisn` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `gender` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NULL DEFAULT NULL,
  `birth_place` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `parent_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parent_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `parent_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `initial_points` int NOT NULL DEFAULT 100,
  `current_points` int NOT NULL DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `students_nis_unique`(`nis` ASC) USING BTREE,
  UNIQUE INDEX `students_nisn_unique`(`nisn` ASC) USING BTREE,
  INDEX `students_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `students_class_id_foreign`(`class_id` ASC) USING BTREE,
  CONSTRAINT `students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of students
-- ----------------------------
INSERT INTO `students` VALUES (1, 7, 1, '20250001', '0000000001', 'L', '2010-06-03', 'Kota Nusantara', 'Jl. Siswa No. 1', 'Bpk. Pratama', '081300000001', NULL, NULL, 100, 75, '2026-06-03 11:12:21', '2026-06-12 12:41:55');
INSERT INTO `students` VALUES (2, 8, 2, '20250002', '0000000002', 'L', '2010-05-04', 'Kota Nusantara', 'Jl. Siswa No. 2', 'Bpk. Setiawan', '081300000002', NULL, NULL, 100, 95, '2026-06-03 11:12:22', '2026-06-03 11:12:24');
INSERT INTO `students` VALUES (3, 9, 3, '20250003', '0000000003', 'P', '2010-04-04', 'Kota Nusantara', 'Jl. Siswa No. 3', 'Ibu Dewi', '081300000003', NULL, NULL, 100, 90, '2026-06-03 11:12:22', '2026-06-03 11:12:24');
INSERT INTO `students` VALUES (4, 10, 4, '20250004', '0000000004', 'P', '2010-03-05', 'Kota Nusantara', 'Jl. Siswa No. 4', 'Ibu Sari', '081300000004', NULL, NULL, 100, 110, '2026-06-03 11:12:22', '2026-06-03 11:12:24');
INSERT INTO `students` VALUES (5, 11, 1, '20250005', '0000000005', 'L', '2010-02-03', 'Kota Nusantara', 'Jl. Siswa No. 5', 'Bpk. Prasetyo', '081300000005', NULL, NULL, 100, 130, '2026-06-03 11:12:23', '2026-06-03 11:12:24');
INSERT INTO `students` VALUES (6, 12, 2, '20250006', '0000000006', 'P', '2010-01-04', 'Kota Nusantara', 'Jl. Siswa No. 6', 'Ibu Handayani', '081300000006', NULL, NULL, 100, 120, '2026-06-03 11:12:23', '2026-06-03 11:12:24');
INSERT INTO `students` VALUES (7, 13, 3, '20250007', '0000000007', 'L', '2009-12-05', 'Kota Nusantara', 'Jl. Siswa No. 7', 'Bpk. Ramadhan', '081300000007', NULL, NULL, 100, 100, '2026-06-03 11:12:23', '2026-06-03 11:12:23');
INSERT INTO `students` VALUES (8, 14, 4, '20250008', '0000000008', 'P', '2009-11-05', 'Kota Nusantara', 'Jl. Siswa No. 8', 'Ibu Safira', '081300000008', NULL, NULL, 100, 100, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `students` VALUES (9, 15, 1, '20250009', '0000000009', 'L', '2009-10-06', 'Kota Nusantara', 'Jl. Siswa No. 9', 'Bpk. Maulana', '081300000009', NULL, NULL, 100, 100, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `students` VALUES (10, 16, 2, '20250010', '0000000010', 'P', '2009-09-06', 'Kota Nusantara', 'Jl. Siswa No. 10', 'Ibu Anggraini', '081300000010', NULL, NULL, 100, 100, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `students` VALUES (11, 18, 1, '222222', '222222', 'L', '2004-06-07', 'test', 'test alamat siswa', 'ortu test', '089666077720', 'test alamat ortu', NULL, 100, 80, '2026-06-03 13:32:35', '2026-06-13 08:59:13');

-- ----------------------------
-- Table structure for teachers
-- ----------------------------
DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `nip` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `specialization` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `teachers_nip_unique`(`nip` ASC) USING BTREE,
  INDEX `teachers_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of teachers
-- ----------------------------
INSERT INTO `teachers` VALUES (1, 3, '198001012010012001', 'Konseling Pribadi & Sosial', '2026-06-03 11:12:20', '2026-06-03 11:12:20');
INSERT INTO `teachers` VALUES (2, 4, '198505152012011002', 'Konseling Belajar & Karier', '2026-06-03 11:12:20', '2026-06-03 11:12:20');
INSERT INTO `teachers` VALUES (3, 5, '199003212015012003', NULL, '2026-06-03 11:12:21', '2026-06-03 11:12:21');
INSERT INTO `teachers` VALUES (4, 6, '199112012016011004', NULL, '2026-06-03 11:12:21', '2026-06-03 11:12:21');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','guru_bk','wali_kelas','siswa','kepsek') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Administrator', 'admin@smk.sch.id', NULL, '$2y$12$VNp.HpRBTrVKItjbLpkZlOcbBBxgbGs1Umk5gQ3PhdjoL4QLZU8FS', 'admin', '081234567890', NULL, 1, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `users` VALUES (2, 'Drs. Budi Santoso, M.Pd', 'kepsek@smk.sch.id', NULL, '$2y$12$A7Zt4GjoAuNq8Qe3LQGAZ.aR.17C/4NdlZbVpAOb.mw3xPWb6UUPK', 'kepsek', '081234567891', NULL, 1, NULL, '2026-06-03 11:12:20', '2026-06-03 11:12:20');
INSERT INTO `users` VALUES (3, 'Siti Aminah, S.Pd', 'guru.bk1@smk.sch.id', NULL, '$2y$12$4dVFbNzfRCzLIWevZOhZQu3m9/x.qOobTAR3K8VBm22vmhml2KKvW', 'guru_bk', '081234567892', NULL, 1, NULL, '2026-06-03 11:12:20', '2026-06-03 11:12:20');
INSERT INTO `users` VALUES (4, 'Ahmad Fauzi, S.Pd', 'guru.bk2@smk.sch.id', NULL, '$2y$12$L1zYDG1rN1PJmFhz6h/LVewhgBp9sU0i5oQlMPN6QfdGlfs7X3QDa', 'guru_bk', '081234567893', NULL, 1, NULL, '2026-06-03 11:12:20', '2026-06-03 11:12:20');
INSERT INTO `users` VALUES (5, 'Dewi Lestari, S.Pd', 'wali.kelas1@smk.sch.id', NULL, '$2y$12$0Af.QsU2aVkuyehxrdtFreSkAifn5D9ZWguI69usdsoCwbzu3ktyy', 'wali_kelas', '081234567894', NULL, 1, NULL, '2026-06-03 11:12:21', '2026-06-03 11:12:21');
INSERT INTO `users` VALUES (6, 'Rudi Hartono, S.T', 'wali.kelas2@smk.sch.id', NULL, '$2y$12$PajB9Zvt/9R92kuqg/LjXugkxcwli0/GDx2AywqYN.uNAvBSpp.MG', 'wali_kelas', '081234567895', NULL, 1, NULL, '2026-06-03 11:12:21', '2026-06-03 11:12:21');
INSERT INTO `users` VALUES (7, 'Andi Pratama', 'andi.pratama@siswa.smk.sch.id', NULL, '$2y$12$T62U6BuJPP5nvzJD0vyMnOvZRhD.OxcssNTvfGzzlslndCUhm.Ha2', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 11:12:21', '2026-06-03 11:12:21');
INSERT INTO `users` VALUES (8, 'Budi Setiawan', 'budi.setiawan@siswa.smk.sch.id', NULL, '$2y$12$0Z3LoPpew56JgMiCN5SFW./.56xgO.mX4kwENpGjgipQgZ47b6vt6', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 11:12:22', '2026-06-03 11:12:22');
INSERT INTO `users` VALUES (9, 'Citra Dewi', 'citra.dewi@siswa.smk.sch.id', NULL, '$2y$12$2vBJQyul6RyauUuZvtd1DOt1F8tdBXmHzmgRxV4O2rVkO7Il0yKtK', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 11:12:22', '2026-06-03 11:12:22');
INSERT INTO `users` VALUES (10, 'Diana Putri', 'diana.putri@siswa.smk.sch.id', NULL, '$2y$12$9LcMMr64hTDppFReh04fmeR4EDxvfDKF8WYHgMrtVtRiTY2rPkoHW', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 11:12:22', '2026-06-03 11:12:22');
INSERT INTO `users` VALUES (11, 'Eko Prasetyo', 'eko.prasetyo@siswa.smk.sch.id', NULL, '$2y$12$VWmjb763OI/F81oaFqqleeOZ6fObwzvguz7k592jeEBm6g4mt01ua', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 11:12:23', '2026-06-03 11:12:23');
INSERT INTO `users` VALUES (12, 'Fitri Handayani', 'fitri.handayani@siswa.smk.sch.id', NULL, '$2y$12$RPGcIhSVkJb0nmg71at0..QpV7LdA3/qOjwoJHcWKEoGzcqW.pRaG', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 11:12:23', '2026-06-03 11:12:23');
INSERT INTO `users` VALUES (13, 'Galih Ramadhan', 'galih.ramadhan@siswa.smk.sch.id', NULL, '$2y$12$pToBeoINy6qglR3YshPQq.rpXxFtDaGyFVEB7GVdWHd7OP6X9y2s.', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 11:12:23', '2026-06-03 11:12:23');
INSERT INTO `users` VALUES (14, 'Hana Safira', 'hana.safira@siswa.smk.sch.id', NULL, '$2y$12$.0Z64Uw6udG0r8PQEXhYy.mb9FaC8jrEmh0QLu2gyBh8DpNSxZSz.', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `users` VALUES (15, 'Irfan Maulana', 'irfan.maulana@siswa.smk.sch.id', NULL, '$2y$12$Z4ghlaeYbQNT2WtgrGXPcuneKWl.GOjNbRv3rIMgogbVTm0PnxfZ.', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `users` VALUES (16, 'Julia Anggraini', 'julia.anggraini@siswa.smk.sch.id', NULL, '$2y$12$oCoO5Lec5oi9LbPaiz0qg.zljNbXyo0jllELW77UeOhvQyaO7sx5W', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `users` VALUES (18, 'test', 'zentrixkreasi@gmail.com', NULL, '$2y$12$L1zYDG1rN1PJmFhz6h/LVewhgBp9sU0i5oQlMPN6QfdGlfs7X3QDa', 'siswa', NULL, NULL, 1, NULL, '2026-06-03 13:32:34', '2026-06-03 13:32:34');

-- ----------------------------
-- Table structure for violation_types
-- ----------------------------
DROP TABLE IF EXISTS `violation_types`;
CREATE TABLE `violation_types`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('ringan','sedang','berat') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int NOT NULL DEFAULT 0,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of violation_types
-- ----------------------------
INSERT INTO `violation_types` VALUES (1, 'Terlambat masuk sekolah', 'ringan', 5, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `violation_types` VALUES (2, 'Tidak memakai seragam lengkap', 'ringan', 5, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `violation_types` VALUES (3, 'Tidak mengerjakan tugas', 'ringan', 5, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `violation_types` VALUES (4, 'Membolos pelajaran', 'sedang', 10, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `violation_types` VALUES (5, 'Membawa HP saat pelajaran', 'sedang', 10, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `violation_types` VALUES (6, 'Merokok di lingkungan sekolah', 'sedang', 15, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `violation_types` VALUES (7, 'Berkelahi di sekolah', 'berat', 25, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `violation_types` VALUES (8, 'Membully teman', 'berat', 20, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `violation_types` VALUES (9, 'Merusak fasilitas sekolah', 'berat', 20, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `violation_types` VALUES (10, 'Mencuri', 'berat', 30, NULL, '2026-06-03 11:12:19', '2026-06-03 11:12:19');
INSERT INTO `violation_types` VALUES (11, 'Terlambat masuk sekolah', 'ringan', 5, NULL, '2026-06-03 11:17:41', '2026-06-03 11:17:41');
INSERT INTO `violation_types` VALUES (12, 'Tidak memakai seragam lengkap', 'ringan', 5, NULL, '2026-06-03 11:17:41', '2026-06-03 11:17:41');
INSERT INTO `violation_types` VALUES (13, 'Tidak mengerjakan tugas', 'ringan', 5, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `violation_types` VALUES (14, 'Membolos pelajaran', 'sedang', 10, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `violation_types` VALUES (15, 'Membawa HP saat pelajaran', 'sedang', 10, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `violation_types` VALUES (16, 'Merokok di lingkungan sekolah', 'sedang', 15, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `violation_types` VALUES (17, 'Berkelahi di sekolah', 'berat', 25, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `violation_types` VALUES (18, 'Membully teman', 'berat', 20, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `violation_types` VALUES (19, 'Merusak fasilitas sekolah', 'berat', 20, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');
INSERT INTO `violation_types` VALUES (20, 'Mencuri', 'berat', 30, NULL, '2026-06-03 11:17:42', '2026-06-03 11:17:42');

-- ----------------------------
-- Table structure for violations
-- ----------------------------
DROP TABLE IF EXISTS `violations`;
CREATE TABLE `violations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `violation_type_id` bigint UNSIGNED NOT NULL,
  `recorded_by` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `points_deducted` int NOT NULL DEFAULT 0,
  `evidence_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `violations_student_id_foreign`(`student_id` ASC) USING BTREE,
  INDEX `violations_violation_type_id_foreign`(`violation_type_id` ASC) USING BTREE,
  INDEX `violations_recorded_by_foreign`(`recorded_by` ASC) USING BTREE,
  CONSTRAINT `violations_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `violations_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `violations_violation_type_id_foreign` FOREIGN KEY (`violation_type_id`) REFERENCES `violation_types` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of violations
-- ----------------------------
INSERT INTO `violations` VALUES (1, 1, 8, 3, '2026-05-24', 'Pelanggaran tercatat oleh Guru BK.', 20, NULL, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `violations` VALUES (2, 2, 2, 3, '2026-05-30', 'Pelanggaran tercatat oleh Guru BK.', 5, NULL, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `violations` VALUES (3, 3, 5, 3, '2026-05-10', 'Pelanggaran tercatat oleh Guru BK.', 10, NULL, '2026-06-03 11:12:24', '2026-06-03 11:12:24');
INSERT INTO `violations` VALUES (4, 11, 9, 3, '2026-06-03', 'test kronologi', 20, NULL, '2026-06-03 13:33:24', '2026-06-03 13:33:24');
INSERT INTO `violations` VALUES (5, 11, 2, 3, '2026-06-03', 'vhv', 5, NULL, '2026-06-03 14:05:27', '2026-06-03 14:05:27');
INSERT INTO `violations` VALUES (6, 1, 11, 3, '2026-06-12', 'masuknya telat', 5, NULL, '2026-06-12 12:41:55', '2026-06-12 12:41:55');
INSERT INTO `violations` VALUES (7, 11, 1, 3, '2026-06-13', 'tes', 5, NULL, '2026-06-13 01:06:06', '2026-06-13 01:06:06');
INSERT INTO `violations` VALUES (8, 11, 3, 4, '2026-06-13', 'garap tugasnya', 5, NULL, '2026-06-13 05:27:59', '2026-06-13 05:27:59');
INSERT INTO `violations` VALUES (9, 11, 2, 4, '2026-06-12', 'nggak pake sabuk', 5, NULL, '2026-06-13 08:58:16', '2026-06-13 08:58:16');

-- ----------------------------
-- Table structure for wa_logs
-- ----------------------------
DROP TABLE IF EXISTS `wa_logs`;
CREATE TABLE `wa_logs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `recipient_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('violation','invitation','reminder','other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `status` enum('pending','sent','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reference_id` bigint UNSIGNED NULL DEFAULT NULL,
  `reference_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wa_logs
-- ----------------------------
INSERT INTO `wa_logs` VALUES (1, '089666077720', '⚠️ *NOTIFIKASI PELANGGARAN*\n\nYth. ortu test,\n\nDengan ini kami informasikan bahwa putra/putri Bapak/Ibu:\n\n👤 Nama: *test*\n📋 NIS: 222222\n🏫 Kelas: X RPL 1\n\nTelah melakukan pelanggaran:\n❌ *Merusak fasilitas sekolah*\n📅 Tanggal: 03/06/2026\n📉 Poin dikurangi: 20\n📊 Sisa poin: *80*\n\nMohon perhatian dan kerjasamanya.\n\nHormat kami,\n_SMK Negeri 1 Nusantara_', 'violation', 'failed', 4, 'violation', 'API token not configured', '2026-06-03 13:33:25', '2026-06-03 13:33:25');
INSERT INTO `wa_logs` VALUES (2, '089666077720', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'failed', NULL, NULL, 'cURL error 60: SSL certificate OpenSSL verify result: unable to get local issuer certificate (20) (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://api.fonnte.com/send', '2026-06-03 13:40:11', '2026-06-03 13:40:11');
INSERT INTO `wa_logs` VALUES (3, '089666077720', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'failed', NULL, NULL, 'cURL error 60: SSL certificate OpenSSL verify result: unable to get local issuer certificate (20) (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://api.fonnte.com/send', '2026-06-03 13:42:09', '2026-06-03 13:42:09');
INSERT INTO `wa_logs` VALUES (4, '+6289666077720', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'failed', NULL, NULL, 'cURL error 60: SSL certificate OpenSSL verify result: unable to get local issuer certificate (20) (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://api.fonnte.com/send', '2026-06-03 13:44:19', '2026-06-03 13:44:19');
INSERT INTO `wa_logs` VALUES (5, '+6289666077720', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'failed', NULL, NULL, 'cURL error 60: SSL certificate OpenSSL verify result: unable to get local issuer certificate (20) (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://api.fonnte.com/send', '2026-06-03 13:44:38', '2026-06-03 13:44:38');
INSERT INTO `wa_logs` VALUES (6, '089666077720', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'failed', NULL, NULL, 'cURL error 60: SSL certificate OpenSSL verify result: unable to get local issuer certificate (20) (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://api.fonnte.com/send', '2026-06-03 13:44:51', '2026-06-03 13:44:51');
INSERT INTO `wa_logs` VALUES (7, '089666077720', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'failed', NULL, NULL, 'cURL error 60: SSL certificate OpenSSL verify result: unable to get local issuer certificate (20) (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://api.fonnte.com/send', '2026-06-03 13:45:07', '2026-06-03 13:45:07');
INSERT INTO `wa_logs` VALUES (8, '6289666077720', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'failed', NULL, NULL, 'cURL error 60: SSL certificate OpenSSL verify result: unable to get local issuer certificate (20) (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://api.fonnte.com/send', '2026-06-03 13:45:39', '2026-06-03 13:45:39');
INSERT INTO `wa_logs` VALUES (9, '089666077720', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'sent', NULL, NULL, '{\"reason\":\"invalid token\",\"status\":false}', '2026-06-03 13:48:57', '2026-06-03 13:48:57');
INSERT INTO `wa_logs` VALUES (10, '6289666077720', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'sent', NULL, NULL, '{\"reason\":\"invalid token\",\"status\":false}', '2026-06-03 13:51:52', '2026-06-03 13:51:52');
INSERT INTO `wa_logs` VALUES (11, '0895370209724', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'sent', NULL, NULL, '{\"reason\":\"invalid token\",\"status\":false}', '2026-06-03 13:53:10', '2026-06-03 13:53:10');
INSERT INTO `wa_logs` VALUES (12, '62895370209724', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'sent', NULL, NULL, '{\"reason\":\"invalid token\",\"status\":false}', '2026-06-03 13:53:48', '2026-06-03 13:53:48');
INSERT INTO `wa_logs` VALUES (13, '089666077720', 'Halo! Ini adalah pesan uji coba integrasi WhatsApp Gateway Fonnte dari Sistem BK SMK.', 'other', 'sent', NULL, NULL, '{\"detail\":\"success! message in queue\",\"id\":[160275862],\"process\":\"pending\",\"quota\":{\"6289666077720\":{\"details\":\"deduced from total quota\",\"quota\":1000,\"remaining\":999,\"used\":1}},\"requestid\":517613965,\"status\":true,\"target\":[\"6289666077720\"]}', '2026-06-03 14:04:11', '2026-06-03 14:04:11');
INSERT INTO `wa_logs` VALUES (14, '089666077720', '⚠️ *NOTIFIKASI PELANGGARAN*\n\nYth. ortu test,\n\nDengan ini kami informasikan bahwa putra/putri Bapak/Ibu:\n\n👤 Nama: *test*\n📋 NIS: 222222\n🏫 Kelas: X RPL 1\n\nTelah melakukan pelanggaran:\n❌ *Tidak memakai seragam lengkap*\n📅 Tanggal: 03/06/2026\n📉 Poin dikurangi: 5\n📊 Sisa poin: *75*\n\nMohon perhatian dan kerjasamanya.\n\nHormat kami,\n_SMK Negeri 1 Nusantara_', 'violation', 'sent', 5, 'violation', '{\"detail\":\"success! message in queue\",\"id\":[160276003],\"process\":\"pending\",\"quota\":{\"6289666077720\":{\"details\":\"deduced from total quota\",\"quota\":999,\"remaining\":998,\"used\":1}},\"requestid\":517616240,\"status\":true,\"target\":[\"6289666077720\"]}', '2026-06-03 14:05:29', '2026-06-03 14:05:29');
INSERT INTO `wa_logs` VALUES (15, '081300000001', '⚠️ *NOTIFIKASI PELANGGARAN*\n\nYth. Bpk. Pratama,\n\nDengan ini kami informasikan bahwa putra/putri Bapak/Ibu:\n\n👤 Nama: *Andi Pratama*\n📋 NIS: 20250001\n🏫 Kelas: X RPL 1\n\nTelah melakukan pelanggaran:\n❌ *Terlambat masuk sekolah*\n📅 Tanggal: 12/06/2026\n📉 Poin dikurangi: 5\n📊 Sisa poin: *75*\n\nMohon perhatian dan kerjasamanya.\n\nHormat kami,\n_SMK Negeri 1 Nusantara_', 'violation', 'sent', 6, 'violation', '{\"detail\":\"success! message in queue\",\"id\":[161976892],\"process\":\"pending\",\"quota\":{\"6289666077720\":{\"details\":\"deduced from total quota\",\"quota\":998,\"remaining\":997,\"used\":1}},\"requestid\":535381475,\"status\":true,\"target\":[\"6281300000001\"]}', '2026-06-12 12:42:04', '2026-06-12 12:42:04');
INSERT INTO `wa_logs` VALUES (16, '089666077720', '⚠️ *NOTIFIKASI PELANGGARAN*\n\nYth. ortu test,\n\nDengan ini kami informasikan bahwa putra/putri Bapak/Ibu:\n\n👤 Nama: *test*\n📋 NIS: 222222\n🏫 Kelas: X RPL 1\n\nTelah melakukan pelanggaran:\n❌ *Terlambat masuk sekolah*\n📅 Tanggal: 13/06/2026\n📉 Poin dikurangi: 5\n📊 Sisa poin: *70*\n\nMohon perhatian dan kerjasamanya.\n\nHormat kami,\n_SMK Negeri 1 Nusantara_', 'violation', 'sent', 7, 'violation', '{\"detail\":\"success! message in queue\",\"id\":[162027864],\"process\":\"pending\",\"quota\":{\"6289666077720\":{\"details\":\"deduced from total quota\",\"quota\":997,\"remaining\":996,\"used\":1}},\"requestid\":536045728,\"status\":true,\"target\":[\"6289666077720\"]}', '2026-06-13 01:06:10', '2026-06-13 01:06:10');
INSERT INTO `wa_logs` VALUES (17, '089666077720', '⚠️ *NOTIFIKASI PELANGGARAN*\n\nYth. ortu test,\n\nDengan ini kami informasikan bahwa putra/putri Bapak/Ibu:\n\n👤 Nama: *test*\n📋 NIS: 222222\n🏫 Kelas: X RPL 1\n\nTelah melakukan pelanggaran:\n❌ *Tidak mengerjakan tugas*\n📅 Tanggal: 13/06/2026\n📉 Poin dikurangi: 5\n📊 Sisa poin: *65*\n\nMohon perhatian dan kerjasamanya.\n\nHormat kami,\n_SMK Negeri 1 Nusantara_', 'violation', 'sent', 8, 'violation', '{\"detail\":\"success! message in queue\",\"id\":[162072146],\"process\":\"pending\",\"quota\":{\"6289666077720\":{\"details\":\"deduced from total quota\",\"quota\":996,\"remaining\":995,\"used\":1}},\"requestid\":536525698,\"status\":true,\"target\":[\"6289666077720\"]}', '2026-06-13 05:28:03', '2026-06-13 05:28:03');
INSERT INTO `wa_logs` VALUES (18, '089666077720', '⚠️ *NOTIFIKASI PELANGGARAN*\n\nYth. ortu test,\n\nDengan ini kami informasikan bahwa putra/putri Bapak/Ibu:\n\n👤 Nama: *test*\n📋 NIS: 222222\n🏫 Kelas: X RPL 1\n\nTelah melakukan pelanggaran:\n❌ *Tidak memakai seragam lengkap*\n📅 Tanggal: 12/06/2026\n📉 Poin dikurangi: 5\n📊 Sisa poin: *60*\n\nMohon perhatian dan kerjasamanya.\n\nHormat kami,\n_SMK Negeri 1 Nusantara_', 'violation', 'sent', 9, 'violation', '{\"detail\":\"success! message in queue\",\"id\":[162100827],\"process\":\"pending\",\"quota\":{\"6289666077720\":{\"details\":\"deduced from total quota\",\"quota\":995,\"remaining\":994,\"used\":1}},\"requestid\":536778945,\"status\":true,\"target\":[\"6289666077720\"]}', '2026-06-13 08:58:20', '2026-06-13 08:58:20');
INSERT INTO `wa_logs` VALUES (19, '089666077720', '📩 *SURAT PANGGILAN ORANG TUA*\n\nYth. ortu test,\n\nDengan hormat, kami mengundang Bapak/Ibu untuk hadir di sekolah:\n\n📅 Tanggal: *15/06/2026*\n🕐 Pukul: *09:00*\n📍 Tempat: Jl. Pendidikan No. 1, Kota Nusantara\n\nTerkait: gak berangkat sekolah\n\nKehadiran Bapak/Ibu sangat kami harapkan.\n\nHormat kami,\n_SMK Negeri 1 Nusantara_', 'invitation', 'sent', 1, 'parent_letter', '{\"detail\":\"success! message in queue\",\"id\":[162101127],\"process\":\"pending\",\"quota\":{\"6289666077720\":{\"details\":\"deduced from total quota\",\"quota\":994,\"remaining\":993,\"used\":1}},\"requestid\":536781578,\"status\":true,\"target\":[\"6289666077720\"]}', '2026-06-13 09:00:06', '2026-06-13 09:00:06');

SET FOREIGN_KEY_CHECKS = 1;
