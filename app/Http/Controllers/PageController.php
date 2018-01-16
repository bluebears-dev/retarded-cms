<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Page;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    private $rules = null;

    public function __construct(Guard $auth)
    {
        $this->rules = [
            'name' => 'required:pages.name|unique:pages',
            'published' => 'required:pages.published|boolean',
            'parent_page' => 'required:pages.parent_page|string|exists:pages,name'
        ];
    }

    public function getPage(Request $request, $name) {
        $page = Page::where('name', $name);
        $page = $page->firstOrFail();
        return $this->createResponse([
            'page' => $page
        ], Response::HTTP_OK);
    }

    private function buildPageRoute(String $name, String $parent_name) {
        if ($parent_name !== 'home' && $parent_name !== '') {
            $parent = Page::where('name', $parent_name)->first();
            if ($parent->route)
                return $parent->route . '/' . $name;
        }
        return $name;
    }

    public function fetch($slug = null)
    {
        $page = Page::where('route', $slug)->where('published', 1);
        $page = $page->firstOrFail();
        return view('templates/' . $page->template . '/index')->with('content', $page->content);
    }

    public function home()
    {
        $page = Page::where('route', '/');
        $page = $page->firstOrFail();
        return view('templates/' . $page->template . '/index')->with('content', $page->content);
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create websites')) {
            $validator = Validator::make($request->only('name', 'parent_page', 'published'), $this->rules);

            if ($validator->fails())
                return $this->createResponse($validator->messages(), Response::HTTP_BAD_REQUEST);

            $page = new Page;
            $page->template = 'default';
            $page->route = $this->buildPageRoute($request->name, $request->parent_page);
            $page->parent_page = $request->parent_page == 'home' ? '' : $request->parent_page;
            $page->fill($request->only('name', 'content', 'published'));
            $page->save();
            return $this->createResponse([
                'route' => $page->route
            ], Response::HTTP_OK);
        }
        return $this->createResponse('', Response::HTTP_FORBIDDEN);
    }

    private function updateMenuEntries($old, $new) {
        $menu = Menu::where('page', $old)->get();
        foreach ($menu as $entry) {
            $entry->page = $new;
            $entry->save();
        }
    }

    public function update(Request $request, $page) {
        if (Auth::user()->can('edit websites')) {
            $validator = Validator::make($request->only('name', 'parent_page', 'published'), $this->rules);

            if ($validator->fails() &&
                in_array("The name has already been taken.", $validator->messages()->get('name'), true) &&
                $page !== $request->name)
                    return $this->createResponse($validator->messages(), Response::HTTP_BAD_REQUEST);

            $current_page = Page::where('name', $page);
            $current_page = $current_page->firstOrFail();
            $current_page->route = $this->buildPageRoute($request->name, $request->parent_page);
            $current_page->parent_page = $request->parent_page == 'home' ? '' : $request->parent_page;
            $current_page->fill($request->only('name', 'content', 'published'));
            $current_page->save();

            $this->updateMenuEntries($page, $request->name);
            return $this->createResponse([
                'route' => $current_page->route
            ], Response::HTTP_OK);
        }
        return $this->createResponse('', Response::HTTP_FORBIDDEN);
    }

    public function index(Request $request)
    {
        $pages = Page::all('name', 'parent_page', 'published', 'template', 'route');
        return $this->createResponse([
            'pages' => $pages
        ], Response::HTTP_OK);
    }

    public function toggleState(Request $request, $name) {
        $page = Page::where('name', $name)->firstOrFail();
        $user = Auth::user();

        if (($page->published && $user->can('unpublish websites')) || (!$page->published && $user->can('publish websites'))) {
            $page->published = !$page->published;
            $page->save();

            return $this->createResponse([
                'published' => $page->published,
                'condition' => ($page->published && $user->can('unpublish websites')) || (!$page->published && $user->can('publish websites'))
            ], Response::HTTP_OK);
        }

        return $this->createResponse([
            'message' => 'You are not allowed to toggle visibility of page.'
        ], Response::HTTP_FORBIDDEN);
    }

    public function destroy(Request $request, $page)
    {
        if (Auth::user()->can('delete websites')) {
            $page = Page::where('name', $page)->firstOrFail();
            if ($page)
                $page->delete();
            return $this->createResponse([
                'name' => $page->name
            ], Response::HTTP_OK);
        }
        return $this->createResponse([
            'message' => 'You are not allowed to delete page.'
        ], Response::HTTP_FORBIDDEN);
    }
}
