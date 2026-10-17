<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <meta name="color-scheme" content="dark only">
    <meta name="supported-color-schemes" content="dark only">
    <title>{{ $subjectTitle ?? 'Daily AI World — Executive Briefing' }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        :root {
            color-scheme: dark only;
            supported-color-schemes: dark only;
        }
        html, body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background-color: #08090D !important;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #E2E8F0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
            border-collapse: collapse !important;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        a {
            text-decoration: none;
            color: #38BDF8;
        }
        a:hover {
            text-decoration: underline;
        }
        .wrapper {
            width: 100% !important;
            table-layout: fixed;
            background-color: #08090D;
            padding: 32px 0 48px;
        }
        .main {
            background-color: #0F1219 !important;
            margin: 0 auto;
            width: 100%;
            max-width: 620px;
            border-spacing: 0;
            border-radius: 12px;
            border: 1px solid #1E2433;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.45);
        }
        .header {
            background-color: #0F1219;
            padding: 32px 28px 24px;
            border-bottom: 1px solid #1E2433;
        }
        .brand-pill {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #10B981;
            background-color: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 12px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        }
        .logo-title {
            color: #FFFFFF;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.6px;
            margin: 0;
            line-height: 1.2;
        }
        .logo-sub {
            color: #94A3B8;
            font-size: 13px;
            margin: 6px 0 0;
            font-weight: 400;
        }
        .content {
            padding: 28px 28px 20px;
        }
        .hero-card {
            background-color: #141824;
            border: 1px solid #283046;
            border-radius: 10px;
            padding: 22px;
            margin-bottom: 24px;
        }
        .hero-tag {
            color: #F59E0B;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-family: ui-monospace, SFMono-Regular, monospace;
        }
        .hero-title {
            color: #FFFFFF;
            font-size: 19px;
            font-weight: 700;
            line-height: 1.35;
            margin: 8px 0 10px;
        }
        .hero-deck {
            color: #CBD5E1;
            font-size: 14px;
            line-height: 1.55;
            margin: 0 0 16px;
        }
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
            color: #FFFFFF !important;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 18px;
            border-radius: 6px;
            text-align: center;
            border: 1px solid #3B82F6;
        }
        .section-label {
            color: #64748B;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 16px;
            font-family: ui-monospace, SFMono-Regular, monospace;
        }
        .card {
            background-color: #121520;
            border: 1px solid #1E2433;
            border-radius: 8px;
            padding: 18px;
            margin-bottom: 14px;
        }
        .card:hover {
            border-color: #38BDF8;
        }
        .cat-pill {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 3px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 8px;
            font-family: ui-monospace, SFMono-Regular, monospace;
        }
        .cat-workflow { color: #A78BFA; background-color: rgba(167, 139, 250, 0.12); border: 1px solid rgba(167, 139, 250, 0.25); }
        .cat-mcp      { color: #34D399; background-color: rgba(52, 211, 153, 0.12); border: 1px solid rgba(52, 211, 153, 0.25); }
        .cat-coding   { color: #38BDF8; background-color: rgba(56, 189, 248, 0.12); border: 1px solid rgba(56, 189, 248, 0.25); }
        .cat-llm      { color: #F472B6; background-color: rgba(244, 114, 182, 0.12); border: 1px solid rgba(244, 114, 182, 0.25); }
        .cat-news     { color: #FBBF24; background-color: rgba(251, 191, 36, 0.12); border: 1px solid rgba(251, 191, 36, 0.25); }
        
        .read-time {
            color: #64748B;
            font-size: 11px;
            margin-left: 8px;
            font-family: ui-monospace, SFMono-Regular, monospace;
        }
        .card-title {
            color: #F1F5F9;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.4;
            margin: 0 0 8px;
        }
        .card-deck {
            color: #94A3B8;
            font-size: 13px;
            line-height: 1.5;
            margin: 0 0 12px;
        }
        .card-link {
            color: #38BDF8;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }
        .share-box {
            background: linear-gradient(180deg, #131722 0%, #0D1017 100%);
            border: 1px solid #232B3D;
            border-radius: 10px;
            padding: 22px;
            text-align: center;
            margin: 28px 0 16px;
        }
        .share-title {
            color: #FFFFFF;
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 6px;
        }
        .share-desc {
            color: #94A3B8;
            font-size: 13px;
            margin: 0 0 16px;
            line-height: 1.45;
        }
        .share-btn {
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 6px;
            margin: 0 4px;
        }
        .share-btn-x {
            background-color: #000000;
            color: #FFFFFF !important;
            border: 1px solid #334155;
        }
        .share-btn-li {
            background-color: #0A66C2;
            color: #FFFFFF !important;
            border: 1px solid #0A66C2;
        }
        .share-btn-fw {
            background-color: #1E293B;
            color: #E2E8F0 !important;
            border: 1px solid #334155;
        }
        .footer {
            background-color: #0A0C12;
            padding: 26px 28px;
            border-top: 1px solid #1E2433;
            text-align: center;
            color: #64748B;
            font-size: 12px;
            line-height: 1.6;
        }
        .footer a {
            color: #94A3B8;
        }
        .author-box {
            padding-top: 16px;
            border-top: 1px solid #1E2433;
            margin-top: 24px;
            color: #94A3B8;
            font-size: 13px;
            line-height: 1.5;
        }
        .author-name {
            color: #F8FAFC;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" role="presentation" cellpadding="0" cellspacing="0" width="100%">
            <!-- Header -->
            <tr>
                <td class="header">
                    <span class="brand-pill">⚡ Live Technical Dispatch</span>
                    <h1 class="logo-title">Daily AI World</h1>
                    <p class="logo-sub">{{ $editionName ?? 'Executive Briefing' }} · {{ $issueDate ?? date('F j, Y') }}</p>
                </td>
            </tr>

            <!-- Content Area -->
            <tr>
                <td class="content">
                    @if(!empty($articles))
                        @php
                            $hero = $articles[0];
                            $remaining = array_slice($articles, 1);
                        @endphp

                        <!-- Hero Feature Article -->
                        <div class="hero-card">
                            <span class="hero-tag">🔥 Featured Breakthrough</span>
                            <h2 class="hero-title">{{ $hero['title'] }}</h2>
                            <p class="hero-deck">{{ $hero['deck'] }}</p>
                            <a href="{{ $hero['url'] }}?utm_source=newsletter&utm_medium=email&utm_campaign=daily-dark" class="btn-primary" target="_blank">
                                Read Complete Implementation →
                            </a>
                        </div>

                        <!-- Secondary Dispatches -->
                        @if(count($remaining) > 0)
                            <div class="section-label">// Today's High-Signal Engineering Dispatches</div>

                            @foreach($remaining as $art)
                                @php
                                    $catId = (int)($art['category_id'] ?? 3);
                                    $catClass = match($catId) {
                                        1 => 'cat-workflow',
                                        5 => 'cat-mcp',
                                        3 => 'cat-coding',
                                        10 => 'cat-llm',
                                        default => 'cat-news'
                                    };
                                    $catName = match($catId) {
                                        1 => 'AI Workflow',
                                        5 => 'MCP Directory',
                                        3 => 'Coding Agents',
                                        10 => 'LLMs & Inference',
                                        default => 'AI News'
                                    };
                                @endphp
                                <div class="card">
                                    <span class="cat-pill {{ $catClass }}">{{ $catName }}</span>
                                    <span class="read-time">· {{ $art['reading_time'] ?? 7 }} min read</span>
                                    <h3 class="card-title">{{ $art['title'] }}</h3>
                                    <p class="card-deck">{{ $art['deck'] }}</p>
                                    <a href="{{ $art['url'] }}?utm_source=newsletter&utm_medium=email&utm_campaign=daily-dark" class="card-link" target="_blank">
                                        Inspect Architecture & Code →
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    @endif

                    <!-- Viral Growth & Referral Box -->
                    <div class="share-box">
                        <div class="share-title">Enjoying Daily AI World?</div>
                        <p class="share-desc">Forward this briefing to an engineer colleague or share it with your network to support zero-fluff AI engineering.</p>
                        <div>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode(($subjectTitle ?? 'Daily AI World Briefing') . ' - Read the dispatches here: https://dailyaiworld.com') }}" class="share-btn share-btn-x" target="_blank">
                                Post on X
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=https%3A%2F%2Fdailyaiworld.com" class="share-btn share-btn-li" target="_blank">
                                Share LinkedIn
                            </a>
                            <a href="mailto:?subject={{ urlencode('Check out today\'s Daily AI World dispatches') }}&body={{ urlencode('Here is today\'s technical briefing from Daily AI World: https://dailyaiworld.com') }}" class="share-btn share-btn-fw">
                                Forward Email
                            </a>
                        </div>
                    </div>

                    <!-- Author Note -->
                    <div class="author-box">
                        <span class="author-name">Curated by Deepak Bagada</span><br>
                        Founder & Editor-in-Chief at Daily AI World · CEO at SaaSNext<br>
                        <a href="https://x.com/deeepakbagada" target="_blank">@deeepakbagada</a> · <a href="https://deepakbagada.in" target="_blank">deepakbagada.in</a>
                    </div>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="footer">
                    <p style="margin: 0 0 10px;">
                        You received this email because you subscribed to <strong>Daily AI World</strong>.<br>
                        Zero synthetic AI fluff · 100% runnable multi-file code · Production war stories.
                    </p>
                    <p style="margin: 0;">
                        <a href="https://dailyaiworld.com" target="_blank">Visit Daily AI World</a> · 
                        <a href="https://dailyaiworld.com/workflows" target="_blank">Workflows</a> · 
                        <a href="https://dailyaiworld.com/mcp-directory" target="_blank">MCP Directory</a> · 
                        <a href="{{ $unsubscribeUrl ?? 'https://dailyaiworld.com/unsubscribe' }}">Unsubscribe</a>
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
