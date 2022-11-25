<?php

namespace Tests\Unit;

use App\Models\UserCategory;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCategoryTest extends TestCase
{

    /**
     * Test de la fonction role.
     *
     * @return void
     */
    public function testGetRole ()
    {
        /** UserCategory $category */
        $category = UserCategory::query()->find(1);
        $role = $category->role;
//        dd($role);
        $this->assertSame($role->name, 'SA');
    }
}
