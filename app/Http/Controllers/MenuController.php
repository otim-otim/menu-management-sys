<?php

namespace App\Http\Controllers;

use App\DTO\MenuCreateDTO;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function __construct(
        public MenuService $menuService = new MenuService()
    ){

    } 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('children')->get();
        return response()->json(MenuResource::collection($menus)  );
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parentId' => 'nullable|exists:menus,id',
        ]);

        $dto = MenuCreateDTO::fromRequest($request);

        $menu = $this->menuService->storeMenu($dto);

        // $menu = Menu::create($request->all());

        return response()->json($menu, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return response()->json(new MenuResource($menu->load('children')));
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'depth' => 'required|integer|min:1',
        ]);

        $menu->update($request->all());

        return response()->json(new MenuResource($menu));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json(null, 204);
    }
}
