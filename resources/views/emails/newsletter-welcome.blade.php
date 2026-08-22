<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ $appName }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #0A0A0F;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #E2E8F0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #0A0A0F;
            padding: 40px 0 60px;
        }
        .main {
            background-color: #12121A;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            border-radius: 12px;
            border: 1px solid #1E1E2E;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #1E1B4B 0%, #0F172A 100%);
            padding: 36px 32px 28px;
            text-align: left;
            border-bottom: 1px solid #2E285C;
        }
        .brand-badge {
            display: inline-block;
            background-color: rgba(139, 92, 246, 0.2);
            border: 1px solid rgba(139, 92, 246, 0.4);
            color: #C4B5FD;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 4px 10px;
            border-radius: 9999px;
            margin-bottom: 12px;
        }
        .brand-title {
            color: #FFFFFF;
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 4px;
            letter-spacing: -0.5px;
        }
        .brand-sub {
            color: #94A3B8;
            font-size: 13px;
            margin: 0;
        }
        .content {
            padding: 32px 32px 24px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 700;
            color: #F8FAFC;
            margin-top: 0;
            margin-bottom: 14px;
        }
        .text {
            color: #CBD5E1;
            font-size: 15px;
            line-height: 1.65;
            margin-bottom: 20px;
        }
        .edition-box {
            background-color: #1A1A27;
            border-left: 4px solid #8B5CF6;
            border-radius: 6px;
            padding: 14px 18px;
            margin-bottom: 24px;
        }
        .edition-label {
            font-size: 11px;
            color: #A78BFA;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }
        .edition-value {
            font-size: 15px;
            font-weight: 600;
            color: #FFFFFF;
            margin-top: 2px;
        }
        .features-grid {
            margin: 24px 0;
        }
        .feature-card {
            background-color: #161622;
            border: 1px solid #232336;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
        }
        .feature-title {
            font-size: 14px;
            font-weight: 700;
            color: #FFFFFF;
            margin: 0 0 4px;
            display: flex;
            align-items: center;
        }
        .feature-desc {
            font-size: 13px;
            color: #94A3B8;
            margin: 0;
            line-height: 1.5;
        }
        .cta-container {
            text-align: center;
            margin: 32px 0 16px;
        }
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);
            color: #FFFFFF !important;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            box-shadow: 0 4px 14px rgba(139, 92, 246, 0.35);
        }
        .btn-secondary {
            display: inline-block;
            background-color: #1E1E2E;
            color: #C4B5FD !important;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            margin: 6px 4px;
            border: 1px solid #2D2D42;
        }
        .footer {
            padding: 24px 32px 32px;
            background-color: #0E0E14;
            border-top: 1px solid #1A1A27;
            text-align: center;
        }
        .footer-text {
            color: #64748B;
            font-size: 12px;
            line-height: 1.6;
            margin: 0 0 10px;
        }
        .footer-links a {
            color: #8B5CF6;
            text-decoration: none;
            margin: 0 8px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" width="100%" cellpadding="0" cellspacing="0">
            <!-- Header -->
            <tr>
                <td class="header">
                    <span class="brand-badge">Official Confirmation</span>
                    <h1 class="brand-title">{{ $appName }}</h1>
                    <p class="brand-sub">The Premier Journal of Artificial Intelligence & Compute Infrastructure</p>
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td class="content">
                    <h2 class="greeting">You're on the list! 🎉</h2>
                    <p class="text">
                        Welcome to <strong>{{ $appName }}</strong>. You have officially subscribed to our curated executive intelligence network.
                    </p>

                    <div class="edition-box">
                        <div class="edition-label">Active Subscription</div>
                        <div class="edition-value">{{ $edition }}</div>
                        <div style="font-size: 12px; color: #94A3B8; margin-top: 4px;">Delivered directly to: <strong>{{ $email }}</strong></div>
                    </div>

                    <p class="text">
                        Every day, we cut through the noise to deliver the essential breakthroughs shaping the future of AI engineering, models, and workflows.
                    </p>

                    <div class="features-grid">
                        <div class="feature-card">
                            <h3 class="feature-title">⚡ High-Impact AI News</h3>
                            <p class="feature-desc">Concise, verified dispatches on frontier models, GPU clusters, and enterprise deployments.</p>
                        </div>
                        <div class="feature-card">
                            <h3 class="feature-title">🛠️ Step-by-Step AI Workflows</h3>
                            <p class="feature-desc">Actionable guides to automating business pipelines, agentic orchestration, and LLM integrations.</p>
                        </div>
                        <div class="feature-card">
                            <h3 class="feature-title">🔌 Curated MCP Directory</h3>
                            <p class="feature-desc">The definitive open directory of Model Context Protocol servers for Claude, Cursor, and agent runtimes.</p>
                        </div>
                    </div>

                    <div class="cta-container">
                        <a href="{{ $siteUrl }}" class="btn-primary" target="_blank">Explore Latest Articles &rarr;</a>
                        <div style="margin-top: 14px;">
                            <a href="{{ $siteUrl }}/workflows" class="btn-secondary" target="_blank">Workflows</a>
                            <a href="{{ $siteUrl }}/mcp-directory" class="btn-secondary" target="_blank">MCP Directory</a>
                            <a href="{{ $siteUrl }}/latest-ai-news" class="btn-secondary" target="_blank">Latest AI News</a>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="footer">
                    <p class="footer-text">
                        You received this email because you subscribed to updates at <strong>{{ $siteUrl }}</strong>.
                    </p>
                    <p class="footer-links">
                        <a href="{{ $siteUrl }}">Home</a> &bull;
                        <a href="{{ $siteUrl }}/subscribe">Manage Subscription</a> &bull;
                        <a href="mailto:{{ config('mail.from.address') }}">Contact Support</a>
                    </p>
                    <p class="footer-text" style="margin-top: 12px; font-size: 11px;">
                        &copy; {{ date('Y') }} {{ $appName }}. All rights reserved.
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
