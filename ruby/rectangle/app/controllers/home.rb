class Home < ApplicationController
	def main
		render :action => "home/index"
		render :action => "home/form"	
	end

	def form
	
	end
end
