<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $students = Student::active()->get();
        if ($request->has('group')) {
            $group = $request->group;
            $groupId = Group::select('id')->where('name', $group)->get()[0]->id;
            $students = Student::active()->where('group_id', $groupId)->get();
        }

        $fullData = [];

        foreach ($students as $student)
        {
            $data = [
                'name' => $student->user->name,
                'surname' => $student->user->surname,
                'iin' => $student->iin,
                'gpa' => $student->gpa,
                'group' => $student->group->name,
            ];

            $fullData[] = $data;
        }


        return response()->json(['data' => array_slice($fullData, $request->from ?? 0, $request->to ?? 10), 'total' => count($fullData)]);
    }

    public function create(StoreStudentRequest $request): JsonResponse
    {
        $msg = "ok";
        DB::beginTransaction();
        try {

            $user = User::create(
                array_merge(['password' => bcrypt($request->password)],
                    $request->safe()->except('iin', 'gpa', 'parent_phone', 'group_id', 'password')));

            Student::create(
                array_merge($request->safe()->only('iin', 'gpa', 'parent_phone', 'group_id'),
                    ['user_id' => $user->id,
                        'is_active' => true]));

            DB::commit();
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            DB::rollBack();
        }

        return response()->json(['success' => $msg], 201);
    }
}
