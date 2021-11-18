<?php

namespace App\Http\Controllers;

use App\Models\Advisor;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class AdvisorController extends Controller
{
    //

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'surname' => 'required|string|between:2,100',
            'patronymic' => 'nullable|string|between:2,100',
            'phone' => 'required|integer',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        DB::beginTransaction();
        try {
            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)]
            ));

            Teacher::create([
                'user_id' => $user->id,
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return response()->json([
            'message' => 'Teacher successfully registered',
            'user' => $user
        ], 201);
    }

    public function getTeacher($id)
    {
        $teacher = Teacher::where('id', $id)->firstOrFail();

        return response()->json([
            'teacher' => array_merge($teacher->user->toArray(), ['teacher_id' => $teacher->id])
        ]);
    }
}
