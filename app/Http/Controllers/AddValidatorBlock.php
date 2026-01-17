<?php

namespace App\Http\Controllers;


use App\Services\ValidatorBlockService;

class AddValidatorBlock extends Controller {
    public function handle() {
        ValidatorBlockService::createRandomBlock();
    }
}
