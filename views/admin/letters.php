<?php include '../../config/init.php'; ?>
<!-- user.php -->
<!DOCTYPE html>
<html lang="en">
<?php include 'components/head.php'; ?>
<body class="bg-gray-50">
<div class="flex">
    <?php include 'components/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex flex-col flex-1">
    <?php include 'components/header.php'; ?>

    <main class="p-6">
        <div class="bg-white shadow-md rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Letters</h2>
            </div>

            <!-- Inventory Table -->
            <div class="overflow-x-auto">
                <table id="inventoryTable" class="min-w-full border-collapse rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr class="text-gray-700 text-sm font-semibold uppercase">
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                        <?php
                        $result = $conn->query("SELECT letters.*, requests.* FROM letters LEFT JOIN requests ON letters.request_id = requests.id");
                        while ($row = $result->fetch_assoc()):
                        ?>
                        <tr class="hover:bg-gray-50"> 
                            <td class="px-6 py-3"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name'] ?? '') ?></td>
                            <td class="px-6 py-3"><?= htmlspecialchars($row['email'] ?? '') ?></td>

                            <td class="px-6 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                       <button 
                                        onclick="openPdfModal('<?= $row['letter_name'] ?>')" 
                                        class="bg-blue-600 text-white px-4 py-1.5 rounded-md shadow hover:bg-blue-700 transition">
                                        View PDF
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</div>

<!-- Add Item Modal -->
<div id="pdfModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-4/5 h-4/5 flex flex-col">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">View Letter</h3>
            <button onclick="closePdfModal()" class="text-gray-700 hover:text-gray-900">&times;</button>
        </div>
        <div class="flex-1 overflow-auto p-4">
            <iframe id="pdfFrame" src="" class="w-full h-full" frameborder="0"></iframe>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
function openPdfModal(pdfPath) {
    document.getElementById('pdfFrame').src = `https://gso-aosr.onrender.com/assets/pdfs/${pdfPath}`;
    document.getElementById('pdfModal').classList.remove('hidden');
}

function closePdfModal() {
    document.getElementById('pdfFrame').src = '';
    document.getElementById('pdfModal').classList.add('hidden');
}
</script>


<script>
    $(document).ready(function() {
        $('#inventoryTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true
        });
    });
</script>
</body>
</html>
