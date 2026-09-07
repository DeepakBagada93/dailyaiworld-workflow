<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectTitle }}</title>
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
            padding: 30px 0 50px;
        }
        .main {
            background-color: #12121A;
            margin: 0 auto;
            width: 100%;
            max-width: 620px;
            border-spacing: 0;
            border-radius: 12px;
            border: 1px solid #1E1E2E;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #1E1B4B 0%, #0F172A 100%);
            padding: 32px 28px 24px;
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
            margin-bottom: 10px;
        }
        .brand-title {
            color: #FFFFFF;
            font-size: 22px;
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
            padding: 28px 28px 20px;
        }
        .greeting {
            font-size: 17px;
            font-weight: 700;
            color: #F8FAFC;
            margin-top: 0;
            margin-bottom: 8px;
        }
        .intro-text {
            color: #94A3B8;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .section-header {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #A78BFA;
            border-bottom: 1px solid #232336;
            padding-bottom: 8px;
            margin: 24px 0 16px;
        }
        .article-card {
            background-color: #161622;
            border: 1px solid #232336;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 14px;
        }
        .article-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 2px 8px;
            border-radius: 4px;
            margin-bottom: 8px;
        }
        .badge-workflow {
            background-color: rgba(59, 130, 246, 0.2);
            color: #93C5FD;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }
        .badge-mcp {
            background-color: rgba(16, 185, 129, 0.2);
            color: #6EE7B7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .badge-blog {
            background-color: rgba(245, 158, 11, 0.2);
            color: #FCD34D;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        .badge-news {
            background-color: rgba(239, 68, 68, 0.2);
            color: #FCA5A5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .article-title {
            font-size: 15px;
            font-weight: 700;
            color: #FFFFFF;
            margin: 0 0 6px;
            line-height: 1.4;
        }
        .article-title a {
            color: #FFFFFF;
            text-decoration: none;
        }
        .article-title a:hover {
            color: #A78BFA;
            text-decoration: underline;
        }
        .article-desc {
            font-size: 13px;
            color: #94A3B8;
            margin: 0 0 10px;
            line-height: 1.5;
        }
        .article-meta {
            font-size: 11px;
            color: #64748B;
        }
        .cta-container {
            text-align: center;
            margin: 32px 0 16px;
            padding-top: 12px;
            border-top: 1px solid #1E1E2E;
        }
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);
            color: #FFFFFF !important;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            padding: 13px 26px;
            border-radius: 8px;
            box-shadow: 0 4px 14px rgba(139, 92, 246, 0.35);
        }
        .footer {
            padding: 24px 28px 30px;
            background-color: #0E0E14;
            border-top: 1px solid #1A1A27;
            text-align: center;
        }
        .footer-text {
            color: #64748B;
            font-size: 11px;
            line-height: 1.6;
            margin: 0 0 8px;
        }
        .footer-links a {
            color: #8B5CF6;
            text-decoration: none;
            margin: 0 6px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" width="100%" cellpadding="0" cellspacing="0">
            <!-- Header -->
            <tr>
                <td class="header">
                    <span class="brand-badge">{{ $editionName }}</span>
                    <h1 class="brand-title">{{ $appName }}</h1>
                    <p class="brand-sub">{{ $issueDate }} &bull; Curated Intelligence & Breakthrough Dispatches</p>
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td class="content">
                    <h2 class="greeting">Hi there,</h2>
                    <p class="intro-text">
                        Here is your daily executive briefing featuring <strong>{{ count($articles) }} breakthrough dispatches</strong> published today across AI Workflows, Model Context Protocol tools, Engineering Blogs, and Breaking AI News.
                    </p>

                    <!-- Articles loop grouped -->
                    @foreach($articles as $art)
                    <div class="article-card">
                        @if($art['category_id'] == 1)
                            <span class="article-badge badge-workflow">⚙️ AI Workflow</span>
                        @elseif($art['category_id'] == 5)
                            <span class="article-badge badge-mcp">🔌 MCP Tool</span>
                        @elseif($art['category_id'] == 11)
                            <span class="article-badge badge-news">⚡ Breaking AI News</span>
                        @else
                            <span class="article-badge badge-blog">📝 Engineering Deep Dive</span>
                        @endif

                        <h3 class="article-title">
                            <a href="{{ $art['url'] }}" target="_blank">{{ $art['title'] }}</a>
                        </h3>
                        <p class="article-desc">{{ $art['deck'] }}</p>
                        <div class="article-meta">
                            ⏱️ {{ $art['reading_time'] }} min read &bull; <a href="{{ $art['url'] }}" style="color: #A78BFA; text-decoration: none; font-weight: 600;" target="_blank">Read Full Article &rarr;</a>
                        </div>
                    </div>
                    @endforeach

                    <div class="cta-container">
                        <a href="{{ $siteUrl }}" class="btn-primary" target="_blank">Explore Full Daily AI World Journal &rarr;</a>
                    </div>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="footer">
                    <p class="footer-text">
                        You received this daily dispatch because you are an active subscriber to <strong>{{ $appName }}</strong>.
                    </p>
                    <p class="footer-links">
                        <a href="{{ $siteUrl }}">Home</a> &bull;
                        <a href="{{ $siteUrl }}/workflow">Workflows</a> &bull;
                        <a href="{{ $siteUrl }}/mcp-directory">MCP Directory</a> &bull;
                        <a href="{{ $siteUrl }}/blogs">Blogs</a>
                    </p>
                    <p class="footer-text" style="margin-top: 10px; font-size: 10px;">
                        &copy; {{ date('Y') }} {{ $appName }}. All rights reserved. &bull; By Deepak Bagada, CEO at SaaSNext.
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
