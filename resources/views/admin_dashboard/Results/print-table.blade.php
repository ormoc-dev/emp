<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border-bottom: 2px solid #ddd;
            background-color: #ffffff;
        }
        .header .logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 10px;
        }
        .header .title {
            text-align: center;
            flex: 1;
            margin: 0 20px;
        }
        .header h1 {
            margin: 5px 0 0 0;
            font-size: 20px;
            color: #333;
            font-weight: bold;
        }
        .header h3 {
            margin: 5px 0 0 0;
            font-size: 18px;
            color: #555;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 16px;
            color: #777;
            font-style: italic;
        }
        .table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 16px;
        }
        .table thead th {
            background-color: #dfe2e4;
            color: #030202;
            font-weight: bold;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table .highlight {
            color: #050505;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .title-section, .signature {
            text-align: center;
            width: 90%;
            margin: 20px auto;
        }
        .signature .line {
            width: 300px;
            border-bottom: 1px solid #000;
            margin: 20px auto;
        }
        .signature-label {
            font-weight: bold;

        }
        .right{
            float: right;
        }
        .signature{
            margin-top: 150px;
        }

        .powered-by {
        text-align: center;
        margin-top: 50px;
        margin-bottom: 20px;
        font-size: 14px;
        color: #666;
        font-family: Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .powered-by span {
        font-style: italic;
    }

    .powered-by strong {
        color: #333;
        font-weight: 600;
    }

    .powered-by img {
        width: 30px;
        height: 30px;
        object-fit: contain;
    }

    </style>
</head>
<body>
    <div class="clearfix header">
        <img src="{{ asset('img/wlc.jpg') }}" alt="Left Logo" class="logo">
      
        <div class="title">
            <h1>WESTERN LEYTE COLLEGE OF ORMOC</h1>
            <h3>A. Bonifacio St. Ormoc City</h3>
            <p><i>College of ICT and Engineering</i></p>
        </div>
        <img src="{{ asset('img/cicte-logo.png') }}" alt="Right Logo" class="logo right">
    </div>
    <div class="title-section">
        <h3 class="title">{{ $title }}</h3>
       
    </div>
    {!! $tableContent !!}
    
    <div class="footer" style="margin-top: 20px; text-align: center; font-size: 12px;">
        <p>Printed on: {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <div class="signature">
        <div class="line"></div>
        <span class="signature-label">Chairman</span>
    </div>

    <div class="powered-by">
        <div>
            <span>Powered by</span> <strong>Event Master-Pro</strong>
        </div>
        
        <img class="logo-powerd" src="{{ asset('img/emp-logo.png') }}" alt="Event Master-Pro Logo">
    </div>
</body>
</html>
