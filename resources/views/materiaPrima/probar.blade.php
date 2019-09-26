<!DOCTYPE html>

<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel DataTable With Custom Filter - Tuts Make</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Laravel DataTable With Custom Filter - Tuts Make</h2>
        <br>
        <div class="row">
            <div class="form-group col-md-6">
                <h5>Start Date <span class="text-danger"></span></h5>
                <div class="controls">
                    <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> <div class="help-block"></div></div>
                </div>
                <div class="form-group col-md-6">
                    <h5>End Date <span class="text-danger"></span></h5>
                    <div class="controls">
                        <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> <div class="help-block"></div></div>
                    </div>
                    <div class="text-left" style="
                    margin-left: 15px;
                    ">
                    <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                </div>
            </div>
            <br>
            <table class="table table-bordered" id="laravel_datatable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created at</th>
                    </tr>
                </thead>
            </table>
        </div>
        <script>
            $(document).ready( function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#laravel_datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('users-list') }}",
                        type: 'GET',
                        data: function (d) {
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        }
                    },
                    columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' }
                    ]
                });
            });
            
            $('#btnFiterSubmitSearch').click(function(){
                $('#laravel_datatable').DataTable().draw(true);
            });
        </script>
    </body>
    </html>