<?php

namespace App\Http\Controllers\Admin\Department;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        
        $request->validated();

        $getrequest = $request->all();

        $department = new Department();
        $department->name = $getrequest['name'];
        $department->address = $getrequest['address'];
        $department->save();

        return redirect('admin/departments')->with('flash_message', 'Отделение добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $getdepartment = Department::findOrFail($department->id);

        return view('admin.departments.show', compact('getdepartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $getdepartment = Department::findOrFail($department->id);
        return view('admin.departments.edit', compact('getdepartment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $request->validated();

        $getrequest = $request->all();

        $getdepartment = Department::findOrFail($department->id);
        $getdepartment->name = $getrequest['name'];
        $getdepartment->address = $getrequest['address'];
        $getdepartment->update();

        return redirect('/admin/departments')->with('flash_message', 'Отделение обновлена');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $getdepartment = Department::findOrFail($department->id);
        $getdepartment->delete();

        return redirect('admin/departments')->with('flash_message', 'Отделение удалена');

    }
}
