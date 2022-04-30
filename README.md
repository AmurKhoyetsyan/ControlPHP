# Control PHP
for open page index.php of public -> public/index.php

### for remove storage view files
run in terminal this command

    php control view:clear

If `composer install` or `composer update` does not work, write `composer dumb-autoload -o`

#### example route

    use Lib\Route\Route;
    use App\Controller\HomeController;

    Route::get('/', function() {
        return view('welcome');
    });
    
    Route::middleware('auth', function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
    });
    
    Route::get('/home', [HomeController::class, 'index']);
    
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/create', [HomeController::class, 'store'])->name('save');
    Route::put('/update', [HomeController::class, 'update'])->name('update');
    Route::destroy('/delete', [HomeController::class, 'destroy'])->name('delete');


#### methods

    dd(...$args) // for print data
    basePath() // reurned string base path
    url('/img/upload/favicon.ico') // returned string file in pubblic directory
    env($keyItem, $path) // get .env file end returned value by key
    route($name, $id, $option) // getted route path by name and returned path
    redirect($name, $id, $option) // redirected route by name
    config($path) // get config content file and returned array (json)
    view($viewName, $arguments) // returned view by path on resources exp view('home.index', ['data' => $data]) and added arguments
    response($data, $json = true) // for api
    includes($path, $rule = false) // included file by path on resources
    uuid($len) // returned unic id
    
    
#### for include in view 

    @include($path) // included file by path on resources exp @includes('pages.money.partials.table')
    
#### DB

    in DB all methods is static
    
    DB::beginTransaction();
    DB::commit();
    DB::rollback();
    DB::getConnection();
    DB::getDB();
    
#### Model

    get($column)
    find($id, $column)
    create($data)
    where($condition) // $this->model->where(['last_name', '=', 'test'])->get(['id', 'name', 'last_name'])
    rightJoin($columns, $relationTable, $condition, $where)
    pagination($limit $order, $columns, $option)
    update($id, $request)
    delete($id)