@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => __('users.title'),
'activePage' => 'users',
'activeNav' => '',
])

@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <select id='status' class="form-control form-control-sm" style="width: 200px">
                                <option value="">{{ __('global.form.all') . " " . __('users.title') }}</option>
                                <option value="1">{{ __('global.form.active') . " " . __('users.title')}}</option>
                                <option value="0">{{__('global.form.inactive') . " " . __('users.title')}}</option>
                            </select>
                        </div>
                        <div class="card-tools">
                            <a href="{{route('users.create')}}" class="btn btn-block btn-primary btn-xs">{{ __('global.form.create') }}</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped users-table">
                            <thead>
                                <tr>
                                    <th>{{ __('global.name') }}</th>
                                    <th>{{ __('global.email') }}</th>
                                    <th>{{ __('global.phone') }}</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

<script type="text/javascript">
    $(function() {
        var table = $('.users-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            columnDefs: [{
                className: "dt-center",
                targets: [3, 4]
            }],
            ajax: {
                url: "{{ route('users.get') }}",
                data: function(d) {
                    d.status = $('#status').val(),
                        d.search = $('input[type="search"]').val()
                }
            },
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        $('#status').change(function() {
            table.draw();
        });
    });
</script>

@endsection