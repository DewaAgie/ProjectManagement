

 
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
    
    function loadRekapCro(month="", type="so") {
      let statusActive = $("#statusActive2").val();
      $.get(link + `/getRekapHarian?month=${month}&type=${type}&status=${statusActive}`)
      .done(data => {
        data = JSON.parse(data)
        if(data.error) {
          Swal.fire("Terjadi kesalahan saat menampilkan rekap harian", "", "info")
          return 
        }
        var
         html=""
        if(data.role === "admin") {

           data = data.data;
          
           html += loadHTMLRekapAdmin(data, type);
        } else {
          data = data.data
          html += loadHTMLRekap(data)
        }
          
          $(".rekapCRO").html(html)
      })
    }

    function loadHTMLRekapAdmin(data, type) {
      let html = "";
      var 
        header_title = "",
        totalRekapPerHari = {};

      switch (type) {
        case "so":
          header_title = `SALES ORDER ${data.month.toUpperCase()}`
          break;
        case "wo":
          header_title = `WORK ORDER ${data.month.toUpperCase()}`
          break;
        case "sa":
          header_title = `SALES ACTIVE ${data.month.toUpperCase()}`
          break;
      
        default:
          break;
      }

      html += `
              <table border="1" width="100%" class="table table-sm">
                
                <tr>
                  <td rowspan="2" align="center" style="background:#44546B;color:white;vertical-align:middle!important">CRO</td>
                  <td colspan="${data.total_day+1}}" align="center">${header_title}</td>
                </tr>
                <tr >
        `

        // Membuat header tanggal
        for(let i=1;i<=data.total_day;i++) {
          html += `<td align="center" valign="center" style="padding:10px; ${data.hari_minggu.includes(i) ? 'color:red;' : ''}">${i}</td>`
        }

        html += `
        <td align="center">Total</td>
        </tr>`

        // Membuat rekapan per CRO
        data.cro.forEach(value => {
          html += `
          <tr>
            <td style="padding:10px">
              ${value.name}
            </td>`
            Object.entries(value.data[type]).forEach(([key, so]) => {
              html += `<td align="center">${(so==0?'-':so)}</td>`
              totalRekapPerHari[key] = totalRekapPerHari[key] ? totalRekapPerHari[key] + so : so 
            });

            html += `
              <td align="center">${sum(value.data[type])}</td>
            </tr>
            `

        });

        html += `
        <tr>
          <td align="center"></td>
        `
        
        Object.entries(totalRekapPerHari).forEach(([key, val]) => {          
          html += `<th><center>${(val==0?'-':val)}</center></th>`
        })

        html += `
          <th><center>${sum(totalRekapPerHari)}</center></th>
        `
        html +=`
                </tr>
              </table>
      `
      return html; 
    }


    function loadHTMLRekap(data) {
      var 
        html = "",
        header_title = data.month.toUpperCase(),
        totalRekapPerHari = {}

      html += `
            <table border="1" width="100%" class="table" style="border: 2px solid #dddddd;">
              
              <tr>
                <td rowspan="2" align="center" style="background:#44546B;color:white;vertical-align:middle!important">CRO</td>
                <td colspan="${data.total_day+1}" align="center">${header_title}</td>
              </tr>
              <tr >
        `

        for(let i=1;i<=data.total_day;i++) {
          html += `<td align="center" valign="center" style="padding:10px; ${data.hari_minggu.includes(i) ? 'color:red;' : ''}">${i}</td>`
        }
        html+= `<td align="center" valign="center">Total</td>`

        Object.entries(data.cro).forEach(([key, val]) => {
          var title = "Sales Active"
          if(key === "so") {
            title = "Sales Order"
          } else if(key === "wo"){
            title = "Work Order"
          }

          html += `<tr><td align="center" valign="center">${title}</td>`
          
          Object.entries(val).forEach(([key, value]) => {
            html += `<td align="center" valign="center">${(value == 0?'-':value)}</td>`
          })

          html+= `<td valign="center" align="center">${sum(val)}</td>`
          html += "</tr>"
        })

        
        // html += `
        //   <td align="center">${sum(totalRekapPerHari)}</td>
        // `
        html +=`
                </tr>
              </table>
      `

      return html
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
          loadListStaff();
        }
    });
    function pageGanti(index){
      pageAktif = index;
      pageCount = index;
      loadListStaff(index);
    }

    function changePage(e){
        pageGanti(parseInt($(e).val()));
    }


    function pervPage(){
    if (pageCount != 0) {
      pageAktif--;
      pageCount = pageCount-1;
      loadListStaff();
    }
  }

  function nextPage(){
    if (indexContent != jumlahSeluruh) {
      pageAktif++;
      pageCount = pageCount+1;
      loadListStaff();
    }
  }
  function pageIndex(index){
      pageAktif = index;
      pageCount = index;
      loadListStaff();
    }
  function cariStaff(){
    pageAktif = 0;
    pageCount = 0;
    loadListStaff();
 }

  function pageShow(index){
    pageAktif = index;
    pageCount = index;
    loadListStaff();
  }

// staff
  function loadListStaff(){
    $('.tableStaff').loading('toggle');
    var txt ="";
    page      = pageCount;
    var no    = (parseInt(page)*20)+1;
    var awal  = no;
    var cari = $('#cariStaff').val();
    var role = $('#roleStaff').val();
    var periode = $('#periode-staff-kirim').val();
    var active = $("#statusActive").val();
    $.getJSON(link+'/users/jsonListStaff?page='+page+'&cari='+cari+'&role='+role+'&periode='+periode+`&order=${orderedBY}&statusActive=${active}`,function(data){
      jumlahSeluruh = data[0];
      pageTotal = parseInt(Math.ceil(jumlahSeluruh/20));
      $.each(data[1], function(key, val){
        txt += `<tr>
                <td align="left">${no}</td>
                <td align="left">${val.salesCode}</td>
                <td align="left"><a href="${link+"/users/form?id="+val.id}" style="color:#1e88e5;">${val.name}</a></td>
                <td align="left">${val.SO}</td>
                <td align="left">${val.WO}</td>
                <td align="left">${val.SA}</td>
                <td align="left">${val.bonus}</td>
                <td align="left"><a href="${link}/downloadRekapPendapatan?id=${val.id}&month=${periode}"><i class="fa fa-download text-primary cursor-pointer" ></i></td>
              </tr>`;
        indexContent = no;
        no++;
      });
    }).done(function(){
      $('#displayPage').html((awal)+'-'+indexContent+'/'+jumlahSeluruh);
      $('#displayPage2').html((awal)+'-'+indexContent+'/'+jumlahSeluruh);
      $('#tbodyListStaff').html(txt);
      $('.tableStaff').loading('toggle');
      // $('[data-toggle="tooltip"]').tooltip();
      setPaging(5,2);
      if (jumlahSeluruh == 0) {
        $('#tbodyListStaff').html("<td colspan='7'><center>Data tidak ditemukan</center></td>");
      }
    });
  }

  function downloadExcel(type="cro"){
    let 
      periode = $('#periode-rekap-kirim').val(),
      typeStep = $("#select-status-rekap-kirim").val()

    if(type === "cro") {
      let 
        cari = $('#cariStaff').val(),
        role = $('#roleStaff').val();
        statusActive = $("#statusActive").val();
  
      window.location.href = link+'/users/downloadReport?cari='+cari+'&role='+role+'&periode='+periode+'&status='+statusActive;
    } else {
      let statusActive = $("#statusActive2").val();
      window.location.href = link + `/report/rekap-harian?month=${periode}&type=${typeStep}&status=${statusActive}`;
    }
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
    loadListStaff();
  }

