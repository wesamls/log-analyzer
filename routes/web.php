<?php

use App\Http\Controllers\WebhookController;
use App\Livewire\IssuesList;
use App\Livewire\IssueView;
use Illuminate\Support\Facades\Route;

Route::get('/', IssuesList::class)->name('issues.index');
Route::get('/issues/{id}', IssueView::class)->name('issues.show');

// Web Hooks
Route::group(['prefix' => 'hooks'], function () {
    Route::post('/email-message', WebhookController::class);
});
