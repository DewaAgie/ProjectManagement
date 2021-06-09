

 
 function changeUserDashboard() {
    $('.users-title').hide();
    $('.pick-users').show();
    $('.listStaff').select2('open');
  }

    function loadDashboard(){
      $('.users-title').show();
      $('.pick-users').hide();
      var id = $('.listStaff').val();
      $.getJSON(link+"/users/jsonDetailStaff/"+id, function(data){
        var linkFoto = link+"/img/user-icon.png";
        if(data.foto != null){
          linkFoto = link+"/uploadgambar/"+data.foto;
        }
        $('.user_role').html(data.role);
        $('.user_name').html(data.name);
        $('.user_profile').attr('src',linkFoto);
        $('.user_profile_url').attr('href',linkFoto);
        $('.user_email').html(data.email);
        $('.user_telepon').html(data.noTelp);
        $('.user_detail_href').attr('href',link+"/users/form?id="+data.id);
        $('.user_sgm_code').html(data.salesCode);
        loadRequest();
        $('.fancybox').fancybox();
      });

    }

    function sum(obj) {
      return Object.keys(obj).reduce((sum,key)=>sum+parseFloat(obj[key]||0),0);
    }
    

    $("#min-date, #min-date2, #min-date3, #min-date4, #periode-staff, #periode-rekap").datepicker( {
        format: "M yyyy",
        viewMode: "months", 
        minViewMode: "months"
    }).on('changeDate', function (ev) {
        $(this).blur();
        $(this).datepicker('hide');
        setDateValue(ev.date);
        loadRequest();
        cariStaff();
        loadRekapCro(changeFormatDateToMonth($("#periode-rekap-kirim").val()), $("#status-rekap-kirim").val())
    });

    function setDateValue(date){
      $("#min-date").datepicker("update", date);
      $("#min-date2").datepicker("update", date);
      $("#min-date3").datepicker("update", date);
      $("#periode-staff").datepicker("update", date);
      $("#periode-rekap").datepicker("update", date);
      $("#timepicker").val(changeFormatDateToMonth(new Date(date)));
      $("#timepicker2").val(changeFormatDateToMonth(new Date(date)));
      $("#timepicker3").val(changeFormatDateToMonth(new Date(date)));
      $("#periode-rekap-kirim").val(changeFormatDateToMonth(new Date(date)));
      $("#periode-staff-kirim").val(changeFormatDateToMonth(new Date(date)));      
    }

    $("#select-status-rekap-kirim").change(function() {
      $("#status-rekap-kirim").val($(this).val())
      loadRekapCro($("#periode-rekap-kirim").val(), $(this).val())
    })

    $("#statusActive2").change(function() {
      $("#status-rekap-kirim").val($(this).val())
      loadRekapCro($("#periode-rekap-kirim").val(), $("#select-status-rekap-kirim").val())
    })

    function changeFormatDateToMonth(date){
      var date = new Date(date);
      var month = date.getMonth()+1;
      if(month < 10){
        month = "0"+month;
      }
      var year = date.getFullYear();
      return year+'-'+month;      
    }

    function loadRequest(){
      var id = $('.listStaff').val();
      var periode = $("#timepicker2").val();
      $.getJSON(link+"/request/loadRequestUser?id="+id+"&periode="+periode, function(data){
        $(".requestBaru").html(data.requestBaru);
        $(".sedangDikerjakan").html(data.sedangDikerjakan);
        $(".requestTerselesaikan").html(data.requestTerselesaikan);
        $(".d-bonus").html(data.bonus);

        updateListRequest(data.data);
      });
    }

    function updateListRequest(data){
      let text = ``;
      $.each(data, (key, value) => {
        text+= `
          <li>
            <a href="${link}/request/add?id=${value.idRequest}">
              <p>
                <span>${value.judulRequest}</span>
              </p>
            </a>
          </li>
        `;
      })

      $('#requestSedangDikerjakan').html(text);
    }



var pageTotal = 0;
var pageAktif = 0;
var pageCount = 0;
var jumlahSeluruh = 0;
var indexContent = 0;
var orderedBY  = "";

$(document).ready(function(){
    // loadListStaff();
    loadRequest();
});

function setPaging(show,between){
      // show : itu buat nampilin di awal atau akhirnya mau tampil berapa
      // contoh : show = 5 ( 1,2,3,4,5,...,20 ) atau (1,...,16,17,18,19,20)
      // between : untuk ngasik tiap kiri dan kanan berapa index kalau ditengah
      // contoh : between = 2 (1,...,6,7,[8],9,10,...,20)
      between = parseInt(between+1);
      var txt = "";
      txt += `<div class="btn-group">`;
      txt = txt+"<button type='button' class='btn btn-secondary btn-sm' onclick='pervPage();'><i class='fa fa-chevron-left'></i></button>";
      if (pageAktif<(parseInt(show)-1) || pageAktif == (parseInt(show)-1) && pageTotal<=pageAktif) {
        for (var i = 0; i < (pageTotal); i++) {
            if (i<parseInt(show)) {
              txt = txt+"<button type='button' class='btn ";
              if (i == pageAktif) {
                txt = txt+"btn-info ";
              }else{
                txt = txt+"btn-secondary ";
              }
              txt = txt+"btn-sm' onclick='pageGanti("+i+")'>"+(i+1)+"</button>";
            }
        }
        if (pageTotal>parseInt(show)) {
          txt = txt+"<button type='button' class='btn btn-secondary btn-sm'>...</button>";
          txt = txt+"<button type='button' class='btn btn-secondary btn-sm' onclick='pageGanti("+(pageTotal-1)+")'>"+(pageTotal)+"</button>";
        }
      }else if(pageAktif - ((pageTotal)-parseInt(show))>0){
        txt = txt+"<button type='button' class='btn btn-secondary btn-sm' onclick='pageGanti(0)'>1</button>";
        txt = txt+"<button type='button' class='btn btn-secondary btn-sm'>...</button>";
        for (var i = 0; i < (pageTotal); i++) {
            if (i>((pageTotal-1)-parseInt(show))) {
              txt = txt+"<button type='button' class='btn ";
              if (i == pageAktif) {
                txt = txt+"btn-info ";
              }else{
                txt = txt+"btn-secondary ";
              }
              txt = txt+"btn-sm' onclick='pageGanti("+i+")'>"+(i+1)+"</button>";
            }
        }
      }else{
        txt = txt+"<button type='button' class='btn btn-secondary btn-sm' onclick='pageGanti(0)'>1</button>";
        txt = txt+"<button type='button' class='btn btn-secondary btn-sm'>...</button>";
        for (var i = 0; i < (pageTotal); i++) {
            if (i>(pageAktif-between) && i<(pageAktif+between)) {
              txt = txt+"<button type='button' class='btn ";
              if (i == pageAktif) {
                txt = txt+"btn-info ";
              }else{
                txt = txt+"btn-secondary ";
              }
              txt = txt+"btn-sm' onclick='pageGanti("+i+")'>"+(i+1)+"</button>";
            }
        }
        txt = txt+"<button type='button' class='btn btn-secondary btn-sm'>...</button>";
        txt = txt+"<button type='button' class='btn btn-secondary btn-sm' onclick='pageGanti("+(pageTotal-1)+")'>"+(pageTotal)+"</button>";
      }

      txt = txt+"<button type='button' class='btn btn-secondary btn-sm' onclick='nextPage();'><i class='fa fa-chevron-right'></i></button>";
      txt += `</div>`;
      txt = txt+"<select class='select2 jumpPage form-control form-control-sm' onchange='changePage(this)' style='width:60px;'>";
      for(var j = 0;j<pageTotal;j++){
        var selectedPage = '';
        if (j == pageAktif) {
          selectedPage = 'selected';
        }
        txt = txt+"<option value='"+j+"' "+selectedPage+">"+(j+1)+"</option>";
      }
      txt = txt+"</select>";
      $('#btnPaging1').html(txt);
      $('#btnPaging2').html(txt);
      $('.select2').select2();
    }

    $(document).keypress(function(e) {
        if(e.which == 13) {
          // $('#buttonSearchnya').focus();
          pageCount = 0;
          pageAktif = 0;
          loadRequest()
        }
    });
    function pageGanti(index){
      pageAktif = index;
      pageCount = index;
      loadRequest(index)
    }

    function changePage(e){
        pageGanti(parseInt($(e).val()));
    }


    function pervPage(){
    if (pageCount != 0) {
      pageAktif--;
      pageCount = pageCount-1;
      loadRequest()
    }
  }

  function nextPage(){
    if (indexContent != jumlahSeluruh) {
      pageAktif++;
      pageCount = pageCount+1;
      loadRequest()
    }
  }
  function pageIndex(index){
      pageAktif = index;
      pageCount = index;
      loadRequest()
    }

  function pageShow(index){
    pageAktif = index;
    pageCount = index;
    loadRequest()
  }

  function orderBy(element) {
    var orderedBy = $(element).data("orderby") === "asc" ? "desc" : "asc";
    $(".order-item > .desc,.asc").hide();
    var order = $(element).data("order");

    orderedBY = `${order},${orderedBy}`;

    $(element).find(`.${orderedBy}`).show();
    $(element).data("orderby", orderedBy);
    $(element).data("orderby", orderedBy);
    pageAktif = 0;
    pageCount = 0;
    loadRequest()
  }

