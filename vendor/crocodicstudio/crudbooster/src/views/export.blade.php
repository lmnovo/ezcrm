@if(Request::input('fileformat') == 'pdf')
<h3>{{Request::input('filename')}}</h3>
@endif
<table border='1' width='100%' cellpadding='3' cellspacing="0" style='border-collapse: collapse;font-size:12px'>
  <thead>
  <tr>
    <?php
      $columns[count($columns)]['name'] = "Email";

    foreach($columns as $col) {

      if(Request::get('columns')) {
        if(!in_array($col['name'], Request::get('columns'))) {
            continue;
        }
      }
      $colname = $col['label'];
      if ($colname == 'Nombre del Prospecto') {
          echo "<th style='background:#eeeeee'>Información del Prospecto</th>";
      }
      elseif ($colname == 'Lead Name') {
          echo "<th style='background:#eeeeee'>Lead Information</th>";
      }
      else {
          echo "<th style='background:#eeeeee'>$colname</th>";
      }
    }
    ?>
  </tr>
  </thead>
  <tbody>
  @if(count($result)==0)
  <tr class='warning'>
    <td colspan='{{count($columns)+1}}' align="center">No Data Avaliable</td>
  </tr>
  @else
  @foreach($result as $row)
  <tr>
    <?php
    foreach($columns as $col) {

      if(Request::get('columns')) {
        if(!in_array($col['name'], Request::get('columns'))) {
            continue;
        }
      }

      if ($col['field'] == 'id_account' && ($col['label'] == 'Lead Name' || $col['label'] == 'Nombre del Prospecto') ) {
          $lead = DB::table('account')->where('id', @$row->{$col['field']})->first();

          if(count($lead) == 0) {
              $value = '-';
          }
          elseif ($col['label'] = 'Lead Name') {
              $value = 'Name: '.$lead->name.' '.$lead->lastname.'  <br> Email: ('.$lead->email.')'.'  <br> Telephone: ('.$lead->telephone.')';
          }
          else {
              $value = 'Nombre: '.$lead->name.' '.$lead->lastname.'  <br> Correo: ('.$lead->email.')'.'  <br> Teléfono: ('.$lead->telephone.')';
          }

      }
      elseif ($col['field'] == 'id_account' && ($col['label'] == 'Assigned To' || $col['label'] == 'Responsable') ) {
          $account_id = DB::table('account')->where('id', @$row->{$col['field']})->first();
          $lead = DB::table('cms_users')->where('id', $account_id->id_usuario)->first();

          if(count($lead) == 0) {
              $value = '-';
          }
          elseif ($col['label'] = 'Assigned To') {
              $value = 'Name: '.$lead->name.' '.$lead->lastname.'  <br> Email: ('.$lead->email.')'.'  <br> Telephone: ('.$lead->phone.')';
          }
          else {
              $value = 'Nombre: '.$lead->name.' '.$lead->lastname.'  <br> Correo: ('.$lead->email.')'.'  <br> Teléfono: ('.$lead->phone.')';
          }

      }
      else {
          $value = @$row->{$col['field']};
      }
      $title = @$row->{$title_field};

    if(@$col['image']) {
      if($value=='') {
      $value = "http://placehold.it/50x50&text=NO+IMAGE";
      }
      $pic = (strpos($value,'http://')!==FALSE)?$value:asset($value);
      $pic_small = $pic;
      if(Request::input('fileformat')=='pdf') {
        echo "<td><a data-lightbox='roadtrip' rel='group_{{$table}}' title='$col[label]: $title' href='".$pic."'><img class='img-circle' width='40px' height='40px' src='".$pic_small."'/></a></td>";
      }else{
        echo "<td>$pic</td>";
      }
    

    }else if(@$col['download']) {
      $url = (strpos($value,'http://')!==FALSE)?$value:asset($value);
      echo "<td><a class='btn btn-sm btn-primary' href='$url' target='_blank' title='Download File'>Download</a></td>";
    }else{
    
    //limit character             
    if($col['str_limit']) {
      $value = trim(strip_tags($value));
      $value = str_limit($value,$col['str_limit']);
    }

    if($col['nl2br']) {
                $value = nl2br($value);
              }

    if(Request::input('fileformat') == 'pdf') {
      if(!empty($col['callback_php'])) {
        
        foreach($row as $k=>$v) {
            $col['callback_php'] = str_replace("[".$k."]",$v,$col['callback_php']);
        }
        @eval("\$value = ".$col['callback_php'].";");
      }

      //New method for callback
      if(isset($col['callback'])) {
        $value = call_user_func($col['callback'],$row);
      }
    }
    

      echo "<td>".$value."</td>";
    }
    }
    ?>
  </tr>
  @endforeach
  @endif
  </tbody>
</table>
<script type="text/php">
    if ( isset($pdf) ) {
        $font = Font_Metrics::get_font("helvetica", "bold");
        $pdf->page_text(36, 18, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
    }
</script>