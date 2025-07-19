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

        .letter-row {
            display: none;
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

        .letter-date {
            min-width: 120px;
        }

        .letter-no {
            min-width: 160px;
        }

        .letter-crn {
            width: 180px;
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
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 13px;
            width: 250px;
        }

        @media (max-width: 768px) {
            .letter-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }

            .search-input {
                width: 100%;
                margin-top: 8px;
            }
        }
    </style>

    <div class="col-md-12 text-center">
        <button class="btn btn-dark btn-sm" id="resetView" style="float: left;">
            <i class="fa fa-arrow-left"></i> Back
        </button>
        <h4><strong>📁 Letter Download (Receipt - By Year)</strong></h4>
    </div>

    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12" id="category-section">
                        @foreach ($letters as $categoryId => $subCatGroup)
                            @php $categoryName = $categories[$categoryId] ?? 'Others/Miscellaneous '; @endphp

                            <div class="category-wrapper" id="category-wrapper-{{ $categoryId }}">
                                <div class="folder" onclick="openCategory('{{ $categoryId }}')">
                                    📁 <strong>{{ $loop->iteration }}. {{ $categoryName }}</strong>
                                </div>
                            </div>

                            <div id="category-{{ $categoryId }}" class="nested-folder category-content">
                                <div class="d-flex justify-content-end mb-3">
                                    <button class="btn btn-dark btn-sm"
                                        onclick="goBackToCategories('{{ $categoryId }}')">🔙 Back</button>
                                </div>

                                @foreach ($subCatGroup as $subCategoryId => $years)
                                    @php $subCategoryName = $subCategories[$subCategoryId] ?? 'Others/Miscellaneous Departments'; @endphp

                                    <div class="folder"
                                        onclick="toggleSubCategory('{{ $categoryId }}', '{{ $subCategoryId }}')">
                                        📁 {{ $subCategoryName }}
                                    </div>

                                    <div id="subcategory-{{ $categoryId }}-{{ $subCategoryId }}" class="nested-folder">
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
                                                    <input type="text"
                                                        class="form-control form-control-sm search-input mx-2"
                                                        placeholder="🔍 Search Date, Letter No, CRN..."
                                                        onkeyup="filterLetters(this, 'letter-container-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}')">
                                                    <a href="{{ route('pdf.merge', [$categoryId, $subCategoryId, $year]) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                                        ⬇️ Download Merged PDF
                                                    </a>
                                                </div>

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
                                                                    {{ optional($letter->subCategory)->sub_category_name ?? ($letter->letter_other_sub_categories ?? 'Others/Miscellaneous Department') }}
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

    <script>
        document.getElementById('resetView').addEventListener('click', function() {
            window.location.href = "{{ route('dashboard') }}";
        });

        function openCategory(categoryId) {
            document.querySelectorAll('.category-wrapper').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.category-content').forEach(el => el.style.display = 'none');
            document.getElementById('category-' + categoryId).style.display = 'block';
            document.getElementById('resetView').style.display = 'none';
        }

        function goBackToCategories(categoryId) {
            document.querySelectorAll('.category-wrapper').forEach(el => el.style.display = 'block');
            document.getElementById('category-' + categoryId).style.display = 'none';
            document.getElementById('resetView').style.display = 'inline-block';
        }

        function toggleSubCategory(catId, subCatId) {
            const parent = document.getElementById('category-' + catId);
            Array.from(parent.querySelectorAll('.nested-folder')).forEach(child => {
                if (child.id.startsWith('subcategory-') && child.id !== `subcategory-${catId}-${subCatId}`) {
                    child.style.display = 'none';
                }
            });
            const el = document.getElementById(`subcategory-${catId}-${subCatId}`);
            el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
        }

        function toggleFolder(id) {
            const el = document.getElementById(id);
            const parent = el.parentElement;

            Array.from(parent.children).forEach(child => {
                if ((child.classList.contains('nested-folder') || child.classList.contains('pdf-list')) && child
                    .id !== id) {
                    child.style.display = 'none';
                }
            });

            el.style.display = (el.style.display === "none" || el.style.display === "") ? "block" : "none";

            if (el.style.display === "block") {
                const yearParts = id.split("-");
                const groupKey = `letters-${yearParts[1]}-${yearParts[2]}-${yearParts[3]}`;
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

        function filterLetters(inputElement, containerId) {
            const filterText = inputElement.value.toLowerCase();
            const container = document.getElementById(containerId);
            const letterRows = container.querySelectorAll('.letter-row');

            letterRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(filterText) ? 'flex' : 'none';
            });

            const paginationId = 'pagination-' + containerId.split("letter-container-")[1];
            const pagination = document.getElementById(paginationId);
            pagination.style.display = filterText.trim() ? 'none' : 'block';

            if (!filterText.trim()) {
                const groupKey = 'letters-' + containerId.split("letter-container-")[1];
                paginateLetters(groupKey, 0);
            }
        }
    </script>
@endsection
