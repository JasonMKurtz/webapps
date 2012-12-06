class Rectangle
	def initialize(w, h)
		@width = w
		@height = h 
	end

	def Area
		@width * @height
	end

	def Diagonal
		a = @width * @width
		b = @height * @height
		c = a + b
	
		Math.sqrt(c)
	end
end
