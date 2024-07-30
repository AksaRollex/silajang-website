/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 8.0.27 : Database - pro_silajang
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `acuan_metodes` */

DROP TABLE IF EXISTS `acuan_metodes`;

CREATE TABLE `acuan_metodes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acuan_metodes_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `acuan_metodes` */

insert  into `acuan_metodes`(`id`,`uuid`,`nama`,`created_at`,`updated_at`) values 
(1,'39bce234-554e-43a8-b669-1479ee845bb4','Sesaat (Grab Sample)','2023-08-09 08:39:14','2023-08-09 08:39:14');

/*Table structure for table `banners` */

DROP TABLE IF EXISTS `banners`;

CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banners_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `banners` */

insert  into `banners`(`id`,`uuid`,`judul`,`gambar`,`link`,`created_at`,`updated_at`) values 
(1,'225c441b-afb4-4ead-8307-dff7939ea048','Banner 1','/storage/banner/J3Kys8NjdbGOnnaZ0Q4BrAGEuEgetRL7eNC3B3Cb.jpg',NULL,'2023-08-30 15:43:45','2023-08-30 15:43:45'),
(2,'8dc97fd8-6c7c-4a9a-b720-b2f834591f62','Banner 2','/storage/banner/oCKtgGTIcVSNZeWstrCJHlHMwHS6dsZHW73DtTBG.jpg',NULL,'2023-08-30 15:44:15','2023-08-30 15:44:15'),
(3,'72dd9ef2-5e6e-442c-987e-ce73d7f7f0a8','Banner 3','/storage/banner/1foanDLoiZS73BjCvHTFY47ElofsQkbp8RPuLWMR.jpg',NULL,'2023-08-30 15:46:05','2023-08-30 15:46:05');

/*Table structure for table `detail_users` */

DROP TABLE IF EXISTS `detail_users`;

CREATE TABLE `detail_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `tanda_tangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instansi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pimpinan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pj_mutu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan_id` bigint unsigned DEFAULT NULL,
  `kelurahan_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `detail_users_uuid_unique` (`uuid`),
  KEY `detail_users_user_id_foreign` (`user_id`),
  KEY `detail_users_kecamatan_id_foreign` (`kecamatan_id`),
  KEY `detail_users_kelurahan_id_foreign` (`kelurahan_id`),
  CONSTRAINT `detail_users_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatans` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `detail_users_kelurahan_id_foreign` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahans` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `detail_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `detail_users` */

insert  into `detail_users`(`id`,`uuid`,`user_id`,`tanda_tangan`,`instansi`,`alamat`,`pimpinan`,`pj_mutu`,`telepon`,`fax`,`email`,`jenis_kegiatan`,`lat`,`long`,`kecamatan_id`,`kelurahan_id`,`created_at`,`updated_at`) values 
(1,'44512102-875f-4b4c-a7fa-64eac0a995dc',10,NULL,'CV. MAJU JAYA COBA ELEKTRIK','DK. SUMBER SARI II SARI REJO JOMBANG','AANG KURNIAWAN','FAHRUR ROZI','085489888878','02888','dfsdsad@email.com','fsdfsdfdsfds','-7.2748725','112.65226249999999',4,48,'2023-08-21 15:52:38','2023-09-06 06:29:04'),
(2,'96f98217-2a36-43a3-b280-f75946c1cf4f',13,NULL,'cv mti','surabaya','fahrur','rozi','089657147966',NULL,'mcflyons@gmail.com','softwhare','-7.2750211','112.651801',3,32,'2023-09-08 11:25:03','2023-09-20 11:57:28'),
(3,'04b1ed54-dd16-4a94-bd43-4d86ff7d0d69',2,'/storage/tanda_tangan/w3YiIUVk82rySzQi0rIgOSmMe4uHfE84pRQM6rII.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'-7.5468338','112.2275157',NULL,NULL,'2023-09-14 13:56:43','2023-09-14 13:58:17'),
(4,'81a30797-6462-486c-afe3-bf3cbbd12253',15,NULL,'CV. MTI','Jl. Surabaya','Fahrur Rozi','Fahrur Rozi','08977266144',NULL,'admin@mcflyon.co.id','Keramik','-7.5379109','112.2405733',1,2,'2023-09-22 10:05:42','2023-09-22 10:05:42');

/*Table structure for table `email_verifications` */

DROP TABLE IF EXISTS `email_verifications`;

CREATE TABLE `email_verifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_verifications_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `email_verifications` */

insert  into `email_verifications`(`id`,`email`,`otp`,`otp_expired_at`,`created_at`,`updated_at`) values 
(3,'gengkhan292@gmail.com','029316','2023-09-07 15:44:00','2023-09-07 13:49:56','2023-09-07 15:42:00'),
(4,'aang22@gmail.com','081296','2023-09-07 15:30:37','2023-09-07 15:27:18','2023-09-07 15:28:37'),
(5,'kurniawanaang59@gmail.com','459503','2023-09-07 15:41:32','2023-09-07 15:33:26','2023-09-07 15:39:32');

/*Table structure for table `f_a_q_s` */

DROP TABLE IF EXISTS `f_a_q_s`;

CREATE TABLE `f_a_q_s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pertanyaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pertanyaan_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jawaban` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jawaban_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `f_a_q_s_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `f_a_q_s` */

insert  into `f_a_q_s`(`id`,`uuid`,`pertanyaan`,`pertanyaan_en`,`jawaban`,`jawaban_en`,`gambar`,`created_at`,`updated_at`) values 
(2,'af487327-4da4-49ca-aee3-6ba951399d7e','Daftar Aplikasi SI-LAJANG','Registration Application SI-LAJANG','Fitur \"DAFTAR / REGISTER\" digunakan untuk mendapatkan akun login. Isikan nama Perusahaan , No Wahatsapp dan alamat email aktif dan password login (bukan password email ya). Dalam beberapa detik Anda akan mendapatkan email resmi dari Aplikasi SI-LAJANG  UPT. Laboratorium Dinas Lingkungan Hidup Kab. Jombang. Klik tombol \"Verifikasi Email\" untuk kembali ke halaman login. dan anda  Juga akan Mendapatkan OTP di Whastapp Anda untuk Memverifikasi No. Whatsapp anda.','The \"DAFTAR/ REGISTER\" feature is used to get a login account. Fill in the company name, Wahatsapp number and active email address and login password (not an email password, OK). In a few seconds you will get an official email from the SI-LAJANG UPT Application. District Environmental Service Laboratory. Jombang. Click the \"Verify Email\" button to return to the login page. and you will also get an OTP on your Whastapp to verify no. Whatsapp you.',NULL,'2023-09-06 08:34:50','2023-09-06 08:34:50'),
(3,'6a108e2d-db10-4382-8f03-2c80f870b779','LOGIN','LOGIN','Untuk Login aplikasi SI-LAJANG dapat mengunakan Login E-Mail yang sudah di daftarkan atau dapat juga mengunakan OTP (One Time Password) dengan memasukan No. Whatsapp yang sudah di daftakan  nanti akan mendaptkan OTP Ke No. Whatsapp tersebut.','To log in to the SI-LAJANG application, you can use the registered E-Mail Login or you can also use OTP (One Time Password) by entering No. Whatsapp that has been registered will later get an OTP to No. Whatsapp.',NULL,'2023-09-06 08:37:46','2023-09-06 08:37:46');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `foto_titik_permohonans` */

DROP TABLE IF EXISTS `foto_titik_permohonans`;

CREATE TABLE `foto_titik_permohonans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titik_permohonan_id` bigint unsigned NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `foto_titik_permohonans_uuid_unique` (`uuid`),
  KEY `foto_titik_permohonans_titik_permohonan_id_foreign` (`titik_permohonan_id`),
  CONSTRAINT `foto_titik_permohonans_titik_permohonan_id_foreign` FOREIGN KEY (`titik_permohonan_id`) REFERENCES `titik_permohonans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `foto_titik_permohonans` */

insert  into `foto_titik_permohonans`(`id`,`uuid`,`titik_permohonan_id`,`foto`,`keterangan`,`created_at`,`updated_at`) values 
(4,'097919d7-7a0a-4921-97e3-8e6baeac7973',13,'/storage/foto_lapangan/ocu8Dw5c6Sox9favk5pL1fKXruLr78GPnSIwggSR.png',NULL,'2023-09-22 09:22:29','2023-09-22 09:22:29');

/*Table structure for table `golongans` */

DROP TABLE IF EXISTS `golongans`;

CREATE TABLE `golongans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `golongans_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `golongans` */

insert  into `golongans`(`id`,`uuid`,`nama`,`created_at`,`updated_at`) values 
(1,'ae9b7258-be82-427b-a34c-5a0f2b786ff2','Customer','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(2,'7187164b-8cb4-46fc-a41e-185267bcdd00','Dinas Internal','2023-08-09 08:39:13','2023-08-09 08:39:13');

/*Table structure for table `jasa_pengambilans` */

DROP TABLE IF EXISTS `jasa_pengambilans`;

CREATE TABLE `jasa_pengambilans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wilayah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jasa_pengambilans_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jasa_pengambilans` */

insert  into `jasa_pengambilans`(`id`,`uuid`,`wilayah`,`harga`,`created_at`,`updated_at`) values 
(1,'8ceebaea-d643-4fb9-ac97-10c445022407','Jombang',0,'2023-09-04 08:34:39','2023-09-04 08:34:39');

/*Table structure for table `jenis_parameters` */

DROP TABLE IF EXISTS `jenis_parameters`;

CREATE TABLE `jenis_parameters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenis_parameters_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jenis_parameters` */

insert  into `jenis_parameters`(`id`,`uuid`,`nama`,`created_at`,`updated_at`) values 
(1,'fe3299d3-cd5a-4001-88fc-d3328fd868af','Fisika','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(2,'31c7510b-b579-4daa-9066-b90213225a4d','Kimia','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(3,'5ee4cb32-1488-47e5-bc3a-0b367c53aa42','Mikrobiologi','2023-08-09 08:39:14','2023-08-09 08:39:14');

/*Table structure for table `jenis_sampels` */

DROP TABLE IF EXISTS `jenis_sampels`;

CREATE TABLE `jenis_sampels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenis_sampels_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jenis_sampels` */

insert  into `jenis_sampels`(`id`,`uuid`,`nama`,`kode`,`created_at`,`updated_at`) values 
(1,'e8d145c7-9d92-41b5-bdf6-59b5dadca9b5','Air Limbah','AL','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(2,'9a1cdcdb-5c32-4534-97a7-6a8ca93900d1','Air Sungai','AS','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(3,'bfb5cd7b-c24e-4a81-9896-2055fffe988f','Air Higienis','AH','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(4,'99e58480-e64b-47bf-8140-99e05f172401','Kebisingan','KB','2023-08-09 08:39:14','2023-08-09 08:39:14');

/*Table structure for table `jenis_wadahs` */

DROP TABLE IF EXISTS `jenis_wadahs`;

CREATE TABLE `jenis_wadahs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenis_wadahs_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jenis_wadahs` */

insert  into `jenis_wadahs`(`id`,`uuid`,`nama`,`keterangan`,`created_at`,`updated_at`) values 
(1,'ca82d8a2-b499-472a-9bf4-d9645fb9cf89','Plastik','500 mL','2023-08-09 08:39:14','2023-08-31 14:33:13'),
(2,'7c2951d0-487e-4000-b4f1-593557307d54','Gelas',NULL,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(3,'b21df836-174e-4cd6-8a87-7a4dcc85d8b9','Plastik','1000 mL','2023-08-31 14:33:32','2023-08-31 14:33:32'),
(4,'63d90b79-88da-4b7f-9b21-4ec92651f57c','Plastik','2500 mL','2023-08-31 14:33:58','2023-08-31 14:33:58'),
(5,'fbc5f290-8f6e-4c46-ba7b-96d7999c3081','Botol Terang','100 mL','2023-08-31 14:35:40','2023-08-31 14:35:40'),
(6,'b03a412c-994f-4a77-afd7-8eebfed79e42','Botol Terang','500 mL','2023-08-31 14:35:58','2023-08-31 14:35:58'),
(7,'9535ed8c-725b-4155-a868-f5d0914655bc','Botol Gelap','1000 mL','2023-08-31 14:36:14','2023-08-31 14:36:14'),
(8,'16789958-8944-49ef-b042-44709db28a6c','Botol Gelap','200 mL','2023-08-31 14:36:27','2023-08-31 14:36:27');

/*Table structure for table `kecamatans` */

DROP TABLE IF EXISTS `kecamatans`;

CREATE TABLE `kecamatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kecamatans_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kecamatans` */

insert  into `kecamatans`(`id`,`uuid`,`nama`,`created_at`,`updated_at`) values 
(1,'f922cbde-185d-4e6c-8b71-856af7e87148','Perak','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(2,'9ab1ebee-04ea-4c9e-9b42-ce2f888192a6','Gudo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(3,'21cb2dc0-b1c1-47f5-b043-c66062c6993d','Ngoro','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(4,'d49f437e-e7ca-49df-8ecf-a0023dfd40b3','Bareng','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(5,'b7299b2c-0852-433e-822d-c9380a430846','Wonosalam','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(6,'4818a150-b7ae-4d82-991a-bf3f13a0fb0d','Mojoagung','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(7,'70ea09d7-f4a9-4784-9a46-6934e26feb20','Mojowarno','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(8,'aa59480b-8aa6-45b6-a74e-1a4fe6121cff','Diwek','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(9,'e4f01ccb-ba71-4332-b609-e97caf393213','Jombang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(10,'585ca261-e32e-46be-b5f1-594dff5c77f7','Peterongan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(11,'2679bcae-b678-42b5-89e5-24222c035e9b','Sumobito','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(12,'0d3d1703-a3c0-43fd-8ff8-d8a1fc24462f','Kesamben','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(13,'a3c3637d-0d04-4b25-ada2-791d08747b1a','Tembelang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(14,'93b19abe-c18d-435b-933c-0f172a820c31','Ploso','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(15,'aaa47b7e-43f4-4b32-a295-a7fdf014afe4','Plandaan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(16,'2ac84f36-c6d0-4348-810e-c739a10908ea','Kabuh','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(17,'4fcf1c6d-ad13-447e-8d00-84ba691a511c','Kudu','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(18,'589d71b4-5fba-4ced-bef7-d17ce4a1ab6d','Bandarkedungmulyo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(19,'bb73156e-41c5-4805-9f6f-dd1526f2f770','Jogoroto','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(20,'a3d60f58-e6f2-422a-a8f4-f429162ae11a','Megaluh','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(21,'c3807950-e687-40a6-a5e2-fb0d8bb597a6','Ngusikan','2023-08-09 08:39:12','2023-08-09 08:39:12');

/*Table structure for table `kelurahans` */

DROP TABLE IF EXISTS `kelurahans`;

CREATE TABLE `kelurahans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan_id` bigint unsigned NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelurahans_uuid_unique` (`uuid`),
  KEY `kelurahans_kecamatan_id_foreign` (`kecamatan_id`),
  CONSTRAINT `kelurahans_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=307 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kelurahans` */

insert  into `kelurahans`(`id`,`uuid`,`kecamatan_id`,`nama`,`created_at`,`updated_at`) values 
(1,'bc16795e-a725-4fa8-b919-4050eeeb6880',1,'Jatiganggong','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(2,'8265548e-58f2-4fb3-90e8-880da44f959f',1,'Kepuhkajang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(3,'11ee1d21-3c6f-4676-ba5f-e1a5facad1c3',1,'Sumberagung','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(4,'510becec-7e8d-438f-b7e7-036903bce705',1,'Pagerwojo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(5,'666df94d-9ed6-4e1e-a96b-5820272a7010',1,'Perak','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(6,'3608ecf7-4f87-4690-b6af-a21786716065',1,'Sembung','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(7,'76d18cc8-093a-476f-ae7b-d2aaf06c5cdb',1,'Glagahan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(8,'909dad86-e3da-4f7c-a2b4-86066f42ee03',1,'Kalang Semanding','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(9,'7c6c0348-977f-4712-be64-5cb458080712',1,'Gadingmangu','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(10,'174527bf-8cad-46a7-811f-298c18b99930',1,'Plosogenuk','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(11,'fdc49965-0859-48c8-ad15-7734d17e6858',1,'Sukorejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(12,'846ede14-93c0-4d4b-9e09-ebdce947c751',1,'Temuwulan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(13,'a08881ec-41da-4477-8731-9e202927043d',1,'Cangkringrandu','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(14,'d97816fd-9172-4b89-9ba5-06adb1a365f8',2,'Pucangro','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(15,'0b888094-d735-48d9-abaa-45173b172480',2,'Kedungturi','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(16,'8fcdc727-e44d-491d-afe0-0647890e91d1',2,'Japanan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(17,'1669f8a8-8a7d-4589-a4ce-24a36c292163',2,'Blimbing','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(18,'5d48bad5-10e5-4497-8aad-c210b37ced9c',2,'Mentaos','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(19,'a581627d-72ca-4090-9b66-0d2eed0a65f6',2,'Sukoiber','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(20,'42fb856f-04a0-49cc-9227-d9a249329fe4',2,'Sukopinggir','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(21,'762e951e-6a61-46fe-b8fa-9b4dd132646e',2,'Bugasurkedaleman','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(22,'b2c5c2fc-6562-47fb-bf50-893d40540a44',2,'Gudo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(23,'d3a1e5bf-fb2d-4c55-8d27-5c2bca1a3cab',2,'Pesanggrahan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(24,'7be84866-38ab-498d-b4df-4cb990f7540e',2,'Wangkalkepuh','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(25,'ae0c3ab1-a4c4-4735-ae78-336b3e2cd0f2',2,'Krembangan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(26,'51e36a8c-7f00-4605-aa8c-b541fd95bffb',2,'Sepanyul','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(27,'3ef3cbbf-d858-47b3-aa80-18f1ef6a9d54',2,'Godong','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(28,'22de7e39-4be0-4e3d-ae1d-4555f1adf245',2,'Mejoyolosari','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(29,'0035d731-1d73-4836-9175-6bc85047c496',2,'Plumbongambang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(30,'b8381f19-adb0-4616-b776-d15ce8e286a8',2,'Gempollegundi','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(31,'43a5cc38-5862-4914-8b4f-1bd4f86783f0',2,'Tanggungan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(32,'305befd1-b64a-4689-ad29-fe4e5fbb17e4',3,'Jombok','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(33,'8d3f338b-94fc-420f-9d30-ba5e5d6e564d',3,'Genukwatu','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(34,'dd63c41f-3481-48f0-bb7d-bc42998bf3ae',3,'Rejoagung','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(35,'1c1b81c3-784a-4150-8f28-0c95085c358d',3,'Kauman','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(36,'65157079-c9ca-44bf-9faf-da606d0653f4',3,'Ngoro','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(37,'157cef4f-2788-461a-a7bb-1854ad21039e',3,'Badang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(38,'608bb30a-0a0d-4d2d-8188-d9c3af765fa6',3,'Pulorejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(39,'23e2609b-c1fa-48d2-9197-58a32051a35f',3,'Banyuarang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(40,'baf387f6-2f1f-44bd-8f19-d662d18671dd',3,'Sidowarek','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(41,'c34342a3-6925-4dca-acca-62054dbe6571',3,'Gajah','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(42,'80ffaaf6-71ac-4f85-bc40-b96320fbf74d',3,'Kesamben','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(43,'7b192df4-d4e5-43d4-81ee-0c80157fecb1',3,'Kertorejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(44,'d6b62c53-ffc5-416b-903d-475ebe679efb',3,'Sugihwaras','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(45,'24874cdd-6358-4e1e-ae0a-140811ca7de0',4,'Kebondalem','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(46,'35a3bfc3-9dbc-40a1-8e19-90aa93285cc1',4,'Mundusewu','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(47,'e7a65e0c-23a4-4f98-b5aa-1f0d1bb36ba1',4,'Pakel','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(48,'9c810ec8-054d-40ed-be2a-81b9abf960b5',4,'Karangan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(49,'a4ef3972-b83a-45b1-bed6-98ae5655c3f6',4,'Ngampungan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(50,'cc87afb8-049b-4965-926b-bafdd00b02d9',4,'Jenisgelaran','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(51,'0c3e5048-2bab-4a73-b266-b08ac1a6f2c0',4,'Bareng','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(52,'6a276735-57ec-4ef6-a451-01b65159619d',4,'Tebel','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(53,'a13e70b2-dfa2-4f98-a4c4-c5271eb99e1e',4,'Mojotengah','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(54,'2cc0d313-24e6-4aec-8b7f-512f7728f2cc',4,'Banjaragung','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(55,'d2ad06af-078a-4ed2-83b8-76b252a80507',4,'Nglebak','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(56,'b18ff0c7-d826-4e54-8857-87910855635e',4,'Ngrimbi','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(57,'6c194344-b2db-4ad7-8718-27cf26b2b0ae',4,'Pulosari','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(58,'4f4ace2a-7810-4e8e-9fbd-b28bd4655988',5,'Galengdowo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(59,'4ce83c8b-ffb8-43ce-9db5-7b7327eaf3f8',5,'Wonomerto','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(60,'9c4b184c-cce8-4a64-a6fd-9e369dc5edee',5,'Jarak','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(61,'ca0da804-0700-4b49-af02-d55fa4bb4f8e',5,'Sambirejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(62,'10ff804f-e45d-431c-8482-df8834795779',5,'Wonosalam','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(63,'d26aa0c6-4041-4a15-bdfe-8662d5740806',5,'Carangwulung','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(64,'61f6a0cf-9913-4055-855e-3d917c196881',5,'Wonokerto','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(65,'86a877ba-4092-4aea-89c3-1055bc992f64',5,'Sumberjo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(66,'4de0fc52-a8c9-4609-b60e-e3ab156bf483',5,'Panglungan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(67,'bf0a2efd-b0c6-4448-a159-858dd2b2a843',6,'Kedunglumpang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(68,'20e19ebb-da28-4100-99d5-88d3e14a85c1',6,'Dukuhmojo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(69,'7a609fc9-dc1b-4337-9812-a1f692332421',6,'Karangwinongan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(70,'99200efa-4d35-42ac-8803-21bc54aa3c00',6,'Kademangan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(71,'a7328b8f-5e46-4b71-98d4-ad38857f006a',6,'Janti','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(72,'bf55cfa7-ef88-4529-8de3-9d35bccbddc7',6,'Tejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(73,'a1a85cfe-b9b0-44f5-abf2-c23ef4ae3dc6',6,'Gambiran','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(74,'71bc804c-6d9f-4be5-8451-95f1d6219864',6,'Kauman','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(75,'95b2aae2-13d6-49f1-a8f4-7b6e08cb348f',6,'Mojotrisno','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(76,'7d54efbe-7829-4dd3-94e4-93dca668a94c',6,'Tanggalrejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(77,'302d3f61-2e87-4c5b-8b51-59ae592b2a6e',6,'Dukuhdimoro','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(78,'173daf12-31f6-47d2-8f3c-b4f24cc1e405',6,'Miagan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(79,'b64a1a29-f66d-48bd-a884-0877f3fe0e00',6,'Mancilan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(80,'88df35ab-ba94-4fdd-8c67-5fa76920f521',6,'Betek','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(81,'50956c18-49d3-4d7e-b444-9ba01a1ccbbf',6,'Karobelah','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(82,'9aa4c6fd-e0e7-4e43-ba9b-2cf8554e8ff8',6,'Murukan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(83,'36b3cf14-f99f-4059-beee-986212c4ae7b',6,'Johowinong','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(84,'eb1827d4-d1d6-42d3-a922-4822d3d0af4a',6,'Seketi','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(85,'04e71151-293b-4191-8996-ebfcbaf29f57',7,'Kedungpari','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(86,'ab752529-24ce-4b1a-994b-76d49c0cbd48',7,'Karanglo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(87,'c413ba0a-9419-4588-bbf4-6445ff2e269f',7,'Latsari','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(88,'ffdbc5ef-a1af-4a18-b7e0-62fd8befafe3',7,'Mojowarno','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(89,'b6635f30-8639-471d-91ff-ce97be20cce5',7,'Penggaron','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(90,'45f7dc1e-45d1-4170-ae7a-ac1ca8ef6a2f',7,'Mojoduwur','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(91,'b53215d0-66df-4644-bdcb-e24acad81c81',7,'Mojowangi','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(92,'ca477f20-6f36-48d9-b735-521329ca9e52',7,'Gondek','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(93,'45552b41-4d39-4904-b5dd-05bb03e58dcd',7,'Gedangan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(94,'04d81809-3b9c-45e7-a7ee-0d612763522e',7,'Mojojejer','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(95,'5b74313a-07c5-4d4a-8269-c9b98ee2dc70',7,'Japanan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(96,'5a2fd6f7-38dc-48db-ba98-9ec0d90b5db9',7,'Menganto','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(97,'ad0af929-2e7b-45df-bc9b-a3bf069584b7',7,'Grobogan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(98,'3761a4e4-461f-4e5c-8aea-34e3538b6eed',7,'Rejoslamet','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(99,'e6f5500f-51a0-4481-8a25-c6444755c5bb',7,'Selorejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(100,'98e10d36-0f06-4478-a6be-f36e04c82b3e',7,'Sidokerto','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(101,'3186321b-5745-4b72-939b-bacce0601c82',7,'Sukomulyo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(102,'7cda3b45-4124-494a-89d5-ede5e47c45ee',7,'Catakgayam','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(103,'b24fbf14-e9c8-4910-86f4-b2d738467842',7,'Wringinpitu','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(104,'bf85f4f6-1190-4085-b9eb-cd09b8d2a347',8,'Kayangan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(105,'db27a89e-4484-45cf-ab0f-4db367606695',8,'Puton','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(106,'40df55aa-0c13-4260-a080-b02bb5b0573b',8,'Bendet','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(107,'518b0473-4f04-4894-8c62-af062481209f',8,'Bulurejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(108,'91e85b51-9482-4873-adc3-2408d3fb1332',8,'Grogol','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(109,'24491a2e-fb9b-42c3-966b-4a0a2c4666b8',8,'Jatirejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(110,'08cb9532-e539-456a-921e-5bdc50b3af1e',8,'Cukir','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(111,'f77ea1b0-3c53-4acc-aed6-2a9d129e2a48',8,'Kwaron','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(112,'27d18a82-8515-4f62-87eb-cea39fd9d04e',8,'Watugaluh','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(113,'f7defb1a-063b-4622-8941-3b9c725e6a94',8,'Pundong','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(114,'4e6c3440-b695-430c-8940-b87ebb6c7cbc',8,'Diwek','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(115,'79a0f14d-eae6-4ed7-b0c2-86b081d99904',8,'Bandung','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(116,'e1f3c155-0707-49c2-bcf2-6afa3385b88f',8,'Kedawong','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(117,'2e338772-4ebd-4613-84d0-5d588cc88779',8,'Ngudirejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(118,'5ce29f51-73d2-4009-96db-b360f71302e4',8,'Ceweng','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(119,'72353e6f-0adb-4dab-8634-58ad61b96251',8,'Balongbesuk','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(120,'8db34fe2-1613-4bb3-a8a2-2f97308fcdb2',8,'Pandanwangi','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(121,'8031a0b1-8e03-45ef-a100-1492844da01e',8,'Brambang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(122,'67a97da1-396f-412b-a205-3fa811416831',8,'Jatipelem','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(123,'638124aa-f03c-42cb-b37b-19c5a1f614a5',8,'Keras','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(124,'e344d89e-f8ff-4034-9128-a94fb7f1e503',9,'Jombatan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(125,'ff4e1808-1fac-49a0-9d3c-0c6d1319544e',9,'Kaliwungu','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(126,'c28b9db3-dc5c-4e03-aa18-139e5869ce9b',9,'Jelakombo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(127,'733075d1-5cbc-4bea-8051-4adcf89fa5c1',9,'Kepanjen','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(128,'bbb9f308-4948-42e6-8329-dec7988c4405',9,'Mojongapit','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(129,'f94e6f19-7574-435d-addb-4df11b2cee20',9,'Plandi','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(130,'d412194d-66ec-42d0-a472-13e504bfb434',9,'Kepatihan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(131,'61cd1596-4e97-4f8e-9d95-2e0758f898da',9,'Pulolor','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(132,'9bf6f009-8f94-4a97-950d-e1e1fd36cdcf',9,'Sengon','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(133,'bff43941-b22b-47ba-a340-b934ed8df9b1',9,'Tunggorono','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(134,'5cf0ef4a-1f0c-49ff-9e1e-f27a340a2bed',9,'Denanyar','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(135,'caa3e930-bd66-48d9-8a56-b9f11ccb34d1',9,'Jombang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(136,'fb342929-3b4a-4e24-a75e-5a308455bc58',9,'Candimulyo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(137,'4e2b5a16-920c-49b6-8c84-786113b52af8',9,'Tambakrejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(138,'ff162432-52af-49c5-bceb-6ad04094065b',9,'Banjardowo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(139,'f6fb3c54-ecff-42a2-87fa-868930b7f9b1',9,'Sambongdukuh','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(140,'8d89ad37-74c8-4e9e-9801-4ac9db152d71',9,'Dapurkejambon','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(141,'77f17235-7562-4884-84a0-7f596a266e63',9,'Jabon','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(142,'ea3eb96e-f868-4203-a90d-19cf179a1fb5',9,'Plosogeneng','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(143,'66f6c181-2d13-4560-b543-90cb8ab31f17',9,'Sumberjo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(144,'ff612578-a844-4672-b03f-f160860e3eba',10,'Peterongan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(145,'46638b93-0bfb-4f7b-9b2c-7fa673ca6ffa',10,'Keplaksari','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(146,'85304525-b27a-422c-9f1d-5b542987b480',10,'Kepuhkembeng','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(147,'8a776671-a162-4700-a118-f118d5759b2e',10,'Mancar','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(148,'39af9e22-8a9f-4231-a22b-fff503389d30',10,'Tugusumberjo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(149,'0c4c7e14-3635-40d1-b4cb-44f5336047bf',10,'Morosunggingan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(150,'6f36a7b6-e979-4f7b-83a1-00eb8b80ee41',10,'Kebontemu','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(151,'96c1bf3b-b554-4e0b-92be-b78b77f8a22c',10,'Dukuhklopo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(152,'3be00673-dd42-4f4a-a0ab-fc78223ee19f',10,'Tanjunggunung','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(153,'a3d3a4ae-7d4e-43a8-a6ba-723f16ecffb2',10,'Bongkot','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(154,'84c38726-a09a-40ca-adda-8dea8d4eca55',10,'Senden','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(155,'bf031adb-d455-4647-99ef-b09476e6470b',10,'Ngrandulor','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(156,'1a1fbd86-f693-44d5-b4d6-c6bd8147c2d9',10,'Tengaran','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(157,'8bbf6604-a5fc-4f57-94f9-7c8b3b793e21',10,'Sumberagung','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(158,'9dde895f-3313-45ac-bdad-14849338b793',11,'Plosokerep','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(159,'bf3ff2a2-9a31-425f-97ae-6eb54d9f36d5',11,'Jogoloyo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(160,'228d090c-6e1d-4083-897e-ab175d479a6d',11,'Palrejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(161,'5357cd75-8a40-4422-ac13-27b50f691208',11,'Plemahan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(162,'d20b9b87-931e-4154-bfaa-aae45de45193',11,'Brudu','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(163,'ec547415-8a7f-4083-8662-f27b818e47d1',11,'Badas','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(164,'8b0d3712-846b-49d3-badf-e4f5f3572989',11,'Nglele','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(165,'a7c118b3-564c-4693-ac0d-daf5890584b3',11,'Trawasan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(166,'f3bcaf94-7a91-4490-be62-a9bdf270df19',11,'Sebani','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(167,'af05f667-b190-4ee3-afa2-8aa137a67c78',11,'Mlaras','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(168,'4be0b808-2c3e-405b-bfa0-acc2578ca779',11,'Segodorejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(169,'3ff63d2e-2d19-47ae-b69e-bc6174c69737',11,'Kedung Papar','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(170,'638450f0-bd73-4857-b2db-5d6ead5569b4',11,'Sumobito','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(171,'5abc9c69-370f-47f5-8590-9a2296c09b1e',11,'Curahmalang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(172,'6d9591e5-7024-4fae-b443-44c6bc3f82e7',11,'Budug Sidorejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(173,'d5153fd7-2c5c-4d93-95a9-c7dd5599ff4b',11,'Kendalsari','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(174,'24a80e6f-0180-4926-8658-e3bf411463c1',11,'Talunkidul','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(175,'55f27d9d-f2aa-40a7-9726-6bbf924595c2',11,'Madiopuro','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(176,'f73d0d59-255c-43c4-8c8a-74981794fc99',11,'Bakalan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(177,'e483546f-bbef-40da-836b-ceadc23b4f2e',11,'Gedangan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(178,'58cdda1b-4bd2-4632-a5d8-d5d4e343f0f1',11,'Menturo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(179,'0400d557-e62f-47a5-ae63-c37a64e7b71a',12,'Kedungbetik','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(180,'7aee53d8-c052-4fba-9459-4724512782a5',12,'Kedungmlati','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(181,'7acefd85-1840-4658-a012-e623d24bec22',12,'Watudakon','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(182,'14be9ae9-fd88-4033-97c0-23d0b648ec12',12,'Carangrejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(183,'9499ed36-c603-4719-92ce-5674ede75715',12,'Jombok','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(184,'4bd5edf8-0f2b-4683-92bc-1619c146156b',12,'Blimbing','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(185,'257283fc-56e5-4694-981b-2d20e32acb84',12,'Wuluh','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(186,'abd57398-3dd7-4506-a712-70bcb1e831d2',12,'Pojokrejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(187,'ae36b195-8438-4acb-8b50-aa41eef70341',12,'Kesamben','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(188,'223f99bd-d0b7-4a1f-871e-3c91bbb8ee13',12,'Podoroto','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(189,'7d22bc22-cb0d-4648-b9b2-1b238697eae5',12,'Jombatan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(190,'f4c68365-15e0-40a3-ac0b-8e068763e067',12,'Pojokkulon','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(191,'ef993a37-b250-4149-b55c-e9699d13c435',12,'Gumulan','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(192,'bb0e89d1-3e44-4808-aae9-a104986ccb5a',12,'Jatiduwur','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(193,'cce98e21-a476-4ce2-846b-05c0198a4e19',13,'Mojokrapak','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(194,'aad12272-a888-4577-979f-a96e7e18b18b',13,'Pesantren','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(195,'4a02c804-7d26-492b-9b1f-23cf04f04728',13,'Tampingmojo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(196,'bd3c5a21-0aa3-4c0a-b84e-34b5c7f53963',13,'Kalikejambon','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(197,'ebcc7577-d24f-443b-afc6-5f85713b8bf8',13,'Kedunglosari','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(198,'8b010289-e050-4dfc-980f-8e5a183c2571',13,'Kedungotok','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(199,'7e2ab204-4bd9-4278-8f86-f6e367c27add',13,'Tembelang','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(200,'be235fe8-9bdf-4078-a6c1-5ae63ede760e',13,'Sentul','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(201,'a00e1430-a5f1-4475-a872-832a343be121',13,'Gabusbanaran','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(202,'316276b9-e810-4ac0-9168-ca1a0aee6984',13,'Pulorejo','2023-08-09 08:39:12','2023-08-09 08:39:12'),
(203,'3aaf3d91-c74a-48c7-a731-d62b5c160f70',13,'Rejosopinggir','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(204,'04a43e94-4251-4f70-913d-eefa5b09a06c',13,'Jatiwates','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(205,'f1dc611f-076a-4069-a0dd-6114be6d4ca4',13,'Kepuhdoko','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(206,'2cb4d476-6a8d-4c7e-8e05-a829ce26b6ff',13,'Pulogedang','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(207,'7b01b1e8-4a88-4081-b1f2-a9294cf0569b',13,'Bedahlawak','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(208,'5d7f510e-03d5-4e2c-8dbf-5fd267106609',14,'Tanggungkramat','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(209,'a3dcfb0f-72a9-4dcc-9f9d-a06009591582',14,'Rejoagung','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(210,'0d6659ff-ee56-4319-a96a-a9565fcd3574',14,'Losari','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(211,'db94fc99-3ab5-497d-8417-78cbae7de1a0',14,'Ploso','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(212,'fbfd37fd-70b2-42e2-810b-ac5a5b33197c',14,'Jatigedong','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(213,'f2ca3c49-dffc-4125-bc01-efc471ca2f3f',14,'Daditunggal','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(214,'ed45d9eb-958b-4ee9-9f5a-0ec58437f9b7',14,'Kedungombo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(215,'6e28a84f-a95a-4851-a79e-9a540c5174cc',14,'Jatibanjar','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(216,'e68b1522-438e-4e71-a0bc-11b75d32ba91',14,'Pagertanjung','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(217,'fa59d1f7-a6c4-4bc0-9b7b-a5bdd70f814a',14,'Pandanblole','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(218,'c06b894a-5b58-4b8a-b8a5-a3dd3de01a0e',14,'Kedungdowo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(219,'81567dc4-238c-48a0-9a89-1ada0dcc6369',14,'Kebonagung','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(220,'c09a2bab-18db-42d4-878c-5ff7f2905eb9',14,'Bawangan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(221,'a4217282-c573-4cdc-96cc-ba9d2a94bbd3',15,'Klitih','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(222,'0483534a-f955-417c-a5d8-9432f0da5f89',15,'Plabuhan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(223,'76acf98a-29a8-4757-999a-dcdbe5fab67d',15,'Kampungbaru','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(224,'db7f4c3e-55cf-4982-bf8d-ff36132544de',15,'Gebangbunder','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(225,'e1c76364-f9ea-4c0f-8bc1-a6054dd5b51c',15,'Jatimlerek','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(226,'839aab70-0053-4c84-aa87-8fa74d6c0cd7',15,'Karangmojo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(227,'2a19cb6e-19de-4ce8-9179-4562451db331',15,'Plandaan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(228,'9a0ebacd-02b4-4aac-b301-4630dbc2b1a5',15,'Bangsri','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(229,'d7c54d67-8e89-4e46-a00b-1608b173f8ff',15,'Purisemanding','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(230,'edc7a1f3-432a-4889-850f-c24dfe991480',15,'Tondowulan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(231,'b6e776e9-1187-4fbd-9684-6bcc6a25b111',15,'Darurejo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(232,'b1cd8cb1-8263-450b-a8d3-5f4b4f1851c4',15,'Sumberjo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(233,'6d2b09be-ef18-482b-b4e9-27c8dc8eaa54',15,'Jiporapah','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(234,'44fa137e-ea67-4f16-b1fc-24531ec52749',16,'Marmoyo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(235,'a15335f3-84b2-4e81-82ca-79f2fb330403',16,'Tanjungwadung','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(236,'aedee335-3ce1-47c1-8735-9a8cdceac307',16,'Mangunan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(237,'ea06fb90-a6f5-479e-80f3-55aa2a2fd7e0',16,'Kabuh','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(238,'97aca549-2308-400f-ba3e-948e9aec85cb',16,'Kedungjati','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(239,'c8497774-f473-4cab-9acd-f1065be396cc',16,'Banjardowo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(240,'14c9274d-1fa7-4e1a-824f-ba78c22c9150',16,'Karangpakis','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(241,'283e1c8b-33a4-42c3-be9e-015334c956ce',16,'Sumberingin','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(242,'f04318b6-58f5-4a95-961e-f849953aed7c',16,'Sumbergondang','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(243,'57f5040e-ac62-4d1d-bd7b-fa8a08943f82',16,'Kauman','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(244,'da0573f8-50f4-461b-9f37-6b14d4a910f8',16,'Munungkerep','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(245,'57f892d9-35c4-40e4-9fd8-b49a4ad1278b',16,'Genenganjasem','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(246,'0b9a9325-5601-4123-97e3-2e8a4f93f5ac',16,'Manduro','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(247,'b3dcd31f-40a7-401b-ae27-b1a57f555a4d',16,'Sukodadi','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(248,'a3b2cf57-56cf-433d-b69c-1c200c4e0cd3',16,'Pengampon','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(249,'245c93e0-ad67-43ae-8b25-6d02e610210a',16,'Sumberaji','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(250,'8ec56a29-bee4-48c3-93d6-0af5b0ff748d',17,'Sidokaton','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(251,'a9939dc3-64d8-45b7-8309-331e81b968d7',17,'Tapen','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(252,'c597951f-0f0d-457f-881e-6ea8dc81e2f9',17,'Bakalanrayung','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(253,'e0779d94-bf9e-4b07-9f1b-24ce03b7772c',17,'Randuwatang','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(254,'6cf8e435-8a21-4a94-bf04-d255ebce5b3c',17,'Sumberteguh','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(255,'3a3bd2ba-37a7-4d33-bef0-b28e6b0fba80',17,'Menturus','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(256,'ab3f2a32-d132-4990-9e87-aac0c5ce0d4a',17,'Kudubanjar','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(257,'7e60ac06-3ef9-4931-86bd-ef9cf8e726fc',17,'Made','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(258,'34990d59-6fad-470c-a033-d1ddb4d650c0',17,'Kepuhrejo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(259,'dc8c4455-4715-4728-9bd6-f1fab1dc1fdd',17,'Bendungan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(260,'ff062bd5-63ef-4467-b3ae-3ea2da24a92f',17,'Katemas','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(261,'3d6edfae-8403-447b-93c9-275bc58e755d',18,'Bandarkedungmulyo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(262,'ef51f4bc-052d-4d5a-b9fd-80b68525bb13',18,'Mojokambang','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(263,'7c9803f8-8e87-48b1-8ede-a22afe1858ea',18,'Barongsawahan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(264,'465962be-a3f5-4c01-8607-419f8b41ae8e',18,'Kayen','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(265,'d4ae99a8-d218-4c6e-9a23-79f7ab097ebd',18,'Gondangmanis','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(266,'3b7046d1-c42b-4038-befd-ea93055a0cb4',18,'Brodot','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(267,'3929615b-0b4b-40b9-959b-e44974ffc78b',18,'Pucangsimo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(268,'fdec8513-38a0-479b-986e-def3fb2eb89a',18,'Banjarsari','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(269,'33a1106c-5229-4a0e-9cf3-28d37e1e55b2',18,'Brangkal','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(270,'245c369e-da3d-4836-89b1-696bcaa69ba8',18,'Karangdagangan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(271,'bb9b2797-925f-4c53-a11b-d777930d74b0',18,'Tinggar','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(272,'b0f6cf38-0683-4f57-a70d-bbe632311f93',19,'Jogoroto','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(273,'e53cad4c-11b0-4887-a8b7-8a38c5d2d05a',19,'Jarakkulon','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(274,'fcf860e9-7381-431d-b386-c06cca45d4a6',19,'Alang-alangcaruban','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(275,'758251f1-62fc-4efc-bba2-b8814b797a88',19,'Sukosari','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(276,'45ad8ee9-674f-41c5-99d8-9294a0b71e16',19,'Sawiji','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(277,'c8af2936-a16a-4932-9496-2917194a7ca2',19,'Mayangan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(278,'206002b6-e4f8-466e-984d-9e071c5dd3e1',19,'Sumbermulyo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(279,'a6527f2a-6be3-4a9b-93b7-7f3c09fc1afc',19,'Ngumpul','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(280,'aad71163-ab08-4e74-95c0-a3c0a43f3b23',19,'Tambar','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(281,'48f04bef-766c-48c8-8391-1a6d2d4ead45',19,'Janti','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(282,'d97ed1b3-45fb-4645-93db-14cc39c91c5f',19,'Sambirejo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(283,'69286317-5b0f-4085-9aa1-a5e658eca34f',20,'Turipinggir','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(284,'4ac76053-188e-440e-badb-cf5aa23149ef',20,'Gongseng','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(285,'e5a590e2-0a03-453e-83be-f9c0e3f8f3bf',20,'Megaluh','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(286,'20646319-cd01-46d8-bba9-d801e6c207ac',20,'Sudimoro','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(287,'9b68ef8e-2e68-4fd6-9449-ec8fd571208a',20,'Balongsari','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(288,'6e1ede21-1bff-4d86-a25c-e57ab91942fe',20,'Sumbersari','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(289,'df0a3d9a-c089-483f-981d-3bc2208cec2b',20,'Ngogri','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(290,'ba9635bb-937d-44aa-903e-453564681b01',20,'Sidomulyo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(291,'376b63e4-9b44-481c-bfd1-ad1075e37b24',20,'Balonggemek','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(292,'c825b7db-1b68-4c4b-958c-77f4196000e9',20,'Dukuharum','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(293,'3d47a3eb-0b44-4b72-ba0d-55a5ed5c7a38',20,'Sumberagung','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(294,'55776d20-6b96-4365-b045-95afec709402',20,'Pacarpeluk','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(295,'21f1d99f-f383-459b-af47-4bc4e9e5d432',20,'Kedungrejo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(296,'475bec85-868c-459f-94be-1993aa2370df',21,'Ketapangkuning','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(297,'51d5853d-71cf-4e52-bed8-dea8c2aa4a3d',21,'Keboan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(298,'80f6bb3c-30d4-42bc-9463-6d0ec3cde716',21,'Kedungbogo','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(299,'ebd424da-828e-4b87-bf93-135be80c2662',21,'Ngusikan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(300,'2f79f0f8-d718-42dd-a0a1-03cb41209a3a',21,'Sumbernongko','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(301,'7ec455bd-d270-4c3d-9e46-17374125a6a1',21,'Cupak','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(302,'e6acee2c-cc97-40d0-9a18-23236e833f1c',21,'Manunggal','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(303,'213d7a8b-e6d6-474e-9150-db0e4c5e1c0d',21,'Ngampel','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(304,'ba151393-898e-4bc3-bcc9-cb3612f32c97',21,'Mojodanu','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(305,'87275bd9-1574-4f91-b736-d6c7ab61afcf',21,'Kromong','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(306,'858fc6ab-7184-405d-bd25-2b0906f6e2c6',21,'Asemgede','2023-08-09 08:39:13','2023-08-09 08:39:13');

/*Table structure for table `keterangan_umpan_baliks` */

DROP TABLE IF EXISTS `keterangan_umpan_baliks`;

CREATE TABLE `keterangan_umpan_baliks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keterangan_umpan_baliks_uuid_unique` (`uuid`),
  UNIQUE KEY `keterangan_umpan_baliks_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `keterangan_umpan_baliks` */

insert  into `keterangan_umpan_baliks`(`id`,`uuid`,`kode`,`keterangan`,`created_at`,`updated_at`) values 
(1,'e613de99-b454-4c7c-9853-227a50374b1b','u1','Persyaratan','2023-08-31 15:52:29','2023-09-21 13:29:33'),
(2,'d99b922b-da30-4a1f-98b7-dcf05c334f2e','u2','Prosedur','2023-08-31 15:52:29','2023-09-21 13:29:46'),
(3,'61732f00-5680-4281-abc8-596e3c9185c9','u3','Waktu Pelayanan','2023-08-31 15:52:29','2023-09-21 13:29:59'),
(4,'dfd31095-efbf-40bb-9bdd-d7fe1b085db9','u4','Biaya/Tarif','2023-08-31 15:52:29','2023-09-21 13:30:23'),
(5,'1f44bed9-d6ba-4982-bdb7-3e526fdb8490','u5','Produk Spesifikasi Layanan','2023-08-31 15:52:29','2023-09-21 13:30:46'),
(6,'494487b2-0ac1-4197-b29c-e3d1bf32a57c','u6','Kompetensi Pelaksana','2023-08-31 15:52:29','2023-09-21 13:31:05'),
(7,'9fb53d64-88b5-49e7-afd9-3384d350e365','u7','Perilaku Pelaksana','2023-08-31 15:52:29','2023-09-21 13:31:20'),
(8,'9a2d6ffa-e7c9-41df-b9c1-41e98a04a34c','u8','Sarana dan Prasarana','2023-08-31 15:52:29','2023-09-21 13:31:33'),
(9,'8dd3a929-2da6-40b6-9a9e-374d80021d62','u9','Penanganan Pengaduan','2023-08-31 15:52:29','2023-09-21 13:31:53');

/*Table structure for table `kode_retribusis` */

DROP TABLE IF EXISTS `kode_retribusis`;

CREATE TABLE `kode_retribusis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_retribusis_uuid_unique` (`uuid`),
  UNIQUE KEY `kode_retribusis_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kode_retribusis` */

insert  into `kode_retribusis`(`id`,`uuid`,`kode`,`nama`,`created_at`,`updated_at`) values 
(1,'3b18bae3-f223-449a-9c20-f17966eca9a3','01','RETRIBUSI PERSAMPAHAN KEBERSIHAN','2023-08-21 16:06:45','2023-08-21 16:06:45'),
(2,'260d7378-3db3-4e7d-ac60-0ba5c40c226a','02','RETRIBUSI PEMAKAIAN LAB','2023-08-21 16:06:45','2023-08-21 16:06:45'),
(3,'d784c962-353f-4d9f-b42d-e273379613fb','03','RETRIBUSI PENYEWAAN TANAH & BANGUNAN','2023-08-21 16:06:45','2023-08-21 16:06:45');

/*Table structure for table `layanans` */

DROP TABLE IF EXISTS `layanans`;

CREATE TABLE `layanans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `layanans_uuid_unique` (`uuid`),
  UNIQUE KEY `layanans_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `layanans` */

insert  into `layanans`(`id`,`uuid`,`slug`,`nama`,`deskripsi`,`nama_en`,`deskripsi_en`,`created_at`,`updated_at`) values 
(1,'b5867b1d-0a52-4162-93f7-aa58be4cf206','alur-permohonan','Alur Permohonan','<figure class=\"image\"><img src=\"https://silajang.mcflyon.co.id/storage/layanan/DHp26xDbpIrjNRxDjcdOwTA58prr3yVJj5KmL14b.png\"></figure>','Flow of Application','<figure class=\"image\"><img src=\"https://silajang.mcflyon.co.id/storage/layanan/X1Ut67Bj0V3rgmyyJEoAXKPW3WvKsGyhrm6VDxU7.png\"></figure>','2023-08-31 15:53:31','2023-08-31 15:53:31'),
(3,'a9fb06a8-4206-4174-8981-2c2674b60530','standart-pelayanan','Standart Pelayanan','<p>-</p>','service standart','<p>-</p>','2023-09-18 12:47:49','2023-09-18 12:47:49'),
(4,'a129b131-5869-45c0-a7fc-fb66a28a8151','maklumat-pelayanan','MAKLUMAT PELAYANAN','<p>-</p>','SERVICE ANNOUNCEMENT','<p>-</p>','2023-09-21 13:58:45','2023-09-21 13:58:45');

/*Table structure for table `libur_cutis` */

DROP TABLE IF EXISTS `libur_cutis`;

CREATE TABLE `libur_cutis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `libur_cutis_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `libur_cutis` */

insert  into `libur_cutis`(`id`,`uuid`,`tanggal`,`keterangan`,`created_at`,`updated_at`) values 
(1,'d7921d9e-37a7-458d-af3f-68c72aebbbb6','2023-08-17','Hari Kemerdekaan Republik Indonesia','2023-09-05 15:03:52','2023-09-05 15:03:52');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_07_18_063302_create_golongans_table',1),
(2,'2014_10_12_000000_create_users_table',1),
(3,'2014_10_12_100000_create_password_reset_tokens_table',1),
(4,'2019_08_19_000000_create_failed_jobs_table',1),
(5,'2019_12_14_000001_create_personal_access_tokens_table',1),
(6,'2023_07_07_103003_create_jenis_wadahs_table',1),
(7,'2023_07_08_111647_create_jenis_sampels_table',1),
(8,'2023_07_18_032008_create_kecamatans_table',1),
(9,'2023_07_18_032100_create_kelurahans_table',1),
(10,'2023_07_18_041716_create_permission_tables',1),
(11,'2023_07_18_061837_create_peraturans_table',1),
(12,'2023_07_18_063227_create_jasa_pengambilans_table',1),
(13,'2023_07_18_063537_create_permohonans_table',1),
(14,'2023_07_18_064330_create_titik_permohonans_table',1),
(15,'2023_07_18_070149_create_jenis_parameters_table',1),
(16,'2023_07_18_070650_create_parameters_table',1),
(17,'2023_07_18_071059_create_settings_table',1),
(18,'2023_07_18_071855_create_peraturan_parameters_table',1),
(19,'2023_07_18_072502_create_titik_permohonan_parameters_table',1),
(20,'2023_07_18_075950_create_detail_users_table',1),
(21,'2023_07_25_070713_create_phone_verifications_table',1),
(22,'2023_07_25_153036_create_email_verifications_table',1),
(23,'2023_07_27_130608_create_pengawetans_table',1),
(24,'2023_07_27_130713_create_pengawetan_parameters_table',1),
(25,'2023_08_02_145150_create_user_parameters_table',1),
(26,'2023_08_03_154559_create_tanda_tangans_table',1),
(27,'2023_08_04_083810_create_acuan_metodes_table',1),
(28,'2023_08_04_084620_alter_table_titik_permohonans_add_acuan_metode_id',1),
(29,'2023_08_04_100859_create_libur_cutis_table',1),
(30,'2023_08_08_154528_alter_table_titik_permohonans_add_nomor',1),
(31,'2023_08_08_155033_alter_table_jenis_sampels_add_kode',1),
(32,'2023_08_09_083435_alter_table_titik_permohonans_nullable',1),
(33,'2023_08_09_113845_alter_table_titik_permohonans_add_keterangan_revisi',2),
(34,'2023_08_10_104406_create_tracking_pengujians_table',3),
(35,'2023_08_11_091114_alter_table_titik_permohonan_parameters_add_kajiulang_permintaan',3),
(36,'2023_08_11_091300_alter_table_titik_permohonan_add_hasil_permohonan',3),
(37,'2023_08_11_094518_alter_table_titik_permohonans_add_lab_subkontrak',3),
(38,'2023_08_11_110111_alter_table_titik_permohonans_add_new_kondisi',3),
(39,'2023_08_11_142730_alter_table_titik_permohonans_change_to_datetime',3),
(40,'2023_08_15_152426_alter_table_tanda_tangans_drop_column_pangkat',4),
(41,'2023_08_16_094145_create_titik_permohonan_lapangans_table',5),
(42,'2023_08_18_093747_alter_table_titik_permohonan_parameters_add_keterangan_hasil',6),
(43,'2023_08_18_112434_alter_table_titik_permohonan_lapangans_add_params',6),
(44,'2023_08_21_092508_alter_table_titik_permohonan_parameters_drop_acc_upt',7),
(45,'2023_08_21_101211_create_kode_retribusis_table',7),
(46,'2023_08_21_101717_create_payments_table',7),
(47,'2023_08_21_111740_alter_table_payments_add_status',7),
(48,'2023_08_22_085459_alter_table_titik_permohonans_add_pengawetan_oleh',8),
(49,'2023_08_23_112840_create_f_a_q_s_table',9),
(50,'2023_08_23_115804_create_radius_pengambilans_table',9),
(51,'2023_08_23_120408_alter_permohonans_add_radius_pengambilan',9),
(52,'2023_08_28_104808_alter_table_titik_permohonan_parameters_add_hasil_uji_pembulatan',10),
(53,'2023_08_29_082548_alter_table_tanda_tangans',11),
(54,'2023_08_29_082731_alter_table_users_add_nip',11),
(55,'2023_08_29_084131_alter_table_detail_users_add_tanda_tangan',11),
(56,'2023_08_30_101130_create_pengumumen_table',12),
(57,'2023_08_30_101137_create_banners_table',12),
(58,'2023_08_30_101743_alter_table_faqs_add_english',12),
(59,'2023_08_30_102348_alter_table_pengumumen_add_english',12),
(60,'2023_08_30_104134_alter_table_pengumumen_and_banners_add_uuid',12),
(61,'2023_08_30_142810_alter_table_peraturans_add_file',12),
(62,'2023_08_31_094210_create_layanans_table',13),
(63,'2023_08_31_151502_create_umpan_baliks_table',13),
(64,'2023_08_31_153245_create_keterangan_umpan_baliks_table',13),
(65,'2023_09_04_095617_alter_table_parameters_add_keterangan',14),
(66,'2023_09_04_154108_create_petugas_pengambils_table',15),
(67,'2023_09_05_142722_alter_table_umpan_baliks_add_bulan',16),
(68,'2023_09_06_080351_create_produk_hukums_table',16),
(69,'2023_09_06_080403_create_produk_hukum_items_table',16),
(70,'2023_09_06_091756_alter_table_produk_hukums_add_slug',16),
(71,'2023_09_13_085742_alter_table_detail_users_nullable',17),
(72,'2023_09_19_092629_create_foto_titik_permohonans_table',18),
(73,'2023_09_20_081943_alter_table_titik_permohonan_add_obyek_pelayanan',19),
(74,'2023_09_20_131023_alter_table_payments_add_tanggal_bayar',19);

/*Table structure for table `model_has_permissions` */

DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_roles` */

insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values 
(1,'App\\Models\\User',1),
(2,'App\\Models\\User',2),
(3,'App\\Models\\User',3),
(5,'App\\Models\\User',3),
(4,'App\\Models\\User',4),
(5,'App\\Models\\User',4),
(5,'App\\Models\\User',5),
(5,'App\\Models\\User',6),
(5,'App\\Models\\User',7),
(5,'App\\Models\\User',8),
(6,'App\\Models\\User',8),
(5,'App\\Models\\User',9),
(6,'App\\Models\\User',9),
(7,'App\\Models\\User',10),
(7,'App\\Models\\User',13),
(7,'App\\Models\\User',15);

/*Table structure for table `parameters` */

DROP TABLE IF EXISTS `parameters`;

CREATE TABLE `parameters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` double NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mdl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_akreditasi` tinyint(1) NOT NULL DEFAULT '0',
  `is_dapat_diuji` tinyint(1) NOT NULL DEFAULT '1',
  `jenis_parameter_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parameters_uuid_unique` (`uuid`),
  KEY `parameters_jenis_parameter_id_foreign` (`jenis_parameter_id`),
  CONSTRAINT `parameters_jenis_parameter_id_foreign` FOREIGN KEY (`jenis_parameter_id`) REFERENCES `jenis_parameters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `parameters` */

insert  into `parameters`(`id`,`uuid`,`nama`,`keterangan`,`metode`,`harga`,`satuan`,`mdl`,`is_akreditasi`,`is_dapat_diuji`,`jenis_parameter_id`,`created_at`,`updated_at`) values 
(1,'4821de54-6da8-4f54-bda3-e16b1b687ba3','Suhu',NULL,'SNI 06-6989.23-2005',15000,'oC','0',1,1,1,'2023-08-09 08:39:14','2023-09-04 10:40:36'),
(2,'d2aa281c-727d-479c-a572-29c0c77debcd','TSS',NULL,'SNI 6989.3:2019',25000,'mg/L',NULL,1,1,1,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(3,'29373343-8df5-412d-8446-2e896bb0d86a','DHL',NULL,'SNI 6989.1:2019',14000,'mmhos/μS',NULL,1,1,1,'2023-08-09 08:39:14','2023-08-29 14:54:09'),
(4,'1cc97d16-db58-462a-be21-05638ee24352','pH',NULL,'SNI 6989.11:2019',15000,'-','',1,1,2,'2023-08-09 08:39:14','2023-09-13 14:47:47'),
(5,'ec08ec0b-88cb-4b7d-92fc-3846f00ff330','COD','Air Sungai','SNI 6989.2:2019',102000,'mg/L','3.05861',1,1,2,'2023-08-09 08:39:14','2023-09-08 13:45:09'),
(6,'ff1e9eed-b114-4ae3-8364-da274cd68b7e','BOD',NULL,'SNI 6989.72:2009',80000,'mg/L','0',1,1,2,'2023-08-09 08:39:14','2023-09-13 14:46:49'),
(7,'45f242ec-9bc9-433c-926a-980001deee49','DO',NULL,'SNI 06-6989.11-2004',33000,'mg/L',NULL,1,1,2,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(8,'74698dd5-7881-4fb9-a845-f0e6b388dfba','Cu',NULL,'SNI 6989.6:2009',52000,'mg/L','0.05652',1,1,2,'2023-08-09 08:39:14','2023-09-01 09:32:27'),
(9,'940726a9-c91e-4033-8dfc-24e96ec80e80','Cr',NULL,'SNI 6989.17:2009',52000,'mg/L','0.1383',1,1,2,'2023-08-09 08:39:14','2023-09-01 10:05:29'),
(10,'e7aae4e8-4110-4ddb-ab59-394b6487b891','Zn',NULL,'SNI 6989.7:2009',52000,'mg/L',NULL,1,1,2,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(11,'346adb8b-a5d8-4d0b-9fb9-56e205e6583e','Klorin Bebas',NULL,'IKM.KJB-39',25000,'mg/L',NULL,0,1,3,'2023-08-09 08:39:14','2023-08-29 14:51:21'),
(12,'c6b0f2ba-f312-4f49-a238-eca8847b9741','Amonia Total','Air Limbah','SNI 06.6989.30-2005',40000,'mg/L','0.031',1,1,2,'2023-08-09 08:39:14','2023-09-08 13:33:47'),
(13,'9e9e86a4-495c-4282-9e4e-6423b91c21fb','Amonia Bebas','Air Limbah','IKM.KJB-19 (Kalkulasi)',51000,'mg/L','0.0003',1,1,2,'2023-08-09 08:39:14','2023-09-08 13:33:35'),
(14,'59b2f298-efb2-41c2-9168-8d37941568d4','Ortho phospat',NULL,'SNI 06.6989.31-2005',37000,'mg/L','',1,1,2,'2023-08-09 08:39:14','2023-09-13 14:47:59'),
(15,'e942f61d-1224-4df4-b4f6-dab0de04f5e8','Total phospat','Air Limbah','SNI 6989-31.2021',36000,'mg/L','0.066',0,1,2,'2023-08-09 08:39:14','2023-09-08 13:52:40'),
(17,'6cdf38a3-3348-4d47-b451-f9860f4999cc','Total Coli (MPN)',NULL,'SM APHA 23rd. Ed, 9221 B, C, 2017',77000,'MPN/100 mL',NULL,1,1,3,'2023-08-09 08:39:14','2023-08-29 11:23:49'),
(18,'178d5fc8-503d-4cdd-ba59-7979549a3303','Total Coli (CFU)',NULL,'SM APHA 23rd. Ed, 9222 J, 2017',77000,'CFU/100 mL',NULL,0,1,3,'2023-08-09 08:39:14','2023-08-29 11:26:06'),
(19,'0e11cb82-4440-4ec8-9d02-574ff51b375a','E. coli (CFU)',NULL,'SM APHA 23rd. Ed, 9222 J, 2017',99000,'CFU/100 mL',NULL,0,1,3,'2023-08-09 08:39:14','2023-08-29 14:47:01'),
(20,'63dcff8b-19bb-421c-89ca-d56eaa51ba35','Minyak dan Lemak',NULL,'SNI 6989.10:2011',74000,'mg/L','0',0,1,2,'2023-08-09 08:39:14','2023-09-04 09:31:20'),
(21,'34c9446e-c247-4bde-98e3-4470e5c98569','Phenol',NULL,'SNI 06-6989.21-2004',89000,'mg/L','0.0657',0,1,2,'2023-08-09 08:39:14','2023-09-01 08:00:52'),
(22,'76194d7a-7cee-47c9-816c-0233a58aa476','Sulfida',NULL,'SNI 6989.70:2009',70000,'mg/L','',0,1,2,'2023-08-09 08:39:14','2023-09-13 14:48:32'),
(23,'99c8a0f8-1a18-4f8c-9c9b-98550f35b031','Nitrit',NULL,'SM APHA 23rd. Ed, 4500 B, 2017',34000,'mg/L','0.004',0,1,2,'2023-08-09 08:39:14','2023-09-01 08:17:20'),
(24,'9b4b4225-569c-4f46-9a22-e523857a8dcd','Nitrat','Air Limbah','SM APHA 23rd. Ed, 4500 B, 2017',34000,'mg/L','0.186',0,1,2,'2023-08-09 08:39:14','2023-09-08 13:47:54'),
(26,'25e24e76-dc03-4604-b193-49a408a30108','Total Nitrogen','Air Limbah','JIS K0102 butir 45.2-2008',60000,'mg/L','0.0645',0,1,2,'2023-08-09 08:39:14','2023-09-08 13:46:48'),
(27,'2f74be0a-4475-4800-b121-2d87765cc86d','Pb',NULL,'SNI 6989.8:2009',52000,'mg/L','2.4077',0,1,2,'2023-08-09 08:39:14','2023-09-01 09:59:35'),
(28,'178ae6ba-1f0a-4db0-92d2-ea79ab6bd44b','Cd',NULL,'SNI 6989.16:2009',52000,'mg/L','0.31993',0,1,2,'2023-08-09 08:39:14','2023-09-01 09:27:52'),
(29,'0c96a8e4-d646-4cd5-b162-f59a33074ae5','Fe',NULL,'SNI 06-6989.21-2004',52000,'mg/L',NULL,0,1,2,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(30,'d157e5b5-5182-407e-a67d-27e826a88c9e','Mn','Air Limbah','SNI 6989.5:2009',52000,'mg/L','',0,1,2,'2023-08-09 08:39:14','2023-09-08 13:47:04'),
(31,'39de7b92-b085-4a0a-bed5-2d40d81f59c8','As',NULL,'SNI 6989.81:2018',102000,'mg/L',NULL,0,1,2,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(32,'627bde91-eb8d-4ff5-9041-bd5959e91415','Fenol',NULL,'SNI 06-6989-21:2004',89000,'mg/L','',0,1,2,'2023-08-09 08:39:14','2023-09-13 14:47:16'),
(33,'54b84632-d813-4fb8-9d71-96dba5c815b9','Warna',NULL,'SNI 6989.80:2011',40000,'TCU',NULL,1,1,1,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(34,'b323847a-f8c0-4e70-9ece-2e1c439f6209','Klorida',NULL,'SNI 6989.19:2009',40000,'mg/L','2.09',0,1,2,'2023-08-09 08:39:14','2023-09-01 09:36:34'),
(35,'6022a586-2d92-4ea5-b899-e4b7a1319982','Kekeruhan',NULL,'SNI 06-6989.25-2005',15000,'NTU',NULL,1,1,1,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(36,'53c5799d-1b92-4211-bb44-f50789679e9a','Kesadahan Total','Air Bersih','SNI 06-6989.12-2004',40000,'mg/L','1.9',1,1,2,'2023-08-09 08:39:14','2023-09-08 13:47:16'),
(37,'8cf656be-5e03-4bb9-82a2-2bab467db297','Kalsium',NULL,'SNI 06-6989.12-2004',52000,'mg/L',NULL,1,1,2,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(38,'3f1399ab-2418-466f-a947-cd5094a85bf3','Magnesium',NULL,'SNI 06-6989.12-2004',52000,'mg/L',NULL,1,1,2,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(39,'96aa6bd9-bed3-4133-b141-47d55f2977a5','Rasa',NULL,'IKM-KJB.28 (Organoleptik)',14000,'-','',1,1,1,'2023-08-09 08:39:14','2023-09-13 14:48:19'),
(40,'1fca8e19-742b-444e-bed7-c669bbdfd79b','Bau',NULL,'IKM-KJB.29 (Organoleptik)',14000,'-','0',1,1,1,'2023-08-09 08:39:14','2023-09-13 14:46:38'),
(41,'faaf653e-cf7c-4905-aef3-2f146aadcaa0','Surfaktan',NULL,'SNI 06-6989.51-2005',105000,'mg/L','0.019',1,1,2,'2023-08-09 08:39:14','2023-09-01 10:32:43'),
(42,'8e843265-522e-4972-9374-514ef8016df6','KMnO4',NULL,'SNI 06-6989.22-2004',33000,'mg/L',NULL,0,1,1,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(43,'f2663c64-dfc2-4d1d-82ed-caf1dcf92a79','TDS',NULL,'SNI 6989.37:2019',26000,'mg/L','',1,1,1,'2023-08-09 08:39:14','2023-09-13 14:48:40'),
(45,'d01b395e-2adf-4d66-bdaf-02881c8ad110','Fecal Coli (MPN)',NULL,'SM APHA 23rd. Ed, 9221 E, C, 2017',99000,'MPN/100mL',NULL,1,1,3,'2023-08-29 11:24:43','2023-08-29 14:59:14'),
(46,'77f864d6-cdd7-495c-a936-5b91b0f28b73','Nitrat','Air Bersih','SM APHA 23rd. Ed, 4500-NO3-B, 2017',34000,'mg/L','0.175',1,1,2,'2023-08-30 12:06:20','2023-09-08 13:47:32'),
(47,'b5c7e22c-421a-4aed-ac04-05ee2cdfb442','Zn','Air Sungai','SNI 6989.7:2009',52000,'mg/L','',0,1,2,'2023-08-30 12:13:23','2023-09-08 13:46:24'),
(48,'33a24b4b-ed1f-4f86-88aa-93b032ae20a2','Mn',NULL,'SNI 6989.5:2009',52000,'mg/L','0.03',1,1,2,'2023-09-01 08:08:08','2023-09-01 08:08:55'),
(49,'71ee20ed-04c1-445d-94b1-3f56d8f5e1f8','Cr6+','Air Bersih','SNI 6989.71:2009',40000,'mg/L','0.0092',0,1,2,'2023-09-01 09:51:00','2023-09-08 13:45:33'),
(50,'e4a0a3a8-09fa-43e9-a309-a55dbf9927cd','Cr6+','Air Limbah','SNI 6989.71:2009',40000,'mg/L','0.0144',0,1,2,'2023-09-01 09:53:09','2023-09-08 13:45:42'),
(51,'03c41cad-087e-40a2-a731-08602e653b20','COD','Air Limbah','SNI 6989.2:2019',102000,'mg/L','1.9526',1,1,2,'2023-09-01 10:04:08','2023-09-08 13:44:53'),
(52,'2d96ecf5-99a6-4732-b2ec-50a833d0076f','COD','Tinggi Air Limbah','SNI 6989.2:2019',102000,'mg/L','11.447',1,1,2,'2023-09-01 10:17:00','2023-09-08 13:45:19'),
(53,'9a234fc4-050c-436f-85be-cca82af86c17','Total Phospat','Air Sungai','SNI 06-6989.31-2005',36000,'mg/L','0.032',0,1,2,'2023-09-01 10:43:07','2023-09-08 13:46:38'),
(54,'9a234fc4-050c-436f-95be-cda82af86c17','Krom Heksavalen',NULL,'SNI 6989.71:2009',40000,'mg/L',NULL,0,1,2,'2023-09-01 10:43:07','2023-09-01 10:43:07'),
(55,'9b4b4225-569c-4f46-10a22-e5238578dcd','Nitrat','Air Sungai','SM APHA 23rd. Ed, 4500 B, 2017',34000,'mg/L','0.1829',0,1,2,'2023-09-01 10:43:07','2023-09-08 13:52:57'),
(57,'61472ac6-cade-47c5-9036-a3f3b821e540','Fluorida',NULL,'-',0,'-','0',0,0,2,'2023-09-04 09:53:01','2023-09-04 10:29:11');

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_retribusi_id` bigint unsigned DEFAULT NULL,
  `va_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` double NOT NULL,
  `tanggal_exp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'YYYYMMDD',
  `is_lunas` tinyint(1) NOT NULL DEFAULT '0',
  `titik_permohonan_id` bigint unsigned DEFAULT NULL,
  `berita1` text COLLATE utf8mb4_unicode_ci,
  `berita2` text COLLATE utf8mb4_unicode_ci,
  `berita3` text COLLATE utf8mb4_unicode_ci,
  `berita4` text COLLATE utf8mb4_unicode_ci,
  `berita5` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','success','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_bayar` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_uuid_unique` (`uuid`),
  UNIQUE KEY `payments_va_number_unique` (`va_number`),
  KEY `payments_kode_retribusi_id_foreign` (`kode_retribusi_id`),
  KEY `payments_titik_permohonan_id_foreign` (`titik_permohonan_id`),
  CONSTRAINT `payments_kode_retribusi_id_foreign` FOREIGN KEY (`kode_retribusi_id`) REFERENCES `kode_retribusis` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `payments_titik_permohonan_id_foreign` FOREIGN KEY (`titik_permohonan_id`) REFERENCES `titik_permohonans` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `payments` */

insert  into `payments`(`id`,`uuid`,`kode_retribusi_id`,`va_number`,`nama`,`jumlah`,`tanggal_exp`,`is_lunas`,`titik_permohonan_id`,`berita1`,`berita2`,`berita3`,`berita4`,`berita5`,`created_at`,`updated_at`,`status`,`tanggal_bayar`) values 
(4,'3ac8881c-a3aa-441e-a3bf-324842b4668d',2,'1494022023082501','Customer Test',25000,'2023-09-24',0,1,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-08-25 15:19:05','2023-08-25 15:19:08','failed',NULL),
(7,'4d90e2df-5609-42fa-bab5-f70319d6c610',2,'1494022023082502','Customer Test',25000,'2023-09-24',0,1,'pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-08-25 15:22:58','2023-08-25 15:23:01','failed',NULL),
(22,'f84c01dd-d6a1-48d0-ac0c-e1eacaa74996',2,'1494022023090501','Customer Test',413000,'2023-10-05',0,2,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-05 11:41:30','2023-09-05 11:43:54','failed',NULL),
(23,'05c04f3c-2ec0-4582-a4a4-692a3a2c3b25',2,'1494022023090502','Customer Test',25000,'2023-10-05',0,2,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-05 11:44:33','2023-09-05 11:44:35','failed',NULL),
(26,'1800fb66-2e19-4f4c-ad4c-61c88c62d9ba',2,'1494022023090503','Customer Test',413000,'2023-10-05',0,2,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-05 11:44:49','2023-09-05 11:45:37','failed',NULL),
(27,'591f41eb-edff-4f78-8516-1473f3e0a5dc',2,'1494022023090504','Customer Test',413000,'2023-10-05',0,2,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-05 11:45:45','2023-09-05 11:46:32','failed',NULL),
(28,'13019611-5143-4070-99a9-15a64e0df657',2,'1494022023090505','Customer Test',413000,'2023-10-05',0,2,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-05 11:46:36','2023-09-11 12:00:31','failed',NULL),
(29,'a5c08bee-6b7e-4e24-800a-c36d649554db',2,'1494022023090801','M Aang Kurniawan',425000,'2023-09-22',1,4,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-08 14:52:52','2023-09-08 15:54:41','success',NULL),
(30,'2fced482-0c3d-4129-8ec4-1ab2d57a4797',2,'1494022023091301','Customer Test',362000,'2023-09-27',0,6,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-13 11:37:50','2023-09-13 13:10:00','failed',NULL),
(31,'c8f17c79-2207-49bc-a291-336fe5c3b71a',2,'1494022023091302','Customer Test',281000,'2023-09-27',0,1,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-13 11:38:12','2023-09-13 11:38:12','pending',NULL),
(32,'bace7a95-a197-45db-99b7-6a1da53001c6',3,'1494032023091303','aang',400000,'2023-09-30',0,NULL,'contoh berita 1',NULL,NULL,NULL,NULL,'2023-09-13 13:39:23','2023-09-13 13:47:29','failed',NULL),
(33,'52e6940f-d54b-432f-9aea-4b91238a5fd5',2,'1494022023091304','Customer Test',413000,'2023-09-27',0,7,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-13 13:52:38','2023-09-13 13:52:38','pending',NULL),
(34,'d2986bf0-d893-4b8b-881c-0788edc46942',2,'1494022023091401','Customer Test',413000,'2023-09-28',0,2,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-14 13:10:17','2023-09-14 13:10:17','pending',NULL),
(35,'c821757b-3506-4a67-90db-c99caf49f755',2,'1494022023091801','M Aang Kurniawan',413000,'2023-10-02',1,9,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-18 11:09:44','2023-09-21 09:40:40','success','2023-09-21'),
(36,'ec942fbc-8802-4e04-a07a-dd401977f63a',2,'1494022023091802','M Aang Kurniawan',452000,'2023-10-02',1,10,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-18 12:29:28','2023-09-21 09:40:15','success','2023-09-21'),
(37,'db5844f3-9514-42c7-b63c-a956bfcfbdde',2,'1494022023092101','M Aang Kurniawan',425000,'2023-10-21',1,12,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-21 13:41:33','2023-09-21 16:00:57','success','2023-09-21'),
(38,'3248d094-8a1a-43fb-b02f-3395d9b8f53e',2,'1494022023092102','Customer Test',362000,'2023-10-21',0,6,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-21 14:21:23','2023-09-21 14:21:23','pending',NULL),
(39,'c9d27b4f-101c-442b-aa61-a038e0cc6a01',2,'1494022023092201','CV. MTI',413000,'2023-10-22',0,14,'Pembayaran Pengujian',NULL,NULL,NULL,NULL,'2023-09-22 10:10:59','2023-09-22 10:10:59','pending',NULL);

/*Table structure for table `pengawetan_parameters` */

DROP TABLE IF EXISTS `pengawetan_parameters`;

CREATE TABLE `pengawetan_parameters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pengawetan_id` bigint unsigned NOT NULL,
  `parameter_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengawetan_parameters_pengawetan_id_foreign` (`pengawetan_id`),
  KEY `pengawetan_parameters_parameter_id_foreign` (`parameter_id`),
  CONSTRAINT `pengawetan_parameters_parameter_id_foreign` FOREIGN KEY (`parameter_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengawetan_parameters_pengawetan_id_foreign` FOREIGN KEY (`pengawetan_id`) REFERENCES `pengawetans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pengawetan_parameters` */

insert  into `pengawetan_parameters`(`id`,`pengawetan_id`,`parameter_id`,`created_at`,`updated_at`) values 
(1,1,2,NULL,NULL),
(2,1,3,NULL,NULL),
(3,1,5,NULL,NULL),
(4,2,5,NULL,NULL),
(5,1,6,NULL,NULL),
(6,1,7,NULL,NULL),
(7,1,8,NULL,NULL),
(8,3,8,NULL,NULL),
(9,1,9,NULL,NULL),
(10,3,9,NULL,NULL),
(11,1,10,NULL,NULL),
(12,3,10,NULL,NULL),
(13,1,11,NULL,NULL),
(14,2,11,NULL,NULL),
(15,1,13,NULL,NULL),
(16,2,13,NULL,NULL),
(17,1,14,NULL,NULL),
(18,1,15,NULL,NULL),
(19,2,15,NULL,NULL),
(21,1,17,NULL,NULL),
(22,1,18,NULL,NULL),
(23,1,19,NULL,NULL),
(24,1,20,NULL,NULL),
(25,2,20,NULL,NULL),
(26,1,21,NULL,NULL),
(27,2,21,NULL,NULL),
(28,1,22,NULL,NULL),
(29,2,22,NULL,NULL),
(30,5,22,NULL,NULL),
(31,1,23,NULL,NULL),
(32,1,24,NULL,NULL),
(35,1,26,NULL,NULL),
(36,2,26,NULL,NULL),
(37,1,27,NULL,NULL),
(38,3,27,NULL,NULL),
(39,1,28,NULL,NULL),
(40,3,28,NULL,NULL),
(41,1,29,NULL,NULL),
(42,3,29,NULL,NULL),
(43,1,30,NULL,NULL),
(44,3,30,NULL,NULL),
(45,1,31,NULL,NULL),
(46,3,31,NULL,NULL),
(47,1,32,NULL,NULL),
(48,2,32,NULL,NULL),
(49,1,33,NULL,NULL),
(50,1,35,NULL,NULL),
(51,1,36,NULL,NULL),
(52,3,36,NULL,NULL),
(53,1,37,NULL,NULL),
(54,3,37,NULL,NULL),
(55,1,38,NULL,NULL),
(56,3,38,NULL,NULL),
(57,1,39,NULL,NULL),
(58,1,40,NULL,NULL),
(59,1,41,NULL,NULL),
(60,1,42,NULL,NULL),
(61,3,42,NULL,NULL),
(62,1,43,NULL,NULL),
(64,1,45,NULL,NULL),
(65,1,46,NULL,NULL),
(66,1,47,NULL,NULL),
(67,3,47,NULL,NULL),
(68,1,48,NULL,NULL),
(69,3,48,NULL,NULL),
(70,7,34,NULL,NULL),
(71,1,49,NULL,NULL),
(72,6,49,NULL,NULL),
(73,1,50,NULL,NULL),
(74,6,50,NULL,NULL),
(75,1,51,NULL,NULL),
(76,2,51,NULL,NULL),
(77,1,52,NULL,NULL),
(78,2,52,NULL,NULL),
(79,1,12,NULL,NULL),
(80,2,12,NULL,NULL),
(81,1,53,NULL,NULL),
(82,2,53,NULL,NULL),
(84,1,57,NULL,NULL),
(85,1,1,NULL,NULL),
(86,1,4,NULL,NULL);

/*Table structure for table `pengawetans` */

DROP TABLE IF EXISTS `pengawetans`;

CREATE TABLE `pengawetans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengawetans_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pengawetans` */

insert  into `pengawetans`(`id`,`uuid`,`nama`,`created_at`,`updated_at`) values 
(1,'39576d25-dbdb-4b20-8b7b-3c119818c30e','Pendinginan','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(2,'65932555-2045-4683-95ae-813b3c3bb950','H2SO4','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(3,'15366cbe-7be0-45f3-a585-7ad7feade8ee','HNO3','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(4,'f5991fc8-7439-45ca-9fdd-d6f7796692d9','NaOH','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(5,'2550fe25-96fe-4699-ba70-38e123b9b67f','Zn(CH3COO)2','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(6,'3247be00-c4fc-4c83-94c2-2aa135a36b6e','(NH4)2SO4','2023-08-09 08:39:14','2023-08-09 08:39:14'),
(7,'63fe12bc-462d-4da4-9066-339481ec9607','-','2023-09-01 09:35:31','2023-09-01 09:35:31');

/*Table structure for table `pengumumen` */

DROP TABLE IF EXISTS `pengumumen`;

CREATE TABLE `pengumumen` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengumumen_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pengumumen` */

insert  into `pengumumen`(`id`,`uuid`,`judul`,`judul_en`,`isi`,`isi_en`,`created_at`,`updated_at`) values 
(2,'65906c69-d8fc-4009-9007-f4ee44d1d4b6','KETENTUAN PELAYANAN','TERMS OF SERVICE','1. Laboratorium Lingkungan Dinas Lingkungan Hidup Kabupaten Jombang memberlakukan pengujian parameter kualitas lingkungan yang terintegrasi dengan pengambilan contoh uji\r\n2. Proses pelayanan pengujian parameter kualitas lingkungan adalah 14 hari kerja\r\n3. Layanan operasional pada Senin-Kamis jam 07.30-15.30 dan Jumat jam 07.30-14.30\r\n4. Pembayaran dilakukan dengan akun virtual BANK JATIM \r\n5. Jangka waktu pembayaran adalah 14 hari kerja \r\n6. Segala bentuk koordinasi, komunikasi dan pemberian layanan konsultasi agar mengefektifkan penggunaan sarana whatsapp, e-mail, dan sarana elektronik lainnya\r\n\r\nSalam, \r\n\r\nKepala UPT Laboratorium Lingkungan Dinas Lingkungan Hidup Kabupaten Jombang','1. The Environmental Laboratory of the Jombang Regency Environmental Department requires testing of environmental quality parameters that are integrated with taking test samples\r\n2. The service process for testing environmental quality parameters is 14 working days\r\n3. Operational service on Monday-Thursday 07.30-15.30 and Friday 07.30-14.30\r\n4. Payment is using BANK JATIM virtual account\r\n5. The payment period is 14 working days\r\n6. All of communication and provision of consulting services in order to make effective use of whatsapp, e-mail and other electronic means\r\n6. Kindly contact us trough whatsapp and e-mail for all forms of communication\r\n\r\nSincerely,\r\n\r\nHead of Environmental Laboratory of the Jombang Regency Environmental Department','2023-09-07 14:51:55','2023-09-07 15:04:17');

/*Table structure for table `peraturan_parameters` */

DROP TABLE IF EXISTS `peraturan_parameters`;

CREATE TABLE `peraturan_parameters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `peraturan_id` bigint unsigned NOT NULL,
  `parameter_id` bigint unsigned NOT NULL,
  `baku_mutu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cetak_miring` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peraturan_parameters_peraturan_id_foreign` (`peraturan_id`),
  KEY `peraturan_parameters_parameter_id_foreign` (`parameter_id`),
  CONSTRAINT `peraturan_parameters_parameter_id_foreign` FOREIGN KEY (`parameter_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peraturan_parameters_peraturan_id_foreign` FOREIGN KEY (`peraturan_id`) REFERENCES `peraturans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `peraturan_parameters` */

insert  into `peraturan_parameters`(`id`,`peraturan_id`,`parameter_id`,`baku_mutu`,`cetak_miring`,`created_at`,`updated_at`) values 
(17,7,6,'75',0,NULL,NULL),
(19,7,2,'50',0,NULL,NULL),
(20,7,32,'0,25',0,NULL,NULL),
(21,7,12,'4',0,NULL,NULL),
(22,7,4,'6-9',0,NULL,NULL),
(23,8,6,'75',0,NULL,NULL),
(25,8,2,'60',0,NULL,NULL),
(26,8,20,'15',0,NULL,NULL),
(28,8,41,'3',0,NULL,NULL),
(29,9,4,'6-9',0,NULL,NULL),
(30,9,6,'75',0,NULL,NULL),
(32,9,2,'100',0,NULL,NULL),
(33,9,20,'10',0,NULL,NULL),
(34,9,9,'1',0,NULL,NULL),
(35,9,8,'3',0,NULL,NULL),
(36,9,10,'10',0,NULL,NULL),
(37,10,6,'100',1,NULL,NULL),
(39,10,2,'100',0,NULL,NULL),
(40,10,20,'15',0,NULL,NULL),
(41,10,12,'25',0,NULL,NULL),
(42,10,4,'6-9',0,NULL,NULL),
(43,11,6,'Maks 100',0,NULL,NULL),
(45,11,2,'Maks 100',0,NULL,NULL),
(46,11,26,'Maks 30',0,NULL,NULL),
(47,11,21,'Maks 1',0,NULL,NULL),
(48,11,4,'6-9',0,NULL,NULL),
(49,12,6,'Maks 75',0,NULL,NULL),
(51,12,2,'Maks 75',0,NULL,NULL),
(52,12,4,'6-9',0,NULL,NULL),
(53,13,6,'Maks 40',0,NULL,NULL),
(55,13,2,'Maks 40',0,NULL,NULL),
(56,13,20,'Maks 5',0,NULL,NULL),
(57,13,22,'Maks 0,5',0,NULL,NULL),
(58,13,4,'6-9',0,NULL,NULL),
(59,13,1,'=',0,NULL,NULL),
(60,14,4,'6-9',0,NULL,NULL),
(61,14,6,'Maks 150',0,NULL,NULL),
(62,14,5,'Maks 300',0,NULL,NULL),
(63,14,2,'Maks 100',0,NULL,NULL),
(64,14,26,'Maks 60',0,NULL,NULL),
(65,14,28,'Maks 0,1',0,NULL,NULL),
(66,15,40,'-',0,NULL,NULL),
(67,15,43,'-',0,NULL,NULL),
(68,15,35,'-',0,NULL,NULL),
(69,15,39,'-',0,NULL,NULL),
(70,15,1,'-',0,NULL,NULL),
(71,15,33,'-',0,NULL,NULL),
(72,15,31,'-',0,NULL,NULL),
(73,15,29,'-',0,NULL,NULL),
(74,15,28,'-',0,NULL,NULL),
(75,15,36,'-',0,NULL,NULL),
(76,15,34,'-',0,NULL,NULL),
(77,15,9,'-',0,NULL,NULL),
(78,15,30,'-',0,NULL,NULL),
(79,15,24,'-',0,NULL,NULL),
(80,15,23,'-',0,NULL,NULL),
(81,15,4,'-',0,NULL,NULL),
(82,15,10,'-',0,NULL,NULL),
(83,15,22,'-',0,NULL,NULL),
(84,15,8,'-',0,NULL,NULL),
(85,15,27,'-',0,NULL,NULL),
(86,15,17,'-',0,NULL,NULL),
(100,15,45,'-',0,NULL,NULL),
(113,2,4,'6-9',0,NULL,NULL),
(114,2,6,'Maks  30',0,NULL,NULL),
(115,2,51,'Maks  100',0,NULL,NULL),
(116,2,2,'Maks 30',0,NULL,NULL),
(117,2,12,'Maks 10',0,NULL,NULL),
(118,2,20,'Maks 5',0,NULL,NULL),
(119,2,18,'maks 3000',0,NULL,NULL),
(120,6,19,'Maks 0',0,NULL,NULL),
(121,6,18,'Maks 0',0,NULL,NULL),
(122,6,1,'Suhu Udara ± 3',0,NULL,NULL),
(123,6,43,'<300',0,NULL,NULL),
(124,6,35,'<3',0,NULL,NULL),
(125,6,33,'Maks 10',0,NULL,NULL),
(126,6,40,'Tidak Berbau',0,NULL,NULL),
(127,6,4,'6.5 – 8.5',0,NULL,NULL),
(128,6,46,'Maks 20',0,NULL,NULL),
(129,6,23,'Maks 3',0,NULL,NULL),
(130,6,29,'Maks 0,2',0,NULL,NULL),
(131,6,48,'Maks 0,1',0,NULL,NULL),
(164,20,4,NULL,0,NULL,NULL),
(165,20,6,NULL,0,NULL,NULL),
(166,20,51,NULL,0,NULL,NULL),
(167,20,2,NULL,0,NULL,NULL),
(168,20,20,NULL,0,NULL,NULL),
(169,20,15,NULL,0,NULL,NULL),
(170,20,41,NULL,0,NULL,NULL),
(171,21,4,'6-9',0,NULL,NULL),
(172,21,6,'Maks 50',0,NULL,NULL),
(173,21,51,'Maks 120',0,NULL,NULL),
(174,21,2,'Maks 50',0,NULL,NULL),
(175,21,20,'Maks 20',0,NULL,NULL),
(176,22,4,'6-9',0,NULL,NULL),
(177,22,6,'Maks 75',0,NULL,NULL),
(178,22,51,'Maks 150',0,NULL,NULL),
(179,22,2,'Maks 100',0,NULL,NULL),
(180,22,21,'Maks 0,2',0,NULL,NULL),
(194,25,4,'6-9',0,NULL,NULL),
(195,25,6,'Maks 150',0,NULL,NULL),
(196,25,51,'Maks 300',0,NULL,NULL),
(197,25,2,'Maks 100',0,NULL,NULL),
(198,26,4,'6-9',0,NULL,NULL),
(199,26,6,'Maks 80',0,NULL,NULL),
(200,26,51,'Maks 160',0,NULL,NULL),
(201,26,2,'Maks 100',0,NULL,NULL),
(202,26,12,'Maks 2',0,NULL,NULL),
(203,26,20,'Maks 5',0,NULL,NULL),
(204,26,21,'Maks 0,5',0,NULL,NULL),
(205,27,4,NULL,0,NULL,NULL),
(206,27,6,NULL,0,NULL,NULL),
(207,27,51,NULL,0,NULL,NULL),
(208,27,2,NULL,0,NULL,NULL),
(209,27,13,NULL,0,NULL,NULL),
(210,27,41,NULL,0,NULL,NULL),
(211,27,1,NULL,0,NULL,NULL),
(212,28,4,NULL,0,NULL,NULL),
(213,28,6,NULL,0,NULL,NULL),
(218,28,51,NULL,0,NULL,NULL),
(219,28,2,NULL,0,NULL,NULL),
(220,28,20,NULL,0,NULL,NULL),
(221,28,8,NULL,0,NULL,NULL),
(222,28,9,NULL,0,NULL,NULL),
(223,28,10,NULL,0,NULL,NULL),
(224,29,4,NULL,0,NULL,NULL),
(225,29,6,NULL,0,NULL,NULL),
(226,29,51,NULL,0,NULL,NULL),
(227,29,2,NULL,0,NULL,NULL),
(228,29,13,NULL,0,NULL,NULL),
(229,29,21,NULL,0,NULL,NULL),
(230,30,4,NULL,0,NULL,NULL),
(231,30,6,NULL,0,NULL,NULL),
(232,30,51,NULL,0,NULL,NULL),
(233,30,2,NULL,0,NULL,NULL),
(234,30,21,NULL,0,NULL,NULL),
(235,30,26,NULL,0,NULL,NULL),
(236,31,4,NULL,0,NULL,NULL),
(237,31,6,NULL,0,NULL,NULL),
(238,31,51,NULL,0,NULL,NULL),
(239,31,2,NULL,0,NULL,NULL),
(240,31,12,NULL,0,NULL,NULL),
(241,31,20,NULL,0,NULL,NULL),
(242,31,18,NULL,0,NULL,NULL),
(246,7,51,'125',0,NULL,NULL),
(247,8,51,'180',0,NULL,NULL),
(248,8,4,'6-9',0,NULL,NULL),
(249,9,51,'150',0,NULL,NULL),
(250,10,51,'200',0,NULL,NULL),
(252,6,49,'Maks 0,01',0,NULL,NULL),
(253,11,51,'Maks 300',0,NULL,NULL),
(254,12,51,'Maks 150',0,NULL,NULL),
(255,13,51,'Maks 70',0,NULL,NULL),
(256,32,2,'Maks 100',0,NULL,NULL),
(257,32,4,'6-9',0,NULL,NULL),
(258,32,12,'Maks 10',0,NULL,NULL),
(259,32,6,'Maks 60',0,NULL,NULL),
(261,32,51,'Maks 120',0,NULL,NULL),
(262,32,32,'Maks 0,5',0,NULL,NULL),
(263,32,20,'Maks 5',0,NULL,NULL);

/*Table structure for table `peraturans` */

DROP TABLE IF EXISTS `peraturans`;

CREATE TABLE `peraturans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tentang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `peraturans_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `peraturans` */

insert  into `peraturans`(`id`,`uuid`,`nama`,`nomor`,`tentang`,`file`,`created_at`,`updated_at`) values 
(2,'233726fa-32d7-431f-a728-13728253e17d','Peraturan Menteri Lingkungan Hidup dan Kehutanan Republik Indonesia','P.68/Menlhk/Setjen/Kum.1/8/2016','Baku Mutu Air Limbah Domestik','/storage/peraturan/n0M4H3v6u9OGz5gIYU57dR1owhfhxRGsWZJyHRUY.pdf','2023-08-09 08:39:14','2023-09-04 08:12:21'),
(6,'9863d786-a26d-45a2-8971-e12b169200fa','PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA','NOMOR 2 TAHUN 2023','Parameter Air Keperluan Higiene dan Sanitasi',NULL,'2023-08-09 08:39:14','2023-09-04 08:52:05'),
(7,'d9aa4159-3091-4b1e-94e3-0aa4960cde5d','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH (Industri Kayu Lapis)',NULL,'2023-08-29 09:55:35','2023-08-29 10:00:10'),
(8,'e7bdf923-55be-43ea-8538-5d1e0658e7b8','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH (Industri Sabun)',NULL,'2023-08-29 10:02:46','2023-08-29 10:02:46'),
(9,'735d5ad8-d961-45ad-8dd4-d0095199c8e9','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH (Industri Polyetylene)',NULL,'2023-08-29 10:13:10','2023-08-29 10:13:10'),
(10,'7ecce328-144a-43bd-80a4-2f862ea853e7','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH (Industri Rumah Pemotongan Hewan)',NULL,'2023-08-29 10:19:21','2023-08-29 10:19:21'),
(11,'ac74c72e-799b-4353-87e3-8ac836267993','PERATURAN GUBERNUR JAWA TIMUR','NOMOR 52 TAHUN 2014','PERUBAHAN ATAS  PERATURAN GUBERNUR JAWA TIMUR NOMOR 72 TAHUN 2013 TENTANG BAKU MUTU AIR LIMBAH BAGI INDUSTRI DAN/ATAU KEGIATAN  USAHA LAINNYA (Industri Farmasi Proses Pembuatan Bahan Formula)',NULL,'2023-08-29 10:24:15','2023-08-29 10:35:11'),
(12,'77e70b40-1896-4d7d-97bf-fbef6187f295','PERATURAN GUBERNUR JAWA TIMUR','NOMOR 52 TAHUN 2014','PERUBAHAN ATAS PERATURAN GUBERNUR JAWA TIMUR NOMOR 72 TAHUN 2013 TENTANG BAKU MUTU AIR LIMBAH BAGI INDUSTRI DAN/ATAU KEGIATAN USAHA LAINNYA (Industri Farmasi Formulasi)',NULL,'2023-08-29 10:34:19','2023-08-29 10:34:19'),
(13,'5481456d-5e34-4778-a492-c7fd076bd156','PERATURAN GUBERNUR JAWA TIMUR','NOMOR 72 TAHUN 2013','BAKU MUTU AIR LIMBAH BAGI INDUSTRI DAN/ATAU  KEGIATAN USAHA LAINNYA (Industri Gula)',NULL,'2023-08-29 10:40:45','2023-08-29 10:40:45'),
(14,'cd2d297f-24f0-49ce-b29f-786806ed56e3','PERATURAN MENTERI LINGKUNGAN HIDUP DAN KEHUTANAN REPUBLIK INDONESIA','NOMOR P.59/Menlhk/Setjen/Kum.1/7/2016','BAKU MUTU LINDI BAGI USAHA DAN/ATAU KEGIATAN TEMPAT PEMROSESAN AKHIR SAMPAH (Baku Mutu Lindi)',NULL,'2023-08-29 10:44:25','2023-08-29 10:44:25'),
(15,'c1a99d4c-8ee8-448a-b1fe-bfdc22bd8a0a','PERATURAN MENTERI LINGKUNGAN HIDUP DAN KEHUTANAN REPUBLIK INDONESIA','NOMOR P.59/Menlhk/Setjen/Kum.1/7/2016','BAKU MUTU LINDI BAGI USAHA DAN/ATAU KEGIATAN TEMPAT PEMROSESAN AKHIR SAMPAH (Sumur Pantau)',NULL,'2023-08-29 10:49:33','2023-08-29 10:49:33'),
(20,'e1140018-7687-4cc9-b0ce-fbdd804b8146','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH (CV. Dhuha)','/storage/peraturan/AZ92Ejf5tiTfDuBirm60DAuhourRoZBzOg7LFis4.pdf','2023-09-01 14:25:52','2023-09-01 14:25:52'),
(21,'94bdef99-61b9-4ce7-9a9d-df7af767ff9c','PERATURAN GUBERNUR JAWA TIMUR','NOMOR 72 TAHUN 2013','Baku Mutu Air Limbah Bagi Industri dan/atau Kegiatan Usaha Lainnya (Perusahaan Kerupuk)','/storage/peraturan/vjOw603ihR0HXpt4Lip2mFW4DHsMaKvEvqrFReOo.pdf','2023-09-01 14:29:41','2023-09-01 14:30:08'),
(22,'cb3ac252-87e8-482a-bc2e-0cf9b0a1c8ed','PERATURAN GUBERNUR JAWA TIMUR','NOMOR 72 TAHUN 2013','Baku Mutu Air Limbah Bagi Industri dan/atau Kegiatan Usaha Lainnya(Perusahaan Jamu)','/storage/peraturan/LyxARqtnMI2cPOfCv999SJnGQgSi2T1psYLvAgWE.pdf','2023-09-01 14:31:44','2023-09-01 14:31:44'),
(25,'c8dc7957-b904-4f8a-a833-afdcbe673993','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH(PERUSAHAAN KECAP)','/storage/peraturan/lYbQl0grnEK5UfnN6n3zU9iQNRt6myeWpO8epf6U.pdf','2023-09-01 14:44:30','2023-09-01 14:45:54'),
(26,'9e38bd72-2a5c-4a25-b645-80f1e34c8096','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH (PERUSAHAAN ROKOK KATEGORI III)','/storage/peraturan/HYOx6GwLnFRV0z3BMpFl5SlhRCDQRnZZqnOd5ATq.pdf','2023-09-01 14:50:32','2023-09-04 11:30:39'),
(27,'b6a5ba8b-aa91-4352-a7b1-3ba4c8e05796','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH (PERUSAHAAN KOSMETIK)',NULL,'2023-09-01 14:54:00','2023-09-01 14:54:09'),
(28,'6042584f-260e-464f-9604-d7e1af543a4b','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH PERUSAHAAN PENGOLAHAN PLASTIK (PET)',NULL,'2023-09-01 14:55:59','2023-09-01 14:55:59'),
(29,'0afff90f-7f4f-479c-a691-1d31e15ccd36','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH (PERUSAHAAN KAYU LAPIS)',NULL,'2023-09-01 15:09:40','2023-09-01 15:09:40'),
(30,'ea01a0cc-23b6-4636-a34a-9190ca05b957','PERATURAN GUBERNUR JAWA TIMUR','NOMOR 52 TAHUN 2014','Baku Mutu Air Limbah (Pertambangan)',NULL,'2023-09-01 17:48:56','2023-09-01 17:48:56'),
(31,'13ffd39a-5df2-4a7d-b0c6-e07377af1fc0','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 68 TAHUN 2016','Baku Mutu Air Limbah Domestik',NULL,'2023-09-01 17:51:31','2023-09-13 14:50:57'),
(32,'b650615c-b61c-4656-9873-d92b5170c182','PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA','NOMOR 5 TAHUN 2014','BAKU MUTU AIR LIMBAH (PERUSAHAAN ROKOK KATEGORI IV)',NULL,'2023-09-04 11:32:45','2023-09-04 11:32:45');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values 
(1,'dashboard','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(2,'pengujian','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(3,'administrasi','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(4,'penerima-sample','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(5,'pengambil-sample','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(6,'pengujian-sample','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(7,'verifikasi','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(8,'baku-mutu','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(9,'manager-teknis','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(10,'kepala-upt','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(11,'master','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(12,'acuan-metode','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(13,'peraturan','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(14,'parameter','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(15,'pengawetan','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(16,'jenis-sampel','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(17,'jenis-wadah','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(18,'jasa-pengambilan','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(19,'libur-cuti','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(20,'user','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(21,'jabatan','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(22,'konfigurasi','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(23,'tanda-tangan','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(24,'konfigurasi-pengujian','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(25,'website','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(26,'setting','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(27,'whatsapp','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(28,'tracking-pengujian','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(29,'permohonan','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(30,'titik-permohonan','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(31,'tracking-permohonan','api','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(32,'analis','api','2023-08-09 11:44:48','2023-08-09 11:44:48'),
(33,'koordinator-teknis','api','2023-08-09 11:44:48','2023-08-09 11:44:48'),
(34,'pembayaran','api','2023-08-21 16:06:35','2023-08-21 16:06:35'),
(35,'pembayaran-pengujian','api','2023-08-21 16:06:35','2023-08-21 16:06:35'),
(36,'pembayaran-non-pengujian','api','2023-08-21 16:06:35','2023-08-21 16:06:35'),
(37,'kode-retribusi','api','2023-08-21 16:06:35','2023-08-21 16:06:35'),
(38,'report','api','2023-08-22 16:04:18','2023-08-22 16:04:18'),
(39,'lhu','api','2023-08-22 16:04:18','2023-08-22 16:04:18'),
(40,'kendali-mutu','api','2023-08-23 15:56:55','2023-08-23 15:56:55'),
(41,'radius-pengambilan','api','2023-08-23 15:56:55','2023-08-23 15:56:55'),
(42,'faq','api','2023-08-24 15:14:10','2023-08-24 15:14:10'),
(43,'banner','api','2023-08-30 15:42:30','2023-08-30 15:42:30'),
(44,'pengumuman','api','2023-08-30 15:42:30','2023-08-30 15:42:30'),
(45,'layanan','api','2023-08-31 15:52:08','2023-08-31 15:52:08'),
(46,'rekap-data','api','2023-09-04 15:27:47','2023-09-04 15:27:47'),
(47,'pembayaran-global','api','2023-09-06 15:52:39','2023-09-06 15:52:39'),
(48,'umpan-balik','api','2023-09-06 15:52:39','2023-09-06 15:52:39'),
(49,'produk-hukum','api','2023-09-06 15:52:39','2023-09-06 15:52:39'),
(50,'rekap-parameter','api','2023-09-08 15:52:09','2023-09-08 15:52:09'),
(51,'tracking-pengujian-customer','api','2023-09-08 15:52:09','2023-09-08 15:52:09'),
(52,'pembayaran-customer','api','2023-09-12 15:54:50','2023-09-12 15:54:50'),
(53,'persetujuan','api','2023-09-19 15:53:11','2023-09-19 15:53:11');

/*Table structure for table `permohonans` */

DROP TABLE IF EXISTS `permohonans`;

CREATE TABLE `permohonans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `industri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembayaran` enum('tunai','transfer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tunai',
  `is_mandiri` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `jasa_pengambilan_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `radius_pengambilan_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permohonans_uuid_unique` (`uuid`),
  KEY `permohonans_user_id_foreign` (`user_id`),
  KEY `permohonans_jasa_pengambilan_id_foreign` (`jasa_pengambilan_id`),
  KEY `permohonans_radius_pengambilan_id_foreign` (`radius_pengambilan_id`),
  CONSTRAINT `permohonans_jasa_pengambilan_id_foreign` FOREIGN KEY (`jasa_pengambilan_id`) REFERENCES `jasa_pengambilans` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `permohonans_radius_pengambilan_id_foreign` FOREIGN KEY (`radius_pengambilan_id`) REFERENCES `radius_pengambilans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permohonans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permohonans` */

insert  into `permohonans`(`id`,`uuid`,`keterangan`,`industri`,`kegiatan`,`alamat`,`pembayaran`,`is_mandiri`,`user_id`,`jasa_pengambilan_id`,`created_at`,`updated_at`,`radius_pengambilan_id`) values 
(1,'666c52da-bdf1-4f3e-99b6-e44d65dcc447',NULL,'asdasdas','fsdfsdfdsfds','asdasdas','transfer',1,10,NULL,'2023-08-25 14:46:00','2023-08-25 14:46:00',NULL),
(2,'04825f80-9338-4532-a0e1-5ed82efb95f5',NULL,'asdasdas','fsdfsdfdsfds','asdasdas','transfer',0,10,1,'2023-09-04 08:36:30','2023-09-08 15:15:33',1),
(3,'da1bef30-e6d0-4bd2-b64c-c37c7d5d41d6','-','cv mti','softwhare','surabaya','transfer',1,13,NULL,'2023-09-08 13:38:49','2023-09-08 13:38:49',NULL),
(4,'7346efa2-510d-4db8-a065-9dd85c5a55e8',NULL,'CV. MAJU JAYA COBA ELEKTRIK','Tahu kenuol','DK. SUMBER SARI II SARI REJO JOMBANG','transfer',0,10,1,'2023-09-13 10:57:27','2023-09-13 10:57:27',NULL),
(5,'c3d04b76-309b-4698-90ac-1c59f9e401d0','Di ambil','CV. MAJU JAYA COBA ELEKTRIK','Tahu kenyol','DK. SUMBER SARI II SARI REJO JOMBANG','transfer',0,10,1,'2023-09-13 10:58:22','2023-09-13 10:58:22',NULL),
(6,'5fe86c56-b07f-4cf7-af2f-3ae6609b80ee',NULL,'CV. MAJU JAYA COBA ELEKTRIK','fsdfsdfdsfds','DK. SUMBER SARI II SARI REJO JOMBANG','transfer',0,10,1,'2023-09-13 11:13:11','2023-09-13 13:51:13',1),
(7,'4cf63d7d-b664-43ac-92e9-e917e88450bf',NULL,'CV. MAJU JAYA COBA ELEKTRIK','fsdfsdfdsfds','DK. SUMBER SARI II SARI REJO JOMBANG','transfer',0,10,1,'2023-09-13 11:50:26','2023-09-13 13:51:52',1),
(8,'4e7b713d-b718-4aab-8fbc-f36ffa31f837',NULL,'CV. MAJU JAYA COBA ELEKTRIK','fsdfsdfdsfds','DK. SUMBER SARI II SARI REJO JOMBANG','transfer',0,10,1,'2023-09-13 14:33:28','2023-09-13 14:33:28',NULL),
(9,'d76d0281-1a6b-451e-b04f-d6282d5486b0',NULL,'cv mti','softwhare','surabaya','transfer',1,13,NULL,'2023-09-18 10:56:07','2023-09-18 10:56:07',NULL),
(10,'cdfb4abd-af0c-4220-9c10-b29ae33204c2','-','cv mti','softwhare','surabaya','transfer',0,13,1,'2023-09-18 12:14:44','2023-09-18 13:08:17',1),
(11,'37b6db6f-956c-4ec9-97a8-bb012fb51637','-','cv mti','softwhare','surabaya','transfer',0,13,1,'2023-09-18 13:10:18','2023-09-18 13:10:18',NULL),
(12,'88ba1e1c-fe65-45f3-9344-d8f92a53ef65',NULL,'cv mti','softwhare','surabaya','transfer',1,13,NULL,'2023-09-21 11:18:14','2023-09-21 11:18:14',NULL),
(13,'58b72f17-8e05-47cf-a288-346edc548389',NULL,'cv mti','softwhare','surabaya','transfer',1,13,NULL,'2023-09-21 11:26:52','2023-09-21 11:26:52',NULL),
(14,'cd68a94f-7605-4be4-9529-cf95b1ebbb2d',NULL,'cv mti','softwhare','surabaya','transfer',0,13,1,'2023-09-22 05:26:33','2023-09-22 09:28:16',1),
(15,'95bac4d3-86d1-4700-880c-edf865470e4f',NULL,'CV. MTI','Keramik','Jl. Surabaya','transfer',1,15,NULL,'2023-09-22 10:06:45','2023-09-22 10:06:45',NULL);

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `petugas_pengambils` */

DROP TABLE IF EXISTS `petugas_pengambils`;

CREATE TABLE `petugas_pengambils` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `petugas_id` bigint unsigned NOT NULL,
  `titik_permohonan_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `petugas_pengambils_petugas_id_foreign` (`petugas_id`),
  KEY `petugas_pengambils_titik_permohonan_id_foreign` (`titik_permohonan_id`),
  CONSTRAINT `petugas_pengambils_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `petugas_pengambils_titik_permohonan_id_foreign` FOREIGN KEY (`titik_permohonan_id`) REFERENCES `titik_permohonans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `petugas_pengambils` */

insert  into `petugas_pengambils`(`id`,`petugas_id`,`titik_permohonan_id`,`created_at`,`updated_at`) values 
(1,8,6,NULL,NULL),
(2,9,6,NULL,NULL),
(3,8,7,NULL,NULL),
(4,9,7,NULL,NULL),
(5,8,10,NULL,NULL),
(6,9,10,NULL,NULL),
(9,8,13,NULL,NULL),
(10,9,13,NULL,NULL),
(11,8,11,NULL,NULL),
(12,9,11,NULL,NULL);

/*Table structure for table `phone_verifications` */

DROP TABLE IF EXISTS `phone_verifications`;

CREATE TABLE `phone_verifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_verifications_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `phone_verifications` */

/*Table structure for table `produk_hukum_items` */

DROP TABLE IF EXISTS `produk_hukum_items`;

CREATE TABLE `produk_hukum_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produk_hukum_id` bigint unsigned NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `produk_hukum_items_uuid_unique` (`uuid`),
  KEY `produk_hukum_items_produk_hukum_id_foreign` (`produk_hukum_id`),
  CONSTRAINT `produk_hukum_items_produk_hukum_id_foreign` FOREIGN KEY (`produk_hukum_id`) REFERENCES `produk_hukums` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `produk_hukum_items` */

insert  into `produk_hukum_items`(`id`,`uuid`,`produk_hukum_id`,`nama`,`file`,`created_at`,`updated_at`) values 
(8,'d4f63ddc-48fd-4f59-88a0-9f9bf9dae7fe',2,'PERATURAN MENTERI LINGKUNGAN HIDUP REPUBLIK INDONESIA NOMOR 5 TAHUN 2014 TENTANG BAKU MUTU AIR LIMBAH','/storage/produk_hukum/79E54kmAqFE0DYA4BuxUxhRMZCqbaDkV0eJQEqJj.pdf','2023-09-13 15:13:17','2023-09-13 15:13:17'),
(9,'103d31d8-a216-4e5f-a967-f733c7312f24',2,'PERATURAN MENTERI LINGKUNGAN HIDUP DAN KEHUTANAN REPUBLIK INDONESIA NOMOR: P.68/Menlhk/Setjen/Kum.1/8/2016','/storage/produk_hukum/QlQ9BXq4VAsollrzqUDIStCas8KD61xBomHl1Vvg.pdf','2023-09-13 15:13:17','2023-09-13 15:13:17'),
(10,'95632eec-d720-4105-846e-20835dfa594f',2,'PERATURAN MENTERI LINGKUNGAN HIDUP DAN KEHUTANAN REPUBLIK INDONESIA NOMOR P.59/Menlhk/Setjen/Kum.1/7/2016 Tentang Baku Mutu Lindi Bagi Usaha dan/atau Kegiatan Tempat Pemrosesan Akhir Sampah','/storage/produk_hukum/kwVYzrsFteDLHGmBK4WTsvR24H5RLjcjIRYwzSej.pdf','2023-09-13 15:13:17','2023-09-13 15:13:17'),
(11,'cf4485ee-6bb6-431a-8813-db6f62c203be',2,'PERATURAN MENTERI KESEHATAN REPUBLIK INDONESIA NOMOR 2 TAHUN 2023 TENTANG PERATURAN PELAKSANAAN PERATURAN PEMERINTAH NOMOR 66 TAHUN 2014 TENTANG KESEHATAN LINGKUNGAN','/storage/produk_hukum/DQIh2EVOCusRVHGoKDP6ImvyxjdgMhtpP6ShnWAl.pdf','2023-09-13 15:13:17','2023-09-13 15:13:17'),
(12,'4bb85e24-0aaf-48a3-8aed-8549eaaa5984',4,'PERATURAN GUBERNUR JAWA TIMUR NOMOR 72 TAHUN 2013 TENTANG BAKU MUTU AIR LIMBAH BAGI INDUSTRI DAN/ATAU KEGIATAN USAHA LAINNYA','/storage/produk_hukum/hT8k1NoSDwzlJqlRhJso2RNyNVXaPYbBSeEDVSbY.pdf','2023-09-13 15:16:52','2023-09-13 15:16:52'),
(13,'0b40eefc-d262-4df6-b1e8-73f09b99b344',4,'PERATURAN GUBERNUR JAWA TIMUR NOMOR 52 TAHUN 2014 TENTANG PERUBAHAN ATAS PERATURAN GUBERNUR JAWA TIMUR NOMOR 72 TAHUN 2013 TENTANG BAKU MUTU AIR LIMBAH BAGI INDUSTRI DAN/ATAU KEGIATAN USAHA LAINNYA','/storage/produk_hukum/K4rlHPomrCvwfv7px91Cu2IUKTvb5nWdmBwY9nXS.pdf','2023-09-13 15:16:52','2023-09-13 15:16:52');

/*Table structure for table `produk_hukums` */

DROP TABLE IF EXISTS `produk_hukums`;

CREATE TABLE `produk_hukums` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `produk_hukums_uuid_unique` (`uuid`),
  UNIQUE KEY `produk_hukums_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `produk_hukums` */

insert  into `produk_hukums`(`id`,`uuid`,`nama`,`slug`,`deskripsi`,`created_at`,`updated_at`) values 
(2,'00860329-262c-4de3-a653-7aa4dd66dcbe','PERATURAN MENTERI REPUBLIK INDONESIA','peraturan-menteri-republik-indonesia','<p>KUMPULAN PERATURAN MENTERI REPUBLIK INDONESIA&nbsp;</p>','2023-09-13 11:07:59','2023-09-13 11:09:47'),
(4,'c81fcd9c-0ef4-4625-9cbf-0850a658ad33','PERATURAN GUBERNUR','peraturan-gubernur',NULL,'2023-09-13 15:16:52','2023-09-13 15:16:52');

/*Table structure for table `radius_pengambilans` */

DROP TABLE IF EXISTS `radius_pengambilans`;

CREATE TABLE `radius_pengambilans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `radius` int NOT NULL COMMENT 'dalam meter',
  `harga` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `radius_pengambilans_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `radius_pengambilans` */

insert  into `radius_pengambilans`(`id`,`uuid`,`nama`,`radius`,`harga`,`created_at`,`updated_at`) values 
(1,'0506bded-a9bc-4e22-8cd8-48dcd5cba4ad','-',0,0,'2023-09-01 15:20:03','2023-09-01 15:20:03');

/*Table structure for table `role_has_permissions` */

DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_has_permissions` */

insert  into `role_has_permissions`(`permission_id`,`role_id`) values 
(1,1),
(2,1),
(3,1),
(4,1),
(5,1),
(7,1),
(10,1),
(11,1),
(12,1),
(13,1),
(14,1),
(15,1),
(16,1),
(17,1),
(18,1),
(19,1),
(20,1),
(21,1),
(22,1),
(23,1),
(24,1),
(25,1),
(26,1),
(27,1),
(28,1),
(32,1),
(33,1),
(34,1),
(35,1),
(36,1),
(37,1),
(38,1),
(39,1),
(40,1),
(41,1),
(42,1),
(43,1),
(44,1),
(45,1),
(46,1),
(47,1),
(48,1),
(49,1),
(50,1),
(53,1),
(1,2),
(2,2),
(7,2),
(10,2),
(22,2),
(24,2),
(28,2),
(38,2),
(39,2),
(40,2),
(46,2),
(50,2),
(1,3),
(2,3),
(7,3),
(22,3),
(24,3),
(28,3),
(32,3),
(33,3),
(38,3),
(39,3),
(40,3),
(46,3),
(50,3),
(1,4),
(2,4),
(3,4),
(4,4),
(22,4),
(24,4),
(28,4),
(34,4),
(35,4),
(38,4),
(39,4),
(50,4),
(53,4),
(1,5),
(2,5),
(7,5),
(32,5),
(1,6),
(2,6),
(3,6),
(5,6),
(1,7),
(2,7),
(29,7),
(30,7),
(51,7),
(52,7);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`guard_name`,`full_name`,`created_at`,`updated_at`) values 
(1,'admin','api','Administrator','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(2,'kepala-upt','api','Kepala UPT. Laboratorium Lingkungan','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(3,'koordinator-teknis','api','Koordinator Teknis','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(4,'koordinator-administrasi','api','Koordinator Administrasi','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(5,'analis','api','Analis','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(6,'pengambil-sample','api','Petugas Pengambil Sample','2023-08-09 08:39:13','2023-08-09 08:39:13'),
(7,'customer','api','Customer','2023-08-09 08:39:13','2023-08-09 08:39:13');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_depan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_dalam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg_auth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kop_app` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kop_sni` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dinas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pemerintah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `settings` */

insert  into `settings`(`id`,`uuid`,`app`,`description`,`logo_depan`,`logo_dalam`,`banner`,`bg_auth`,`kop_app`,`kop_sni`,`dinas`,`pemerintah`,`alamat`,`telepon`,`email`,`created_at`,`updated_at`) values 
(1,'7544570a-9735-4349-8a7c-6e74683e9834','SI-LAJANG v.3','Sistem Informasi Laboratorium Lingkungan Jombang','/storage/setting/alNj5p2aV0hs1ivu7ZoXZMvrQivr5F93ZWkuGIno.png','/storage/setting/9IhMysjVi2KjKI6FJKNYbbEEzkcJXHUM8on1yE7U.png','/storage/setting/II0rdJRqXna0AAttcKv5LZlmsY4sLuaUwPVStwUY.png','/storage/setting/gcWgRSdtDSyndw4fGZ3trhLYof2ZMoNHGnRnLrHm.png','/storage/setting/HuZM0Wlw7pr1FPHEclCReqfyI4yEQpdfqR3yZiLX.png','/storage/setting/JzGJVto2j7itJzGjUToBrYYPvZbU8Jt175PS4aAY.png','DINAS LINGKUNGAN HIDUP UPT LABORATORIUM LINGKUNGAN HIDUP','PEMERINTAH KABUPATEN JOMBANG','Jl. KH.  ABDURRACHMAN WACHID NO. 132, DESA CANDI MULYO, JOMBANG 61413','(0321) 8494980','upt.lablingkungan@jombangkab.go.id','2023-08-09 08:39:12','2023-09-13 10:27:47');

/*Table structure for table `tanda_tangans` */

DROP TABLE IF EXISTS `tanda_tangans`;

CREATE TABLE `tanda_tangans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bagian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tanda_tangans_uuid_unique` (`uuid`),
  KEY `tanda_tangans_user_id_foreign` (`user_id`),
  CONSTRAINT `tanda_tangans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tanda_tangans` */

insert  into `tanda_tangans`(`id`,`uuid`,`bagian`,`created_at`,`updated_at`,`user_id`) values 
(1,'66f2650e-4826-4f1a-a83e-e270962e2bfa','Kendali Mutu','2023-08-29 11:19:33','2023-08-29 11:19:33',2),
(2,'d5b3099d-4031-4272-95d7-b11d5327eb59','Lembar Hasil Uji','2023-08-29 11:19:33','2023-08-29 11:19:33',2),
(3,'d6e56b83-88b6-489e-98f0-95a74f41d7cf','SPP','2023-08-29 11:19:33','2023-08-29 11:19:33',3),
(4,'f7004f53-a148-48e1-9a76-76787c4e103d','RDPS','2023-08-29 11:19:33','2023-08-29 11:19:33',3),
(5,'9c5a5b30-8279-484e-ac04-d3e6c5b81fe6','Pembayaran','2023-08-29 11:19:33','2023-08-29 11:19:33',4),
(6,'ccf11013-7ecd-47a5-a81e-445a744149b0','Pengambilan Sampel (Koordinator Administrasi)','2023-08-29 11:19:33','2023-08-29 11:19:33',4),
(7,'949f451b-b68a-44eb-a1cc-8a497676cb91','Pengambilan Sampel (Koordinator Teknis)','2023-08-29 11:19:33','2023-08-29 11:19:33',3);

/*Table structure for table `titik_permohonan_lapangans` */

DROP TABLE IF EXISTS `titik_permohonan_lapangans`;

CREATE TABLE `titik_permohonan_lapangans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titik_permohonan_id` bigint unsigned NOT NULL,
  `suhu_air` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ph` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dhl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salinitas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `do` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kekeruhan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `klorin_bebas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suhu_udara` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelembapan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cuaca` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecepatan_angin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arah_angin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titik_permohonan_lapangans_uuid_unique` (`uuid`),
  KEY `titik_permohonan_lapangans_titik_permohonan_id_foreign` (`titik_permohonan_id`),
  CONSTRAINT `titik_permohonan_lapangans_titik_permohonan_id_foreign` FOREIGN KEY (`titik_permohonan_id`) REFERENCES `titik_permohonans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `titik_permohonan_lapangans` */

insert  into `titik_permohonan_lapangans`(`id`,`uuid`,`titik_permohonan_id`,`suhu_air`,`ph`,`dhl`,`salinitas`,`do`,`kekeruhan`,`klorin_bebas`,`suhu_udara`,`kelembapan`,`cuaca`,`kecepatan_angin`,`arah_angin`,`created_at`,`updated_at`) values 
(1,'fabb865d-fcd7-4e54-9115-7395001bdbbe',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-08-29 05:52:14','2023-08-29 05:52:14'),
(2,'7c506a35-791f-4907-a615-89f8dbd6b80d',2,'29,3','7,0',NULL,NULL,NULL,NULL,NULL,'30,2',NULL,NULL,NULL,NULL,'2023-09-04 08:40:31','2023-09-08 15:15:33'),
(3,'56fc5d83-2a55-4892-b776-0bc3f4007e88',5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-09-13 11:00:21','2023-09-13 11:00:21'),
(4,'02ef22fa-f3ee-4a9d-bfda-ad3ea4d8af84',6,'31','6,7','-','-','5','-','0,03',NULL,NULL,NULL,NULL,NULL,'2023-09-13 11:14:37','2023-09-13 13:51:12'),
(5,'af5a16da-52aa-4ae4-9c75-84d6631a92fc',7,'31','7','-','-','5','-','-',NULL,NULL,NULL,NULL,NULL,'2023-09-13 11:59:17','2023-09-13 13:51:52'),
(6,'a326e6b2-9121-4567-b54d-6371ac69991e',10,'28.6','7.38',NULL,NULL,NULL,NULL,NULL,'29.8','60.33','cerah',NULL,NULL,'2023-09-18 12:16:20','2023-09-18 13:08:17'),
(7,'d2f66d1a-7ba7-4859-8d26-f98e55d0e119',11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-09-18 13:11:41','2023-09-22 09:34:39'),
(8,'94fc8637-9af0-44a0-8e67-e49fad6f310d',13,'30','4','3','0','5','2','3','28','60','0','0','0','2023-09-22 06:05:05','2023-09-22 09:28:16');

/*Table structure for table `titik_permohonan_parameters` */

DROP TABLE IF EXISTS `titik_permohonan_parameters`;

CREATE TABLE `titik_permohonan_parameters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `titik_permohonan_id` bigint unsigned NOT NULL,
  `parameter_id` bigint unsigned NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `baku_mutu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mdl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hasil_uji` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hasil_uji_pembulatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_hasil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kuantitas` int NOT NULL,
  `acc_analis` tinyint(1) NOT NULL DEFAULT '0',
  `acc_analis_at` datetime DEFAULT NULL,
  `acc_manager` tinyint(1) NOT NULL DEFAULT '0',
  `acc_manager_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `personel` tinyint(1) DEFAULT NULL,
  `metode` tinyint(1) DEFAULT NULL,
  `peralatan` tinyint(1) DEFAULT NULL,
  `reagen` tinyint(1) DEFAULT NULL,
  `akomodasi` tinyint(1) DEFAULT NULL,
  `beban_kerja` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `titik_permohonan_parameters_titik_permohonan_id_foreign` (`titik_permohonan_id`),
  KEY `titik_permohonan_parameters_parameter_id_foreign` (`parameter_id`),
  CONSTRAINT `titik_permohonan_parameters_parameter_id_foreign` FOREIGN KEY (`parameter_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `titik_permohonan_parameters_titik_permohonan_id_foreign` FOREIGN KEY (`titik_permohonan_id`) REFERENCES `titik_permohonans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `titik_permohonan_parameters` */

insert  into `titik_permohonan_parameters`(`id`,`titik_permohonan_id`,`parameter_id`,`harga`,`satuan`,`baku_mutu`,`mdl`,`hasil_uji`,`hasil_uji_pembulatan`,`keterangan`,`keterangan_hasil`,`kuantitas`,`acc_analis`,`acc_analis_at`,`acc_manager`,`acc_manager_at`,`created_at`,`updated_at`,`personel`,`metode`,`peralatan`,`reagen`,`akomodasi`,`beban_kerja`) values 
(9,1,6,'80000','mg/L','-','0,000023','12',NULL,NULL,NULL,1,1,'2023-08-25 14:58:54',1,'2023-08-25 15:01:20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(10,1,5,'102000','-','-','12','32',NULL,NULL,NULL,1,1,'2023-08-25 14:59:01',1,'2023-08-25 15:02:20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(11,1,2,'25000','mg/L','12','-','56',NULL,NULL,NULL,1,1,'2023-08-25 14:59:18',1,'2023-08-25 15:02:26',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(12,1,20,'74000','-','-','3','12.1',NULL,NULL,NULL,1,1,'2023-08-25 15:26:20',1,'2023-08-25 15:26:41',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(13,2,4,'15000','-','6-9','0','1','1','-','Tidak Memenuhi',1,1,'2023-09-08 14:47:59',1,'2023-09-05 15:53:54',NULL,NULL,1,1,1,1,1,NULL),
(14,2,6,'80000','mg/L','maks 30','0','25','25','-','Memenuhi',1,1,'2023-09-08 14:43:54',1,'2023-09-04 09:56:59',NULL,NULL,1,1,1,1,1,NULL),
(15,2,51,'102000','mg/L','maks 100','1.9526','21','21','-','Memenuhi',1,1,'2023-09-08 14:43:57',1,'2023-09-04 09:57:08',NULL,NULL,1,1,1,1,1,NULL),
(16,2,2,'25000','mg/L','maks 30','0','10','10','-','Memenuhi',1,1,'2023-09-08 14:44:18',1,'2023-09-04 09:57:11',NULL,NULL,1,1,1,1,1,NULL),
(17,2,12,'40000','mg/L','maks 10','0.031','1','1','-','Memenuhi',1,1,'2023-09-08 14:44:16',1,'2023-09-14 13:10:22',NULL,NULL,1,1,1,1,1,NULL),
(18,2,20,'74000','mg/L','maks 10','0','5','5','-','Memenuhi',1,1,'2023-09-08 14:44:14',1,'2023-09-14 13:10:24',NULL,NULL,1,1,1,1,1,NULL),
(19,2,18,'77000','CFU/100 mL','maks 3000','0','100','100','-','Memenuhi',1,1,'2023-09-08 14:44:20',1,'2023-09-14 13:10:17',NULL,NULL,1,1,1,1,1,NULL),
(34,4,2,'25000','mg/L','Maks 100','1','87','87',NULL,'Tidak Memenuhi',1,1,'2023-09-08 14:55:39',1,'2023-09-08 15:25:12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(35,4,4,'15000','-','6-9','10','1','1',NULL,'Memenuhi',1,1,'2023-09-08 14:55:20',1,'2023-09-08 15:33:18',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(36,4,12,'40000','mg/L','Maks 10','0.031','8','8',NULL,'Memenuhi',1,1,'2023-09-08 14:55:47',1,'2023-09-08 15:26:40',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(37,4,6,'80000','mg/L','Maks 60','10','40','40',NULL,'Memenuhi',1,1,'2023-09-08 14:55:29',1,'2023-09-08 15:33:20',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(38,4,51,'102000','mg/L','Maks 120','1.9526','100','100',NULL,'Memenuhi',1,1,'2023-09-08 14:55:50',1,'2023-09-08 15:33:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(39,4,32,'89000','mg/L','Maks 0,5','1','0,3','0,3',NULL,'Memenuhi',1,1,'2023-09-08 14:56:08',1,'2023-09-08 15:33:37',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(40,4,20,'74000','mg/L','Maks 5','0','4','4',NULL,'Memenuhi',1,1,'2023-09-08 14:56:11',1,'2023-09-08 15:33:23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(41,6,4,'15000',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(42,6,6,'80000','mg/L',NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(43,6,51,'102000','mg/L',NULL,'1.9526',NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(44,6,2,'25000','mg/L',NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(45,6,13,'51000','mg/L',NULL,'0.0003',NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(46,6,21,'89000','mg/L',NULL,'0.0657',NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(47,7,4,'15000','-','6-9','0','7','7',NULL,'Memenuhi',1,1,'2023-09-13 13:53:31',1,'2023-09-13 14:00:36',NULL,NULL,1,1,1,1,1,NULL),
(48,7,6,'80000','mg/L','30','0','10','10',NULL,'Memenuhi',1,1,'2023-09-13 13:53:46',1,'2023-09-13 14:00:31',NULL,NULL,1,1,1,1,1,NULL),
(49,7,51,'102000','mg/L','100','1.9526','25','25',NULL,'Memenuhi',1,1,'2023-09-13 13:54:28',1,'2023-09-13 14:00:39',NULL,NULL,1,1,1,1,1,NULL),
(50,7,2,'25000','mg/L','30','0','21','21',NULL,'Memenuhi',1,1,'2023-09-13 13:54:38',1,'2023-09-13 13:59:22',NULL,NULL,1,1,1,1,1,NULL),
(51,7,12,'40000','mg/L','30','0.031','15','15',NULL,'Memenuhi',1,1,'2023-09-13 13:55:18',1,'2023-09-13 13:59:33',NULL,NULL,1,1,1,1,1,NULL),
(52,7,20,'74000','mg/L','5','0','4,3','4,3',NULL,'Memenuhi',1,1,'2023-09-13 13:55:33',1,'2023-09-13 13:59:47',NULL,NULL,1,1,1,1,1,NULL),
(53,7,18,'77000','CFU/100 mL','3000','0','1000','1000',NULL,'Memenuhi',1,1,'2023-09-13 13:55:42',1,'2023-09-13 14:00:45',NULL,NULL,1,1,1,1,1,NULL),
(54,9,4,'15000','-','-','-','7.68','7.68',NULL,'Memenuhi',1,1,'2023-09-18 11:32:47',1,'2023-09-18 11:36:08',NULL,NULL,1,1,1,1,1,0),
(55,9,6,'80000','mg/L','-','0','10.123','10.123',NULL,'Memenuhi',1,1,'2023-09-18 11:31:54',1,'2023-09-18 11:36:11',NULL,NULL,1,1,1,1,1,0),
(56,9,51,'102000','mg/L','-','1.9526','30.698','30.698',NULL,'Memenuhi',1,1,'2023-09-18 11:25:05',1,'2023-09-18 11:36:15',NULL,NULL,1,1,1,1,1,0),
(57,9,2,'25000','mg/L','-','0','7.5','7.5',NULL,'Memenuhi',1,1,'2023-09-18 11:30:32',1,'2023-09-18 11:36:30',NULL,NULL,1,1,1,1,1,0),
(58,9,12,'40000','mg/L','-','0.031','0.532','0.532',NULL,'Memenuhi',1,1,'2023-09-18 11:24:58',1,'2023-09-18 11:37:07',NULL,NULL,1,1,1,1,1,NULL),
(59,9,20,'74000','mg/L','-','0.8','3.667','3.667',NULL,'Memenuhi',1,1,'2023-09-18 11:33:32',1,'2023-09-18 11:37:15',NULL,NULL,1,1,1,1,1,NULL),
(60,9,18,'77000','CFU/100 mL','-','0','3800','3800',NULL,'Tidak Memenuhi',1,1,'2023-09-18 11:30:45',1,'2023-09-18 11:37:30',NULL,NULL,1,1,1,1,1,NULL),
(61,10,4,'15000','-','-','0','7.38','7.38',NULL,'Memenuhi',1,1,'2023-09-18 12:34:02',1,'2023-09-18 12:36:56',NULL,NULL,1,1,1,1,1,NULL),
(62,10,6,'80000','mg/L','-','0','20.123','20.123',NULL,'Memenuhi',1,1,'2023-09-18 12:35:27',1,'2023-09-18 12:37:01',NULL,NULL,1,1,1,1,1,NULL),
(63,10,51,'102000','mg/L','-','1.9526','50.321','50.321',NULL,'Memenuhi',1,1,'2023-09-18 12:35:42',1,'2023-09-18 12:37:07',NULL,NULL,1,1,1,1,1,NULL),
(64,10,2,'25000','mg/L','-','-','117','117',NULL,'Tidak Memenuhi',1,1,'2023-09-18 12:35:48',1,'2023-09-18 12:37:20',NULL,NULL,1,1,1,1,1,NULL),
(65,10,20,'74000','mg/L','-','0','7.667','7.7',NULL,'Memenuhi',1,1,'2023-09-18 12:35:56',1,'2023-09-18 12:37:35',NULL,NULL,1,1,1,1,1,NULL),
(66,10,8,'52000','mg/L','-','0.05652','-0.0021','<0.05652',NULL,'Memenuhi',1,1,'2023-09-18 12:33:17',1,'2023-09-18 12:38:06',NULL,NULL,1,1,1,1,1,NULL),
(67,10,9,'52000','mg/L','-','0.1383','0.321','0.321',NULL,'Memenuhi',1,1,'2023-09-18 12:31:59',1,'2023-09-18 12:38:14',NULL,NULL,1,1,1,1,1,NULL),
(68,10,10,'52000','mg/L','-','0','0.005','0.005',NULL,'Memenuhi',1,1,'2023-09-18 12:32:10',1,'2023-09-18 12:38:23',NULL,NULL,1,1,1,1,1,NULL),
(69,11,13,'51000','mg/L',NULL,'0.0003',NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(70,11,31,'102000','mg/L',NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(71,12,2,'25000','mg/L','Maks 100','-','120','120',NULL,'Tidak Memenuhi',1,1,'2023-09-21 15:12:46',1,'2023-09-21 15:24:41',NULL,NULL,1,1,1,1,1,0),
(72,12,4,'15000','-','6-9','-','8','8',NULL,'Memenuhi',1,1,'2023-09-21 15:12:41',1,'2023-09-21 15:24:44',NULL,NULL,1,1,1,1,1,0),
(73,12,12,'40000','mg/L','Maks 10','0.031','7','7',NULL,'Memenuhi',1,1,'2023-09-21 15:12:35',1,'2023-09-21 15:24:46',NULL,NULL,1,1,1,1,1,0),
(74,12,6,'80000','mg/L','Maks 60','0','60','60',NULL,'Memenuhi',1,1,'2023-09-21 15:11:58',1,'2023-09-21 15:24:49',NULL,NULL,1,1,1,1,1,0),
(75,12,51,'102000','mg/L','Maks 120','1.9526','110','110',NULL,'Memenuhi',1,1,'2023-09-21 15:12:03',1,'2023-09-21 15:24:50',NULL,NULL,1,1,1,1,1,0),
(76,12,32,'89000','mg/L','Maks 0,5','0','<0,05','<0,05',NULL,'Memenuhi',1,1,'2023-09-21 15:12:23',1,'2023-09-21 15:24:52',NULL,NULL,1,1,1,1,1,0),
(77,12,20,'74000','mg/L','Maks 5','0','4','4',NULL,'Memenuhi',1,1,'2023-09-21 15:12:54',1,'2023-09-21 15:25:17',NULL,NULL,1,1,1,1,1,0),
(85,13,4,'15000','-',NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,'2023-09-22 06:05:05',1,1,1,1,1,0),
(86,13,6,'80000','mg/L',NULL,'0',NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,1,1,1,1,1,0),
(87,13,51,'102000','mg/L',NULL,'1.9526',NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,1,1,1,1,1,0),
(88,13,2,'25000','mg/L',NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(89,13,12,'40000','mg/L',NULL,'0.031',NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,1,1,1,1,1,0),
(90,13,20,'74000','mg/L',NULL,'0',NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,1,1,1,1,1,0),
(91,13,18,'77000','CFU/100 mL',NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,0,NULL,NULL,NULL,1,1,1,1,1,0),
(92,14,4,'15000','-','25','0','7','7',NULL,'Memenuhi',1,1,'2023-09-22 10:19:45',1,'2023-09-22 10:21:30',NULL,NULL,1,1,1,1,1,1),
(93,14,6,'80000','mg/L','-','0','25','25',NULL,'Memenuhi',1,1,'2023-09-22 10:19:52',1,'2023-09-22 10:21:35',NULL,NULL,1,1,1,1,1,1),
(94,14,51,'102000','mg/L','12','1.9526','23','23',NULL,'Tidak Memenuhi',1,1,'2023-09-22 10:20:12',1,'2023-09-22 10:21:45',NULL,NULL,1,1,1,1,1,1),
(95,14,2,'25000','mg/L','-','0','14','14',NULL,'Memenuhi',1,1,'2023-09-22 10:20:23',1,'2023-09-22 10:21:55',NULL,NULL,1,1,1,1,1,1),
(96,14,12,'40000','mg/L','-','0.031','15','15',NULL,'Memenuhi',1,1,'2023-09-22 10:20:31',1,'2023-09-22 10:22:01',NULL,NULL,1,1,1,1,1,1),
(97,14,20,'74000','mg/L','-','0','22','22',NULL,'Memenuhi',1,1,'2023-09-22 10:20:33',1,'2023-09-22 10:22:05',NULL,NULL,1,1,1,1,1,1),
(98,14,18,'77000','CFU/100 mL','-','0','34','34',NULL,'Memenuhi',1,1,'2023-09-22 10:20:36',1,'2023-09-22 10:22:12',NULL,NULL,1,1,1,1,1,1);

/*Table structure for table `titik_permohonans` */

DROP TABLE IF EXISTS `titik_permohonans`;

CREATE TABLE `titik_permohonans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_lhu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_formulir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `south` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `east` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permohonan_id` bigint unsigned NOT NULL,
  `jenis_sampel_id` bigint unsigned NOT NULL,
  `jenis_wadah_id` bigint unsigned NOT NULL,
  `peraturan_id` bigint unsigned DEFAULT NULL,
  `pengambil_id` bigint unsigned DEFAULT NULL,
  `nama_pengambil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_pengambilan` datetime DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `keterangan_revisi` text COLLATE utf8mb4_unicode_ci,
  `status_pembayaran` int NOT NULL DEFAULT '0',
  `sertifikat` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal_diterima` datetime DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `acuan_metode_id` bigint unsigned DEFAULT NULL,
  `hasil_pengujian` tinyint(1) DEFAULT NULL,
  `kesimpulan_permohonan` tinyint(1) DEFAULT NULL COMMENT 'Diterima atau ditolak',
  `lab_subkontrak` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kesimpulan_sampel` tinyint(1) DEFAULT NULL COMMENT 'Diterima atau ditolak',
  `kondisi_sampel` tinyint(1) DEFAULT NULL COMMENT 'Normal atau abnormal',
  `keterangan_kondisi_sampel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Keterangan kondisi sampel, jelaskan...',
  `pengawetan_oleh` enum('Pelanggan','Laboratorium') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obyek_pelayanan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titik_permohonans_uuid_unique` (`uuid`),
  KEY `titik_permohonans_permohonan_id_foreign` (`permohonan_id`),
  KEY `titik_permohonans_jenis_sampel_id_foreign` (`jenis_sampel_id`),
  KEY `titik_permohonans_jenis_wadah_id_foreign` (`jenis_wadah_id`),
  KEY `titik_permohonans_peraturan_id_foreign` (`peraturan_id`),
  KEY `titik_permohonans_pengambil_id_foreign` (`pengambil_id`),
  KEY `titik_permohonans_acuan_metode_id_foreign` (`acuan_metode_id`),
  CONSTRAINT `titik_permohonans_acuan_metode_id_foreign` FOREIGN KEY (`acuan_metode_id`) REFERENCES `acuan_metodes` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `titik_permohonans_jenis_sampel_id_foreign` FOREIGN KEY (`jenis_sampel_id`) REFERENCES `jenis_sampels` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `titik_permohonans_jenis_wadah_id_foreign` FOREIGN KEY (`jenis_wadah_id`) REFERENCES `jenis_wadahs` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `titik_permohonans_pengambil_id_foreign` FOREIGN KEY (`pengambil_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `titik_permohonans_peraturan_id_foreign` FOREIGN KEY (`peraturan_id`) REFERENCES `peraturans` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `titik_permohonans_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonans` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `titik_permohonans` */

insert  into `titik_permohonans`(`id`,`uuid`,`kode`,`no_lhu`,`no_formulir`,`lokasi`,`south`,`east`,`keterangan`,`permohonan_id`,`jenis_sampel_id`,`jenis_wadah_id`,`peraturan_id`,`pengambil_id`,`nama_pengambil`,`tanggal_pengambilan`,`status`,`keterangan_revisi`,`status_pembayaran`,`sertifikat`,`tanggal_diterima`,`tanggal_selesai`,`created_at`,`updated_at`,`acuan_metode_id`,`hasil_pengujian`,`kesimpulan_permohonan`,`lab_subkontrak`,`kesimpulan_sampel`,`kondisi_sampel`,`keterangan_kondisi_sampel`,`pengawetan_oleh`,`obyek_pelayanan`) values 
(1,'e0141052-e716-47dd-9964-5f1dfe5dafa6','KJB-2309-04/1','001/AL/415.34.1/VIII/2023','004/SPP/IX/2023','Gresik','0','9',NULL,1,1,1,NULL,NULL,'Ozi','2023-08-01 12:00:00',3,NULL,0,0,'2023-09-13 11:38:12','2023-10-03 11:38:12','2023-08-25 14:49:26','2023-09-13 11:38:12',1,NULL,NULL,NULL,1,0,NULL,'Pelanggan',NULL),
(2,'ed05fca1-7626-49a9-91e6-18569745ad4d','KJB-2309-05/1','002/AL/415.34.1/IX/2023','001/SPP/IX/2023','outlet IPAL','7°16\'28.4\"S','112°39\'9.8\"N',NULL,2,1,1,31,8,NULL,'2023-09-04 11:00:00',7,NULL,0,0,'2023-09-05 16:00:48','2023-09-25 16:00:48','2023-09-04 08:38:03','2023-09-14 13:10:17',1,1,1,NULL,1,1,NULL,'Laboratorium',NULL),
(4,'83daf7f4-bd6e-4f77-beb4-587389a590d4','KJB-2309-06/1','003/AL/415.34.1/IX/2023','002/SPP/IX/2023','mti','7°16\'30.4\"S','112°39\'6.4\"N','-',3,1,2,32,NULL,'aang','2023-09-01 12:00:00',11,NULL,1,0,'2023-09-08 14:52:51','2023-09-28 14:52:51','2023-09-08 13:48:50','2023-09-08 15:54:45',1,NULL,NULL,NULL,1,1,NULL,'Laboratorium',NULL),
(5,'1ac2a615-3bf0-4b13-9894-74255448cb6b','(Belum Ditetapkan)','(Belum Ditetapkan)','(Belum Ditetapkan)','Kjb labling',NULL,NULL,NULL,5,2,1,NULL,NULL,NULL,NULL,0,NULL,0,0,NULL,NULL,'2023-09-13 10:59:06','2023-09-13 10:59:06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(6,'17018667-35ee-4f5c-9ad7-fb468ae2f950','KJB-2309-07/1','(Belum Ditetapkan)','003/SPP/IX/2023','Jbg','7°32\'48.6\"S','112°13\'39.2\"N','-',6,2,1,29,NULL,NULL,'2023-09-13 12:00:00',3,NULL,0,0,'2023-09-21 14:21:23','2023-10-11 14:21:23','2023-09-13 11:13:38','2023-09-21 14:21:23',1,1,1,NULL,1,1,NULL,'Laboratorium',NULL),
(7,'e8b436e7-c76f-4a30-ac36-e0477e60be46','KJB-2309-08/1','004/AL/415.34.1/IX/2023','005/SPP/IX/2023','IPAL','7°32\'48.6\"S','112°13\'39.2\"N',NULL,7,1,1,31,NULL,NULL,'2023-09-13 17:00:00',8,NULL,0,0,'2023-09-13 13:52:38','2023-10-03 13:52:38','2023-09-13 11:51:47','2023-09-13 14:04:33',1,1,1,NULL,1,1,NULL,'Laboratorium',NULL),
(8,'b53da3a3-0e5c-4ae6-8451-dacba3e51fef','(Belum Ditetapkan)','(Belum Ditetapkan)','(Belum Ditetapkan)','IPAL OUTLET',NULL,NULL,NULL,8,1,1,NULL,NULL,NULL,NULL,0,NULL,0,0,NULL,NULL,'2023-09-13 14:33:49','2023-09-13 14:33:49',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(9,'6ad9340e-4375-49a1-b6ef-9ae270ef90a0','KJB-2309-09/1','005/AL/415.34.1/IX/2023','006/SPP/IX/2023','saluran pembuangan','7°32\'17.1\"S','112°14\'25.8\"N','-',9,1,3,31,NULL,'ayunia','2023-09-04 10:05:00',7,NULL,1,0,'2023-09-18 11:09:44','2023-10-06 11:09:44','2023-09-18 10:59:17','2023-09-21 09:40:40',1,NULL,NULL,NULL,1,0,'sampel di antar oleh pelanggan','Laboratorium',NULL),
(10,'fc3bd69e-6043-459a-a42b-9704f05dc6d0','KJB-2309-10/1','006/AL/415.34.1/IX/2023','007/SPP/IX/2023','outlet IPAL','7°32\'17.7\"S','112°14\'26.0\"N','-',10,1,2,28,NULL,NULL,'2023-09-18 12:00:00',11,NULL,1,2,'2023-09-18 12:29:28','2023-10-06 12:29:28','2023-09-18 12:15:29','2023-09-21 15:53:28',1,1,1,NULL,1,1,NULL,'Laboratorium',NULL),
(11,'9d1ad489-86be-4d3f-9a86-931e0567707a','(Belum Ditetapkan)','(Belum Ditetapkan)','(Belum Ditetapkan)','Dam Ngumpul',NULL,NULL,'-',11,2,2,NULL,NULL,NULL,NULL,0,NULL,0,0,NULL,NULL,'2023-09-18 13:10:55','2023-09-18 13:22:58',NULL,1,1,NULL,NULL,NULL,NULL,NULL,NULL),
(12,'fff6d72b-a536-44f4-a68a-75c7cf2d98cd','KJB-2309-11/1','007/AS/415.34.1/IX/2023','008/SPP/IX/2023','bungkal','7°16\'30.5\"S','112°39\'6.6\"N','-',13,2,1,32,NULL,'Aang Kurniawan','2023-09-21 12:00:00',9,NULL,1,0,'2023-09-21 14:21:44','2023-10-11 14:21:44','2023-09-21 11:39:43','2023-09-21 16:00:58',1,NULL,NULL,NULL,1,1,NULL,'Laboratorium',NULL),
(13,'1a5eed3a-215f-4aeb-95be-294d44714502','KJB-2309-12/1','(Belum Ditetapkan)','009/SPP/IX/2023','kabuh','7°16\'30.3\"S','112°39\'6.4\"N','-',14,1,3,31,NULL,NULL,'2023-09-26 12:00:00',1,NULL,0,0,NULL,NULL,'2023-09-22 05:32:53','2023-09-22 09:28:16',1,1,1,NULL,NULL,NULL,NULL,NULL,'-'),
(14,'73c1622b-ffb1-4aa8-90d3-7bb5719dbd39','KJB-2309-13/1','008/AS/415.34.1/IX/2023','010/SPP/IX/2023','Air Sungai','7°32\'16.7\"S','112°14\'25.6\"N',NULL,15,2,1,31,NULL,'AANG KURNIAWAN','2023-09-01 12:00:00',7,NULL,0,0,'2023-09-22 10:10:59','2023-10-12 10:10:59','2023-09-22 10:07:41','2023-09-22 10:22:12',1,NULL,NULL,NULL,1,1,NULL,'Laboratorium',NULL);

/*Table structure for table `tracking_pengujians` */

DROP TABLE IF EXISTS `tracking_pengujians`;

CREATE TABLE `tracking_pengujians` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titik_permohonan_id` bigint unsigned NOT NULL,
  `status` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tracking_pengujians_uuid_unique` (`uuid`),
  KEY `tracking_pengujians_titik_permohonan_id_foreign` (`titik_permohonan_id`),
  CONSTRAINT `tracking_pengujians_titik_permohonan_id_foreign` FOREIGN KEY (`titik_permohonan_id`) REFERENCES `titik_permohonans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tracking_pengujians` */

insert  into `tracking_pengujians`(`id`,`uuid`,`titik_permohonan_id`,`status`,`keterangan`,`created_at`,`updated_at`) values 
(1,'bffc8744-b7bd-42cb-a331-441a04c1820d',1,1,NULL,'2023-08-25 14:49:26','2023-08-25 14:49:26'),
(2,'6e4c20b0-578b-472b-8f90-a29ccccd30fc',1,2,NULL,'2023-08-25 14:53:44','2023-08-25 14:53:44'),
(3,'4f7bbba9-2156-4585-b94c-238a44aa7af9',1,3,NULL,'2023-08-25 14:53:44','2023-08-25 14:53:44'),
(4,'08a60ebd-3ffb-4277-92f1-3543bcf60488',1,4,NULL,'2023-08-25 14:59:23','2023-08-25 14:59:23'),
(5,'0e73346b-5c0f-47db-8a8a-60d1e0ae6baa',1,4,NULL,'2023-08-25 14:59:23','2023-08-25 14:59:23'),
(6,'7fe27903-1bd4-4f3d-9262-ea6bd01de03c',1,5,NULL,'2023-08-25 14:59:23','2023-08-25 14:59:23'),
(7,'8092bb73-2b86-4cea-bab7-3fc200bd84f2',1,5,NULL,'2023-08-25 14:59:23','2023-08-25 14:59:23'),
(8,'d88a36f8-bb4a-4958-a252-be88096b8653',1,6,NULL,'2023-08-25 15:02:34','2023-08-25 15:02:34'),
(9,'37f7eae1-0ad9-47ff-a171-d89b69a6bcc5',1,7,NULL,'2023-08-25 15:02:34','2023-08-25 15:02:34'),
(10,'7890bcbb-7070-43e7-9fb0-63b0c85a114a',1,8,NULL,'2023-08-25 15:05:48','2023-08-25 15:05:48'),
(11,'878268fd-5868-4b33-b167-e855ca102226',1,5,NULL,'2023-08-25 15:26:03','2023-08-25 15:26:03'),
(12,'c335d929-d783-4498-89a1-6194f168f0d4',1,3,NULL,'2023-08-25 15:26:03','2023-08-25 15:26:03'),
(13,'e2c40369-6e92-4cd9-a364-c46d25860564',1,4,NULL,'2023-08-25 15:26:20','2023-08-25 15:26:20'),
(14,'207c530d-e6a6-4a34-b081-39f10a5cda62',1,5,NULL,'2023-08-25 15:26:20','2023-08-25 15:26:20'),
(15,'0535aa17-7af5-4276-8896-4f2aa45dc610',1,6,NULL,'2023-08-25 15:26:41','2023-08-25 15:26:41'),
(16,'25bc1f3b-3d29-4cc9-a50c-7bd98a65a1b6',1,7,NULL,'2023-08-25 15:26:41','2023-08-25 15:26:41'),
(17,'fee13f6b-3d89-4a22-83e9-1ef51ecffa4c',1,1,NULL,'2023-08-26 07:06:06','2023-08-26 07:06:06'),
(18,'78a3ef81-d5ac-4f94-8279-f610820a0939',2,0,NULL,'2023-09-04 08:38:03','2023-09-04 08:38:03'),
(19,'41cf0bbe-0512-4c94-a78a-270917c50b12',2,1,NULL,'2023-09-04 08:43:38','2023-09-04 08:43:38'),
(20,'3aea3417-8dbf-46e6-a7cb-c92d30265852',2,0,NULL,'2023-09-04 08:44:05','2023-09-04 08:44:05'),
(21,'a42b20d7-7b04-4f11-879b-fef44f8360f2',2,1,NULL,'2023-09-04 08:45:21','2023-09-04 08:45:21'),
(22,'1019a8c3-f04d-4c1d-bab2-9da2710040c4',2,0,NULL,'2023-09-04 08:56:39','2023-09-04 08:56:39'),
(23,'af620f64-c0ca-4e66-a417-69356c7f7f11',2,1,NULL,'2023-09-04 08:58:43','2023-09-04 08:58:43'),
(24,'4d12c90c-eee9-42a5-b324-4fba3fa5a0e4',2,2,NULL,'2023-09-04 09:05:58','2023-09-04 09:05:58'),
(25,'7a4f2a53-c858-4ad5-9569-e67d626d4442',2,3,NULL,'2023-09-04 09:05:58','2023-09-04 09:05:58'),
(26,'46b2f312-9fb3-435a-80b5-ba00a782c74c',2,0,NULL,'2023-09-04 09:08:37','2023-09-04 09:08:37'),
(27,'261ab710-61e1-4be1-b179-82aaf8ce3125',2,1,NULL,'2023-09-04 09:09:17','2023-09-04 09:09:17'),
(28,'b7fd7dcb-6545-48d5-ba59-94cedd2669ed',2,0,NULL,'2023-09-04 09:09:45','2023-09-04 09:09:45'),
(29,'31977cf9-34c0-4641-9b66-355c162f427d',2,1,NULL,'2023-09-04 09:10:09','2023-09-04 09:10:09'),
(30,'ddd74a87-8b26-4d31-a0d3-0c076896f6d6',2,2,NULL,'2023-09-04 09:18:45','2023-09-04 09:18:45'),
(31,'0f2421c3-c611-4ec4-8407-d5e7a6fc6ce1',2,3,NULL,'2023-09-04 09:18:45','2023-09-04 09:18:45'),
(32,'559b0246-88d5-4902-aa76-46366b20ff11',2,4,NULL,'2023-09-04 09:50:30','2023-09-04 09:50:30'),
(33,'e5f44f9b-bd1b-4cad-ba7e-d94a3a28f950',2,5,NULL,'2023-09-04 09:50:30','2023-09-04 09:50:30'),
(34,'98c84564-697c-4a74-8d54-e4fdde66b1f3',2,6,NULL,'2023-09-04 09:57:18','2023-09-04 09:57:18'),
(35,'f9c6ff3d-beff-4124-adf7-fd497f81b0fd',2,7,NULL,'2023-09-04 09:57:18','2023-09-04 09:57:18'),
(36,'f7adf5b5-c4b3-451d-af78-a201f64967f0',2,8,NULL,'2023-09-04 10:10:32','2023-09-04 10:10:32'),
(37,'cbcdc99c-76d0-4ac0-b457-8f6a27e1b5fc',2,7,NULL,'2023-09-05 12:00:50','2023-09-05 12:00:50'),
(38,'6fe9656f-817a-4ea3-8944-c35b401a1e78',2,8,NULL,'2023-09-05 12:01:19','2023-09-05 12:01:19'),
(39,'da41f023-2677-46cf-87f5-ba02ea49440f',2,1,NULL,'2023-09-05 15:52:25','2023-09-05 15:52:25'),
(40,'2125831c-8430-4c1c-ab5a-5d74d339b4b6',2,2,NULL,'2023-09-05 15:53:15','2023-09-05 15:53:15'),
(41,'dbb3833a-b6ca-4128-b6f3-8ba0d8e72d09',2,3,NULL,'2023-09-05 15:53:15','2023-09-05 15:53:15'),
(42,'52e30a7b-6fba-4697-8131-99cfdb0d9a2b',2,4,NULL,'2023-09-05 15:53:37','2023-09-05 15:53:37'),
(43,'f485fa01-e11f-4914-b951-a3db86fcb609',2,5,NULL,'2023-09-05 15:53:37','2023-09-05 15:53:37'),
(44,'c17c5e50-4db4-4d61-ae35-ce0f43055e73',2,6,NULL,'2023-09-05 15:53:51','2023-09-05 15:53:51'),
(45,'0c1c2d40-9811-492c-a94c-be285c5b72af',2,7,NULL,'2023-09-05 15:53:51','2023-09-05 15:53:51'),
(46,'6b0cadf4-8088-4b40-a812-20dad8827d7f',2,1,NULL,'2023-09-05 15:55:34','2023-09-05 15:55:34'),
(47,'27bbbc55-65b3-415f-afe2-90402256cce7',2,2,NULL,'2023-09-05 15:55:50','2023-09-05 15:55:50'),
(48,'b0007640-7278-4a47-948f-74408ac03263',2,3,NULL,'2023-09-05 15:55:50','2023-09-05 15:55:50'),
(49,'d16bd237-b1a0-4182-b23b-985195409152',2,1,NULL,'2023-09-05 15:57:44','2023-09-05 15:57:44'),
(50,'9a0f505e-6d49-478e-b14c-6fcbd3cc906f',2,2,NULL,'2023-09-05 16:00:48','2023-09-05 16:00:48'),
(51,'61bf48f6-912a-4c96-9b25-98faf4bbd79f',2,3,NULL,'2023-09-05 16:00:48','2023-09-05 16:00:48'),
(53,'623b4301-1c18-44a9-9539-f700b49fc487',4,1,NULL,'2023-09-08 13:48:50','2023-09-08 13:48:50'),
(54,'3316eac3-ddc5-4fb5-92b0-27c88c2e2de2',2,4,NULL,'2023-09-08 14:43:53','2023-09-08 14:43:53'),
(55,'c075af14-3763-4d14-844b-b6e3a3fd6c56',2,5,NULL,'2023-09-08 14:43:53','2023-09-08 14:43:53'),
(56,'725a5d96-7ba5-4721-ad9f-c2a85fbbf32e',4,2,NULL,'2023-09-08 14:52:55','2023-09-08 14:52:55'),
(57,'5c4ac178-5c94-419c-bfbe-f4d56588e1c7',4,3,NULL,'2023-09-08 14:52:55','2023-09-08 14:52:55'),
(58,'90c4a000-0a0c-48d9-a20d-569f47b1ba28',4,4,NULL,'2023-09-08 14:56:12','2023-09-08 14:56:12'),
(59,'ae7900f1-dac2-4983-9beb-d4003ce509e8',4,5,NULL,'2023-09-08 14:56:12','2023-09-08 14:56:12'),
(60,'818fbba3-082b-4c8e-8674-1a2f33073173',4,6,NULL,'2023-09-08 15:33:37','2023-09-08 15:33:37'),
(61,'2a088648-9ea2-449e-bccf-422ca18dbe2a',4,7,NULL,'2023-09-08 15:33:37','2023-09-08 15:33:37'),
(62,'c86a2515-998d-4a93-8c83-82c5d99012b6',4,8,NULL,'2023-09-08 15:39:21','2023-09-08 15:39:21'),
(63,'4f99c1ed-3d54-43c3-ada1-43c0551cdfdf',4,11,'Selesai','2023-09-08 15:54:45','2023-09-08 15:54:45'),
(64,'ebf4104e-b139-465e-85f5-5338f2fb847d',4,9,NULL,'2023-09-08 15:54:45','2023-09-08 15:54:45'),
(65,'869e2ec4-a769-4e54-8275-d73e05505595',4,11,'Selesai','2023-09-08 15:58:41','2023-09-08 15:58:41'),
(66,'57474f73-25bf-4e89-84d5-3b2109039773',4,11,'Selesai','2023-09-11 11:30:33','2023-09-11 11:30:33'),
(67,'6fe7b2e1-b511-42ff-af01-b607e1654d59',4,11,'Selesai','2023-09-13 09:30:23','2023-09-13 09:30:23'),
(68,'d711c251-15ef-4fc9-8d15-2dcbc026c328',5,0,NULL,'2023-09-13 10:59:06','2023-09-13 10:59:06'),
(69,'f672f029-7012-4f57-a78a-fb2996f3ba4e',6,0,NULL,'2023-09-13 11:13:38','2023-09-13 11:13:38'),
(70,'4ef7aa8b-18e6-42dd-88ec-1c357cbd3f1e',6,1,NULL,'2023-09-13 11:23:11','2023-09-13 11:23:11'),
(71,'0c9e3980-be5d-42c7-9bc4-e752580edfdc',6,0,NULL,'2023-09-13 11:27:19','2023-09-13 11:27:19'),
(72,'640caf84-c94a-404e-9c42-7dfc97e093f7',6,1,NULL,'2023-09-13 11:30:12','2023-09-13 11:30:12'),
(73,'5bcfda18-7d79-48b6-87ff-b3f006233793',6,2,NULL,'2023-09-13 11:37:52','2023-09-13 11:37:52'),
(74,'4487a6e7-5bd6-4128-b710-ed87fc123572',6,3,NULL,'2023-09-13 11:37:52','2023-09-13 11:37:52'),
(75,'9bd30976-9728-4874-ba64-a593d6e96860',1,2,NULL,'2023-09-13 11:38:13','2023-09-13 11:38:13'),
(76,'ac3a11a9-839c-47fe-87ee-06fc9d2924dc',1,3,NULL,'2023-09-13 11:38:13','2023-09-13 11:38:13'),
(77,'2f91cba4-c886-46a1-8fe7-5bfbb21b193b',7,0,NULL,'2023-09-13 11:51:47','2023-09-13 11:51:47'),
(78,'0703090a-e5e2-4c1d-bd0f-796c126db246',6,1,NULL,'2023-09-13 12:03:20','2023-09-13 12:03:20'),
(79,'d8f8b50e-25aa-4e09-b5f7-33c3a89ba656',6,2,NULL,'2023-09-13 12:03:27','2023-09-13 12:03:27'),
(80,'62179dd7-30a6-48d4-8a1d-be2bf5e67a7e',6,3,NULL,'2023-09-13 12:03:27','2023-09-13 12:03:27'),
(81,'acb5d6c3-a7b0-4ff9-8cd4-6616ab44f487',7,1,NULL,'2023-09-13 13:50:45','2023-09-13 13:50:45'),
(82,'2cea6c94-ff14-45f4-bd3f-78d6a0b21c0f',7,0,NULL,'2023-09-13 13:51:06','2023-09-13 13:51:06'),
(83,'eb92bd19-d107-40aa-a7fd-a4fc59ae4498',7,1,NULL,'2023-09-13 13:52:09','2023-09-13 13:52:09'),
(84,'23a00b1e-c606-4ffa-8f1b-f5a7201a2b75',7,2,NULL,'2023-09-13 13:52:39','2023-09-13 13:52:39'),
(85,'aa9020a2-690e-42fa-b771-96eb45caf74d',7,3,NULL,'2023-09-13 13:52:39','2023-09-13 13:52:39'),
(86,'1dbb5e6e-c2db-410a-afa9-de29ec437bb5',7,4,NULL,'2023-09-13 13:55:39','2023-09-13 13:55:39'),
(87,'2e007c23-b34d-4b08-8141-024ff9ca4569',7,5,NULL,'2023-09-13 13:55:39','2023-09-13 13:55:39'),
(88,'a7d33023-42e9-455d-a9ce-8872b435669b',7,6,NULL,'2023-09-13 14:00:45','2023-09-13 14:00:45'),
(89,'7a5a70e4-705f-48d7-b034-21093eeaa165',7,7,NULL,'2023-09-13 14:00:45','2023-09-13 14:00:45'),
(90,'2fc84a1c-aa5b-41fd-9e26-e4cab7cec7fa',7,8,NULL,'2023-09-13 14:04:33','2023-09-13 14:04:33'),
(91,'d9f1a2fc-2ec8-42c0-b103-98ceed79831e',8,0,NULL,'2023-09-13 14:33:49','2023-09-13 14:33:49'),
(92,'df46bd12-0097-46ed-9170-468b533bc1f8',4,11,'Selesai','2023-09-13 14:42:14','2023-09-13 14:42:14'),
(93,'4679cd2b-1c14-4212-8784-050a91e54817',2,6,NULL,'2023-09-14 13:10:19','2023-09-14 13:10:19'),
(94,'45f25dac-08ca-4f71-96f3-090ef503a727',2,7,NULL,'2023-09-14 13:10:19','2023-09-14 13:10:19'),
(95,'71a96ae1-f922-4600-afc8-8a43ddf0d9bf',9,1,NULL,'2023-09-18 10:59:17','2023-09-18 10:59:17'),
(96,'3a40a464-b447-47df-af3f-a8eb4fdf424a',9,2,NULL,'2023-09-18 11:09:47','2023-09-18 11:09:47'),
(97,'8251913e-c8c9-4e4f-a137-be9b4aa65993',9,3,NULL,'2023-09-18 11:09:47','2023-09-18 11:09:47'),
(98,'04d6c5da-9c90-4694-8e19-66c5dc7c2f99',9,4,NULL,'2023-09-18 11:33:32','2023-09-18 11:33:32'),
(99,'2bc98c50-90ca-411a-bc86-cc98407c81ba',9,5,NULL,'2023-09-18 11:33:32','2023-09-18 11:33:32'),
(100,'d1cc496d-6896-4603-acac-9a4310ad1685',9,6,NULL,'2023-09-18 11:37:30','2023-09-18 11:37:30'),
(101,'2f91ea9a-4126-4b5b-8286-ff6642532c1e',9,7,NULL,'2023-09-18 11:37:30','2023-09-18 11:37:30'),
(102,'39fbdc5a-233a-4cbb-9d5d-2c428ad65719',9,8,NULL,'2023-09-18 11:58:37','2023-09-18 11:58:37'),
(103,'79e0581c-3699-4032-87b2-03d66ae5f913',9,7,NULL,'2023-09-18 11:59:50','2023-09-18 11:59:50'),
(104,'c207d731-0fee-463d-98c1-7b9612e12234',4,11,'Selesai','2023-09-18 12:06:07','2023-09-18 12:06:07'),
(105,'bb694afe-6103-4799-90c2-2e7e8258f8f4',10,0,NULL,'2023-09-18 12:15:29','2023-09-18 12:15:29'),
(106,'9af6897c-4afa-435e-9b2d-89752066b06c',10,1,NULL,'2023-09-18 12:19:24','2023-09-18 12:19:24'),
(107,'3c1c01f4-933b-436b-9005-61c2133e771c',10,2,NULL,'2023-09-18 12:29:30','2023-09-18 12:29:30'),
(108,'3fab3f14-fa10-407b-82a8-dbb870e36f5a',10,3,NULL,'2023-09-18 12:29:30','2023-09-18 12:29:30'),
(109,'c78b4a95-1cda-4aae-918b-85dc30e4d85f',10,4,NULL,'2023-09-18 12:35:56','2023-09-18 12:35:56'),
(110,'30f5ceb2-22d3-4a9f-8472-f0652fef9e75',10,5,NULL,'2023-09-18 12:35:56','2023-09-18 12:35:56'),
(111,'2fe8dca0-b68f-4783-991d-416ee99f4642',10,6,NULL,'2023-09-18 12:38:23','2023-09-18 12:38:23'),
(112,'bab5b5e8-f6ff-4d75-8b2c-f7da00f57255',10,7,NULL,'2023-09-18 12:38:23','2023-09-18 12:38:23'),
(113,'bf6dfeea-501f-46f2-a376-d53166bce94d',10,8,NULL,'2023-09-18 12:40:37','2023-09-18 12:40:37'),
(114,'a351e8a8-0a91-4c56-8a1c-d559be15d624',11,0,NULL,'2023-09-18 13:10:55','2023-09-18 13:10:55'),
(115,'4d8c6d6e-6fc7-4fcf-884d-02efbd31a973',10,9,NULL,'2023-09-21 09:40:15','2023-09-21 09:40:15'),
(116,'2214cc11-f1d0-4ffe-b271-b27a10439a7d',12,1,NULL,'2023-09-21 11:39:43','2023-09-21 11:39:43'),
(117,'3a21a2be-e888-473c-902c-6c2279beca8b',12,2,NULL,'2023-09-21 13:41:36','2023-09-21 13:41:36'),
(118,'fef6a14d-c3f9-4d5e-b3d3-9712501d116e',12,3,NULL,'2023-09-21 13:41:36','2023-09-21 13:41:36'),
(119,'89968380-4b67-4d18-a223-1e32f8626414',12,1,NULL,'2023-09-21 13:44:58','2023-09-21 13:44:58'),
(120,'d6fb13ae-75f3-43c8-92a0-87a5aa90c9bd',12,2,NULL,'2023-09-21 14:04:15','2023-09-21 14:04:15'),
(121,'7316031d-431a-4db0-93d8-67912feea54d',12,3,NULL,'2023-09-21 14:04:15','2023-09-21 14:04:15'),
(122,'6923d4ed-b6b6-439c-8104-5bda52094699',6,1,NULL,'2023-09-21 14:09:31','2023-09-21 14:09:31'),
(123,'3e75ad41-7dae-46a4-8573-4ec7996e1edb',12,1,NULL,'2023-09-21 14:09:47','2023-09-21 14:09:47'),
(124,'8090859f-80c9-4ef8-9e7f-efecb188b13f',12,2,NULL,'2023-09-21 14:09:53','2023-09-21 14:09:53'),
(125,'24de20f6-7350-4da5-81c4-5e0c8c09dcf2',12,3,NULL,'2023-09-21 14:09:53','2023-09-21 14:09:53'),
(126,'87fe7fbe-a59a-4fe2-a358-119c20a079fd',12,1,NULL,'2023-09-21 14:10:54','2023-09-21 14:10:54'),
(127,'beb4706d-3d74-405c-a998-641921ebc62e',12,2,NULL,'2023-09-21 14:15:54','2023-09-21 14:15:54'),
(128,'254cd87b-9e57-4c99-9afb-43e03e92e23e',12,3,NULL,'2023-09-21 14:15:54','2023-09-21 14:15:54'),
(129,'5c3a5dc6-cd3d-4931-b560-8b1dcb344e9a',12,1,NULL,'2023-09-21 14:20:05','2023-09-21 14:20:05'),
(130,'bac7d11d-0c1a-4cf9-af1b-496537b45319',6,2,NULL,'2023-09-21 14:21:30','2023-09-21 14:21:30'),
(131,'1889f608-14d3-41d1-bf19-beb81c6422aa',6,3,NULL,'2023-09-21 14:21:30','2023-09-21 14:21:30'),
(132,'6654d1c4-8373-4a7d-ba05-e3031769324c',12,2,NULL,'2023-09-21 14:21:44','2023-09-21 14:21:44'),
(133,'bbd02ba7-e9f7-4b5b-afb5-a675a0559e5a',12,3,NULL,'2023-09-21 14:21:44','2023-09-21 14:21:44'),
(134,'468f35a7-daf0-458d-bb1c-4ddeef8732cb',12,4,NULL,'2023-09-21 15:12:54','2023-09-21 15:12:54'),
(135,'43304998-a5b4-4454-aa76-a6877958228e',12,5,NULL,'2023-09-21 15:12:54','2023-09-21 15:12:54'),
(136,'75cb5d3a-5d3e-4764-8cbc-b21ac540d6fb',12,6,NULL,'2023-09-21 15:25:17','2023-09-21 15:25:17'),
(137,'667be16f-bac4-4fc2-86e5-b44dccc129c1',12,7,NULL,'2023-09-21 15:25:17','2023-09-21 15:25:17'),
(138,'6ee04b55-0499-4de0-9c18-e44fd27d85f9',12,8,NULL,'2023-09-21 15:45:06','2023-09-21 15:45:06'),
(139,'2ee41243-75f6-40d1-b675-8445d9a91d38',10,11,'Selesai','2023-09-21 15:53:12','2023-09-21 15:53:12'),
(140,'798502fb-060b-4b38-b80a-e9fe44dc76e8',10,11,'Selesai','2023-09-21 15:53:28','2023-09-21 15:53:28'),
(141,'6f13f838-3ba0-457a-a716-37f8e6eacd75',12,9,NULL,'2023-09-21 16:00:58','2023-09-21 16:00:58'),
(142,'5b4509f1-af9e-413c-bf83-58d45c4d8ef0',13,0,NULL,'2023-09-22 05:32:53','2023-09-22 05:32:53'),
(143,'43eb1bf4-9f89-44fe-aa88-fafc24285ecd',13,1,NULL,'2023-09-22 09:22:31','2023-09-22 09:22:31'),
(144,'84f1743c-cdac-4f78-ae99-ed593b736487',14,1,NULL,'2023-09-22 10:07:41','2023-09-22 10:07:41'),
(145,'027489f4-f5ee-4b36-b269-2bdaa1736283',14,2,NULL,'2023-09-22 10:11:02','2023-09-22 10:11:02'),
(146,'1c003814-9f63-450e-8bb5-9ae0a514ec18',14,3,NULL,'2023-09-22 10:11:02','2023-09-22 10:11:02'),
(147,'7516cbdd-c16a-4ea6-ac43-9a07db912faf',14,4,NULL,'2023-09-22 10:20:36','2023-09-22 10:20:36'),
(148,'15cb4537-82e0-4a75-9794-feff340b7eb3',14,5,NULL,'2023-09-22 10:20:36','2023-09-22 10:20:36'),
(149,'e17574d7-3034-408d-8960-f8c396293f02',14,6,NULL,'2023-09-22 10:22:12','2023-09-22 10:22:12'),
(150,'da01e69c-eee4-4cc0-8946-3416e766712d',14,7,NULL,'2023-09-22 10:22:12','2023-09-22 10:22:12');

/*Table structure for table `umpan_baliks` */

DROP TABLE IF EXISTS `umpan_baliks`;

CREATE TABLE `umpan_baliks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bulan` int NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `u1` int NOT NULL,
  `keterangan_u1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `u2` int NOT NULL,
  `keterangan_u2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `u3` int NOT NULL,
  `keterangan_u3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `u4` int NOT NULL,
  `keterangan_u4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `u5` int NOT NULL,
  `keterangan_u5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `u6` int NOT NULL,
  `keterangan_u6` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `u7` int NOT NULL,
  `keterangan_u7` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `u8` int NOT NULL,
  `keterangan_u8` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `u9` int NOT NULL,
  `keterangan_u9` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `u10` int NOT NULL,
  `keterangan_u10` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `umpan_baliks_uuid_unique` (`uuid`),
  KEY `umpan_baliks_user_id_foreign` (`user_id`),
  CONSTRAINT `umpan_baliks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `umpan_baliks` */

insert  into `umpan_baliks`(`id`,`uuid`,`nomer`,`tahun`,`bulan`,`user_id`,`u1`,`keterangan_u1`,`u2`,`keterangan_u2`,`u3`,`keterangan_u3`,`u4`,`keterangan_u4`,`u5`,`keterangan_u5`,`u6`,`keterangan_u6`,`u7`,`keterangan_u7`,`u8`,`keterangan_u8`,`u9`,`keterangan_u9`,`u10`,`keterangan_u10`,`created_at`,`updated_at`) values 
(1,'d1dab17e-0f6f-4698-87a6-f896552f24c8','1','2023',9,NULL,82,NULL,83,NULL,80,NULL,81,NULL,85,NULL,80,NULL,87,NULL,75,NULL,89,NULL,87,NULL,'2023-09-18 12:51:43','2023-09-18 12:51:43');

/*Table structure for table `user_parameters` */

DROP TABLE IF EXISTS `user_parameters`;

CREATE TABLE `user_parameters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `parameter_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_parameters_user_id_foreign` (`user_id`),
  KEY `user_parameters_parameter_id_foreign` (`parameter_id`),
  CONSTRAINT `user_parameters_parameter_id_foreign` FOREIGN KEY (`parameter_id`) REFERENCES `parameters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_parameters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_parameters` */

insert  into `user_parameters`(`id`,`user_id`,`parameter_id`,`created_at`,`updated_at`) values 
(1,3,27,NULL,NULL),
(2,3,28,NULL,NULL),
(3,5,5,NULL,NULL),
(4,5,12,NULL,NULL),
(5,5,13,NULL,NULL),
(9,5,31,NULL,NULL),
(12,6,20,NULL,NULL),
(13,6,17,NULL,NULL),
(16,6,26,NULL,NULL),
(17,6,29,NULL,NULL),
(18,7,6,NULL,NULL),
(19,7,7,NULL,NULL),
(20,7,15,NULL,NULL),
(21,7,21,NULL,NULL),
(22,7,30,NULL,NULL),
(23,8,4,NULL,NULL),
(24,8,35,NULL,NULL),
(25,8,11,NULL,NULL),
(27,8,3,NULL,NULL),
(29,9,34,NULL,NULL),
(35,5,51,NULL,NULL),
(36,5,52,NULL,NULL),
(37,3,9,NULL,NULL),
(38,3,10,NULL,NULL),
(39,3,47,NULL,NULL),
(40,4,36,NULL,NULL),
(41,4,37,NULL,NULL),
(42,4,38,NULL,NULL),
(43,5,46,NULL,NULL),
(44,5,55,NULL,NULL),
(45,5,24,NULL,NULL),
(46,5,23,NULL,NULL),
(47,6,45,NULL,NULL),
(48,6,49,NULL,NULL),
(49,6,50,NULL,NULL),
(50,7,14,NULL,NULL),
(51,7,53,NULL,NULL),
(52,8,1,NULL,NULL),
(53,8,39,NULL,NULL),
(54,8,40,NULL,NULL),
(55,9,8,NULL,NULL),
(56,9,22,NULL,NULL),
(57,9,41,NULL,NULL),
(58,9,33,NULL,NULL),
(59,9,42,NULL,NULL),
(60,4,2,NULL,NULL),
(61,4,18,NULL,NULL),
(62,4,19,NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expired_at` timestamp NULL DEFAULT NULL,
  `golongan_id` bigint unsigned NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_uuid_unique` (`uuid`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  KEY `users_golongan_id_foreign` (`golongan_id`),
  CONSTRAINT `users_golongan_id_foreign` FOREIGN KEY (`golongan_id`) REFERENCES `golongans` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`uuid`,`nama`,`nip`,`email`,`phone`,`email_verified_at`,`phone_verified_at`,`password`,`confirmed`,`photo`,`otp`,`otp_expired_at`,`golongan_id`,`remember_token`,`created_at`,`updated_at`) values 
(1,'859af36a-e778-4ff2-9a5d-e48bf2262b1b','Administrator',NULL,'admin@silajang.go.id','','2023-08-09 08:39:13','2023-08-09 08:39:13','$2y$10$1qAN8Z6HxAHTC/945mGOa.wyzpT3xbEdYJ4ILZM/vXThaKnsmvvDm',1,NULL,NULL,NULL,2,NULL,'2023-08-09 08:39:13','2023-08-09 08:39:13'),
(2,'f0cbc4cc-3969-49be-83f8-2ab00a9b24d0','Herlina Hamzah, S.T.','198203262015052001','herlinas1512ln@gmail.com','081230237372','2023-08-09 08:39:13','2023-08-09 08:39:13','$2y$10$Z/27fNNJeG0RkTvSUIa6LuFYiCGHJti2Eyo/4WZ8glL6xAy2HJhom',1,NULL,NULL,NULL,2,NULL,'2023-08-09 08:39:13','2023-09-04 09:43:54'),
(3,'8d34a065-d5e0-46d4-ba63-b6e7c8aef6e0','Mutya Sandei Sahasrikirana, S.Si.','199410162022032007','mutyasandeis@gmail.com','085735535633','2023-08-09 08:39:13','2023-08-09 08:39:13','$2y$10$ixtfN/9JUxUFE.tQ3rP8aOUTiUk7hfb9JclpIeKWlLXevGulQt7eu',1,NULL,NULL,NULL,2,NULL,'2023-08-09 08:39:13','2023-09-04 09:43:05'),
(4,'31d1634a-e8d1-4e35-becf-6179b81531a4','Kartika Arifatunnisa\', A.Md., K.L.','199605162020122008','kartikaarifa91@gmail.com','081233148205','2023-08-09 08:39:13','2023-08-09 08:39:13','$2y$10$hpHEBFeaeX1zhSFxPx.8lutQwupqryw0x0Qa4PAy0yXTysv7cyCi2',1,NULL,NULL,NULL,2,NULL,'2023-08-09 08:39:13','2023-09-04 09:46:12'),
(5,'479ad50e-8536-4994-8ff9-dbbe42b57eab','Najihah, S.Si.',NULL,'nnajihah945@gmail.com','082257237831','2023-08-09 08:39:13','2023-08-09 08:39:13','$2y$10$IhXJ.cXphXcoPqDe5eUGluSK9BZNxrCy6BTks3k5CRb5W2.KwgfH.',1,NULL,NULL,NULL,2,NULL,'2023-08-09 08:39:13','2023-08-09 08:39:13'),
(6,'c98cbbae-1bea-4bb5-b645-0c963784e30d','Eko Januar Anggra, S.Si.',NULL,'experianggra@gmail.com','082132676601','2023-08-09 08:39:14','2023-08-09 08:39:14','$2y$10$p/qHopbSoOV6Z13pEyYp7utWwYeWRotzSH..Y8io6IAi4UjnT6R.C',1,NULL,NULL,NULL,2,NULL,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(7,'06245d13-00f9-473a-8d4f-7525957952b8','Ayu Nia Maulidiyah, S.Si.',NULL,'ayuniamaulidiyah@gmail.com','085748405755','2023-08-09 08:39:14','2023-08-09 08:39:14','$2y$10$vIj6IuYdzVBH3MQHFQ.sruoKQ6y0Gye76f1.MTMfwgVSnVTnwBPye',1,NULL,NULL,NULL,2,NULL,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(8,'7f357486-797a-4dc0-99a4-2db5ac6ff9cd','Wahyu Chandra Eko Utoro, S.Ak.',NULL,'wahyu.chandra222@gmail.com','082228569583','2023-08-09 08:39:14','2023-08-09 08:39:14','$2y$10$wbmk26zl5shPQ7xe3cJLj.FIY7SHeCF4PQEOA3rEMxGDhN5TeOx7q',1,NULL,NULL,NULL,2,NULL,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(9,'7496b80b-46e1-4035-a6d4-68fe416e3e96','M. Renjis Setiawan, S.T.',NULL,'renjiss12@gmail.com','089513697116','2023-08-09 08:39:14','2023-08-09 08:39:14','$2y$10$2C.gPGtulAwU3uPxxPkdGeaiJ6Gif9HCijRjW2NnfXnzHGimODmKW',1,NULL,NULL,NULL,2,NULL,'2023-08-09 08:39:14','2023-08-09 08:39:14'),
(10,'510ef842-7f75-4fd1-a402-a733266304fc','Customer Test',NULL,'customer@testing.com','08123456789','2023-08-09 08:39:14','2023-08-09 08:39:14','$2y$10$amfZaXci8RpH860ow0Sanua0ve03Fvj.MroViK219FBpLQvO9Vbw.',1,'/storage/user/UNcuADHwC2UazUB3EQubQMLpK10yqw5hFJvL9nLP.png',NULL,NULL,1,NULL,'2023-08-09 08:39:14','2023-08-19 06:01:29'),
(13,'7f2b18ef-b6b5-4fdb-8ed1-a209adccf02a','M Aang Kurniawan',NULL,'mcflyons@gmail.com','089657147966','2023-09-08 10:33:01','2023-09-08 10:33:01','$2y$10$Lx1h9hvl.RbLCIx4sY0OOeztKeEq/U8AWzFmJVjLdP9ADKwXTTG4e',1,'/storage/user/FfG1pAWmtj6yv7d2SFHx6A2XA95WqYTCdmSbvOqw.jpg',NULL,NULL,1,NULL,'2023-09-08 10:33:01','2023-09-22 11:13:33'),
(15,'1b728cc6-880c-44fc-858a-cf2c98f1903b','CV. MTI',NULL,'admin@mcflyon.co.id','08977266144','2023-09-22 10:04:15','2023-09-22 10:04:15','$2y$10$tvn6E2nhU/NsrRYpZsYHO.hhkXjab2S3DnVTy54D0Ccg.s9sYEC5u',1,NULL,NULL,NULL,1,NULL,'2023-09-22 10:04:15','2023-09-22 10:04:15');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
