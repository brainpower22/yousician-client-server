<?php

use App\Http\Middleware\SessionMiddleware;
use App\Support\Route;

Route::get('/phpinfo', 'HomeController@phpInfo')->setName('phpinfo');

Route::group('api', function () {
    Route::post('/event/new/Exception', 'Controller@empty')->setName('postException');
});

Route::post('/authenticated', 'AuthController@logged')->setName('logged');
Route::get('/profile', 'ProfileController@profile')->setName('profile');

Route::group('', function () {

    Route::post('/home', 'HomeController@home')->setName('home');

    Route::post('/profile/preferences', 'ProfileController@preferences')->setName('profilePreferences');
    Route::get('/profile/activity', 'ProfileController@activity')->setName('profileActivity');
    Route::post('/profile/syllabus/switch', 'ProfileController@switch')->setName('postProfileSwitch');

    Route::get('/syllabus/guitar/versions', 'SyllabusController@versions')->setName('versions');
    Route::get('/syllabus/{instrument}', 'SyllabusController@instrument')->setName('syllabusInstrument');

    Route::get('/songs/gp/{id}', 'SongController@mxl')->setName('songsMxl');
    Route::get('/songs/mxl/{id}', 'SongController@mxl')->setName('songsMxl');
    Route::post('/songs/user/remove/{doc_id}', 'SongController@songsUserRemove')->setName('postSongsUserRemove');
    Route::post('/songs/filter/favorite/ids', 'SongController@filterFavoriteIds')->setName('postSongsFilterFavoriteIds');
    Route::post('/songs/{id}/favorite/add', 'SongController@favoriteAdd')->setName('songsFavoriteAdd');
    Route::post('/songs/{id}/favorite/remove', 'SongController@favoriteRemove')->setName('songsFavoriteRemove');

    Route::post('/usersongs', 'SongController@userSongs')->setName('postUserSongs');
    Route::post('/usersongs/modify/{doc_id}', 'SongController@userSongsModify')->setName('postUserSongsModify');

    Route::post('/events/new/{event}', 'Controller@empty')->setName('postEventNew');

    Route::get('/notifications', 'NotificationController@notifications')->setName('getNotifications');
    Route::get('/ratings', 'RatingController@ratings')->setName('getRatings');
    Route::get('/third_party_service_status', 'Controller@empty')->setName('getThirdPartyServiceStatus');

    Route::get('/users/profile/subscription', 'PaymentController@subscriptionV1')->setName('usersProfileSubscription');
    
    Route::get('/content/collections/{id}/items', 'ContentController@collectionItems')->setName('getContentCollectionItems');
    Route::get('/content/{instrument}/collection/groups', 'ContentController@collectionGroups')->setName('getContentCollectionGroups');
    Route::get('/content/{instrument}/collections/my', 'ContentController@collectionMy')->setName('getContentCollectionMy');
    Route::post('/content/guitar/collections', 'ContentController@collectionAdd')->setName('postCollectionAdd');
    Route::put('/content/collections/{_id}/items', 'ContentController@collectionAddItems')->setName('putCollectionAddItems');
    Route::delete('/content/collections/{_id}/items', 'ContentController@collectionRemoveItems')->setName('deleteCollectionRemoveItems');
    Route::delete('/content/collections/{_id}', 'ContentController@collectionRemove')->setName('deleteCollectionRemove');
    Route::put('/content/collections/{_id}', 'ContentController@collectionUpdate')->setName('putCollectionUpdate');

})->add(SessionMiddleware::class);



