<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:'.Permission::ViewPermissionsMatrix->value);
    }

    public function index()
    {
        $roles = UserRole::cases();
        $permissions = Permission::cases();
        $matrix = config('permissions');

        return view('admin.permissions.index', compact('roles', 'permissions', 'matrix'));
    }
}
