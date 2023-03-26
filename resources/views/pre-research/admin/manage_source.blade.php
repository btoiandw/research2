@extends('layouts.admin.admin')
@section('content')
    @if ($message = Session::get('edit_success'))
        <script>
            Swal.fire(
                'แก้ไขข้อมูลแหล่งทุนสำเร็จ!',
                'success'
            )
        </script>
    @endif

    @if ($errors->any())
        <!-- ตรวจสอบว่ามี Error ของ validation ขึ้นมาหรือเปล่า -->

        <div class="alert alert-danger" id="ERROR_COPY" style="display:none;">
            <ul style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <!-- ทำการ วน Loop เพื่อแสดง Error ของ validation ขึ้นมาทั้งหมด -->
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <!-- ref - https://laravel.com/docs/7.x/validation#DisplayingTheValidationErrors  -->
    @endif
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary me-md-2" type="button" onclick="AddSource()">เพิ่มแหล่งทุน</button>
    </div>
    <div class="row mb-3 mt-3">
        <div class="col-xl-12">
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <div class="table-responsive pt-3">
                    <table class="table fw-bold w-100" id="admin_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr class=" align-middle">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อแหล่งทุนงานวิจัย</th>
                                <th class=" fw-bolder" style="font-size: 15px">ประเภทแหล่งทุน</th>
                                <th class=" fw-bolder" style="font-size: 15px">ปี</th>
                                <th class=" fw-bolder" style="font-size: 15px">ตัวอย่างโครงร่างงานวิจัย</th>
                                <th class=" fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_s as $item)
                                <tr>
                                    <td align="center">{{ $i++ }}</td>
                                    <td>{{ $item->full_name_source }}</td>
                                    <td align="center">{{ $item->type_research_source }}</td>
                                    <td align="center">
                                        {{ $item->Year_source }}
                                    </td>
                                    <td align="center">
                                        <button type="button" class="btn btn-info btn-sm"
                                            onclick="viewFile({{ $item->research_sources_id }})">
                                            {{ $item->ex_research }}
                                        </button>
                                    </td>
                                    <td align="center">
                                        <div class="d-grid gap-2 d-md-flex">
                                            <button class="btn btn-yellow me-md-2 btn-sm" type="button"
                                                onclick="editSo({{ $item->research_sources_id }})">แก้ไข</button>
                                            <button class="btn btn-danger btn-sm" type="button"
                                                onclick="cancelSource({{ $item->research_sources_id }})">ยกเลิก</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Source Modal -->
    <div class="modal fade" id="addSource" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addSourceLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addSourceLabel">เพิ่มแหล่งทุน</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.source-store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <strong class="col-3">ประจำปี</strong>
                            <div class="col-9">
                                <input type="text" name="ye" id="ye" class=" form-control"
                                    value="{{ date('Y') + 544 }}" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-3">ชื่อแหล่งทุน(แบบย่อ)</strong>
                            <div class="col-9">
                                <input type="text" name="name_so" placeholder="สก.สว." id="name_so"
                                    class=" form-control" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-3">ชื่อแหล่งทุน</strong>
                            <div class="col-9">
                                <input type="text" name="name_so" placeholder="สำนักงานคณะกรรมการส่งเสริมวิทยาศาสตร์ วิจัยและนวัตกรรม (สก.สว.)" id="name_so"
                                    class=" form-control" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-form-label col-sm-3 pt-0">ประเภทแหล่งทุน</strong>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type"
                                        value="ภายนอก">
                                    <label class="form-check-label" for="type">
                                        ภายนอก
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type"
                                        value="ภายใน">
                                    <label class="form-check-label" for="gridRadios2">
                                        ภายใน
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <strong class="col-sm-3 col-form-label" align="right">ไฟล์ตัวอย่างโครงร่างงาน</strong>
                            <div class=" col-sm-9">
                                <input type="file" name="file" id="file" class=" form-control" required>
                                <span class="text-danger">*ไฟล์ .pdf และ .docx เท่านั้น</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- edit Source Modal -->
    <div class="modal fade" id="editSource" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editSourceLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editSourceLabel">แก้ไขแหล่งทุน</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.edit-source') }}" method="post" id="editSo"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row mb-3">
                            <strong class="col-3">ประจำปี</strong>
                            <div class="col-9">
                                <input type="text" name="ye" id="y" class=" form-control" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-3">ชื่อแหล่งทุน</strong>
                            <div class="col-9">
                                <input type="text" name="name_so" id="name" class=" form-control" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-form-label col-sm-3 pt-0">ประเภทแหล่งทุน</strong>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type_out"
                                        value="ภายนอก">
                                    <label class="form-check-label" for="type">
                                        ภายนอก
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type_in"
                                        value="ภายใน">
                                    <label class="form-check-label" for="gridRadios2">
                                        ภายใน
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <strong class="col-sm-3 col-form-label" align="right">ไฟล์ตัวอย่างโครงร่างงาน</strong>
                            <div class=" col-sm-9">
                                <input type="file" name="file" id="file_e" class=" form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                    </div>
                </form>


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
        var has_error = {{ $errors->count() > 0 ? 'true' : 'false' }};
        if (has_error) {
            Swal.fire({
                title: 'Error',
                icon: 'error',
                type: 'error',
                html: jQuery("#ERROR_COPY").html(),
                showCloseButton: true,
            });
        }
    </script>
    <script>
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
        })

        function AddSource() {
            $('#addSource').modal('toggle');
        }

        function editSo(id) {
            //console.log(id);
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/admin/view/source/' + id,
                success: function(res) {
                    //console.log(res.data[0]);
                    var data = res.data[0];
                    console.log(data);
                    $('#editSource').modal('toggle');
                    $('#id').val(data.research_sources_id);
                    $('#y').val(data.Year_source);
                    $('#name').val(data.full_name_source);

                    if (data.type_research_source == 'ภายนอก') {
                        $('#type_out').attr('checked', true);
                        $('#type_in').attr('checked', false);
                    } else {
                        $('#type_out').attr('checked', false);
                        $('#type_in').attr('checked', true);
                    }

                    //$('#file').val(data.ex_research);
                }
            })
        }

        function cancelSource(id) {
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/admin/view/source/' + id,
                success: function(res) {
                    var data = res.data[0];
                    Swal.fire({
                        title: 'คุณต้องการยกเลิก?',
                        html: '<h3><strong>ชื่อแหล่งทุน : </strong>' + data.full_name_source +
                            '</h3>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#5e72e4',
                        cancelButtonColor: '#f5365c',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'GET',
                                dataType: 'JSON',
                                url: '/cencel/source/' + id,
                                success: function(res) {
                                    console.log(res);
                                    if (res.status == true) {
                                        Swal.fire({
                                            //title:'ยกเลิก!',
                                            title: 'ยกเลิกสำเร็จ',
                                            icon: 'success'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        })
                                    } else {
                                        Swal.fire({
                                            //title:'ยกเลิก!',
                                            title: 'ยกเลิกไม่สำเร็จ',
                                            icon: 'error'
                                        })
                                    }
                                }
                            })
                        }
                    })
                }
            })

        }

        function viewFile(id) {
            console.log(id);
            //var id = id;
            var url = '/view/source/file/' + id;
            //console.log(url);
            window.open(url, "_blank");
        }
    </script>
@endpush
