<?php
// Include the database configuration
include 'config.php';

// Determine the current page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

// Define the number of records per page
$records_per_page = 5;

// Calculate the starting record for the query
$offset = ($page - 1) * $records_per_page;

// Fetch total records for pagination
$total_query = "SELECT COUNT(*) AS total FROM list_fasum";
$total_result = mysqli_query($conn, $total_query);
$total_data = mysqli_fetch_assoc($total_result)['total'];

// Fetch records for the current page
$query = "SELECT * FROM list_fasum LIMIT $offset, $records_per_page";
$result = $conn->query($query);
?>

<div class="py-4 px-2 flex justify-between">
    <p class="text-3xl text-gray-800 px-2">Fasilitas Umum</p>
    <p class="text-gray-600 px-2"><span class="text-blue-500">Home</span> / Fasilitas Umum</p>
</div>

<div class="px-4">
    <div class="flex justify-end mb-2">
        <a href="/data/create" class="flex gap-2 items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
            <i class="fa-solid fa-plus"></i>
            <p>Tambah</p>
        </a>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Foto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis Lapangan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lokasi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Koordinat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='bg-white border-b'>";
                        echo "<td class='px-6 py-4'><img src='../../uploads/images/" . $row['foto'] . "' alt='Foto' class='w-16 h-16 object-cover'></td>";
                        echo "<td class='px-6 py-4'>" . htmlspecialchars($row['lapangan']) . "</td>";
                        echo "<td class='px-6 py-4'>" . htmlspecialchars($row['lokasi']) . "</td>";
                        echo "<td class='px-6 py-4'>" . htmlspecialchars($row['latitude']) . ", " . htmlspecialchars($row['longitude']) . "</td>";
                        echo "<td class='px-6 py-4'>";
                        echo "<a href='/data/edit?id=" . $row['id'] . "' class='font-medium text-blue-600 hover:underline'>Edit</a><span class='px-2'>|</span>";
                        echo "<form action='../../controller/deleteFasum.php' method='POST' style='display:inline;' id='deleteForm'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <button type='button' data-id='" . $row['id'] . "' onclick='showDeleteModal(this)' class='font-medium text-red-600 hover:underline'>Hapus</button>
                            </form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center py-4 text-gray-500'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4" aria-label="Table navigation">
            <?php
            // Total number of pages
            $total_pages = ceil($total_data / $records_per_page);

            // Current record range
            $start_record = $offset + 1;
            $end_record = min($offset + $records_per_page, $total_data);
            ?>
            <span class="text-sm font-normal text-gray-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span class="font-semibold text-gray-900"><?php echo $start_record; ?>-<?php echo $end_record; ?></span> of <span class="font-semibold text-gray-900"><?php echo $total_data; ?></span></span>
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                <?php if ($page > 1): ?>
                    <li>
                        <a href="?page=<?php echo $page - 1; ?>" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li>
                        <a href="?page=<?php echo $i; ?>" class="flex items-center justify-center px-3 h-8 hover:bg-blue-100 hover:text-blue-700 <?php echo $i === $page ? 'text-blue-600 border border-gray-300 bg-blue-50' : 'leading-tight text-gray-500 bg-white border border-gray-300'; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li>
                        <a href="?page=<?php echo $page + 1; ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 ">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <h2 class="text-lg font-bold mb-4">Hapus Data</h2>
        <p>Apakah kamu yakin ingin menghapus data ini?</p>
        <div class="flex justify-end mt-4">
            <button id="cancelButton" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg mr-2">Batal</button>
            <button id="confirmDeleteButton" class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-lg">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    let deleteModal = document.getElementById('deleteModal');
    let confirmDeleteButton = document.getElementById('confirmDeleteButton');
    let cancelButton = document.getElementById('cancelButton');
    let deleteId = null;

    function showDeleteModal(element) {
        deleteId = element.getAttribute('data-id');
        deleteModal.classList.remove('hidden');
    }

    confirmDeleteButton.addEventListener('click', function() {
        if (deleteId) {
            document.querySelector(`#deleteForm input[name="id"][value="${deleteId}"]`).form.submit();
        }
    });

    cancelButton.addEventListener('click', function() {
        deleteModal.classList.add('hidden');
    });
</script>