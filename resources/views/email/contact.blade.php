<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ Mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 10px;
            font-size: 24px;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .contact-info {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            background-color: #fafafa;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .contact-info h3,
        .contact-info h4 {
            color: #333;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #aaa;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer .disclaimer {
            font-size: 12px;
            color: #bbb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thông Tin Liên Hệ</h2>
        <p>Xin chào, bạn có một yêu cầu liên hệ mới với nội dung như sau:</p>

        <div class="contact-info">
            <h3>Liên hệ từ: <span style="color: #4CAF50;">{{ $name }}</span></h3>
            <h4>Email liên hệ: <span style="color: #4CAF50;">{{ $email }}</span></h4>
        </div>

        <div class="contact-info">
            <p><strong>Nội dung liên hệ:</strong></p>
            <p>{{ $body }}</p>
            
        </div>
        <div class="contact-info" style="text-align: center">
            <p><strong>Chúng tôi sẽ liên hệ và thông báo mới đến quý khách</strong></p>
        
        <footer class="footer">
            <p>Trân trọng,<br>Đội ngũ hỗ trợ StayNest</p>
            <p class="disclaimer">Đây là email tự động. Vui lòng không trả lời trực tiếp email này.</p>
        </footer>
    </div>
</body>
</html>
