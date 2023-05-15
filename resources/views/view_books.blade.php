<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <form method="GET" action="/">
            @csrf
            <label for="title">Title</label>
            <input type="text" id="title" name="title">
            <button type="submit">Search</button>
            @if($user_type==='staff')
            <button type="button" onclick="addBook()">Add Book</button>
            @endif
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
        <table>
            <thead>
                <th>Title</th>
                <th>Author Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>ISBN</th>
                <th colspan="2">Actions</th>
            </thead>
            <tbody id="books-table-body">
                @foreach ($books as $book)
                <tr>
                <td><?php echo $book->title; ?></td>
                <td><?php echo $book->author_name; ?></td>
                <td><?php echo $book->quantity; ?></td>
                <td><?php echo $book->price; ?></td>
                <td><?php echo $book->ISBN; ?></td>

                @if($user_type==='staff')
                <td>
                    <a  href="{{ route('add_book', ['id' => $book->id, 'create'=>false]) }}">
                        <button>Edit</button>
                    </a>
                </td>
                <td>
                    <a  href="{{ route('index', ['id' => $book->id, 'method'=>'delete']) }}">
                        <button>Delete</button>
                    </a>
                </td>
                @endif
                @if($user_type==='customer')
                <td>
                    <a id="buyButton{{ $book->id }}" href="#" class="btn btn-primary">Buy</a>

                    <script>
                        $(document).ready(function() {
                            var bookId = "{{ $book->id }}";
                            var quantity = $('#buyQuantity').val();
                            $('#buyQuantity').change(function() {
                                quantity = $(this).val();
                                console.log("quantity: " + quantity);
                                updateBuyButtonUrl();
                            });
                            updateBuyButtonUrl();

                            function updateBuyButtonUrl() {
                                var url = "{{ route('payment', ['id' => ':id', 'quantity' => ':quantity']) }}";
                                url = decodeURIComponent(url.replace('&amp;', '&'));
                                url = url.replace(':id', bookId);
                                 url = url.replace(':quantity', quantity);
                                $('#buyButton'+ bookId).attr('href', url);
                            }
                        });
                    </script>
                </td>
                <td>
                    <select id="buyQuantity" class="quantity">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </td>
                @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
    <script>

        function addBook() {
            var url = "{{ route('add_book', ['create'=>true]) }}";
            location.href = url;
        };
    </script>
    <style>
        table, th, td {
            border: 1px solid;
        }
    </style>
</html>
