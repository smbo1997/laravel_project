<?php

namespace App;

use Illuminate\Http\Request;
use App;

class Languages{

    public $language = '';
    public $currentPageUrl = '';
    public function __construct() {
        $language = request()->segment(1);
        $this->language = $language;
        return App::setLocale($language);
    }
}