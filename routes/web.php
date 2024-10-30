// ... existing routes ...

Route::middleware(['auth'])->group(function () {
    // ... existing routes ...

    // API Documentation
    Route::get('/api-docs', function () {
        return view('api-docs');
    })->name('api-docs');
});