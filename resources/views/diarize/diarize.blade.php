@extends('layouts.app')
<style>
     #preview {
            width: 100%; /* Full width */
            height: 450px; /* Define the height for the scrollable container */
            overflow-y: auto; /* Enable vertical scrolling */
            border: 1px solid #ccc; /* Optional: Add a border for clarity */
            padding: 5px; /* Add padding for spacing */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
        }
</style>
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row d-flex align-items-stretch">
                <div class="col-md-6">
                    <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
                        <!-- <div class="box-header">
                                                <div class="box-tools">
                                                <p style="font-size:18px;font-weight:bold;margin-bottom: 9px; color:#173F5F;">Actions</p>
                                                </div>
                                            </div> -->
                        <div class="box-body">
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Main row -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="letter-form">

                                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active active-link" id="custom-tabs-one-home-tab"
                                                            data-toggle="pill" href="#custom-tabs-one-home" role="tab"
                                                            aria-controls="custom-tabs-one-home" aria-selected="true"><strong>Letter Details</strong>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link disabled disabled-link"
                                                            id="custom-tabs-one-profile-tab" data-toggle="pill"
                                                            href="#custom-tabs-one-profile" role="tab"
                                                            aria-controls="custom-tabs-one-profile" aria-selected="false">
                                                            @if ($receipt == 1)
                                                            <strong>Sender Details</strong>
                                                            @else
                                                            <strong>Recipient Details</strong>
                                                            @endif
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                                    <div class="tab-pane fade show active" id="custom-tabs-one-home"
                                                        role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Letter No.<span
                                                                        class="text text-danger fw-bold">*</span></label>
                                                                <input type="text" name="letter_no" id="letter_no"
                                                                    class="form-control form-control-sm">
                                                                <label class="text text-danger letter_no fw-bold"></label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Letter Date<span
                                                                        class="text text-danger fw-bold">*</span></label>
                                                                <input type="date" name="letter_date" id="letter_date"
                                                                    class="form-control form-control-sm">
                                                                <label class="text text-danger letter_date fw-bold"></label>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label fw-bold">Subject<span
                                                                        class="text text-danger fw-bold">*</span></label>
                                                                <textarea class="form-control form-control-sm" name="subject" id="subject"></textarea>
                                                                <label class="text text-danger subject fw-bold"></label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Letter Category<span
                                                                        class="text text-danger fw-bold">*</span></label>
                                                                <select class="form-control form-control-sm" name="category"
                                                                    id="category">
                                                                    <option value="">Select Category</option>
                                                                    @foreach ($letterCategories as $value)
                                                                        <option value="{{ $value['id'] }}">
                                                                            {{ $value['category_name'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <label class="text text-danger category fw-bold"></label>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Letter Sub Category<span
                                                                        class="text text-danger fw-bold">*</span></label>
                                                                <select class="form-control form-control-sm" name="sub_category"
                                                                    id="sub_category">
                                                                    <option value="">Select Sub Category</option>
                                                                    
                                                                </select>
                                                                <input type="hidden" class="form-control" name="other_sub_category" id="other_sub_category" placeholder="Other Sub Category">
                                                                <label class="text text-danger sub_category fw-bold other_sub_category"></label>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Priority<span
                                                                        class="text text-danger fw-bold">*</span></label>
                                                                <select class="form-control form-control-sm" name="priority"
                                                                    id="priority">
                                                                    <option value="">Select Priority</option>
                                                                    @foreach ($priorities as $value)
                                                                        <option value="{{ $value['id'] }}">
                                                                            {{ $value['priority_name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label class="text text-danger priority fw-bold"></label>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Letter<span
                                                                        class="text text-danger fw-bold">*</span></label>
                                                                <input type="file" name="letter" id="letter"
                                                                    class="form-control form-control-sm">
                                                                <label class="text text-danger letter fw-bold"></label>
                                                            </div>




                                                            <div class="col-md-6">
                                                                @php
                                                                    $issue_date = "";
                                                                    $read_only = "";
                                                                @endphp
                                                                @if ($receipt == 1)
                                                                    <label class="form-label fw-bold">Received Date<span
                                                                            class="text text-danger fw-bold">*</span></label>
                                                                @else
                                                                @php
                                                                    $issue_date = \Carbon\Carbon::now()->format('Y-m-d');
                                                                    $read_only = "readonly";
                                                                @endphp
                                                                    <label class="form-label fw-bold">Issue Date<span
                                                                            class="text text-danger fw-bold">*</span></label>
                                                                @endif
                                                                @if($legacy != 1)
                                                                <input type="date" name="received_date"
                                                                id="received_date" class="form-control form-control-sm" value="{{$issue_date}}" {{$read_only}}>
                                                                @else
                                                                <input type="date" name="received_date"
                                                                id="received_date" class="form-control form-control-sm">
                                                                @endif
                                                                <label
                                                                    class="text text-danger received_date fw-bold"></label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Diarize Date<span
                                                                        class="text text-danger fw-bold">*</span></label>
                                                                <input type="date" name="diary_date" id="diary_date"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                    readonly>
                                                                <label class="text text-danger diary_date fw-bold"></label>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <input type="hidden" name="receipt"
                                                                    value="{{ $receipt }}">
                                                            <input type="hidden" name="legacy"
                                                                    value="{{ $legacy }}">
                                                                <button type="button" class="btn btn-warning btn-sm"
                                                                    data-target="#custom-tabs-one-home"
                                                                    id="btn-next">NEXT</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="custom-tabs-one-profile"
                                                        role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                                        <div id="sender-fields"
                                                            style="display: @if ($receipt == 1) block @else none @endif">
                                                            <!-- Sender Details Form Fields -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Name<span
                                                                            class="text text-danger fw-bold">*</span></label>
                                                                    <input type="text" name="sender_name"
                                                                        id="sender_name"
                                                                        class="form-control form-control-sm"
                                                                        placeholder=" Name of a person">
                                                                    <label
                                                                        class="text text-danger sender_name fw-bold"></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Designation<span
                                                                            class="text text-danger fw-bold">*</span></label>
                                                                    <input type="text" name="sender_designation"
                                                                        id="sender_designation"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="eg. Home Secretary">
                                                                    <label
                                                                        class="text text-danger sender_designation fw-bold"></label>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Mobile</label>
                                                                    <input type="text" name="sender_mobile"
                                                                        id="sender_mobile"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="eg. 7020541234">
                                                                    <label
                                                                        class="text text-danger sender_mobile fw-bold"></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Email</label>
                                                                    <input type="text" name="sender_email"
                                                                        id="sender_email"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="eg. assam@gov.in">
                                                                    <label
                                                                        class="text text-danger sender_email fw-bold"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="recipient-fields"
                                                            style="display: @if ($receipt == 0) block @else none @endif">
                                                            <!-- Recipient Details Form Fields -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Name<span
                                                                            class="text text-danger fw-bold">*</span></label>
                                                                    <input type="text" name="recipient_name"
                                                                        id="recipient_name"
                                                                        class="form-control form-control-sm"
                                                                        placeholder=" Name of a person">
                                                                    <label
                                                                        class="text text-danger recipient_name fw-bold"></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Designation<span
                                                                            class="text text-danger fw-bold">*</span></label>
                                                                    <input type="text" name="recipient_designation"
                                                                        id="recipient_designation"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="eg. Home Secretary">
                                                                    <label
                                                                        class="text text-danger recipient_designation fw-bold"></label>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Mobile</label>
                                                                    <input type="text" name="recipient_mobile"
                                                                        id="recipient_mobile"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="eg. 7020541234">
                                                                    <label
                                                                        class="text text-danger recipient_mobile fw-bold"></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Email</label>
                                                                    <input type="text" name="recipient_email"
                                                                        id="recipient_email"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="eg. assam@gov.in">
                                                                    <label
                                                                        class="text text-danger recipient_email fw-bold"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label class="form-label fw-bold">Office Details<span
                                                                        class="text text-danger fw-bold">*</span></label>
                                                                <textarea class="form-control form-control-sm" name="organization" id="organization"
                                                                    placeholder="eg. Assam Secretariat"></textarea>
                                                                <label
                                                                    class="text text-danger organization fw-bold"></label>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <label class="form-label fw-bold">Address</label>
                                                                <textarea class="form-control form-control-sm" name="address" id=address"
                                                                    placeholder="eg. Dispur, Guwahati, Kamrup(M), Assam-781019"></textarea>
                                                                <label class="text text-danger address fw-bold"></label>
                                                            </div>
                                                            @if ($receipt == 1)
                                                                <div class="col-md-12">

                                                                    <label for="auto-ack"
                                                                        class="ml-4 form-label fw-bold"><input
                                                                            class="form-check-input" type="checkbox"
                                                                            value="1" id="auto-ack"
                                                                            name="auto_ack">&nbsp;Auto Generate
                                                                        Acknowledgement</label>

                                                                </div>
                                                            @endif

                                                            <div class="col-md-6">
                                                                <button type="button" class="btn btn-warning btn-sm"
                                                                    data-target="#custom-tabs-one-home"
                                                                    id="btn-prev">PREVIOUS</button>
                                                                &nbsp;
                                                                <button type="button"
                                                                    class="btn btn-primary save-btn btn-sm"
                                                                    data-url="{{ route('store_letter') }}"
                                                                    data-form="#letter-form"
                                                                    data-message="Do you want to diarize this letter?"
                                                                    data-redirect="{{ route('letters', [encrypt(0)]) }}"
                                                                    id="save-letter-btn">DIARIZE</button>
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Main row -->
                                </div><!-- /.container-fluid -->
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box shadow-lg p-3 mb-5 bg-white rounded min-vh-40">
                        <div class="box-body">
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Main row -->
                                    <div class="row">
                                        <div class="col-md-12" style="height:29rem;">
                                            <div class="fileContent" id="preview">
                                                <h5 class="text text-warning mt-5 text-center">Please upload the letter for
                                                    viewing.</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Main row -->
                                </div><!-- /.container-fluid -->
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script src="{{ asset('js/custom/common.js') }}"></script>
    @if (session('ack_check'))
        <script>
            window.location.href = "{{ route('acknowledge_email', [session('letter_id')]) }}";
        </script>
    @endif
    <script>
        $(document).on('click', '#btn-next', function(e) {
            $('.disabled-link').removeClass('disabled');
            $('.active-link').addClass('disabled');
            var next = $('#custom-tabs-one-tab li.active').next()
            next.length ?
                next.find('a').click() :
                $('#custom-tabs-one-tab li a')[1].click();
        });

        $(document).on('click', '#btn-prev', function(e) {
            $('.disabled-link').addClass('disabled');
            $('.active-link').removeClass('disabled');
            var next = $('#custom-tabs-one-tab li.active').next()
            next.length ?
                next.find('a').click() :
                $('#custom-tabs-one-tab li a')[0].click();
        });




        // $(document).ready(function() {
        //     const $pdfUploadInput = $('#letter');
        //     const $pdfViewer = $('.fileContent');
        //     const $displayButton = $('#display-file-btn');
        //     const $removeBtn = $('#remove-btn');

        //     $pdfUploadInput.on('change', function() {
        //         const file = this.files[0];
        //         if (file) {
        //             const reader = new FileReader();
        //             reader.onload = function(e) {
        //                 const pdfData = e.target.result;
        //                 const $pdfObject = $('<object></object>')
        //                     .attr('data', pdfData)
        //                     .attr('type', 'application/pdf')
        //                     .attr('width', '100%')
        //                     .attr('height', '480px');
        //                 $pdfViewer.empty().append($pdfObject);
        //             };
        //             reader.readAsDataURL(file);
        //             $removeBtn.show();
        //         } else {
        //             $pdfViewer.text('No file selected');
        //         }
        //     });
        //     $(document).on('click', '#view-letter-btn', function() {
        //         if ($('#letter').val() == "") {

        //             $('.fileContent').html('<h5 class="text text-danger">No file selected</h5>');

        //         }

        //     });


        // });

        $(document).on('change','#category',function(){
            if($(this).val() != "10"){
                $.get("{{route('letter_sub_category')}}",{
                category:$(this).val()
                },function(j){

                    var option = "<option value=''>Select Sub Category</option>";
                    for(var i = 1; i < j.length; i++){
                        option += "<option value='"+j[i].category_id+"'>"+j[i].category_name+"</option>";
                    }
                    $('#sub_category').html(option);
                });
            }

        });

        $(document).on('change','#category',function(){
            if($(this).val() == 10 || $(this).val() == 11){
                $('#other_sub_category').attr('type','text');
                $('#sub_category').prop('hidden',true);
                $('#other_sub_category').attr('placeholder',$.trim($("#category option:selected").text()));
            }else{
                $('#other_sub_category').attr('type','hidden');
                $('#sub_category').prop('hidden',false);
            }
        })
    </script>
    <script>
        document.getElementById('letter').addEventListener('change', function (event) {
    const file = event.target.files[0]; // Get the selected file
    const preview = document.getElementById('preview');
    preview.innerHTML = ''; // Clear previous content

    if (file) {
        if (file.type === 'application/pdf') {
            const fileReader = new FileReader();

            fileReader.onload = function (e) {
                const typedArray = new Uint8Array(e.target.result);

                // Load the PDF document
                pdfjsLib.getDocument(typedArray).promise.then(function (pdf) {
                    const totalPages = pdf.numPages;

                    // Render each page
                    for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
                        renderPage(pdf, pageNum, preview);
                    }
                }).catch(function (error) {
                    console.error('Error loading PDF:', error);
                    preview.innerHTML = '<p>Error loading PDF file.</p>';
                });
            };

            fileReader.readAsArrayBuffer(file); // Read the file as an ArrayBuffer
        } else {
            preview.innerHTML = '<p>Please select a valid PDF file.</p>';
        }
    } else {
        preview.innerHTML = '<p>No file selected.</p>';
    }
});

function renderPage(pdf, pageNumber, container) {
    pdf.getPage(pageNumber).then(function (page) {
        const viewport = page.getViewport({ scale: 0.50 });

        // Create a canvas for the page
        const canvas = document.createElement('canvas');
        canvas.classList.add('pdf-page');
        const ctx = canvas.getContext('2d');

        // Set canvas dimensions
        canvas.width = viewport.width;
        canvas.height = viewport.height;

        // Append canvas to container
        container.appendChild(canvas);

        // Render the page on the canvas
        const renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };
        page.render(renderContext);
    }).catch(function (error) {
        console.error(`Error rendering page ${pageNumber}:`, error);
    });
}

    </script>
@endsection
@endsection
