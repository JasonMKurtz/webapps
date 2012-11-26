class Rectangle
	def initialize(w, h) 
		@width = w
		@height = h 
	end

	def CalcArea 
		@width * @height;
	end

	def CalcDiagonal
		a = @width * @width 
		b = @height * @height 
		c = a + b

		Math.sqrt(c) # returns the square root, despite having no "return" statement
	end	
end
