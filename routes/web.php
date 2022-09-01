<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/kirim-email', 'SendmailController@index')->name('email');
Route::post('/test-send-email', 'SendmailController@send')->name('send.email');
/*
Route::group(['prefix' => 'admin'], function () {
	//Login Routes...
	Route::get('/login','Adminauth\LoginController@getLoginForm');
	Route::pots('/authenticate','Adminauth\LoginController@authenticate');

});
*/
Auth::routes();
//admin routes
Route::get('/manajemen-pengguna', 'AdminController@userList');
Route::get('/tambah-pengguna', 'AdminController@formUser');
Route::post('/tambah-pengguna', 'AdminController@insertUser');
Route::get('/getdata-manajemen-pengguna', 'AdminController@getUserList');
Route::get('/getdata-agen', 'AdminController@getAgenList');
Route::get('/detail-pengguna/{id}', 'AdminController@detailPengguna');
Route::post('/update-fee-pengguna', 'AdminController@updateFee');
Route::get('/edit-pengguna/{id}', 'AdminController@editUser');
Route::post('/update-pengguna', 'AdminController@updateUser');
Route::post('/update-rate-ijp-sppsb', 'AdminController@updateRateSppsb');	//rate sppsb
Route::post('/update-rate-ijp-sp3kbg', 'AdminController@updateRateSp3kbg');	//rate sp3kbg
Route::post('/update-status-pengguna', 'AdminController@updateStatus');
Route::get('/backup-database', 'AdminController@backupDB');

Route::get('/bank', 'BankController@index');
Route::get('/getdata-bank-tablelist', 'BankController@getDataBank');
Route::get('/tambah-bank', 'BankController@addBank');
Route::post('/tambah-bank', 'BankController@insertBank');
Route::get('/edit-bank/{id}', 'BankController@editBank');
Route::post('/update-bank', 'BankController@updateBank');

Route::get('/manage-data-pengajuan', 'AdminController@manageData');
Route::get('/getdata-draft-sppsb', 'AdminController@getSppsbDraftTable');
Route::get('/getdata-draft-sp3kbg', 'AdminController@getSp3kbgDraftTable');
Route::get('/delete-data-sppsb/{id}', 'AdminController@deleteDataSppsb');
Route::get('/delete-data-sp3kbg/{id}', 'AdminController@deleteDataSp3kbg');

//common routes
Route::get('/home', 'CommonController@index');
Route::get('/sppsb-detail/{id}', 'SppsbController@detail');		// detail sppsb
Route::get('/sp3kbg-detail/{id}', 'Sp3kbgController@detail'); 	// detail sp3kbg
Route::post('/sppsb-update', 'SppsbController@update');			// update sppsb
Route::post('/sp3kbg-update', 'Sp3kbgController@update'); 		// update sp3kbg
Route::get('/sppsb-disetujui', 'SppsbController@disetujui');
Route::get('/getdata-sppsb-disetujui', 'SppsbController@getDisetujuiTable');
Route::get('/getdata-sp3kbg-disetujui', 'Sp3kbgController@getDisetujuiTable');
Route::get('/sppsb-ditolak', 'SppsbController@ditolak');
Route::get('/getdata-sppsb-ditolak', 'SppsbController@getDitolakTable');
Route::get('/getdata-sp3kbg-ditolak', 'Sp3kbgController@getDitolakTable');

Route::get('/laporan', 'SppsbController@laporan');
Route::get('/getdata-detail-agen/{id}/{startDate}/{endDate}', 'SppsbController@getDataReportAgen');
Route::get('/getdata-detail-agen-all/{id}/{startDate}/{endDate}', 'SppsbController@getDataReportAgenAll');
Route::get('/getdata-belum-terbit/{id}', 'SppsbController@getDataBlmTerbit');
Route::get('/getdata-rekap-agen/{startDate}/{endDate}', 'SppsbController@getDataRekapAgen');
Route::get('/getdata-rekap-wilayah/{startDate}/{endDate}', 'SppsbController@getDataRekapWilayah');
Route::post('/cetak-laporan-agen-detail', 'ReportController@cetakAgenDetail');
Route::post('/cetak-laporan-agen-detail-all', 'ReportController@cetakAgenDetailAll');
Route::post('/cetak-laporan-rekap-agen', 'ReportController@cetakRekapAgen');
Route::post('/cetak-laporan-perwilayah', 'ReportController@cetakPerWilayah');
Route::post('/cetak-laporan-belum-terbit', 'ReportController@cetakBelumTerbit');
Route::post('/cetak-laporan-agen', 'ReportController@cetakLapAgen');

Route::get('/ganti-password', 'CommonController@gantiPassword');
Route::post('/ganti-password', 'CommonController@updatePassword');
Route::get('/profil-pengguna', 'CommonController@profil');
Route::get('/edit-profil-pengguna', 'CommonController@editProfil');
Route::post('/update-profil-pengguna', 'CommonController@updateProfil');
Route::get('/cek-sertifikat', 'CommonController@ceksertifikat');

//agen routes
//proses sppsb
Route::get('/sppsb-form', 'AgenController@form');
Route::post('/sppsb-form', 'AgenController@insert');
Route::get('/sppsb-edit/{id}', 'AgenController@edit');
Route::post('/sppsb-edit', 'AgenController@update');
Route::get('/sppsb-sp3kbg-data-table', 'AgenController@data');
Route::get('/getdata-sppsb', 'AgenController@getDataTable');

//proses sp3kbg
Route::get('/sp3kbg-form', 'AgenController@formSp3kbg');
Route::post('/sp3kbg-form', 'AgenController@insertSp3kbg');

Route::get('/sp3kbg-edit/{id}', 'AgenController@editSp3kbg');
Route::post('/sp3kbg-edit', 'AgenController@updateSp3kbg');
Route::get('/getdata-sp3kbg', 'Sp3kbgController@getDataTable');

Route::get('/sppsb-cetak-sertifikat', 'AgenController@cetak');
Route::get('/getdata-sppsb-cetak', 'AgenController@getCetakSppsbTable');

Route::get('/getdata-sp3kbg-cetak', 'AgenController@getCetakSp3kbgTable');
//staff route
Route::get('/sppsb-sp3kbg-masuk', 'StaffController@masuk');
Route::get('/getdata-sppsb-masuk', 'StaffController@getSppsbMasukTable');
Route::get('/getdata-sp3kbg-masuk', 'StaffController@getSp3kbgMasukTable');
Route::get('/sppsb-penomoran/{id}', 'StaffController@penomoranSppsb');
Route::post('/sppsb-penomoran', 'StaffController@updateSppsb');
Route::get('/sp3kbg-penomoran/{id}', 'StaffController@penomoranSp3kbg');
Route::post('/sp3kbg-penomoran', 'StaffController@updateSp3kbg');
Route::get('/getdata-rate-ijp', 'StaffController@getRateIjp');
//direksi route
Route::get('/getdata-sppsb-layak', 'DireksiController@getLayakSppsbTable');
Route::get('/getdata-sp3kbg-layak', 'DireksiController@getLayakSp3kbgTable');
Route::get('/sppsb-detail-direksi/{id}', 'DireksiController@detailSppsb');
Route::get('/sp3kbg-detail-direksi/{id}', 'DireksiController@detailSp3kbg');
Route::post('/sppsb-direksi-update', 'DireksiController@updateSppsb');
Route::post('/sp3kbg-direksi-update', 'DireksiController@updateSp3kbg');
Route::post('/update-signed-master', 'DireksiController@signedUpdate');
//report routes
Route::get('/cetak-detail-sppsb/{id}', 'ReportController@detailSppsb');
Route::get('/cetak-analisa-sppsb/{id}', 'ReportController@analisaSppsb');
Route::get('/cetak-detail-sp3kbg/{id}', 'ReportController@detailSp3kbg');
Route::get('/cetak-sertifikat-sppsb/{id}', 'ReportController@sertifikatSppsb');
Route::get('/cetak-perjanjian-ganti-rugi/{id}', 'ReportController@perjanjian');
Route::get('/cetak-sertifikat-sp3kbg/{id}', 'ReportController@sertifikatSp3kbg');
Route::get('/cetak-sp3kbg/{id}', 'ReportController@cetakSp3kbg');


Route::get('/verify/{id}', 'VerifyController@sertifikatSppsb');

Route::get('/sb-detail/{id}', 'VerifyController@detail');	
Route::get('/sppsb-form-admin', 'StaffController@formStaff');	
Route::get('/carikontraktor', 'StaffController@search');
//Route::post('/spsb-form-staff', 'StaffController@insertSPPSB');
Route::get('/cari-pemilik-proyek', 'StaffController@searchPemilikProyek'); 

Route::post('/sppsb-form-staff', 'StaffController@insert');
Route::get('/sppsb-detail-staff/{id}', 'StaffController@detail');
Route::get('/sppsb-edit-staff/{id}', 'StaffController@edit');
Route::post('/sppsb-edit-staff', 'StaffController@update');
Route::get('/sppsb-sp3kbg-data-table-staff', 'StaffController@data');
Route::get('/getdata-sppsb-staff', 'StaffController@getDataTable');
Route::post('/sppsb-update-staff', 'SppsbController@update');			// update sppsb


Route::get('/sppsb-cetak-sertifikat-kabag', 'AgenController@cetakkabag');
Route::get('/getdata-sppsb-cetak-kabag', 'AgenController@getCetakSppsbTableKabag');
