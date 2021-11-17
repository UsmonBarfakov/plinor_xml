let basUrl = 'http://plinor_xml/';

function deleteFile(id, rowId)
{
    //get confirmation before delete
    if(!confirm('Удалить файл?')) {
        return
    }
    //send AJAX request for delete to API with callback function
    sendAJAX(basUrl+'index.php/api', { "id": id, "method": "delete"}, function (str) {
        let response = JSON.parse(this.responseText);
        alert(response.message);
        removeRow(rowId);
    });
}

function removeRow(rowNum)
{
    document.getElementById("filesTable").deleteRow(rowNum);
}

function sendAJAX(url, data, callBack = null)
{
    let xhttp = new XMLHttpRequest();
    if (callBack) {
        xhttp.onload = callBack;
    }
    xhttp.open("POST", url);
    xhttp.setRequestHeader("Content-type", "application/json;charset=UTF-8");
    if (data) {
        xhttp.send(JSON.stringify(data));
    } else {
        xhttp.send();
    }
}

function sortTable(n) {
    let table, rows, switching, i, x, y, shouldSwitch, dir, switchCount = 0;
    table = document.getElementById("filesTable");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
            // Start by saying there should be no switching:
            shouldSwitch = false;
            /* Get the two elements you want to compare,
            one from current row and one from the next: */
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /* Check if the two rows should switch place,
            based on the direction, asc or desc: */
            if (dir === "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir === "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /* If a switch has been marked, make the switch
            and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchCount ++;
        } else {
            /* If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again. */
            if (switchCount === 0 && dir === "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}