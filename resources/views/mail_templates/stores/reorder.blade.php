{{ $data['store_name'] }}様({{ $data['store_code'] }})より発注依頼がありました。<br>
<br>
【発注内容】<br>
メーカー：{{ $data['manufacturer_name'] }}<br>
商品名：{{ $data['product_name'] }}<br>
型式：{{ $data['model'] }}<br>
ガス種：{{ $data['type'] }}<br>
納品場所：{{ $data['delivery'] }}<br>
数量：{{ $data['quantity'] }}<br>
<br>
【発注依頼先】<br>
担当者コード：{{ $data['sale_code'] }}<br>
氏名：{{ $data['sale_full_name'] }}<br>
メインメールアドレス：{{ $data['sale_email'] }}<br>
<br>
下記リンクから内容をご確認ください。<br>
<a href="{{ $data['message_url'] }}" target="_blank">{{ $data['message_url'] }}</a><br>
<br>
【発信元】<br>
Nittoh Mobile System<br>
日東エネルギー株式会社