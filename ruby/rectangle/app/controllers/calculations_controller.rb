class CalculationsController < ActionController::Base
	def calculate
		height = params[:height].to_i
		width = params[:width].to_i

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