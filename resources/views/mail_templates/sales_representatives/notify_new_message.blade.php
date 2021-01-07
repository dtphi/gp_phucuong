{{ $data['name'] }}様({{ $data['code'] }})より新着メッセージを受信しました。<br>
<br>
【メッセージ受信先】<br>
担当者コード：{{ $data['employee_number'] }}<br>
氏名：{{ $data['full_name'] }}<br>
メインメールアドレス：{{ $data['main_email'] }}<br>
<br>
下記リンクから内容をご確認ください。<br>
<a href="{{ $data['url'] }}" target="_blank">{{ $data['url'] }}</a><br>
<br>
【発信元】<br>
Nittoh Mobile System<br>
日東エネルギー株式会社