class Rectcalc < ActiveRecord::Base
	def initialize 
		Rect = Rectangle.new(params[:width], params[:height])
	end

	def Calc
		Rect
	end
end
