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
            width: 90%; 
        }
        
        .memo-details table {
            width: 100%;
            margin-bottom: 25px;
        }
        
        .memo-details td {
            padding: 8px 0;
            vertical-align: top;
        }
        
        .memo-details .label {
            width: 120px;
            font-weight: bold;
        }
        
        .memo-body {
            margin: 25px 0;
            text-align: justify;
            line-height: 1.7;
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
            {!! nl2br(e($memo->isi)) !!}
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
<<<<<<< HEAD
                    {{ $memo->approval_date->format('d/m/Y H:i') }}
=======
>>>>>>> 3ad3906dbdb6de5e29514832f96c6d6db9ace5ab
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>