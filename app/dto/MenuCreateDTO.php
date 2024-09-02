<?php

namespace App\DTO;

use Illuminate\Http\Request;

class MenuCreateDTO
{
    public string $name;
    public ?int $parent_id = null;
    

    public function __construct(string $name, ?int $parent_id)
    {
        $this->name = $name;
        $this->parent_id = $parent_id;
        
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('parentId'),
            
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            
        ];
    }
}