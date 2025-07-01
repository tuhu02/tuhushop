<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Carousel</title>
    @vite('resources/css/app.css')
</head>
<body class="flex">
    <x-admin-sidebar />
    <main class="w-full min-h-screen box-border bg-gray-50 overflow-hidden flex flex-col p-6">
        <!-- Header Actions -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Carousel List</h2>
            <button 
                onclick="showModal('addCarouselModal')" 
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                Add New Carousel
            </button>
        </div>

        <!-- Carousel Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-4 border-b text-gray-700">#</th>
                        <th class="p-4 border-b text-gray-700">Image</th>
                        <th class="p-4 border-b text-gray-700">Title</th>
                        <th class="p-4 border-b text-gray-700">Description</th>
                        <th class="p-4 border-b text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Row -->
                    <tr>
                        <td class="p-4 border-b">1</td>
                        <td class="p-4 border-b">
                            <img src="https://via.placeholder.com/150" alt="Carousel Image" class="w-16 h-16 object-cover rounded-md">
                        </td>
                        <td class="p-4 border-b">Carousel Title</td>
                        <td class="p-4 border-b">This is a sample description.</td>
                        <td class="p-4 border-b flex space-x-2">
                            <button 
                                onclick="showModal('editCarouselModal')" 
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded-lg">
                                Edit
                            </button>
                            <button 
                                onclick="confirmDelete()" 
                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Add Carousel -->
    <div id="addCarouselModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-lg font-bold mb-4">Add New Carousel</h2>
            <form>
                <div class="mb-4">
                    <label for="addTitle" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="addTitle" class="w-full p-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="addDescription" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="addDescription" class="w-full p-2 border rounded-lg"></textarea>
                </div>
                <div class="mb-4">
                    <label for="addImage" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" id="addImage" class="w-full p-2 border rounded-lg">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="hideModal('addCarouselModal')" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancel</button>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Carousel -->
    <div id="editCarouselModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-lg font-bold mb-4">Edit Carousel</h2>
            <form>
                <div class="mb-4">
                    <label for="editTitle" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="editTitle" class="w-full p-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="editDescription" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="editDescription" class="w-full p-2 border rounded-lg"></textarea>
                </div>
                <div class="mb-4">
                    <label for="editImage" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" id="editImage" class="w-full p-2 border rounded-lg">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="hideModal('editCarouselModal')" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Cancel</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show modal
        function showModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        // Hide modal
        function hideModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Confirm delete
        function confirmDelete() {
            if (confirm("Are you sure you want to delete this carousel?")) {
                alert("Carousel deleted!");
            }
        }
    </script>
</body>
</html>
