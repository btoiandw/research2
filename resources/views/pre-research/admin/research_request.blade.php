@extends('layouts.admin.admin')
@section('content')
    <div class="row mb-3 mt-3">
        <div class="col-xl-12">
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <div class="table-responsive">
                    <table class="table fw-bold w-100" id="research_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr align="center">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อโครงร่างงานวิจัยภาษาไทย</th>
                                <th class="fw-bolder" style="font-size: 15px">รายละเอียด</th>
                                <th class="fw-bolder" style="font-size: 15px">สถานะ</th>
                                <th class="fw-bolder" style="font-size: 15px">สรุปผล/ข้อเสนอแนะ</th>
                                <th class="fw-bolder" style="font-size: 15px">เพิ่มกรรมการ</th>
                                <th class="fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_re as $item)
                                <tr>
                                    <td align="center">{{ $i++ }}</td>
                                    <td>
                                        {!! Str::limit("$item->research_th", 50, ' ...') !!}
                                    </td>
                                    <td align="center">
                                        <button class=" btn btn-info btn-sm" onclick="viewDetail({{ $item->research_id }})">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td align="center">
                                        @if ($item->research_status == 0)
                                            <button class="btn btn-yellow disabled btn-sm">
                                                รอตรวจสอบ
                                            </button>
                                        @else
                                        @endif
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-sm btn-default"
                                            onclick="addSumFeed({{ $item->research_id }})">
                                            <i class="fa-solid fa-plus"></i><span>ข้อเสนอแนะ</span>
                                        </button>
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-default btn-sm"
                                            onclick="addDirector({{ $item->research_id }})">
                                            <i class="fa-solid fa-user-plus"></i>
                                        </button>
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-xmark"></i><span>ยกเลิก</span>
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

    {{-- modal view detail --}}
    <div class="modal fade" id="viewdetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewdetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewdetailLabel">รายละเอียดโครงร่างงานวิจัย</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="year" class="col-sm-2 col-form-label" align="right">ปีงบประมาณ</label>
                        <div class="col-sm-10">
                            <input type="text" class=" form-control-plaintext" id="year" name="year">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nameTH" class="col-sm-2 col-form-label "
                            align="right">{{-- &emsp;&emsp; --}}ชื่อโครงร่างงานวิจัยภาษาไทย</label>
                        <div class=" col-sm-10">
                            <label class="form-control-plaintext" id="nameTH" name="nameTH"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nameEN" class="col-sm-2 col-form-label"
                            align="right">{{-- &emsp;&emsp; --}}ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</label>
                        <div class=" col-sm-10">
                            <label class="form-control-plaintext" id="nameEN" name="nameEN"></label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label
                            for="message-text"style="text-align:left;font-weight:600;font-size:18px;background:#fff;border:none"
                            class="pt-3 py-0 card-header">รายชื่อนักวิจัย</label>
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
                        <label for="message-text" class="col-sm-2 col-form-label" align="right">แหล่งทุนวิจัย</label>
                        <div class="col-sm-10">
                            <label class="form-control-plaintext" id="source" name="source_id">
                            </label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-form-label col-sm-2 pt-0" align="right">ประเภทงานวิจัย</div>
                        <div class="col-sm-10">
                            <label name="type" id="type_re" class="form-control-plaintext"></label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" align="right">คำสำคัญ</label>
                        <div class="col-sm-10">
                            <label name="keyword" id="key" placeholder="คำสำคัญในการวิจัย"
                                class="form-control-plaintext"></label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" align="right">พื้นที่ในการวิจัย</label>
                        <div class="row col-sm-10">
                            <label id="area" class="form-control-plaintext"></label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label"
                            align="right">วันที่เริ่มต้นการวิจัย</label>
                        <div class="row col-sm-10">
                            <div class="col-sm">
                                <label class="form-control-plaintext" id="start" name="sdate"></label>

                            </div>
                            <label for="inputEmail3" class="col-sm-2 col-form-label "
                                align="right">วันที่สิ้นสุดการวิจัย</label>
                            <div class="col-sm">
                                <div class="col-sm">
                                    <label class="form-control-plaintext" id="end" name="edate"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label" align="right">งบประมาณการวิจัย</label>
                        <div class="col-sm-10">
                            <label name="budage" id="bud" type="number" class="form-control-plaintext"></label>

                        </div>
                    </div>

                    <div class="row">
                        <div class="d-grid gap-2 d-md-flex mx-5">
                            <button class="btn btn-warning" id="view_word">
                                WORD FILE
                            </button>
                            <button class="btn btn-warning" id="view_pdf">
                                PDF FILE
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- add director --}}
    <div class="modal fade" id="add_director" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="add_directorlLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="add_directorLabel">เพิ่มคณะกรรมการ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.add-director') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_r" id="id_r" value="" />
                        <div class="row mb-3">
                            <strong class="col-sm-3 col-form-label" align="right">ชื่อโครงร่างงานวิจัย : </strong>
                            <div class="col-sm-9">
                                <label class="form-control-plaintext" id="name_th"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3 col-form-label" align="right">แหล่งทุน : </strong>
                            <div class="col-sm-9">
                                <label class="form-control-plaintext" id="so"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3 col-form-label" align="right">ประเภทงานวิจัย : </strong>
                            <div class="col-sm-9">
                                <label class="form-control-plaintext" id="ty"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3 col-form-label" align="right">งบประมาณ : </strong>
                            <div class="col-sm-9">
                                <label class="form-control-plaintext" id="bu"></label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3 col-form-label" align="right">กรรมการท่านที่ 1</strong>
                            <div class="col-sm-9">
                                <select class="form-select" name="referees[]" id="referees[]"
                                    aria-label="Default select example">
                                    <option selected>-- เลือกชื่อกรรมการท่านที่ 1 --</option>
                                    @foreach ($data_d as $rows)
                                        <option value="{{ $rows->employee_referees_id }}">{{ $rows->full_name_th }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3 col-form-label" align="right">กรรมการท่านที่ 2</strong>
                            <div class="col-sm-9">
                                <select class="form-select" name="referees[]" id="referees[]"
                                    aria-label="Default select example">
                                    <option selected>-- เลือกชื่อกรรมการท่านที่ 2 --</option>
                                    @foreach ($data_d as $rows)
                                        <option value="{{ $rows->employee_referees_id }}">{{ $rows->full_name_th }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3 col-form-label" align="right">กรรมการท่านที่ 3</strong>
                            <div class="col-sm-9">
                                <select class="form-select" name="referees[]" id="referees[]"
                                    aria-label="Default select example">
                                    <option selected>-- เลือกชื่อกรรมการท่านที่ 3 --</option>
                                    @foreach ($data_d as $rows)
                                        <option value="{{ $rows->employee_referees_id }}">{{ $rows->full_name_th }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary me-2">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!--add sum feed Modal -->
    <div class="modal fade" id="addFeed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addFeedLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addFeedLabel">ประเมินโครงร่างงานวิจัย</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <strong class="col-md-3">ชื่อโครงร่างงานวิจัยภาษาไทย</strong>
                        <div class="col-md-9">
                            <label for="" id="name_th"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-md-3">ชื่อโครงร่างงานวิจัยอังกฤษ</strong>
                        <div class="col-md-9">
                            <label for="" id="name_en"></label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-bold">ผลการประเมิน</label>
                        <div class="col-sm-10"onclick="pass()">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="AssessmentResults"
                                    id="AssessmentResults1" value="ไม่ผ่าน" checked>
                                <label class="form-check-label" for="AssessmentResults1">ไม่ผ่าน</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="AssessmentResults"
                                    id="AssessmentResults2" value="ผ่าน" {{-- disabled --}}>
                                <label class="form-check-label" for="AssessmentResults2">ผ่าน</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row"id="checkFile">
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input onclick="sugges()" class="form-check-input" type="checkbox" id="mustAddFile"
                                    name="mustAddFile" value="mustAddFile">
                                <label class="form-check-label text-danger"
                                    for="mustAddFile">ต้องการเพิ่มไฟล์ข้อเสนอแนะ</label>
                            </div>
                        </div>
                    </div>
                    <div class=" row " id="suggestion">
                        <label class="col-sm-3 col-form-label fw-bold">ข้อเสนอแนะ</label>
                        <div class=" px-3">
                            <textarea {{-- onkeyup="sugges()" --}} class="form-control" name="suggestion" {{-- id="suggestion" --}}
                                placeholder="ระบุข้อเสนอแนะ" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="row" id="suggestionFile">
                        <label class="col-sm-3 col-form-label fw-bold">ไฟล์ข้อเสนอแนะ</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="suggestionFile" id="suggestionFile"
                                rows="20">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
        $(document).ready(function() {
            $('#research_table').DataTable({
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
                    {
                        responsivePriority: 3,
                        targets: 5
                    },
                ],
                lengthMenu: [10, 20, 50, 100, ],
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
                    $('#type_re').html(type[0] + ', ' + type[1]);
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

        function addDirector(id) {
            $.ajax({
                type: 'GET',
                url: '/admin/research/director/' + id,
                dataType: 'JSON',
                success: function(res) {
                    console.log(res);
                    var data = res.data_re
                    $('#add_director').modal('toggle');
                    //console.log(data);
                    $('#id_r').val(data[0].research_id)
                    $('#name_th').html(data[0].research_th);
                    $('#so').html(data[0].research_source_name);
                    $('#ty').html(data[0].type_research_id);
                    $('#bu').html(data[0].budage_research);
                }
            })
            /*   */
        }

        function addSumFeed(id) {
            $('#addFeed').modal('toggle');
        }

        $(document).ready(function() {
            document.getElementById("suggestionFile").style.display = "none";
        });

        function sugges() {
            var rb = document.getElementById('AssessmentResults2');
            //var rb = document.querySelector('input[id="refers2"]:checked').value;
            var ck = document.getElementById('mustAddFile');
            var cf = document.getElementById('checkFile');
            var x = document.getElementById("suggestionFile");
            var z = document.getElementById("suggestion");
            var bs = document.getElementById("save");

            //x.value = x.value.toUpperCase();

            console.log('false');
            if (ck.checked == true) {
                console.log('true');
                Swal.fire({
                    text: "คุณต้องการเพิ่มไฟล์ข้อเสนอแนะ ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่',
                    cancelButtonText: 'ไม่',
                }).then((result) => {
                    if (result.isConfirmed) {
                        x.style.display = "";
                        z.style.display = "none";
                        bs.style.display = "none";
                    }
                    if (result.dismiss) {
                        //console.log('false');
                        ck.checked = false;
                        x.style.display = "none";
                        z.style.display = "";
                        bs.style.display = "";
                    }
                })

            } else {
                //console.log('false');
                ck.style.display = "";
                x.style.display = "none";
                z.style.display = "";
            }

        }

        function pass() {
            var rb2 = document.getElementById('AssessmentResults2');
            var rb1 = document.getElementById('AssessmentResults1');
            //var rb = document.querySelector('input[id="refers2"]:checked').value;
            var ck = document.getElementById('mustAddFile');
            var cf = document.getElementById('checkFile');
            var x = document.getElementById("suggestionFile");
            var z = document.getElementById("suggestion");
            var bs = document.getElementById("save");

            //x.value = x.value.toUpperCase();

            if (rb2.checked == true) {
                cf.style.display = "none";
                x.style.display = "none";
                z.style.display = "none";
                bs.style.display = "none";
                console.log('true');
            }
            if (rb1.checked == true) {
                cf.style.display = "";
                bs.style.display = "";
                sugges();
            }
        }
    </script>
@endpush
