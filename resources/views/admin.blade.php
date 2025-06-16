@extends('layout')
@section('title', 'Admin | Dashboard')
@section('main_container')
    <style>
        body {
            width: 100%;
            overflow-x: hidden;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <h3 class="text-center">User Data</h3>
    <table id="users_table" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>access</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>access</th>
            </tr>
        </tfoot>
    </table>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            $('#users_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin/userData')}}',
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'access' }
                ],
                initComplete: function () {
                    var api = this.api();
                    api.columns().every(function (index) {
                        var column = this;
                        var title = $(column.footer()).text();
                        var storageKey = "footerSearch_" + index;

                        var input = $('<input type="text" placeholder="🔍 ' + title + '" />')
                            .appendTo($(column.footer()).empty())
                            .css({
                                width: "90%",
                                padding: "3px",
                                "box-sizing": "border-box",
                                "font-size": "13px"
                            });
                        var saved = localStorage.getItem(storageKey);
                        if (saved) {
                            input.val(saved);
                            column.search(saved).draw();
                        }
                        input.on('keyup change clear', function () {
                            var value = this.value;
                            localStorage.setItem(storageKey, value);
                            column.search(value).draw();
                        });
                    });
                }
            });
        });
    </script>
@endsection