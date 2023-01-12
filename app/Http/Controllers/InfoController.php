<?php

namespace App\Http\Controllers;

use App\Http\Requests\TitleRequest;

use App\Service\Fivegear;

class InfoController extends Controller
{
    public function __invoke(TitleRequest $request)
    {
        $data=$request->validated();
        $title=mb_strtolower($data['title']);
        $parser=new Fivegear();
        $info=$parser->get($title);
        return $info;

    }
}
