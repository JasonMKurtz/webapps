class FormHandle < ActiveRecord::Base
	def index
	end

	def handle 
		if params[:width].blank? or params[:height].blank?
			end

		@R = Rectangle.new(params[:width], params[:height])
		@calc = [@R.Area, @R.Diagonal]
		respond_to do |format|
			format.json{
				render :json => @calc.to_json
			}
		end
	end
end