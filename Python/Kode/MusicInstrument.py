from Item import Item

class MusicInstrument(Item):
    def __init__(self, id=0, price=0.0, stock=0,
                 playing_method="", condition="", weight=""):
        # memanggil constructor Item
        super().__init__(id, price, stock)
        self.playing_method = playing_method
        self.condition = condition
        self.weight = weight

    # getter and setter playingMethod
    def set_playing_method(self, playing_method):
        self.playing_method = playing_method

    def get_playing_method(self):
        return self.playing_method

    # getter and setter condition
    def set_condition(self, condition):
        self.condition = condition

    def get_condition(self):
        return self.condition

    # getter and setter weight
    def set_weight(self, weight):
        self.weight = weight

    def get_weight(self):
        return self.weight