<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Document;
use App\ServiceType;
use App\Unit;
use App\Department;
use DB;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $user_unit = $user->unit_id;

        $documents = DB::table('documents')
                    ->leftJoin('units', 'units.id', '=', 'documents.unit_id')
                    ->leftJoin('departments', 'departments.id', '=', 'documents.department_id')
                    ->leftJoin('service_types', 'service_types.id', '=', 'documents.service_type_id')
                    ->select('documents.*', 'units.name as unit', 'departments.name as department', 'service_types.name as service_type')
                    ->paginate(10);

        return view('home')->with('documents', $documents)->with('user_unit', $user_unit);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service_types = ServiceType::all();
        $units = Unit::all();
        $departments = Department::all();

        return view('documents.create')->with('service_types', $service_types)->with('units', $units)->with('departments', $departments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'item_name' => 'required',
            'service_type_id' => 'required',
            'unit_id' => 'required',
            'department_id' => 'required',
            'user' => 'required',
            'last_renewal_date' => 'required',
            'next_renewal_date' => 'required',
            'amount' => 'required',
            'file' => 'max:2048'
        );
        $customMessages = array(
            'item_name.required' => 'Item Name is required.',
            'service_type_id.required' => 'Service Type is required.',
            'unit_id.required' => 'Unit is required.',
            'department_id.required' => 'Department is required.',
            'user.required' => 'User is required.',
            'last_renewal_date.required' => 'Last Renewal Date is required.',
            'next_renewal_date.required' => 'Next Renewal Date is required.',
            'amount.required' => 'Amount is required.',
            'file.required' => 'File size maximum 2MB is allowed.'
        );
        $this->validate($request, $rules, $customMessages);

        if($request->hasFile('file')){
            // Get File Name With The Extension
            $fileNameWithExt = $request->file('file')->getClientOriginalName();

            // Get just File Name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just File Extension
            $extension = $request->file('file')->getClientOriginalExtension();
            // Filename to Store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            $path = $request->file('file')->storeAs('public/attachments', $fileNameToStore);

        } else {
            $fileNameToStore = '';
        }

        $documents = new Document;
        $documents->item_name = $request->input('item_name');
        $documents->service_type_id = $request->input('service_type_id');
        $documents->brand = $request->input('brand');
        $documents->model = $request->input('model');
        $documents->serial_no = $request->input('serial_no');
        $documents->unit_id = $request->input('unit_id');
        $documents->department_id = $request->input('department_id');
        $documents->user = $request->input('user');
        $documents->original_placement_location = $request->input('original_placement_location');
        $documents->original_document_location = $request->input('original_document_location');
        $documents->last_renewal_date = $request->input('last_renewal_date');
        $documents->next_renewal_date = $request->input('next_renewal_date');
        $documents->vendor = $request->input('vendor');
        $documents->amount = $request->input('amount');
        $documents->remarks = $request->input('remarks');
        $documents->file = $fileNameToStore;
        $documents->save();

        return redirect('/documents')->with('success', 'Document Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = Document::find($id);
        $service_types = ServiceType::all();
        $units = Unit::all();
        $departments = Department::all();

        return view('documents.edit')->with('document', $document)->with('service_types', $service_types)->with('units', $units)->with('departments', $departments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'item_name' => 'required',
            'service_type_id' => 'required',
            'unit_id' => 'required',
            'department_id' => 'required',
            'user' => 'required',
            'last_renewal_date' => 'required',
            'next_renewal_date' => 'required',
            'amount' => 'required',
            'file' => 'max:2048'
        );
        $customMessages = array(
            'item_name.required' => 'Item Name is required.',
            'service_type_id.required' => 'Service Type is required.',
            'unit_id.required' => 'Unit is required.',
            'department_id.required' => 'Department is required.',
            'user.required' => 'User is required.',
            'last_renewal_date.required' => 'Last Renewal Date is required.',
            'next_renewal_date.required' => 'Next Renewal Date is required.',
            'amount.required' => 'Amount is required.',
            'file.required' => 'File size maximum 2MB is allowed.'
        );
        $this->validate($request, $rules, $customMessages);

        if($request->hasFile('file')){
            // Get File Name With The Extension
            $fileNameWithExt = $request->file('file')->getClientOriginalName();

            // Get just File Name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just File Extension
            $extension = $request->file('file')->getClientOriginalExtension();
            // Filename to Store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            $path = $request->file('file')->storeAs('public/attachments', $fileNameToStore);

        }

        $documents = Document::find($id);
        $documents->item_name = $request->input('item_name');
        $documents->service_type_id = $request->input('service_type_id');
        $documents->brand = $request->input('brand');
        $documents->model = $request->input('model');
        $documents->serial_no = $request->input('serial_no');
        $documents->unit_id = $request->input('unit_id');
        $documents->department_id = $request->input('department_id');
        $documents->user = $request->input('user');
        $documents->original_placement_location = $request->input('original_placement_location');
        $documents->original_document_location = $request->input('original_document_location');
        $documents->last_renewal_date = $request->input('last_renewal_date');
        $documents->next_renewal_date = $request->input('next_renewal_date');
        $documents->vendor = $request->input('vendor');
        $documents->amount = $request->input('amount');
        $documents->remarks = $request->input('remarks');

        $previous_file = $request->input('previous_file');

        if($request->hasFile('file')){

            if($previous_file != ''){
                // Delete File
                Storage::delete('/public/attachments/'.$previous_file);
            }
            $documents->file = $fileNameToStore;
        }
        $documents->save();

        return redirect('/documents/'.$id.'/edit')->with('success', 'Document Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
