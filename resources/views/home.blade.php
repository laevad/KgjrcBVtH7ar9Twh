@extends('layouts.app')

@section('content')
    <div class="container-fluid content">
        <div class="mb-2">
            <button type="button" class="btn btn-success">Success</button>
        </div>
        <table class=" table table-striped " id="report" >
            <thead class="table table-hover tab text-nowrap">

            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </table>
    </div>
@endsection

@push('js')
    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        let  table = $('#report').DataTable({
            destroy: true,
            retrieve:true,
            processing:false,
            "autoWidth": true,
            "responsive": true,
            info:true,
            searching:true,
            serverSide: true,
            ajax:"{{ route('home') }}",
            dom: 'flBrtip',
            buttons: [
                'print',
                'excel',
                'csv',
                'pdf'
            ],
            paging: true,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex', orderable:true, searchable:true},
                {data:'name', name:'name'},
                {data:'email', name:'email'},
                {data:'action', name:'action'},

            ]
        });

        table.buttons().container()
            .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );


    </script>
@endpush
