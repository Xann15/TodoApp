-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Bulan Mei 2024 pada 17.18
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todos_app`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `scheduled_notifications`
--

CREATE TABLE `scheduled_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `todo_id` int(11) DEFAULT NULL,
  `notification_time` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `scheduled_notifications`
--

INSERT INTO `scheduled_notifications` (`id`, `user_id`, `todo_id`, `notification_time`) VALUES
(14, 1, 1, '02:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `todos`
--

CREATE TABLE `todos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `todo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `todos`
--

INSERT INTO `todos` (`id`, `user_id`, `status`, `todo`) VALUES
(1, 1, 'true', 'makaaaaan'),
(23, 2, 'true', 'gym'),
(27, 1, 'true', 'gym');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `gender` varchar(50) NOT NULL DEFAULT '',
  `full_name` varchar(100) NOT NULL DEFAULT '',
  `picture` varchar(255) NOT NULL DEFAULT '',
  `verifiedEmail` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) NOT NULL DEFAULT '',
  `notification_endpoint` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `gender`, `full_name`, `picture`, `verifiedEmail`, `token`, `notification_endpoint`) VALUES
(1, 'pandjiealdino15@gmail.com', 'Pandjie', 'Aldino', '', 'Pandjie Aldino', 'https://lh3.googleusercontent.com/a/ACg8ocJE1HTOpXw5BBE7RwoZO9N5aTRYuC2UBnFN6hDQL1sWM7abm_QS=s96-c', 1, '106044094088138731307', '{\"endpoint\":\"https://fcm.googleapis.com/fcm/send/e_b4RCX3VzE:APA91bGBbxGpaKWAc-wo7F0tO9Qinf5rbNEfFe03QlkwDiMh4mWKO02S5fMXwnZZwGxKheSW8vmxfCRN1xiqH5-qSBK2tfohJR_esiyEkB0_F2qpjNSXIsOHodFtTC6Hu2iktDinZA5J\",\"expirationTime\":null,\"keys\":{\"p256dh\":\"BKIUWoTiyGR5ra5_SDimXGWTz0oGkKTc-ZtN8zfWcgfDTpKxm5NJKMeBThw6SmJjWrsjU4OTHYOZvWMyblztn5M\",\"auth\":\"IZedlLyfgVE7MQvMInqVAA\"}}'),
(2, 'kumasuppport@gmail.com', 'kuma', '', '', 'kuma', 'https://lh3.googleusercontent.com/a/ACg8ocKVikUeatFzCQ5EunqSE08kfSWc7DnJKG3mTwd5kbQSDHZxcg=s96-c', 1, '111230991323607962462', '{\"endpoint\":\"https://fcm.googleapis.com/fcm/send/frTHNJWFrt4:APA91bFb31vE7pPGAb7B5ZM6LRcYu5PEJ1T426iCH0GcURDmDV9qK9223Qrn4S47oNEZot1sntPZye5UHWc3SYCp4pSwWZTU4Vu_BANeLaukNp0rE-UFXTJo-l7CaRaZ8OmKZst6v8jp\",\"expirationTime\":null,\"keys\":{\"p256dh\":\"BPgu4xe94W5VqVAvcD7sSHnppPVa4q1hR5kRJNhQvk9VNXtrComQUr8dMrzYE8nVfbS0wcXBRy1zUIDL9srRlGg\",\"auth\":\"FyL980Kdp_QnU1TPwce9Fw\"}}');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `scheduled_notifications`
--
ALTER TABLE `scheduled_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `scheduled_notifications`
--
ALTER TABLE `scheduled_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `todos`
--
ALTER TABLE `todos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
