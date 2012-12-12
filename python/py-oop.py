#!/usr/bin/python
class Test: 
	def __init__(self,str): 
		self.str = str
	description = "OOP"
	author = "me"
	def getstr(self): 
		return self.str

T = Test("hrm")
print T.getstr()
