// Toggle children visibility
    function toggleChildren(parentId) {
        const children = document.querySelectorAll('.child-of-' + parentId);
        const icon = document.getElementById('icon-' + parentId);
        
        children.forEach(child => {
            if (child.style.display === 'none') {
                child.style.display = 'table-row';
                icon.classList.remove('rotated');
            } else {
                child.style.display = 'none';
                icon.classList.add('rotated');
            }
        });
    }

    // Expand all children
    function expandAll() {
        document.querySelectorAll('.child-row').forEach(row => {
            row.style.display = 'table-row';
        });
        document.querySelectorAll('.transition-icon').forEach(icon => {
            icon.classList.remove('rotated');
        });
    }

    // Collapse all children
    function collapseAll() {
        document.querySelectorAll('.child-row').forEach(row => {
            row.style.display = 'none';
        });
        document.querySelectorAll('.transition-icon').forEach(icon => {
            icon.classList.add('rotated');
        });
    }

    // Open edit modal with data
    function openEditModal(id, name, isInternal) {
        document.getElementById('editForm').action = '/admin/categories/' + id;
        document.getElementById('editName').value = name;
        document.getElementById('editIsInternal').checked = (isInternal == 1);
    }

    // Initialize: Show all children by default
    document.addEventListener('DOMContentLoaded', function() {
        expandAll();
    });
