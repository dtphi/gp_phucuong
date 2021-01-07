# Create sales representatives data by php array format from tsv
# 社員番号	姓	名	セイ	メイ	電話番号	メインメールアドレス	サブメールアドレス1	サブメールアドレス2	サブメールアドレス3	サブメールアドレス4 パスワード
# command example: cat data/sales_representatives.tsv | ruby import_sales.rb > data/sales_output.txt
while line = gets.chomp do
  d = line.split "\t"
  puts "[#{d[0]}, '#{d[1]}', '#{d[2]}', '#{d[3]}', '#{d[4]}', '#{d[5]}', '#{d[6]}', '#{d[7]}', '#{d[8]}', '#{d[9]}', '#{d[10]}', '#{d[11]}'],"
end