@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => __('logs.title'),
'activePage' => 'logs',
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
                        </div>
                        <div class="card-tools">
                            <a href="{{ route('logs.clear') }}" class="btn btn-danger btn-block btn-sm">
                                <i class="fa fa-trash"></i>
                                {{ __('logs.clear')  }}
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="log-table" class="table table-sm table-striped log-table">
                            <thead>
                                <tr>
                                    <th>{{ __('global.log_name') }}</th>
                                    <th>{{ __('global.event') }}</th>
                                    <th>{{ __('global.description') }}</th>
                                    <th>{{ __('global.causer_name') }}</th>
                                    <th>{{ __('global.subject') }}</th>
                                    <th>{{ __('global.created_at') }}</th>
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
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/datetime-moment.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.21/dataRender/datetime.js"></script>

<script type="text/javascript">
    $(function() {
        var table = $('.log-table').DataTable({
            order: [
                [5, 'desc']
            ],
            serverSide: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel'
            ],
            columnDefs: [{
                    className: "dt-center",
                    targets: [0, 1]
                },
                {
                    targets: 5,
                    render: $.fn.dataTable.render.moment('YYYY-MM-DDTHH:mm:ss.SSSSZ', 'YYYY/MM/DD HH:mm')
                },
            ],
            ajax: {
                url: "{{ route('logs.get') }}",
            },
            columns: [{
                data: 'log_name',
            }, {
                data: 'event',
            }, {
                data: 'description'
            }, {
                data: 'causer',
                name: 'causer.name'
            }, {
                data: 'subject_type'
            }, {
                data: 'created_at'
            }, ],
        });
        setInterval(function() {
            table.ajax.reload(null, false);
        }, 5000);
    });
</script>
@endsection