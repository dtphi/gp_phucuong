# Create store data by php array format from tsv

# command example: cat data/order_histories.tsv | ruby import_order_histories.rb > data/order_histories_output.txt
while line = gets.chomp do
  d = line.split "\t"
  puts "[#{d[0]}, '#{d[1]}', '#{d[2]}', '#{d[3]}', '#{d[4]}', '#{d[5]}', #{d[6]}, #{d[7]}],"
end