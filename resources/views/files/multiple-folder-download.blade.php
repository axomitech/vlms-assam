@extends('layouts.app')

@section('content')
    <style>
        .folder {
            cursor: pointer;
            padding: 12px 16px;
            margin: 6px 0;
            background-color: #f8f9fa;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .folder:hover {
            background-color: #e2e6ea;
        }

        .nested-folder {
            padding-left: 25px;
            display: none;
        }

        .year-folder {
            cursor: pointer;
            padding: 10px 16px;
            background-color: #e9f7ef;
            border-radius: 5px;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .pdf-list {
            margin-left: 30px;
            padding: 10px 15px;
            border-left: 2px solid #ccc;
            display: none;
        }

        .pdf-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .pdf-link span {
            flex: 1;
            font-size: 14px;
        }

        .pdf-link a {
            text-decoration: none;
            font-size: 13px;
        }

        .btn-outline-primary {
            padding: 3px 8px;
            font-size: 13px;
        }

        h2 {
            margin-bottom: 25px;
        }

        .letter-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            margin-bottom: 8px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .letter-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .letter-info span {
            display: inline-block;
        }

        .letter-date {
            min-width: 120px;
        }

        .letter-no {
            min-width: 160px;
        }

        .letter-crn {
            width: 180px;
        }

        .download-btn {
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .letter-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }

            .letter-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .download-btn {
                margin-top: 5px;
            }
        }
    </style>

    <div class="col-md-12 text-center">
        <button class="btn btn-dark btn-sm" id="resetView" style="float: left;">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </button>
        <h4><strong>📁 Letter Download (Issue - By Year)</strong></h4>
    </div>

    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 ">
                        @foreach ($letters as $categoryId => $subCatGroup)
                            @php
                                $categoryName = $categories[$categoryId] ?? 'Unknown Category';
                                $serial = $loop->iteration;
                            @endphp

                            <div class="folder" onclick="toggleFolder('category-{{ $categoryId }}')">
                                📁 <strong>{{ $serial }}. {{ $categoryName }}</strong>
                            </div>

                            <div id="category-{{ $categoryId }}" class="nested-folder">
                                @foreach ($subCatGroup as $subCategoryId => $years)
                                    @php $subCategoryName = $subCategories[$subCategoryId] ?? 'Unknown Subcategory'; @endphp

                                    <div class="folder"
                                        onclick="toggleFolder('subcategory-{{ $categoryId }}-{{ $subCategoryId }}')">
                                        📁 {{ $subCategoryName }}
                                    </div>

                                    <div id="subcategory-{{ $categoryId }}-{{ $subCategoryId }}" class="nested-folder">
                                        <div id="subcat-{{ $categoryId }}-{{ $subCategoryId }}">
                                            @foreach ($years as $year => $lettersGroup)
                                                <div class="year-folder"
                                                    onclick="toggleFolder('year-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}')">
                                                    📁 {{ $year }} — Total Letters:
                                                    <strong>{{ count($lettersGroup) }}</strong>
                                                </div>

                                                <div id="year-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}"
                                                    class="pdf-list">
                                                    <div class="pdf-link">
                                                        <span><strong>📅 Year: {{ $year }}</strong></span>
                                                        <a href="{{ route('pdf.merge.Issue', [$categoryId, $subCategoryId, $year]) }}"
                                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                                            ⬇️ Download Merged PDF
                                                        </a>
                                                    </div>

                                                    @php $count = 0; @endphp
                                                    @foreach ($lettersGroup as $letter)
                                                        @if ($count >= 12)
                                                            @break
                                                        @endif
                                                        <div class="letter-row">
                                                            <div class="letter-info">
                                                                <span class="letter-date">📅
                                                                    {{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}</span>
                                                                <span class="letter-no">📨
                                                                    {{ $letter->letter_no ?? 'No Letter No' }}</span>
                                                                <span class="letter-crn">🔖
                                                                    {{ $letter->crn ?? 'No CRN' }}</span>
                                                            </div>

                                                            <a href="{{ asset(str_replace('public/', 'storage/', $letter->letter_path)) }}"
                                                                class="btn btn-sm btn-outline-primary download-btn"
                                                                target="_blank">
                                                                ⬇️ Download
                                                            </a>
                                                        </div>
                                                        @php $count++; @endphp
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Back button click redirect to dashboard
        document.getElementById('resetView').addEventListener('click', function() {
            window.location.href = "{{ route('dashboard') }}";
        });

        // Toggle folder view
        function toggleFolder(id) {
            const el = document.getElementById(id);
            el.style.display = (el.style.display === "none" || el.style.display === "") ? "block" : "none";
        }
    </script>
@endsection
