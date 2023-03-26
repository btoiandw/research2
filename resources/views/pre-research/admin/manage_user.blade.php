@extends('layouts.admin.admin')
@section('content')
    <div class="d-flex justify-content-between">
        <h3>จัดการแอดมิน</h3>
        <div class=" d-flex g-2 justify-content-end ">
            <button class="btn btn-primary" type="button" onclick="addAdmin()">
                <i class="fa-solid fa-plus"></i> เพิ่มแอดมิน
            </button>
        </div>
    </div>
    <div class="row mb-3 mt-3">
        <div class="col-xl-12">
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <div class="table-responsive pt-3">
                    <table class="table fw-bold w-100" id="admin_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr align="center">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อ-สกุล</th>
                                <th class="fw-bolder" style="font-size: 15px">สถานะ</th>
                                <th class="fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_u as $item)
                                <tr>
                                    <td align="center">{{ $i++ }}</td>
                                    <td>{{ $item->pname }} {{ $item->full_name_th }}</td>
                                    <td align="center">
                                        @if ($item->status_workadmin == 1)
                                            <button class="btn btn-success btn-sm disabled">ACTIVE</button>
                                        @else
                                        @endif
                                    </td>
                                    <td align="center">
                                        <!--button class="btn btn-sm btn-yellow">แก้ไข</button-->
                                        <button class="btn btn-sm btn-danger"
                                            onclick="cancelStatus({{ $item->employee_id }})">
                                            ยกเลิก
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--  <div class="row mb-3 mt-3">
        <div class="col-xl-12">
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <h3>จัดการผู้ทรงคุณวุฒิ</h3>
                <div class="table-responsive">
                    <table class="table fw-bold w-100" id="director_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr align="center">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อ-สกุล</th>
                                <th class="fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_d as $items)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $items->full_name_th }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-yellow">แก้ไข</button>
                                        <button class="btn btn-sm btn-danger">
                                            ยกเลิก
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    --}}

    <!--Add Admin Modal -->
    <div class="modal fade" id="addAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addAdminLabel">เพิ่มแอดมิน</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row mb-3">
                        <strong class="col-sm-3">เลขบัตรประชาชน</strong>
                        <div class="col-sm-6">
                            <input type="text" class=" form-control" name="id_card" id="id_card" />
                        </div>
                        <div class="col-1 me-2"onclick="search_users()">
                            <i class="fa-solid fa-magnifying-glass-plus" style="font-size: 18px;color:black"></i>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-sm-3">ชื่อ-นามสกุล</strong>
                        <div class="col-sm-9">
                            <input type="text" id="fullname" name="fullname" value=""
                                class="form-control disabled" readonly />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong class="col-sm-3">username</strong>
                        <div class="col-sm-9">
                            <input type="text" id="username" name="username" value=""
                                class="form-control disabled" readonly />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="save_admin()">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $(document).ready(function() {
            $('#admin_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,

                language: {
                    lengthMenu: "แสดง _MENU_ รายการ",
                    search: "ค้นหาข้อมูลในตาราง",
                    info: "แสดงข้อมูล _END_ จากทั้งหมด _TOTAL_ รายการ",
                    paginate: {
                        previous: "ก่อนหน้า",
                        next: "ถัดไป",

                    },
                },

            });

            /* $('#director_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,

                language: {
                    lengthMenu: "แสดง _MENU_ รายการ",
                    search: "ค้นหาข้อมูลในตาราง",
                    info: "แสดงข้อมูล _END_ จากทั้งหมด _TOTAL_ รายการ",
                    paginate: {
                        previous: "ก่อนหน้า",
                        next: "ถัดไป",

                    },
                },

            }); */
        })

        function addAdmin() {
            $('#addAdmin').modal('toggle');
        }

        function cancelStatus(id) {
            //console.log(id);
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/admin/cancel/' + id,
                success: function(res) {
                    console.log(res.data);
                    var data = res.data[0];
                    Swal.fire({
                        //title: 'Are you sure?',
                        html: "<h3 class='form-control-plaintext'>คุณต้องการยกเลิกการเป็นแอดมินของผู้ใช้ : " +
                            data.full_name_th + "</h3>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'GET',
                                dataType: 'JSON',
                                url: '/admin/cancel/admin/' + id,
                                success: function(response) {
                                    if (response.status == true) {
                                        console.log('success');

                                        Swal.fire({
                                            icon: 'success',
                                            // title: 'Oops...',
                                            text: 'ยกเลิกการเป็นแอดมินสำเร็จ',
                                            //footer: '<a href="">Why do I have this issue?</a>'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                    } else {
                                        console.log(id);
                                        console.log(response);
                                    }
                                }
                            })
                        }
                    })
                }
            })
        }

        function search_users() {
            var id_card = $('#id_card').val();
            //console.log(id_card);
            $.ajax({
                method: 'POST',
                dataType: 'JSON',
                url: '/admin/search',
                data: {
                    id_card: id_card
                },
                success: function(res) {
                    var data = res.data[0];
                    $('#username').val(data.username);
                    $('#fullname').val(data.full_name_th);
                }
            })
        }

        function save_admin() {
            var id_card = $('#id_card').val();
            $.ajax({
                method: 'POST',
                dataType: 'JSON',
                url: '/admin/store',
                data: {
                    id_card: id_card
                },
                success: function(res) {
                    if (res.status == true) {
                        console.log('success');

                        Swal.fire({
                            icon: 'success',
                            // title: 'Oops...',
                            text: 'เพิ่มแอดมินสำเร็จ',
                            //footer: '<a href="">Why do I have this issue?</a>'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    } else {

                        console.log(res);
                    }
                }
            })
        }
    </script>
@endpush
