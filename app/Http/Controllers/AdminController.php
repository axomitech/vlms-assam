<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminModel;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDepartment;
use Auth;

use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function show_user()
    {
        $currentDept = session('role_dept');

        $currentRole = session('role');

        // Fetch the department users only
        $resultDept = AdminModel::get_all_dept_user($currentDept);
    
        // Fetch all users
        $resultsAll = AdminModel::get_all_user_details();

        $results = ($currentRole == 4)
        ? $resultDept
        : $resultsAll;

        // Fetch all departments
        $departments = Department::getAllDepartments();

        // Fetch departments that do not have a departmental admin
        $departmentsWithoutAdmin = Department::getDepartmentsWithoutAdmin();

        // Fetch all roles
        $roles = Role::getAllRoles();

        // Fetch roles available for super admins - DEPARTMENTAL ADMIN
        $superAdminRoles = Role::getSuperAdminRoles();

        // Based on the current role, fetch departmental admin roles or super admin roles
        $rolesForAdmins = ($currentRole == 4)
            ? Role::getDepartmentalAdminRoles()
            : $superAdminRoles;

        return view('admin.user', compact(
            'results',
            'departments',
            'roles',
            'superAdminRoles',
            'departmentsWithoutAdmin',
            'rolesForAdmins'
        ));
    }


    public function add_user(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'u_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:60|unique:users',
            'dept_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Use a database transaction to ensure data integrity
        FacadesDB::beginTransaction();

        try {
            // Create the user
            $user = User::create([
                'name' => $request->u_name,
                'email' => $request->email,
                'password' => Hash::make('password'),
            ]);

            // Associate the user with the department and role
            UserDepartment::create([
                'user_id' => $user->id,
                'department_id' => $request->dept_id,
                'role_id' => $request->role_id,
                'default_access' => true
            ]);

            // Commit the transaction
            FacadesDB::commit();

            return back()->with('success', 'User added successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            FacadesDB::rollBack();

            // Log the error or handle it as needed
            Log::error('Failed to add user: ' . $e->getMessage());

            return back()->with('error', 'Failed to add user. Please try again.');
        }
    }

    public function edit_user(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'u_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'dept_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Begin a database transaction
        FacadesDB::beginTransaction();
        try {
            // Find and update the user
            $user = User::findOrFail($request->user_id);
            $user->name = $request->u_name;
            $user->email = $request->email;
            $user->save();

            // Update user's department and role
            $userDepartment = UserDepartment::where('user_id', $user->id)->first();

            if ($userDepartment) {
                $userDepartment->department_id = $request->dept_id;
                $userDepartment->role_id = $request->role_id;
                $userDepartment->save();
            } else {
                // This block is for sanity check; ideally, the record should exist
                UserDepartment::create([
                    'user_id' => $user->id,
                    'department_id' => $request->dept_id,
                    'role_id' => $request->role_id
                ]);
            }

            // Commit the transaction
            FacadesDB::commit();

            return back()->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            FacadesDB::rollBack();

            // Log the error or handle it as needed
            Log::error('Failed to update user: ' . $e->getMessage());

            return back()->with('error', 'Failed to update user. Please try again.');
        }
    }

    public function default_access(Request $request)
    {
        $userDepartment = UserDepartment::where([
            ['user_id', $request->user_id],
            ['department_id', $request->department_id],
            ['role_id', $request->role_id],
        ])->first();

        if ($userDepartment) {
            $userDepartment->default_access = $request->default_access;
            $userDepartment->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function show_department(Request $request)
    {
        $departments = Department::getAllDepartmentsWithAbbreviation();
        // return $departments;
        return view('admin.department', compact('departments'));
    }

    public function add_department(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'dept_name' => 'required|string|max:255|unique:departments,department_name',
            'dept_abbr' => 'required|string|max:10|unique:departments,abbreviation'
        ]);

        // Create and save the department
        $department = new Department();
        $department->department_name = $validatedData['dept_name'];
        $department->abbreviation = $validatedData['dept_abbr'];
        $department->save();

        // Return a success response
        return back()->with('success', 'Department added successfully.');
    }

    public function edit_department(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'dept_id' => 'required|exists:departments,id',
            'dept_name' => 'required|string|max:255',
            'dept_abbr' => 'nullable|string|max:10',
        ]);

        // Find the department by ID
        $department = Department::find($validatedData['dept_id']);

        // Update the department details
        $department->department_name = $validatedData['dept_name'];
        $department->abbreviation = $validatedData['dept_abbr'];
        $department->save();

        // Return a response, e.g., redirect back with a success message
        return redirect()->back()->with('success', 'Department updated successfully!');
    }
}
