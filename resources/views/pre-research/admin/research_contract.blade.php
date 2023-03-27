@extends('layouts.admin.admin')
@section('content')
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
    <div class="row mb-3 mt-5">
        <div class="col-xl-12">
            <h3 style="font-weight: 800">อนุมัติสัญญาทุน</h3>
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <div class="table-responsive">
                    <table class="table fw-bold w-100" id="research_all_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr align="center">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อโครงร่างงานวิจัยภาษาไทย</th>
                                <th class="fw-bolder" style="font-size: 15px">รายละเอียด</th>
                                <th class="fw-bolder" style="font-size: 15px">สถานะ</th>
                                <th class="fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_re as $item)
                                @if ($item->research_status == 11 || $item->research_status == 15)
                                    <tr>
                                        <td align="center">{{ $i++ }}</td>
                                        <td>
                                            {!! Str::limit("$item->research_th", 50, ' ...') !!}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm"
                                                onclick="viewDetail({{ $item->research_id }})">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </td>
                                        <td align="center">
                                            <button class="btn btn-warning btn-sm">
                                                {{ $item->contract_status }}
                                            </button>
                                        </td>
                                        <td>
                                            @if ($item->contract_status == 'เพิ่มไฟล์สัญญาแล้ว')
                                                <button class="btn btn-info btn-sm"
                                                    onclick="viewFileCon({{ $item->contract_id }})">
                                                    ดูไฟล์
                                                </button>
                                            @else
                                                @if ($item->research_status == 15)
                                                    <button class="btn btn-sm" style="background-color: #2ec4b6;color:#fff"
                                                        onclick="approve({{ $item->research_id }})">
                                                        <i class="fa-solid fa-file-invoice"></i> อนุมัติสัญญา
                                                    </button>
                                                @endif
                                                @if ($item->research_status == 11)
                                                    <button class="btn btn-sm btn-primary"
                                                        onclick="addFile({{ $item->contract_id }})">
                                                        <i class="fa-solid fa-file-invoice"></i> เพิ่มไฟล์
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--approve Modal -->
    <div class="modal fade" id="approve" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="approveLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="approveLabel">อนุมัติสัญญาทุน</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.approve-contact') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_re" id="id_re">
                        <div class="row mb-3">
                            <strong class="col-3">ชื่อโครงร่างงานวิจัยภาษาไทย</strong>
                            <div class="col-9">
                                <input type="text" name="" id="n_th" value="" class=" form-control"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-3">ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</strong>
                            <div class="col-9">
                                <input type="text" name="" id="n_en" value="" class=" form-control"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-3">ชื่อแหล่งทุนงานวิจัย</strong>
                            <div class="col-9">
                                <input type="text" name="" id="s_re" value="" class=" form-control"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-3">ประเภทงานวิจัย</strong>
                            <div class="col-9">
                                <input type="text" name="" id="t_re" value="" class=" form-control"
                                    readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <strong class="col-sm-3 col-form-label">รายการส่งมอบ</strong>
                            <div class="col-sm-9">
                                <select class="form-select" id="list_app" name="list_app">
                                    <option value="">-- เลือกรายการส่งมอบ --</option>
                                    @foreach ($db_de_list as $row)
                                        <option value="{{ $row->deliver_id }}">
                                            {{ $row->research_source_name }} {{ $row->Type_research }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-3">จำนวนเงินที่อนุมัติ</strong>
                            <div class="col-9">
                                <input type="number" name="bug" id="bug" class=" form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">ยืนยัน</button>
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- modal view detail --}}
    <div class="modal fade" id="viewdetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewdetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewdetailLabel">รายละเอียดโครงร่างงานวิจัย</h1>
                    <button type="button" class="btn-close" {{-- data-bs-dismiss="modal" --}}onclick="location.reload()"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <strong for="year" class="col-sm-3 col-form-label" align="right">ปีงบประมาณ</strong>
                        <div class="col-sm-9">
                            <input type="text" class=" form-control-plaintext" id="year" name="year">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="nameTH" class="col-sm-3 col-form-label "
                            align="right">{{-- &emsp;&emsp; --}}ชื่อโครงร่างงานวิจัยภาษาไทย</strong>
                        <div class=" col-sm-9">
                            <label class="form-control-plaintext" id="nameTH" name="nameTH"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong for="nameEN" class="col-sm-3 col-form-label"
                            align="right">{{-- &emsp;&emsp; --}}ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</strong>
                        <div class=" col-sm-9">
                            <label class="form-control-plaintext" id="nameEN" name="nameEN"></label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong
                            for="message-text"style="text-align:left;font-weight:600;font-size:18px;background:#fff;border:none"
                            class="pt-3 py-0 card-header">รายชื่อนักวิจัย</strong>
                        <div class="card-body pt-0">
                            <table class="table table-responsive" id="detail_researcher" name="detail_researcher">
                                <thead align="center">
                                    <tr>
                                        <th width="600px" style="font-size: 14px">ลำดับ</th>
                                        <th width="600px" style="font-size: 14px">ชื่อ-นามสกุล</th>
                                        <th width="600px" style="font-size: 14px">สังกัด/คณะ</th>
                                        <th width="300px" style="font-size: 14px">ร้อยละบทบาทในการวิจัย</th>
                                    </tr>
                                </thead>
                                <tbody align="center" id="roleResearch">

                                </tbody>
                            </table>
                        </div>


                    </div>

                    <div class="row mb-3">
                        <strong for="message-text" class="col-sm-3 col-form-label" align="right">แหล่งทุนวิจัย</strong>
                        <div class="col-sm-9">
                            <label class="form-control-plaintext" id="source" name="source_id">
                            </label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-form-label col-sm-3 pt-0" align="right">ประเภทงานวิจัย</strong>
                        <div class="col-sm-9">
                            <label name="type" id="type_re" class="form-control-plaintext"></label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="inputEmail3" class="col-sm-3 col-form-label" align="right">คำสำคัญ</strong>
                        <div class="col-sm-9">
                            <label name="keyword" id="key" placeholder="คำสำคัญในการวิจัย"
                                class="form-control-plaintext"></label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="inputEmail3" class="col-sm-3 col-form-label"
                            align="right">พื้นที่ในการวิจัย</strong>
                        <div class="row col-sm-9">
                            <label id="area" class="form-control-plaintext"></label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="inputEmail3" class="col-sm-3 col-form-label"
                            align="right">วันที่เริ่มต้นการวิจัย</strong>
                        <div class="row col-sm-9">
                            <div class="col-sm">
                                <label class="form-control-plaintext" id="start" name="sdate"></label>
                            </div>
                            <strong for="inputEmail3" class="col-sm-4 col-form-label "
                                align="right">วันที่สิ้นสุดการวิจัย</strong>
                            <div class="col-sm">
                                <div class="col-sm">
                                    <label class="form-control-plaintext" id="end" name="edate"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="inputEmail3" class="col-sm-3 col-form-label"
                            align="right">งบประมาณการวิจัย</strong>
                        <div class="col-sm-9">
                            <label name="budage" id="bud" type="number" class="form-control-plaintext"></label>

                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex mx-5">
                        <button class="btn btn-warning" id="view_word">
                            WORD FILE
                        </button>
                        <button class="btn btn-warning" id="view_pdf">
                            PDF FILE
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" {{-- data-bs-dismiss="modal" --}}
                        onclick="location.reload()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--approve Modal -->
    <div class="modal fade" id="addFile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addFileLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addFileLabel">เพิ่มไฟล์สัญญาทุน</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_con" id="id_con">
                        <div class="row mb-3">
                            <strong class="col-3">ชื่อโครงร่างงานวิจัยภาษาไทย</strong>
                            <div class="col-9">
                                <input type="text" name="" id="t" value=""
                                    class=" form-control" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-3">ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</strong>
                            <div class="col-9">
                                <input type="text" name="" id="e" value=""
                                    class=" form-control" readonly>
                            </div>
                        </div>
                        <div class="row" id="add_f">
                            <strong class="col-3">เพิ่มไฟล์สัญญาทุน</strong>
                            <div class="col-9">
                                <input type="file" name="con_f" id="con_f" class=" form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">ยืนยัน</button>
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">ปิด</button>
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
            $('#research_all_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 3
                    },

                ],
                lengthMenu: [5, 15, 25, 50, 100, ],
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
    </script>

    <script>
        function approve(id) {
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '/view/research/' + id,
                dataType: 'JSON',
                success: function(res) {
                    moment.locale('th');
                    console.log(res.data_re);
                    var data = res.data_re;
                    //$('#n_th').val(data.)
                    var type_re = data[0].type_research_id;
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
                    $('#id_re').val(data[0].research_id);
                    $('#n_th').val(data[0].research_th);
                    $('#n_en').val(data[0].research_en);
                    $('#s_re').val(data[0].research_source_name);
                    $('#t_re').val(ty);
                }
            })
            $('#approve').modal('toggle');
        }

        function viewDetail(id) {
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '/view/research/' + id,
                dataType: 'JSON',
                success: function(res) {
                    moment.locale('th');
                    console.log(res.data_re);
                    var data = res.data_re;
                    createRows(res);
                    $('#viewdetail').modal('toggle');
                    //console.log(html);
                    var type_re = data[0].type_research_id;
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
                    //console.log(type);
                    var area_re = data[0].research_area;
                    var area = area_re.split('_');
                    var start = moment(data[0].date_research_start).add(543, 'year').format('Do MMMM YYYY');
                    var end = moment(data[0].date_research_end).add(543, 'year').format('Do MMMM YYYY');
                    // console.log(start);
                    //console.log(area);
                    $('#year').val(data[0].year_research);
                    $('#nameTH').html(data[0].research_th);
                    $('#nameEN').html(data[0].research_en);
                    $('#source').html(data[0].research_source_name);
                    $('#type_re').html(ty);
                    $('#key').html(data[0].keyword);
                    $('#area').html(area[0] + ' ' + area[1] + ' ' + area[2]);
                    $('#start').html(start);
                    $('#end').html(end);
                    $('#bud').html(data[0].budage_research + '.00 บาท');
                    $('#view_pdf').click(function() {
                        //console.log(data[0].research_id);
                        var id = data[0].research_id;
                        var url = '/view-pdf/' + id;
                        //console.log(url);
                        window.open(url, "_blank");
                    })
                    $('#view_word').click(function() {
                        //console.log(data[0].research_id);
                        var id = data[0].research_id;
                        var url = '/view-word/' + id;
                        //console.log(url);
                        window.open(url, "_blank");
                    })
                }
            })

        }

        function createRows(res) {
            var len = 0;
            $('#detail_researcher tbody').empty(); // Empty <tbody>
            if (res['data_re'] != null) {
                len = res['data_re'].length;

            }
            console.log(len);
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    //var id = response['data_re'][i].full_name_th;
                    var nameth = res['data_re'][i].full_name_th;
                    var major = res['data_re'][i].major;
                    var pc = res['data_re'][i].pc;

                    var tr_str = "<tr>" +
                        "<td align='center'>" + (i + 1) + "</td>" +
                        "<td align='center'>" + nameth + "</td>" +
                        "<td align='center'>" + major + "</td>" +
                        "<td align='center'>" + pc + "</td>" +
                        "</tr>";

                    $("#detail_researcher tbody").append(tr_str);
                }
            } else {
                var tr_str = "<tr>" +
                    "<td align='center' colspan='4'>No record found.</td>" +
                    "</tr>";

                $("#detail_researcher tbody").append(tr_str);
            }
        }

        function addFile(id) {
            console.log(id);
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/view-f/add-contract/' + id,
                success: function(res) {
                    console.log(res);
                    var db = res.db[0];
                    $('#t').val(db.research_th);
                    $('#e').val(db.research_en);
                    $('#addFile').modal('toggle');
                }
            })
        }

        function viewFileCon(id){
            console.log(id);
        }
    </script>
@endpush
