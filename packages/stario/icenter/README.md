# TODO
## Requirements
1. stario/permission
2. tymon/jwt-auth
## Configuration

1. publish the config using the following command: 
```$ php artisan vendor:publish```
2. $ php artisan migrate/db:seed
3. You have to register middleware in app/Http/Kernel.php under the $routeMiddleware property:
'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,
4. In config/jwt.php change follow:
```'user' => 'Star\Icenter\User',```
5. Add this line below in *App\Http\Kernel.php*
```'role' => \Star\Icenter\Middleware\Role::class,```
6. Add this line below in *database\seeds\DatabaseSeeder.php*
``` $this->call(Star\Icenter\resources\seeds\IcenterSeeder::class); ```
7. Add this line in *config/jwt.php*
```     'user' => 'Star\Icenter\User', ```
## Usage
```  Route::group(['prefix' => 'user', 'middleware' => ['jwt.auth', 'role:admin,manage users']], function () {
    Route::get('me', 'UserController@me');
    Route::get('menu', 'UserController@menuList');
  });```
