![][image1]

**Develop a Simple Laravel CRUD Application | December 3, 2024 | 11:47:51 PM**

Objective

To develop a Laravel application that allows users to manage a list of books. The application must implement the following functionalities:

\- Search  
\- Create  
\- Edit  
\- Update  
\- Delete

Application Description

You will create a Book Management System where users can perform CRUD operations on books. Each book will have the following attributes:

\- Title (string)  
\- Author (string)  
\- Description (text)  
\- Published Year (integer)  
\- Genre (string)

Step-by-Step Instructions

**Setup the Laravel Project**  
1\. Install a new Laravel project:  
bash  
   laravel new book-management  
   cd book-management   

2\. Set up the database connection in the .env file.

**Create the Database and Model**  
1\. Create a migration and model for the Book entity:  
bash  
   php artisan make:model Book \-m  
   Php artisan migrate

**Open VS Code** 

  code .

2\. Define the database schema in the migration file located in database/migrations/:  
Look for the migration file

    Schema::create('books', function (Blueprint $table) {  
            $table-\>id();  
            $table-\>string('title');  
            $table-\>string('author');  
            $table-\>text('description');  
            $table-\>integer('published\_year');  
            $table-\>string('genre');  
            $table-\>timestamps();  
        });

3\. Run the migration:  
   
    php artisan migrate

**Create the Controller and Routes**  
1\. Generate a controller for books:  
bash  
   php artisan make:controller BookConroller –resource

2\. Define the routes in routes/web.php:

  \<?php

  use Illuminate\\Support\\Facades\\Route;  
  use App\\Http\\Controllers\\BookController;

  Route::get('/', \[BookController::class, 'index'\])-\>name('books.index');   
  Route::resource('books', BookController::class);

**Implement CRUD Functionalities**  
a. Create and Store Books

1\. In the create method of BookController, return a view for adding a new book:  
   
   public function create()  
    {  
        return view('books.create');  
    }

2\. In the store method, validate and save the book data:  
Import Book model

   use App\\Models\\Book;

3\. Create a modal resources/views/books/index.blade.php with a form to add a book.

\<\!DOCTYPE html\>  
\<html lang="en"\>

\<head\>  
    \<meta charset="UTF-8"\>  
    \<meta name="viewport" content="width=device-width, initial-scale=1.0"\>  
    \<title\>Search Books\</title\>  
    \<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"\>  
\</head\>

\<body class="bg-gray-200 flex flex-col items-center min-h-screen p-6"\>  
    \<\!-- Search Form \--\>  
    \<form method="GET" action="{{ route('books.index') }}"  
        class="flex space-x-2 p-4 bg-gray-100 rounded-md shadow-md mb-8 w-full max-w-lg"\>  
        \<input type="text" name="query" placeholder="Search books..."  
            class="flex-1 border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"\>  
        \<button type="submit"  
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"\>  
            Search  
        \</button\>  
    \</form\>

    \<\!-- Button to Open Modal \--\>  
    \<button onclick="document.getElementById('bookModal').classList.remove('hidden')"  
        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"\>  
        Add New Book  
    \</button\>

    \<\!-- Book List \--\>  
    \<div class="w-full max-w-4xl mx-auto mt-6"\>  
        \<h2 class="text-3xl font-bold mb-6 text-center"\>Book List\</h2\>  
        @foreach ($books as $book)  
            \<div class="space-y-4 mb-2"\>  
                \<div  
                    class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300"\>  
                    \<div class="flex justify-between items-center mb-2"\>  
                        \<h3 class="text-2xl font-semibold text-gray-800"\>{{ $book-\>title }}\</h3\>  
                        \<div class="flex space-x-2"\>  
                            \<\!-- Edit Button \--\>  
                            \<a href="{{ route('books.edit', $book) }}"  
                                class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-200"\>  
                                Edit  
                            \</a\>  
                        \</div\>  
                    \</div\>  
                    \<p class="text-gray-700 mb-2"\>{{ $book-\>description }}\</p\>  
                    \<div class="flex justify-between items-center"\>  
                        \<span class="text-gray-600 text-sm"\>Published:  
                            \<strong\>{{ $book-\>published\_year }}\</strong\>\</span\>  
                        \<span class="text-gray-600 text-sm"\>Genre: \<strong\>{{ $book-\>genre }}\</strong\>\</span\>  
                    \</div\>  
                \</div\>  
            \</div\>  
        @endforeach  
    \</div\>

    \<\!-- Modal \--\>  
    \<div id="bookModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden"\>  
        \<div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg"\>  
            \<h1 class="text-2xl font-bold mb-4"\>Add New Book\</h1\>  
            \<form method="POST" action="{{ route('books.store') }}"\>  
                @csrf  
                \<div class="mb-4"\>  
                    \<label for="title" class="block text-gray-700 font-semibold mb-2"\>Title\</label\>  
                    \<input type="text" id="title" name="title" placeholder="Enter book title"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"  
                        required\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="author" class="block text-gray-700 font-semibold mb-2"\>Author\</label\>  
                    \<input type="text" id="author" name="author" placeholder="Enter author's name"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"  
                        required\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="description" class="block text-gray-700 font-semibold mb-2"\>Description\</label\>  
                    \<textarea type="text" id="author" name="description" placeholder="Enter book's description"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"  
                        required\>\</textarea\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="published\_year" class="block text-gray-700 font-semibold mb-2"\>Published year\</label\>  
                    \<input type="number" id="author" name="published\_year"  
                        placeholder="Enter book's publish year"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"  
                        required\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="genre" class="block text-gray-700 font-semibold mb-2"\>Genre\</label\>  
                    \<input type="text" id="author" name="genre" placeholder="Enter book's genre"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"  
                        required\>  
                \</div\>  
                \<div class="flex justify-end space-x-2"\>  
                    \<button type="button" onclick="document.getElementById('bookModal').classList.add('hidden')"  
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200"\>  
                        Cancel  
                    \</button\>  
                    \<button type="submit"  
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"\>  
                        Add Book  
                    \</button\>  
                \</div\>  
            \</form\>  
        \</div\>  
    \</div\>  
\</body\>

\</html\>

b. Read and List Books  
1\. In the index method of BookController, retrieve all books and return a view:  
    public function index(Request $request)  
    {  
        $query \= $request-\>input('query');

        $books \= Book::when($query, function ($q) use ($query) {  
           return $q-\>where('title', 'like', "%$query%")  
                    \-\>orWhere('author', 'like', "%$query%");  
        })-\>get();

        return view('books.index', compact('books'));  
    }  
2\. Create the view resources/views/books/index.blade.php to display the list of books.

c. Edit and Update Books

1\. In the edit method, retrieve the book data and return a view:  
     
     public function edit(Book $book)  
    {  
        return view('books.edit', \[  
            'book' \=\> $book  
        \]);  
    }

2\. In the update method, validate and update the book data:

    public function update(Request $request, Book $book)  
    {  
        $validated \= $request-\>validate(\[  
            'title' \=\> 'required|string|max:255',  
            'author' \=\> 'required|string|max:255',  
            'description' \=\> 'required',  
            'published\_year' \=\> 'required|integer',  
            'genre' \=\> 'required|string|max:255',  
        \]);

        $book-\>update($validated);

        return redirect()-\>route('books.index')-\>with('success', 'Book updated successfully\!');  
    }

3\. Create the view resources/views/books/edit.blade.php with a form to edit a book.

\<\!DOCTYPE html\>  
\<html lang="en"\>

\<head\>  
    \<meta charset="UTF-8"\>  
    \<meta name="viewport" content="width=device-width, initial-scale=1.0"\>  
    \<title\>Search Books\</title\>  
    \<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"\>  
\</head\>

\<body class="bg-gray-200 flex flex-col items-center min-h-screen p-6"\>  
    \<div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"\>  
        \<div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md"\>  
            \<h2 class="text-2xl font-bold mb-4"\>Edit Book\</h2\>  
            \<form method="POST" action="{{ route('books.update', $book-\>id) }}"\>  
                @csrf  
                @method('PUT')  
                \<div class="mb-4"\>  
                    \<label for="title" class="block text-gray-700 mb-2"\>Title\</label\>  
                    \<input type="text" name="title" id="title" value="{{ $book-\>title }}"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="author" class="block text-gray-700 mb-2"\>Author\</label\>  
                    \<input type="text" name="author" id="author" value="{{ $book-\>author }}"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="description" class="block text-gray-700 mb-2"\>Description\</label\>  
                    \<textarea name="description" id="description"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"\>{{ $book-\>description }}\</textarea\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="published\_year" class="block text-gray-700 mb-2"\>Published Year\</label\>  
                    \<input type="number" name="published\_year" id="published\_year" value="{{ $book-\>published\_year }}"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="genre" class="block text-gray-700 mb-2"\>Genre\</label\>  
                    \<input type="text" name="genre" id="genre" value="{{ $book-\>genre }}"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"\>  
                \</div\>  
                \<div class="flex justify-end space-x-2"\>  
                    \<button type="submit"  
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"\>Save\</button\>  
                    \<a href="{{ route('books.index') }}"\>  
                        \<button type="button"  
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none"\>Cancel\</button\>  
                    \</a\>  
                    \<\!-- Delete Button \--\>  
                    \<form action="{{ route('books.destroy', $book-\>id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');"\>  
                        @csrf  
                        @method('DELETE')  
                        \<button type="submit"  
                                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200"\>  
                            Delete  
                        \</button\>  
                    \</form\>  
                \</div\>  
            \</form\>  
        \</div\>  
    \</div\>  
\</body\>  
\</html\>

d. Delete Books  
1\. In the destroy method, delete the selected book:

    public function destroy(Book $book)  
    {  
        $book-\>delete();  
        return redirect()-\>route('books.index')-\>with('success', 'Book deleted successfully\!');  
    }

2\. Add delete buttons in the index view for each book.

**Implement Search Functionality**  
1\. Add a search form in the index inside view/books directory:

**Copy the HTML code below**

\<\!DOCTYPE html\>  
\<html lang="en"\>

\<head\>  
    \<meta charset="UTF-8"\>  
    \<meta name="viewport" content="width=device-width, initial-scale=1.0"\>  
    \<title\>Search Books\</title\>  
    \<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"\>  
\</head\>

\<body class="bg-gray-200 flex flex-col items-center min-h-screen p-6"\>  
    \<\!-- Search Form \--\>  
    \<form method="GET" action="{{ route('books.index') }}"  
        class="flex space-x-2 p-4 bg-gray-100 rounded-md shadow-md mb-8 w-full max-w-lg"\>  
        \<input type="text" name="query" placeholder="Search books..."  
            class="flex-1 border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"\>  
        \<button type="submit"  
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"\>  
            Search  
        \</button\>  
    \</form\>

    \<\!-- Button to Open Modal \--\>  
    \<button onclick="document.getElementById('bookModal').classList.remove('hidden')"  
        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"\>  
        Add New Book  
    \</button\>

    \<\!-- Book List \--\>  
    \<div class="w-full max-w-4xl mx-auto mt-6"\>  
        \<h2 class="text-3xl font-bold mb-6 text-center"\>Book List\</h2\>  
        @foreach ($books as $book)  
            \<div class="space-y-4 mb-2"\>  
                \<div  
                    class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300"\>  
                    \<div class="flex justify-between items-center mb-2"\>  
                        \<h3 class="text-2xl font-semibold text-gray-800"\>{{ $book-\>title }}\</h3\>  
                        \<div class="flex space-x-2"\>  
                            \<\!-- Edit Button \--\>  
                            \<a href="{{ route('books.edit', $book) }}"  
                                class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-200"\>  
                                Edit  
                            \</a\>  
                        \</div\>  
                    \</div\>  
                    \<p class="text-gray-700 mb-2"\>{{ $book-\>description }}\</p\>  
                    \<div class="flex justify-between items-center"\>  
                        \<span class="text-gray-600 text-sm"\>Published:  
                            \<strong\>{{ $book-\>published\_year }}\</strong\>\</span\>  
                        \<span class="text-gray-600 text-sm"\>Genre: \<strong\>{{ $book-\>genre }}\</strong\>\</span\>  
                    \</div\>  
                \</div\>  
            \</div\>  
        @endforeach  
    \</div\>

    \<\!-- Modal \--\>  
    \<div id="bookModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden"\>  
        \<div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg"\>  
            \<h1 class="text-2xl font-bold mb-4"\>Add New Book\</h1\>  
            \<form method="POST" action="{{ route('books.store') }}"\>  
                @csrf  
                \<div class="mb-4"\>  
                    \<label for="title" class="block text-gray-700 font-semibold mb-2"\>Title\</label\>  
                    \<input type="text" id="title" name="title" placeholder="Enter book title"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"  
                        required\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="author" class="block text-gray-700 font-semibold mb-2"\>Author\</label\>  
                    \<input type="text" id="author" name="author" placeholder="Enter author's name"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"  
                        required\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="description" class="block text-gray-700 font-semibold mb-2"\>Description\</label\>  
                    \<textarea type="text" id="author" name="description" placeholder="Enter book's description"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"  
                        required\>\</textarea\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="published\_year" class="block text-gray-700 font-semibold mb-2"\>Published year\</label\>  
                    \<input type="number" id="author" name="published\_year"  
                        placeholder="Enter book's publish year"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"  
                        required\>  
                \</div\>  
                \<div class="mb-4"\>  
                    \<label for="genre" class="block text-gray-700 font-semibold mb-2"\>Genre\</label\>  
                    \<input type="text" id="author" name="genre" placeholder="Enter book's genre"  
                        class="w-full border border-gray-300 rounded-md px-3 py-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"  
                        required\>  
                \</div\>  
                \<div class="flex justify-end space-x-2"\>  
                    \<button type="button" onclick="document.getElementById('bookModal').classList.add('hidden')"  
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200"\>  
                        Cancel  
                    \</button\>  
                    \<button type="submit"  
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"\>  
                        Add Book  
                    \</button\>  
                \</div\>  
            \</form\>  
        \</div\>  
    \</div\>  
\</body\>

\</html\>

2\. Update the index method to handle search queries:

    public function index(Request $request)  
    {  
        $query \= $request-\>input('query');

        $books \= Book::when($query, function ($q) use ($query) {  
           return $q-\>where('title', 'like', "%$query%")  
                    \-\>orWhere('author', 'like', "%$query%");  
        })-\>get();

        return view('books.index', compact('books'));  
    }

Update the web.php

**Test Your Application**  
\- Add sample data to the database.  
\- Verify that all functionalities (search, create, edit, update, delete) work as expected.

**Deliverables**  
1\. A GitHub repository containing the Laravel project.  
2\. A short document explaining the functionality and how to run the project.

**Criteria for Grading**  

Here's a rubric template for evaluating web development projects using Laravel and Tailwind CSS. This rubric divides evaluation into three categories with detailed criteria:

### **Web Development Rubric for Laravel & Tailwind CSS Projects**

#### **1\. Functionality (40 points)**

* **Excellent (36-40 points)**: The application fully meets all functional requirements. All features, such as CRUD operations, form validation, authentication, and other Laravel functionalities, work seamlessly without any bugs.  
* **Good (28-35 points)**: The application meets most functional requirements, with only minor issues or incomplete features that do not significantly impact the user experience.  
* **Satisfactory (20-27 points)**: The application meets some functional requirements, but several features have issues or are incomplete. This affects usability.  
* **Needs Improvement (0-19 points)**: The application fails to meet key functional requirements, with major bugs or incomplete core features that impact overall usability.

#### **2\. Design and UI/UX (30 points)**

* **Excellent (27-30 points)**: The application has an appealing, responsive, and intuitive design using Tailwind CSS. The layout is well-structured, and elements are styled consistently. Accessibility considerations are taken into account.  
* **Good (21-26 points)**: The design is visually appealing and mostly responsive, but there are minor inconsistencies in styling or a few usability issues.  
* **Satisfactory (15-20 points)**: The design is functional but may lack polish or have issues with responsiveness or accessibility. Styling inconsistencies are present.  
* **Needs Improvement (0-14 points)**: The design is not user-friendly or responsive, and styling is inconsistent or not aligned with best practices. Accessibility considerations are lacking.

#### **3\. Code Quality and Best Practices (30 points)**

* **Excellent (27-30 points)**: Code is clean, well-organized, and adheres to Laravel and Tailwind CSS best practices. Proper naming conventions, modular structure, and efficient use of resources (e.g., blade components and Tailwind utility classes) are evident. Documentation is clear.  
* **Good (21-26 points)**: Code is mostly well-organized and follows best practices, with minor deviations. Most components are modular, and documentation is adequate but could be improved.  
* **Satisfactory (15-20 points)**: Code structure is somewhat organized but contains noticeable issues like code duplication or improper use of Laravel and Tailwind CSS conventions. Documentation is sparse or unclear.  
* **Needs Improvement (0-14 points)**: Code is disorganized, difficult to read, or violates core best practices for Laravel and Tailwind CSS. Significant issues with code modularity or documentation.

### **Total: 100 points**

This rubric can be adjusted as needed based on project specifications or additional criteria

**Instructor A Deliverables**  
Save you file as *\[Laravel Student Task\]-\[students last name\]-\[student\_first name\]-\[date today\].pdf*   
Example: *Laravel Student Task*\-Millena-Jay-December 9, 2024.pdf

**Deadline of Submission**  
The deadline is set for December 5, 2024\. Please send it to me via private message on my Messenger at [*www.fb.com/knightofdaraga*](http://www.fb.com/knightofdaraga) *|* Jay Millena \- Instructor A  
*![][image2]*

[image1]: <data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAApEAAABPCAIAAAA84gnqAACAAElEQVR4Xuy9B1hUV/M/fjS2GJUuSKIxMdWuIL0XEU00Ro3RmGKMsWvsDQvSRHrvvRfp9t6Rroi9IShl6Z3dBf8z51yWBTR53++b7/f55/3tfebZB+6ee8qcOfOZmTPnLnn9v3l1dnYKhUI+n9/a2trU1FRfX19VVVVeXl5aWvr8+fNnPS+48+LFi7KyMh6PV1tbC+XhKXgWaoB6elctuSSX5JJckkty/T92kd43/o4LULatrQ1w99WrV3fv3s3Kyjp9+nRqanp0TIKHV/DWXfbfLd1uOnvV5OlLPxq/4Ivxs8d9OW/StEVm5qsWfr918xYbJxf/kLDopOS0EydOXr9+vbCwsKSkpLq6uqWlRSAQSPBbckkuySW5JNf/m9ffidmApoCp4ByDowx+c1bWzTNnzoaHxx528DY0+/2jT+cSMoOQiYSMl5Gf8snnGqpqszQ05+rqz9fRm6uuYT5houHYjzVIv2mEfEHIhJHKZtp6vxyycQ8IimTg/ejRI/DRGxoawPnu6Ojo3bzkklySS3JJLsn1X339PZgNjjVAdUVFxYMHDzIzb8THH3Vw8vpy0nxCJpMBn38xXmvbDsuoqNjc/IKa2pr29rbX4Cp3dnQKKXV0dnYIOwXCzk6MgXd0CNtaWqt4vMtXrnj5Bs6du0RBSYWQSR9+bG5l7RwTmwAue1FR0cuXL8HthnZ7d0VySS7JJbkkl+T6L73+U8wG1Gxubn7x4kVOTs7RpNS9++wnTltIyBQy4MsDB2wvXLzc3NTUAcDMBw9c2CEQXL92d+WKNPNZqT5eNzuEgg4+X8Bv70eORIRndwjaOwQd589lW1kdq62uEwowxA7YDuhe8rL06NEMPf2vCPmEDJyxdbt1dHRCZmbmkydPGhsbwe2WBMwll+SSXJJLcv3XX/9zzGaRcB6PB771qZOnPL0CFD+YDQ4xGTDezd3n3r37nZ18gPNXL6ubm5oBrTsEQh6vhpCgadOCNdUPEeJ3+fKjDkFzW1sTId6RYbc6BPxOQceaNbYDSHxFRRViNr/V2TntxMn7PF4tADzUc/XqjW079hIyfris7hEHz9TUtMLCwvLy8qamJglsSy7JJbkkl+T6777+h5jd1tZWU1Pz6NGjU6dO2x/xHCyrAzi6efOuwsK78FUHeMiC9qVLwwkBcickQMDnCwX8vXv89u85094G/nR7aGjQuI+TGxoaWlrqCfE6mnAHMbtDqKpiP/+blJbmNvi3o6OdkEh1NTtC/JNTswDgO/jtHR38urq6M2cvKilPI2Ta7r2H09LSs7JugvXQ2toqQW7JJbkkl+SSXP+t17+N2eBbNzY2FhUVnT17ztnZe7C0LvjWbu7e5eUV6EzzheBPg4scEZE6yyTlZUlFS0tDfX2tEEPgrZvWWe/ZfZ7Pb+8UCq9cvvmBcnJdbV1DQzU43ydP3umEJwV8QlycXa4D6ENtt2/nvTvo9IJv0qIiswDO+e1tZ07f27Tp2IaNp0+cKBII+EVF96dM0ydkyjfz15w4cTIvL6+2tpbP5/futOSSXJJLckkuyfXPv/4NzAYXtr29/cWLF9evXz940GHUaFPSf5qjkwc4uCz0DUjciVgLmC1YumS7ldXlzk5wr4VtrU05uY8F/NYHD+8Q4qGmkrR0WRo40Feu3+8UCKuqKwgJfndQtJV1em1tJSExP/yY4elxGRpcv85m+46MYyeSUtNudnZ0zP7KWUE+1t392L59DoP6H3FzzQIUFwiE9+49WPbDr6S/1vpN+y9evPj48WNwuCWJ5ZJLckkuySW5/suufwOz29raysvLL1265OLm02+YISGf7Ttg3d7WBsAMTjDgtBCTyBCz4b/AQLcpk1KL7jzlt7cnxF388ovgiopqobDVLzBERW3PlEl+jofTO4UdrzuggpbwsIxA/5i8vPvV1ZXTJh8cPMCakH3NTbXTplv99uvxsxcKBe38tpYWQvx9fS4JBG3t7Y0Bgf6zZwXX1TWCTQDOfWNjk6HRV4RMsLJyOnXqdGlpaXNzswS2JZfkklySS3L9N13/EmaDhw2e6/3794+fODl9xrfkXQ0LiwN1dbVtLe0rf00YNChUasRRS8uzNPEbT22B280XtGqpryPElRA/5VFBlZX1HQJ+Y2PNlWu3I8Iy1204+s382OlTo7/4NH7M6KNjRid99mmSulqC+ezYLVuTfLzPnTqVy+OVZmdlrV1rT/pbCeHZhjpCAhMT8wsLb41+P8Xq0LkmTG1rAzjfuSti+fLUzg7B8+JnhHz8/hj91NT0/Px8Ho8nOQwmuSSX5JJckuu/5vprzBYIBHV1dffu3QsJiXpPVoOQD+Pikzr4HVW8yimTVn37TerL0rLQkABCjly58lgAsM0XdEXIhW3treXlr6JjLqvPiJAeev7dAdcVpfIUZbJGyQHdHCWbPUpOnLKU8H62oky2onT+sME33xtyRk8nxN7+RHNT/evODhW1Hwf1T1qyJGPWbCdC4gpvFQsFHRs2Bo4cHiczeIvc8ITz5+40NNSv3bB1sJSW3WGP8+fPVVZWtre39x6S5JJckktySS7J9Q+8/hqza2trAbCPHTtOhk4lg6edOnWOQjIfPtIzjhISf+Pq404hf+WKTb8uz+joEFJvm98h6Ch7Vebienz4kKShA64qyhYqyQNI32TwrCz/dqLgDWUQv2ULRsrnDRuUIz08fv26mGfFj1av20vILkLcrQ8dAye7qrKmHwn/aMyxS5cKjM32gTcv5AsFbW1yMlPIO6oHDjjn5ubyKis7OyVBcskluSSX5JJc//jrzzC7o6OjoaHhxo0bISERhEwlZEx2dk5tbf269Ykx0ZkCfhtAtdms5YQkl5WXqGl4uzpeEgpbXgv5x49fJSRYYfitD+RylRGAEYM5tKbUy71Wlu9ZhkPuHmVGyeUOfzcX3Osjjqn44jQB/1VZ+ZSpHp7u6avXbSRkf3NTA7ebji4+39snkJBPNefuJCqWxCCUmMQR0wQJSUhCEpKQhP7B1Buou67Ozs7q6ur8/Ly1a/eQoXqEjG5qarp//wEhscu+jyf9PWxsLgv47fX1FXO++oWQlOW/RnZ0CMLCM6CAknzeKPSqM7thWDYHCP5QlMsbJVf0LgH0TSckYGA/FzlZewUFO+nhjv2JPyFRg8h1+eG3lOXuyCvcHCl/XVmmC7bls9FNl81RkoNn07ZvTbxw7vz48b/2I7Hp6beF+Eo1zH0DPx9cbUxME3Y8ePCQkEnTDX4kmrbEOJCYJ5LZRyUkIQlJSEIS+qdSb6zuutra2oqKitLS0kl/LUI+TknJ6BB0FBTcIiToh+9O9yORttYXamurO4UdBbdvHk3K5Le3qusEAxgryQM25yJOd7vIWcqyBaOk84b0uzZu3KF583cEBgafO3+29OWD+oYSPr+psam2pZlXwXt0+87NmLjIHbsPzzTbPeidYKlB+Qqy+awGrKSrTkW5bOlhRRs2xj14ePvzL9da7Evnt9NNdGGHmKuN/+7bb0nI+ClfHyDaR4hZTO/BS0hCEpKQhCT0D6LeWE2v1tbWFy9eREfHjftcf+DQz2/fvoMQiIewBdeunh30zp4vJ3hoau0ixOvX5UGtLS3BwSfB1VaSz6RpZQCuiK+j5G4qyd2UGZ5NSIzFAafMmzcBm/FHQPASdn0C8c3NZwcHB6Gv3POqqikPCok0Nd0/sP91cK+7t8O7kHsIuXzq9E1wsTmo5gsFAkFa2nX6/rUoZeWYqqqGqMi4AQNUZsyzIAaeZGZU7/FLSEISkpCEJPRPod5wTX/24/nz52fOnBkhp0X6j6+qqnr1qjLA/8q+fRk3rj3q6GjhVZYQYqWhkv7syUser+rnFREjZfOVZLNGAckDmt5QlslTkisY2v+Mnv6BBw8KOzsBjNk70hCqaQi7+6qvr1/4/Xv6Bor4TtOODvrTXhTY8diYgP1wSEN9VVR02jskXk46F514BG/wvDMV5XJHDi/8QDkyJ7dIyMeTZr/84jxwQPLz56+gkwf3W4/5MKasvOb339cQMnmk7j6i707M43uzQEISkpCEJCShfwT1AmzAypqamtOnz/ywDHBufEJiymG7JELi16wK2rrNhhAXd7fL4HNXlL98+PBxaWkZIadHyeYBfI7CTO+bgNzKcplSAy+ZzrSor+d1At4K8beuAYiZg11RWXGr8HZOfm55ZUVjUwPc3rl9f8kLqes3pEJCwruRnAtxC7Kysq5cvnL50uXcvDyhsPXy5csmpu6KMtlKzKFHEwHwO2f44MxLl7OhHTAmVq89j78YJhDU1FQSEnblyoP29tY//tg2RXXuSIN9xCSEzJLAtoQkJCEJSegfSL0wu6Wl5cmTJ05OnmSI2u+/b2xpbh71vuOi+Ul8fptQ0O7q7jF5cjyvorZD2FZSUjbnq/BRsrcAsFmwWlkmV2HkNYV3c5xcvRsaqqk7TQGb8547+Hy+0dfGZEw/8hFRnKxk+pVJ/u388V+Sqjrp6lpZFVXV0pevwA/H8hSzO4UdIz9U6v/RwP5jB6lrauC7UQUdNdXVmlo+MsMylRCtRbvmOf1I4tlz2fJyKydNSkKfW8i/eiWPvBPx9GmFUNhe8qKEkInac7cQXVcyM5LMluSjSUhCEpKQhP5pJA7YAKvFxcWnTp0m704n5MvWlhaBoI0Qm+07LtAz2YKnT+8ovx/17Hn5iZM33iHnADWVEbBv4oEu2WxlqfxPx/9xpyhPgDvTQsDqzq6LOc/FJcVSk+RHjJd39HA+dfbsq/Iys5nm584rlPOkK6qkEpLkzM2/xi1u+koWhtljJ437QPXDD1Q+1NDV7MQUM/zJbaGAn5WVPWzACSVMIxcdEssZNuDm2XNXZqivJySUUvCtW087hO1CvoBXxbO1dSTkM1kdGiGX5KNJSEISkpCE/nEkAmxA1sbGxsuXL2/atJeQqdGxibidLBSs37iLkKiv5yS7uJyTl4308b345EnJ4HduKMtmjpLNocevs0fJZykOzTqanEB961bmWItfANi1dXVLf1m6fvvau/fuICwLO7Zt2751u2xtw4jyKhmgqvoReyxkr127xjBbKECHe8ykj0erjhVhNiUu3ezps0dms/wwN40GyZUxPp87dPDZ+KOXS0tflJaWtLS0dAr5JS/KtLVjCIltaGhZsWKDhv6SfuoWxNBP4mpLSEISkpCE/mEkwmw+n19WVhYZFSszUnf27AXl5RUlpRVCYVtDbfWBA/b9+1sR4r94SVRNbe3sOTGKCpn0yDUewVKSy5Qblr30x/008budAnYPzKaAXXvI9tCc7+fdzM7EV6V1oDdNCLl7T668UraiWra8WqaySrqwUFpf36CquoqdsQaEHjNx3OgefjbnglNQ55eUFksPTVOWp7CNvn6Ooly2glwyv72lg9/ezhcEB18a+2HELNPwzz89EBJ448H9R2COqC/YT7QdyKzY3rz4NyhRjPp+++8W+3fp36r2Xy/5P6b/gyb+dvq3eCih/0p2/Ysj+heLSeiN9F8pOb3o/3aMDLABQ+vq6nJycmaZ/0QGT3v69FlSYhoh8Zs2nhAKBJ188GsFAkH7a6FAzzBaTqZAWSZHCdxr2Wwl2Swl6VvRsTECPp+lm7GrG64xni3QM9VTnPaBssqYweOGJaYkw51du8B9H3j5knxZlTRgNhCvSuZekRwh/b799tvk1JT4xISkxMT3J45lsfEJKhMSEhPjE+LjExLOnT3X1tbGkPvp0wcTJ3oqyuZj1jp6/NfB6V+/Mb64+NmY0VaqaiF797p8ODr93Nnz2dmPwVKYOFH33SGqRHMfMQkmsxJ6s+PPKJGYJ5BZcRhXN4umBH/E4h3z+B4vbIFicAdsAvGS8C8QfkXr4QqwMuzbuK7KGfWpmXuqZwe4Mr0GImqCVUULsyZYB8SHw/WTdaPPWN5GbBTc46LOsBoSumQ3savDYk1wQxONrs8U9Kj5jU8ldJEYD/Er2hb7xJtdLBX15419Zs+ai4qJz3LXt92NivjfxS5sjrXLWhSNi1LvIbBRdPWKEdfbnsV6NJpIm+hZhhWYRRmIPWesE/VQTK4Yk7vZJXpcxC7GQ1GFInkTsaIXu94ycW+gRNp5Ot43P9VTQkSD6jGJXayYJWJXL37SsXCV/5XovmFQXcuzV/ewpGi6xYuJM1y8ti7mcDykYxfvsEg2ZomEUDSnXcPsHoi4GhGfNXEJFz3Lqn2byL2xWC82ivUBW+9idY/aRAX+ktV9mUxrED3bg7d96e1dxS69nQMcx/pKiDhje6nTvpXQYj3qFxUQlWH6RLyGtwvS304Ms1taWh49ehQff5QMVNczmPOipOLE8Tunzx7TUN82aXz4pYsPEI+FgqSUq4pSt7t/20M2S3bYtT+2OuPeNcVpVhsD6066M136qnTe4m/enz7mAxWGvmPe+1R2+fKfRyoPBcx2dFGoqR9BMVuGVy+dmqFEyIChQ96TkpdTVlWiTyFgM4J/gZTB59bXrKmuBm+9k3rbNbWVs2YfHoXvcmHnwrOlh2Zv3ZpSWlqCpga/PSe3iN/ejK45X1hYeIeQT2bo/ER0nGgyWh+OvJGY6pkZRQyDiFHQBrfrKx2vDPgxnmj4j19/DO/jXDJJjcd/TcOIis+YFUl/eNz42e4Sme5D1H2Jlj+ZGUFmUjnWDydfepEv3MkXLuRzN/KFJ9ELJFN9yefu5HNXvPmlB5ngS2ZGc3qZqzacGAR+sSrlN4cri63OkTkR+H43uAnFuiUpEeUGC4dCH6atT4c+LDh4jkz1IsbBOGQzJlXxCLGTA8gX3uQLV0ruZLwfMQrHsfzZgjyKz5rRJoxDyDSfBZbnt3jeUFmfRqZ6ck0gN6hAw0gnBZBx7uQjF/KRMxnnSj71IJ96kc+9sWnTCJTyHvJNFzPc/MKffO7Z9ZRb11PAMT86BLpITCLIeB9kFHDsUzeiF0BMwoh+CBnvS8Z7kwme+O34ANoEHS/0GXhlFESm+y60PL/Z88bEtalkihfR9iM6QTgcc7q2TaPIBGCLB/kS5oVOzZd++C3UYxCOk/KlO7LrU1eiz1oMRb5NoC3C58RA7BiUh/swBBgyDAEGAkyAIXzmTT73JbohdHnDKKLI5344OizjTMt4cvwRNQqkHYojgv585ko+cSWfeZCp3ihOJiFkZjhWIlI0JpHkSxg1lSvsvxfRCEFeQVXwB1QyngmYB84UcEMlkHLJi0zwwlFMDxabuxgUY8NAMsNvme2lzZ6ZZEkcmeKJ7erTOv9CcVM5AVEEFn2XQBbF4x/cU+xbOtemkWSCPxlPuQ2TqOFLTEKxJHQGJxE6Bt3zp6ygo8DJ9SCfuSD/P3XHRaTig3MKT+EypJjatydciwlUbiOJcRCstaXWF2BQ7/96lEyCQcGkBHOcnE2XGw4/HNf7dJ+f7S9tcL9GFsUQdR+8acbWOwU2aHQi7T+IBMzOJG9agOFKDLYFU/AZXV/QVdFAVIM40f2Mii7ICTyoHUAnhXKJAQYIEswm0xIgilCDJi0AzEHtwZatB1ZrSkUOPpckEq0gXDJMooA+poya5kd+TCEm4VhML5R85kM+pmXg20+o1IFkwk09OrMMh3BcVEchq2nrU32IfiCyGscYg2N8gwBQVQmVgHJQ8/3N8fI612tTN6QTVZ+PVqXhdDORBs4sjCd6weRjd9pPJ04/QM9hEYG0mEVgGRgvcICtOOSAN1GlGg/69iVboS7IAViVZpSxuBh98f7nICEuODTotoYfSgjqySicGjZxMDtaoZSNtBJYF9AQdi8aP4HDn4i0lkj/eKOson6j4I0SEgqVf3foHAjSV3tPk2neZDHMexRW/idy+B8SQ9mysrILFy7++tt2QibeyMzasd22f38feZnAQe/4Dx4cNaB/yi8/p+fm3SMknXslGR6yylKUKzjiEAjeLkNqVhXDbERxYUdOfvbgMUM/UB07WvVDJMBdlTHKUz7YsvH94mIFQt75btHwhiap8ioZwOzahhE7dsPNQWnHFT3dRyl8qjx6+sfgmiNgT//wfdUx76t+yEjLUBsxW8jSywUA2/z2poH9ExRlczGZnPZt+IAbzs7HBfhrJUL8zRI+xtWF9P2mVraHCZneX/sAMfTt9ir+nGAlzwwjOj78ttf81td+R/OJgYvGqpj21tedgtfEiK52XKWxqEP1fK8XlEPJose18l/7Tlke2VAvxAfbXhNdX9SzpmGfLYsrfFQDVUENcP9K3svR84O+3XOsvl7Q3nXTMfYWMQghs6j5BqtRz/d8VincT734+J2Z7pdyX8LfgvbXPx+5SAx8qSQxxR2LK9/QL/cuT9j+OiT9jtx83/z7PKwWOqDljWsJewsAFrnC/uLdxzWiFvcHZistZKbi29mCii8Km9DwgtbhqSkrosYt9m9tQc7AHaLrg99it2OJYcgPVmdbWzpZE8WljQstMn53uHC1oELIf/3RT/E4LtSSYr4d2kaRKx0uP3hez57KKSybvzttvculoie1grbXSnPDcPmZRrwzJ+zO41roACtWXtlKdNxGLwwNPf6gsVEId3LvV//hkcmtMbNIWLdWwTehh1DJRufzQ2Z5OcfktdGB33lcTwz8KFtAm4Stcrzc2sz1ua5OYB2WS4wAHSMUFsd6JhX1aFHD9aNFoTt9bjQ0dMAd+NzsdfOdWdC90LE/xhU8qBbxdovHxcUHTrgn3IbWky48Qc2L4BG62fNaA+0tUFhG0bd70n+yOVNW2QpzRzT9UZxMw6esSHpUXM+kpbqmfe7OZPf4W01NHVDtpdxXxIAWQ1UY1f+r8ITzT1gPoTyvus3gj3SGgnN2nKiu5XMi1/o648ozoudhtDn1zM1SIZ3H5IvPvwPbjskGGJeGgceuPmcyNmtbcn9Tj8SLTzr4tOS5x8QggCqmt8sJ6m5AnVBLr4sC2h+15dHEKLDbIqRz3d883CosD5oQMeqjJSHEyHu965UKXhv8+6KsxSIoF1EcumQaEn3qIRsdPLJ4f/qh4JuvKlrhTnNzJ9GHxRX0FnVJ7QOoATowPwzKw5AX7ssYaOYVlI4TCnQj7yUdFEUsWjL+7GMsyX9NzDzN/4hnXPJKyAc9gCxFxQ0UttU7UyQSIOpkQRiqcphcKKPqLhpac1PnDp9M/Mo0zHT78fhzjxlbmps65u9O2eF1lYliGYox0xIwpyHn6TJnnLn3pFZ9ZSIx8t/odrX4VROrFirZ5n2dWi0hY78Nhzsnbrxwi82ro5oEnko8c985Nv9leUtpRRsO3yT0sx/jbcNzmSTAoCwDri3Ym+6WcLu+Xph44TmaKdB507DfHC6ChDNpufeoesmB40FpdwWUV3FnnhCjACzW125DOyYCZPJVZSs8eCGndMgsjyFzfNjoiI4/Sj4MzSSkqlYA0usUnVtT285aybj8+EhEzv1n9VhS14+YBOusTcEZp10FSrn01GxbBqi7n2zOt3bdBAYejsonhmiDfv5DjH9qkaj89/vSt3hcBhUNFV7OLcM0JjDXmFFiGqG5NrWkrFmkhI/CqjQHMQvvZxa6yukyqwHoxq1X3+5JW+t0sehJ3Wvh60Gz6NTAijMOPplZAg++LG9WXxlFDFwfPceeq/0Sh9+iWuu7KP4Oek0D4w8fPkxKSiZEzXz2wqamxtpanrXVQZlhqYcdQ728Qleu9H78uHSmafhI6Xx8kTj3RtJcQlJqa6tFSM3QmouICztDokPIqP4ssj2a+crTx4xWHUvelaqqVqytkyZksLqaVGMzJqBR2Jb9Zv5IQoY+eqJUWz9MXm7EBxM+GjXlA3hQWXX06AkfEeV+UCGQvpF+TU2N2MY2gDF/wyY7qWH0RWzy2e/LZyvL5o4dmyzgt3Ip6NwPeyNsvywtBW9efbEd0XWmGqQPU3oT9VyNAjbbHmOzS760IFq2RNvhe6tTiNmGASimzHg09Mu/XwXFnpY0kEk2RMcZHXpt55paPtwkcwLosgkhhj4/bAgS0vXc2NhBTJyILhRzjD9RyJbo/Wd1RO0wdaQiqXfofzX/FadBVGyJ1mEyzTK3qLydKq8l1meogxtF3YgIouGJct/6+tT1p2QGFLYjEw+yakvLWoiqC1ZrRr12Xbe5G6OYaOJANJ2goT/TxZwzF0xUXEELwFN3HlZjZ7QOr7dMZOop7x6P6HlxVi30Ss8j5w72Eyjj/D2iYYMMmeEIA1llfRb1Gsale2I2rGod1y1WR9lTjgHniIYtfcoJmlP5IYqz9I0DyFS7tq6lBQP87Ht/ouNItByImgtYkkTdiRh0OUYmgcTMl/Xw/I1n+C5bmH0th09+CYcHAaGJrheNgtDggZ5b5q0yVmd0RgFRd6AOUATqKR1nXlWbqMXT154SHQeYONXlodCTuRtjsEXgD6hmQ7BdXBnb6+sEZNwB7JuO85nrxdl3eJxShra0ncAIYxXKLvQhmoexmJnvy4pWMsMX64HBGvhY+l9hVb2qaCZT9gNDTH8LYk8VPqqlCjQC/QPjQDLNlhkcUH7+riRi4IVt0Uo+XOwHbGdPoU0AAgZcVT+82fV8XS2faLsQQ+pGALuMAiasiOVTBX3A9xKOEdilcWSF3Ul4tughj+h6c3ZqXyERTSUuB3+wR1mL/gm5RNeD+rIs9kvnGlBWz+1C9gtWBujukxqcHW0n8qEVmLBEzZHoe1M3OgyHaeTMzCPsv4olitNkKzatvGoB0fZErsJq7QsksDSAOZreTGACU29jUgsMSvPIT3uS+BQRibY3lYFIXKTfhLDhG29LQgnXtI0/fZdZpcFJBUTPmzIqGudazyPm5F3WeSgff/oeLiLosKHvvM3xonFZep0BPUDnPZToe8z43ruDzkVjg5CoWhJNuwNeZ9kUx555TPSpFBn6KRgdaWvBm2ANzNkYSfQ9Ua50nP84groICIAWJxHcD+Og+TsyPGNzicZhomtTWoagDhXutIzCH1z4JnCj+w1kIFRr4E3UjzDl09L8mnxxkGhTSZgXnHuvGsdOMZVoOQcmFbBWsm+VIqs1bB8+RRMf+GC0Og4Nhd6BjURcziDV84L5tNhAQ1tsHSZ0lp8QlyQnjXqrjjaB3gMJVLd6UdrAWll5MJHMOEQ+t8XJBVEEfNX3ItPsmHEDn8TICbiNS0zXNaeokj11Dpazmj0WBr0BQ9NwENlJVEJsyQI/xmqQHGJCjYaZ0TSG5PPT/iRWGMCYqNkSY/otcEDHtaoaLQkgK5g4dWvUz6pOUHj8NyHIQ1AI2p6sYz/sjicaVkTLnqg7P3xeN2dtAjXp3hiE+DvoNQ2MX7lyZc9eWzJE/eLFq7a2PoQEEhL76TgPqRFJa9efrG+or6isGP4uvsCEe+m3bN7Q/qciIpNEvvVriv0MrQsKClT0Nd6fhnDbTdPHvK/2gaKiVH7+qAre8Jqm4R+MUnhv6ODiF4rlVeBqj7j3QEFBTmrffvn6emlehcy9B0qqM+Q/mvTp+yofAfBr6mqiTdABLjx61h0YFBdQwG7vELRT2G794Yf9o/A3SNgPimQryGafPpPV2YHvR6MvXuU3NzeHh98sKHi6dtN2Fa0lZOpeXKJvwycR4YKPJtruKecfobyCKzDPgWgcoorMjcwOpsgaQW1z/++2JrCZNlsL6tieGHrjGtN1IZPsqmv4zvGFdNkAZnsvXuvPlk0DKCYTe0R3bYeYjAK2bu+B5lK3pUgM1fot2hLLqr1ZUIoaBCqEysftFRmJRN2lCyp8QfuwwgY/eVNwcgF5ijtdxG7efVQF3iG1dsNA9GetCWb3O0FqNY9g9/qqvG5WxKPDquX2orSxnXnVZBeudmhC7VDc8XxWVQHAthGVfsRs15w7iH9AGRfuoXDruaPqmR08+NtI9J/EMRvNI+oP6ThvOcTpO2f/00TThj7lQXQ8Bn5Few5lQN2r2V7MLs4qKGElgeasC0UdMeYQ8kTHBbuBYBYmZe5dU8vFMMhH+wAncF4Az/ScC4rKQSHqrEui3mo0zo6e6/X80nbK2MjUXEA1OsVRqBd03U5ff3Yt57lIL0z72Z9oWo/8xquhQTj++0DUNRgGCKdq1JGtasSecXsQIXAInuR7GlUDIwC0m9aRlPMPWFUjF3qggaXrivwx9XvHjAIVwq23pf8FMczei8Wm7mOaCGcBgZn6dgBL061EmG2+NQYlEOcahZN8dAA6mVXAAWRlVRtOh6at+eqwcqgWGoXHkbEhmiujwH1pRyfmNZl8ELsN7IICOk4gxuhNgrdhRkM7fYWEzaM51Vy67i3NGA9oR9tU+PlC6kGigLEy8VhG38PG43jJS/RRWMesvE4TNSsy6VBNTTu1JHypCUhHZ2Bf34BhCVTrqgcomtodCb7Enn3d8Rr7iYu6J5CgIQhY7gcIh8+C4fuFBdX+vsg6HeflO3B9/bAngxpJwUTdvZUiJbJo8j4UJJg71YOV1FyDOXUOu47ix5xpA8852+Kg6XbaB4BYgA0EGy3n/LuVj59xsZadh5PRGqNhNqLvrvadezdmqxzACf14Vyn1nsHcnPZDMK5EQ18lI1vWE5hTs3VhWC04izqOa22SWbW1dXwQIVAR2BO9QAQt7K21CLN3WUYSHVAC7hhFQGMXxQlEuguzO8nnFqglYIphfpdSixykBUpqHgk8mstayb5VgmtQy3bm2hAm+c9fNhNtMQusm9Ugcj5+0dfZg4v+gEV6kHbAFfHSMJCTRv0gsJ/wpqaNCLN/3x8PEI5rc5ondgBlwxPEgLWImG1ojyd1QR50XbJuc1rl1NVHRM0Ouw3rF4dm143ZKCF2RMP6m22cZwLyT/Q86epDPny/K7Ybs6FpcAPQgYZl7szrxuyTRL1L/3wT1n82xWxDv3GzXVmB2GN5ZJoFVcuuKE6mwbhs//cwG0C2uro6MRGcbFXSfyq/vQ3gsKW58WXp04jIhK3bPFau8Gtqalm8JEpJNle0ky03/NruPa6YlSaO2ULhk2dPvv1xgdxEpdGqY0ahh81lkI0GwJ425j0Z6Xf6D719R+5ljVQZT3bDJjnwdy9ekH9VNQJg+9hxRUKG3Lo1klct/apKuq5pxK6dH78zaPCH08d9oDpWlDdeUvpyssHM4ydPLft1xdWbN0+eOj1vwRKTOfNu37nb1tY05J0MRXy5KX1LmlzehAmxlZW8J49K/XyuEBJNSPCsWQFHk29UVJYPGDR97u/O1K18m97pIobZeh77nDnbFlbC3cc1X60OBnMMdQTnyQWBnVXBo3EejELbovCxECgsVFhU4C4wJAOxMPITw2whMbHD9axt3xOz7TgPScuFGZXwVVBCJkoGrFuQZg0b1h8g8+1HqQ3uCzLNqsU+aFijqAGKgLSpWrP7oFPUVkdzZqmeWw/M1nLE+38SezCLARhebnWMU5HwyOQDyAEYl47DrN/9mRpCfTrDCQEbMEnfTQyz7xL1Q9glXe8Zy+O5KIJ4bBy5HY/M1HURYbaT/0k6ELfB80L3BuYQUxokwG2ncKLpfCmnNDjh+oXrXACNxiH2kQ/24/BhcTIFZBxwwPsCq+3xsxoy8SA3EbBujSlzUBUyF5Nu4uq5i2F2HviXOGUYT0OlcCazOPBotspCK1Yh8HPp9qiR89wRs5eEcjEMdFX9xDCbT8buRLNM18MqNJ/o+SPgsSFoO4gwW2EBqDDE7DmbklYdvkBDrCyJwcfS76IYZlugxTZ1P4fZMFJNZwohUTje3pjty7UFX31m29TUMW+1O68aY574LM7UAfPVIeWVzTiPqNMxqHM9t5gVOHqmiKjZ0LSJME6M9Si7AFH+xM9mezRGAUu3JS7bGXEl6wmrLe38fRRdLqba5Ysb+dl4nbl7v9wr9AwbI4zILeQCmbAPMRtccxbPZFuk4pg9wwqNRUDT2Y7MwgAZIBMO0x/xE8vJYOvXODDl3D1WP6hj1MI4qAjqUwZhrwC/u2JgmQU4+0DJ0GEoCd8Cadj6RV1k98FwocEkajsa+c3Zgd7L9O8Os29XWqaABt9mn/G8pO7pc27viWK2EzU+IoCHPTAb/GyY0I93vaRAC5Myeo47iihitl0PzEZDMBCGvNYmlVWLmK3t1M0ikBkjMETsuzH7UDRKuDHdv8MyVDLFMfvTPegj6nlscrpI9Om6QGkJJ1oO3ZhdUIIKTeuw2ToOsy/llhBtVxStHkFguk9s6PPZUn/2IHSgsrr9t73xGGMAQGW2L+7jRLOpB73RjdngZ4P9gaqJSiyUBJmcwsVRqJ/tgKAIHNBzzyoUw2ywqnEuopA/4piNEuKEFsmMfewO3gS1DO2aIjO/3xUn5mdbY9O4iEJArsQw+wRakKC1zAK+WELXET4L8uDAxKmdRkFcI67jROhTnYNs6btB8zdRe3t7aWmpm5sf6ac6dbpBZ4eAvuUbz1m9xkNbwva2llevSglJw0RxDInnvC+XNVI2sOB2rvgeNjjrLh7Ogz4YNHLiqG7fmh6t/kBljOL00V9OlnF3H03I0CVLZHhVI8p40pHR8oQM8vFTKOeNqKge4eoJmD2onCdfViVVVjXi2NkxAOEH9ir36z9stFo3ZvN4vG+WLCu4fXvRsuW/bdxS/KJkzsJlufkFNoedwWz45JN9ohzy9+Wz3yEX0zMyCXEe8l7Eqt+jko9ebwEhFfLBLydknN5Xm1CaQTj68kWcQLOAkIHAqXZHYoFgyR3yu0wMPBBFYB2C0td1QnObw2w7nD+2O4jyF44+JWZdUWE19u/G7AYBmQX2oxPROxJ7XAyzNQ6jkjIO7j/TnQWi4SvPiCvcCgSh0ebiZkBh6bfQvjbwVPzaU6T4yJRDqF6hEig8ZGungOvbPu8LNHwHDqXHrDUhrAaK2U6ov/5kJwZ1X8CpyxxAolsz3ZKLHOi5vT/HgW0k4/ANXPE+Yra7CLNPX3kw+RtH1e8DHUKzfj54ikPfXsKNGhYw21WE2SEJ175eE/TdtqNnMkvSrzzndApLJtJ2R8xOzJI23FNahq4/kAuoe+mdFLOZ94ku74lrT9m39x5VkmmH6OKk+hr+AL2AqjCAYlssc4O6MTuNYXYE3WhHBX0m80Vgci6ZvIkNFqiS1yo9x6ELs0M5lQQc7sJsmGLjX73nro9aa3cGzC/MekPBoFlO2o4izP7ZInbu2pD5m2IfPKu3C85CvYnSAqLla+kvhtmTd4N3Im1yuEtUqjHew2wF+FSx7oHZRjSXDdsKJeMdm5o65631/2ajX0vXhv2ouU7mvweWV7Zw7qwpBhgfPa9j34Ym56AcMusK2RXYxa5AOoS3mHeI2WDm+safuke0D246GME0I04KdBV6IsJsqMQ40Mb7/N0HFWTippv5nK0A3jn5fGdNTRtiNihBXEQx2A2DI92YrWZLvR938JAauhJBiKk7SjvGbMU2XDBK7/uky+W997QWbSPkGM3eYIYR2nDhzLd7WszlUgSnFuBuhVEQjYU67LdPZPdh7YMlzbHFOHDOrlTQgeTj39l0o4xN2nuzoDQg+nI3ZtunoIWBAbkoWKdq33n09LMPz/jJj3nqqRceovVshDEbJaPD3Zi9nkIFSKyea2/MNqGvZMbUOeQnMXAQw2wEUdQ8LG8OJBwkU92eKR8AG5MVPl+vDVttc6qmlk90u3IjTHth9gsakrE5eYmze75eH06VZy/MZtuI/kTDHuwt9izrRmDKbTLTm9oWNEcVKZZ6tC5imH0U7Vp0gWieLMK/H5liLYbZjqiHMWbukdW140Yx2x5d25nUHNE43I3ZYG4CQoNiVDkg6ozh2kjOPEXMju+B2cykAPnUcxVhtl/M1a9XBy3cmnA+6+WUHzFFg9q1gVBt0SOeCLZBJYIZob8inNuo+hMt+h9SU1NTYWGhockv5B0VZxcPGkNGwBYdhhYKBZs3JUkNz+76ta4bCrK3fP0iOjuFnZ2dfD7/4eOHZvPNyOj+mNdNU8ZGY9IZEJf1rTx99KYtoyqrFHh1w7ZuVQLYfvhodHnVe89KpT4cI7v81+EV1dK11dKLFitOnDS0qlamrFKmql6+Hxnx8OHY2sZhx06NGjB4uJa+BvupzUePH5vO/yExJT0pNX35uk31DQ2Lf1kxe+H3z168wKy33KuDSEjXua/skXL5BnopK5ZvUByZhGF7euyb/kyncOJkU+WxMzGOCjLaly89iAZsYToBgyfvi0vn5JgROnYYVAxAYdI/AnOP8wfiBYYz3JlFE2UZMUnlrP6AxWsDuGXT3JmZ9/x6DtKLUk5Z4O4aYja4qoFys0CAMCgH1frH3uACoTSA09aV3nXx5jM0UfXcPvrGnZMh6MMMW7pcw3AZf2oh6ltAYg4a4zgit1lrQ1l5zs8G/fgn0kZ1X14h54WgoE+l+Ie+IBgHR16VN7MmFOZ4UM0eLI7Zj55WxabnpJ29+/h53VKL41RpRvfem2D8Acy24nYZUs/c3u6Y4Rhy9XFxXfKFpxTpWWorQLvXpbxXwcn5ZIYFmbiDrR/4DD96g8KDO7dfYOB1o+AVqw397Mm0z8ahgUmFAfH5frHZfrE5AQn5KmvTuRWr79ETsx26MBuUQuCZm6WBKYVE/SDR2FNcwmHbsYv3GllsHKYGE8KjqSnjxJR4U6Nwy+HknS6n4k8UZd0uJ9o0zRUd90hxzD4ceG670/F9nueqqtttAjI564Ty3NKfC/+WVzSrLDwcmZLNb3/97EXdNkACVWsKzDRIgJht0xuzubbCyWTXpsbOeRsjiOqeMfMdWKOgs6BvGBtHUaE2h57Hi5ecAYR+NihEDAaGhqYU+sfn+cVk+cflBCYWfLg0AVt849YSAmHE9CVhCAMqe8jEP7ILODAe/603h6noBydSly7Ixufi3YeVRG0f+WTztRzOusq787IWMFvHtQuzY2kg2qEbs9Xt0CTV9yZTLevrMV8ESB6mAEQRMVssQZ3KZ/ELbrKq6wS4uIC9uB5pGB8RgqIIHgRwZ/4uUNypu+iDopoOA3T5ZVsYu4+rfgb1CEEwjIPn7MlAzJ68/c5DLh620zHlVXkTUdvztLgPZsN06Ht2+9mNQoOfPQ/7nIURgfEXnZ6PCxmcfhPcWFUyFsdsjM8hN3phtg7FbDZeHAJMlmNpGbcSdx2KRYZDoyzwAKoMMZXbzwYFstU+BaQu/vid5qZOouPHhZRAnLQcRZidd7tk2Zag5NOFYEvBClq8JQLDG8Z0H623zR3PzD4y7YBb8DmRgmqnoKv0bRDNE+w6MofC5iqG2UnIIpEdYB6LamqKzZsw27MHZmvYc342YrZ9N2ar26ByBsNuxiFRNzbZpaO1QbcRe2K2DaeRTDEAKcLspNOgf9Idgq8+K2mYtJQm06CWoJtN6jZGv3jV1wu6kbvt9V7Xc1TC35gL+XcQuK0XL14kZCrpN+Xu3fvs9JSQ+0EtxO9nz4qVRqYD/uEvd8njD4EMGXCpprZSIBBcvnr5o2kfy08Y+YHqh2NmfISR8OljP0CoHksJ/vhI4ROljRsVqurAsZYt48lU1Upb7B81evTwV69k6hrf27JVaer0YXUNslUNI2Slh7m4KECx2jr59RsV798fVVEpD/9WVg9LSJeXHSr18OFD/IUwofDihQu3CgqOHz9++9at3Nzcurraq1evoYWBZ8FbNmyyVpYrYK8iV5bNGkCuFd4pvHX7YWdHR1sr/+njyosXnrg5pUdGxxIyZQBmj/v/9cYDc/5gMYCXoGULKi8o9pIotfhqQRmGiQw8iYptBY9LUNJcjgEczo8U6QWk3piN+9mGaMOCJRuTkcumvxuzoVGtI0WPOBfhzLXHKHBwsydm73I/A9ofjUoDLgUD6vniW3fsFcPscd2Y/f3eoxSzAZzce2I2DbLNYicZxE4iiogG1vZ3JcugtzFmH5e0YuD17kwnUDrtLOKqYkd9gmBi0I3ZGeeKyIx9qGK03HVXUk0Kkt2L+X0w29n/JFGjCVzGXkYbkzmHEg/DAGb7XMorCwYTXseBaNjsPMJt8uFwBK8xHIf2BCab2AdfYvdBRRLlfbRvMEGexy5hjgK930ET1mgE+E8w2zjwTNbLwLQiHIWmNcCMKKurQ/B6/HcsZ743ZmNsfPRWmunjbPJHCkYgcQj0OIAYZo/81hn3DrSPjJkfpLEijrrsUV1+9gXG89ra9is3ubyKfoaWND/AjepZBjl/gtkRZIoHYvbmeIwWahw6daU7I7e8vBnxz4RlSHlmd6UIYG78VGvUzsAuI6/7T7lUies5xT2i3D1mkHnPQVEnHoA6yy4syy589ewF92DcySL0ULktZzrXJsE2vpfvPqzCKQYbeupekdOMgoT7NYFvxmw1GsrCQL1DI70JBG4ZtZV7+dkRMLlpZ7mcf0TcSZacn8223tna5DDbI/8OZ+Hde1wD/KQZiJj8sXZvNLuPDWFEmp5sNA6Zs/cEYrbK/gmzDrBoFpCD30kybfvTYm7gb8NsQMENNkkfLvbFRCotB8Aw6qjR7Tbj4J6YLfKzXf4Us0PegtmUGxxmc342xsY/3o6SrOuisjwazyCgpRiD/RTD7GfF1Yx1T57XyhkdwvKgQLhJ7Lt+aVAH1JTWYTJp51a7hLo6zqIC/UC03bkdsVkJzKN9E2azMEwsSu8bMBtWrkeP2PjbMBtgGLoBeliN28nCm/Pozv2/jNlWnsfIjAMYYzfwkPuKRlxwEunGFmYPOJBpe/R/dnvwmMuJA0bNXE2P+5r/J6/tejs9f/48LS2dDJphNntBacmrn35MePzw2clTd9vbmmuq6/n8ZvvDp0YMvjFKJmeUHFD2SJnbpqZ2tg4OkzWmTdObPl1fdbLe9GkGqipG6tMMZzCaqq86RXf6JN3pQ0bJEzJw0cIRpWWjeDXS5TxpwOCq+hEqU+RVVaVr6mUvX5cZOuK9nJhPi299PkJ2xP1H8rU1Mhs2KwUEKpZVDy+vki6rGlFZLZudI2f2lSwh/bdv315ZWREWFubv56ehoXH48GF5efmrV6/u2bunnY8/5SnoED599lBuRBZNRssCzJaXzbt2/Y6LU9SIoTGEBA4fmqata0VIenFxMSEKukvRN0Xd0Zc1IjJnJw4jf7Q8R/R8UEeADw0+wcQtbJJQr6nao72v4/z9Zs4Sv5b9FBchqt1oeoII1nZ4wtnnxIRq4R772QJijFnoYNHHZOR3YXYN0WD72SFQ7Q77FFZtTQ2faDqiaIIXq825SnzcurblMio1HZizC2Tje45qlkAsPJnbz37xsoFMt8abuGDce8TGNY/g8kYzOeRCbgUx7nkQazbbz8bMr2rq9wNtcDjZtYrcDX7lrBBwUzAehb5sj9g47mdr2GBnTNhJcXbEsxe32X52d2zc2f8UGjSw9sB/UvNyiivCc6vogIYTHS+K2YV0T9odAGz5To7/FLMd0ajHU17+n851ZluesEQt3U9ye//aDvO2clo4/dIjrIExvG9sHM0LdgQogGL2XS4qq31kxe4IdpgNMXuRF43+0Z3FHvvZAvLxbi5FRcs77141PSlLU/DEMXuhO91ZBEvLS3dl/HbXq13BarH9bPDe3v+Z/Q3Vmq9F/cKZFJyf3TM2bkjPAbJ9+sluFLMTcfhgfarsi0jNYU1TzKbOB5oIft9ti2bbLgBv+su8cIrBC9e0sw+5wmq28T2LN/GoXp+1Y06tDX0fABvyqS1u0EyyIGM3MeUIFRqAOYtcorNPY8s2PpcwNRIn0QOQW3mOfT3V8ojZmvZcXiTKXnCP2PgMa0Q4XdfFuxO6jUgs799zP5t68+gUOjPwgMJztsXTvYAIWjMGMxwibu12v07NAm+Vn/26KwSvl+0FaDt5h15gj8eAN8z0PvYf/GyK2aD0VS1sfE9zPf94K1HZJYbZyVzg1xTTv3vsZ0+3QNxlPvRMCpns4KhJiLSBfVMjym1b6+slO+gOHRTTdrDzP8+q7Y6NM/hEyya4T2xcHLPjsAbx/ezP9tIcNE+o/N7Tumm/JuGSAcnUEstBy3+6aI1rE90MAv7PWEy78WaLDc/cL9x5ipjShDhYg2Bwf7mRzT7mihvQLB80MWnwUlccs4/2xOw4nPqptmwRwVikZjqihEDTui73nnBuTO/9bPHYOO5nuwJvx33tyO60IZDb0alnmN1zPxv533c/m+agUf1j4XvDO/UhMcZdzg8XxyssjKJJ7M6YcDN126uudIRN9sdpcOh/51ct7t+/H59wlAxR37xtz7WrmWamJ04cPztndnwlr1Jfxy8v7/G8+ZEjAbBl8+hLS7JlhxbssfAoq6goK8fr5ctXr16+gr/LysrLyis4qqh48uypvuHUtNQxi39UIOTd+d/IZWcr1NbJvKqSquDJxB1VHDhQrqpq5IuSYf0GKNw6JPMoTXXR99LVddIZx5WW/TSqvFK+nCdTXilV3yh7PROAf8jyX+UioxWVFEcsWvRdRkZ6Wmrqrl277t69+8UXX1y6dMnK2hr8fox+gzPd1jygf6oSWBiy+JYV+CMs/OzePXazzGKioxMIib+Vf50QhxfFFYR8YvL9IZSqvpInTubs0HPovWcN+msSEbNpuiOZuI0px7z7PHTFQJJAiWvasj1vkE71H/3RicdtbDzMt9TyvEv8Xe5fI9/FazjMRoVubE9zJRyie+WNo98Thlvmql2bOqAL9BxpHpAHuBTMT6qtpbmjhjSJRs/NJ+ISK1wEvgtY7hi09/jDBRN8gFYeONqdv9orB02DOi4GvqsdrxwKzUOxZsFDESvQXQsFtWgjSmMGXQ/LjC5OOz/0v1FNOKShf2+Cm/HQRI+8cS2aIoQY85YXBrG88R45aKfR/UJt7hF57O53e09gzQh4obifnfcK/WzEYDwDQ6btr6XH6ihm0+159ORCYGjBSRw+3b5fQbNF0A9YuieO3bxx6yVOH25GYOyxZw7aYRw1M8ANfU/fLA1gmA0twqfKgZg0rJn62WzHjqXPAGYf6cbscXsQYPQ9ncNuFr9qpq4b3T3VdkgWzxvXpkakntfVvFcfLaXcpihi6SdieBMZ99sex6NsikE1ExMPzj9AdRPUIwdtC93LnEnPL0GZCU64n/1HPMVgbzQ9v9jF6qGYTUEI40lBZIZNTiGe0QIBiz1xh0tlV7d2jbzBavaNvkpTZCN627vMzQI5NPJ++LQGD/OgMWpHZuy7/4hzRCLTb3WdwaP7pkb+NDbO4wwp+FQ7ZOGc1s752Q40360Ls/XF88YtsXJth7w73HGyvKIKZHLf/R3mfWrYhafkMDY+LW5APqPlyqyioJbm10t2n0QOAORPPXS3q7eAW9SK8ibT7XKLUJKrqtu+WOCO6x2fxf3LObtpbFzNlmhYTvga8wzQoVSxAAgXYfYOLgeNZU27qy1y65GDhgYT3Qph6wI5GUeB057lsoAg7fc4hZYW9ETryOPnXLUUs0VbWom4GYf72UfEznpFI7cRX+lmBKxomqjVjdmYN+6AbNfyKq9qIzOpHwnswrxxbslk5z8j49d4R3CGQtGjappnQE809QjF0fqNQq9nv9jpegkTSoDJsORV97DwQ01tO9Fw7MJsmqMutp+98kAisgiVQxcHYCzqR9g2P9DkBW5U23iRGfbsTjuH2dS9QXPTp2feOJUQNbvEM/eQG62vC+6Wo6bFecfwW4+8cTUrutkRyXrVA7M1OP0D3DbfmITFTEJmbkg9d7OUaHnSr6CV/dn5z9upZM7bEPG/iNnZ2dnBIXGk/5To6CQnx+BJ44/r6EX9+nNGfNx5aZno0lKeosJxJZkC+gsc+OKzQQOOZmVdRYf2DT8EgiezhUKhxb4DK1YOra4ZCV51da1sabn8nj3yCrJSE8a/d//BqOo62Zo6qXPn5MzNZeob5X9f8376cvnirZ8kJklX1cpt3aZcxZMrq5Sta5C+dUdprPKwnTtH8qpkq6ukyqulwedOTJSdMGFSUlISdxBc7GJ34ENJxkFB9jaeTMP3q2RraWekJie9NzCqvr5e6X2LW3mP3T0jGxqaFi9eNWvhTpzXXiu8FzE1pON7MbcMJvh6/iupRSDWHjbU1KWWOIU60xC60eLx2VwnQIV2Gs5aZpFGjP3V1xw9d7OkjNeOJ7lNUAsPMA+MSefgGT4dgi8RIzelhX5PupZiQ4PQ/I9YTH7B9RMEWmPO6qCX9A0ApWXNhmsiiZbzhZvF0HrcyTtkqiU90kNdN+iDlv2PO6PZ+cInz+uIqiPYtqyrU5d4I2CzqKZp+MdLwxNOFLIWQdSM1oR/vSUh81YZdIlMYPm6Pfer0HyJxoWhZf/tpnC27B1Cr5OpR8C05NPj4/q/oB/AedJGQR8vi6iv40Kdz1/U666hZqzZ2zZ7uGM5X/4ccf4Gl2x8LfuZ7qqwLY5n7j2ugSZGzaEHN01Chy6I9orNgT6A1vth37H3l9I4sJ7rADPHisoWxGzcz6YniwCHYJ2r213Jfs76nHL2vtKiADLT5cFTzlpHDNBwY5sOn/wUyU71AN1/Um2ynqKFacR7C6KX7DveRjWdY1im0pJotMlAK82wruC1Imaz/WyEzwgyJyjuxG1WCdBqq+S5WxL8EvJgCCkXHtOgPSYlaKyMfFXBxUU8o2/orgpfti+tvLIV4UqVbYIEv/dtaME9lCig5saObzeHkGm7dJe5dVA9CJ1ZtPc4+mcIIUG/W6eLGs0sKB02n6ayG4d+tjwBBAZaf17SYLIpechcdN/Byvl6cxS0hfvZDEdxCyAS1dB0KwAGNMJaX7tG3CDmXp8u9RMFOXmg3HXpaWZxzGbW7cyIVXZni1823X9Ss2hn0uCvAwDyZeZ65dzi4u1Q5xrb0wO/pmBpHjZnW1pDvbC1pXO9/ZnPlschZIJJqmlX9JCHTNBxoYZXDN1EDHanRgOrZLV1yrwtcbHHkMkg2yv3J6CZyxLa35AkEYVop2m3ZFsEk4Ez15+O/yWKzAr66eCp56VNyyxOUJWNJwNx+GrWxS8b2fDnbIknX9jFn8TQ+oXMp0SXnsfDiY4c9E20yR+psNbgq+Sz9yb8GAwPNjR2HPK5QLTtVH8JFM3F0+J6zdUs6zhUeUm4T1wWs+faWl4br48mZoEoNuK7Ueb0JWv67lO/dRUF5Kb8Eqq5KuZc5jOf2C4+tL5W+TUSXz/APNeZkQO+Ct3vfU70IqOz1x4pLqFJdubc6+0GzQlasCOBmfvA4a1H0o3XRfnG59bVCZIuPMNQIgzNOFhnddSzLjStqGgeM9+JqOxOPXuHaS1YjLrrk5GrPUJlNG/cKDD9dBH0+f7TugnAYUP3RTvxKB08OP57HxoWYmlosf3MQ2d0nSoEyikqU/89mjKWhkmgw2hOee1zPcEKgECaro9esCsl717V42IuO6GktHHmhhj6prMwxQVhVn7cLlg7bl2nmW+KBgsDBtvY1GHpeYqoWtEIAZrLQ+eFwGyy4QAf1tmlE9MA6l8FTfglQpSkef76E71VYZuOnL7/pBag/V1TXxRRo4Ap8wPh2fp64dfbUoiJl+ryIMZzS0+6TYmy/b8TG7948eLK1fsBs+8U3a3i8c6dvxQYGL1ggfW4z6y/WxhXX99IyAXcG6bgpySXraFhXV/PEwNsDi+FHcKmpmZfX9/hI0b4eo29dUumrlausVGaVyVTxpMCxAU8vnZN9rNPpbV1ZV6WyTfWSf2+Wmn5ypE3vUfamo1tXTOotGDajz+PrK6WBXf8yZOR02bIenqBay5XVj2ojCddXiXFq5Oua5KqrR154rji7NnKS5YsKSwsFMNr+tMk1G5YtebwyBHs977Q1Sbk+O0796uq6oT89s7XAsyeQ9Oi088/apLGMsyRwUhaH9aIiGG2YeC36+OJthtRd3EIvpZ26Unaxce/7YpC45r5lGbshZq4SQympfZSz8N+509ce3Y6s8TO/+onCzFayGWYm4ap/hC1+UDChr0Ra3eFbLSI3HIwftJ8/1W7Ev7YH7N+Tzjc3LQvZvuhFGJAT2ig/4QbP+AojJ3j5BefA9Umnn1o6XGaqNI3wxjQNzyghU7fGggiBdaouu3KXVFBR/PPZ5XEn7q/ZFME7jFD38AHwsK4mbrhQCp0Y82u0JXbgn/ZHLxie9TqPfEb9idusUzGN6Yh4PX0s3EhxbOzatjEVKs1u6OPnn1wMafUNy5n0fow9KvQWw3AbgBDDIK3HEqHQa3bHbp2V+gf+2N3WqcCftAEjT58Rlaz96CF77bL+ONAHHTst21BP28J/W1H9Nq9CRv3J24FnhjTEKJp2II/UjbsT1q7N37d3vgth9JWW2TgOkFXzAPQeo9dRncCJ8br6F4geJaq1mv2xsSfvnc+uyQyo3D34ZQPzO2Jlg0xdMFXoUExk+BdtseA/+t2h63fHQZ93mGdxt6yNG/D0T8Opq3dEwctbjqQvHZ/Br4fDVo09JEy89plmz7crOvA2MyIqT9Ebz4Qv253+MptQb9sCf5la8Tq3fHrLRK2HkqeDYqJ+dnGITusUzftj129I2TFVhhp2MqdMWv2QOWJ261SaX8QcX/enrR5f9z6vUwworZZxhO1I2gYqVrP+tX/kOcZm4AbeDbXJKzf7JBth5I27otatyt0/d4I6MCSzUdxHg1DNlsdX2+RuGZPHPRhm1WG0UqaAYSbGm7TlwRtPJCCXUK0o9lYJvSdMJqHwR7dbpOUdO7hxZyX/gm5mw/GDTK2w5QOMw8qSF2ZTd0rBfcsNlumQlvrLBI2H0xetiURJH/5dpTtDXvC1+0K2WARue1Q6vRlGMn/+NvIzZbpwE/g6uaDqTttT+BbBU3ooTI1p20w3bhZQzcmZkWNnB2m83MI0T2C4dzph3SW+a3eHbvVMuHjee6464w7wTS57w0mODv3jz49wu1ky2V/hMWcuHsuqyTm5P2dDqdRqIyRgdTCoxvnaJgeJrr2ICEZl5+czXxh53dRDSAHHEFMAg2mI402XJm43ToDWAqM3bgvYbtVGsje1O/AyPboZ+y10zqFzQUV/rhdNmm4W2Qaus06Y8tBWP6RbPmDgKkvZR62uCFLc7DRDQB9YrfVKsEr5qZreOZP2+OJpv3SDcEb94at2Rmybk8kNmpEbVMcY5TWz7FbDiZutIiCRkGZwDrabnOcGNM3c1HMVvsxetuhZPhq1Y5gkMzl2yJ+3xm7fl/CHweSTFdS7UHjgtAr6DMsgfW7Qjfti16/L56+sOgwmWa1cF2wY8j1PZ7XuE2Z7j5z72E0WR6lPNubzHC2cDl79OzD41ef7bBNITNsqHKg76qjwf9pS6J32qQzFoFswFrDsYB+MBNPUcRINTy7ckdEQGKOV0y21k8YA9h6MGaTRTiOcW8MqgUDxGyTlXHGv4Xj3h9IyBRL9SW+v+2MWbc3VmWxNwYRoR7chmepJOFz1ybAAhEp4a2WRzHGYBo2eGbwbtuMDRZRVDEG/bQldCWnf47utkuj6YGYSTfY2G/275FE3XmlRXJ4+p1T15+Dwv/yG1ei54LSixbYG92S/5hOnTo186s1copqZWWVnfx2fE+YsK25qb6qqpJXWVFe8XLoAERrBD/ZnJHyOUu+PyQQ4M6xCLEF4NF0dj5/XmFsbEbwGkjIO+8NG/TtwmEHLBUybypXVL7f0CJTXSNTVSN394HifktFTW2FjFMKT168p2nyaeFvUldWfFK9avDjLaop6R+Bex0Wo2BooPDggVxt9ciyGunq+hGNTXKlr5Ti4+R2bJebNXv4e+8NpK0MHKU0Jicnl/n3IuiGT1+/QOmBl5U4zM4m5Ny1a4Wdwraysqr9Fmf3W5y6evUhFEtOOTZD8zuV711Qzvqyppu6Xs5lRHdoMDYOfgAgKH2XCCAEvg2U7sEwdMezVd74FVhbUAZKsjchoNtKX5eG20X4+iS6BuzxE3PHvFEXAABrH6E3nWkeL9NWdMsNHocyoJi0nPANX5rORMeNhhP9aRCbLXj2Dmd6JkcfXxaBhaEPWi50/9WLnuJlcWn2TmDq07AW8bVQrvgvkCGN8TLAewM3aBIy3cPGJjToMLVd2UYsqn62ks3piywAOMFVYk3gyXL2mtW4N2M2062gdtHZwt1iygonGpulHQMOoAdPIwpgAOl7020C+poF5tmzILARfd8cBhtpYjOaAuz10dTMZ31Wd8T3vsEcAeE80kiJGb61ER9nE8F4grtf4ufs6U42U9wwUpzNUDRT2Jk31EeUt1AbDoFOMTbhjE+xIRjREzU01EG75IplkD/OGPzE+uk7TFj9M+mBNCgj4gb3MhA6dug5PGJIX6mBFYZSKXLiJhQGa8LCv+H4B4yRq5zKDJqD9AXshjTFjBMM9tr8aAQwFGPcDuTYpYXbNzTV0RVbZ8LZC7M5PtMQN24B0lwHzKjwQ12GQ6AvejOgyXpoIYVwc40s9eF6y2YBWMriUujM0Qw76C0MnEkd8ApGh1LhTv/wpDYEQ6aeTjbXNyoDM/GwPleDJpVbHdouAhVtiFvFdB8EOezGDR9L0tWBu85UTliXWCydmomUsdQJwyEHoTxADWwuME2BCT870h1AA6ps+TvRue75QkARP7HDGGajmZuOdMl74WBRvRxBQkVB5ZP52bPoEW19fPtNtwzg5DIFxQyyEBpiYZLpgDUg/2lmFgoGzfE0xcxHnH2ccdpJVFD0FTRQmCkKQ5pK2cPPpuuXuqooPNhVD6LlhvqKtcLEDOcogeqHUBQMkbhi3JumtqEdQFmBRga+lY9qS2fkgDZVpwZ0gJxWcaGqkr1nKZjrNpMQXE10atjuhjF1o5FRNJ8UlbBbtxKGatGnoosIbTuRKhbTP5jZQHMOcFXStkAFAd/Al9Nwxh03qBB6i072X/1qw/+YMjKOTZry1bRpWjxelZ/fZV/fK8EhmVHRBfGJeS+KX+Tk3FWQyu/C7GxF+TxLSy8RQMJVX9+UfPSE2Zyx12+8V1cvVd8gU1Mn96hY6lqWlJev3IZN0pMm4DtKCRmqojr0t1/lM05JPXmqUFMrHxcv+/3CUWVrpCtXjyhbI39vuUzjygH5luNtjyhW8Ea0CeSK7ipEJ4xctFh2/BdDCBkx7rMRGzZL+wcpnbusVFIiX1uj0FAvV1Urs3P38GHDh23csAl/LbvL6798+do7JIHrtlw2mB3RUecPWsYQErXLImLJsv2E2Hl5X8vNLRj98azP51j+9cYDKiMuVwVni+kaE7olzDm4XSYVqgZakitDnQZWjIt90WXDdvLQi6KHkbBAOHPBUW6QqAruRmJ6sHImVbK9q6X2tfhqxybYqVOxPjCQQLCk+16omuPoO/xoN0SNcp2htkXvzSpR/dQywCYiuCFwowjHRrHPrIkupnXXT/NERIPqWzNWTg/FYefDe/eKdYyBIuMhmwuOD10/HISNUsJ/xeYF1z+NWnN9DuruuYg5TBGjzhJNRNcUcy2yr9hRe1GL7FeAqHWFLdIh4HyJhsBG0TWEmez3SBgOUXzqPVLaH1Y/VsWmSSQYNAVPXBqZ68BVSAfI1RZO73eZfVhJF7uYr/NWdiVQ40nELnpEp5tddAji5TkSFww2CrGusmGKakDjNYbm2HexlBVm8kP9sK5exXf/0hQOmdoxjLgHwyl4dAleX6ESlwERi3rLLWuoa/ictHQtUiwpWheiRUR/eIYTCbZw2HtLGEu7Rs2tVjanbC5oIqpomthcv2FRsEVETQ3xOcVeicsDrZYJHspVV3lslPYKucoMAlGFFJn6Sh1nHjGRFpfMLg3GRILjP9MnfRIacIC0CU4MmKoU9ZPNkYh74ixikileJyvGOsw6w8SPTT0bQp8VKhIPxigGsRwTWOtshXYtK5ESYJWwCeoeu4g/jAlMJtkCF41RxG0qIf97gA2UkpIuP8pMR8fk+bMnWnpbdDUOz51rLz08eODA+Mwb986fK1CQ7sJsfJVKfnBI1OvXr8vLqn28YlSmGfoGDCkvl62plC2rkmavDafU/TevdkR1nVRdkzQ42c9KZNPPKbp5yRvojJo6UeEXA+XGNcNqVw2uWS9Xv2Zw3eoB1zZ/aT5XUd9U6vfV0kknZe88HlVXJ9vcKAs18GpZtUhdbeHfFTUjahplswpkZeUHKCmNPXnqdEtL870Ht/uRYCW5HOi2sly2zPAcH//ThLgEBuZVlFcJBK3Xrl8YpZj87NkTeUWtMSYWf43ZSAzn2GFrdmqLWYtU/t5QuMuq7VGyb1V/Tr3s7q5qu+vsu857dqB34V5l/qQbbxxX3yb+tD9vrv/PqxWv+U3E1f+mzou+6qa31IwrU3xqWK9o+b7VcjW/7X5XzT1afFP3ukm8WN9vexV7YxlWv/hXrId9C3d1rPdXot726rkYiR75E3b1pd4NvY3e2Ct2v4s5vTv2xvK9nvpLEtXQc3n2HQ7XVs9F9K/0580MF/+qz/0/6794eRH/3/b4G9vtycY3FBAjruQby/SpvC/Tevfh7crhbT15Q529auvzCBJ9qm8PexV4Q529yvxJDb3qecsw39D/v5WSk9Pek9LT15/T0tLa2SF4/LRs8eIkQoLcnM50dAhPnshVkM7twuybI6Vv79l3yMLikJGhXkAoqa4aXlknVV4l+4qCaEU1UhlPBjGVJ1OOf8iUVcria84q5SqqZHk1Mo0tUq3twxpb3n3xkiRkkPPfkMY171atGVK75t2m3/rn+Ix8/JQ0Ng1t50s1tIyoqh1Wju8xlS3jydIK5fC0WBW+95S1hcjNwyNkldWy1bWKZ84PnzPXePvuvTMXLPzwwxglWS42Lj8iz93jFCHhZ87eJsSxqKjk2fNH8jLJL0qKhw7XGKmz41/DbHFia+Av50ZU7C9L/lv0r1f7r5f8T+j/oIm/nf5vOPPfQeK8+m9i1784qH+x2P8N/f+hD/8W/b3c+7vq+dvpbxzjX1FycsrAd/VNTOfW1NTPmuk37N1Ti74LSUnMjE+4zKusOXE8Rwyzc5RkbxvPWvT14t+Mv1625KeNy1esePhQCt+Xgi8/Qa+XVw0kU9MwpKHxXV7VgPuPSHLqgNCI0S6uZu7ua4JDHW9k3rx//wGvslHAF9wtfOyWkOsWczzCwy7Gx80nPSvjcklbm6D8ZW3R7WfpqWc93a337//G0vbL8KhBV3JIFW94XeN79Y3vVtUC/EtT+4Ae+K6VLikbEB9vd+XadU2jBebzf5v3/Q8fjo78/9q7DrAojv69X/TTfMYoTYotppgYazR2iSLS7w6QckfvqIi994IK9hILKBZEuAMpAopYQCxRioAIYm+xxRZBlHKV/7s7sLkc6Jf6fzTfvs88d7Ozs9Nn3t9vdmbWUKeQTrZegUHbwjkL0gQ8L4rKoKi0kosPKEo4a3b6owf3/v2Rsdbg6b+fsznDGc5whjOc+X83qakHtXVNzEc5XLt+zc09xM0tzMl5tcA2dJTFyps37h07UqhHn6ZSr2cb6F4cbuZo6xIgEPqDua0d/eyd/Dy9nNLSum2PHLhjx9i9MSsTkqMvFl+6d//+ixfV0lqyKKx+Dxj9SW3aSKW1NdXVVeUVFRuj0o7ekR+6Ijt4Q5peWnHv0bPqmppaaa1cLlMpZczOLXotOP4UCuXjJ+W3b/+Yn18ctSdi25YFK1by137fNSPzw7j9844dOznc2oHn5CcQ+dNG6NW5vZjlbP02FxYuTVQoZIUFuTOmbL//4B59aJpCcefHe63aDtX/7g/o2ZzhDGc4wxnO/L+blNS0dl2sv/3W/NXLSqVUoVLIVfQ6cBl9DKhMdu5c6a/eZ+sWDh7uDM7mC30t7USJKWl2TgE2jp6jhX4XLlxUKaUqhUzJfCiTXaTGLi+vqamZNWtuXMmL+OLqA5flyVcUiZdlaVeVB8vkKSXle7KuZlxRpJYpUi/LU8vkyWXyhOLqhOJX2XlljbZhI3CZgt4gTh9kGrEjdriF0EbozXcOAFsTeYIvdDHSSTfUI3PjBdr/Kdj4ferOnRkVFZVyRRXz+U761PGi4uIOn5h8aRPCcTZnOMMZznDmPTCHDqX3Hyj6qtuAFy/KX5S/LLt0J/N4WWTED9OnH5HE5F65cl239S/rxg31zvcd6GXv5m/t5HE8M3vC9Ln2rt7LVq8FhRuP4hcUFtHbo+W0Wk2bX0Bf//TTw6TDJ/edvpVWJk8tUcEcuKRIuayCSSx5uffU3ZQyVeolVdqlutRLdQcv1SVdUiaVVl6797S6+pWCOSmFDY2w+KvXr3fsjjaz9ajXrWnCpo1A5Gft5NVOK6thr1dBi3/lHzqUR1EbunRJfPrk5zoF+fC24uSZU599ZdPddjmz0i+JM5zhDGc4w5l32hw7dpRnP6XZf3pevnx1yJCgIcO2iFy2zVsYtWlT7LVr9yorXzSj6G9k1b/P1s3/stscO1cvaydvexePSTPnrd74/dhJsxYvXWUx2sNGGGhswks/eIiow2qMrTyQemRJ9NFdp2/FFz6JOnM/pVQFc+CS8kCZ8kCpMqn45d7Td3GZXAb3ugOldbibXFyx59T1NWml8eduSmUyBaO7K5g/hVx+oaR0hI0z3wUqtZ9AONbWxY8v8rV19uMJvW2EviP4/vptzjPnoJH92cfy8kvLSvPatNlIUd+3+Y8k5UAhQooRJw41dl0ZFhazb298vJgznOEMZzjDmXfZUGfPnl0eupX6V5+jxzPrmFPEVEqpUlFFv/GVyeSy2pbN02nOpr9umW+gU9ihXaxA5CpwGisQBprZu2zZGjl34WITgeO2qGgbR1+eMJAnGjN+3KQ7d+7QyjFD3GDHNavXeE1eGZl1fduxazE591LL5EklqqTSOpgDF+uSL5RHnr4LezJjkkpVaWXKiKxrkdm3Uq6WByyNkkrrORt8XV1T4xk009zei+jWPGc/W1c/a0dfgchruLXrrl2+o4Vj+vQNNdC6YKhTvz/7Ayr16dOfMo6kUNTu+PiThp0Wtf3oRPS+vDnzQngC/7lz50RHR4s5cODAgQOHdxtUYWHhvpgEqvk3u3bFvnz56qdHzysqKmtqauhVYAppnVL+WZcD9Ky4bg7Iz1AnX0/rlJmtI59eg+bHE/kHT5oqSUiydPAcLhAtWBpm6eRlI/S3cfLlCZwrKioaXkArbt26aWzmMG9bakzB430592LPP0u4pAJbw4C89xe/3HXqbnJJA2eDzi/VJBY+3pZ9IyT6+Mo9BxvCUb6sfLlhc4SZg7tA5FvP2TyTS/kjFoaM5buM7dGvV9GZb61cvD/tHAnxApxtRH/w+zxPICm6UNT9y/gWzRMpavuXXbd7+Ub+9KjczNp1zNjZixYt3Ldvn2bBcHi3EdcAiUSiee+dQXx8PFKo6frnsG7dOo0s41KjNCCDbtmyRd3PH0bjwBu7s3c1/OBSvQTYR95UZcT/m+6+HXg2PDxc01UNCJYk5o+Fz4HDOwLq2rVrCQmJ1H/6BwROPPPDOYr6nqI2UNROihK3/lC8e9c5P/89Om2Kyfkk4D8DrYt9vhnLFwYylOnLdwkwthSt3LAh9WDamEkTrRw8zOw8+aBzF18TS8fwiO0NbKvMycsZxnPZk/d499kH4cdvJF2sTQQ3l6gSSlTiwoqdJ+8kFtOXiSWKA6XKzUevbD569UBZ9fR14hqplFGxFadPpYvcPPub2EsiAixHe1sLfa2dAwaPtB856js7Fw+B0J8n9LIYHWgn8tTROkd/10s3nz67TSc/OSWzqKDkYvGVFy+eIBxmOkFaUVFOUZ/NmLUkLCwsJiZGs2A4vNvYuRNNlIqMjBw1atTMmTM1b/8JoDE4Ojoi8PHjxxMXjPJubm4+Pj7kcvny5a1aterUqVPnzp1NTU1/eVINeKR79+7gziFDhvy1JIGEgXvUXSBxwhEkvWbNmpCQELhMnDhx0qRJ6n7+DIKDgyEoREVFTZkypX///qxYQCJ1cnLy9PQMCgpCMrp168aKv3D8/vvvUZhjxoxZsGCBmCnYgICA0NDQJrvbxo0bt23btnnz5qFDh2re+w3Yv3//woULNV0bMHbsWNQm4kUUurq6mrc5cHh/QD18+DAj4whF9ezy+eCXlRVyebVMVrN398lPDPc6Oe6+ef3h0WNn/9PymIFuDrNv6ryBbmF7nf0CV29bskhb5M8X+Qwzt1n3fURcYvLm8IjUtDQTnohfP3Htu2DB4vLyF4S2o6L2Tl8bH1f8IjLrdviJu+JiZdxFpaRYGVtYvuPk7bhipaREGX9RuS/nye7T91Ku1k7dcvjug8dkp1hi6pFPu32bsE309RD75XODv7N2yt7ZTeTjDXW/XuEWwuJn6xxg5uhpoHXBSIfeVt5Bp0C7VeGFC2U869W1NdVKmVwppxeg4feHs7kU1WXhwsUbNmyIjY3VLBgO7zagMIEzYFmyZIm9vT3rDkbZu3cvKpRlSljAN+raHhQyuMAOb42nWMBG8IPxHeGzgcybN8/X15fYET5xBxs1fpyA8KgGuaq/gmHTyV6SeNnLHTt2wEU9fDju3r27cbBw13CEEDN58mT2LptgFupxIUziou5BHcuWLdu1axexb926lZUGwJEQZVCwXbt2RTr37Nkzbtw4cktLSwvditjFDVGImYSxQakDiUGCV6xYAYt6maCa1FPO1hq5XL9+/erVq4kdnL1o0SLUmkZOAaRk8eLF7CUJRNxQMqw75D9xQ8kgL+p1gTwi2axLLAPimbggXvWgOHD4+0C9ePEiNzdXV98UtH3wYMaZU8WDB0f37x9z+nQpvZ9KrqiurhppEm2kXUJ/Jov+HGehnm6ulb1z/VJt5heKtZWDd05enrmtcPuePcZWjoSzaSoV+Y60sYNkoFTKZDLpADO7mRHpO07eCc+4whC2AiamsDzi5B0xY4+7JN+aeXPz4Sshktyl4an0a2yVkmfjdGj7IM8x/ibGg4KmTbV197G3GmXpNGbOBCeeM6g6wNxWlJ7m7uk72d7N7YsvNxjp0W/f29OcXURRaTsi933Y7IBW27iUlJLq6oqg8XsOHSoaHzyznYHxwoULIiIiNEuFwzsPwtnDhw8HYasPryYmJrgFjbNPnz5iZnZ66dKlxDPUPrisXLnS3NwcAzdcMNRaWVk1KbHNmDEDD7KXc+fOZTmbAE+9hefEDbRNFHEkzNvbG4w1ePBgMj8MnRWOhHJgQZLgaGxsTFRSUCOIEMmDFkukDcgHmzZtIhlpkrPBWAMGDCBFwXI2EgkLntLX14eKibvTpk0DB4NgWrRoQTzjWQgxEBHUw1SHOmcjU6NHjyZ2BNuzZ08khs/ngxcDAwNZOkSYoD1iV8ebOJvA398fD0III5fz589HFB9//DF5ZOfOnaQwbWxsSJlAeggJCSECATgbmjSSh3IjdwmQRxS1ugDBuiM6FCnr0rx5c0SB9rB8+XKkQSQSEXc7OztUNLKG2CUMevTosX37dkgYHh4eYqYcAgICxExjY0PjwOFvAvXq1avS0tLRjsFUi8ELFi23E0zq1ye6vLxcoahVyGpUCnob9MZNhz76MNeIfj2cB9NOt7jfYH87Nx+B0M9WFGDr4s938bUVBlrZusZI4heErBK4+Fs5els5kGVi9Gtvb5+g+/fvq5Ty5cuWC4OXxpe82JZ+ZX+pnObpi4qYgvKIEzfFxcxl3qstGVdjC54EhUZfvH4fGvapMzkjeQ69vh48f8ywRaErKl9VPXr8yNnTN2qu0e6lBtbOgbaiwD4DR+Qd1nb19bFwdDfQOmXErHJvr5uvp13o6Zlgb7t5uEVKt8+CoZgdz0yjqP3h20+0/HjAl914GJfRUTVLhcM7D8Je4CT8siMyuIdilG+AcBLG1oSEBFxieJ06dSosGKYxHONWly5d8Ovq6tokZ4MPCKURNObs4OBgdQ9Ngkwgk4EeFjAlYTVYIDqw3pAXEB4sq1atIowIna9v3754ClRNGAhURESEN3E2HNk5Z5az0bZBLbD4+PjMmTMHPiE0QCCAxczMjHgmxdgQWBNQ52wkLCwsjL2FYpk9ezaK1MHBQSAQsO7q1CtmUkgsb+FskgbwJbhTzFTTunXrYOHxeCQvKDTCmigiUibTp09X17Oh9+Oujo6OOmcDSDDiZdPAWhAj+1ZFwrQHFKCbmxuihgRjYWFBbqEKyFt2eBAzldWvXz+0K8iFnp6exA/yS4RFcsmBw98HCsovlOBt23ZR1MBPPxuqkNGHoqgUipqq1xER54yN97uL9r98WdFOb08HEDZ9sth5+nCVNpnmPKHAxbthSzRtRtm627oEgqEtBM6ZJ7KPHD1uautOaBtqt6mNU3JyalVVlaeX/xJJXsTJnyLPPt6R/Sg8++GenKfbT9/befrp9lOPdv7wcFvW/Y3pZWnZeUqVYu2mcDNbkT1vaG60RcQSc4y/KlUdlO+t4VE7w+xWhPjwhH60EflZOI8RuHh26rDbSPsi/SabNucp6sj5ouIjGcdu3LijkEojt2/9T/MEjOq1tVUU9aWP/9T169ezygGH9wiJiYksUX3xxRcY0OOY5UXDhg2TMBPLrA7UqVMnNJvOnTuTeebNmzeDs/Fgx44d8QvO1ggZtNS7d28obbjFEoyfnx8hDHK5ceNGVlCAI3gFLuSSANIDOAzhExkCfiAEgGPAcBJmrhXu0BFB/OQuLsE6eITM0CLePn36wBshDLiMGzcOWjiZsddYbEViUZ+bBRWRkEFLQ4YMQcigGUKK4D/EAhfCQGKGbwjZIBleXl6hoaFsOMQR+u7ixYtRhkg/VHn1uwgTbA0/33zzjbqmjnRCs4cGjIgg65DJA6QzKCgIGURQ0HHVV8mRikOdQpRBGkjIEFPweJs2bUixQ2Rp164dHtfT0yP1MmvWLMgi4E7Yk5KSEAt8amlp4Sk2ZAIEDjKGOzwgEDHTMEaMGLFo0SIEFcu8SUF7gDu8IWGgZFamQRWQ12dkgh0Pmpubo0zQPFDvYkZcQNbYuuPA4W8FpaS/p/ny8OEjvfsJqWYDHjx4lHPuIkVBP4gdabYzMfEcfaiZQnnyVIG+drERvXuKXoltoFfU0SBS4OQhEAbQ0+PCgKEWTvkFRSMs7XmiwMSU5LmLw2LiEsztnG2cvfhOY/jMMm+z0V7ncnOePnvSw9TZXBgcOGPGshVrFi0JNR5uxhvtPHXW/KAJU4cYW3brbzHcabJcoTyaedLaMYAv9DO38x5m42Pp5tFzoLW1nafQa6q1veswvkf3HsMFjMTAF/nZOvlbC0UGWiX0USo0YecZ6hSvWZMmkZzYG11YUfFSBXFELjtx8mi8JDs7+4y+kfGiRYvROZtcEcPhHQcZx1kSJZoQsRPyVveprgBJGKhfsnYNvOWWhkYFOmk8W6MRr/jXCSN31aNoUktrnJEmvYkb+dSIiL2lcZd1IRYwU+PV18S/xiMaaPIuiVr9FhtUk/4be24y5eqOGkXKujcJjdIjdo2n2OSx7uBsQvbq3ki8rKNGyjlw+PtA1dXVVVdX//DDD6Erv6daDE5NS98bLRHY7k5KOSuXSeugccvlSvqI8Jp/U0cN6a1TtP4KXjRsU9JnkB9ZQG4x2it8xy5LJzeB0MsjIGjIKP6U2YusHYXncnNjExLN7DwIswpEvsNtRl++fOVsTu7LykryxWsozTIatYgFiamprr5182pmVvad+/dH8Jz5QuZEUlEgX+gbsaPT4YxPIyL779jdLSNT38E1gO/qx5x8TpvR7j5f9VyChBnpMYKFToFO6/zS0usB/rMgf3QwSCwtuYccqRCLqm64maOVteecOXOIlK1ZKhw4/Gag/bAztO871q5dq+n0Pw92qoMDh3cBNGeDLG/evJmamtbxU7N+/Uc9//lnFf0FjRpxXE7nDlC4Yyhq36lTN5ctj9duebG9Th59xAo4W+e8QesCG6E7dFwbR29zgds3xhaXL5ccPHRwhI3QysE7Ne2gvdDd2tGH1oPpRd1kzVrACCu7V5WVcrncxsZq6tQppqNGGn83bOWqVT6+PqtWhyUnJzMigtSELyTr0tm59xGmPU7/oHc4o/2RDMNDGR0tRgfyGxaNC0R+3XvNN9IuMtIuNKJnAgoNdIpseHsUilrk5eLF8x+22KDbbhNFJRUWXCkuvkhRBvPmL8ZQ+/ZlRBw4cPhfBgSyadOmLV68mFOjObwjoDkbKC8vLygoWLduK/Xht6FhG8HY+ecvfNQ8aW/06Qf3b3h4TIKqWlX1WuSyl+x7Jnu1ocvq60bxnNz4Ii9o0oGTp1k5CF19x8XtT8g4mmXK8wRhWzh4OHkGxCeleARMYLZj0RRrZSf66fFj4++MQ8NWeHh7fv311wdSU7du2xYVu2/Tpo0VFS8nz1xAVp6DtomBfaS9q4vbpydPGmYd0x87wZ7Z5UX0bF9zWzcjrVIj+rA2iBSQJ4p79hQ/fPRYIa9RyhWJCfEQOxbMT6CovVVV1T16mbT6eOiCBfO5FeMc/mH4S6jlLwmEw58EVwscmkQ9Z8tksgcPHhw7dpyihlDNetbUVK9du2NMQKZMWnvixEVLc3Ce5MCB3NevK5tR6e3JcSU0Z+e31ynU00od7UKvIReIfECuvQaOzM4+3X84L0YcJxB5z14Usi9GvCcqeri1g1vARJ6zr0AYwHPxtbZxkMqk0Oera2uqq6qgW9+7f7+mpub27dsz5odYO/nQOjQdJs3WxPCFgdZCn0GDBgmE9CGp9F2hv62b+zDTce3anmuvm8tsRaPn7b/4QpKTe8HSIuLwoZLaGmlNbZUkNnZs4K6881dClq6hqN7z5y/bsGHDu7+lcseOHVOnTnVzc/Pz8/v7+nBISIiHh4e7uzviUi+TJne7NkbLli0b76X5LdizZ4+2trbGu4klS5Z4e3sHBwcHBga+ZQMSAbt+6rcDOZoxYwaKNCAggCxf+sMIDw8fO3ashuPatWu9vLymT5+u4f7XAlUzf/58W1vbCRMmsLuqEGnnzp3VvS1YsGDu3LnqLizUF66LmTZAFlFDp+zatav6rd+I3bt3+zJAwU6ePHn79u3EHQUeGRn5WxoSiz+2mOv777/38fHx9/d/06b5Pwk01CYXvSO68ePHo9JdXV3ZxTGN1ze8BSh89D60JdQgqU206q+++kqj0EiYEmbFIileCbPcUt3P2wEt5XdVRJNAftkN9xLmzICtW7eyd6Ojozdv3sxeIiOol23btrEuHP4k6jmbrES7cOGCh+dE6sPBeXkFR48f+rRT8qrVYPHob/vFxMaeUspkSpl08dJEnZZ5hszx44xGm2+oV9yrX7C9q5/Amf4OprmtyNbJLXjqzJS0g2s3bLF08hN5+Dh5BM5bGrovLsHc3oPv7McX+luNdr189Sr9FTB6O9kvSM84aspz54u8+UJfCwdfvgs9tU5mv/GgpUvgMFNLnijQiiZsX/gxFXjpaZ+uP/WMHHymXRojznry5Cc395lI/Bj/jMpXr1QqRCSrU6m0dPoYdDSbNWvmu7/6DMmztraWMEA3+POd7U2Ij4+3sLBA11q2bBlZPUswe/bs3zL8IZHsAP27IGG2WmnkiwxJ5A2ieudvEp988knjRcL/FYgCgzui+Prrr9WHm9+L1atXk/1jLBAyShLj1LBhw/7WdRLdu3fHOIiINm3aRJamE2hwNqqvydPB8KCZmZm6fMb6BC1169btF6+/B1FRUWgJhEiaNWtGGg/Z8NYk2zXZpEkD+AMvrSTMuneyte/vAKrbyspKwxFyW4cOHSQNK+PIGQDgXUrtQJ7/CjRFExMT/IJT2Y0GGpytHubQoUMJVaPxq9f+2xHXcAzRnwQKmR0W+Hx+jx49ID6SS7QoHo83a9asoKAg1gMc7e3tf69szeFNqOdsQC6XP378OCExuXtPm949jO/9eKdD++k2NpIf7/6kkNJsLWe+GgLNe/Wa9HY6Fwx1CshENL2MXOdiO/3tjm4+9BJxob+lo5urf/Aoe08boa9A5Gvj7LM9cvfGLdsGmtkeTD88b+lyWod29rOxdXzw4L5SQb6zSX+uq7q62tTWhQ9FXBTgYd/7wY0hJgKo1GPmzB/v4OFnKnBbvWHA4cOfHD7aPmytha2LrznP26BtEb3ujF4cd85Iu0CvdQmPt5f+0Ka8FiR99uwZgd0kikqYO/cYYsg+kU1R/efMWRAaGvqOK9mkgzXZ0Ddu3Aj9iRU4MHaDOUC3EuZcJ/QfDL6rVq1iOzw0qkWLFhH7unXrli9fzl4SwKeNjQ3CCQsLGzhwIOsOPiMJwAC6jAEZeeEfBUiOyRS/gbMxeLFsgeEGSvOKFSvIjlsCjIDz5s0zNzdvPLR99NFHGL/UNRVEzW7JwyiAPJLq+/zzz0GNKA2WIGFBvKzysZSBhpiPTIlEImSqT58+rJKKYQgqPkkMHoeuH8ZsRIYLHscttsCRbBI7QtAgZsI37OtP/AYHByMcshgbIgjCQcYlDKDls0WEJKE8yYgPODk5TZs2rcljScRMebKjpJgpHLKZColhORvhIy4ktUnOhjSGJEFNZ12QFxIIqhijMFqI+pEySBi5K2aUQtQ+qgMNqXH22ZJHgHZ2dqRNIjpSYngK4ZB8bdiw4bPPPiPqPlzgB+VGCpk9ag2PIxnsVm/Ei8ffMqkDLV9DhkO1onzY9omqnDNnDnoQ+14M5cPqr4gLnpEvMdMGUERLGBCfCARsROwsUN2NVWpkFrEQu6WlJWoBaUb4CBme0TfXr1+v7h+3UBdk8bm2tjZpHhDL0FTYVYEIk50ygURIyhnlxkqNJCOoOLZxIjuIiG0qKNspU6aQHg3lGJ2R7UdipvGgeFkpGXfJkEIuWfj5+aGm2FpG/1UfakDnSACi6N27t4SRYyAawoJKIcfOcPjz+IWzAalUWlxcvCMyivpwmI21i4zeHCUHT6sUCqipKpCrAmxYo5DWuHnG6rXON9AtpHd/Mdqtkd55Ha14c3vX0a60TqzxKtrS0XOUrTA9I+NYVqb72Mmj+CKekw9P6OvpHVhdXaVS0QeKQ2jYumMX821NMHrggFHmglFWfGHwgBH8EzFt/MYgWC8TvsdwS7eRtr5WQp+vuq/S12qYpdfNN6BfsRfPnhddU01/lExFH1AKI1MqpEePHwwNjb18+Ypeu29mzJyLTog297eqQX8eZNNt4z7DDjdt2rQhNIaeiXGB+ES+jI2N0VUg2LLHfkHmHTNmDBkNHRwc0FE1gpUwnI1RRktLS71YMNCQERARYezr2bMneRDdD8nT0dEh3hpzNplFRPcmlxggevXqhWebN29OWJ9MSiOdo0ePbpzH1q1bY2xF5ye3JkyYAJ/kbBAAGWSn5sDZZGjw8PCQMNN00E5Ak0TyiGOO1VTfBkZA/CNrSDlKRsxwEgas9u3bEwWCUAsZ3TBMo9Dc3d0J+bm4uGxnoB6gOuKYM8769+9PLlEI7E4hhAkmJnZEPXbsWCSV5AV1PXHixBEjRpC7AoGA5e/GgG6NcZO9BLXMmDFDwpz6STgbdmLBwN0kZ/fr1w/RIVJWElLnbOjZEmZCm0gt8IOR3dXVlRTIli1bMFKjoBqnUKLG2WhvaFQS5sscrO6IkkT4JFK4IyISJspz0KBBxC5h5B5icXR0xC+r1eHZaLVTVxujMWcbGRkhp0gwHkSrIxNXRBpGcUEygyOYhsSCLKPiyMw8PIDwJMw5poTFUc5k0786qKZOfENxffLJJ8SO5sq+GkCJwU726Kv7lzCcjXHJx8eHsCZcPv30UxSRvr4+CR9hsgIZy9nklALiCEtCQgJKslOnTmIm/ZCZEAKy6ezszFYEmcFCMpAdCXOQPkkM6mL8+PHfffcdyoGo73vVztYlgAyBxGBsYU8jQGjgbMRIgjU1NSVMTxRrOJIODvuoUaPUg+Lwh/ErzgZx3r9/Pysry6jTcKp5n2fPfianczNsXW8YIpTev//QxESsp0UvQ2OWkdPHrRjqFRm2TRlm6mjr4sN8+Ite8l1/JrnQ32K057hJU8ZPmm7j5HPkaKZ/0DSBKGCkpTAr66RSKaPfZ9+7z3fwIEvPrOm16EFCVz9bkRdP6D3KBsq3F1luJhD52Ln4fms8zkCr0JBW9On94u11CjroXqCo1MrKCjowJs1K+gw3+mhxBYxC5uc3jqJ6ocO8F2+y0dChBbJ9W9JwDjPST2gP/ZZYMLBCLSPe0JOHDx8Oz+ilpF+B8NQ7HkZekBN7SSBp0LMxuoGTWHcMH+wIiNGEVbxQeuAedrBozNli5rUo+z0JjAIgCVg6duyIFMIRygGhUkSnMX6JGT2bDN8EyCZGE5azkXFWswFnE0Yk4WBMxCgvZnIkZoatr7/+unH4cMdgLWFOC/nyyy+Jf7SKDz74gOVs6EbEHTTAnjAqZqgIGdfQk1jgcbIIoGXLlqTY8TibFxQgy7UY01kqEjNiinqW+Xw+Oyw2Tj/oh8zAk0sMmsQzy9ksTTbJ2bgL7Q23IIiQbIp/zdkoNOKNKHZIAOQnSGwkRmQQ+rG6dsVCosbZqCOiocYxM0bEM/myC6GlOOaVLfGMp8AW9aEw9EM8qHcBMfM423Mbxy7+NWfvYc4M5/F4cQ2bp+ECCldXWGEHWeIp4gHy0/Tp04kd4ZCTTfE4KSV0kMacjfajPmtFJGMEiyIiLiy/ipmgkB72hDUWiJHMSbCZkjTMjaOFE6muyTDV58Yp5lgeNF09PT0SAgaBOAZkNkuds/E4Ef3JmYBi5q0KmwD8ortpsCyy5s+gb9++kNrVXyySqGEhB/TGMafwShiqRvmQqDXeInH4w/gVZwM1NTV37tyJ2L5bS3+Y6Uje06fPlDIFrWer0TajwsqhH2/ceLCdVoEB/TWOPHr9l26BoU6RgU7J511nW9oznwmh58b92M1aPFHAhGkzN20Jj43fbyJw8p8wi+8UYD9aCGpVKZUTps21pg8PpwneXuQ/pP/nt3K0R/J9BMIA2ojot+D2bt5mPBcDrSxD7WJmZp752iZ0fe2Llja7njx5Qp/jpiZkENpWyZS5+ecpqs/ESTMxWjWWi99NoK0PGTIEnSQkJAQCLBkxMbZidEOPAr8SP6BhohjhErqygYEBOnnv3r3B1mKmp0Fghx/CEBgEhUKhxov80NBQaNhwFzd8DAPaOQgAPZNMXRLVatKkSYS9IFYjcHRUQhWgHxIXCyQS8jv6PJkhJARPXsiR2UUMQFCFoeP26NFDfcJczEwMUMwZYeRSwmhF0EcxthLJAPSMAY5UIm6R02cxjpAxGncxVBHmRiwkXrXg6QCRKh0dHai5gwcPJmGGhYV16NABRUfWlBEhg5QwRjd4xtAGP3gW7lBqWarTAAoW6UTtsKdaQu2Aqk2mc5E2kDGpKWQQwaJeyIiMMkeVEbUSl0FBQZaWlkQ0AVmy8goLsA5SgozgQfb7YwiTHcGRWlQBxlBIY788xqh6AwYMQFWifsnny9j5GNIAoIHBEcmG9knaCZKBWCALssMuSBeBq4VKA+WMtjp06FCM2sgp+0YTjQQBot+hAaNwkCTSigiXkzAhPKE0SN73Mee0kxJDMlAO5Kg1McOpqHry6gG1g3bbEHl9RKhENBXkDu2csDsqDho8uBZ5QU7RU1B3RJOOZQ6+RUYgXEII2818fwVtlYhxhA6hYbNVhqSyJ7qzQLCoX9wiJ7gRMRpNmmoQU9AaoWuy7Vl9vQgLVFarVq2QWdaFdJZoZikAkTBImGKmAX/88cdEUCCdhUQECyoUchgRKOGICkV20KTJxAbcqQZxE+7oiSiHb775hrRAdEa0QOjHMczXz1CVaHiNJyNRLxDp2NpHKaFxsnIhEow+hQSzLigTRIQ0aJQbhz8MTc5WqVTV1dUFBQUREbupVkP79htJrxGrn2dm9WzGyOjfyJ1HmlGpBvT0eJ6hLn2YCXTujmBu7Uvdu0+3sHe2cw0kOnfD2m9/ntBd4OQzaBjvyPGM9du2m/KE167dePr06ShbT0LwtvSK8UArRw9zB1C+N7MJ28fe3af/4CAjrXRDLfqDXfXnutAT48Va/85x9YhWyqS/pI2mbdooaQVbfvZs7gctuk2btgAtadf7doiKpAHqLmr36z2oX2o4vsmujib9qPts7KGxf3U0+Wxjx8YPklsalxo+WXtjy1vs6tAIkLiwvxoeNDy/KUyCN4Xc+FbjS9aufonBtEkps3FExFHd/iY/xFHjbmOfLDS8TZ48WX2SQP2WRpisu4YLwZti17A3voVfMFx0o3VqDfE38YiYeSNDhEtIXYRE2dBYn+yzYCNwvEY46pfqUH+QdWnS3viNOEHjkIlLk+E06Ugxyq66H6JnN+m5seUtdg1IGGi6vhW/1z+Ht0CTswltP3/+HLTt5hFMtTJevXo9aE/RwIVSqezqjVtlV65ehrl89dqNW6WXLjWjIvW1So10c+sVX/KCWbegnXZJJ8P1/YY6OXp42bvQ5E3425zvEh65y1TgZuPoI3AOWLtxfdQ+CXuiGVkljku+81hHj7E2LtaffzZHr+05Eiz720E3p732pVYfrT15Ou9SGZ0YYsouX6mqqlLJGQqXyStfvqSoHmbmrpBMt27d+n4RNgcO7xrADW+aZvj/xB+gAYjshoaGGAeCgoL+6+M7d+5svJHvzyA+Pr59+/aarn8dUC8aB05A5W0s1nB439EEZwO1tbUPHz5MSjowaIg9RXVL2J9CnzrOcPaB5NT9ialHj2cfg8nMPpF9KvvEmePZWaajdhtql7IryWk9mF6edtZIu8SgTYGR0ZZ+/d3MBPajPX1t6QNHx1rYuzHbr+n5cxfPQLex02ydfRlGp5et2bnSG69NeQ6ffz5Pt/UJQ91iI90c5sNi9QIBjF6bYu22e06fPX0i+8zx4yfo9DDmeFZ2VLSYCBkyqWzWrPn6RsNmzqQXi3KfA+HA4U+iSQ37fUFMTMxvpDFk8zf6/O34W4tuHwP2Mpb5NrzGWzAO/wA0zdl1zCkr169fP5xxpEXrAdR/+k2ZOktJa67S5AMpD+4/IB8OUZsnlykUsvQjZylqq1brW+QLYPUbpskMtk5+e91CfZ1i/bb5Wq0PGHWc2bWH50Bj26GmZsbmJsYWI4zNvxtoavH1t9ZdPh9r0HaD7odZOloX2muXMc/WK9bMlz9oi572RYpKzc0rUUrpt9f1BulhjEqpjEs8oKBXjMsGDRlJUd/OmjU7LCxsz549MRw4cODAgcN7izdydh3z7ZC7d+8mJx/o0cuKamO8eu06lVyVmALOvq+Sy1VqS72g1IKzlTJ6KdmDhw8M9CObN8/tqHuhPX1QWj3RMqSbw3BwIcPoRUa09nzBQLfYkDYXYae9aeNWLvOiOo9MtjPntxQwn8TOb/tRwQfN4rNPFcrptWZS+vsljPTwqyVyCmXc/oTXr1/zBI6dPjGJioq5du3aq1evNLPHgQMHDhw4vFd4G2crlUowX0FBQVJSSudPTCjq8y3bdiSlpNJ6tvzXy7NlcqWUvPOGvbqm5tXefQdb/vugTsui9roFzI6shjXev0xu01u6f+1IeJ21k0cYytcp0m9zqV271NnzY3568kTF7EBj1etf2Lp+9ZkyVpLg7upDfdA3MnLfuXPnKioqIFNoZo8DBw4cOHB4r/A2ziaorKy8fv360aPHunYzoVoPdnMNePb0KbsHuoEp5ffu3plNUSmrVtZUVSll9I5oOD569GjipNguXfa2oPL025Qa6RYa0uo1mehuIGnm05nE1LO1Tn4H7aIOunm6Ohcp6lyL5vFzF0aXXLpOCxEMKyto7VpalPPDtaIi4sKkhFC4vLy8nKJ6GHQYsTV8d3Fx8c8//6xkvvLJgQMHDhw4vNf475xdxyxJe/z4cWbm8fnzw6jWQ9rq93r+/GeaORv03SePH8+0sDy8fuNkB7v5FLVq4rTY+fOltTVyqUwuq4bPV6/L886XbdqazLOVdP0ymqJONKPOftwiv/wEcFsAAAWVSURBVG2r3Dat8tq0ytdqlf9R8/MtqByKOtKhQ/xwk/2LQ+KOZ56XySvrQMcISCGTy+XVr15VvqxYY2d3PuNIMEXFzZpOU7iMTgat5SvkoaFrKKrbhInz0tPTS0tLq5ivj2jmhwMHDhw4cHgP8Zs4u445a+XmzZvHjx93d59AtRhsY2138+YtMkMOk5yUHEA1O5WUNImi5vfuPqazwQwjg/Bli7b4+csV8prqaplKAdKFKiyVvn7y9FnRhaupB0+Ehx9euzZp9cpDq1emr16dvCPy4P6ErEtlNx8+fFZVValitGkls7ZMJpP/dPfO9ZJLwYY6x6Kigj74YC5FTW3z0UyKqqgop1fAycDZ8uNZp0DYw02cMjIyysrKXrx4oVKpNHPCgQMHDhw4vJ/4rZxdx6wkf/bs2blz52Ji49q0G04168PnC19WVDKHqyiVKlV+bu75nHNyucKPok5vDw8a1Pd8UlIARS3gWc7v3evxnVsKuaysoKAk54dXUJdfPMeD0ppaqMnMi3AaiEIulVe9ev3w5vXKyld3r1zZOmHCzHZ6+UfTnSnq6ulT0eHbIydNCg8LXWxhtXn2jF1Ll1RVVkC9vvfj/Q8/7E5R/Xfs2JOVlfX48ePa2lqOsDlw4MCBwz8Jv4Oz6xo+2Xn79u3DhzOWLd/Q5YuRFPXZ9FkLq16/rp+dpieopZcvFq+bNePg7t1Pn/w0kaLOxe47nXYQTKySyzdOmw7lOD42JpCiEiO3Cykq50CqUkq/qF45ecocQwO5VHoyKwtM//TBvWPpqWPMzVfpG8ExfOWqZT16zLWy3Lto0e3rN25fu6Kkp+YVP5zLHWXuSFG9Z80OSUlJvXbtGtRrbj6cAwcOHDj88/D7OJsA2jAU2ZKSkiNHjgZPWgTtlqK+mjJl7uvXr+g15PQ3teT0nDY4vLb29KnTm2fOLMnLkdPqtHzKsCFrvv4iXRKztG+fKRS1zMgIKreC0bCDdbXGdWqXvnlzRUXFRONhp6L3+vXuMXnEd+MpqvzJU6lC8fD+vWpGOKC3mSkVmSdO2dq6UNQ3nj7To/dJCgsLHzx4IJVKNZPLgQMHDhw4/CPwRzi7jqFtKNx3797NzMzcGy3u0tWGat6v77cjxZLkZ8+fq2T1p5HTe8DkShUUdGalmEwmXzt5Soi3zzwfn5nt2m8KWRrc5dOammoQ/KnM44ttrFYETxxHUVkJsVMF/PXjxx7es+v6tesPfrynUNBB0ZIAs7nrxo1bq9dspajPP25nunXrzoyMjKKiIqjXtbW1mgnlwIEDBw4c/in4g5xdxxxLDiotLy+/c+fOiRMnYmPjBg93o6g+MI4uvpK4AzU1NSqliixSYwyzyJzekaUin+UGi0tlMiWzfEwqldXW1NLz6/S6NvZ0s/p16Yxirbp9++7a9du+G8GDbt2zz+ioqJgjR45cu3bt2bNniEszfRw4cODAgcM/C3+cs1mAuSsrKx8+fJibm5uenr5zV/SAIa7Uv4aCWbt3H7F8xZozZ/JeV1UpaN4lijLL4m8w9HJxqZLZ5X3vx/sHDx6zH+2t064fAuz7rdOCRavT0g6eOXPmxx9/hMQA7VszQRw4cODAgcM/EX8BZ9cxa9NkMtnPP/8MnbuoqOjQoUOxkv3WguAWH4+gqAEU1eObATa+fpO2bI7IO18IGq5ltm7T+6rJbi65kn77DRVbikBe3Lp5+/TpnEULl9s5+RkYfkNRvSlqmLmVf3RM3IGU1Ozs7Bs36G931tbWcmvNOHDgwIHD/w7+Gs5mARKVSqUg7wcPHoC8wa9g2b3RkgmTl31n6vOhjhlFDWQ4uAdFfUmbf3WlqG4NBvYvKKoX42HIgCHu/kFLd+6OTUo6kJmZWVBQAMX6+fPnVVDZuYNIOXDgwIHD/x7+D4eA6Kz7ehZ9AAAAAElFTkSuQmCC>

[image2]: <data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEEAAABBCAYAAACO98lFAAACvUlEQVR4Xu2QwY1UQQxENxVCQGRA8hzIAYkogAuGP1JL3qcqt/uzc2H9JGu6y2X/nnqJIV4ovEcmhJgQHkwIMSE8sCF8+/ihXZzhmVCvvJnqm51yTAjRCGGHelA+u37WeK809ulVcIZMCHEQwrornZ6Mm3E6obeaqTxq9+JNQ3BaZ+aCnqo6M9QdE0I8MQTnZWVdQS+p9lN3tENwuI/xQdUu+pxX9Z03wxkyIUQjhE5xpjqve+es5tWubjlsCHdQH+RZPSbr9LjzWzIhxEEI+Q+6h1V/JsNdaq9CfcvNssd+ZkKIIgQu4BKlKbiDc9ToY7k5oryOoxBcKXKPfs7y7rQM9yif08mEEIch3GE31+lXb6CmvLyToxB2pWbzXcEdqiqvo+qRCSGKEEi1VD2MGueVlvXuLqUtPZ/Zz0wIcRDCBR+yW36h+kq7cDuVtnD6RTWXuRVCdV5U/XVn33mcl1qGPvYzE0I0QuCifym1M98zTsvnXT+f6c0chaD0rqYepbz5TI/SKrK/mpkQohHCgkv4AfdYzi3oWT6lKXaeXT9jQ1CP4b3y7vq8L41wVs24vfQ6JoQ4CIHLlM57pSst67mvvPSxTpgQ4jCEk4/Qz3LsfEpXWtZdf7ENoatlnR9nEadfVHOL3Oe3qrnFhBAHIXCpOtNDqt6Ce7hzt4MzlXfRDiGTdfWx6qx28tH0ZI0+V25eMSFEEcId1GMVd3SWotJd72JCiCIEfrQqwj59PCtPhh7Oq/O6U1NsQ9jhPLt513d/ln0FZ1mOCSEOQnALeebHTvv5zHI6PW6H42kh0JdxekbN8w1VP993TAjxxBCoqdnV551e3p12l3YIjo5HwT/brWr+LhNCNELoFKFGXzWvetQ4k/nx9cvj9/evn6/0758/vbpn/rsQFDu/DeE9MSHEhPBgQogJ4cGE8Jc/DiUDOjBdKZIAAAAASUVORK5CYII=>