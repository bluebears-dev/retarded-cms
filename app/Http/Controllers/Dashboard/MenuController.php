<?php

namespace App\Http\Controllers\Dashboard;

use App\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    private $rules = null;

    public function __construct(Guard $auth)
    {
        $this->rules = [
            'entry' => 'required:menus.entry',
            'page' => 'required:menus.page|string|exists:pages,name',
        ];
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only('entry', 'page'), $this->rules);

        if ($validator->fails())
            return $this->createResponse($validator->messages(), Response::HTTP_BAD_REQUEST);

        $menu = new Menu;
        $menu->fill($request->only('entry', 'page'));
        $menu->save();

        return $this->createResponse([], Response::HTTP_OK);
    }

    public function index(Request $request)
    {
        $menu = Menu::all('id', 'entry', 'page');
        return $this->createResponse([
            'menu' => $menu
        ], Response::HTTP_OK);
    }

    public function destroy(Request $request, $menu)
    {
        $menu = Menu::where('id', $menu)->firstOrFail();
        if ($menu)
            $menu->delete();
        return $this->createResponse([
            'id' => $menu->id
        ], Response::HTTP_OK);
    }

}


