<?php

use App\Models\Book;
use App\Models\User;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    $user_type = "";
    if (Auth::check()) {
        $user = Auth::user();
        $user_type = $user->user_type;
        if ($request->filled('id') && $request->input('method') == 'delete') {
            $book = Book::find($request->input('id'));
            if ($book) {
                $book->delete();
            }
        }

        $books = DB::table('books');
        if ($request->filled('title')) {
            $books = $books->where('title', 'like', '%' . $request->input('title') . '%');
        }
        $books = $books->get();


        return view('view_books', ['books' => $books, 'user_type' => $user_type]);
    } else {
        return redirect('/login');
    }
})->name('index');

Route::get('/add_book', function (Request $request) {
    if (Auth::check()) {
        if ($request->filled('id')) {
            $book = null;
            if ($request->filled('id')) {
                $book = Book::find($request->input('id'));
            }
            return view('add_book')->with('book', $book);
        } else {
            $book = null;
            return view('add_book')->with('book', $book);
        }
    } else {
        return redirect('/login');
    }
})->name('add_book');

Route::get('/sign_up', function () {
    return view('sign_up');
})->name('sign_up');


Route::post('/sign_up', function (Request $request) {
    if ($request->filled('email') && $request->filled('password')) {
        if (User::where('email', $request->input('email'))->first()) {
            session()->flash('message', 'Email already in the system');
            return redirect('/login');
        }
        $user = new User();
        $user->full_name = $request->input('full_name');
        $user->email = $request->input('email');
        $user->password = md5($request->input('password'));
        $user->user_type = $request->input('user_type');
        $user->save();
        return redirect('/login');
    } else {
        return redirect('/sign_up');
    }
});

Route::post('/submit_book', function (Request $request) {
    if ($request->filled('id')) {
        Book::where('id', $request->input('id'))->update([
            'author_name' => $request->input('author_name'),
            'title' => $request->input('title'),
            'ISBN' => $request->input('ISBN'),
        ]);
    } else {
        $book = new Book();
        $book->author_name = $request->input('author_name');
        $book->title = $request->input('title');
        $book->ISBN = $request->input('ISBN');
        $book->price =  rand(250, 300);
        $book->quantity =  rand(5, 60);
        $book->save();
    }
    return redirect('/');
});

Route::post('/sign_in', function (Request $request) {
    $user = User::select('id', 'email', 'password')->where('email', $request->input('email'))->where('password', md5($request->input('password')));

    if (count($user->get())) {
        $userInfo = $user->first();
        Auth::login($userInfo);

        return redirect('/')->with('user_id', $userInfo->id);
    } else {
        return redirect('/login');
    }
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->middleware('auth')->name('logout');

Route::get('/payment',function(Request $request){
    if (Auth::check()) {
       $book=DB::table('books')->select('id','quantity','price')->where('id',$request->input('id'))->first();
        $newQuanty=$book->quantity-$request->input('quantity');
        Book::where('id', $request->input('id'))->update([
            'quantity' => $newQuanty,
        ]);
        $price=$request->input('quantity')*$book->price;
        $sale=new Sale();
        $user = Auth::user();
        $sale->book_id=$book->id;
        $sale->user_id=$user->id;
        $sale->quantity_sold=$request->input('quantity');
        $sale->price=$book->price;
        $sale->total_price=$price;
        $sale->save();
        return view('payment')->with('price',$price);
    } else {
        return redirect('/login');
    }
})->name('payment');
