<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function index() {

    }

    public function page($slug = null) {
        $page = Page::where('route', $slug)->where('active', 1);
        $page = $page->firstOrFail();
        return view('templates/' . $page->template . '/index')->with('content', $page->content);
    }

    public function add(Request $request) {
        $page = new Page;
        $page->template = 'default';
        $page->route = $request->name;
        $page->fill($request->only('name', 'parent_page', 'content', 'active'));
        $page->save();
        return $this->createResponse($page->route, Response::HTTP_OK);
    }
}
