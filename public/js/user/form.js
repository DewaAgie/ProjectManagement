var gambarUploaded = [];
$("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
//
$(".change-role").change(function(){
  $(".leader-cro").hide();
  if ($(this).val() == "CRO") {
    $(".leader-cro").show();
  }else{
    $("#leader_cro").prop("checked",false).change();
  }
});

$("#leader_cro").change(function() {
   if($(this).is(":checked")){
      $(".pilih_staff_cro").show();
      $(".staff_cro").prop("required",true);
   }else{
      $(".pilih_staff_cro").hide();
      $(".staff_cro").removeAttr("required");
      $(".staff_cro").select2();
   }
});

$(".change-role").trigger("change");
if (roleUser == 'Admin') {
  $("#leader_cro").trigger("change");
}

$('#formStaff').submit(function (e) {
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
            $('#formStaff .inputFoto').each(function () {
                if (typeof gambarUploaded[$(this).attr('name')] != 'undefined') {
                    formData.set($(this).attr('name'), gambarUploaded[$(this).attr('name')]);
                }
            });
            var linkProses = $(this).attr('action');
            $.ajax({
                url: linkProses,
                type: 'POST',
                data: formData,
                success: function (data) {
                    Swal.fire(
                        'Proses berhasil',
                        '',
                        'success'
                    )
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
              // if (roleUser == "Admin") {
              //   window.location.href = link + "/users";                
              // }else{
                location.reload();
              // }
            });
        }
    });
});
