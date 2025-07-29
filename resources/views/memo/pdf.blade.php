<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Memo {{ $memo->nomor }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            font-size: 12pt;
            color: #333;
            margin: 1.5cm;
            position: relative;
            min-height: 100vh;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 15px;
        }
        
        .info-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 25px;
        }
        
        .content {
            margin: 30px 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .signature-container {
            margin-top: 60px;
            margin-bottom: 100px; /* Space for footer */
            width: 300px;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            width: 250px;
            margin: 15px 0 5px 0;
        }
        
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 10pt;
            text-align: center;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>MEMO INTERNAL</h2>
        <p>Nomor: {{ $memo->nomor }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="20%">Dari</td>
            <td width="30%">: {{ $memo->dari }}</td>
            <td width="20%">Tanggal</td>
            <td width="30%">: {{ $memo->tanggal->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Kepada</td>
            <td>: {{ $memo->kepada }}</td>
            <td>Perihal</td>
            <td>: {{ $memo->perihal }}</td>
        </tr>
    </table>

    <div class="content">
        {!! nl2br(e($memo->isi)) !!}
    </div>

    <!-- Tanda Tangan di Kiri -->
    <div class="signature-container">
        <p style="margin-bottom: 15px;">Hormat kami,</p>
        <p style="margin: 0;">{{ $memo->dari }}</p>
        <div class="signature-line"></div>
        <p style="margin: 5px 0 0 0; font-weight: bold;">{{ $memo->penandatangan ?? 'Galla Pandegia' }}</p>
    </div>

    <!-- Footer dengan jarak yang aman -->
    <div class="footer">
        <p>Dokumen ini dicetak pada {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>