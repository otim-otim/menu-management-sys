<?php

namespace App\Services;

use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\DTO\MenuCreateDTO;

class MenuService
{

    public function storeMenu(MenuCreateDTO $dto){
        try {
            $parent = null;
            if($dto->parent_id)
                $parent = Menu::findOrFail($dto->parent_id);
            $depth = $parent ? $parent->depth++ : 0;
            $menu = Menu::create([...$dto->toArray(),'depth' => $depth]);

            return new MenuResource($menu);

        } catch (\Throwable $th) {
            throw $th;
        }

    }
}