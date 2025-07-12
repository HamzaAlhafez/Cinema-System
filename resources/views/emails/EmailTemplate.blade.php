
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Cinema Show</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .offer-details {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .offer-details h2 {
            color: #6a11cb;
            margin-top: 0;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        .detail-value {
            flex: 1;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f5f5f5;
            color: #777;
            font-size: 14px;
        }
        .logo {
            font-weight: bold;
            color: #6a11cb;
            font-size: 18px;
            margin-bottom: 10px;
            display: block;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Cinema Show</h1>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            <p>We're excited to inform you about a new cinema offer at our theaters. Here are the details:</p>
            
            <div class="offer-details">
                <h2>Offer Details</h2>
                
                <div class="detail-row">
                    <span class="detail-label">Movie Title:</span>
                    <span class="detail-value">
                        {{ $Show->movie->title ?? 'Not specified' }}
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Hall:</span>
                    <span class="detail-value">
                        {{ $Show->hall->hall_name ?? 'Not specified' }}
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ $Show->date->format('d M Y')  }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Price:</span>
                    <span class="detail-value">{{ $Show->price }} $</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Start Time:</span>
                    <span class="detail-value">{{\carbon\carbon::parse($Show->start_time)->format('H:i')}}</span>
                </div>


<div class="detail-row">
                    <span class="detail-label">End Time:</span>
                    <span class="detail-value">{{\carbon\carbon::parse($Show->end_time)->format('H:i')}}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Available Seats:</span>
                    <span class="detail-value">{{ $Show->remaining_seats }}</span>
                </div>
            </div>
            
            <p>We wish you an enjoyable viewing experience!</p>
            
            <a href="{{ route('showsmoive.show', $Show->id) }}" class="btn">Book Your Ticket Now</a>
        </div>
        
        <div class="footer">
            <span class="logo">{{ config('app.name') }}</span>
            <p>This message was automatically sent by the {{ config('app.name') }} system. Please do not reply.</p>
            <p>© {{ date('Y') }} All rights reserved</p>
        </div>
    </div>
</body>
</html>