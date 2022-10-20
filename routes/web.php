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
    if(auth()->check()){
        if(auth()->user()->role == 'admin'){
            return redirect('/admin');
        }elseif(auth()->user()->role == 'bazres'){
            return redirect('/user');
        }elseif (auth()->user()->role == 'unknown'){
            return view('auth.unauthenticated');
        } else {
            return view('auth.unauthenticated');
        }
    }
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/verify','Auth\VerifyController@index');
Route::post('/verify','Auth\VerifyController@verify');
/*
|--------------------------------------------------------------------------
| User Route
|--------------------------------------------------------------------------
|
| Bazresin System
|
|
|
*/
Route::group(['prefix' => 'user', 'namespace' => 'User' , 'middleware' => ['auth','verify','access','UserCheck']], function () {
    Route::resource('/', 'DashboardController');

    // Azmoon Route for User
    Route::get('/azmoon', 'AzmoonController@index')->middleware('can:bazresi');
    Route::post('/azmoon/{id}', 'AzmoonController@update')->middleware('can:bazresi');
    Route::get('/azmoon/{id}', 'AzmoonController@show')->middleware('can:bazresi');
    Route::get('/azmoon/edit/{azmoon_id}/{id}', 'AzmoonController@edit')->middleware('can:bazresi');
    Route::post('/azmoon','AzmoonController@bazresi')->middleware('can:bazresi');
    Route::get('/azmoon/choice/{id}', 'AzmoonController@choice')->middleware('can:bazresi');
    Route::get('/azmoon/modir/{id}', 'AzmoonController@modir')->middleware('can:bazresi');
    Route::get('/azmoon/iar/{exam_id}/{modir_code}', 'AzmoonController@iar')->middleware('can:bazresi');
    Route::get('/azmoon/iarSubmit/{exam_id}/{modir_code}', 'AzmoonController@iarSubmit')->middleware('can:bazresi');
    Route::post('/ajaxSaveIar', 'AzmoonController@iarSave')->middleware('can:bazresi');
    Route::post('/ajaxSaveSignature', 'AzmoonController@iarSaveSignature')->middleware('can:bazresi');
    Route::get('/azmoon/iar/excel/{exam_id}/{modir_code}','AzmoonController@excelDownload')->middleware('can:bazresi');
    Route::get('/azmoon/iar/pdf/{exam_id}/{modir_code}','AzmoonController@showPdf')->middleware('can:bazresi');
    Route::get('/azmoon/iar/pdfPrint/{exam_id}/{modir_code}','AzmoonController@createPdf')->middleware('can:bazresi');
    Route::post('/azmoon/poshtiban/create','AzmoonController@create')->middleware('can:bazresi');
    Route::get('/azmoon/bazres/{id}', 'AzmoonController@logBazres')->middleware('can:bazresi');
    Route::post('/bazresLogSave', 'AzmoonController@logBazresCreate')->middleware('can:bazresi');
    Route::post('/azmoonPoshtibanMark','AzmoonController@poshtibanMark');
    // End

    // Profile
        Route::get('/profile', 'ProfileController@index');
        Route::put('/profile', 'ProfileController@update');
        Route::post('/profile/setting', 'ProfileController@setting');
    // End


    // Report
    Route::group(['prefix' => 'report', 'middleware' => 'can:report-bazresi'], function () {
        Route::get('/', 'ReportController@index');

        // Modir
        Route::get('/modir', 'ReportController@modir');
        Route::get('/modir/{exam_id}/{modir_code}', 'ReportController@modirReport');
        Route::get('/excel', 'ReportController@downloadExcel');
        Route::get('/excelItemIar', 'ReportController@downloadExcelItemIar');
        Route::get('/pdf', 'ReportController@downloadPdf');
        Route::get('/poshtiban/{exam_id}/{codemeli}', 'ReportController@reportPoshtiban');
        // End
    });
    // End




    // Leader
    Route::group(['prefix' => 'leader', 'middleware' => 'can:report-bazresi'], function () {
        Route::get('/dataEntry', 'LeaderController@dataEntry');
        Route::get('/dataEntry/{id}', 'LeaderController@indexDataEntry');
        Route::get('/dataEntry/excel/{id}', 'LeaderController@excelDownloadFull');
        Route::get('/dataEntry/pdf/{id}', 'LeaderController@createPdf');
        Route::get('/poshtiban/{exam_id}/{poshtiban_code}', 'LeaderController@poshtiban');
        Route::post('poshtibanSearchAjax', 'PoshtibanController@searchAjax');
        Route::resource('/poshtibans','PoshtibanController');

        Route::get('/modirs/{exam_id}/{modir_code}', 'LeaderController@modir');
        Route::get('modirs/search', 'ModirController@search');
        Route::post('modirSearchAjax', 'ModirController@searchAjax');
        Route::resource('/modirs','ModirController');
    });
    // End

    // Inspector Site
    Route::resource('/inspector','InspectorSiteController')->middleware('can:presence-statistics');
    // End

});

/*
|--------------------------------------------------------------------------
| Admin Route
|--------------------------------------------------------------------------
|
| Bazresin System
|
|
|
*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin' , 'middleware' => ['auth','verify','access','AdminCheck']], function () {
    Route::resource('/', 'DashboardController');
    Route::resource('/users', 'UsersController');

    Route::resource('/permissions', 'PermissionController')->middleware('can:manage-permission');
    Route::resource('/roles', 'RoleController')->middleware('can:manage-role');

    // Hozeh Route
    Route::get('/hozeh','HozehController@index');
    Route::get('/hozeh/upload','HozehController@upload');
    Route::post('/hozeh/upload', 'HozehController@fileUploadHozeh')->name('fileUploadHozeh');
    Route::get('/hozeh/layouts', 'HozehController@layouts');
    Route::get('/hozeh/layouts/{id}/edit', 'HozehController@edit');
    Route::post('/hozeh/layouts/arange_save', 'HozehController@arangeSave');
    Route::post('/hozeh/layouts/arange_update', 'HozehController@arangeUpdate');
    Route::post('/ajax_arrange_exam','HozehController@ajax_arrange_exam');
    // End

    // Modir Route
    Route::get('/modir','ModirController@index');
    Route::get('/modir/upload','ModirController@upload');
    Route::post('/modir/upload', 'ModirController@fileUploadModir')->name('fileUploadModir');
    // End


    // IAR Form
    Route::get('/iar', 'IarController@index');
    Route::get('/iar/question', 'IarController@q_index');
    Route::get('/iar/question/create', 'IarController@q_create');
    Route::post('/iar/question', 'IarController@q_store');
    Route::put('/iar/question/{id}', 'IarController@q_update');
    Route::delete('/iar/question/{id}', 'IarController@q_destroy');
    Route::get('/iar/question/{id}/edit', 'IarController@q_edit');
    // End


    // Exams
    Route::get('/exams', 'ExamController@index');
    Route::get('/exams/create', 'ExamController@create');
    Route::post('/exams', 'ExamController@store');
    Route::get('/exams/{id}/edit', 'ExamController@edit');
    Route::get('/examFullExcel/{id}', 'ExamController@excelDownloadFull');
    // End

    //update Exam
    Route::get('/exams/update/{project_id}', 'ExamUpdateController@index');
    Route::get('/exams/update/{project_id}/{column_name}', 'ExamUpdateController@deletecol');
    Route::post('/exams/update/editname', 'ExamUpdateController@editname');
    Route::post('/exams/update/addcol', 'ExamUpdateController@addcol');
    Route::post('/exams/update/edititem', 'ExamUpdateController@edititem');
    Route::get('/exams/update/{id}/{itemid}/{column}', 'ExamUpdateController@delitem');
    Route::post('/exams/update/additem', 'ExamUpdateController@additem');
    Route::post('/exams/update/show', 'ExamUpdateController@showw');
    Route::get('/downloadLastVersion/{id}','ExamUpdateController@downloadExel');
    Route::get('/exams/updateing/{id}','ExamUpdateController@edit');
    Route::post('/exams/update_exam','ExamUpdateController@updatename');
    Route::patch('/exams/updateProj', 'ExamUpdateController@update')->name('project.updateProj');
    Route::post('/ajax_change_type_column', 'ExamUpdateController@ajax_change_type_column');
    Route::post('/ajaxChangeRequireColumn', 'ExamUpdateController@changeRequire');
    //  End

    // Inspector
    Route::get('/inspector','InspectorController@index');
    Route::get('/inspector/upload','InspectorController@upload');
    Route::post('/inspector/upload', 'InspectorController@fileUploadInspector')->name('fileUploadInspector');
    // End
});
