<html>
	<head>
	    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext" rel="stylesheet" type="text/css">
	    <style type="text/css">
	        html, body, div, span, applet, object, iframe,
	        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
	        a, abbr, acronym, address, big, cite, code,
	        del, dfn, em, img, ins, kbd, q, s, samp,
	        small, strike, strong, sub, sup, tt, var,
	        b, u, i, center,
	        dl, dt, dd, ol, ul, li,
	        fieldset, form, label, legend,
	        table, caption, tbody, tfoot, thead, tr, th, td,
	        article, aside, canvas, details, embed,
	        figure, figcaption, footer, header, hgroup,
	        menu, nav, output, ruby, section, summary,
	        time, mark, audio, video {
	            margin: 0;
	            padding: 0;
	            border: 0;
	            font: inherit;
	            font-size: 100%;
	            vertical-align: baseline;
	        }
	 
	        html {
	            line-height: 1;
	        }
	 
	        ol, ul {
	            list-style: none;
	        }
	 
	        table {
	            border-collapse: collapse;
	            border-spacing: 0;
	        }
	 
	        caption, th, td {
	            text-align: left;
	            font-weight: normal;
	            vertical-align: middle;
	        }
	 
	        q, blockquote {
	            quotes: none;
	        }
	        q:before, q:after, blockquote:before, blockquote:after {
	            content: "";
	            content: none;
	        }
	 
	        a img {
	            border: none;
	        }
	 
	        article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
	            display: block;
	        }
	 
	        body {
	            font-family: "Source Sans Pro", sans-serif;
	            font-weight: 300;
	            font-size: 12px;
	            margin: 0;
	            padding: 50px 25px 30px 10px;
	        }
	        body a {
	            text-decoration: none;
	            color: inherit;
	        }
	        body a:hover {
	            color: inherit;
	            opacity: 0.7;
	        }
	        body .container {
	            min-width: 500px;
	            margin: 0 auto;
	            padding: 0 20px;
	        }
	        body .clearfix:after {
	            content: "";
	            display: table;
	            clear: both;
	        }
	        body .left {
	            float: left;
	        }
	        body .right {
	            float: right;
	        }
	        body .helper {
	            display: inline-block;
	            height: 100%;
	            vertical-align: middle;
	        }
	        body .no-break {
	            page-break-inside: avoid;
	        }
	 
	        header {
	            margin-top: 20px;
	            margin-bottom: 50px;
	        }
	        header figure {
	            float: left;
	            width: 60px;
	            height: 60px;
	            margin-right: 10px;
	            background-color: #8BC34A;
	            border-radius: 50%;
	            text-align: center;
	        }
	        header figure img {
	            margin-top: 13px;
	        }
	        header .company-address {
	            float: left;
	            max-width: 150px;
	            line-height: 1.7em;
	        }
	        header .company-address .title {
	            color: #035167;
	            font-weight: 400;
	            font-size: 1.5em;
	            text-transform: uppercase;
	        }
	        header .company-contact {
	            float: right;
	            height: 60px;
	            padding: 0 10px;
	            background-color: #8BC34A;
	            color: white;
	        }
	        header .company-contact span {
	            display: inline-block;
	            vertical-align: middle;
	        }
	        header .company-contact .circle {
	            width: 20px;
	            height: 20px;
	            background-color: white;
	            border-radius: 50%;
	            text-align: center;
	        }
	        header .company-contact .circle img {
	            vertical-align: middle;
	        }
	        header .company-contact .phone {
	            height: 100%;
	            margin-right: 20px;
	        }
	        header .company-contact .email {
	            height: 100%;
	            min-width: 100px;
	            text-align: right;
	        }
	 
	        section .details {
	            margin-bottom: 55px;
	        }
	        section .details .client {
	            width: 50%;
	            line-height: 20px;
	        }
	        section .details .client .name {
	            color: #8BC34A;
	        }
	        section .details .data {
	            width: 50%;
	            text-align: right;
	        }
	        section .details .title {
	            margin-bottom: 15px;
	            color: #035167;
	            font-size: 2em;
	            font-weight: 600;
	            /*text-transform: uppercase;*/
	            text-align: center
	        }
	        section table {
	            width: 100%;
	            /*border-collapse: collapse;
	            border-spacing: 0;*/
	            border: hidden;
	            font-size: 0.9166em;
	        }
	        section table .qty, section table .unit{
	            width: 13%;
	        }
	        section table .total {
	        	width: 20%;
	        }
	        section table .desc {
	            width: 35%;
	        }
	        section table thead {
	            display: table-header-group;
	            vertical-align: middle;
	            /*border-color: inherit;*/
	            border: hidden
	        }
	        section table thead th {
	            padding: 5px 10px;
	            background: #035167;
	            /*border-bottom: 5px solid #FFFFFF;
	            border-right: 4px solid #FFFFFF;*/
	            text-align: center;
	            color: white;
	            font-weight: 600;
	            text-transform: uppercase;
	            border: hidden
	        }
	        section table thead th:last-child {
	            border-right: none;
	        }
	        section table thead .desc {
	            text-align: center;
	        }
	        section table thead .qty {
	            text-align: center;
	        }
	        section table tbody td {
	            padding: 10px;
	            background: #f8fcf2;
	            color: #000;
	            text-align: center;
	            /*border-bottom: 5px solid #FFFFFF;
	            border-right: 4px solid #E8F3DB;*/
	            border: hidden
	        }
	        section table tbody td:last-child {
	            border-right: none;
	        }
	        section table tbody h3 {
	            margin-bottom: 5px;
	            color: #8BC34A;
	            font-weight: 600;
	        }
	        section table tbody .desc {
	            text-align: left;
	        }
	        section table tbody .qty {
	            text-align: center;
	        }
	        section table.grand-total {
	            margin-bottom: 45px;
	        }
	        section table.grand-total td {
	            padding: 5px 10px;
	            border: none;
	            color: #777777;
	            text-align: right;
	        }
	        section table.grand-total .desc {
	            background-color: transparent;
	        }
	        section table.grand-total tr:last-child td {
	            font-weight: 600;
	            color: #8BC34A;
	            font-size: 1.18181818181818em;
	        }
	 
	        footer {
	        	position: absolute;
	        	bottom: 1;
	            margin-bottom: 20px;
	        }
	        footer .thanks {
	            margin-bottom: 40px;
	            color: #8BC34A;
	            font-size: 1.16666666666667em;
	            font-weight: 600;
	        }
	        footer .notice {
	            margin-bottom: 25px;
	        }
	        footer .end {
	            padding-top: 5px;
	            border-top: 2px solid #8BC34A;
	            text-align: center;
	        }
	        .datacol{
	        	width: 50%;
	        	float: right;
	        }
	        .colum{
	        	width: 40%;
	        	float: left;
	        	font-size: 15px;
	        	font-style: italic;
	        }
	        .columdata{
	        	width: 55%;
	        	float: right;
	        	margin-left: 5%;
	        	text-align: left;
	        	font-size: 15px;
	        	font-style: italic;
			}
	    </style>
	</head>
	<body>
	    <header class="clearfix">
	    </header>
	 
	    <section>
	        <div class="container">
	            <div class="details clearfix">
	            	<div class="title" >Reporte de Empresas</div>
	                <div class="data right">
	                    <div class="date">
	                        <div class="datacol"><span class="colum">Fecha: </span><span class="columdata">{{$hoy}}</span></div><br/>
	                        <div class="datacol"><span class="colum">Usuario: </span><span class="columdata">{{$user}}</span></div>
	                    </div>
	                </div>
	            </div>
	 
	            <table border="0" cellspacing="0" cellpadding="0">
	                <thead>
	                    <tr>
	                    	<th class="qty">Sigla</th>
	                        <th class="desc">Nombre</th>
	                        <th class="qty">Nit</th>
	                        <th class="unit">Telefono</th>
	                        <th class="total">Correo</th>
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
	    </section>
	 
	   <!--  <footer>
	        <div class="container">
	            <div class="end">1</div>
	        </div>
	    </footer> -->
	</body>
</html>