@extends('layouts.admin.admin')
@section('content')
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary me-md-2" type="button" onclick="addModal()">เพิ่มรายการส่งมอบ</button>
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
                                <th class=" fw-bolder" style="font-size: 15px">ประเภทงานวิจัย</th>
                                <th class=" fw-bolder" style="font-size: 15px">รายละเอียด</th>
                                <th class=" fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_de as $item)
                                <tr>
                                    <td align="center">{{ $i++ }}</td>
                                    <td>
                                        {{ $item->research_source_name }}
                                    </td>
                                    <td>
                                        @foreach (explode('_', $item->Type_research) as $ty)
                                            {{ $ty }} <br />
                                        @endforeach
                                        {{-- $item->Type_research --}}
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-info btn-sm" onclick="viewDetail({{ $item->deliver_id }})">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-yellow btn-sm me-2"
                                            onclick="edit({{ $item->deliver_id }})">แก้ไข</button>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="cancel({{ $item->deliver_id }})">ยกเลิก</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--Add Modal -->
    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">เพิ่มรายการส่งมอบ</h1>
                    <button type="button" class="btn-close" {{-- data-bs-dismiss="modal"  --}}aria-label="Close"
                        onclick="location.reload()"></button>
                </div>
                <form action="{{ route('admin.deliver-store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <strong class=" col-sm-3">แหล่งทุน</strong>
                            <div class="col-sm-9">
                                <select class="form-select" id="source_id" name="source_id">
                                    <option value="">-- เลือกแหล่งทุน --</option>
                                    @foreach ($data_so as $row)
                                        <option value="{{ $row->research_sources_id }}">
                                            {{ $row->research_source_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3">ประเภทงานวิจัย</strong>
                            <div class="col-sm-9">
                                <select class="form-select" id="type_id" name="type_id">
                                    <option value="">-- เลือกประเภทงานวิจัยการให้ทุน --</option>
                                    @foreach ($da as $row)
                                        <option value="{{ $row->type_research_id }}">
                                            {{ $row->type_research_id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3">วันที่เริ่มต้นสัญญา</strong>
                            <div class="col-sm-9">
                                <input type="date" name="contact_start" id="contact_start" class=" form-control"
                                    data-date-format="DD MM YYYY" min="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3">วันที่สิ้นสุดสัญญา</strong>
                            <div class="col-sm-9">
                                <input type="date" name="contact_end" id="contact_end" class=" form-control"
                                    data-date-format="DD MM YYYY" min="" />
                            </div>
                        </div>

                        <div class="row g-3 align-items-center justify-content-center mb-3">
                            <div class="col-auto">
                                <strong for="inputPassword6" class="col-form-label">จำนวนงวด</strong>
                            </div>
                            <div class="col-auto">
                                <input type="text" name="number" min="1" max="10" id="number"
                                    class=" form-control disabled" readonly value="" />
                            </div>
                            <div class="col-auto">
                                <span id="passwordHelpInline" class="form-text">
                                    <button class="btn btn-default btn-sm me-2" type="button" id="addNumbere">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>

                                </span>
                            </div>
                        </div>
                        <div id="boxLesson">
                            <div class="row mb-3 row-lesson mx-2" id="row[]">
                                <strong class="col-sm-2  " id="le">งวดที่ <span id="nu">1</span></strong>
                                <textarea name="lesson[]" id="lesson" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" {{-- data-bs-dismiss="modal" --}}
                            onclick="location.reload()">ยกเลิก</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!--View detail Modal -->
    <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewModalLabel">รายละเอียดรายการส่งมอบ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{--  <form action="{{ route('admin.deliver-store') }}" method="post">
                    @csrf --}}
                <div class="modal-body">
                    <div class="row mb-3">
                        <strong class=" col-sm-3">แหล่งทุน</strong>
                        <div class="col-sm-9">
                            <label for="" id="so"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-sm-3">ประเภทงานวิจัย</strong>
                        <div class="col-sm-9">
                            <label for="" id="ty"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-sm-3">วันที่เริ่มต้นสัญญา</strong>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-auto">
                                    <label for="" id="start"></label>
                                </div>
                                <div class="col-sm-1">
                                    <strong>ถึง</strong>
                                </div>
                                <div class="col-auto">
                                    <label for="" id="end"></label>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="table mb-0">
                        <div class="card-body pt-0">
                            <table class="table table-responsive" id="detail_list" name="detail_list">
                                <thead align="center">
                                    <tr>
                                        <th width="300px" style="font-size: 14px">งวดที่</th>
                                        <th width="800px" style="font-size: 14px" class=" text-wrap">รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody id="dt_list">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"data-bs-dismiss="modal">ปิด</button>
                </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>

    <!--edit Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">แก้ไขรายการส่งมอบ</h1>
                    <button type="button" class="btn-close" {{-- data-bs-dismiss="modal"  --}}aria-label="Close"
                        onclick="location.reload()"></button>
                </div>
                <form action="{{ route('admin.list-edit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_dl" id="id_dl">
                        <input type="hidden" name="s" id="s">
                        <input type="hidden" name="t" id="t">
                        <div class="row mb-3">
                            <strong class=" col-sm-3">แหล่งทุน</strong>
                            <div class="col-sm-9">
                                <label for="" id="source"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3">ประเภทงานวิจัย</strong>
                            <div class="col-sm-9">
                                <label for="" id="type_d"></label>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3">วันที่เริ่มต้นสัญญา</strong>
                            <div class="col-sm-9">
                                <input type="date" name="contact_start" id="contact_st" class=" form-control"
                                    data-date-format="DD MM YYYY" min="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3">วันที่สิ้นสุดสัญญา</strong>
                            <div class="col-sm-9">
                                <input type="date" name="contact_end" id="contact_en" class=" form-control"
                                    data-date-format="DD MM YYYY" min="" />
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="card-body pt-0">
                                <table class="table table-responsive" id="edit_list" name="tableTap">
                                    <thead align="center">
                                        <tr>
                                            <th width="300px" style="font-size: 14px">งวดที่</th>
                                            <th width="800px"style="font-size: 14px">
                                                รายละเอียด
                                            </th>
                                            <th width="100px">
                                                <button class="btn btn-info btn-sm" id="addBtnED" type="button">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody align="center" id="ed_list">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" {{-- data-bs-dismiss="modal" --}}
                            onclick="location.reload()">ยกเลิก</button>
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
            var len = 1;
            var old = $('#number').val();
            $('#addNumbere').click(function() {
                len++;
                // $('#nu').html(i);
                if (len > 10) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'จำนวนงวดต้องไม่เกิน 10 งวด',
                    })
                } else {

                    $('#number').val(len);
                    console.log(len);
                    tr = '<div class="row mb-3 mx-2"  id="row' + len + '">' +
                        '<strong class="col-sm-2 " id="le">งวดที่ <span id="nu">' + len +
                        '</span></strong>' +
                        // '<div class="col-sm-10">' +
                        '<textarea name="lesson[]" id="lesson" rows="5" class=" form-control col-8 me-2 "></textarea>' +
                        '<button class="btn btn-danger btn-sm col-auto" type="button" id="btnDel">' +
                        '<i class="fa-solid fa-minus"></i>' +
                        '</button>' +
                        // '</div>' +
                        '</div>';

                    $('#boxLesson').append(tr);
                }
            })

        })
        $(document).on('click', '#btnDel', function() {
            var len = $('#number').val();
            console.log('len:' + len);
            $(this).closest('div').remove();
            //$('#le').hide();
            // $(this).closest('strong').remove();
            var rd = len - 1;
            $('#number').val(rd);
        });
        $(document).on('click', '#btnDelED', function() {
            $(this).closest('tr').remove();
        });
    </script>

    <script>
        function addModal() {
            moment.locale('th');
            document.getElementById('contact_start').min = new Date(new Date().getTime() - new Date().getTimezoneOffset() *
                    60000)
                .toISOString().split("T")[0];
            document.getElementById('contact_end').min = new Date(new Date().getTime() - new Date().getTimezoneOffset() *
                    60000)
                .toISOString().split("T")[0];
            $('#number').val(1);
            $('#addModal').modal('toggle');
            var divRow = document.getElementById('#boxLesson');
        }

        function edit(id) {
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/admin/view/list/' + id,
                success: function(res) {
                    moment.locale('th');
                    var data = res.data_dl;
                    //console.log(data);
                    $('#editModal').modal('toggle');
                    createRowsEdit(res)

                    var type_re = data[0].Type_research;
                    var type = type_re.split('_');
                    //console.log(type);
                    var ty = '';
                    console.log('len:' + type.length);
                    if (type.length == 3) {
                        ty = type[0] + ', ' + type[1] + ', ' + type[2];
                    } else if (type.length == 2) {
                        ty = type[0] + ', ' + type[1];
                    } else {
                        ty = data[0].type_research_id;
                    }
                    $('#id_dl').val(data[0].deliver_id);
                    $('#s').val(data[0].research_source_id);
                    $('#t').val(data[0].Type_research);
                    $('#source').html(data[0].research_source_name);
                    $('#type_d').html(ty);
                    $('#contact_st').val(data[0].Date_start_contract);
                    $('#contact_en').val(data[0].Date_end_contract);

                }
            })

        }

        function viewDetail(id) {
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/admin/view/list/' + id,
                success: function(res) {
                    //console.log(res.data_dl[0]);
                    moment.locale('th');
                    var data = res.data_dl;

                    console.log(data);
                    var start = moment(data.Date_start_contract).add(543, 'year').format(
                        'วันที่ Do เดือนMMMM พ.ศ.YYYY');
                    var end = moment(data.Date_end_contract).add(543, 'year').format(
                        'วันที่ Do เดือนMMMM พ.ศ.YYYY');
                    var type_re = data[0].Type_research;
                    var type = type_re.split('_');
                    //console.log(type);
                    var ty = '';
                    //console.log('len:' + type.length);
                    if (type.length == 3) {
                        ty = type[0] + ', ' + type[1] + ', ' + type[2];
                    } else if (type.length == 2) {
                        ty = type[0] + ', ' + type[1];
                    } else {
                        ty = data[0].Type_research;
                    }
                    createRows(res);
                    $('#viewModal').modal('toggle');
                    $('#so').html(data[0].research_source_name);
                    $('#ty').html(ty);
                    $('#start').html(start);
                    $('#end').html(end);

                }
            })

        }

        function createRows(res) {
            var len = 0;
            $('#detail_list tbody').empty(); // Empty <tbody>
            if (res['data_dl'] != null) {
                len = res['data_dl'].length;

            }
            console.log('len: ' + len);
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    //var id = response['data_re'][i].full_name_th;
                    var detail = res['data_dl'][i].lesson;
                    //var major = res['data_dl'][i].major;
                    // var pc = res['data_dl'][i].pc;
                    console.log(detail);
                    var tr_str = "<tr>" +
                        "<td align='center'>" + (i + 1) + "</td>" +
                        "<td><textarea rows='5' class=' form-control-plaintext' readonly>" + detail + "</textarea></td>" +
                        "</tr>";

                    $("#detail_list tbody").append(tr_str);
                }
            } else {
                var tr_str = "<tr>" +
                    "<td align='center' colspan='2'>No record found.</td>" +
                    "</tr>";

                $("#detail_list tbody").append(tr_str);
            }
        }

        function createRowsEdit(res) {
            var len = 0;
            $('#edit_list tbody').empty(); // Empty <tbody>
            if (res['data_dl'] != null) {
                len = res['data_dl'].length;

            }
            console.log('len: ' + len);
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    //var id = response['data_re'][i].full_name_th;
                    var detail = res['data_dl'][i].lesson;
                    //var major = res['data_dl'][i].major;
                    // var pc = res['data_dl'][i].pc;
                    console.log(detail);
                    var tr_str = "<tr id='row" + i + "'>" +
                        "<td align='center'>" + (i + 1) + "</td>" +
                        "<td><textarea rows='5' class=' form-control'name='lesson[" + i + "]' id='ls" + i + "'>" + detail +
                        "</textarea></td>" +
                        "<td align='center'><button type='button' class='btn btn-danger btn-sm' id='btnDelED" + i +
                        "'><i class='fa-solid fa-minus'></i></button></td>" +
                        "</tr>";

                    $("#edit_list tbody").append(tr_str);
                }
                $('#addBtnED').click(function() {
                    // var row = i;
                    // len = len + 1;
                    var tr = '<tr id="row_ed' + len + '">' +
                        '<td align="center">' + (len + 1) + '</td>' +
                        '<td><textarea class="form-control" name="lesson[' + len +
                        ']" id="ls' + len +
                        '"></textarea></td>' +
                        '<td><button type="button" id="btnDelED" class="btn btn-danger btn-sm" ><i class="fa fa-minus"></i></button></td>' +
                        '</tr>';
                    $('#ed_list').append(tr);
                    console.log('LEN:' + len);

                    if (len > 10) {
                        Swal.fire({
                            icon: 'error',
                            //title: 'Oops...',
                            text: 'จำนวนงวดต้องไม่เกิน 10 งวด!',
                            // footer: '<a href="">Why do I have this issue?</a>'
                        })
                    }
                });
            } else {
                var tr_str = "<tr>" +
                    "<td align='center' colspan='3'>No record found.</td>" +
                    "</tr>";

                $("#edit_list tbody").append(tr_str);
            }
        }

        function cancel(id) {
            console.log(id);
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/admin/view/list/' + id,
                success: function(res) {
                    var data = res.data_dl;
                    Swal.fire({
                        title: 'คุณต้องการยกเลิกรายการส่งมอบแหล่งทุนวิจัย?',
                        text: 'ชื่อแหล่งทุนวิจัย : ' + data[0].research_source_name + '  ปีงบประมาณ: ' +
                            data[0].Year_source,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'GET',
                                dataType: 'JSON',
                                url: '/admin/cancel/list/' + id,
                                success: function(respo) {
                                    console.log(respo);
                                    if (respo.status == true) {
                                        Swal.fire({
                                            text: 'ยกเลิกสำเร็จ!',
                                            icon: 'success'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            text: 'ยกเลิกไม่สำเร็จ!',
                                            icon: 'error'
                                        });
                                    }
                                }
                            })

                        }
                    })
                }
            })
        }
    </script>
@endpush
