<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-200 flex flex-col items-center min-h-screen p-6">
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-2xl font-bold mb-4">Edit Book</h2>
            <form method="POST" action="{{ route('books.update', $book->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ $book->title }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="author" class="block text-gray-700 mb-2">Author</label>
                    <input type="text" name="author" id="author" value="{{ $book->author }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ $book->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="published_year" class="block text-gray-700 mb-2">Published Year</label>
                    <input type="number" name="published_year" id="published_year" value="{{ $book->published_year }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="genre" class="block text-gray-700 mb-2">Genre</label>
                    <input type="text" name="genre" id="genre" value="{{ $book->genre }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Save</button>
                    <a href="{{ route('books.index') }}">
                        <button type="button"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none">Cancel</button>
                    </a>
                    <!-- Delete Button -->
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">
                            Delete
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
