<?php

Route::get('/{any?}', 'SPAController@index')
    ->where('any', '^(?!api\/)[\/\w\.-]*');
