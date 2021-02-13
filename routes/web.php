<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new' => true,
        'has_posts' => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false
    ],
    3 => [
        'title' => 'Intro to Golang',
        'content' => 'This is a short intro to Go',
        'is_new' => false
    ]
];

// // Route::get('/', function () {
// //     return view('home.index');
// // })->name('home.index');

// Route::view('/', 'home.index')->name('home.index');
Route::get('/', [PostsController::class, 'index'])
    ->name('home.index');
    // ->middleware('auth');

// // Route::get('/contact', function () {
// //     return view('home.contact');
// // })->name('home.contact');

// Route::view('/contact', 'home.contact')->name('home.contact');
Route::get('/contact', [HomeController::class, 'contact'])
    ->name('home.contact');

Route::get('/secret', [HomeController::class, 'secret'])
    ->name('secret')
    ->middleware('can:home.secret');

Route::get('/single', AboutController::class);

// // Route::get('/home/{id?}/{name?}', function($the_id = 0, $the_name = 'no name') {
// //     return 'Hello, World!' . '<br>' . $the_id . '<br>' . $the_name;
// // });

// // Route::get('/posts', function(Request $request) use ($posts) {
// Route::get('/posts', function () use ($posts) {
//     request()->whenFilled('name', function ($name) {
//         dd($name);
//     });

//     // dd(request()->all());
//     // dd((int)request()->input('page', 1)); // all input types (form, query params), default = 1
//     dd((int)request()->query('page', 1)); // only query params, default = 1

//     // compact($posts) === ['posts' => $posts]
//     return view('posts.index', ['posts' => $posts]);
// });

// Route::get('/posts/{id}', function ($id) use ($posts) {
//     abort_if(!isset($posts[$id]), 404);

//     return view('posts.show', ['post' => $posts[$id]]);
// })->name('posts.show');

Route::resource('posts', PostsController::class);
    // ->only(['index', 'show', 'create', 'store', 'edit', 'update']);

Route::get('/posts/tag/{tag}', [PostTagController::class, 'index'])->name('posts.tags.index');

Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
    return 'posts from ' . $daysAgo . ' days ago';
})->name('posts.recent.index')->middleware('auth');

Route::prefix('/fun')->name('fun.')->group(function () use ($posts) {
    Route::get('/fun/responses', function () use ($posts) {
        return response($posts, 201)
            // ->view('home.index')
            ->header('Content-Type', 'application/json')
            ->cookie('MY_COOKIE', 'Wernich', 3600);
    })->name('responses');

    Route::get('/redirect', function () {
        return redirect('/contact');
    })->name('redirect');

    Route::get('/back', function () {
        return back();
    })->name('back');

    Route::get('/named-route', function () {
        return redirect()->route('posts.show', ['id' => 1]);
    })->name('named-route');

    Route::get('/away', function () {
        return redirect()->away('https://google.com');
    })->name('away');

    Route::get('/json', function () use ($posts) {
        return response()->json($posts);
    })->name('json');

    Route::get('/download', function () {
        return response()->download(public_path('/daniel.jpg'), 'picture.jpg');
    })->name('download');
});

Route::resource('posts.comments', PostCommentController::class)->only('store');

Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

Auth::routes();
