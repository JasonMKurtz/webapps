class Hello
	def initialize(string) 
		@str = string
	end

	def Say
		puts @str
	end
end

H = Hello.new("blah blah")
H.Say
