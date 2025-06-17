document.addEventListener("DOMContentLoaded", function() {

    function attachModalListeners() {
        // DELETE Modal
        var deleteLinks = document.querySelectorAll(".delete");
        deleteLinks.forEach(function(link) {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                var id = this.getAttribute("data-id");
                var deleteLink = document.getElementById("deleteLink");
                deleteLink.href = 'delete.php?id=' + id;

                var deleteModal = document.getElementById("deleteModal");
                var modal = new bootstrap.Modal(deleteModal);
                modal.show();
            });
        });

        // BLOCK Modal
        var blockLinks = document.querySelectorAll(".block");
        blockLinks.forEach(function(link) {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                var id = this.getAttribute("data-id");
                var blockLink = document.getElementById("blockLink");
                blockLink.href = 'block.php?id=' + id;

                var blockModal = document.getElementById("blockModal");
                var modal = new bootstrap.Modal(blockModal);
                modal.show();
            });
        });

        // UNBLOCK Modal
        var unblockLinks = document.querySelectorAll(".unblock");
        unblockLinks.forEach(function(link) {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                var id = this.getAttribute("data-id");
                var unblockLink = document.getElementById("unblockLink");
                unblockLink.href = 'unblock.php?id=' + id;

                var unblockModal = document.getElementById("unblockModal");
                var modal = new bootstrap.Modal(unblockModal);
                modal.show();
            });
        });
    }

    // Call once for initial load
    attachModalListeners();

    // DataTables initialization

    // Attach again after every redraw
    dataTable.on('draw', function() {
        attachModalListeners();
    });

    // ----------------------------------- MULTI SELECTION ----------------------------------

    function getSelectedIds() {
        var selectedIds = [];
        var checkboxes = document.querySelectorAll('#myTable input[type="checkbox"]');
        var idColumnIndex = -1;
        var headers = document.querySelectorAll('#myTable th');
        for (var i = 0; i < headers.length; i++) {
            if (headers[i].textContent.trim() === 'Name') {
                idColumnIndex = i;
                break;
            }
        }
        checkboxes.forEach(function (checkbox, index) {
            if (index === 0 && checkbox.checked) return;

            if (checkbox.checked) {
                var row = checkbox.closest('tr');
                var cells = row.querySelectorAll('td');
                var nameCell = cells[idColumnIndex];
                var span = nameCell.querySelector('span');
                if (span) {
                    selectedIds.push(span.textContent);
                }
            }
        });
        return selectedIds;
    }

    // Delete Selected
    document.getElementById('deleteSelected').addEventListener('click', function(event) {
        event.preventDefault();
        var selectedIds = getSelectedIds();
        document.getElementById('selectedDeleteIds').value = selectedIds.join(',');
    });

    // Block / Unblock
    var path = window.location.pathname;
    var page = path.split("/").pop();

    if (page == "blocked.php") {
        document.getElementById('unblockSelected').addEventListener('click', function(event) {
            event.preventDefault();
            var selectedIds = getSelectedIds();
            document.getElementById('selectedUnblockIds').value = selectedIds.join(',');
        });
    } else {
        document.getElementById('blockSelected').addEventListener('click', function(event) {
            event.preventDefault();
            var selectedIds = getSelectedIds();
            document.getElementById('selectedBlockIds').value = selectedIds.join(',');
        });
    }

});
