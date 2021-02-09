<?php

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

Route::get('/', function () {
    return view('welcome');
});

use App\User;
use App\Profile;
use App\Post;
use App\Category;
use App\Role;
use App\Portfolio;
use App\Tag;

Route::get('/create_user', function(){
    $user = User::create([
        'name' => 'sandhika',
        'email' => 'sandhika@gmail.com',
        'password' => bcrypt('password')
    ]);
    return $user;
});

Route::get('/create_profile', function() {
    $profile = Profile::create([
        'user_id' => 1,
        'phone' => '0989332211',
        'address' => 'Jl. Baru, No.3'
    ]);
    return $profile;
});

Route::get('/create_user_profile', function() {
    $user = User::find(2);

    $profile = new Profile([
        'phone' => '098899883344',
        'address' => 'Jl. Raya, No.123'
    ]);

    $user->profile()->save($profile);
    return $user;
});

Route::get('/read_user', function() {
    $user = User::find(1);

    $data = [
        'name' => $user->name,
        'phone' => $user->profile->phone,
        'address' => $user->profile->address
    ];

    return $data;
});

Route::get('/read_profile', function() {
    $profile = Profile::where('phone','0989332211')->first();

    $data = [
        'name' => $profile->user->name,
        'email' => $profile->user->email,
        'phone' => $profile->phone,
        'address' => $profile->address
    ];

    return $data;
});

Route::get('/update_profile', function() {
    $user = User::find(2);

    $data = [
        'phone' => '001122',
        'address' => 'jl. Pekan baru'
    ];

    $user->profile()->update($data);
    return $user;
});


Route::get('/delete_profile', function() {
    $user = User::find(2);

    $user->profile()->delete();

    return $user;
});

Route::get('/create_post', function() {
    // $user = User::create([
    //     'name' => 'sandhika',
    //     'email' => 'sandhika@gmail.com',
    //     'password' => bcrypt('password'),
    // ]);

    $user = User::findOrFail(2);

    $user->posts()->create([
        'title' => 'Isi Title post terbaru milik Member 1',
        'body' => 'Hello world psot tebaru milik Member 1'
    ]);

    return 'Success';
});

Route::get('/read_posts', function() {
    $user = User::find(3);

    $posts = $user->posts()->get();
    
    foreach ( $posts as $post ) {
        $data[] = [
            'name' => $post->user->name,
            'post_id' => $post->user_id,
            'title' => $post->title,
            'body' => $post->body
        ];
    }

    return $data;
});


Route::get('/update_post', function() {

    $user = User::find(3);

    $user->posts()->where('id', 2)->update([
        'title' => 'ini isian title post terbaru 2',
        'body' => 'ini isian title body terbaru 2'
    ]);

    return 'Success';
});

Route::get('/delete_post', function() {

    $user = User::find(3);

    $user->posts()->where('id', 2)->delete();

    return 'Success';
});

Route::get('/create_categories', function() {
    // $post = Post::findOrFail(1);
    // $post->categories()->create([
    //    'slug' => Str::slug('PHP','-'),
    //    'category' => 'PHP'
    // ]);

    // return 'Success';

    $user = User::create([
        'name' => 'Hakim',
        'email' => 'hakim@gmail.com',
        'password' => bcrypt('password')
    ]);

    $user->posts()->create([
        'title' => 'New Post',
        'body' => "New Body"
    ])->categories()->create([
        'slug' => Str::slug('New Category','-'),
        'category' => 'New Category'
    ]);
});


Route::get('/read_category', function() {
    // $post = Post::find(1);

    // $categories = $post->categories->where('id',2);
    // foreach ( $categories as $category ) {
    //     echo $category->slug . '</br>';
    // }

    $category = Category::find(3);

    $posts = $category->posts;

    foreach ( $posts as $post ) {
        echo $post->title . '</br>';
    }
});


Route::get('/attach', function() {
    // $post = Post::find(2);
    // $post->categories()->attach(1);

    $post = Post::find(3);
    $post->categories()->attach([1,2,3]);

    return 'Success';
});

Route::get('/detach', function() {
    $post = Post::find(3);
    $post->categories()->detach(1);

    return 'Success';
});

Route::get('/sync', function() {
    $post = Post::find(3);
    $post->categories()->sync([2,3]);

    return 'Success';
});

Route::get('/role/posts', function() {
    $role = Role::find(2);
    return $role->posts;
});


Route::get('/comment/create', function() {
    // $post = Post::find(1);
    // $post->comments()->create([
    //     'user_id' => 1,
    //     'content' => 'Balasan dari respon user id 1'
    // ]);

    $post = Portfolio::find(1);
    $post->comments()->create([
        'user_id' => 1,
        'content' => 'Balasan dari respon portflio id 1'
    ]);

    return 'Success';
});

Route::get('/comment/read', function() {
    // $post = Post::findOrFail(1);
    // $comments = $post->comments;
    // foreach ( $comments as $comment ) {
    //     echo $comment->user->name . ' - ' . $comment->content . ' (' . $comment->commentable->title . ') <br>';
    // };

    // return 'Success';

    $portfolio = Portfolio::findOrFail(1);
    $comments = $portfolio->comments;
    foreach ( $comments as $comment ) {
        echo $comment->user->name . ' - ' . $comment->content . ' (' . $comment->commentable->title . ') <br>';
    };

    return 'Success';

    
});


Route::get('/comment/update', function() {
    
    // $post = Post::find(1);
    // $comment = $post->comments()->where('id', 1)->first();
    // $comment->update([
    //    'content' => 'Komentar dari post berhasil di sunting'
    // ]);

    $portfolio = Portfolio::find(1);
    $comment = $portfolio->comments()->where('id', 3)->first();
    $comment->update([
       'content' => 'Komentar dari portfolio berhasil di sunting'
    ]);

    return 'Success';
});


Route::get('/comment/delete', function() {

    // $post = Post::find(1);
    // $comment = $post->comments()->where('id', 2)->first();
    // $comment->delete();

    // return 'Success';

    $portfolio = Portfolio::find(1);
    $comment = $portfolio->comments()->where('id', 4)->first();
    $comment->delete();

    return 'success';
});

Route::get('/tag/read', function() {
    // $post = Post::find(1);

    // foreach ( $post->tags as $tag ) {
    //     echo $tag->name . '<br>';
    // };

    $portfolio = Portfolio::find(1);

    foreach ( $portfolio->tags as $tag ) {
        echo $tag->name . '<br>';
    };
});


Route::get('/tag/attach', function() {
    $post = Post::find(1);

    $post->tags()->attach([4,5,6]);

    // $portfolio = Portfolio::find(1);

    // $portfolio->tags()->attach([7,8,4]);

    return 'success';
});

Route::get('/tag/detach', function() {
    // $post = Post::find(1);

    // $post->tags()->detach([1,3]);

    $portfolio = Portfolio::find(1);

    $portfolio->tags()->detach([2,8]);
    
    return 'Success';
});

Route::get('/tag/sync', function() {
    $post = Post::find(1);

    $post->tags()->sync([8]);
});
