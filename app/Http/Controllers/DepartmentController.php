<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class DepartmentController extends Controller
{
    //

    public function index()
    {
        $departments = Department::all();
        $fullData = [];

        foreach ($departments as $department) {
            $data = [
                'manager' => $department->manager->user->name . ' ' . $department->manager->user->surname,
                'name' => $department->name,
                'teachers' => $department->teachers->count(),
            ];

            $fullData[] = $data;
        }
        return response()->json(['data' => $fullData]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100|unique:departments',
            'manager_id' => 'required|integer|gt:0',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        DB::beginTransaction();
        try {
            Department::create($validator->validated());
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return response(['success' => true]);
    }
}
