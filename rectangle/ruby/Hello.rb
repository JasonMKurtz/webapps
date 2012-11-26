class Hello 
	def initialize(str)
		@string = str; 
	end

	def say
		@string; 
	end
end

H = Hello.new("hi there"); 
puts H.say