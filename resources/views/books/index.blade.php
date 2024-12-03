<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-200 flex flex-col items-center min-h-screen p-6">
    <!-- Search Form -->
    <form method="GET" action="{{ route('books.index') }}"
        class="flex space-x-2 p-4 bg-gray-100 rounded-md shadow-md mb-8 w-full max-w-lg">
        <input type="text" name="query" placeholder="Search books..."
            class="flex-1 border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
        <button type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
            Search
        </button>
    </form>

    <!-- Button to Open Modal -->
    <button onclick="document.getElementById('bookModal').classList.remove('hidden')"
        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
        Add New Book
    </button>

    <!-- Book List -->
    <div class="w-full max-w-4xl mx-auto mt-6">
        <h2 class="text-3xl font-bold mb-6 text-center">Book List</h2>
        @foreach ($books as $book)
            <div class="space-y-4 mb-2">
                <div
                    class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-2xl font-semibold text-gray-800">{{ $book->title }}</h3>
                        <div class="flex space-x-2">
                            <!-- Edit Button -->
                            <a href="{{ route('books.edit', $book) }}"
                                class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-200">
                                Edit
                            </a>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-2">{{ $book->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Published:
                            <strong>{{ $book->published_year }}</strong></span>
                        <span class="text-gray-600 text-sm">Genre: <strong>{{ $book->genre }}</strong></span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div id="bookModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg">
            <h1 class="text-2xl font-bold mb-4">Add New Book</h1>
            <form method="POST" action="{{ route('books.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter book title"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                        required>
                </div>
                <div class="mb-4">
                    <label for="author" class="block text-gray-700 font-semibold mb-2">Author</label>
                    <input type="text" id="author" name="author" placeholder="Enter author's name"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                        required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea type="text" id="author" name="description" placeholder="Enter book's description"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                        required></textarea>
                </div>
                <div class="mb-4">
                    <label for="published_year" class="block text-gray-700 font-semibold mb-2">Published year</label>
                    <input type="number" id="author" name="published_year"
                        placeholder="Enter book's publish year"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                        required>
                </div>
                <div class="mb-4">
                    <label for="genre" class="block text-gray-700 font-semibold mb-2">Genre</label>
                    <input type="text" id="author" name="genre" placeholder="Enter book's genre"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                        required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('bookModal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        Add Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
