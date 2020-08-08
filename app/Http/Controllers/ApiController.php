<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\ServiceType;
use App\Unit;
use App\Department;
use DB;

class ApiController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function documentList(){
        $documents = DB::table('documents')
            ->leftJoin('units', 'units.id', '=', 'documents.unit_id')
            ->leftJoin('departments', 'departments.id', '=', 'documents.department_id')
            ->leftJoin('service_types', 'service_types.id', '=', 'documents.service_type_id')
            ->select('documents.*', 'units.name as unit', 'departments.name as department', 'service_types.name as service_type')
            ->paginate(10);

        return response($documents, 200);
    }

    public function getUnits(){
        $units = Unit::all();

        return response($units, 200);
    }

}
