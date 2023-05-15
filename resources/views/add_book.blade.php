<html>

<body>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <form action="/submit_book" method="POST">
        @csrf
        @if ($book)
            <input type="hidden" name="id" value="{{ $book->id }}">
        @endif
        <div>
            <label>Author Name</label>
            <input type="text" id="author_name" name="author_name" value="{{ $book ? $book->author_name : '' }}">
        </div>
        <div>
            <label>Title</label>
            <input type="text" id="title" name="title" value="{{ $book ? $book->title : '' }}">
        </div>
        <div>
            <label>ISBN</label>
            <input type="text" id="ISBN" name="ISBN" value="{{ $book ? $book->ISBN : '' }}">
        </div>
        <input type="submit" value="Submit">
    </form>
</body>
<style>
    form div {
        padding: 10px;
    }

    form label {
        display: inline-block;
        width: 100px;
        /* adjust as needed */
    }

    form input[type="text"] {
        display: inline-block;
        width: 200px;
        /* adjust as needed */
    }
</style>

</html>
