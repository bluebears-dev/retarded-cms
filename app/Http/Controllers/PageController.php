<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function fetch($slug = null) {
        $page = Page::where('route', $slug)->where('active', 1);
        $page = $page->firstOrFail();
        return view('templates/' . $page->template . '/index')->with('content', $page->content);
    }

    public function store(Request $request) {
        $page = new Page;
        $page->template = 'default';
        $page->route = $request->name;
        $page->parent_page = $request->parent_page == null ? '' : $request->parent_page;
        $page->fill($request->only('name', 'content', 'active'));
        $page->save();
        // TODO: implement validation
        return $this->createResponse($page->route, Response::HTTP_OK);
    }

    public function index(Request $request) {
        $pages = Page::all('name', 'parent_page', 'active', 'template', 'route');
        return $this->createResponse($pages, Response::HTTP_OK);
    }

    public function show(Request $request, $user)
    {

    }

    public function update(Request $request, $user)
    {
//        if (Auth::user()->can('edit users')) {
//            $user = User::find($user);
//            if ($user)
//                $user->syncRoles($request->only('role'));
//        }
    }

    public function destroy(Request $request, $user)
    {
//        if (Auth::user()->can('delete users')) {
//            $user = User::find($user);
//            $response_data = null;
//            if ($user) {
//                $response_data = $user->id;
//                if (Auth::user()->id == $user->id) {
//                    LoginController::logout($request);
//
//                    $response_data = ['redirect' => route('dashboard')];
//                }
//                $user->delete();
//                $this->changed = true;
//            }
//            return $this->createResponse($response_data, Response::HTTP_OK);
//        }
//        return $this->createResponse('', Response::HTTP_FORBIDDEN);
    }
}
