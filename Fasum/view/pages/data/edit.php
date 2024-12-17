<?php
// Include configuration
include 'config.php';

// Fetch the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    die("Invalid ID");
}

$sql = "SELECT id, foto, lapangan, lokasi, longitude, latitude FROM list_fasum where id=$id";
$result = $conn->query($sql);

$data = $result->fetch_assoc();
$conn->close();

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']); // Clear errors after displaying
?>

<div class="py-4 px-2 flex justify-between">
    <p class="text-3xl text-gray-800 px-2">Edit</p>
    <p class="text-gray-600 px-2"><span class="text-blue-500">Home</span> / Fasilitas Umum / Edit</p>
</div>

<div class="px-4">
    <form method="POST" action="../../../controller/editFasum.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="existing_foto" value="<?php echo htmlspecialchars($data['foto']); ?>">

        <!-- Foto -->
        <div class="mb-5">
            <label for="foto" class="block mb-2 text-sm font-medium text-gray-900">Upload Foto</label>
            <input type="file" id="foto" name="foto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            <p class="text-sm text-gray-500">Foto saat ini: <?php echo htmlspecialchars($data['foto']); ?></p>
            <?php if (isset($errors['foto'])): ?>
                <div class="mb-5">
                    <ul style="color: red;">
                        <li><?php echo htmlspecialchars($errors['foto']); ?></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <!-- Jenis Lapangan -->
        <div class="mb-5">
            <label for="jenis_lapangan" class="block mb-2 text-sm font-medium text-gray-900">Jenis Lapangan</label>
            <input type="text" id="jenis_lapangan" name="jenis_lapangan" value="<?php echo htmlspecialchars($data['lapangan']); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            <?php if (isset($errors['lapangan'])): ?>
                <div class="mb-5">
                    <ul style="color: red;">
                        <li><?php echo htmlspecialchars($errors['lapangan']); ?></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <!-- Lokasi -->
        <div class="mb-5">
            <label for="lokasi" class="block mb-2 text-sm font-medium text-gray-900">Lokasi</label>
            <select id="lokasi" name="lokasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="" disabled>Pilih lokasi</option>
                <option value="Batam Kota" <?php echo ($data['lokasi'] === 'Batam Centre') ? 'selected' : ''; ?>>Batam Kota</option>
                <option value="Sagulung" <?php echo ($data['lokasi'] === 'Lubuk Baja') ? 'selected' : ''; ?>>Sagulung</option>
            </select>
            <?php if (isset($errors['lokasi'])): ?>
                <div class="mb-5">
                    <ul style="color: red;">
                        <li><?php echo htmlspecialchars($errors['lokasi']); ?></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <!-- Koordinat -->
        <div class="mb-5">
            <label for="koordinat" class="block mb-2 text-sm font-medium text-gray-900">Koordinat</label>
            <input type="text" id="koordinat" name="koordinat" value="<?php echo htmlspecialchars($data['latitude'] . ', ' . $data['longitude']); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
            <?php if (isset($errors['koordinat_format'])): ?>
                <div class="mb-5">
                    <ul style="color: red;">
                        <li><?php echo htmlspecialchars($errors['koordinat_format']); ?></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
            Update
        </button>
    </form>
</div>