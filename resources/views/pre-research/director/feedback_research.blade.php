@extends('layouts.UD.ud')
@section('content')
    <div class=" container-fluid mt-5">

        <div class="row mb-3 mt-3">
            <div class="col-xl-12">
                <div class="bg-white rounded shadow-xl m-dash p-2">
                    <div class="table-responsive">
                        <table class="table fw-bold w-100" id="research_table">
                            <thead class="table-dark table-hover table align-middle">
                                <tr align="center">
                                    <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                    <th class="fw-bolder" style="font-size: 15px">ชื่อโครงร่างงานวิจัยภาษาไทย</th>
                                    <th class="fw-bolder" style="font-size: 15px">ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</th>
                                    <th class="fw-bolder" style="font-size: 15px">รายละเอียด</th>
                                    <th class="fw-bolder" style="font-size: 15px">สถานะ</th>
                                    <th class="fw-bolder" style="font-size: 15px">ประเมิน</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($re as $item)
                                    <tr>
                                        <td align="center">{{ $i++ }}</td>
                                        <td>{{ $item->research_th }}</td>
                                        <td>{{ $item->research_en }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm"
                                                onclick="viewDetail({{ $item->research_id }})">
                                                รายละเอียด
                                            </button>
                                        </td>
                                        <td>
                                            @if ($item->status == 0)
                                                <button class="btn btn-default btn-sm disabled">ยังไม่ได้ตรวจสอบ</button>
                                            @else
                                                <button class="btn btn-success btn-sm disabled">ตวจสอบแล้ว</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 0)
                                                <button class="btn btn-primary btn-sm"
                                                    onclick="addFeed({{ $item->research_id }})">
                                                    <i class="fa-solid fa-comment"></i> ประเมิน
                                                </button>
                                            @else
                                                <button class="btn btn-success btn-sm"
                                                    onclick="viewFeed({{ $item->research_id }},{{ $data[0]->employee_referees_id }})">
                                                    ดูการประเมิน
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--add feed Modal -->
    <div class="modal fade" id="addFeed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addFeedLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addFeedLabel">ประเมินโครงร่างงานวิจัย</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('director.add-feed') }}" method="post" enctype="multipart/form-data" id="form-feed">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_director" value="{{ $data[0]->employee_referees_id }}">
                        <input type="hidden" name="id_re" id="id_re">
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
                            <div class="col-sm-10"{{-- onclick="pass()" --}}>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="AssessmentResults"
                                        id="AssessmentResults1" value="ไม่ผ่าน" checked>
                                    <label class="form-check-label" for="AssessmentResults1">ไม่ผ่าน</label>
                                </div>

                                <div class="form-check form-check-inline" id="AssessmentResults2">
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
                                <textarea {{-- onkeyup="sugges()" --}} class="form-control" name="suggestion" id="comment" placeholder="ระบุข้อเสนอแนะ"
                                    rows="10"></textarea>
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
                        <input type="submit" class="btn btn-success" id="save" name="save"
                            {{-- onclick="saveFeed()" --}} value="บันทึก" />
                        <input type="submit" class="btn btn-primary" name="save" id="comfirm"
                            value="ส่งการประเมิน" />
                        {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button> --}}
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
                    <button type="button" class="btn-close" onclick="location.reload()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <strong for="year" class="col-sm-3 col-form-label" align="right">ปีงบประมาณ</strong>
                        <div class="col-sm-9">
                            <input type="text" class=" form-control-plaintext" id="year" name="year">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <strong for="nameTH" class="col-3 col-form-label "
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

                    <button type="button" class="btn btn-default" onclick="location.reload()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- view Feed Modal -->
    <div class="modal fade" id="viewFeed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="viewFeedLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewFeedLabel">รายละเอียด</h1>
                    <button type="button" class="btn-close" onclick="location.reload()" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <input type="hidden" name="research_id" id="research_id" value="">
                            <div class="mb-3 row">
                                <strong class="col-sm-3 col-form-label fw-bold">ชื่อโครงร่างงานวิจัยภาษาไทย</strong>
                                <div class="col-sm-9">
                                    <label readonly class="form-control-plaintext" id="th"></label>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <strong class="col-sm-3 col-form-label fw-bold">ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</strong>
                                <div class="col-sm-9">
                                    <label readonly class="form-control-plaintext" id="en"></label>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <strong class="col-sm-3 col-form-label fw-bold">ผลการประเมิน</strong>
                                <div class="col-sm-9">
                                    <input type="text" readonly class=" form-control-plaintext"
                                        name="Assessment_result" id="result" value="">
                                </div>
                            </div>

                            <div class="mb-3 row " id="div_cm">
                                <strong class="col-sm-3 col-form-label fw-bold">ข้อเสนอแนะ</strong>
                                <div class="col-sm-9">
                                    <label readonly class=" form-control-plaintext" name="suggestion"
                                        id="sg_cm"></label>

                                    <button type="button" class="btn btn-warning" name="suggestionFile" id="sg_F">ดูไฟล์</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="location.reload()">ปิด</button>
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
        });

        function addFeed(id) {
            console.log(id);
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/view/research/' + id,
                success: function(res) {
                    var data = res.data_re;
                    var data_feed = res.data_feed;
                    //console.log(data_feed);
                    var di = @json($data[0]->employee_referees_id);
                    console.log('DI:' + di);
                    for (let index = 0; index < data_feed.length; index++) {
                        if (data_feed[index].employee_referees_id == di) {
                            console.log(data_feed[index]);
                            $('#addFeed').modal('toggle');
                            $('#id_re').val(data[0].research_id);
                            $('#name_th').html(data[0].research_th);
                            $('#name_en').html(data[0].research_en);
                            if (data_feed[index].feedback != null || data_feed[index].suggestionFile != null) {
                                $('#checkFile').css('display', 'none');
                                $('#AssessmentResults2').css('display', 'none');
                                $('#comment').html(data_feed[index].feedback);
                            } else {

                            }

                        }
                    }


                }
            })

        }
    </script>
    <script>
        $(document).ready(function() {
            document.getElementById("suggestionFile").style.display = "none";
        });

        $('#AssessmentResults2').on('click', function() {
            $('#checkFile').css('display', 'none');
            $('#suggestionFile').css('display', 'none');
            $('#suggestion').css('display', 'none');
            $('#save').css('display', 'none');
        })
        $('#AssessmentResults1').on('click', function() {
            $('#checkFile').css('display', 'block');
            $('#suggestionFile').css('display', 'block');
            $('#suggestion').css('display', 'block');
            $('#save').css('display', 'block');
            sugges();
        })

        function sugges() {
            var rb = document.getElementById('AssessmentResults2');
            //var rb = document.querySelector('input[id="refers2"]:checked').value;
            var ck = document.getElementById('mustAddFile');
            var cf = document.getElementById('checkFile');
            var x = document.getElementById("suggestionFile");
            var z = document.getElementById("suggestion");
            var bs = document.getElementById("save");
            var bc = document.getElementById("comfirm");

            //x.value = x.value.toUpperCase();

            // console.log('false');
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
                    $('#source').html(data[0].full_name_source);
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
                    });
                    $('#view_word').click(function() {
                        //console.log(data[0].research_id);
                        var id = data[0].research_id;
                        var url = '/view-word/' + id;
                        //console.log(url);
                        window.open(url, "_blank");
                    });
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

                    var pc = res['data_re'][i].pc;

                    var tr_str = "<tr>" +
                        "<td align='center'>" + (i + 1) + "</td>" +
                        "<td align='center'>" + nameth + "</td>" +

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

        function viewFeed(id, u_id) {
            console.log(id);
            console.log('uid:' + u_id);
            $.ajax({
                method: 'GET',
                dataType: 'JSON',
                url: '/view/feed/detail/' + id + '/' + u_id,
                success: function(res) {
                    console.log(res.dt[0]);
                    var data = res.dt[0];
                    var cm = '';

                    if (data.feedback != null) {
                        cm = data.feedback;
                        $('#sg_F').css('display', 'none');
                        $('#sg_cm').html(cm);
                    } else if (data.suggestionFile != null) {
                        cm = data.suggestionFile;
                        $('#sg_cm').css('display', 'none');
                        $('#sg_F').html(cm);
                    } else {

                    }
                    if (data.Assessment_result == 'ผ่าน') {
                        $('#div_cm').css('display', 'none');

                    }
                    $('#sg_F').on('click', function() {
                        var id = data.research_id;
                        var val = data.suggestionFile;
                        var url = '/director/view-file/feed/' + id + '/' + val;
                        console.log(url);
                        window.open(url, "_blank");
                    })
                    $('#viewFeed').modal('toggle');
                    $('#th').html(data.research_th);
                    $('#en').html(data.research_en);
                    $('#result').val(data.Assessment_result);
                }
            })
            //

        }
    </script>
@endpush
