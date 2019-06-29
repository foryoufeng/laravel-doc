//doc route
Route::group(['namespace'=>'Docs'],function (){
    Route::get('doc', 'LaravelDocController@index')->name('doc.index');
    Route::get('doc/html', 'LaravelDocController@html')->name('doc.html');
    Route::get('apidoc', 'LaravelApiDocController@index')->name('doc.apidoc');
    Route::get('apidoc/html', 'LaravelApiDocController@html')->name('doc.apidoc.html');
    Route::post('apidoc/markdown', 'LaravelApiDocController@markdown')->name('doc.apidoc.markdown');
    Route::post('apidoc/save', 'LaravelApiDocController@save')->name('doc.apidoc.save');
});
