
<p style="font-weight:bold" class="bold-normal-text text-center report-title">Reporte de Sucursales</p>
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
            <th class="thead">Alias</th>
            <th class="thead">Dirección</th>
            <th class="thead">Contacto</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sucursales as $s)
            <tr>
                <td class="qty">{{$s->alias}}</td>
                <td class="desc">{{$s->direccion}}</td>
                <td class="qty">{{$s->nombres}} {{$s->apellidos}}</td>
            </tr>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>