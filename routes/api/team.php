<?php
Route::group(['prefix' => 'teams', 'namespace' => "Team", 'middleware' => ["auth:api"]], function () {
    Route::post('/', ['as' => "create-team", 'uses' => "CreateTeam"]);
    Route::get('/', ['as' => "list-teams", 'uses' => "ListTeams"]);
    Route::get('/{slug}', ['as' => "show-team", 'uses' => "ShowTeam"]);
    Route::patch('/{slug}', ['as' => "update-team", 'uses' => "UpdateTeam"]);
    Route::delete('/{slug}', ['as' => "delete-team", 'uses' => "DeleteTeam"]);

    Route::group(['prefix' => '/{slug}/members', 'namespace' => "Member"], function () {
        Route::get('/', ['as' => "list-team-members", 'uses' => "ListTeamMembers"]);
        Route::post('/', ['as' => "add-team-member", 'uses' => "AddTeamMember"]);
        Route::get('/{id}', ['as' => "show-team-member", 'uses' => "ShowTeamMember"]);
        Route::delete('/{id}', ['as' => "remove-team-member", 'uses' => "RemoveTeamMember"]);
    });

    Route::group(['prefix' => '/{slug}/channels', 'namespace' => "Channel"], function () {
        Route::get('/', ['as' => "list-team-channels", 'uses' => "ListTeamChannels"]);
        Route::post('/', ['as' => "create-team-channel", 'uses' => "CreateTeamChannel"]);
        Route::get('/{chSlug}', ['as' => "show-team-channel", 'uses' => "ShowTeamChannel"]);
        Route::patch('/{chSlug}', ['as' => "update-team-channel", 'uses' => "UpdateTeamChannel"]);
        Route::delete('/{chSlug}', ['as' => "delete-team-channel", 'uses' => "DeleteTeamChannel"]);

        Route::group(['prefix' => '/{chSlug}/members', 'namespace' => "Member"], function () {
            Route::post('/', ['as' => "add-channel-member", 'uses' => "AddChannelMember"]);
            Route::get('/', ['as' => "list-channel-members", 'uses' => "ListChannelMembers"]);
            Route::get('/{id}', ['as' => "show-channel-member", 'uses' => "ShowChannelMember"]);
            Route::delete('/{id}', ['as' => "remove-channel-member", 'uses' => "RemoveChannelMember"]);
        });

        Route::group(['prefix' => '/{chSlug}/threads', 'namespace' => "Thread"], function () {
            Route::post('/', ['as' => "add-channel-thread", 'uses' => "CreateChannelThread"]);
            Route::get('/', ['as' => "list-channel-threads", 'uses' => "ListChannelThreads"]);
            Route::get('/{thSlug}', ['as' => "show-channel-thread", 'uses' => "ShowChannelThread"]);
            Route::patch('/{thSlug}', ['as' => "update-channel-thread", 'uses' => "UpdateChannelThread"]);
            Route::delete('/{thSlug}', ['as' => "remove-channel-thread", 'uses' => "DeleteChannelThread"]);

            Route::group(['prefix' => '/{thSlug}/messages', 'namespace' => "Message"], function () {
                Route::post('/', ['as' => "create-thread-message", 'uses' => "CreateThreadMessage"]);
                Route::get('/', ['as' => "list-thread-messages", 'uses' => "ListThreadMessages"]);
                Route::get('/{mSlug}', ['as' => "show-thread-message", 'uses' => "ShowThreadMessage"]);
            });
        });
    });
});
