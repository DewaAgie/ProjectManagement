$('.btn-modal-tim').click(function () {
    showFormTim();
});

function showFormTim(id = 0) {
    if (id != 0) {
        Swal.fire({
            title: 'Loading data..',
            html: '',
            allowOutsideClick: false,
            onOpen: () => {
                swal.showLoading()
            }
        });
        $.getJSON(link + "/tim/jsonDetailTim?id=" + id, function (data) {
            Swal.close();
            $('#id_tim').val(data.idTim);
            $('#id_programmer').val(data.idUser);
            $('#id_project').val(data.idProject);
            $('.modal-tim').modal();
        });
    } else {
        $('#id_tim').val();
        $('#id_programmer').val();
        $('#id_project').val();
        $('.modal-tim').modal();
    }
}

$('#form_tim').on("submit", function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Apa anda Yakin?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: 'Loading..',
                html: '',
                allowOutsideClick: false,
                onOpen: () => {
                    swal.showLoading()
                }
            });
            var formData = new FormData(this);
            var linkProses = $(this).attr('action');
            $.ajax({
                url: linkProses,
                type: 'POST',
                data: formData,
                success: function (data) {
                    if (data.error) {
                        Swal.fire(
                            data.message,
                            '',
                            'error'
                        )
                    } else {
                        Swal.fire(
                            data.message,
                            '',
                            'success'
                        )
                    }
                },
                error: function (xhr, textStatus, error) {
                    // var w = window.open();
                    // var html = xhr.responseText;
                    // $(w.document.body).html(html);
                    Swal.fire(
                        'Proses gagal',
                        '',
                        'error'
                    );
                },
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
            }).done(function () {
                cariTim();
                $('.modal-tim').modal("toggle");
            });
        }
    });
});

$('.modal-tim').on('hidden.bs.modal', function () {
    $('input[name="id_tim"]').val("");
    $('input[name="nama_tim"]').val("");
    $('input[name="harga_tim"]').val("");
    $('input[name="persentase"]').val("");
});


// list Tim
var pageTotal = 0;
var pageAktif = 0;
var pageCount = 0;
var jumlahSeluruh = 0;
var indexContent = 0;

$(document).ready(function () {
    loadList();
    $('[data-toggle="tooltip"]').tooltip();
});

function setPaging(show, between) {
    // show : itu buat nampilin di awal atau akhirnya mau tampil berapa
    // contoh : show = 5 ( 1,2,3,4,5,...,20 ) atau (1,...,16,17,18,19,20)
    // between : untuk ngasik tiap kiri dan kanan berapa index kalau ditengah
    // contoh : between = 2 (1,...,6,7,[8],9,10,...,20)
    between = parseInt(between + 1);
    var txt = "";
    txt += `<div class="btn-group">`;
    txt = txt + "<button type='button' class='btn btn-secondary btn-sm' onclick='pervPage();'><i class='fa fa-chevron-left'></i></button>";
    if (pageAktif < (parseInt(show) - 1) || pageAktif == (parseInt(show) - 1) && pageTotal <= pageAktif) {
        for (var i = 0; i < (pageTotal); i++) {
            if (i < parseInt(show)) {
                txt = txt + "<button type='button' class='btn ";
                if (i == pageAktif) {
                    txt = txt + "btn-info ";
                } else {
                    txt = txt + "btn-secondary ";
                }
                txt = txt + "btn-sm' onclick='pageGanti(" + i + ")'>" + (i + 1) + "</button>";
            }
        }
        if (pageTotal > parseInt(show)) {
            txt = txt + "<button type='button' class='btn btn-secondary btn-sm'>...</button>";
            txt = txt + "<button type='button' class='btn btn-secondary btn-sm' onclick='pageGanti(" + (pageTotal - 1) + ")'>" + (pageTotal) + "</button>";
        }
    } else if (pageAktif - ((pageTotal) - parseInt(show)) > 0) {
        txt = txt + "<button type='button' class='btn btn-secondary btn-sm' onclick='pageGanti(0)'>1</button>";
        txt = txt + "<button type='button' class='btn btn-secondary btn-sm'>...</button>";
        for (var i = 0; i < (pageTotal); i++) {
            if (i > ((pageTotal - 1) - parseInt(show))) {
                txt = txt + "<button type='button' class='btn ";
                if (i == pageAktif) {
                    txt = txt + "btn-info ";
                } else {
                    txt = txt + "btn-secondary ";
                }
                txt = txt + "btn-sm' onclick='pageGanti(" + i + ")'>" + (i + 1) + "</button>";
            }
        }
    } else {
        txt = txt + "<button type='button' class='btn btn-secondary btn-sm' onclick='pageGanti(0)'>1</button>";
        txt = txt + "<button type='button' class='btn btn-secondary btn-sm'>...</button>";
        for (var i = 0; i < (pageTotal); i++) {
            if (i > (pageAktif - between) && i < (pageAktif + between)) {
                txt = txt + "<button type='button' class='btn ";
                if (i == pageAktif) {
                    txt = txt + "btn-info ";
                } else {
                    txt = txt + "btn-secondary ";
                }
                txt = txt + "btn-sm' onclick='pageGanti(" + i + ")'>" + (i + 1) + "</button>";
            }
        }
        txt = txt + "<button type='button' class='btn btn-secondary btn-sm'>...</button>";
        txt = txt + "<button type='button' class='btn btn-secondary btn-sm' onclick='pageGanti(" + (pageTotal - 1) + ")'>" + (pageTotal) + "</button>";
    }

    txt = txt + "<button type='button' class='btn btn-secondary btn-sm' onclick='nextPage();'><i class='fa fa-chevron-right'></i></button>";
    txt += `</div>`;
    txt = txt + "<select class='select2 jumpPage form-control form-control-sm' onchange='changePage(this)' style='width:60px;'>";
    for (var j = 0; j < pageTotal; j++) {
        var selectedPage = '';
        if (j == pageAktif) {
            selectedPage = 'selected';
        }
        txt = txt + "<option value='" + j + "' " + selectedPage + ">" + (j + 1) + "</option>";
    }
    txt = txt + "</select>";
    $('#btnPaging1').html(txt);
    $('#btnPaging2').html(txt);
    $('.select2').select2();
}

$(document).keypress(function (e) {
    if (e.which == 13) {
        // $('#buttonSearchnya').focus();
        pageCount = 0;
        pageAktif = 0;
        loadList();
    }
});

function pageGanti(index) {
    pageAktif = index;
    pageCount = index;
    loadList(index);
}

function changePage(e) {
    pageGanti(parseInt($(e).val()));
}


function pervPage() {
    if (pageCount != 0) {
        pageAktif--;
        pageCount = pageCount - 1;
        loadList();
    }
}

function nextPage() {
    if (indexContent != jumlahSeluruh) {
        pageAktif++;
        pageCount = pageCount + 1;
        loadList();
    }
}

function pageIndex(index) {
    pageAktif = index;
    pageCount = index;
    loadList();
}

function cariTim() {
    pageAktif = 0;
    pageCount = 0;
    loadList();
}

function pageShow(index) {
    pageAktif = index;
    pageCount = index;
    loadList();
}


function loadList() {
    $('.tableTim').loading('toggle');
    var txt = "";
    page = pageCount;
    var no = (parseInt(page) * 20) + 1;
    var awal = no;
    var cari = $('#cariTim').val();
    let project = $("#project").val();
    $.getJSON(link + '/tim/jsonListTim?page=' + page + "&search=" + cari + "&project=" + project, function (data) {
        jumlahSeluruh = data[0];
        pageTotal = parseInt(Math.ceil(jumlahSeluruh / 20));
        $.each(data[1], function (key, val) {
            txt += `<tr>
            <td align="left">${no}</td>
            <td align="left"><a href="#!" onclick="showFormPaket(${val.idTeam})">${val.namaUser}</a></td>
            <td align="left">${val.namaProject}</td>`;
            if (roleUser == 'Admin') {
                txt += `
                <td align="left">
                <a href="#!" onclick="showFormTim(${val.idTeam})" class="text-primary" data-placement="top" data-toggle="tooltip" title="Edit">
                <i class="ti-marker-alt"></i>
                </a>
                <a href="#!" onclick="deleteTim(${val.idTeam})" class="text-danger" data-placement="top" title="Delete" data-toggle="tooltip">
                <i class="ti-trash"></i>
                </a>
              </td>
              `
            }
            txt += `</tr>`;
            indexContent = no;
            no++;
        });
    }).done(function () {
        $('#displayPage').html((awal) + '-' + indexContent + '/' + jumlahSeluruh);
        $('#displayPage2').html((awal) + '-' + indexContent + '/' + jumlahSeluruh);
        $('#tbodyListTim').html(txt);
        $('.tableTim').loading('toggle');
        // $('[data-toggle="tooltip"]').tooltip();
        setPaging(5, 2);
        if (jumlahSeluruh == 0) {
            $('#tbodyListTim').html("<td colspan='5'><center>Data tidak ditemukan</center></td>");
        }
    });
}

function deleteTim(id) {
    Swal.fire({
        title: 'Apa anda Yakin?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: 'Loading..',
                html: '',
                allowOutsideClick: false,
                onOpen: () => {
                    swal.showLoading()
                }
            });
            $.getJSON(link + "/tim/deleteTim?id=" + id, function (data) {
                if (data.error) {
                    Swal.fire(
                        data.message,
                        '',
                        'error'
                    )
                } else {
                    Swal.fire(
                        data.message,
                        '',
                        'success'
                    )
                }
                cariTim();
            }).fail(function () {
                Swal.fire(
                    'Proses gagal',
                    '',
                    'error'
                );
                cariTim();
            });
        }
    });
}
