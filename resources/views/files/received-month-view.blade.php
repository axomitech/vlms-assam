@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/month-view.css') }}">

    <div class="col-md-12 text-center mb-3">
        {{-- <button class="btn btn-dark btn-sm" id="resetView" style="float: left;">
            <i class="fa fa-arrow-left"></i> Back
        </button> --}}

        <button class="btn btn-warning btn-sm" id="backToCategories" style="float: right; display: none;"
            onclick="backToCategories()">
            🔙 Back to Categories
        </button>

        <h4><strong>📁 Letter Download (Receipt - By Month)</strong></h4>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    @foreach ($groupedLetters as $categoryId => $subCats)
                        @php
                            $categoryName = $categories[$categoryId] ?? 'Others/Miscellaneous';
                            $safeCategoryId = preg_replace('/[^a-zA-Z0-9_-]/', '', $categoryId);
                        @endphp

                        <div class="folder category-folder" onclick="showCategory('{{ $safeCategoryId }}')">
                            📁 {{ $loop->iteration }}. {{ $categoryName }}
                        </div>

                        <div id="cat-{{ $safeCategoryId }}" class="nested-folder category-content">

                            @foreach ($subCats as $subCategoryId => $years)
                                @php
                                    $subCategoryName =
                                        $subCategories[$subCategoryId] ?? 'Others/Miscellaneous Departments';
                                    $safeSubCategoryId = preg_replace('/[^a-zA-Z0-9_-]/', '', $subCategoryId);
                                @endphp

                                <div class="folder"
                                    onclick="toggleFolder('subcat-{{ $safeCategoryId }}-{{ $safeSubCategoryId }}')">
                                    📂 {{ $subCategoryName }}
                                </div>

                                <div id="subcat-{{ $safeCategoryId }}-{{ $safeSubCategoryId }}" class="nested-folder">
                                    @foreach ($years as $year => $months)
                                        <div class="year-folder"
                                            onclick="toggleFolder('year-{{ $safeSubCategoryId }}-{{ $year }}')">
                                            📅 {{ $year }} — Months: <strong>{{ count($months) }}</strong>
                                        </div>

                                        <div id="year-{{ $safeSubCategoryId }}-{{ $year }}" class="nested-folder">
                                            @foreach ($months as $month => $lettersGroup)
                                                <div class="month-folder"
                                                    onclick="toggleFolder('month-{{ $safeSubCategoryId }}-{{ $year }}-{{ $month }}')">
                                                    🗓️ {{ $month }} — Letters:
                                                    <strong>{{ count($lettersGroup) }}</strong>
                                                </div>

                                                <div id="month-{{ $safeSubCategoryId }}-{{ $year }}-{{ $month }}"
                                                    class="pdf-list">

                                                    <div class="pdf-link">
                                                        <strong>📅 {{ $month }} {{ $year }}</strong>

                                                        <input type="text"
                                                            class="form-control form-control-sm search-input"
                                                            placeholder="🔍 Search Date, Letter No, CRN..."
                                                            onkeyup="filterLetters(this, 'letter-container-{{ $safeSubCategoryId }}-{{ $year }}-{{ $month }}')">

                                                        <a href="{{ route('pdf.merge.month.Issue', [$categoryId, $subCategoryId, $year, $month]) }}"
                                                            class="btn btn-sm btn-outline-primary" target="_blank">📎
                                                            Download Merged PDF</a>
                                                    </div>

                                                    <div
                                                        id="letter-container-{{ $safeSubCategoryId }}-{{ $year }}-{{ $month }}">
                                                        @foreach ($lettersGroup as $index => $letter)
                                                            <div class="letter-row"
                                                                data-group="letters-{{ $safeSubCategoryId }}-{{ $year }}-{{ $month }}"
                                                                data-index="{{ $index }}">

                                                                <div class="letter-info">
                                                                    <span class="letter-date">
                                                                        📅
                                                                        {{ \Carbon\Carbon::parse($letter->received_date)->format('d-m-Y') }}
                                                                    </span>
                                                                    <span class="letter-no">📨
                                                                        {{ $letter->letter_no ?? 'No Letter No' }}</span>
                                                                    <span class="letter-crn">🔖
                                                                        {{ $letter->crn ?? 'No CRN' }}</span>
                                                                    <span class="letter-subcategory">
                                                                        <i class="fa fa-tags text-info"></i>
                                                                        {{ optional($letter->subCategory)->sub_category_name ??
                                                                            ($letter->letter_other_sub_categories ?? 'Others/Miscellaneous Department') }}
                                                                    </span>
                                                                </div>

                                                                <a href="{{ asset(str_replace('public/', 'storage/', $letter->letter_path)) }}"
                                                                    class="btn btn-sm btn-outline-primary"
                                                                    target="_blank">⬇️ Download</a>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="pagination-buttons"
                                                        id="pagination-{{ $safeSubCategoryId }}-{{ $year }}-{{ $month }}">
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    {{-- Include external JS --}}
    <script src="{{ asset('js/month-view.js') }}"></script>
@endsection
