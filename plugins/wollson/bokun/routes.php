<?php
use Wollson\Bokun\Components\BokunCmp;

Route::get('/api/paypal', function () {
    $tours = new BokunCmp;
    $tours->payNow();
});

Route::get('/api/testmail', function () {
    $test = new BokunCmp;
    $test->testEmail();
});
?>