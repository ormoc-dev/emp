<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDF Export</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #ffffff;
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
                width: 100%;
                margin: 20px auto;
                border-collapse: collapse;
                background-color: #ffffff;
                font-size: 12px;
                page-break-inside: avoid;
            }

            .table th,
            .table td {
                padding: 8px 12px;
                border: 1px solid #333;
                text-align: left;
                font-size: 11px;
                vertical-align: top;
            }

            .table thead th {
                background-color: #f5f5f5;
                font-weight: bold;
                color: #000;
                text-align: center;
            }

            .table tbody tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            .table tbody tr:nth-child(odd) {
                background-color: #ffffff;
            }

            /* Handle Tailwind classes that might be in the table */
            .table .px-4 {
                padding-left: 16px;
                padding-right: 16px;
            }

            .table .py-2 {
                padding-top: 8px;
                padding-bottom: 8px;
            }

            .table .border-b {
                border-bottom: 1px solid #ddd;
            }

            .table .text-center {
                text-align: center;
            }

            .table .font-bold {
                font-weight: bold;
            }

            .table .bg-green-100 {
                background-color: #dcfce7;
            }

            .table .text-green-800 {
                color: #166534;
            }

            .table .text-xs {
                font-size: 8px;
            }

            .table .font-medium {
                font-weight: 500;
            }

            .table .px-2\.5 {
                padding-left: 10px;
                padding-right: 10px;
            }

            .table .py-0\.5 {
                padding-top: 2px;
                padding-bottom: 2px;
            }

            .table .rounded {
                border-radius: 4px;
            }

            .table .border-green-400 {
                border-color: #4ade80;
            }

            /* Handle winner row styling */
            .table .winner-row {
                background-color: #f0f9ff;
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

            .title-section {
                text-align: center;
                width: 100%;
                margin: 20px auto;
            }

            .signature {
                text-align: center;
                width: 100%;
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

            .right {
                float: right;
            }

            .signature {
                margin-top: 50px;
            }

            .powered-by {
                text-align: center;

                margin-bottom: 20px;
                font-size: 12px;
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

            .footer {
                margin-top: 20px;
                text-align: center;
                font-size: 10px;
            }
        </style>
    </head>

    <body>
        <div class="clearfix header">


            <div class="title">
                <h1>WESTERN LEYTE COLLEGE OF ORMOC</h1>
                <h3>A. Bonifacio St. Ormoc City</h3>
                <p><i>College of ICT and Engineering</i></p>
            </div>

        </div>

        <div class="title-section">
            <h3 class="title">{{ $title }}</h3>
        </div>

        <div class="w-full overflow-x-auto">
            <div class="min-w-full">
                {!! $tableContent !!}
            </div>
        </div>

        <div class="footer">
            <p>Generated on: {{ now()->format('F d, Y h:i A') }}</p>
        </div>

        <div class="signature">
            <div class="line"></div>
            <span class="signature-label">Chairman</span>
        </div>

        <div class="powered-by">
            <div>
                <span>Powered by</span> <strong>Event Master-Pro</strong>
            </div>

        </div>
    </body>

</html>
