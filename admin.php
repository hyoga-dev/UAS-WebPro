<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "pytho");

if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];
    mysqli_query($conn, "UPDATE users SET role = '$new_role' WHERE id = $user_id");
    header("Location: admin.php");
}

if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    if ($user_id != $_SESSION['user_id']) {
        mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");
    }
    header("Location: admin.php");
}

$users = mysqli_query($conn, "SELECT * FROM users");

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image']; 
    $rating = $_POST['rating'];
    mysqli_query($conn, "INSERT INTO products (name, price, image, rating, reviews) VALUES ('$name', '$price', '$image', '$rating', 0)");
    header("Location: admin.php");
}

if (isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header("Location: admin.php");
}

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    mysqli_query($conn, "UPDATE orders SET status = '$new_status' WHERE id = $order_id");
    header("Location: admin.php");
}

$products = mysqli_query($conn, "SELECT * FROM products");
$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY tanggal_pemesanan DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Phyto</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { overflow-y: auto; background: #f4f4f4; padding: 20px; }
        .admin-section { background: white; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #2ecc71; color: white; }
        .form-add { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .form-add input { padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
        .status-badge { padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold; }
        .status-dikemas { background: #f1c40f; color: white; }
        .status-dikirim { background: #3498db; color: white; }
        .status-selesai { background: #2ecc71; color: white; }
    </style>
</head>
<body>

    <h1>Phyto Admin Dashboard</h1>

    <div class="admin-section">
    <h2>Manajemen User</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        <?php while($u = mysqli_fetch_assoc($users)): ?>
        <tr>
            <td>#<?php echo $u['id']; ?></td>
            <td><?php echo htmlspecialchars($u['nama']); ?></td>
            <td><?php echo htmlspecialchars($u['email']); ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                    <select name="new_role" onchange="this.form.submit()" style="padding:5px; border-radius:5px;">
                        <option value="user" <?php echo $u['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo $u['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                    <input type="hidden" name="update_role" value="1">
                </form>
            </td>
            <td>
                <?php if($u['id'] != $_SESSION['user_id']): ?>
                    <a href="admin.php?delete_user=<?php echo $u['id']; ?>" 
                       onclick="return confirm('Hapus user ini? Semua data pesanan mereka mungkin akan terdampak.')" 
                       style="color:red; text-decoration:none; font-weight:bold;">Hapus</a>
                <?php else: ?>
                    <span style="color:#aaa;">Anda (Aktif)</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

    <div class="admin-section">
        <h2>Manajemen Produk</h2>
        <form class="form-add" method="POST">
            <input type="text" name="name" placeholder="Nama Produk" required>
            <input type="number" name="price" placeholder="Harga" required>
            <input type="text" name="image" placeholder="Nama File Gambar (ex: cactus.png)" required>
            <input type="number" name="rating" placeholder="Rating Awal (1-5)" min="1" max="5">
            <button type="submit" name="add_product" class="btn-share" style="border:none; cursor:pointer;">+ Tambah Produk</button>
        </form>

        <table>
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Rating</th>
                <th>Aksi</th>
            </tr>
            <?php while($p = mysqli_fetch_assoc($products)): ?>
            <tr>
                <td><img src="Assets/Image/<?php echo $p['image']; ?>" width="50"></td>
                <td><?php echo $p['name']; ?></td>
                <td>Rp <?php echo number_format($p['price'], 0, ',', '.'); ?></td>
                <td>⭐ <?php echo $p['rating']; ?></td>
                <td>
                    <a href="admin.php?delete_product=<?php echo $p['id']; ?>" onclick="return confirm('Hapus produk ini?')" style="color:red;">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="admin-section">
        <h2>Daftar Pesanan User</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Total</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
            <?php while($o = mysqli_fetch_assoc($orders)): ?>
            <tr>
                <td>#<?php echo $o['id_order']; ?></td>
                <td><?php echo date('d M Y', strtotime($o['tanggal_pemesanan'])); ?></td>
                <td><?php echo $o['nama_produk']; ?> (<?php echo $o['jumlah']; ?>x)</td>
                <td>Rp <?php echo number_format($o['total_harga'], 0, ',', '.'); ?></td>
                <td>
                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '', $o['status'])); ?>">
                        <?php echo $o['status']; ?>
                    </span>
                </td>
                <td>
                    <form method="POST" style="display:flex; gap:5px;">
                        <input type="hidden" name="order_id" value="<?php echo $o['id_order']; ?>">
                        <select name="new_status" style="padding:5px;">
                            <option value="Sedang Dikemas">Sedang Dikemas</option>
                            <option value="Dikirim">Dikirim</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                        <button type="submit" name="update_status" style="cursor:pointer; background:#2ecc71; color:white; border:none; border-radius:3px;">Update</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>
</html>