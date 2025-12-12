document.getElementById('resetView')?.addEventListener('click', function() {
    window.location.href = resetDashboardUrl;
});

function toggleFolder(id) {
    const el = document.getElementById(id);
    if (!el) return;

    const parent = el.parentElement;
    Array.from(parent.children).forEach(child => {
        if ((child.classList.contains('nested-folder') || child.classList.contains('pdf-list')) && child.id !== id) {
            child.style.display = 'none';
        }
    });

    el.style.display = (el.style.display === "none" || el.style.display === "") ? "block" : "none";

    if (el.classList.contains('pdf-list') && el.style.display === "block") {
        const idParts = id.split("-");
        const groupKey = `letters-${idParts[1]}-${idParts[2]}-${idParts[3]}-${idParts[4]}`;
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

document.getElementById("subcategorySearch")?.addEventListener("input", function() {
    const query = this.value.toLowerCase().trim();
    const folders = document.querySelectorAll(".folder.subcat-folder");

    folders.forEach(folder => {
        const text = folder.textContent.toLowerCase();
        const match = text.includes(query);

        folder.style.display = match ? "block" : "none";
        const nested = folder.nextElementSibling;

        if (nested && nested.classList.contains("nested-folder")) {
            nested.style.display = "none";
        }
    });
});

function searchLetters(group, value) {
    const searchTerm = value.toLowerCase().trim();
    const rows = document.querySelectorAll(`[data-group="${group}"]`);

    rows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        row.style.display = rowText.includes(searchTerm) ? 'flex' : 'none';
    });
}
