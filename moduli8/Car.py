class Car:

    def __init__(self,name,color,year,gjendja,motor,doors):
        self.name = name
        self.color= color
        self.year= year
        self.gjendja= gjendja
        self.motor= motor
        self.doors= doors

    def start(self):
        print("kerri u nis!!")

    def drive(self):
        print(self.name , "eshte duke levizur")

    def stop(self):
        print("lerri eshte ndalur")

    def bbreak(self):
        print("kerri nuk eshte duke ndalur")

    def jepiGazz(self):
        print("kerri eshte duke rritur shpejtesin")





