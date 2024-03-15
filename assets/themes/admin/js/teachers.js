function filterTeacher(str) {
    if (str == "") {
        document.getElementById("filter_teacher").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("filter_teacher").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","admin/teachers/filterByStatus/"+str,true);
        xmlhttp.send();
    }
}