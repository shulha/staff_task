<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Search Employee by name or patronymic or surname
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchEmployee(Request $request)
    {
        if ($request->isMethod('get')){

            $searchString = $request->input('input');
            if(empty($searchString))
                return response()->json(['success' => false], 400);

            $result = Employee::search($searchString);

            return response()->json(['success' => true, 'result' => $result], 200);
        }

        return response()->json(['success' => false], 405);
    }
}
