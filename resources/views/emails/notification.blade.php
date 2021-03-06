<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body style="padding:0; margin:0;font-family:Verdana,Arial;line-height:150%;">
<table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="5" style="background-color:#fafafa;padding-top:5px;border-bottom:1px solid #cfdad6;">
            <img height="40" src="{{ $site_url }}/images/{{ $config['logo'] }}" alt="{{ $config['logo'] }}" border="0" style="display: block; padding: 10px 0 13px 20px;" />
        </td>
    </tr>
    <tr>
        <td style="color: #484747; background: #FFF; text-align: left; padding: 20px 40px 30px;">
            <p>{!! $content !!}</p>

            @if (!empty($aLink))
                <p><a href="{{ $aLink }}">{{ (!empty($aText)) ? $aText : $aLink }}</a></p>
            @endif
        </td>
    </tr>
    <tr>
        <td style="background-color: #FFF; padding: 4px 0; vertical-align: middle;border-top:1px solid #cfdad6;">
            <p style="text-align: center; color: #349DC9; font-size: 11px; padding: 0; margin: 0;">&copy; {{ date('Y') }} &bull; <a href="{{ $site_url }}" style="color: #349DC9; text-decoration: none">{{ $config['company'] }}</a></p>
        </td>
    </tr>
</table>
</body>