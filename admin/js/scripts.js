$(document).ready(function () {
    // Digunakan untuk membuat tatanan tulisan seperti email
    // Editor CKEDITOR
    ClassicEditor
        .create(document.querySelector('#body'))
        .catch(error => {
            console.error(error);
        });
    // Rest of the code
});

// Membuat notofikasi ketika login dan menggunakan checkBoxes dari halaman view_all_post harus sama
// Melakukan check list secara keseluruhan data agar dapat mengubah secara bersamaan data
$(document).ready(function () {
    $('#selectAllBoxes').click(function (event) {
        if (this.checked) {
            $('.checkBoxes').each(function () {
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function () {
                this.checked = false;
            });
        }

    });

    // Untuk menambahkan gambar loading setiap pindah halaman
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("body").prepend(div_box);
    $('#load-screen').delay(700).fadeOut(600, function () {
        $(this).remove();
    });
});


// Melakukan request ke server
function loadUsersOnline() {
    $.get("functions.php?onlineusers=result", function (data) {
        $(".usersonline").text(data);
    });
}

setInterval(function () {
    loadUsersOnline();
}, 500);