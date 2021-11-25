<?php

use Illuminate\Support\Facades\Route;

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

$locale = Request::segment(1);
if (in_array($locale, Config::get("app.locales"))) {
    \App::setLocale($locale);
} else {
   \App::setLocale("en");
   $locale = "en";
}

if($locale == "en")
    Route::get("/", function () { return view("welcome"); })->name("home");
else
    Route::get("/$locale", function () { return view("welcome"); })->name("home");

Route::group(["prefix" => "$locale/lang"], function() {
    Route::get("all",			"LangController@getFiles")->name("Lang.getFiles");
    Route::get("create",		"LangController@createFile")->name("Lang.createFile");
    Route::post("create",		"LangController@createFileData")->name("Lang.createFileData");
    Route::get("edit/{file}",	"LangController@editFile")->name("Lang.editFile");
    Route::post("edit",			"LangController@editFileData")->name("Lang.editFileData");
    Route::get("add/{file}",	"LangController@addKey")->name("Lang.addKey");
    Route::post("add",			"LangController@addKeyData")->name("Lang.addKeyData");
    Route::post("delete",		"LangController@deleteKey")->name("Lang.deleteKey");
});