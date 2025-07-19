@extends('layouts.app')

@section('content')
    <style>
        .folder,
        .year-folder,
        .month-folder {
            cursor: pointer;
            padding: 10px 16px;
            margin: 6px 0;
            background-color: #f1f1f1;
            border-radius: 6px;
            font-weight: 500;
        }

        .nested-folder {
            margin-left: 20px;
            display: none;
        }

        .pdf-list {
            margin-left: 40px;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .pdf-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #eef;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 6px;
            gap: 10px;
        }

        .letter-row {
            display: none;
            justify-content: space-between;
            align-items: center;
            padding: 6px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 5px;
        }

        .letter-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
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

        .folder:hover,
        .year-folder:hover,
        .month-folder:hover {
            background-color: #e0e0ff;
        }

        .pagination-buttons {
            margin-top: 10px;
        }

        .pagination-buttons button {
            margin-right: 5px;
            padding: 4px 10px;
            font-size: 13px;
        }

        .search-input {
            width: 200px;
        }

        @media (max-width: 768px) {
            .letter-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }

            .pdf-link {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-input {
                width: 100%;
            }
        }
    </style>

    <div class="col-md-12 text-center mb-3">
        <button class="btn btn-dark btn-sm" id="resetView" style="float: left;">
            <i class="fa fa-arrow-left"></i> Back
        </button>

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
                            $categoryName = $categories[$categoryId] ?? 'Unknown Category';
                            $serial = $loop->iteration;
                            $safeCatId = preg_replace('/[^a-zA-Z0-9_-]/', '', $categoryId);
                        @endphp

                        <div class="folder category-folder" onclick="showCategory('{{ $safeCatId }}')">
                            📁 {{ $serial }}. {{ $categoryName }}
                        </div>

                        <div id="cat-{{ $safeCatId }}" class="nested-folder category-content">
                            @foreach ($subCats as $subCategoryId => $years)
                                @php
                                    $subCategoryName =
                                        $subCategories[$subCategoryId] ?? 'Others/Miscellaneous Departments';
                                    $safeSubcatId = preg_replace('/[^a-zA-Z0-9_-]/', '', $subCategoryId);
                                @endphp

                                <div class="folder"
                                    onclick="toggleFolder('subcat-{{ $safeCatId }}-{{ $safeSubcatId }}')">
                                    📂 {{ $subCategoryName }}
                                </div>

                                <div id="subcat-{{ $safeCatId }}-{{ $safeSubcatId }}" class="nested-folder">
                                    @foreach ($years as $year => $months)
                                        <div class="year-folder"
                                            onclick="toggleFolder('year-{{ $safeSubcatId }}-{{ $year }}')">
                                            📅 {{ $year }} — Months: <strong>{{ count($months) }}</strong>
                                        </div>

                                        <div id="year-{{ $safeSubcatId }}-{{ $year }}" class="nested-folder">
                                            @foreach ($months as $month => $lettersGroup)
                                                <div class="month-folder"
                                                    onclick="toggleFolder('month-{{ $safeSubcatId }}-{{ $year }}-{{ $month }}')">
                                                    🗓️ {{ $month }} — Letters:
                                                    <strong>{{ count($lettersGroup) }}</strong>
                                                </div>

                                                <div id="month-{{ $safeSubcatId }}-{{ $year }}-{{ $month }}"
                                                    class="pdf-list">
                                                    <div class="pdf-link">
                                                        <span><strong>🗂️ {{ $month }}
                                                                {{ $year }}</strong></span>

                                                        <input type="text"
                                                            class="form-control form-control-sm search-input"
                                                            placeholder="🔍 Search Date, No, CRN, Dept..."
                                                            onkeyup="filterLetters(this, 'letter-container-{{ $safeSubcatId }}-{{ $year }}-{{ $month }}')">

                                                        <a href="{{ route('pdf.merge.month', [$categoryId, $subCategoryId, $year, $month]) }}"
                                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                                            📎 Download Merged PDF
                                                        </a>
                                                    </div>

                                                    <div
                                                        id="letter-container-{{ $safeSubcatId }}-{{ $year }}-{{ $month }}">
                                                        @foreach ($lettersGroup as $index => $letter)
                                                            <div class="letter-row"
                                                                data-group="letters-{{ $safeSubcatId }}-{{ $year }}-{{ $month }}"
                                                                data-index="{{ $index }}">
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
                                                    </div>

                                                    <div class="pagination-buttons"
                                                        id="pagination-{{ $safeSubcatId }}-{{ $year }}-{{ $month }}">
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

    <script>
        document.getElementById('resetView').addEventListener('click', function() {
            window.location.href = "{{ route('dashboard') }}";
        });

        function showCategory(categoryId) {
            document.querySelectorAll('.category-folder').forEach(folder => folder.style.display = 'none');
            document.querySelectorAll('.category-content').forEach(content => content.style.display = 'none');
            const target = document.getElementById('cat-' + categoryId);
            if (target) target.style.display = 'block';
            document.getElementById('backToCategories').style.display = 'inline-block';
        }

        function backToCategories() {
            document.querySelectorAll('.category-folder').forEach(folder => folder.style.display = 'block');
            document.querySelectorAll('.category-content').forEach(content => content.style.display = 'none');
            document.getElementById('backToCategories').style.display = 'none';
        }

        function toggleFolder(id) {
            const el = document.getElementById(id);
            if (!el) {
                console.warn('Element not found:', id);
                return;
            }

            const parent = el.parentElement;

            Array.from(parent.children).forEach(child => {
                if ((child.classList.contains('nested-folder') || child.classList.contains('pdf-list')) && child
                    .id !== id) {
                    child.style.display = 'none';
                }
            });

            el.style.display = (el.style.display === "none" || el.style.display === "") ? "block" : "none";

            if (id.startsWith('month-') && el.style.display === "block") {
                const parts = id.split("-");
                const groupKey = `letters-${parts[1]}-${parts[2]}-${parts[3]}`;
                paginateLetters(groupKey, 0);
            }
        }

        function paginateLetters(group, page) {
            const rows = document.querySelectorAll(`[data-group="${group}"]`);
            const containerId = "pagination-" + group.split("letters-")[1];
            const perPage = 25;
            const total = rows.length;
            const totalPages = Math.ceil(total / perPage);

            rows.forEach(row => row.style.display = 'none');

            for (let i = page * perPage; i < (page + 1) * perPage && i < total; i++) {
                rows[i].style.display = 'flex';
            }

            const paginationContainer = document.getElementById(containerId);
            paginationContainer.innerHTML = '';

            for (let i = 0; i < totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = 'btn btn-sm btn-outline-dark';
                btn.innerText = `${i * perPage + 1} - ${Math.min((i + 1) * perPage, total)}`;
                btn.onclick = () => paginateLetters(group, i);
                paginationContainer.appendChild(btn);
            }
        }

        function filterLetters(input, containerId) {
            const value = input.value.toLowerCase();
            const container = document.getElementById(containerId);
            const rows = container.querySelectorAll('.letter-row');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(value) ? 'flex' : 'none';
            });

            const paginationId = "pagination-" + containerId.split("letter-container-")[1];
            const pagination = document.getElementById(paginationId);
            pagination.style.display = value.trim() ? 'none' : 'block';

            if (!value.trim()) {
                const groupKey = "letters-" + containerId.split("letter-container-")[1];
                paginateLetters(groupKey, 0);
            }
        }
    </script>
@endsection
