@php
    $appName = config('app.name', 'NoteNest');
    $permissionLabel = ($permission ?? 'read') === 'edit' ? 'Can edit' : 'Read only';
    $preview = \Illuminate\Support\Str::limit(strip_tags($note->content ?? ''), 500);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appName }} - Shared Note</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef3f8;
            margin: 0;
            padding: 0;
            color: #1f2937;
        }

        .container {
            max-width: 640px;
            margin: 32px auto;
            background: #ffffff;
            border: 1px solid #d9e2ec;
        }

        .header {
            background: #1f5fbf;
            color: #ffffff;
            padding: 28px 32px;
        }

        .brand {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: .08em;
            text-transform: uppercase;
            opacity: .88;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            line-height: 1.3;
        }

        .content {
            padding: 32px;
        }

        .content p {
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 16px;
        }

        .note-box {
            border: 1px solid #d9e2ec;
            background: #f8fafc;
            padding: 20px;
            margin-top: 22px;
        }

        .label {
            font-size: 12px;
            font-weight: bold;
            color: #64748b;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .value {
            font-size: 16px;
            margin-bottom: 18px;
        }

        .badge {
            display: inline-block;
            background: #e8f1ff;
            color: #1f5fbf;
            border: 1px solid #bfd6ff;
            padding: 6px 10px;
            font-size: 13px;
            font-weight: bold;
        }

        .preview {
            background: #ffffff;
            border-left: 4px solid #1f5fbf;
            padding: 14px 16px;
            white-space: pre-wrap;
            word-break: break-word;
            line-height: 1.5;
            color: #334155;
        }

        .button-wrapper {
            margin-top: 30px;
            text-align: center;
        }

        .button {
            display: inline-block;
            background: #1f5fbf;
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 24px;
            font-weight: bold;
        }

        .hint {
            color: #64748b;
            font-size: 13px;
            margin-top: 18px;
            text-align: center;
        }

        .footer {
            padding: 22px 28px;
            text-align: center;
            background: #f8fafc;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="brand">{{ $appName }}</div>
        <h1>A note has been shared with you</h1>
    </div>

    <div class="content">
        <p>Hello,</p>
        <p><strong>{{ $senderName }}</strong> shared a note with you on {{ $appName }}.</p>

        <div class="note-box">
            <div class="label">Note title</div>
            <div class="value"><strong>{{ $note->title }}</strong></div>

            <div class="label">Permission</div>
            <div class="value"><span class="badge">{{ $permissionLabel }}</span></div>

            <div class="label">Preview</div>
            <div class="preview">{{ $preview !== '' ? $preview : 'This note has no preview content.' }}</div>
        </div>

        <div class="button-wrapper">
            <a href="{{ $noteUrl }}" class="button">Open note</a>
        </div>

        <p class="hint">You need to sign in with the email that received this invitation.</p>
    </div>

    <div class="footer">
        {{ $appName }}<br>
        This is an automated email. Please do not reply to this message.
    </div>
</div>
</body>
</html>