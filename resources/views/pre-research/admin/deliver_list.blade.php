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
                                        {{ $item->Type_research }}
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
                <form action="{{ route('admin.deliver-store') }}" method="post">
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
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" id="type"
                                        value="ชุมชนท้องถิ่น">
                                    <label class="form-check-label" for="type">
                                        ชุมชนท้องถิ่น
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" id="type"
                                        value="ศิลปวัฒนธรรม">
                                    <label class="form-check-label" for="gridRadios2">
                                        ศิลปวัฒนธรรม
                                    </label>
                                </div>

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
                                    <tr id="row_1">
                                        <td align="center" class="fw-bolder"><label
                                                for=""id="r_1"></label></td>
                                        <td>
                                            <textarea class=" form-control-plaintext" readonly for="" id="dl_1"></textarea>
                                        </td>
                                    </tr>
                                    <tr id="row_2">
                                        <td align="center" class="fw-bolder"><label
                                                for=""id="r_2"></label></td>
                                        <td>
                                            <textarea class=" form-control-plaintext" readonly for="" id="dl_2"></textarea>
                                        </td>
                                    </tr>
                                    <tr id="row_3">
                                        <td align="center" class="fw-bolder"><label
                                                for=""id="r_3"></label></td>
                                        <td>
                                            <textarea class=" form-control-plaintext" for="" id="dl_3"></textarea>
                                        </td>
                                    </tr>
                                    <tr id="row_4">
                                        <td align="center" class="fw-bolder"><label
                                                for=""id="r_4"></label></td>
                                        <td>
                                            <textarea class=" form-control-plaintext" for="" id="dl_4"></textarea>
                                        </td>
                                    </tr>
                                    <tr id="row_5">
                                        <td align="center" class="fw-bolder"><label
                                                for=""id="r_5"></label></td>
                                        <td>
                                            <textarea class=" form-control-plaintext" for="" id="dl_5"></textarea>
                                        </td>
                                    </tr>
                                    <tr id="row_6">
                                        <td align="center" class="fw-bolder"><label
                                                for=""id="r_6"></label></td>
                                        <td>
                                            <textarea class=" form-control-plaintext" for="" id="dl_6"></textarea>
                                        </td>
                                    </tr>
                                    <tr id="row_7">
                                        <td align="center" class="fw-bolder"><label
                                                for=""id="r_7"></label></td>
                                        <td>
                                            <textarea class=" form-control-plaintext" for="" id="dl_7"></textarea>
                                        </td>
                                    </tr>
                                    <tr id="row_8">
                                        <td align="center" class="fw-bolder"><label
                                                for=""id="r_8"></label></td>
                                        <td>
                                            <textarea class=" form-control-plaintext" for="" id="dl_8"></textarea>
                                        </td>
                                    </tr>
                                    <tr id="row_9">
                                        <td align="center" class="fw-bolder"><label
                                                for=""id="r_9"></label></td>
                                        <td>
                                            <textarea class=" form-control-plaintext" for="" id="dl_9"></textarea>
                                        </td>
                                    </tr>
                                    <tr id="row_10">
                                        <td align="center" class="fw-bolder"><label
                                                for=""id="r_10"></label></td>
                                        <td>
                                            <textarea class=" form-control-plaintext" for="" id="dl_10"></textarea>
                                        </td>
                                    </tr>
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

                        <div class="row g-3 align-items-center justify-content-center mb-3">
                            <div class="col-auto">
                                <strong for="inputPassword6" class="col-form-label">จำนวนงวด</strong>
                            </div>
                            <div class="col-auto">
                                <input type="text" name="number" min="1" max="10" id="num"
                                    class=" form-control disabled" readonly value="" />
                            </div>
                            <div class="col-auto">
                                <span id="passwordHelpInline" class="form-text">
                                    <button class="btn btn-default btn-sm me-2" type="button" id="addNum">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>

                                </span>
                            </div>
                        </div>
                        <div id="box">
                            <div class="row mb-3 row-lesson mx-2" id="rw_1">
                                <strong class="col-sm-2  " id="le_1">งวดที่ <span id="nu">1</span></strong>
                                <textarea name="lesson_1" id="lesson_i_1" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                            <div class="row mb-3 row-lesson mx-2" id="rw_2">
                                <strong class="col-sm-2  " id="le_2">งวดที่ <span id="nu">2</span></strong>
                                <textarea name="lesson_2" id="lesson_i_2" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                            <div class="row mb-3 row-lesson mx-2" id="rw_3">
                                <strong class="col-sm-2  " id="le_3">งวดที่ <span id="nu">3</span></strong>
                                <textarea name="lesson_3" id="lesson_i_3" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                            <div class="row mb-3 row-lesson mx-2" id="rw_4">
                                <strong class="col-sm-2  " id="le_4">งวดที่ <span id="nu">4</span></strong>
                                <textarea name="lesson_4" id="lesson_i_4" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                            <div class="row mb-3 row-lesson mx-2" id="rw_5">
                                <strong class="col-sm-2  " id="le_5">งวดที่ <span id="nu">5</span></strong>
                                <textarea name="lesson_5" id="lesson_i_5" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                            <div class="row mb-3 row-lesson mx-2" id="rw_6">
                                <strong class="col-sm-2  " id="le_6">งวดที่ <span id="nu">6</span></strong>
                                <textarea name="lesson_6" id="lesson_i_6" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                            <div class="row mb-3 row-lesson mx-2" id="rw_7">
                                <strong class="col-sm-2  " id="le_7">งวดที่ <span id="nu">7</span></strong>
                                <textarea name="lesson_7" id="lesson_i_7" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                            <div class="row mb-3 row-lesson mx-2" id="rw_8">
                                <strong class="col-sm-2  " id="le_8">งวดที่ <span id="nu">8</span></strong>
                                <textarea name="lesson_8" id="lesson_i_8" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                            <div class="row mb-3 row-lesson mx-2" id="rw_9">
                                <strong class="col-sm-2  " id="le_9">งวดที่ <span id="nu">9</span></strong>
                                <textarea name="lesson_9" id="lesson_i_9" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                            <div class="row mb-3 row-lesson mx-2" id="rw_10">
                                <strong class="col-sm-2  " id="le_l_10">งวดที่ <span id="nu">10</span></strong>
                                <textarea name="lesson_10" id="lesson_i_10" rows="5" class=" form-control col-8 me-2 "></textarea>
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
                    var data = res.data_dl[0];
                    //console.log(data);
                    $('#editModal').modal('toggle');

                    $('#source').html(data.research_source_name);
                    $('#type_d').html(data.Type_research);
                    $('#contact_st').val(data.Date_start_contract);
                    $('#contact_en').val(data.Date_end_contract);

                    $('#lesson_i_1').html(data.lesson1);
                    if (data.lesson2 != null) {
                        $('#num').val(2);
                        $('#lesson_i_2').html(data.lesson2);
                    } else {
                        $('#rw_2').css('display', 'none');
                    }

                    if (data.lesson3 != null) {
                        $('#num').val(3);
                        $('#lesson_i_3').html(data.lesson3);
                    } else {
                        $('#rw_3').css('display', 'none');
                    }

                    if (data.lesson4 != null) {
                        $('#num').val(4);
                        $('#lesson_i_4').html(data.lesson4);
                    } else {
                        $('#rw_4').css('display', 'none');
                    }

                    if (data.lesson5 != null) {
                        $('#num').val(5);
                        $('#lesson_i_5').html(data.lesson5);
                    } else {
                        $('#rw_5').css('display', 'none');
                    }

                    if (data.lesson6 != null) {
                        $('#num').val(6);
                        $('#lesson_i_6').html(data.lesson6);
                    } else {
                        $('#rw_6').css('display', 'none');
                    }

                    if (data.lesson7 != null) {
                        $('#r_7').val(7);
                        $('#lesson_i_7').html(data.lesson7);
                    } else {
                        $('#rw_7').css('display', 'none');
                    }

                    if (data.lesson8 != null) {
                        $('#num').val(8);
                        $('#lesson_i_8').html(data.lesson8);
                    } else {
                        $('#rw_8').css('display', 'none');
                    }

                    if (data.lesson9 != null) {
                        $('#num').val(9);
                        $('#lesson_i_9').html(data.lesson9);
                    } else {
                        $('#rw_9').css('display', 'none');
                    }

                    if (data.lesson10 != null) {
                        $('#num').val(10);
                        $('#lesson_i_10').html(data.lesson10);
                    } else {
                        $('#rw_10').css('display', 'none');
                    }


                    var c_num = $('#num').val();
                    console.log(c_num);

                    $('#addNum').on('click', function() {
                        c_num++;
                        // $('#nu').html(i);
                        if (c_num > 10) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'จำนวนงวดต้องไม่เกิน 10 งวด',
                            })
                        } else {

                            $('#num').val(c_num);
                            console.log(c_num);
                            tr = '<div class="row mb-3 mx-2"  id="row' + c_num + '">' +
                                '<strong class="col-sm-2 " id="le">งวดที่ <span id="nu">' + c_num +
                                '</span></strong>' +
                                // '<div class="col-sm-10">' +
                                '<textarea name="lesson[]" id="lesson' + c_num +
                                '" rows="5" class=" form-control col-8 me-2 "></textarea>' +
                                '<button class="btn btn-danger btn-sm col-auto" type="button" id="btnDel">' +
                                '<i class="fa-solid fa-minus"></i>' +
                                '</button>' +
                                // '</div>' +
                                '</div>';

                            $('#box').append(tr);
                        }
                    });
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
                    var data = res.data_dl[0];
                    console.log(data);
                    var start = moment(data.Date_start_contract).add(543, 'year').format(
                        'วันที่ Do เดือนMMMM พ.ศ.YYYY');
                    var end = moment(data.Date_end_contract).add(543, 'year').format(
                        'วันที่ Do เดือนMMMM พ.ศ.YYYY');
                    var type_re = data.Type_research;
                    var type = type_re.split('_');
                    //console.log(type);
                    var ty = '';
                    //console.log('len:' + type.length);
                    if (type.length == 3) {
                        ty = type[0] + ', ' + type[1] + ', ' + type[2];
                    } else if (type.length == 2) {
                        ty = type[0] + ', ' + type[1];
                    } else {
                        ty = data.Type_research;
                    }

                    $('#viewModal').modal('toggle');
                    $('#so').html(data.research_source_name);
                    $('#ty').html(ty);
                    $('#start').html(start);
                    $('#end').html(end);

                    if (data.lesson1 != null) {
                        $('#r_1').html('1');
                        $('#dl_1').html(data.lesson1);
                    } else {
                        $('#row_1').css('display', 'none');
                    }

                    if (data.lesson2 != null) {
                        $('#r_2').html('2');
                        $('#dl_2').html(data.lesson2);
                    } else {
                        $('#row_2').css('display', 'none');
                    }

                    if (data.lesson3 != null) {
                        $('#r_3').html('3');
                        $('#dl_3').html(data.lesson3);
                    } else {
                        $('#row_3').css('display', 'none');
                    }

                    if (data.lesson4 != null) {
                        $('#r_4').html('4');
                        $('#dl_4').html(data.lesson4);
                    } else {
                        $('#row_4').css('display', 'none');
                    }

                    if (data.lesson5 != null) {
                        $('#r_5').html('5');
                        $('#dl_5').html(data.lesson5);
                    } else {
                        $('#row_5').css('display', 'none');
                    }

                    if (data.lesson6 != null) {
                        $('#r_6').html('6');
                        $('#dl_6').html(data.lesson6);
                    } else {
                        $('#row_6').css('display', 'none');
                    }

                    if (data.lesson7 != null) {
                        $('#r_7').html('7');
                        $('#dl_7').html(data.lesson7);
                    } else {
                        $('#row_7').css('display', 'none');
                    }

                    if (data.lesson8 != null) {
                        $('#r_8').html('8');
                        $('#dl_8').html(data.lesson8);
                    } else {
                        $('#row_8').css('display', 'none');
                    }

                    if (data.lesson9 != null) {
                        $('#r_9').html('9');
                        $('#dl_9').html(data.lesson9);
                    } else {
                        $('#row_9').css('display', 'none');
                    }

                    if (data.lesson10 != null) {
                        $('#r_10').html('10');
                        $('#dl_10').html(data.lesson10);
                    } else {
                        $('#row_10').css('display', 'none');
                    }
                }
            })

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
                        title: 'คุณต้องการยกเลิกแหล่งทุนวิจัย?',
                        text: 'ชื่อแหล่งทุนวิจัย : ' + data[0].research_source_name,
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
