@extends('layouts.app')

@section('content')
    {{-- External CSS --}}
    <link rel="stylesheet" href="{{ asset('css/view.css') }}">

    <div class="col-md-12 text-center">
        {{-- <button class="btn btn-dark btn-sm" id="resetView" style="float: left;">
            <i class="fa fa-arrow-left"></i> Back
        </button> --}}
        <h4><strong>📁 Letter Download (Receipt - By Year)</strong></h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="col-md-12" id="category-section">

                        @foreach ($letters as $categoryId => $subCatGroup)
                            @php
                                $categoryName = $categories[$categoryId] ?? 'Others/Miscellaneous';
                            @endphp

                            {{-- CATEGORY BUTTON --}}
                            <div class="category-wrapper" id="category-wrapper-{{ $categoryId }}">
                                <div class="folder" onclick="openCategory('{{ $categoryId }}')">
                                    📁 <strong>{{ $loop->iteration }}. {{ $categoryName }}</strong>
                                </div>
                            </div>

                            {{-- CATEGORY CONTENT --}}
                            <div id="category-{{ $categoryId }}" class="nested-folder category-content">

                                <div class="d-flex justify-content-end mb-3">
                                    <button class="btn btn-dark btn-sm"
                                        onclick="goBackToCategories('{{ $categoryId }}')">🔙 Back</button>
                                </div>

                                @foreach ($subCatGroup as $subCategoryId => $years)
                                    @php
                                        $subCategoryName =
                                            $subCategories[$subCategoryId] ?? 'Others/Miscellaneous Department';
                                    @endphp

                                    {{-- SUB CATEGORY --}}
                                    <div class="folder"
                                        onclick="toggleSubCategory('{{ $categoryId }}', '{{ $subCategoryId }}')">
                                        📁 {{ $subCategoryName }}
                                    </div>

                                    <div id="subcategory-{{ $categoryId }}-{{ $subCategoryId }}" class="nested-folder">

                                        @foreach ($years as $year => $lettersGroup)
                                            {{-- YEAR --}}
                                            <div class="year-folder"
                                                onclick="toggleFolder('year-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}')">
                                                📁 {{ $year }} — Total Letters:
                                                <strong>{{ count($lettersGroup) }}</strong>
                                            </div>

                                            <div id="year-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}"
                                                class="pdf-list">

                                                <div class="pdf-link">
                                                    <span><strong>📅 Year: {{ $year }}</strong></span>

                                                    <input type="text"
                                                        class="form-control form-control-sm w-25 d-inline-block mx-2 search-input"
                                                        placeholder="🔍 Search by Date, Letter No, CRN or Subcategory"
                                                        onkeyup="filterLetters(this, 'letter-container-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}')">

                                                    <a href="{{ route('pdf.merge', [$categoryId, $subCategoryId, $year]) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                                        ⬇️ Download Merged PDF
                                                    </a>
                                                </div>

                                                {{-- LETTER LIST --}}
                                                <div
                                                    id="letter-container-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}">

                                                    @foreach ($lettersGroup as $index => $letter)
                                                        <div class="letter-row" data-index="{{ $index }}"
                                                            data-group="letters-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}">

                                                            <div class="letter-info">
                                                                <span class="letter-date">📅
                                                                    {{ \Carbon\Carbon::parse($letter->received_date)->format('d-m-Y') }}</span>

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
                                                                class="btn btn-sm btn-outline-primary download-btn"
                                                                target="_blank">
                                                                ⬇️ Download
                                                            </a>
                                                        </div>
                                                    @endforeach

                                                </div>

                                                {{-- PAGINATION --}}
                                                <div class="pagination-buttons"
                                                    id="pagination-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}">
                                                </div>

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
    </div>
@endsection


<script>
    const resetRoute = "{{ route('dashboard') }}";
</script>


<script src="{{ asset('js/view.js') }}"></script>
