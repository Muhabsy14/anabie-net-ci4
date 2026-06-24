-- Import file alternatif jika `php spark migrate` tidak tersedia
-- Buat database: CREATE DATABASE anabie_net;

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('owner','admin','pelanggan') NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `paket_layanan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_paket` varchar(100) NOT NULL,
  `kecepatan` varchar(50) NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `deskripsi` text,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `kode_pelanggan` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `paket_id` int unsigned NOT NULL,
  `status` enum('aktif','nonaktif','suspend') DEFAULT 'aktif',
  `tanggal_berlangganan` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_pelanggan` (`kode_pelanggan`),
  KEY `user_id` (`user_id`),
  KEY `paket_id` (`paket_id`),
  CONSTRAINT `pelanggan_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pelanggan_paket_fk` FOREIGN KEY (`paket_id`) REFERENCES `paket_layanan` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tagihan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pelanggan_id` int unsigned NOT NULL,
  `periode_bulan` tinyint unsigned NOT NULL,
  `periode_tahun` smallint unsigned NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `status` enum('belum_lunas','lunas') DEFAULT 'belum_lunas',
  `jatuh_tempo` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pelanggan_id` (`pelanggan_id`),
  CONSTRAINT `tagihan_pelanggan_fk` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pembayaran` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tagihan_id` int unsigned DEFAULT NULL,
  `pelanggan_id` int unsigned NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `metode` varchar(50) NOT NULL,
  `keterangan` text,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagihan_id` (`tagihan_id`),
  KEY `pelanggan_id` (`pelanggan_id`),
  CONSTRAINT `pembayaran_tagihan_fk` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembayaran_pelanggan_fk` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pengaduan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pelanggan_id` int unsigned NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL,
  `status` enum('menunggu','diproses','selesai') DEFAULT 'menunggu',
  `balasan_admin` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pelanggan_id` (`pelanggan_id`),
  CONSTRAINT `pengaduan_pelanggan_fk` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `notifikasi_whatsapp` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pelanggan_id` int unsigned DEFAULT NULL,
  `pesan` text NOT NULL,
  `status_kirim` enum('terkirim','gagal','draft') DEFAULT 'terkirim',
  `metode_kirim` enum('cloud_api','wa_me') DEFAULT 'wa_me',
  `wa_message_id` varchar(100) DEFAULT NULL,
  `api_error` text,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pelanggan_id` (`pelanggan_id`),
  CONSTRAINT `notif_pelanggan_fk` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- Jalankan seeder setelah import: php spark db:seed AnabieNetSeeder
