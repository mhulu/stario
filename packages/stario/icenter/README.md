# TODO
## Requirements
1. stario/permission
2. tymon/jwt-auth
## Configuration
1. Add this line below in *App\config\app.php*
```'Tymon\JWTAuth\Providers\JWTAuthServiceProvider'```
```'JWTAuth' => 'Tymon\JWTAuth\Facades\JWTAuth'```
Also included is a Facade for the PayloadFactory. This gives you finer control over the payloads you create if you require it
```'JWTFactory' => 'Tymon\JWTAuth\Facades\JWTFactory'```
2. publish the config using the following command: 
```$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\JWTAuthServiceProvider"```
3. $ php artisan jwt:generate
4.You have to register middleware in app/Http/Kernel.php under the $routeMiddleware property:
'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,