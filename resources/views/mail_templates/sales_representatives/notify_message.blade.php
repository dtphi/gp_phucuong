{{ $data['full_name'] }}さんからメッセージが転送されました。<br>
<br>
【メッセージ転送元】<br>
担当者コード：{{ $data['employee_number'] }}<br>
氏名：{{ $data['full_name'] }}<br>
メインメールアドレス：{{ $data['main_email'] }}<br>
販売店コード：{{ $data['code'] }}<br>
販売店：{{ $data['name'] }}様<br>
<br>
【メッセージ内容】<br>
送信元：@if($data['sender_type'] == 1) {{ $data['name'] }}様 @else {{ $data['full_name'] }} @endif<br>
@if(isset($data['file']))
  {{ $data['file'] }}<br>
  <br>
  [ファイルが添付されています]<br>
@else
  @if($data['contents'] != '')
    {!! nl2br(e($data['contents'])) !!}<br>
  @endif
  @if($data['contents'] != '' && isset($data['images']))
    <br>
  @endif
  @if(isset($data['images']))
    [画像が添付されています]<br>
  @endif
@endif
<br>
下記リンクから内容をご確認ください。<br>
<a href="{{ $data['url'] }}" target="_blank">{{ $data['url'] }}</a><br>
<br>
【発信元】<br>
Nittoh Mobile System<br>
日東エネルギー株式会社