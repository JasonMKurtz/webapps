class Calculations < ActiveRecord::Base
	def index
	end

	def handle
		# height = params[:height]
		height = 10
		
		# -width = params[:width]
		width = 10

		result = {
			area: height * width,
			diag: Math.sqrt(height*height + width*width)
		}

		respond_to do |format|
			format.json do
				render json: result
			end
		end
	end
end