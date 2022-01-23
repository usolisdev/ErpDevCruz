
<p style="font-weight:bold" class="bold-normal-text text-center report-title">Reporte Dosificaciones</p>
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
            <th class="thead">N.Tramite</th>
            <th class="thead">N.Autorización</th>
            <th class="thead">N.Factura Restantes</th>
            <th class="thead">Sistema Facturación</th>
            <th class="thead">Fecha Limite de Emisión</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dosificaciones as $d)
            <tr>
                <td class="qty">{{$d->ntramite}}</td>
                <td class="desc">{{$d->nautorizacion}}</td>
                <td class="qty">{{$d->stockfacturas}}</td>
                <td class="qty">{{$d->sistemafacturacion}}</td>
                <td class="qty">{{$d->fechalimiteemision}}</td>
            </tr>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>