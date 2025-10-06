<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Incident Report System</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #374151;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            padding: 32px 24px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        .content {
            padding: 32px 24px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
        }
        .message {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 24px;
            line-height: 1.7;
        }
        .button-container {
            text-align: center;
            margin: 32px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 12px 32px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
        }
        .button:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 8px -1px rgba(220, 38, 38, 0.4);
        }
        .features-box {
            background-color: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 6px;
            padding: 20px;
            margin: 24px 0;
        }
        .features-box .title {
            font-weight: 600;
            color: #0c4a6e;
            margin-bottom: 12px;
            font-size: 16px;
        }
        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .features-list li {
            color: #075985;
            font-size: 14px;
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }
        .features-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #0ea5e9;
            font-weight: bold;
        }
        .info-box {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            padding: 16px;
            margin: 24px 0;
        }
        .info-box .icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            background-color: #f59e0b;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
        }
        .info-box .text {
            color: #92400e;
            font-weight: 500;
            font-size: 14px;
        }
        .security-note {
            background-color: #f3f4f6;
            border-left: 4px solid #6b7280;
            padding: 16px;
            margin: 24px 0;
            border-radius: 0 6px 6px 0;
        }
        .security-note .title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .security-note .text {
            color: #6b7280;
            font-size: 14px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 24px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer .text {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
        }
        .footer .link {
            color: #dc2626;
            text-decoration: none;
        }
        .footer .link:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 24px 16px;
            }
            .header {
                padding: 24px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📧 Verify Your Email</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Hello {{ $user->name }}!</div>
            
            <div class="message">
                Thank you for registering with our Incident Report System! We're excited to have you join our community of safety-conscious citizens.
            </div>

            <div class="message">
                To complete your registration and start using all features, please verify your email address by clicking the button below.
            </div>

            <div class="button-container">
                <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
            </div>

            <div class="features-box">
                <div class="title">🚀 What you can do after verification:</div>
                <ul class="features-list">
                    <li>Report incidents and safety concerns</li>
                    <li>Add comments and share insights</li>
                    <li>Upvote and downvote community posts</li>
                    <li>Verify incidents reported by others</li>
                    <li>Upload photos and media</li>
                    <li>Receive location-based alerts</li>
                </ul>
            </div>

            <div class="info-box">
                <span class="icon">⏰</span>
                <span class="text">This verification link will expire in 24 hours for security reasons.</span>
            </div>

            <div class="security-note">
                <div class="title">🛡️ Security Information</div>
                <div class="text">
                    If you did not create an account with us, please ignore this email. 
                    For your security, never share this link with anyone.
                </div>
            </div>

            <div class="message">
                If you're having trouble clicking the button, you can copy and paste the following link into your browser:
            </div>
            
            <div style="background-color: #f3f4f6; padding: 12px; border-radius: 4px; word-break: break-all; font-family: monospace; font-size: 14px; color: #374151; margin: 16px 0;">
                <a href="{{ $verificationUrl }}" style="color: #dc2626; text-decoration: none;">{{ $verificationUrl }}</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="text">
                This email was sent from the Incident Report System.<br>
                If you have any questions, please contact our support team.
            </p>
        </div>
    </div>
</body>
</html>
