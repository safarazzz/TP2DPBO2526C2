class Item:
    def __init__(self, id=0, price=0.0, stock=0):
        self.id = id
        self.price = price
        self.stock = stock

    # getter and setter id
    def set_id(self, id):
        self.id = id

    def get_id(self):
        return self.id

    # getter and setter price
    def set_price(self, price):
        self.price = price

    def get_price(self):
        return self.price

    # getter and setter stock
    def set_stock(self, stock):
        self.stock = stock

    def get_stock(self):
        return self.stock