<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {!!HTML::style('css/reportes/xls.css')!!}
    @yield('css')
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="100%" style="text-align: center;font-size: 18px;"><strong>@yield('titulo')</strong></td>
</tr></table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<table width="100%" style="font-size:8pt"><tr>
<td width="33.3%"><strong></strong></td>
<td width="33.3%" style="text-align: center;"><strong>Página {PAGENO} de {nb}</strong></td>
<td width="33.3%" style="text-align: right;"><strong>{{Carbon\Carbon::now()->format("d/m/Y G:i A")}}</strong></td>
</tr></table>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

@yield('reporte')
</body>
</html>