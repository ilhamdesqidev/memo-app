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
        
        .attachment-info {
            margin: 20px 0;
            font-weight: bold;
        }
        
        .signature-container { 
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .signature-box { 
            width: 250px; 
            text-align: center;
            margin-bottom: 30px;
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
        
        .approval-history {
            margin-top: 40px;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        
        .approval-history h4 {
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .approval-history ul {
            padding-left: 20px;
            margin: 5px 0;
        }
        
        .approval-history li {
            margin-bottom: 5px;
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
    @php
        function safeDateFormat($date) {
            try {
                if ($date instanceof \Carbon\Carbon) {
                    return $date->format('d/m/Y H:i');
                }
                if (is_string($date)) {
                    return \Carbon\Carbon::parse($date)->format('d/m/Y H:i');
                }
                return '.........................';
            } catch (\Exception $e) {
                return '.........................';
            }
        }
    @endphp

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
                    <td>: {{ safeDateFormat($memo->tanggal) }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td>: {{ $memo->perihal }}</td>
                </tr>
                <tr>
                    <td class="label">Status</td>
                    <td>: {{ ucfirst($memo->status) }}</td>
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
        
        <div class="signature-container">
            <!-- Current signature only -->
            @if($memo->signed_by)
            <div class="signature-box">
                @php
                    $currentSignaturePath = $memo->signature_path 
                        ? storage_path('app/public/' . $memo->signature_path) 
                        : null;
                    $currentImageData = null;
                    if ($currentSignaturePath && file_exists($currentSignaturePath)) {
                        $currentImageData = base64_encode(file_get_contents($currentSignaturePath));
                        $currentImageInfo = getimagesize($currentSignaturePath);
                        $currentMimeType = $currentImageInfo['mime'];
                    }
                @endphp
                
                @if(isset($currentImageData))
                    <img src="data:{{ $currentMimeType }};base64,{{ $currentImageData }}" 
                         class="signature-img" alt="Tanda Tangan">
                @else
                    <div class="signature-line"></div>
                @endif
                
                <div class="signature-name">{{ $memo->disetujuiOleh->name ?? '.........................' }}</div>
                <div class="signature-position">{{ $memo->disetujuiOleh->jabatan ?? '.........................' }}</div>
                <div class="signature-date">
                    {{ safeDateFormat($memo->signed_at) }}
                </div>
            </div>
            @endif
            
            <!-- Next approver placeholder if memo is still pending -->
            @if($memo->status === 'diajukan')
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-name">.........................</div>
                <div class="signature-position">.........................</div>
                <div class="signature-date">.........................</div>
            </div>
            @endif
        </div>
        
       
    </div>
</body>
</html>