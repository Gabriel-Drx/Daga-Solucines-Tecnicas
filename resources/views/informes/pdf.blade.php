<!DOCTYPE html>
<html>
<head>
    <title>Informe PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('{{ public_path("imagenes/fondo_pdf_daga.jpeg") }}') no-repeat center center;
            background-size: cover; /* Ajusta la imagen para que cubra todo el fondo */
        }
        .content {
            margin-top: 250px; /* Baja el texto */
            padding: 0px 35px 0px 80px;
            text-align: justify;
            /* background: rgba(255, 255, 255, 0.8); Opcional: agrega fondo blanco semitransparente al texto */
            /* border-radius: 10px; Opcional: redondea bordes */
        }
        h2 {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>INFORME {{ $informe->idInforme }}</h2>
        <p class="right">Lima, {{ date('d/m/Y', strtotime($informe->fechaInfo)) }}</p>
        <p><span class="bold">DIRECCIÓN:</span> {{ $informe->Direccion }}</p>
        <p><span class="bold">ATENCIÓN:</span> {{ $informe->Nombre }}</p>
        <p>Estimados señores:</p>
        <p>{{ $informe->descripcion }}</p>
    </div>
</body>
</html>
