<?php



use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('home'); // resources/home.html
})->name('home');


Route::get('/', function () {
    return view('home', ['title' => 'google.com', 'body' => 'Body']); // resources/home.php
})->name('home');
// resources/home/index.php
// view('home.index')



Route::get('greeting', [\App\Http\Controllers\GreetingController::class, 'greet']);


//create subroute sau /greeting/subroute
Route::prefix('greeting')->group(function () {

    // work for: /greeting/vn
    Route::get('vn', function () {
        return "Xin chào!";
    });

    // work for: /greeting/en
    Route::get('en', function () {
        return "Hello!";
    });

    // work for: /greeting/cn
    Route::get('cn', function () {
        return "china!";
    });
});

// regular {id?} ko co cung dc, nen callback($id = null) de khong error
// Route::get('user/{id?}', function ($id = null) {
//     if (!$id) {
//         return "Xin mời nhập id";
//     }

//     return "User id: $id";
// });

// c1 check id commentId use regular
Route::get('user/{id}/comment/{commentId}', function ($id, $commentId) {
    return "User id: $id and comment id: $commentId";
})->where('id', '[0-9]+')->where('commentId', '[0-9]+');

// c2
Route::get('person/{id}/comment/{commentId}', function ($id, $commentId) {
    return "User id: $id and comment id: $commentId";
})->where(['id' => '[0-9]+', 'commentId' => '\w+']);


// whereNumber($name): tương đương với where($name, '[0-9]+')
// whereAlpha($name): tương đương với where($name, '[a-zA-Z]+')
// whereAlphaNumeric($name): tương đương với where($name, '[a-zA-Z0-9]+')
// whereUuid($name): tương đương với where($name, '[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}') (định dạng UUID)

Route::get('/welcome', function () {
    return "welcome haha!!!";
})->name('welcome');

Route::prefix('user')->as('user.')->group(function () {
    Route::get('profile', function () {
        //
    })->name('profile');

    Route::get('post/{id}', function () {
        //
    })->name('show.post');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', function () {
        //
    });
});


Route::domain('{account}.example.com')->group(function () {
    Route::get('user/{id}', function ($account, $id) {
        //
    });
});


use App\Models\User; //User class

Route::get('/users/{user}', function (User $user) {
    return $user->email;
});


// Route::current() - Lấy ra current route dạng object (Illuminate\Routing\Route).
// Route::currentRouteName() - Lấy ra current route name. Nếu route không set name thì nó sẽ trả về null.
// Route::currentRouteAction() - Lấy ra current action của route. Cái này chỉ work nếu bạn sử dụng Controller làm action cho route.


// <form action="/example" method="POST">
//     <input type="hidden" name="_method" value="PUT">
//     <input type="hidden" name="_token" value="{{ csrf_token() }}">
// </form>

// csrf_field();

// // Output: <input type="hidden" name="_token" value="jtjDHciPJs0riuoHAEHGYNkxdF1DARv5xo9oVOg2">

// <form action="/example" method="POST">
//     @csrf
// </form>

// terminal
// php artisan route:cache
// php artisan route:clear
// php artisan route:list


// use Illuminate\Support\Facades\View;

//select view: 'custom.admin'
// return View::first(['custom.admin', 'admin'], $data);

// if (View::exists('home')) {
//    // tồn tại
// }

// pass data $title to view='home'
// view='*' all view
View::composer('home', function ($view) {
    $view->with('title', 'Toidicode.com');
});

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

Route::post('/requestcls', [UserController::class, 'store']);



Route::get('request', function (Request $request) {
    return "Path: " . $request->path();
});


Route::get('request', function (Request $request) {
    return "Path: " . $request->url();
});

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return "Path: " . $request->fullUrl();
});

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return "Path: " . $request->fullUrlWithQuery(['name' => 'VuThanhTai']);
});

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return 'User Agent: ' . $request->header('user-agent');
});


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return 'Header: ' . $request->header('toidicode', 'Làm gì có header này');
});

/*
    $token = $request->bearerToken();

    $token = $request->header('Authorization', '');

    $ipAddress = $request->ip();

    if ($request->is('admin/*')) {
        // path co bat dau = admin ko
    }

    if ($request->routeIs('admin.*')) {
        // route name co bat dau = admin. ko
    }
    if ($request->isMethod('post')) {
        //
    }
    $method_name = $request->method();


    $input = $request->input();
    // Tương đương với
    $input = $request->all();


    $name = $request->input('name');
    $name = $request->input('name', 'Lò Thị Vi Sóng');

    $name = $request->input('products.0.name');
    // tương đương product[0]['name']

    $names = $request->input('products.*.name');
    // tương đương với lấy hết ra name của products
    

    $archived = $request->boolean('archived');


    $name = $request->name;


    // chi lay username, password
    $input = $request->only(['username', 'password']);
    // hoặc
    $input = $request->only('username', 'password');


    bo qua credit_card, con lai lay all
    $input = $request->except(['credit_card']);
    // hoặc
    $input = $request->except('credit_card');


    $query = $request->query();

    $name = $request->query('name');

    $name = $request->query('name', 'Lò Thị Vi Sóng');
    


    if ($request->has('name')) {
            //
    }

    if ($request->has(['name', 'email'])) {
        //
    }

    if ($request->has('name') && $request->has('email')) {
        //
    }


    if ($request->hasAny(['name', 'email'])) {
        //
    }

    if ($request->has('name') || $request->has('email')) {
        //
    }

    // co name thi run function
    $request->whenHas('name', function ($input) {
        //
    });
    
    if ($request->filled('name')) {
      // co name='value thi true'
    }

    $request->whenFilled('name', function ($input) {
      // 
    });

    if ($request->missing('name')) {
      // ko co name thi run
    }


    //luu all into session
    $request->flash();
    
    //only luu username, email
    $request->flashOnly(['username', 'email']);
    
    //luu all tru password
    $request->flashExcept('password');

    $username = $request->old('username');
    $username = $request->old('username', 'Trần Như Nhộng');
    

    $file = $request->file('photo');
    $file = $request->photo;
    
    if ($request->hasFile('photo')) {
    // co file 'photo' ko
    }

    if ($request->file('photo')->isValid()) {
     // file 'photo' upload thanh cong ko
    }






    

*/