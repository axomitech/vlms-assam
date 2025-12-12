@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/ministry_letter_download.css') }}">

    <div class="col-md-12 mb-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            {{-- <button class="btn btn-dark btn-sm" id="resetView">
                <i class="fa fa-arrow-left"></i> Back
            </button> --}}

            <h4 class="m-0 flex-grow-1 text-center">
                <strong>📁 Letter Download (Receipt - By Ministry)</strong>
            </h4>

            <input type="text" class="form-control form-control-sm" id="subcategorySearch"
                placeholder="🔍 Search Ministry..." style="max-width: 300px;">
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @php $serial = 1; @endphp

                    @foreach ($groupedLetters as $categoryId => $subCats)
                        @foreach ($subCats as $subCategoryId => $years)
                            @php
                                $subCategoryName = $subCategories[$subCategoryId] ?? 'Others/Miscellaneous Departments';
                                $safeCatId = preg_replace('/[^a-zA-Z0-9_-]/', '', $categoryId);
                                $safeSubcatId = preg_replace('/[^a-zA-Z0-9_-]/', '', $subCategoryId);
                            @endphp

                            <div class="folder subcat-folder"
                                onclick="toggleFolder('subcat-{{ $safeCatId }}-{{ $safeSubcatId }}')">
                                📂 {{ $serial++ }}. {{ $subCategoryName }}
                            </div>

                            <div id="subcat-{{ $safeCatId }}-{{ $safeSubcatId }}" class="nested-folder">
                                @foreach ($years as $year => $months)
                                    <div class="year-folder"
                                        onclick="toggleFolder('year-{{ $safeCatId }}-{{ $safeSubcatId }}-{{ $year }}')">
                                        📁 {{ $year }} — Total Months: {{ count($months) }}
                                    </div>

                                    <div id="year-{{ $safeCatId }}-{{ $safeSubcatId }}-{{ $year }}"
                                        class="nested-folder">
                                        <div class="pdf-link">
                                            <span><strong>📅 Year: {{ $year }}</strong></span>
                                            <a href="{{ route('pdf.merge.Issue', [$categoryId, $subCategoryId, $year]) }}"
                                                class="btn btn-sm btn-outline-success" target="_blank">
                                                📌 Download Year-wise PDF
                                            </a>
                                        </div>

                                        @foreach ($months as $month => $lettersGroup)
                                            @php $safeMonth = preg_replace('/[^a-zA-Z0-9_-]/', '', $month); @endphp
                                            <div class="month-folder"
                                                onclick="toggleFolder('month-{{ $safeCatId }}-{{ $safeSubcatId }}-{{ $year }}-{{ $safeMonth }}')">
                                                <div class="pdf-link mb-2">
                                                    🗓️ {{ $month }} —
                                                    Letters:<strong>{{ count($lettersGroup) }}</strong>
                                                    <a href="{{ route('pdf.merge.month.Issue', [$categoryId, $subCategoryId, $year, $month]) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank"
                                                        style="margin-left: 10px;">
                                                        📌 Download Month-wise PDF
                                                    </a>
                                                </div>
                                            </div>

                                            <div id="month-{{ $safeCatId }}-{{ $safeSubcatId }}-{{ $year }}-{{ $safeMonth }}"
                                                class="pdf-list">

                                                <input type="text" class="form-control form-control-sm search-box"
                                                    placeholder="🔍 Search {{ $month }} {{ $year }}"
                                                    oninput="searchLetters('letters-{{ $safeCatId }}-{{ $safeSubcatId }}-{{ $year }}-{{ $safeMonth }}', this.value)"
                                                    style="max-width: 240px; font-size: 12px; padding: 4px 8px; border: 1px solid #ced4da; border-radius: 4px; margin-bottom: 10px;">

                                                @foreach ($lettersGroup as $index => $letter)
                                                    <div class="letter-row" data-index="{{ $index }}"
                                                        data-group="letters-{{ $safeCatId }}-{{ $safeSubcatId }}-{{ $year }}-{{ $safeMonth }}">
                                                        <div class="letter-info">
                                                            <span class="letter-date">📅
                                                                {{ \Carbon\Carbon::parse($letter->received_date)->format('d-m-Y') }}</span>
                                                            <span class="letter-no">📨
                                                                {{ $letter->letter_no ?? 'No Letter No' }}</span>
                                                            <span class="letter-crn">🔖
                                                                {{ $letter->crn ?? 'No CRN' }}</span>
                                                            <span class="letter-subcategory">
                                                                <i class="fa fa-tags text-info"></i>
                                                                {{ optional($letter->subCategory)->sub_category_name ?? ($letter->letter_other_sub_categories ?? 'Others/Miscellaneous Department') }}
                                                            </span>
                                                        </div>
                                                        <a href="{{ asset(str_replace('public/', 'storage/', $letter->letter_path)) }}"
                                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                                            ⬇️ Download
                                                        </a>
                                                    </div>
                                                @endforeach

                                                <div class="pagination-buttons"
                                                    id="pagination-{{ $safeCatId }}-{{ $safeSubcatId }}-{{ $year }}-{{ $safeMonth }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/ministry_letter_download.js') }}"></script>
@endsection
