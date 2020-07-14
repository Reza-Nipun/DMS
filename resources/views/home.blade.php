@extends('layouts.app')

@section('content')
    {{--<div class="container">--}}
        <div class="container">
            <div class="form-group row">
                <div class="col-md-3">
                    <div class="form-group">

                        <label>Item Name</label>
                        <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Item Name" />

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">

                        <label>Select Unit</label>
                        <select class="form-control" name="unit" id="unit">
                            <option value="">Unit</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Select Department</label>
                        <select class="form-control" name="department" id="department">
                            <option value="">Department</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Select Service Type</label>
                        <select class="form-control" name="service_type" id="service_type">
                            <option value="">Service Type</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Renew Date From</label>
                        <input type="date" class="form-control" name="from_date" id="from_date" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Renew Date To</label>
                        <input type="date" class="form-control" name="to_date" id="to_date" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <br />
                        <button class="btn btn-primary" onclick="getFilterDocument()">SEARCH</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <table class="table table-bordered table-responsive" width="100%">
                        <thead>
                        <tr>
                            <th colspan="14"><h3>{{ __('Documents') }}</h3></th>
                            <th colspan="3">
                                <a href="{{ url('documents/create') }}" class="btn btn-success">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4a.5.5 0 0 0-1 0v3.5H4a.5.5 0 0 0 0 1h3.5V12a.5.5 0 0 0 1 0V8.5H12a.5.5 0 0 0 0-1H8.5V4z"/>
                                    </svg>
                                    CREATE
                                </a>
                            </th>
                        </tr>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Item</th>
                            <th class="text-center">Service</th>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Model</th>
                            <th class="text-center">Serial</th>
                            <th class="text-center">Unit</th>
                            <th class="text-center">Dept.</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Orig. Loc.</th>
                            <th class="text-center">Doc. Loc.</th>
                            <th class="text-center">Last Renew</th>
                            <th class="text-center">Next Renew</th>
                            <th class="text-center">Vendor</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody id="tbody_id">
                        @if(count($documents) > 0)
                            @foreach($documents as $d)
                                <tr>
                                    <td class="text-center">{{ $d->id }}</td>
                                    <td class="text-center">{{ $d->item_name }}</td>
                                    <td class="text-center">{{ $d->service_type }}</td>
                                    <td class="text-center">{{ $d->brand }}</td>
                                    <td class="text-center">{{ $d->model }}</td>
                                    <td class="text-center">{{ $d->serial_no }}</td>
                                    <td class="text-center">{{ $d->unit }}</td>
                                    <td class="text-center">{{ $d->department }}</td>
                                    <td class="text-center">{{ $d->user }}</td>
                                    <td class="text-center">{{ $d->original_placement_location }}</td>
                                    <td class="text-center">{{ $d->original_document_location }}</td>
                                    <td class="text-center">{{ $d->last_renewal_date }}</td>
                                    <td class="text-center">{{ $d->next_renewal_date }}</td>
                                    <td class="text-center">{{ $d->vendor }}</td>
                                    <td class="text-center">{{ $d->amount }}</td>
                                    <td class="text-center">{{ $d->remarks }}</td>
                                    <td class="text-center">

                                            <a style="margin: 1px;" href="{{ url("/documents/$d->id/edit") }}" class="btn btn-warning">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                            </a>


                                            @if($d->file != '')

                                                    <a style="margin: 1px;" href="{{ asset('/public/storage/attachments/').'/'.$d->file }}" class="btn btn-success" target="_blank">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8z"/>
                                                            <path fill-rule="evenodd" d="M5 7.5a.5.5 0 0 1 .707 0L8 9.793 10.293 7.5a.5.5 0 1 1 .707.707l-2.646 2.647a.5.5 0 0 1-.708 0L5 8.207A.5.5 0 0 1 5 7.5z"/>
                                                            <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 1z"/>
                                                        </svg>
                                                    </a>

                                            @endif

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="17" class="text-center">No Documents Found!</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="row justify-content-center">{{ $documents->links() }}</div>
                </div>
            </div>
        </div>
    {{--</div>--}}
@endsection

<script type="text/javascript">
    function getFilterDocument() {
        var item_name = $("#item_name").val();
        var unit = $("#unit").val();
        var department = $("#department").val();
        var service_type = $("#service_type").val();
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();


    }
</script>