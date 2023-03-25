<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::withCount('users')->paginate(10);
        $titleTab = 'Department Page';
        $title = 'Department Settings';
        return view('department.list', compact('departments', 'title', 'titleTab'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create a new Department';
        $titleTab = 'Department Page';
        return view('department.create', compact('title', 'titleTab'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $data = $request->all();

        Department::create($data);

        return redirect()->route('department.index')->with('message', 'Department added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $titleTab = 'Department ' . $department->name;
        $title = 'List Karyawan Department ' . $department->name;
        $usersByDepartment = User::where('department_id', $department->id)->paginate(10);

        return view('department.show', compact('usersByDepartment', 'title', 'titleTab', 'department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $title = 'Department Edit';
        $titleTab = 'Department Page';
        return view('department.edit', compact('department', 'title', 'titleTab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $data = $request->all();

        $department->update($data);

        return redirect()->route('department.index')->with('message', 'Department edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('department.index')->with('message', 'Department deleted successfully!');
    }
}
