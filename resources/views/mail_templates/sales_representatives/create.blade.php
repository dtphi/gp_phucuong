下記ユーザーのNiMoアカウントが新規登録されました。<br>
<br>
担当者コード：{{ $data['employee_number'] }}<br>
氏名：{{ $data['full_name'] }}<br>
メインメールアドレス：{{ $data['main_email'] }}<br>
仮パスワード：{{ $data['password'] }}<br>
<br>
下記リンクから仮パスワードでログインし、パスワード変更画面でパスワードの変更を行ってください。<br>
<a href="{{ $data['url'] }}" target="_blank">{{ $data['url'] }}</a><br>
<br>
【発信元】<br>
Nittoh Mobile System<br>
日東エネルギー株式会社