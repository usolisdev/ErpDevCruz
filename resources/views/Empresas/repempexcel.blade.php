
  <p style="font-weight:bold" class="bold-normal-text text-center report-title">Reporte de Empresas</p>
  <div class="table-container">
      <table class="full-w-table">
        <tr>
          <td style="font-weight:bold"><span class="bold-normal-text">Fecha:</span></td>
          <td>{{$hoy}}</td>
          <td style="font-weight:bold"><span class="bold-normal-text">Usuario:</span></td>
          <td>{{$user}}</td>
        </tr>
      </table>
    </div>
  <style>
    .thead{
      background-color: #035167;
      color: #fff;
    }
  </style>
  <div class="table-container">
    <table  class="full-w-table format-gray-table" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
              <th class="thead">Sigla</th>
                <th class="thead">Nombre</th>
                <th class="thead">Nit</th>
                <th class="thead">Telefono</th>
                <th class="thead">Correo</th>
            </tr>
        </thead>
        <tbody>
          @foreach($empresas as $e)
              <tr>
                <td class="qty">{{$e->Sigla}}</td>
                  <td class="desc">{{$e->Nombre}}</td>
                  <td class="qty">{{$e->Nit}}</td>
                  <td class="unit">{{$e->Telefono}}</td>
                  <td class="total">{{$e->Correo}}</td>
              </tr>
            @endforeach
        </tbody>
    </table>
  </div>