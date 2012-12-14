#!/usr/bin/python
class SimpleMath: 
        def __init__(self, num):
                self.num = num

        def squareroot(self):
                num = 0
                while num**2 < abs(self.num):
                    num = num + 1
                if num**2 == self.num:
                    if num < 0:
                        num = -num
                    print('The square root of ' + str(self.num) + ' is ' + str(num))
                else:
                    print(str(self.num) + ' is not a perfect square.')

x=int(raw_input('Enter a number: '))
SM = SimpleMath(x)
SM.squareroot()
