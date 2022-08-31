@extends('layouts.app')

@section('content')
    <div class="container-fluid content">
        <div class="mb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUserModal">
                Add User
            </button>
        </div>
        <table class=" table table-striped " id="report" >
            <thead class="table table-hover tab text-nowrap">

            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </table>
    </div>

    {{--modal--}}
    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" id="userForm" name="userForm">
                @csrf
                <input type="hidden" name="user_id" id="user_id">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveBtn">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        /*get user data*/
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


        /*add user data*/
        $('#saveBtn').click(function (e) {
          e.preventDefault();
          $(this).html('Saving..');

          $.ajax({
              data: $('#userForm').serialize(),
              url: "{{ route('store') }}",
              type: "POST",
              datatype: 'json',
              success:function (data) {
                  if(data.code === 0){

                  }else{
                      $('#userForm').trigger('reset');
                      $('#addUserModal').modal('hide');
                      $('.modal-backdrop').remove();
                      // ===================================
                      $('#report').DataTable().ajax.reload(null, false);
                      $('#report').parents('div.dataTables_wrapper').first().show();
                  }
              }
          });
        });





    </script>
@endpush
