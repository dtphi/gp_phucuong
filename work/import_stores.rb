# Create store data by php array format from tsv

# command example: cat data/stores_xxxx.tsv | ruby import_stores.rb > data/stores_chuou_output.txt
while line = gets.chomp do
    d = line.split "\t"
    puts "[#{d[0]}, '#{d[1]}', '#{d[2]}', '#{d[3]}', '#{d[4]}', '#{d[5]}', '#{d[6]}', '#{d[7]}', '#{d[8]}', '#{d[9]}', '#{d[10]}', '#{d[11]}', '#{d[12]}', '#{d[13]}', '#{d[14]}', '#{d[15]}'],"
  end