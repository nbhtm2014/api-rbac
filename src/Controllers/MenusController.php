<?php

namespace  Szkj\Rbac\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Szkj\Rbac\Models\Menu;

class MenusController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data = Menu::query()
            ->where('pid', 0)
            ->with('children')
            ->get();

        return response()->json($data);
    }

}
