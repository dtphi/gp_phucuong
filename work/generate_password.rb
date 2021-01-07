## ruby generate_password.rb {number}

number = ARGV[0].to_i
o = [('a'..'z'), ('0'..'9')].map { |i| i.to_a }.flatten

number.times do |n|
  puts string = (0...8).map { o[rand(o.length)] }.join
end