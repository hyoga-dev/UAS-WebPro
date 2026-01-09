-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jan 2026 pada 01.31
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
-- Database: `pytho`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `tanggal_pemesanan` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `gambar_produk` varchar(255) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `total_harga` decimal(14,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `reviews` int(11) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `rating`, `reviews`, `image`, `category`) VALUES
(1, 'Giant White', 46000, 5, 76, 'giant-white.png', 'Plants'),
(2, 'Mini Cactus', 25000, 4, 32, 'cactus.png', 'Plants'),
(3, 'Garden Tool Set', 99000, 5, 12, 'tools.png', 'Gardening'),
(4, 'Organic Plant Seeds', 15000, 4, 89, 'seeds.png', 'Seeds'),
(5, 'Terracotta Plant Pot', 85000, 5, 15, 'pot.png', 'Planters'),
(6, 'Snake Plant (Lidah Mertua)', 65000, 4, 210, 'snake-plant.png', 'Plants'),
(7, 'Automatic Water Sprayer', 90000, 5, 69, 'sprayer.png', 'Gardening'),
(8, 'Aloe Vera Medic', 35000, 4, 55, 'aloe.png', 'Plants'),
(9, 'Hanging Macrame Pot', 89000, 5, 8, 'macrame.png', 'Planters'),
(10, 'Golden Pothos', 45000, 4, 150, 'pothos.png', 'Plants');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `created_at`) VALUES
(1, 'lamy', 'hyogadecaprio@gmail.com', '$2y$10$wUb.3qoAHsuSne0EGJcXeeBPYbnf5QdQjoo/a63xaB2u3mf/go1B.', '2026-01-07 01:13:52'),
(2, 'lamy', 'admin@gmail.com', '$2y$10$f6DvihyfPp3wnhbp3tzXaus29qsEVY8WiKI9Wyy4wz6gkLHNdwTgO', '2026-01-07 23:58:46'),
(3, 'udin', 'hyogadecaprio4@gmail.com', '$2y$10$SKuRNV/yIu4waT.FuNYhD.gTMyM6rWy/s05EYcAgecfuvgqxot6Ge', '2026-01-09 00:29:16'),
(4, 'bahak', 'hyogadecaprio7@gmail.com', '$2y$10$WOUxgvIFKCc07xPguOes/eWMohBJq/W4mmazCbiXEqgwQkWHo37sW', '2026-01-09 00:30:39');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
