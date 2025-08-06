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
            font-size: 12px;
        }
        
        .header { 
            text-align: left; 
            margin-bottom: 20px; 
            border-bottom: 1px solid #000;
            padding-bottom: 15px;
        }
        
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .content { 
            margin: 0 auto; 
            width: 100%; 
            box-sizing: border-box;
        }
        
        .memo-details table {
            width: 100%;
            margin-bottom: 20px;
            table-layout: fixed;
            border-collapse: collapse;
        }
        
        .memo-details td {
            padding: 2px 0;
            vertical-align: top;
            word-wrap: break-word;
            font-size: 12px;
        }
        
        .memo-details .label {
            width: 80px;
            font-weight: normal;
        }
        
        .memo-details .colon {
            width: 15px;
        }
        
        .memo-body {
            margin: 20px 0;
            text-align: justify;
            line-height: 1.6;
            width: 100%;
            word-wrap: break-word;
            font-size: 12px;
        }
        
        .memo-body ol {
            padding-left: 20px;
            margin: 10px 0;
        }
        
        .memo-body ol li {
            margin-bottom: 5px;
            line-height: 1.4;
        }
        
        .closing-text {
            margin: 20px 0;
            font-size: 12px;
            line-height: 1.6;
        }
        
        .signature-container { 
            margin-top: 50px;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            width: 100%;
        }
        
        .signature-box { 
            text-align: left;
            width: 250px;
            margin-bottom: 30px;
        }
        
        .signature-header {
            text-align: left;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .signature-position-text {
            text-align: left;
            margin-bottom: 15px;
            font-size: 12px;
        }
        
        .signature-img { 
            max-height: 60px; 
            margin: 15px 0; 
            display: block;
            margin-left: 0;
            margin-right: auto;
        }
        
        .signature-name { 
            font-weight: bold; 
            text-decoration: underline;
            font-size: 12px;
            text-align: left;
            margin-top: 10px;
        }
        
        .signature-position { 
            font-size: 12px; 
            margin-top: 3px;
            text-align: left;
        }
        
        .tembusan {
            margin-top: 40px;
            font-size: 12px;
        }
        
        .tembusan h4 {
            margin: 0 0 5px 0;
            font-size: 12px;
            font-weight: bold;
        }
        
        .tembusan ul {
            padding-left: 20px;
            margin: 5px 0;
        }
        
        .tembusan li {
            margin-bottom: 3px;
            list-style-type: disc;
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
                    return $date->format('d M Y');
                }
                if (is_string($date)) {
                    return \Carbon\Carbon::parse($date)->format('d M Y');
                }
                return '.........................';
            } catch (\Exception $e) {
                return '.........................';
            }
        }
    @endphp

    <div class="header">
        <h2>MEMO</h2>
    </div>
    
    <div class="content">
        <div class="memo-details">
            <table>
                <tr>
                    <td class="label">Nomor</td>
                    <td class="colon">:</td>
                    <td>{{ $memo->nomor }}</td>
                </tr>
                <tr>
                    <td class="label">Kepada</td>
                    <td class="colon">:</td>
                    <td>{{ $memo->kepada }}</td>
                </tr>
                <tr>
                    <td class="label">Dari</td>
                    <td class="colon">:</td>
                    <td>{{ $memo->dari }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td>{{ $memo->perihal }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal</td>
                    <td class="colon">:</td>
                    <td>{{ safeDateFormat($memo->tanggal) }}</td>
                </tr>
            </table>
        </div>
        
        <div class="memo-body">
            {!! $memo->isi !!}
        </div>
        
        <div class="closing-text">
            Demikian disampaikan, selanjutnya mohon arahan lebih lanjut.
        </div>
        
        <div class="signature-container">
            <div class="signature-box">
                <div class="signature-header">Hormat Kami,</div>
                <div class="signature-position-text">{{ $memo->dari }}</div>
                
                @if($memo->signed_by && $memo->signature_path)
                @php
                    $signaturePath = storage_path('app/public/' . $memo->signature_path);
                    if (file_exists($signaturePath)) {
                        $signatureData = base64_encode(file_get_contents($signaturePath));
                        $signatureMime = mime_content_type($signaturePath);
                @endphp
                
                <img src="data:{{ $signatureMime }};base64,{{ $signatureData }}" 
                     class="signature-img" alt="Tanda Tangan">
                
                @php } @endphp
                @endif
                
                <div class="signature-name">{{ $memo->disetujuiOleh->name ?? $memo->signed_by ?? 'Galla Pandegla' }}</div>
            </div>
        </div>
        
        @if(isset($memo->tembusan) && $memo->tembusan)
        <div class="tembusan">
            <h4>Tembusan :</h4>
            <ul>
                @if(is_array($memo->tembusan))
                    @foreach($memo->tembusan as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                @else
                    <li>Asisten Manager Administrasi dan Umum</li>
                    <li>Arsip</li>
                @endif
            </ul>
        </div>
        @endif
    </div>
</body>
</html>