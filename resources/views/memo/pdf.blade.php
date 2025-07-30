<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Memo - {{ $memo->nomor }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #000;
            margin: 0;
            padding: 20px;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            box-sizing: border-box;
        }
        
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 1px solid #000;
            padding-bottom: 15px;
        }
        
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header h3 {
            margin: 0;
            font-size: 14px;
            font-weight: normal;
        }
        
        .content { 
            margin: 0 auto; 
            width: 100%; 
            box-sizing: border-box;
            padding: 0 10px;
        }
        
        .memo-details table {
            width: 100%;
            margin-bottom: 25px;
            table-layout: fixed;
        }
        
        .memo-details td {
            padding: 8px 0;
            vertical-align: top;
            word-wrap: break-word;
        }
        
        .memo-details .label {
            width: 120px;
            font-weight: bold;
        }
        
        .memo-body {
            margin: 25px 0;
            text-align: justify;
            line-height: 1.7;
            width: 100%;
            word-wrap: break-word;
        }
        
        /* Styling untuk konten rich text */
        .memo-body h1, .memo-body h2, .memo-body h3, 
        .memo-body h4, .memo-body h5, .memo-body h6 {
            margin: 15px 0 10px 0;
            font-weight: bold;
            line-height: 1.2;
        }
        
        .memo-body h1 { font-size: 24px; }
        .memo-body h2 { font-size: 20px; }
        .memo-body h3 { font-size: 18px; }
        .memo-body h4 { font-size: 16px; }
        .memo-body h5 { font-size: 14px; }
        .memo-body h6 { font-size: 12px; }
        
        .memo-body p {
            margin: 10px 0;
            text-align: justify;
        }
        
        .memo-body strong {
            font-weight: bold;
        }
        
        .memo-body em {
            font-style: italic;
        }
        
        .memo-body u {
            text-decoration: underline;
        }
        
        .memo-body s {
            text-decoration: line-through;
        }
        
        .memo-body ul, .memo-body ol {
            margin: 10px 0;
            padding-left: 30px;
        }
        
        .memo-body li {
            margin: 5px 0;
        }
        
        .memo-body blockquote {
            margin: 15px 0;
            padding: 10px 20px;
            border-left: 4px solid #ccc;
            background-color: #f9f9f9;
            font-style: italic;
        }
        
        .memo-body code {
            background-color: #f5f5f5;
            padding: 2px 4px;
            border-radius: 3px;
            font-family: monospace;
            font-size: 90%;
        }
        
        .memo-body pre {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 15px 0;
        }
        
        .memo-body pre code {
            background: none;
            padding: 0;
        }
        
        .memo-body a {
            color: #0066cc;
            text-decoration: underline;
        }
        
        .memo-body img {
            max-width: 100%;
            height: auto;
            margin: 10px 0;
        }
        
        .attachment-info {
            margin: 20px 0;
            font-weight: bold;
        }
        
        .signature-container { 
            margin-top: 50px; 
            display: flex; 
            justify-content: flex-end; 
        }
        
        .signature-box { 
            width: 250px; 
            text-align: center; 
        }
        
        .signature-img { 
            max-height: 60px; 
            margin: 10px 0; 
        }
        
        .signature-line { 
            border-top: 1px solid #000; 
            width: 200px; 
            margin: 15px auto; 
        }
        
        .signature-name { 
            font-weight: bold; 
            margin-top: 5px;
        }
        
        .signature-position { 
            font-size: 14px; 
            margin-top: 3px;
        }
        
        .signature-date { 
            font-size: 12px; 
            margin-top: 8px; 
        }

        @page {
            size: A4;
            margin: 20mm;
        }

        @media print {
            body {
                width: 100%;
                max-width: 100%;
                padding: 0;
            }
            .content {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>MEMO INTERNAL</h2>
        <h3>Nomor: {{ $memo->nomor }}</h3>
    </div>
    
    <div class="content">
        <div class="memo-details">
            <table>
                <tr>
                    <td class="label">Dari</td>
                    <td>: {{ $memo->dari }}</td>
                </tr>
                <tr>
                    <td class="label">Kepada</td>
                    <td>: {{ $memo->kepada }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal</td>
                    <td>: {{ $memo->tanggal->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td>: {{ $memo->perihal }}</td>
                </tr>
            </table>
        </div>
        
        <div class="memo-body">
            {!! $memo->isi !!}
        </div>
        
        @if($memo->lampiran > 0)
        <div class="attachment-info">
            Lampiran: {{ $memo->lampiran }} lembar
        </div>
        @endif
        
        @if($memo->include_signature && $memo->signature_path && $memo->disetujuiOleh)
        <div class="signature-container">
            <div class="signature-box">
                @php
                    $signaturePath = storage_path('app/public/' . $memo->signature_path);
                    if (file_exists($signaturePath)) {
                        $imageData = base64_encode(file_get_contents($signaturePath));
                        $imageInfo = getimagesize($signaturePath);
                        $mimeType = $imageInfo['mime'];
                    }
                @endphp
                
                @if(isset($imageData))
                    <img src="data:{{ $mimeType }};base64,{{ $imageData }}" 
                        class="signature-img" alt="Tanda Tangan">
                @endif
                
                <div class="signature-line"></div>
                <div class="signature-name">{{ $memo->disetujuiOleh->name }}</div>
                <div class="signature-position">{{ $memo->disetujuiOleh->jabatan }}</div>
                <div class="signature-date">
                    {{ $memo->approval_date->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>