<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Newsletter Subscriber Alert</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #0A0A0F;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #E2E8F0;
        }
        .wrapper {
            width: 100%;
            background-color: #0A0A0F;
            padding: 40px 0 60px;
        }
        .main {
            background-color: #12121A;
            margin: 0 auto;
            width: 100%;
            max-width: 580px;
            border-radius: 12px;
            border: 1px solid #1E1E2E;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #064E3B 0%, #0F172A 100%);
            padding: 28px 30px 24px;
            border-bottom: 1px solid #065F46;
        }
        .tag {
            display: inline-block;
            background-color: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #6EE7B7;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 3px 8px;
            border-radius: 6px;
            margin-bottom: 8px;
        }
        .title {
            color: #FFFFFF;
            font-size: 20px;
            font-weight: 800;
            margin: 0;
        }
        .content {
            padding: 28px 30px;
        }
        .info-card {
            background-color: #181824;
            border: 1px solid #28283C;
            border-radius: 8px;
            padding: 18px;
            margin: 18px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #222234;
            font-size: 13px;
        }
        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .info-label {
            color: #94A3B8;
            font-weight: 500;
        }
        .info-val {
            color: #F8FAFC;
            font-weight: 700;
            text-align: right;
        }
        .btn-admin {
            display: inline-block;
            background-color: #8B5CF6;
            color: #FFFFFF !important;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 6px;
            margin-top: 10px;
        }
        .footer {
            padding: 20px 30px;
            background-color: #0E0E14;
            border-top: 1px solid #1A1A27;
            text-align: center;
            font-size: 11px;
            color: #64748B;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="header">
                    <span class="tag">⚡ Growth Alert</span>
                    <h1 class="title">New Newsletter Subscriber!</h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <p style="color: #CBD5E1; font-size: 14px; margin-top: 0; line-height: 1.6;">
                        A new reader has subscribed to the <strong>{{ $appName }}</strong> briefing list.
                    </p>

                    <div class="info-card">
                        <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 13px; line-height: 2;">
                            <tr>
                                <td style="color: #94A3B8; padding: 6px 0; border-bottom: 1px solid #232336;">Subscriber Email:</td>
                                <td style="color: #60A5FA; font-weight: 700; text-align: right; padding: 6px 0; border-bottom: 1px solid #232336;">
                                    {{ $email }}
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #94A3B8; padding: 6px 0; border-bottom: 1px solid #232336;">Edition:</td>
                                <td style="color: #F8FAFC; font-weight: 600; text-align: right; padding: 6px 0; border-bottom: 1px solid #232336;">
                                    {{ $edition }}
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #94A3B8; padding: 6px 0; border-bottom: 1px solid #232336;">Subscribed At:</td>
                                <td style="color: #F8FAFC; text-align: right; padding: 6px 0; border-bottom: 1px solid #232336;">
                                    {{ $subscribedAt }}
                                </td>
                            </tr>
                            @if($totalSubscribers > 0)
                            <tr>
                                <td style="color: #94A3B8; padding: 6px 0;">Total Active Audience:</td>
                                <td style="color: #34D399; font-weight: 800; text-align: right; padding: 6px 0;">
                                    {{ number_format($totalSubscribers) }} subscribers
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    <div style="text-align: center; margin-top: 24px;">
                        <a href="{{ $siteUrl }}/cms/subscriptions" class="btn-admin" target="_blank">
                            Open CMS Subscriptions Dashboard &rarr;
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    Automated System Alert &bull; {{ $appName }} Executive Core
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
