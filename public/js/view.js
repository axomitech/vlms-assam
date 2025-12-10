document.getElementById('resetView').addEventListener('click', function() {
    window.location.href = resetRoute;
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
        if ((child.classList.contains('nested-folder') || child.classList.contains('pdf-list')) && child.id !== id) {
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

    let visibleCount = 0;

    letterRows.forEach(row => {
        const textContent = row.innerText.toLowerCase();
        if (textContent.includes(filterText)) {
            row.style.display = 'flex';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    const paginationId = 'pagination-' + containerId.split("letter-container-")[1];
    const pagination = document.getElementById(paginationId);
    pagination.style.display = (filterText.trim() !== "") ? 'none' : 'block';

    if (filterText.trim() === "") {
        const groupKey = 'letters-' + containerId.split("letter-container-")[1];
        paginateLetters(groupKey, 0);
    }
}
