class CalculationsController < ActiveRecord::Base
	def index
	end

	def handle
		"hello"
	end

	def handle2 
		if params[:width].blank? or params[:height].blank?
			end

		@R = Rectangle.new(params[:width], params[:height])

		@R.Area
	end
end