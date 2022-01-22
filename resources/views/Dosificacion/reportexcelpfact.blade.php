
<p style="font-weight:bold" class="bold-normal-text text-center report-title">Reporte Puntos de Facturación</p>
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
            <th class="thead">Codigo</th>
            <th class="thead">Alias</th>
            <th class="thead">Sucursal</th>
        </tr>
        </thead>
        <tbody>
        @foreach($puntosfacturacion as $pf)
            <tr>
                <td class="qty">{{$pf->codigo}}</td>
                <td class="desc">{{$pf->alias}}</td>
                <td class="qty">{{$pf->aliassuc}}</td>
            </tr>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>