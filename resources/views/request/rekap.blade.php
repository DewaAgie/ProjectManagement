<?php

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekap Request.xls");

$no = 1;
$status = [
  '0' => 'Baru',
  '1' => 'Sedang Dikerjakan',
  '2' => 'Testing',
  '3' => 'Revisi',
  '4' => 'Terselesaikan',
  '5' => 'Publish'
];
?>

<table border="1">
<tr>
  <td>No</td>
  <td>Judul Request</td>
  <td>Project</td>
  <td>Dikerjakan Oleh</td>
  <td>Penjadwalan</td>
  <td>Status</td>
</tr>

@foreach ($data as $item)
  <tr>
    <td>{{$no}}</td>
    <td>{{$item->judulRequest}}</td>
    <td>{{$item->namaProject}}</td>
    <td>{{$item->namaUser}}</td>
    <td>'{{$item->tglPenjadwalan}}</td>
    <td>{{$status[$item->status]}}</td>
  </tr>
  @php
      $no++;
  @endphp
@endforeach
</table>
