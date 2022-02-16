# Laravel 8 Multi Level with isAdmin

## Models/User
```php
protected $fillable = [
        'name',
        'email',
        'password',
        'isAdmin'
    ];
```

## User Migration
```php
Schema::create('users', function (Blueprint $table) {
  //
  $table->boolean('isAdmin')->default(0);
});
```


## Middleware
```artisan
php artisan make:middleware isAdmin
```
```php
public function handle(Request $request, Closure $next) {
  if(Auth::user()->isAdmin == true) {
    return $next($request);
  } else {
    dd('not admin'); // you can redirect this into everywhere
  }
}
```
declare it on Kernel
```php
protected $routeMiddleware = [
        //
        'auth' => \App\Http\Middleware\Authenticate::class,
        'admin' => \App\Http\Middleware\isAdmin::class,
    ];
```

## Routes
return view is depends on your views
```php
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin', function () {
        return view('dashboard.admin');
    });
});
Route::get('/dashboard', function () {
    return view('dashboard.member');
})->middleware('auth');
```

## AuthController
```php
public function authenticate(Request $request) {
  $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
  ]);

  if(Auth::attempt($credentials)) {
      $request->session()->regenerate();

      if(Auth::user()->isAdmin == true) {
          return redirect()->intended('admin');
      } else {
          return redirect()->intended('dashboard');
      }
  }
  return back()->withErrors('GAGAL');
}
```
